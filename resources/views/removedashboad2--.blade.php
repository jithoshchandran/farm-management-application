<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard 2 - Premium Cow Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f0f4f0;
            background-image: linear-gradient(135deg, #e8f0e8 0%, #d1e2d1 100%);
            min-height: 100vh;
            color: #2d3436;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            border-radius: 28px;
            overflow: hidden;
        }

        .stat-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        }

        .chart-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 32px;
        }

        .btn-green-dark {
            background: #2d6a4f;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-green-dark:hover {
            background: #1b4332;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(45, 106, 79, 0.3);
        }

        .cow-sub-card {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .cow-sub-card:hover {
            background: rgba(255, 255, 255, 0.9);
            border-color: #2d6a4f;
        }
    </style>
</head>

<body class="p-6 md:p-12">

    <div class="max-w-7xl mx-auto">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Total Cows -->
            <div class="stat-card glass-card rounded-3xl p-6 flex items-center gap-5 border-none shadow-lg">
                <div class="w-20 h-20 flex-shrink-0 bg-green-50 rounded-2xl p-2">
                    <img src="{{ asset('images/dashboard2/cow.png') }}" alt="Cow"
                        class="w-full h-full object-contain">
                </div>
                <div>
                    <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest">Total Cows</h3>
                    <p class="text-4xl font-extrabold text-[#2d6a4f]">120</p>
                </div>
            </div>

            <!-- Total Bulls -->
            <div class="stat-card glass-card rounded-3xl p-6 flex items-center gap-5 border-none shadow-lg">
                <div class="w-20 h-20 flex-shrink-0 bg-blue-50 rounded-2xl p-2">
                    <img src="{{ asset('images/dashboard2/bull.png') }}" alt="Bull"
                        class="w-full h-full object-contain">
                </div>
                <div>
                    <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest">Total Bulls</h3>
                    <p class="text-4xl font-extrabold text-[#2d6a4f]">18</p>
                </div>
            </div>

            <!-- Total Calves -->
            <div class="stat-card glass-card rounded-3xl p-6 flex items-center gap-5 border-none shadow-lg">
                <div class="w-20 h-20 flex-shrink-0 bg-orange-50 rounded-2xl p-2">
                    <img src="{{ asset('images/dashboard2/calf.png') }}" alt="Calf"
                        class="w-full h-full object-contain">
                </div>
                <div>
                    <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest">Total Calves</h3>
                    <p class="text-4xl font-extrabold text-[#2d6a4f]">45</p>
                </div>
            </div>

            <!-- Today's Milk Yield -->
            <div
                class="stat-card glass-card rounded-3xl p-6 flex items-center gap-5 border-none shadow-lg relative overflow-hidden">
                <div class="w-20 h-20 flex-shrink-0 bg-green-50 rounded-2xl p-2">
                    <img src="{{ asset('images/dashboard2/milk.png') }}" alt="Milk"
                        class="w-full h-full object-contain">
                </div>
                <div>
                    <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest">Today's Yield</h3>
                    <div class="flex items-baseline gap-1">
                        <p class="text-4xl font-extrabold text-[#2d6a4f]">950</p>
                        <span class="text-[#40916c] font-black text-xl">L</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Milk Production Overview -->
        <div class="chart-container glass-card p-10 rounded-[40px] mb-10 shadow-xl border-none">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-black text-gray-800 tracking-tight">Milk Production</h2>
                    <p class="text-gray-400 text-sm font-bold uppercase tracking-widest mt-1">Weekly Performance
                        Overview</p>
                </div>
                <div class="flex gap-4">
                    <div class="px-4 py-2 bg-green-50 rounded-xl border border-green-100">
                        <p class="text-[10px] font-bold text-green-600 uppercase">Avg Yield</p>
                        <p class="text-lg font-black text-[#2d6a4f]">785 L</p>
                    </div>
                    <div class="px-4 py-2 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Trend</p>
                        <p class="text-lg font-black text-gray-700">+12%</p>
                    </div>
                </div>
            </div>
            <div id="milk-chart" class="w-full h-[400px]"></div>
        </div>

        <!-- Data Tabs Card Style -->
        <div class="mb-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Our Cows Card Tab -->
                <div onclick="switchTab('inventory')" id="tab-inventory"
                    class="tab-card glass-card rounded-2xl p-6 flex items-center gap-6 cursor-pointer border-2 border-transparent active-tab-card">
                    <div class="w-16 h-16 flex-shrink-0">
                        <img src="{{ asset('images/dashboard2/herd.png') }}" alt="Herd"
                            class="w-full h-full object-contain rounded-lg">
                    </div>
                    <div>
                        <h3 class="text-green-800 font-bold text-lg">Our Cows</h3>
                        <p class="text-gray-500 text-xs text-nowrap">Inventory & Stats</p>
                    </div>
                </div>

                <!-- Breeding Bulls Card Tab -->
                <div onclick="switchTab('health')" id="tab-health"
                    class="tab-card glass-card rounded-2xl p-6 flex items-center gap-6 cursor-pointer border-2 border-transparent">
                    <div class="w-16 h-16 flex-shrink-0">
                        <img src="{{ asset('images/dashboard2/health.png') }}" alt="Bulls"
                            class="w-full h-full object-contain rounded-lg">
                    </div>
                    <div>
                        <h3 class="text-green-800 font-bold text-lg">Breeding Bulls</h3>
                        <p class="text-gray-500 text-xs text-nowrap">Performance & Records</p>
                    </div>
                </div>

                <!-- Recent Calves Card Tab -->
                <div onclick="switchTab('feed')" id="tab-feed"
                    class="tab-card glass-card rounded-2xl p-6 flex items-center gap-6 cursor-pointer border-2 border-transparent">
                    <div class="w-16 h-16 flex-shrink-0">
                        <img src="{{ asset('images/dashboard2/feed.png') }}" alt="Calves"
                            class="w-full h-full object-contain rounded-lg">
                    </div>
                    <div>
                        <h3 class="text-green-800 font-bold text-lg">Recent Calves</h3>
                        <p class="text-gray-500 text-xs text-nowrap">Growth & Monitoring</p>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-3xl p-8 min-h-[400px]">
                <!-- Inventory Tab Content -->
                <!-- Our Cows Tab Content -->
                <div id="content-inventory" class="tab-content transition-all duration-500">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Pregnant Cows Section -->
                        <div class="glass-card p-6 border-none shadow-xl">
                            <div class="flex justify-between items-center mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-[#f0f4f0] rounded-xl">
                                        <!-- Pregnant Cow Icon (Simplified) -->
                                        <svg class="w-8 h-8 text-[#2d6a4f]" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M4.5 21v-8.25m15 0a.75.75 0 110-1.5.75.75 0 010 1.5zM4.5 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM4.5 11.25V9.75M4.5 18a.75.75 0 010-1.5.75.75 0 010 1.5zM12 9.75l.189-.113a1.5 1.5 0 011.622 0l.189.113M14.25 18a.75.75 0 110-1.5.75.75 0 010 1.5zM9.75 18a.75.75 0 110-1.5.75.75 0 010 1.5zM6.75 18a.75.75 0 110-1.5.75.75 0 010 1.5zM18 18a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                            <circle cx="12" cy="7" r="3" />
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-[#2d6a4f]">Pregnant Cows</h4>
                                </div>
                                <a href="#"
                                    class="btn-green-dark px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                                    View All
                                    <span class="text-lg leading-none">›</span>
                                </a>
                            </div>

                            <div class="cow-sub-card p-5 flex gap-6 bg-white/40">
                                <div class="w-32 h-32 flex-shrink-0 rounded-2xl overflow-hidden shadow-md">
                                    <img src="{{ asset('images/dashboard2/cow1.png') }}" alt="Cow"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="flex-grow flex flex-col justify-between">
                                    <div>
                                        <h5 class="text-2xl font-bold text-gray-800">C-102</h5>
                                        <div class="mt-2 space-y-0.5 text-sm">
                                            <p class="text-gray-500">Tag: <span
                                                    class="text-gray-800 font-semibold ml-1">Gir</span></p>
                                            <p class="text-gray-500">Age: <span
                                                    class="text-gray-800 font-semibold ml-1">6 Years</span></p>
                                            <p class="text-gray-500">Milk: <span
                                                    class="text-[#2d6a4f] font-bold ml-1">22 L / Day</span></p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 mt-4">
                                        <button
                                            class="bg-[#2d6a4f] text-white py-2 px-5 rounded-xl text-xs font-bold hover:bg-[#1b4332] shadow-sm transition-all">View
                                            Details</button>
                                        <button
                                            class="bg-gray-800 text-white py-2 px-5 rounded-xl text-xs font-bold hover:bg-black shadow-sm transition-all">Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Feed column Section -->
                        <div class="glass-card p-6 border-none shadow-xl">
                            <div class="flex justify-between items-center mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-[#f0f4f0] rounded-xl">
                                        <!-- Feed Bag Icon -->
                                        <svg class="w-8 h-8 text-[#2d6a4f]" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 3v18M3 12h18M6 6l12 12M6 18L18 6" />
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-[#2d6a4f]">Feed column</h4>
                                </div>
                                <a href="#"
                                    class="btn-green-dark px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                                    View All
                                    <span class="text-lg leading-none">›</span>
                                </a>
                            </div>

                            <div class="cow-sub-card p-5 flex justify-between items-center bg-white/40 min-h-[148px]">
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                            <div class="w-5 h-5 bg-green-500/30 rounded"></div>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400">Hay</p>
                                            <p class="text-sm font-bold text-gray-700">60%</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-green-200 flex items-center justify-center">
                                            <div class="w-5 h-5 bg-green-600/30 rounded"></div>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-400">Silage</p>
                                            <p class="text-sm font-bold text-gray-700">30%</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-end gap-3 h-24">
                                    <div class="w-7 bg-green-200 rounded-t-lg h-[40%]"></div>
                                    <div class="w-7 bg-green-500 rounded-t-lg h-[75%]"></div>
                                    <div class="w-7 bg-green-800 rounded-t-lg h-[95%]"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Pregnancy Checks Section -->
                        <div class="glass-card p-6 border-none shadow-xl">
                            <div class="flex justify-between items-center mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-[#f0f4f0] rounded-xl">
                                        <!-- Scanner Icon -->
                                        <svg class="w-8 h-8 text-[#2d6a4f]" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-[#2d6a4f]">Pregnancy Checks</h4>
                                </div>
                                <a href="#"
                                    class="btn-green-dark px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                                    View All
                                    <span class="text-lg leading-none">›</span>
                                </a>
                            </div>

                            <div class="cow-sub-card p-5 flex items-center gap-8 bg-white/40 min-h-[148px]">
                                <div class="text-center">
                                    <p class="text-6xl font-extrabold text-[#2d6a4f] leading-none">12</p>
                                    <p class="text-xs font-bold text-gray-500 uppercase mt-2 tracking-widest">To Check
                                    </p>
                                </div>
                                <div
                                    class="flex-grow flex items-end justify-between gap-1 h-20 px-2 rounded-xl bg-green-50/50">
                                    <div class="w-3 bg-green-200 rounded-full h-[40%]"></div>
                                    <div class="w-3 bg-green-300 rounded-full h-[70%]"></div>
                                    <div class="w-3 bg-green-200 rounded-full h-[50%]"></div>
                                    <div class="w-3 bg-green-400 rounded-full h-[90%]"></div>
                                    <div class="w-3 bg-green-300 rounded-full h-[60%]"></div>
                                    <div class="w-3 bg-green-200 rounded-full h-[40%]"></div>
                                    <div class="w-3 bg-green-500 rounded-full h-[100%]"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Vaccination Charts Section -->
                        <div class="glass-card p-6 border-none shadow-xl">
                            <div class="flex justify-between items-center mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-[#f0f4f0] rounded-xl">
                                        <!-- Syringe Icon -->
                                        <svg class="w-8 h-8 text-[#2d6a4f]" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 11.25l1.5 1.5.75-.75V8.758l2.25 2.25c.352.352.897.435 1.25.082.353-.353.27-.898-.082-1.25L18.442 7.5H16.5l-.75-.75 1.5-1.5M10.5 11.25L3.94 17.81a2.25 2.25 0 103.182 3.182l6.56-6.56M10.5 11.25l1.5 1.5.75-.75V8.758M10.5 11.25V8.758l2.25 2.25M10.5 11.25l1.5-1.5.75.75m0 0l1.5-1.5" />
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-[#2d6a4f]">Vaccination Charts</h4>
                                </div>
                                <a href="#"
                                    class="btn-green-dark px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                                    View All
                                    <span class="text-lg leading-none">›</span>
                                </a>
                            </div>

                            <div class="cow-sub-card p-5 bg-white/40 min-h-[148px]">
                                <p class="text-xs font-bold text-gray-400 mb-4 uppercase tracking-wider">April 2024</p>
                                <div class="space-y-3">
                                    <div
                                        class="flex items-center justify-between p-3 bg-white/60 rounded-xl hover:shadow-sm transition-all border border-gray-100">
                                        <div class="flex items-center gap-4">
                                            <span class="text-sm font-bold text-[#2d6a4f]">B-01</span>
                                            <span class="text-sm font-semibold text-gray-700">Tuberculosis</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-green-500" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                            </svg>
                                            <span class="text-xs font-bold text-gray-500 uppercase">2 Mar</span>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center justify-between p-3 bg-white/60 rounded-xl hover:shadow-sm transition-all border border-gray-100">
                                        <div class="flex items-center gap-4">
                                            <span class="text-sm font-bold text-[#2d6a4f]">B-16</span>
                                            <span class="text-sm font-semibold text-gray-700">Brucellosis</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-blue-500" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                            </svg>
                                            <span class="text-xs font-bold text-gray-500 uppercase">10 Mar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Health Tab Content -->
                <div id="content-health" class="tab-content hidden transition-all duration-500">
                    <div class="flex justify-between items-center mb-8">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-8 bg-blue-500 rounded-full"></span>
                            <h4 class="text-xl font-bold text-gray-800">Breeding Bulls</h4>
                        </div>
                        <a href="#"
                            class="btn-green-dark px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                            View All Bulls
                            <span class="text-lg leading-none">›</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Bull Card 1 -->
                        <div class="cow-sub-card p-5 flex gap-5 bg-white/40">
                            <div class="w-1/3 h-full min-h-[140px] rounded-2xl overflow-hidden shadow-sm">
                                <img src="{{ asset('images/dashboard2/bull1.png') }}" alt="Bull"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="w-2/3 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <h5 class="text-xl font-bold text-gray-800">B-08</h5>
                                        <span
                                            class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full uppercase">Active</span>
                                    </div>
                                    <div class="mt-2 space-y-0.5 text-xs font-semibold text-gray-500">
                                        <p>Breed: <span class="text-gray-800">Ongole</span></p>
                                        <p>Performance: <span class="text-green-600">Excellent</span></p>
                                    </div>
                                </div>
                                <button
                                    class="btn-green-dark mt-4 py-2 w-full rounded-xl text-xs font-bold flex items-center justify-center gap-2">
                                    View Performance <span class="text-lg leading-none">›</span>
                                </button>
                            </div>
                        </div>
                        <!-- Bull Card 2 -->
                        <div class="cow-sub-card p-5 flex gap-5 bg-white/40">
                            <div class="w-1/3 h-full min-h-[140px] rounded-2xl overflow-hidden shadow-sm">
                                <img src="{{ asset('images/dashboard2/bull2.png') }}" alt="Bull"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="w-2/3 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <h5 class="text-xl font-bold text-gray-800">B-12</h5>
                                        <span
                                            class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full uppercase">Proven</span>
                                    </div>
                                    <div class="mt-2 space-y-0.5 text-xs font-semibold text-gray-500">
                                        <p>Breed: <span class="text-gray-800">Sahiwal</span></p>
                                        <p>Performance: <span class="text-green-600">High Yield</span></p>
                                    </div>
                                </div>
                                <button
                                    class="btn-green-dark mt-4 py-2 w-full rounded-xl text-xs font-bold flex items-center justify-center gap-2">
                                    View Performance <span class="text-lg leading-none">›</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feed Tab Content -->
                <div id="content-feed" class="tab-content hidden transition-all duration-500">
                    <div class="flex justify-between items-center mb-8">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-8 bg-orange-500 rounded-full"></span>
                            <h4 class="text-xl font-bold text-gray-800">Recent Calves</h4>
                        </div>
                        <a href="#"
                            class="btn-green-dark px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                            View All Calves
                            <span class="text-lg leading-none">›</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Calf Card 1 -->
                        <div class="cow-sub-card p-5 flex gap-5 bg-white/40">
                            <div class="w-1/3 h-full min-h-[140px] rounded-2xl overflow-hidden shadow-sm">
                                <img src="{{ asset('images/dashboard2/calf1.png') }}" alt="Calf"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="w-2/3 flex flex-col justify-between">
                                <div>
                                    <h5 class="text-xl font-bold text-gray-800">CL-45</h5>
                                    <div class="mt-2 space-y-0.5 text-xs font-semibold text-gray-500">
                                        <p>Gender: <span class="text-gray-800">Female</span></p>
                                        <p>DOB: <span class="text-gray-800">12/03/2023</span></p>
                                        <p>Status: <span class="text-orange-600">Healthy</span></p>
                                    </div>
                                </div>
                                <button
                                    class="btn-green-dark mt-4 py-2 w-full rounded-xl text-xs font-bold flex items-center justify-center gap-2">
                                    Growth Chart <span class="text-lg leading-none">›</span>
                                </button>
                            </div>
                        </div>
                        <!-- Calf Card 2 -->
                        <div class="cow-sub-card p-5 flex gap-5 bg-white/40">
                            <div class="w-1/3 h-full min-h-[140px] rounded-2xl overflow-hidden shadow-sm">
                                <img src="{{ asset('images/dashboard2/calf2.png') }}" alt="Calf"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="w-2/3 flex flex-col justify-between">
                                <div>
                                    <h5 class="text-xl font-bold text-gray-800">CL-52</h5>
                                    <div class="mt-2 space-y-0.5 text-xs font-semibold text-gray-500">
                                        <p>Gender: <span class="text-gray-800">Male</span></p>
                                        <p>DOB: <span class="text-gray-800">18/02/2023</span></p>
                                        <p>Status: <span class="text-orange-600">Healthy</span></p>
                                    </div>
                                </div>
                                <button
                                    class="btn-green-dark mt-4 py-2 w-full rounded-xl text-xs font-bold flex items-center justify-center gap-2">
                                    Growth Chart <span class="text-lg leading-none">›</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .active-tab-card {
            border-color: #2d6a4f !important;
            background: rgba(255, 255, 255, 1) !important;
            box-shadow: 0 10px 40px rgba(45, 106, 79, 0.15) !important;
            transform: scale(1.02);
        }

        .tab-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tab-card:hover:not(.active-tab-card) {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
        }

        .tab-content {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        function switchTab(tabId) {
            // Hide all contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active style from all cards
            document.querySelectorAll('.tab-card').forEach(card => {
                card.classList.remove('active-tab-card');
            });

            // Show selected content
            document.getElementById('content-' + tabId).classList.remove('hidden');

            // Add active style to selected card
            document.getElementById('tab-' + tabId).classList.add('active-tab-card');
        }
        var options = {
            series: [{
                name: 'Milk Yield (Liters)',
                data: [520, 600, 680, 810, 780, 890, 1020, 880, 750, 720]
            }],
            chart: {
                type: 'area',
                height: 400,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 4,
                colors: ['#2d6a4f']
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100],
                    colorStops: [{
                            offset: 0,
                            color: '#40916c',
                            opacity: 0.6
                        },
                        {
                            offset: 100,
                            color: '#d8f3dc',
                            opacity: 0.1
                        }
                    ]
                }
            },
            markers: {
                size: 6,
                colors: ['#fff'],
                strokeColors: '#2d6a4f',
                strokeWidth: 3,
                hover: {
                    size: 8,
                }
            },
            xaxis: {
                categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                min: 500,
                max: 1200,
                tickAmount: 4,
                labels: {
                    formatter: function(val) {
                        return val.toFixed(0);
                    }
                }
            },
            grid: {
                borderColor: '#e0e0e0',
                strokeDashArray: 4,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            theme: {
                mode: 'light',
            }
        };

        var chart = new ApexCharts(document.querySelector("#milk-chart"), options);
        chart.render();
    </script>
</body>

</html>
