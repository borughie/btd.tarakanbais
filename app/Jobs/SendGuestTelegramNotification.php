<?php

namespace App\Jobs;

use App\Models\Guest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendGuestTelegramNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        public Guest $guest,
    ) {}

    public function handle(): void
    {
        $token = config('services.telegram.bot_token');
        $chatIds = config('services.telegram.chat_ids', []);

        if (! $token || empty($chatIds)) {
            Log::warning('Telegram bot token or chat IDs not configured');

            return;
        }

        $message = "📋 *Tamu Baru*\n"
            ."Instansi: {$this->guest->instansi}\n"
            ."Tujuan: {$this->guest->tujuan}\n"
            ."Jumlah Personil: {$this->guest->jumlah_personil}\n"
            ."Waktu: {$this->guest->created_at->format('d/m/Y H:i')}";

        foreach ($chatIds as $chatId) {
            Http::timeout(10)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => trim($chatId),
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);
        }

        $this->guest->update(['notified' => true]);
    }

    public function failed(?\Throwable $exception): void
    {
        Log::error('Failed to send Telegram notification', [
            'guest_id' => $this->guest->id,
            'error' => $exception?->getMessage(),
        ]);
    }
}
