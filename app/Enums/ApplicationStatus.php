<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case ToSend = 'to_send';
    case Sent = 'sent';
    case Interview = 'interview';
    case Accepted = 'accepted';
    case Rejected = 'rejected';

    /** Nederlandse tekst om in de app te tonen. */
    public function label(): string
    {
        return match ($this) {
            self::ToSend => 'Te versturen',
            self::Sent => 'Verstuurd',
            self::Interview => 'Gesprek',
            self::Accepted => 'Aangenomen',
            self::Rejected => 'Afgewezen',
        };
    }

    /** Tailwind-klassen voor het gekleurde label (kleuren uit Figma). */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::ToSend => 'bg-st-to-send-soft text-st-to-send',
            self::Sent => 'bg-st-sent-soft text-st-sent',
            self::Interview => 'bg-st-interview-soft text-st-interview',
            self::Accepted => 'bg-st-accepted-soft text-st-accepted',
            self::Rejected => 'bg-st-rejected-soft text-st-rejected',
        };
    }

    /** Klasse voor het gekleurde bolletje. */
    public function dotClass(): string
    {
        return match ($this) {
            self::ToSend => 'bg-st-to-send',
            self::Sent => 'bg-st-sent',
            self::Interview => 'bg-st-interview',
            self::Accepted => 'bg-st-accepted',
            self::Rejected => 'bg-st-rejected',
        };
    }

    /** Klassen voor de actieve knop in de statuskiezer. */
    public function activeClasses(): string
    {
        return match ($this) {
            self::ToSend => 'border-st-to-send bg-st-to-send-soft text-st-to-send',
            self::Sent => 'border-st-sent bg-st-sent-soft text-st-sent',
            self::Interview => 'border-st-interview bg-st-interview-soft text-st-interview',
            self::Accepted => 'border-st-accepted bg-st-accepted-soft text-st-accepted',
            self::Rejected => 'border-st-rejected bg-st-rejected-soft text-st-rejected',
        };
    }

    /** Telt deze status als "verstuurd"? */
    public function isSent(): bool
    {
        return $this !== self::ToSend;
    }

    /** Praktische tip die past bij de status. */
    public function tip(): string
    {
        return match ($this) {
            self::ToSend => 'Noem in je motivatie iets specifieks uit hun bio. Zo zien ze dat je echt naar hén hebt gekeken.',
            self::Sent => 'Na een week nog niets gehoord? Stuur een korte, vriendelijke mail of bel even.',
            self::Interview => 'Stuur binnen 24 uur na je gesprek een korte bedankmail. Noem iets specifieks waar jullie over praatten.',
            self::Accepted => 'Gefeliciteerd! Laat de andere bedrijven netjes weten dat je een plek hebt gevonden.',
            self::Rejected => 'Vraag om feedback: wat kon beter? Dat helpt je bij je volgende sollicitatie.',
        };
    }
}
