<!-- components/breadcrumb.blade.php -->
<div class="flex flex-col md:flex-row gap-4 items-start justify-between w-full">
    <!-- Title Section -->
    <div class="flex flex-col w-full md:w-auto">
        <h3 class="text-2xl font-semibold text-primary">@yield('page-title', 'Page')</h3>
        <!-- Breadcrumbs Navigation -->
        <div class="breadcrumbs text-md">
            <ul>
                <li>
                    <a href="/dashboard" class="inline-flex gap-2 items-center">
                        <i class="bx bx-home"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                @foreach ($breadcrumblist as $item)
                    <li>
                        @if(isset($item['link']))  
                            <a href="{{ $item['link'] }}" class="inline-flex gap-2 items-center">
                        @endif
                        <span class="inline-flex gap-2 items-center">
                            @if(isset($item['icon']))
                                <i class="bx {{ $item['icon'] }}"></i>
                            @endif
                            <span>{{ $item['title'] }}</span>
                        </span>
                        @if(isset($item['link']))  
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Action Button Section -->
    <div class="w-full md:w-auto">
        @yield('breadcrumb-action')
    </div>
</div>