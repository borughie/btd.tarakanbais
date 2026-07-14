<div class="font-['Plus_Jakarta_Sans',sans-serif]">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 sm:mb-8 gap-4">
        <div>
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#B3202E] mb-1">SD Indo Tionghoa Tarakan
            </p>
            <h1 class="font-['Fraunces',serif] text-2xl sm:text-3xl font-bold text-[#241B1B]">Daftar Tamu</h1>
            <p class="text-[#6B5C5C] text-sm mt-1">Kelola data kunjungan tamu</p>
        </div>
        <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2 self-start">
            <a href="{{ route('admin.export.word') }}?{{ http_build_query(['search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                target="_blank"
                class="bg-[#2B579A] hover:bg-[#1E3F6F] text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 flex items-center justify-center gap-1.5 text-sm shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Word
            </a>
            <a href="{{ route('admin.export.excel') }}?{{ http_build_query(['search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                target="_blank"
                class="bg-[#217346] hover:bg-[#185C37] text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 flex items-center justify-center gap-1.5 text-sm shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Excel
            </a>
            <a href="{{ route('admin.export.pdf') }}?{{ http_build_query(['search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                target="_blank"
                class="bg-[#B3202E] hover:bg-[#7A1620] text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 flex items-center justify-center gap-1.5 text-sm shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                PDF
            </a>
            <button wire:click="toggleQrModal"
                class="bg-[#C9A227] hover:bg-[#A68520] text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 flex items-center justify-center gap-1.5 text-sm shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                QR Code
            </button>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-6 sm:mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-[#B3202E]/10 border-t-4 border-t-[#B3202E] p-3 sm:p-5">
            <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-[#6B5C5C]">Hari Ini</p>
            <p class="font-['Fraunces',serif] text-2xl sm:text-3xl font-bold text-[#B3202E] mt-1 sm:mt-1.5">{{ $todayCount }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-[#B3202E]/10 border-t-4 border-t-[#241B1B] p-3 sm:p-5">
            <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-[#6B5C5C]">Total Tamu</p>
            <p class="font-['Fraunces',serif] text-2xl sm:text-3xl font-bold text-[#241B1B] mt-1 sm:mt-1.5">{{ $totalCount }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-[#B3202E]/10 border-t-4 border-t-[#C9A227] p-3 sm:p-5">
            <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-[#6B5C5C]">Notifikasi</p>
            <p class="font-['Fraunces',serif] text-2xl sm:text-3xl font-bold text-[#C9A227] mt-1 sm:mt-1.5">{{ $notifiedCount }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#B3202E]/10 mb-6 overflow-hidden">
        <div class="p-3 sm:p-4 border-b border-[#B3202E]/10 bg-[#FBEAEA]/30">
            <div class="flex flex-col gap-3">
                <div class="flex-1">
                    <input type="text" wire:model.live="search" placeholder="Cari instansi atau tujuan..."
                        class="w-full px-4 py-2.5 border border-[#B3202E]/15 rounded-xl focus:ring-2 focus:ring-[#B3202E]/40 focus:border-[#B3202E] transition duration-200 outline-none text-[#241B1B] placeholder:text-gray-400 bg-white text-sm" />
                </div>
                <div class="flex gap-3">
                    <input type="date" wire:model.live="dateFrom" placeholder="Dari tanggal"
                        class="flex-1 px-4 py-2.5 border border-[#B3202E]/15 rounded-xl focus:ring-2 focus:ring-[#B3202E]/40 focus:border-[#B3202E] transition duration-200 outline-none text-[#241B1B] bg-white text-sm" />
                    <input type="date" wire:model.live="dateTo" placeholder="Sampai tanggal"
                        class="flex-1 px-4 py-2.5 border border-[#B3202E]/15 rounded-xl focus:ring-2 focus:ring-[#B3202E]/40 focus:border-[#B3202E] transition duration-200 outline-none text-[#241B1B] bg-white text-sm" />
                </div>
            </div>
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#FBEAEA]/50">
                    <tr>
                        <th class="px-4 py-3 text-center text-[11px] font-semibold text-[#6B5C5C] uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#6B5C5C] uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#6B5C5C] uppercase tracking-wider">Instansi</th>
                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#6B5C5C] uppercase tracking-wider">Tujuan</th>
                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#6B5C5C] uppercase tracking-wider">Personil</th>
                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#6B5C5C] uppercase tracking-wider">PIC</th>
                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#6B5C5C] uppercase tracking-wider">No. HP</th>
                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#6B5C5C] uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#B3202E]/6">
                    @forelse ($guests as $i => $guest)
                        <tr class="hover:bg-[#FBEAEA]/30 transition">
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-[#6B5C5C] text-center">
                                {{ ($guests->currentPage() - 1) * $guests->perPage() + $i + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#6B5C5C]">
                                {{ $guest->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-[#241B1B]">
                                {{ $guest->instansi }}
                            </td>
                            <td class="px-6 py-4 text-sm text-[#6B5C5C] max-w-xs truncate">
                                {{ $guest->tujuan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#6B5C5C]">
                                {{ $guest->jumlah_personil }}
                            </td>
                            <td class="px-6 py-4 text-sm text-[#6B5C5C]">
                                {{ $guest->nama_pic ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#6B5C5C]">
                                {{ $guest->no_hp ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $guest->notified ? 'bg-[#FBF3DC] text-[#8A6D1D] border border-[#E8C468]/50' : 'bg-gray-50 text-gray-500 border border-gray-200' }}">
                                    {{ $guest->notified ? 'Telegram ✓' : 'Belum Notif' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="text-[#6B5C5C]">
                                    <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-[#FBEAEA] flex items-center justify-center">
                                        <svg class="w-7 h-7 text-[#B3202E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="font-['Fraunces',serif] text-lg font-bold text-[#241B1B]">Belum Ada Data Tamu</p>
                                    <p class="text-sm mt-1">Data akan muncul setelah ada kunjungan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="md:hidden divide-y divide-[#B3202E]/6">
            @forelse ($guests as $i => $guest)
                <div class="p-4 hover:bg-[#FBEAEA]/20 transition">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-[#241B1B] text-sm truncate">{{ $guest->instansi }}</p>
                            <p class="text-xs text-[#6B5C5C] mt-0.5">{{ $guest->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <span
                            class="shrink-0 ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $guest->notified ? 'bg-[#FBF3DC] text-[#8A6D1D] border border-[#E8C468]/50' : 'bg-gray-50 text-gray-500 border border-gray-200' }}">
                            {{ $guest->notified ? '✓' : '—' }}
                        </span>
                    </div>
                    <p class="text-xs text-[#6B5C5C] mb-2 line-clamp-2">{{ $guest->tujuan }}</p>
                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-[#6B5C5C]">
                        <span>{{ $guest->jumlah_personil }} orang</span>
                        @if ($guest->nama_pic)
                            <span>PIC: {{ $guest->nama_pic }}</span>
                        @endif
                        @if ($guest->no_hp)
                            <span>{{ $guest->no_hp }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-6 py-16 text-center">
                    <div class="text-[#6B5C5C]">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-[#FBEAEA] flex items-center justify-center">
                            <svg class="w-7 h-7 text-[#B3202E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <p class="font-['Fraunces',serif] text-lg font-bold text-[#241B1B]">Belum Ada Data Tamu</p>
                        <p class="text-sm mt-1">Data akan muncul setelah ada kunjungan</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($guests->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-[#B3202E]/10">
                {{ $guests->links() }}
            </div>
        @endif
    </div>

    @if ($showQrModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:click="toggleQrModal">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-[#241B1B]/60 backdrop-blur-sm transition-opacity"></div>
                <div class="relative bg-white rounded-[28px] shadow-2xl max-w-sm w-full overflow-hidden" wire:click.stop>
                    <div class="bg-linear-to-br from-[#B3202E] to-[#7A1620] px-6 pt-6 pb-7 text-center relative">
                        <div class="w-14 h-14 mx-auto mb-2 rounded-xl bg-white flex items-center justify-center border-2 border-[#E8C468]/60 overflow-hidden">
                            <img src="{{ asset('img/logo.webp') }}" alt="Logo SD" class="w-full h-full object-contain p-0.5" />
                        </div>
                        <p class="text-[#E8C468] text-[11px] font-semibold uppercase tracking-[0.2em] mb-1">SD Indo Tionghoa</p>
                        <h3 class="font-['Fraunces',serif] text-white text-xl font-bold">QR Code Buku Tamu</h3>
                        <div class="absolute -bottom-3 -left-3 w-6 h-6 bg-white rounded-full"></div>
                        <div class="absolute -bottom-3 -right-3 w-6 h-6 bg-white rounded-full"></div>
                    </div>
                    <div class="border-t-2 border-dashed border-[#B3202E]/15 mx-6"></div>

                    <div class="px-6 sm:px-8 py-7 text-center">
                        <p class="text-[#6B5C5C] text-sm mb-6">Scan QR code ini untuk mengisi buku tamu</p>

                        <div class="bg-[#FBEAEA]/40 rounded-2xl p-4 inline-block mb-4 border border-[#B3202E]/10">
                            <img src="{{ $this->qrDataUri }}" alt="QR Code Buku Tamu" class="w-48 h-48 sm:w-56 sm:h-56" />
                        </div>

                        <p class="text-xs text-gray-400 mb-5 break-all">{{ route('guest.checkin') }}</p>
                        <a href="{{ $this->qrDataUri }}" download="qrcode-buku-tamu.png"
                            class="inline-block w-full bg-[#B3202E] hover:bg-[#7A1620] text-white font-semibold uppercase tracking-wide text-sm py-3 px-6 rounded-xl transition duration-200 mb-3 shadow-lg shadow-[#B3202E]/20">
                            Download QR Code
                        </a>

                        <button wire:click="toggleQrModal" class="text-[#6B5C5C] hover:text-[#241B1B] text-sm font-medium">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
