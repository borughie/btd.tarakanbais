<?php

namespace App\Livewire\Admin;

use App\Models\Guest;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

#[Layout('layouts.admin', ['title' => 'Dashboard Tamu'])]
class GuestDashboard extends Component
{
    use WithPagination;

    public string $search = '';

    public string $dateFrom = '';

    public string $dateTo = '';

    public bool $showQrModal = false;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    public function toggleQrModal(): void
    {
        $this->showQrModal = ! $this->showQrModal;
    }

    public function generateQr(): string
    {
        return QrCode::size(300)
            ->generate(route('guest.checkin'));
    }

    #[Computed]
    public function qrDataUri(): string
    {
        $svg = QrCode::size(300)->generate(route('guest.checkin'));

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }

    public function render()
    {
        $query = Guest::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('instansi', 'like', "%{$this->search}%")
                    ->orWhere('tujuan', 'like', "%{$this->search}%");
            });
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $guests = $query->latest()->paginate(15);
        $todayCount = Guest::today()->count();
        $totalCount = Guest::count();
        $notifiedCount = Guest::where('notified', true)->count();

        return view('livewire.admin.guest-dashboard', [
            'guests' => $guests,
            'todayCount' => $todayCount,
            'totalCount' => $totalCount,
            'notifiedCount' => $notifiedCount,
        ]);
    }
}
