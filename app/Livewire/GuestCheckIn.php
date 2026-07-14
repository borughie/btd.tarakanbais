<?php

namespace App\Livewire;

use App\Jobs\SendGuestTelegramNotification;
use App\Models\Guest;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class GuestCheckIn extends Component
{
    public string $instansi = '';

    public string $tujuan = '';

    public int $jumlah_personil = 1;

    public ?string $nama_pic = null;

    public ?string $no_hp = null;

    public bool $submitted = false;

    protected function rules(): array
    {
        return [
            'instansi' => 'required|string|max:255',
            'tujuan' => 'required|string|max:500',
            'jumlah_personil' => 'nullable|integer|min:1|max:100',
            'nama_pic' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $guest = Guest::create([
            'instansi' => $this->instansi,
            'tujuan' => $this->tujuan,
            'jumlah_personil' => $this->jumlah_personil,
            'nama_pic' => $this->nama_pic,
            'no_hp' => $this->no_hp,
        ]);

        try {
            SendGuestTelegramNotification::dispatchSync($guest);
        } catch (\Throwable $e) {
            Log::error('Telegram notification failed', ['guest_id' => $guest->id, 'error' => $e->getMessage()]);
        }

        $this->submitted = true;

        $this->reset([
            'instansi',
            'tujuan',
            'jumlah_personil',
            'nama_pic',
            'no_hp',
        ]);
        $this->jumlah_personil = 1;
    }

    public function resetForm(): void
    {
        $this->submitted = false;
    }

    public function render()
    {
        return view('livewire.guest-check-in')
            ->layout('layouts.guest', ['title' => 'Buku Tamu Digital']);
    }
}
