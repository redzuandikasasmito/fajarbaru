<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
    <style>
        /* Custom Gradient Background */
        body {
            background: linear-gradient(135deg, #e0f2fe, #bae6fd, #7dd3fc);
            min-height: 100vh;
        }
        
        /* Responsive Typography */
        @media (max-width: 640px) {
            body {
                font-size: 14px;
            }
            .dashboard-card {
                flex-direction: column;
                text-align: center;
            }
            .sidebar {
                width: 250px !important;
            }
        }
        
        /* Sidebar Custom Styling */
        .sidebar {
            background: linear-gradient(to bottom, #1e40af, #2563eb);
            color: white;
            width: 260px;
        }
        
        /* Card Hover Effect */
        .dashboard-card {
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* Mobile Menu Overlay */
        @media (max-width: 1024px) {
            .drawer-side {
                z-index: 100;
            }
            .drawer-overlay {
                z-index: 99;
            }
        }
    </style>
</head>
<body class="font-sans">
    <div class="drawer lg:drawer-open">
        <!-- Checkbox untuk drawer mobile -->
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        
        <!-- Konten Utama -->
        <div class="drawer-content flex flex-col">
            <!-- Navbar Mobile Friendly -->
            <div class="navbar bg-base-100 shadow-md">
                <div class="flex-none">
                    <label for="my-drawer" class="btn btn-square btn-ghost lg:hidden">
                        <i class='bx bx-menu text-2xl'></i>
                    </label>
                </div>
                <div class="flex-1 justify-center">
                    <a class="btn btn-ghost text-xl">Dashboard</a>
                </div>
                <div class="flex-none">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img alt="Profil" src="/api/placeholder/150/150" />
                            </div>
                        </div>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                            <li><a><i class='bx bx-user mr-2'></i>Profil</a></li>
                            <li><a><i class='bx bx-cog mr-2'></i>Pengaturan</a></li>
                            <li><a class="text-red-500"><i class='bx bx-log-out mr-2'></i>Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Konten Dashboard Responsif -->
            <main class="p-4 sm:p-6 flex-grow">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <!-- Card Statistik Responsif -->
                    <div class="card bg-white shadow-xl dashboard-card">
                        <div class="card-body w-full flex flex-row items-center justify-between">
                            <div>
                                <h3 class="text-sm sm:text-lg font-semibold text-gray-600">Pendapatan</h3>
                                <p class="text-lg sm:text-2xl font-bold text-blue-600">Rp 125 JT</p>
                            </div>
                            <i class='bx bx-line-chart text-2xl sm:text-4xl text-blue-500'></i>
                        </div>
                    </div>

                    <div class="card bg-white shadow-xl dashboard-card">
                        <div class="card-body w-full flex flex-row items-center justify-between">
                            <div>
                                <h3 class="text-sm sm:text-lg font-semibold text-gray-600">Pelanggan</h3>
                                <p class="text-lg sm:text-2xl font-bold text-green-600">254</p>
                            </div>
                            <i class='bx bx-group text-2xl sm:text-4xl text-green-500'></i>
                        </div>
                    </div>

                    <div class="card bg-white shadow-xl dashboard-card">
                        <div class="card-body w-full flex flex-row items-center justify-between">
                            <div>
                                <h3 class="text-sm sm:text-lg font-semibold text-gray-600">Pesanan</h3>
                                <p class="text-lg sm:text-2xl font-bold text-purple-600">42</p>
                            </div>
                            <i class='bx bx-shopping-bag text-2xl sm:text-4xl text-purple-500'></i>
                        </div>
                    </div>

                    <div class="card bg-white shadow-xl dashboard-card">
                        <div class="card-body w-full flex flex-row items-center justify-between">
                            <div>
                                <h3 class="text-sm sm:text-lg font-semibold text-gray-600">Komplain</h3>
                                <p class="text-lg sm:text-2xl font-bold text-red-600">7</p>
                            </div>
                            <i class='bx bx-message-error text-2xl sm:text-4xl text-red-500'></i>
                        </div>
                    </div>
                </div>

                <!-- Grafik atau Konten Tambahan -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="card bg-white shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title">Grafik Penjualan</h2>
                            <p>Grafik akan ditampilkan di sini</p>
                        </div>
                    </div>
                    <div class="card bg-white shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title">Aktivitas Terakhir</h2>
                            <p>Daftar aktivitas akan ditampilkan di sini</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
        <!-- Sidebar Mobile Friendly -->
        <div class="drawer-side sidebar">
            <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu p-4 w-64 min-h-full bg-blue-700 text-white space-y-2">
                <!-- Logo -->
                <li class="mb-6 text-center">
                    <a class="text-xl sm:text-2xl font-bold">
                        <i class='bx bx-diamond mr-2'></i>Premium App
                    </a>
                </li>

                <!-- Menu Navigasi Responsif -->
                <li class="w-full">
                    <a class="flex items-center space-x-2">
                        <i class='bx bx-home-alt'></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="w-full">
                    <a class="flex items-center space-x-2">
                        <i class='bx bx-user'></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                </li>
                <li class="w-full">
                    <a class="flex items-center space-x-2">
                        <i class='bx bx-chart'></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li class="w-full">
                    <a class="flex items-center space-x-2">
                        <i class='bx bx-cog'></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                
                <!-- Pemisah -->
                <li class="my-4">
                    <hr class="border-blue-500"/>
                </li>
                
                <!-- Premium Feature Responsif -->
                <li class="w-full">
                    <a class="bg-yellow-500 text-white rounded-lg flex items-center space-x-2 justify-center">
                        <i class='bx bx-star'></i>
                        <span>Upgrade Premium</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Optional: Mobile Bottom Navigation -->
    <div class="btm-nav lg:hidden">
        <button>
            <i class='bx bx-home'></i>
            <span class="btm-nav-label">Beranda</span>
        </button>
        <button>
            <i class='bx bx-chart'></i>
            <span class="btm-nav-label">Laporan</span>
        </button>
        <button>
            <i class='bx bx-user'></i>
            <span class="btm-nav-label">Profil</span>
        </button>
    </div>
</body>
</html>