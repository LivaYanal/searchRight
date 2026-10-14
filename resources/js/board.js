/**
 * Kanban-bord: sleep een kaart naar een andere kolom.
 * De status wordt meteen opgeslagen via PATCH /companies/{id}/status.
 * Gaat het mis? Dan gaat de kaart terug naar waar hij was.
 */
const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

function showToast(message) {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = message;
    toast.classList.remove('opacity-0');
    clearTimeout(showToast.timer);
    showToast.timer = setTimeout(() => toast.classList.add('opacity-0'), 2500);
}

function updateCounts(board) {
    board.querySelectorAll('[data-column]').forEach((column) => {
        const count = column.querySelectorAll('[data-card]').length;
        column.querySelector('[data-count]').textContent = count;
        column.querySelector('[data-empty]')?.classList.toggle('hidden', count > 0);
    });
}

document.querySelectorAll('[data-board]').forEach((board) => {
    let dragged = null;
    let fromList = null;
    let fromNext = null;

    board.addEventListener('dragstart', (event) => {
        const card = event.target.closest?.('[data-card]');
        if (!card) return;
        dragged = card;
        fromList = card.parentElement;
        fromNext = card.nextElementSibling;
        event.dataTransfer.effectAllowed = 'move';
        event.dataTransfer.setData('text/plain', card.dataset.card);
        requestAnimationFrame(() => card.classList.add('is-dragging'));
    });

    board.addEventListener('dragend', () => {
        dragged?.classList.remove('is-dragging');
        board.querySelectorAll('.is-over').forEach((el) => el.classList.remove('is-over'));
        dragged = null;
    });

    board.querySelectorAll('[data-column]').forEach((column) => {
        const list = column.querySelector('[data-list]');

        column.addEventListener('dragover', (event) => {
            if (!dragged) return;
            event.preventDefault();
            column.classList.add('is-over');
        });

        column.addEventListener('dragleave', (event) => {
            if (!column.contains(event.relatedTarget)) column.classList.remove('is-over');
        });

        column.addEventListener('drop', async (event) => {
            event.preventDefault();
            column.classList.remove('is-over');
            if (!dragged || list === fromList) return;

            const card = dragged;
            const previousList = fromList;
            const previousNext = fromNext;

            list.prepend(card);
            updateCounts(board);

            let data;
            try {
                const response = await fetch(card.dataset.statusUrl, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: JSON.stringify({ status: column.dataset.column }),
                });

                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                data = await response.json();
            } catch (error) {
                // Opslaan mislukt: kaart terug naar waar hij was
                console.error('Status opslaan mislukt:', error);
                previousList.insertBefore(card, previousNext);
                updateCounts(board);
                showToast('Opslaan is mislukt. Probeer het opnieuw.');
                return;
            }

            // Opgeslagen! Werk het label en de opvolgtekst op de kaart bij.
            const badge = card.querySelector('[data-badge]');
            if (badge && data.badge) badge.outerHTML = data.badge;
            const followUp = card.querySelector('[data-follow-up]');
            if (followUp) followUp.textContent = data.follow_up;
            card.classList.toggle('opacity-60', data.status === 'rejected');

            // Cijfers bovenaan vernieuwen
            const stats = document.querySelector('[data-stats]');
            if (stats && data.stats) stats.outerHTML = data.stats;

            showToast(`Opgeslagen: ${data.label}`);
        });
    });
});

/** Tekenteller onder tekstvelden: <input data-counter="id-van-teller"> */
document.querySelectorAll('[data-counter]').forEach((input) => {
    const counter = document.getElementById(input.dataset.counter);
    const update = () => (counter.textContent = `${input.value.length} / ${input.maxLength}`);
    input.addEventListener('input', update);
    update();
});
