// Licht/donker wisselen, met een cirkel-animatie vanuit de knop
const root = document.documentElement;

function apply(theme) {
    root.dataset.theme = theme;
    try {
        localStorage.setItem('theme', theme);
    } catch (e) {
        // privévenster: dan onthouden we het gewoon niet
    }
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.setAttribute('aria-pressed', String(theme === 'dark'));
    });
}

function toggle(event) {
    const next = root.dataset.theme === 'dark' ? 'light' : 'dark';
    const reduceMotion = matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!document.startViewTransition || reduceMotion) {
        apply(next);
        return;
    }

    const rect = event.currentTarget.getBoundingClientRect();
    const x = rect.left + rect.width / 2;
    const y = rect.top + rect.height / 2;
    const radius = Math.hypot(Math.max(x, innerWidth - x), Math.max(y, innerHeight - y));

    root.style.setProperty('--theme-x', `${x}px`);
    root.style.setProperty('--theme-y', `${y}px`);
    root.style.setProperty('--theme-r', `${radius}px`);

    document.startViewTransition(() => apply(next));
}

document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.setAttribute('aria-pressed', String(root.dataset.theme === 'dark'));
    button.addEventListener('click', toggle);
});

// Volg het systeem zolang er nog niets gekozen is
matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
    let saved = null;
    try {
        saved = localStorage.getItem('theme');
    } catch (e) {}
    if (!saved) root.dataset.theme = event.matches ? 'dark' : 'light';
});
