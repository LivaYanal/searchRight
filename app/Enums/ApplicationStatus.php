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
}
