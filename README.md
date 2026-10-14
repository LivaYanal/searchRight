# searchRight

**Houd je stagezoektocht overzichtelijk.** searchRight is een web app waarmee je bijhoudt welke bedrijven je hebt benaderd (bijvoorbeeld via [stagemarkt.nl](https://stagemarkt.nl)), wat de status van elke sollicitatie is en wanneer je moet opvolgen.

Ik bouw dit project tijdens mijn opleiding Software Developer (niveau 4), terwijl ik zelf een stage zoek. Ik gebruik de app dus zelf.

> 🚧 In ontwikkeling: zie de roadmap hieronder.

## Functies (gepland)

- [ ] Account aanmaken en inloggen
- [ ] Bedrijven toevoegen (naam, plaats, website, contactpersoon)
- [ ] Sollicitaties bijhouden met status: *te versturen → verstuurd → gesprek → aangenomen / afgewezen*
- [ ] Notities en opvolgdatum per sollicitatie
- [ ] Dashboard met overzicht en statistieken
- [ ] Zoeken en filteren
- [ ] Tests voor de belangrijkste onderdelen

## Techniek

| Onderdeel  | Gebruikt                    |
|------------|-----------------------------|
| Backend    | PHP 8.3, Laravel 13         |
| Frontend   | Blade, Tailwind CSS, Vite   |
| Database   | MySQL 8.4                   |
| Omgeving   | Docker (Nginx, PHP-FPM, MySQL, Node) |

## Lokaal draaien

Je hebt alleen [Docker Desktop](https://www.docker.com/products/docker-desktop/) nodig.

```bash
git clone https://github.com/LivaYanal/searchRight.git
cd searchRight
docker compose up -d
```

De eerste keer duurt dit een paar minuten (packages worden geïnstalleerd). Open daarna **http://localhost:8088**.

Handige commando's:

```bash
docker compose exec app php artisan migrate   # database bijwerken
docker compose exec app php artisan test      # tests draaien
docker compose logs -f app                    # logs bekijken
docker compose down                           # alles stoppen
```

## Over mij

Livanur Yanalioglu, student Software Developer, **op zoek naar een stage vanaf 25 januari**.
[LinkedIn](https://www.linkedin.com/in/livanur-yanalioglu-28001832a/)
