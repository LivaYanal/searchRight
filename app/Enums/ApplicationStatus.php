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

    /** Tailwind-klassen voor het gekleurde label. */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::ToSend => 'bg-stone-100 text-stone-700 ring-stone-300',
            self::Sent => 'bg-sky-50 text-sky-800 ring-sky-200',
            self::Interview => 'bg-amber-50 text-amber-800 ring-amber-200',
            self::Accepted => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
            self::Rejected => 'bg-rose-50 text-rose-800 ring-rose-200',
        };
    }
}
