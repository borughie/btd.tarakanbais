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

    // Edit modal
    public bool $showEditModal = false;

    public ?int $editingGuestId = null;

    public string $edit_instansi = '';

    public string $edit_tujuan = '';

    public int $edit_jumlah_personil = 1;

    public ?string $edit_nama_pic = null;

    public ?string $edit_no_hp = null;

    public ?string $edit_tanggal_kunjungan = null;

    public ?string $edit_jam_kunjungan = null;

    // Delete modal
    public bool $showDeleteModal = false;

    public ?int $deletingGuestId = null;

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

    public function editGuest(int $id): void
    {
        $guest = Guest::findOrFail($id);

        $this->editingGuestId = $guest->id;
        $this->edit_instansi = $guest->instansi;
        $this->edit_tujuan = $guest->tujuan;
        $this->edit_jumlah_personil = $guest->jumlah_personil;
        $this->edit_nama_pic = $guest->nama_pic;
        $this->edit_no_hp = $guest->no_hp;
        $this->edit_tanggal_kunjungan = $guest->tanggal_kunjungan?->format('Y-m-d');
        $this->edit_jam_kunjungan = $guest->jam_kunjungan;
        $this->showEditModal = true;
    }

    public function updateGuest(): void
    {
        $this->validate([
            'edit_instansi' => 'required|string|max:255',
            'edit_tujuan' => 'required|string|max:500',
            'edit_jumlah_personil' => 'nullable|integer|min:1|max:100',
            'edit_nama_pic' => 'nullable|string|max:255',
            'edit_no_hp' => 'nullable|string|max:20',
            'edit_tanggal_kunjungan' => 'required|date',
            'edit_jam_kunjungan' => 'required|string',
        ], [], [
            'edit_instansi' => 'instansi',
            'edit_tujuan' => 'tujuan',
            'edit_jumlah_personil' => 'jumlah personil',
            'edit_nama_pic' => 'nama PIC',
            'edit_no_hp' => 'no HP',
            'edit_tanggal_kunjungan' => 'tanggal kunjungan',
            'edit_jam_kunjungan' => 'jam kunjungan',
        ]);

        Guest::findOrFail($this->editingGuestId)->update([
            'instansi' => $this->edit_instansi,
            'tujuan' => $this->edit_tujuan,
            'jumlah_personil' => $this->edit_jumlah_personil,
            'nama_pic' => $this->edit_nama_pic,
            'no_hp' => $this->edit_no_hp,
            'tanggal_kunjungan' => $this->edit_tanggal_kunjungan,
            'jam_kunjungan' => $this->edit_jam_kunjungan,
        ]);

        $this->showEditModal = false;
        $this->editingGuestId = null;
        $this->dispatch('saved', message: 'Data tamu berhasil diperbarui.');
    }

    public function cancelEdit(): void
    {
        $this->showEditModal = false;
        $this->editingGuestId = null;
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingGuestId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteGuest(): void
    {
        Guest::findOrFail($this->deletingGuestId)->delete();

        $this->showDeleteModal = false;
        $this->deletingGuestId = null;
        $this->dispatch('saved', message: 'Data tamu berhasil dihapus.');
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->deletingGuestId = null;
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
            $query->where('tanggal_kunjungan', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->where('tanggal_kunjungan', '<=', $this->dateTo);
        }

        $guests = $query->latest('tanggal_kunjungan')->latest('jam_kunjungan')->paginate(15);
        $todayCount = Guest::where('tanggal_kunjungan', now()->toDateString())->count();
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
