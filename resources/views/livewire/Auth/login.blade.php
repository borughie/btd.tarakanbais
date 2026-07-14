<div class="min-h-screen flex items-center justify-center p-4 bg-white relative overflow-hidden">
    <div
        class="absolute -top-40 left-1/2 -translate-x-1/2 w-150 h-100 bg-[#B3202E]/4 rounded-full blur-3xl pointer-events-none">
    </div>

    <div class="w-full max-w-md relative">
        <div
            class="rounded-[28px] shadow-[0_20px_60px_-15px_rgba(179,32,46,0.25)] border border-[#B3202E]/10 overflow-hidden bg-white">

            {{-- Header: staff ID badge motif (textured, distinct from guest seal) --}}
            <div class="relative bg-linear-to-br from-[#B3202E] to-[#7A1620] px-6 pt-7 pb-8 text-center"
                style="background-image: repeating-linear-gradient(135deg, rgba(255,255,255,0.04) 0px, rgba(255,255,255,0.04) 1px, transparent 1px, transparent 12px), linear-gradient(to bottom right, #B3202E, #7A1620);">
                <div
                    class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-white flex items-center justify-center border-2 border-[#E8C468]/60 overflow-hidden">
                    <img src="{{ asset('img/logo.webp') }}" alt="Logo SD" class="w-full h-full object-contain p-1" />
                </div>
                <h1 class="font-['Fraunces',serif] text-white text-2xl font-bold tracking-tight">SD Indo Tionghua
                    Tarakan</h1>
                <p class="text-[#E8C468] text-[11px] font-semibold uppercase tracking-[0.2em] mt-1.5">Portal Staf
                    &middot; Login Admin</p>
            </div>

            <div class="px-6 py-8 font-['Plus_Jakarta_Sans',sans-serif]">
                <form wire:submit="login" class="space-y-5">
                    <div>
                        <label for="email"
                            class="block text-[11px] font-semibold uppercase tracking-wider text-[#6B5C5C] mb-1.5">
                            Email
                        </label>
                        <input type="email" id="email" wire:model="email"
                            class="w-full px-4 py-3 border border-[#B3202E]/15 rounded-xl focus:ring-2 focus:ring-[#B3202E]/40 focus:border-[#B3202E] transition duration-200 outline-none text-[#241B1B] placeholder:text-gray-400"
                            placeholder="admin@sdindotionghua.sch.id" autocomplete="email" />
                        @error('email')
                            <p class="text-[#B3202E] text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password"
                            class="block text-[11px] font-semibold uppercase tracking-wider text-[#6B5C5C] mb-1.5">
                            Password
                        </label>
                        <input type="password" id="password" wire:model="password"
                            class="w-full px-4 py-3 border border-[#B3202E]/15 rounded-xl focus:ring-2 focus:ring-[#B3202E]/40 focus:border-[#B3202E] transition duration-200 outline-none text-[#241B1B] placeholder:text-gray-400"
                            placeholder="Masukkan password" autocomplete="current-password" />
                        @error('password')
                            <p class="text-[#B3202E] text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="remember"
                                class="w-4 h-4 rounded border-gray-300 accent-[#B3202E] focus:ring-[#B3202E]/40" />
                            <span class="text-sm text-[#6B5C5C]">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full bg-[#B3202E] hover:bg-[#7A1620] disabled:bg-[#B3202E]/50 text-white font-semibold uppercase tracking-wide text-sm py-3.5 px-6 rounded-xl transition duration-200 shadow-lg shadow-[#B3202E]/20">
                        <span wire:loading.remove wire:target="login">Masuk</span>
                        <span wire:loading wire:target="login">Memproses...</span>
                    </button>
                </form>

                <p class="text-center mt-6">
                    <a href="{{ route('guest.checkin') }}" class="text-[#B3202E] text-sm font-medium hover:underline">
                        &larr; Kembali ke Buku Tamu
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>