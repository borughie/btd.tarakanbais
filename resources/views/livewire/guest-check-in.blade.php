<div class="min-h-screen flex items-center justify-center p-4 bg-white relative overflow-hidden">
    {{-- subtle ambient glow, keeps background white but not flat --}}
    <div
        class="absolute -top-40 left-1/2 -translate-x-1/2 w-150 h-100 bg-[#B3202E]/4 rounded-full blur-3xl pointer-events-none">
    </div>

    <div class="w-full max-w-md relative">
        <div
            class="rounded-[28px] shadow-[0_20px_60px_-15px_rgba(179,32,46,0.25)] border border-[#B3202E]/10 overflow-hidden bg-white">

            {{-- Header: official seal motif --}}
            <div class="relative bg-linear-to-br from-[#B3202E] to-[#7A1620] px-6 pt-7 pb-8 text-center">
                <div class="relative w-16 h-16 mx-auto mb-3">
                    <div class="absolute inset-0 rounded-full border-2 border-[#E8C468]/60"></div>
                    <div class="absolute inset-0.75 rounded-full bg-white flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('img/logo.webp') }}" alt="Logo SD" class="w-full h-full object-contain" />
                    </div>
                </div>
                <h1 class="font-['Fraunces',serif] text-white text-2xl font-bold tracking-tight">SD Indo Tionghoa
                    Tarakan</h1>
                <p class="text-[#E8C468] text-[11px] font-semibold uppercase tracking-[0.2em] mt-1.5">Buku Tamu Digital
                </p>

                {{-- ticket notch cutouts --}}
                <div class="absolute -bottom-3 -left-3 w-6 h-6 bg-white rounded-full"></div>
                <div class="absolute -bottom-3 -right-3 w-6 h-6 bg-white rounded-full"></div>
            </div>

            {{-- perforation line --}}
            <div class="border-t-2 border-dashed border-[#B3202E]/15 mx-6"></div>

            <div class="px-6 py-8 font-['Plus_Jakarta_Sans',sans-serif]">
                @if ($submitted)
                    <div class="text-center py-6">
                        <div class="relative w-20 h-20 mx-auto mb-4">
                            <div class="absolute inset-0 rounded-full border-2 border-[#E8C468]"></div>
                            <div class="absolute inset-1 rounded-full bg-[#FBEAEA] flex items-center justify-center">
                                <svg class="w-9 h-9 text-[#B3202E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="font-['Fraunces',serif] text-2xl font-bold text-[#241B1B] mb-2">Terima Kasih</h2>
                        <p class="text-[#6B5C5C] text-sm mb-6 leading-relaxed">Data kunjungan Anda telah berhasil
                            dicatat oleh sistem.</p>
                        <button wire:click="resetForm"
                            class="border-2 border-[#B3202E] text-[#B3202E] hover:bg-[#B3202E] hover:text-white font-semibold text-sm uppercase tracking-wide py-3 px-8 rounded-xl transition duration-200">
                            Isi Kunjungan Baru
                        </button>
                    </div>
                @else
                    <form wire:submit="submit" class="space-y-5">
                        <div>
                            <label for="instansi"
                                class="block text-[11px] font-semibold uppercase tracking-wider text-[#6B5C5C] mb-1.5">
                                Instansi <span class="text-[#B3202E]">*</span>
                            </label>
                            <input type="text" id="instansi" wire:model="instansi"
                                class="w-full px-4 py-3 border border-[#B3202E]/15 rounded-xl focus:ring-2 focus:ring-[#B3202E]/40 focus:border-[#B3202E] transition duration-200 outline-none text-[#241B1B] placeholder:text-gray-400"
                                placeholder="Nama instansi / perusahaan" />
                            @error('instansi')
                                <p class="text-[#B3202E] text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="tanggal_kunjungan"
                                    class="block text-[11px] font-semibold uppercase tracking-wider text-[#6B5C5C] mb-1.5">
                                    Tanggal Kunjungan <span class="text-[#B3202E]">*</span>
                                </label>
                                <input type="date" id="tanggal_kunjungan" wire:model="tanggal_kunjungan"
                                    class="w-full px-4 py-3 border border-[#B3202E]/15 rounded-xl focus:ring-2 focus:ring-[#B3202E]/40 focus:border-[#B3202E] transition duration-200 outline-none text-[#241B1B]" />
                                @error('tanggal_kunjungan')
                                    <p class="text-[#B3202E] text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jam_kunjungan"
                                    class="block text-[11px] font-semibold uppercase tracking-wider text-[#6B5C5C] mb-1.5">
                                    Jam Kunjungan <span class="text-[#B3202E]">*</span>
                                </label>
                                <input type="time" id="jam_kunjungan" wire:model="jam_kunjungan"
                                    class="w-full px-4 py-3 border border-[#B3202E]/15 rounded-xl focus:ring-2 focus:ring-[#B3202E]/40 focus:border-[#B3202E] transition duration-200 outline-none text-[#241B1B]" />
                                @error('jam_kunjungan')
                                    <p class="text-[#B3202E] text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="tujuan"
                                class="block text-[11px] font-semibold uppercase tracking-wider text-[#6B5C5C] mb-1.5">
                                Tujuan Kunjungan <span class="text-[#B3202E]">*</span>
                            </label>
                            <textarea id="tujuan" wire:model="tujuan" rows="3"
                                class="w-full px-4 py-3 border border-[#B3202E]/15 rounded-xl focus:ring-2 focus:ring-[#B3202E]/40 focus:border-[#B3202E] transition duration-200 outline-none resize-none text-[#241B1B] placeholder:text-gray-400"
                                placeholder="Tujuan kunjungan"></textarea>
                            @error('tujuan')
                                <p class="text-[#B3202E] text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jumlah_personil"
                                class="block text-[11px] font-semibold uppercase tracking-wider text-[#6B5C5C] mb-1.5">
                                Jumlah Personil
                            </label>
                            <input type="number" id="jumlah_personil" wire:model="jumlah_personil" min="1" max="100"
                                class="w-full px-4 py-3 border border-[#B3202E]/15 rounded-xl focus:ring-2 focus:ring-[#B3202E]/40 focus:border-[#B3202E] transition duration-200 outline-none text-[#241B1B]" />
                            @error('jumlah_personil')
                                <p class="text-[#B3202E] text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="nama_pic"
                                    class="block text-[11px] font-semibold uppercase tracking-wider text-[#6B5C5C] mb-1.5">
                                    Nama PIC
                                </label>
                                <input type="text" id="nama_pic" wire:model="nama_pic"
                                    class="w-full px-4 py-3 border border-[#B3202E]/15 rounded-xl focus:ring-2 focus:ring-[#B3202E]/40 focus:border-[#B3202E] transition duration-200 outline-none text-[#241B1B] placeholder:text-gray-400"
                                    placeholder="Opsional" />
                                @error('nama_pic')
                                    <p class="text-[#B3202E] text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="no_hp"
                                    class="block text-[11px] font-semibold uppercase tracking-wider text-[#6B5C5C] mb-1.5">
                                    No. HP
                                </label>
                                <input type="text" id="no_hp" wire:model="no_hp"
                                    class="w-full px-4 py-3 border border-[#B3202E]/15 rounded-xl focus:ring-2 focus:ring-[#B3202E]/40 focus:border-[#B3202E] transition duration-200 outline-none text-[#241B1B] placeholder:text-gray-400"
                                    placeholder="Opsional" />
                                @error('no_hp')
                                    <p class="text-[#B3202E] text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full bg-[#B3202E] hover:bg-[#7A1620] disabled:bg-[#B3202E]/50 text-white font-semibold uppercase tracking-wide text-sm py-3.5 px-6 rounded-xl transition duration-200 flex items-center justify-center gap-2 shadow-lg shadow-[#B3202E]/20">
                            <span wire:loading.remove wire:target="submit">Kirim Data Kunjungan</span>
                            <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Mengirim...
                            </span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <p class="text-center text-gray-400 text-[11px] uppercase tracking-wider mt-5">
            &copy; {{ date('Y') }} SD Indo Tionghoa Tarakan &middot; Hak Cipta Dilindungi
        </p>
    </div>
</div>