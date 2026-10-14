<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Database\Factories\ApplicationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['status', 'sent_at', 'follow_up_at', 'notes'])]
class Application extends Model
{
    /** @use HasFactory<ApplicationFactory> */
    use HasFactory;

    protected $attributes = [
        'status' => 'to_send',
    ];

    protected function casts(): array
    {
        return [
            'status' => ApplicationStatus::class,
            'sent_at' => 'date',
            'follow_up_at' => 'date',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Zet een nieuwe status. Gaat hij van "te versturen" naar iets anders
     * en is er nog geen verstuurdatum? Dan vullen we vandaag in.
     */
    public function changeStatus(ApplicationStatus $status): void
    {
        $this->status = $status;

        if ($status->isSent() && $this->sent_at === null) {
            $this->sent_at = today();
        }

        $this->save();
    }

    /** Korte regel onderaan een kaart, bijv. "↻ Opvolgen 21 okt". */
    public function followUpLabel(): string
    {
        return match (true) {
            $this->status === ApplicationStatus::ToSend => '＋ Brief schrijven',
            $this->status === ApplicationStatus::Accepted => '🎉 Stageplek!',
            $this->follow_up_at !== null => '↻ Opvolgen '.$this->follow_up_at->translatedFormat('j M'),
            $this->sent_at !== null => 'Verstuurd '.$this->sent_at->translatedFormat('j M'),
            default => '—',
        };
    }
}
