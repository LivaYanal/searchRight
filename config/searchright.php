<?php

return [
    // Startdatum van je stage, voor de aftelteller in de zijbalk
    'internship_start' => env('INTERNSHIP_START', '2027-01-25'),

    // Demo-modus: toont de inloggegevens van het demo-account op de inlogpagina
    'demo' => (bool) env('SEARCHRIGHT_DEMO', false),
    'demo_email' => 'demo@searchright.app',
    'demo_password' => 'demo1234',
];
