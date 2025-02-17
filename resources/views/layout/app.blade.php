{{-- Head --}}
@include('components.head')


<body class="bg-gray-50">
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        
        {{-- Main Content Wrapper --}}
        <div class="drawer-content flex flex-col min-h-screen">
            {{-- Navbar --}}
            @include('components.header')

            {{-- Main Content --}}
            <main class="flex-1 px-4 py-2">
                {{-- <div class="flex justify-between items-center my-2 py-1 px-4 bg-base-100 shadow-md rounded-md">
                    @yield('breadcrumb')
                </div> --}}
                {{-- Flash Messages --}}
                @if(session()->has('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-error mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Main Content Area --}}
                @yield('content')
            </main>

            {{-- Footer --}}
            @include('components.footer')
        </div>

        {{-- Sidebar --}}
        @include('components.sidebar')
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>