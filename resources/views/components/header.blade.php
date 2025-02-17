<div class="navbar gradient-blue shadow-sm">
    <div class="flex-none lg:hidden">
        <label for="my-drawer-2" class="btn btn-square btn-ghost bg-white">
            <i class='bx bx-menu text-2xl text-primary'></i>
        </label>
    </div>
    <div class="flex-1">
        <div class="flex lg:hidden ml-3 items-center gap-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                <img src="{{ asset('assets/img/fajarbaru.png') }}" alt="Logo" class="w-8 h-8 object-contain">
            </div>
            <div class="text-white">
                <p class="text-xl font-bold leading-none">Fajar Baru</p>
                <span class=" sm:inline md:inline lg:inline text-xs font-semibold tracking-wide">@yield('page-title')</span>
            </div>
        </div>
        <div class="flex ml-3 items-center gap-3">
            <div class="text-white">
                <p class="text-xl font-bold leading-none">@yield('page-title') - POS</p>
                
            </div>
        </div>
    </div>
    <div class="flex-none text-white">
        <button class="btn btn-ghost btn-circle">
            <i class='bx bx-bell text-xl'></i>
        </button>
    </div>
</div>