<div>
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

        .nav-group-items {
            max-height: 500px;
            overflow: hidden;
            transition: max-height 0.3s ease, opacity 0.25s ease;
            opacity: 1;
        }

        .nav-group-items.collapsed {
            max-height: 0;
            opacity: 0;
            padding-bottom: 0 !important;
        }

        .nav-chevron.rotated {
            transform: rotate(180deg);
        }
    </style>
<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Mobile Header -->
    <div class="md:hidden flex items-center justify-between p-4 bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 bg-[#f59e0b] rounded-lg flex items-center justify-center text-white font-black text-xl shadow-sm">
                C</div>
            <span class="font-bold text-gray-900 tracking-tight">Cow Management</span>
        </div>
        <button onclick="toggleSidebar()" class="p-2 text-gray-400 hover:bg-gray-100 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-40 w-72 md:relative md:translate-x-0 -translate-x-full transition-transform duration-300 ease-in-out">
        <div
            class="h-full flex flex-col glass-card m-0 rounded-none border-y-0 border-l-0 border-r border-white/50 bg-white/40 backdrop-blur-2xl">
            <!-- Sidebar Header -->
            <div class="p-8 pb-4 flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-[#2d6a4f] to-[#40916c] rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-900/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L4 9v12h16V9l-8-6z" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-[#1b4332] tracking-tighter">COW MGT</h1>
                    <p class="text-[10px] font-black text-green-600 uppercase tracking-widest">Premium System</p>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex-grow overflow-y-auto px-4 py-4 space-y-2">
                <!-- Dashboard -->
                <div class="space-y-1">
                    <a href="/admin"
                        class="flex items-center gap-3 px-4 py-3 text-[#f59e0b] bg-[#fff8eb] rounded-xl transition-all group">
                        <!-- heroicon-o-home -->
                        <svg class="w-5 h-5 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
                            </path>
                        </svg>
                        <span class="font-semibold text-sm">Dashboard</span>
                    </a>
                </div>

                <!-- Operations & Finance -->
                <div class="nav-group">
                    <button onclick="toggleNavGroup(this)"
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-500 hover:text-gray-700 transition-all">
                        <span class="text-[11px] font-bold uppercase tracking-[0.15em]">Operations & Finance</span>
                        <svg class="w-4 h-4 transition-transform duration-200 nav-chevron" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"></path>
                        </svg>
                    </button>
                    <div class="nav-group-items space-y-0.5 pb-2">
                        <a href="/admin/milk-productions"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-sparkles -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Milk Productions</span>
                        </a>
                        <a href="/admin/feed-purchases"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-truck -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Feed Stock/Purchase</span>
                        </a>
                        <a href="/admin/feed-allocations"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-clipboard-document-list -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15a2.25 2.25 0 0 1 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Feed Allocations</span>
                        </a>
                        <a href="/admin/expenses"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-banknotes -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Other Expenses</span>
                        </a>
                        <a href="/admin/salary-payments"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-credit-card -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Salary Payments</span>
                        </a>
                    </div>
                </div>

                <!-- Health & Breeding -->
                <div class="nav-group">
                    <button onclick="toggleNavGroup(this)"
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-500 hover:text-gray-700 transition-all">
                        <span class="text-[11px] font-bold uppercase tracking-[0.15em]">Health & Breeding</span>
                        <svg class="w-4 h-4 transition-transform duration-200 nav-chevron" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5">
                            </path>
                        </svg>
                    </button>
                    <div class="nav-group-items space-y-0.5 pb-2">
                        <a href="/admin/treatments"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-beaker -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Treatments</span>
                        </a>
                        <a href="/admin/vaccinations"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-shield-check -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Vaccinations</span>
                        </a>
                        <a href="/admin/inseminations"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-check-badge -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Inseminations</span>
                        </a>
                        <a href="/admin/semen-stocks"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-archive-box -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Semen Stocks</span>
                        </a>
                        <a href="/admin/cryocans"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-battery-100 -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 10.5h.375c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125H21M3.75 18h15A2.25 2.25 0 0 0 21 15.75v-6a2.25 2.25 0 0 0-2.25-2.25h-15A2.25 2.25 0 0 0 1.5 9.75v6A2.25 2.25 0 0 0 3.75 18ZM3.75 7.5v10.5">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Cryocans</span>
                        </a>
                    </div>
                </div>

                <!-- Personnel Management -->
                <div class="nav-group">
                    <button onclick="toggleNavGroup(this)"
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-500 hover:text-gray-700 transition-all">
                        <span class="text-[11px] font-bold uppercase tracking-[0.15em]">Personnel Management</span>
                        <svg class="w-4 h-4 transition-transform duration-200 nav-chevron" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5">
                            </path>
                        </svg>
                    </button>
                    <div class="nav-group-items space-y-0.5 pb-2">
                        <a href="/admin/staff"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-identification -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15A2.25 2.25 0 0 0 2.25 6.75v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Staff</span>
                        </a>
                        <a href="/admin/veterinarians"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-user-plus -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Veterinarians</span>
                        </a>
                    </div>
                </div>

                <!-- Resources & Setup -->
                <div class="nav-group border-t border-gray-100 pt-2">
                    <button onclick="toggleNavGroup(this)"
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-500 hover:text-gray-700 transition-all">
                        <span class="text-[11px] font-bold uppercase tracking-[0.15em]">Resources & Setup</span>
                        <svg class="w-4 h-4 transition-transform duration-200 nav-chevron" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5">
                            </path>
                        </svg>
                    </button>
                    <div class="nav-group-items space-y-0.5 pb-2">
                        <a href="/admin/cows"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-user-group -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-3.833-6.242 4.125 4.125 0 0 0-3.833 6.242Zm-8.94 0A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Cows</span>
                        </a>
                        <a href="/admin/feeds"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-shopping-bag -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Feeds</span>
                        </a>
                        <a href="/admin/expense-items"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-list-bullet -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-3.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Expense Items</span>
                        </a>
                        <a href="/admin/expense-categories"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-folder -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.625-1.125h.008V12h-.008v-.375Zm-3 0h.008V12h-.008v-.375Zm-3 0h.008V12h-.008v-.375m16.5 0h.008V12h-.008v-.375m1.375 3.375a1.5 1.5 0 0 1-1.5 1.5H1.5a1.5 1.5 0 0 1-1.5-1.5v-2.25h24v2.25Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Expense Categories</span>
                        </a>
                        <a href="/admin/breeds"
                            class="flex items-center gap-3 px-4 py-2.5 text-gray-600 hover:text-[#f59e0b] hover:bg-[#fff8eb] rounded-xl transition-all group">
                            <!-- heroicon-o-list-bullet -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#f59e0b]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-3.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z">
                                </path>
                            </svg>
                            <span class="font-medium text-sm">Breeds</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-6 border-t border-white/50">
                <div class="flex items-center gap-3 px-4 py-4 bg-white/40 rounded-2xl border border-white/60 group relative">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-tr from-green-100 to-green-50 border border-green-200 flex items-center justify-center flex-shrink-0">
                        <span class="text-green-700 font-bold text-sm">{{ auth()->user() ? substr(auth()->user()->name, 0, 2) : 'JC' }}</span>
                    </div>
                    <div class="flex-grow min-w-0">
                        <p class="text-xs font-bold text-gray-800 truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="text-[9px] font-bold text-gray-400 uppercase truncate">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                    </div>
                    <form method="POST" action="{{ filament()->getLogoutUrl() }}" class="absolute right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        @csrf
                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Overlay -->
    <div id="sidebar-overlay" onclick="toggleSidebar()"
        class="fixed inset-0 z-30 bg-black/20 backdrop-blur-sm hidden md:hidden"></div>

    <!-- Main Content -->
    <main class="flex-grow p-6 md:p-12 overflow-x-hidden">
        <div class="max-w-7xl mx-auto">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Total Cows -->
                <a href="/admin/cows?filters[gender][value]=Female"
                    class="stat-card glass-card rounded-3xl p-6 flex items-center gap-5 border-none shadow-lg">
                    <div class="w-20 h-20 flex-shrink-0 bg-green-50 rounded-2xl p-2">
                        <img src="{{ asset('images/dashboard2/cow.png') }}" alt="Cow"
                            class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest">Total Cows</h3>
                        <p class="text-4xl font-extrabold text-[#2d6a4f]">{{ $totalCows }}</p>
                    </div>
                </a>

                <!-- Total Bulls -->
                <a href="/admin/cows?filters[gender][value]=Male"
                    class="stat-card glass-card rounded-3xl p-6 flex items-center gap-5 border-none shadow-lg">
                    <div class="w-20 h-20 flex-shrink-0 bg-blue-50 rounded-2xl p-2">
                        <img src="{{ asset('images/dashboard2/bull.png') }}" alt="Bull"
                            class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest">Total Bulls</h3>
                        <p class="text-4xl font-extrabold text-[#2d6a4f]">{{ $totalBulls }}</p>
                    </div>
                </a>

                <!-- Total Calves -->
                <a href="/admin/cows?filters[animal_classification][value]=Calf"
                    class="stat-card glass-card rounded-3xl p-6 flex items-center gap-5 border-none shadow-lg">
                    <div class="w-20 h-20 flex-shrink-0 bg-orange-50 rounded-2xl p-2">
                        <img src="{{ asset('images/dashboard2/calf.png') }}" alt="Calf"
                            class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest">Total Calves</h3>
                        <p class="text-4xl font-extrabold text-[#2d6a4f]">{{ $totalCalves }}</p>
                    </div>
                </a>

                <!-- Today's Milk Yield -->
                <a href="/admin/milk-productions"
                    class="stat-card glass-card rounded-3xl p-6 flex items-center gap-5 border-none shadow-lg relative overflow-hidden">
                    <div class="w-20 h-20 flex-shrink-0 bg-green-50 rounded-2xl p-2">
                        <img src="{{ asset('images/dashboard2/milk.png') }}" alt="Milk"
                            class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest">Today's Yield</h3>
                        <div class="flex items-baseline gap-1">
                            <p class="text-4xl font-extrabold text-[#2d6a4f]">{{ number_format($todayYield, 0) }}</p>
                            <span class="text-[#40916c] font-black text-xl">L</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Milk Production Overview -->
            <div class="chart-container glass-card p-10 rounded-[40px] mb-10 shadow-xl border-none transition-all duration-300">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 cursor-pointer group" onclick="toggleMilkProduction()">
                    <div>
                        <h2 class="text-3xl font-black text-gray-800 tracking-tight group-hover:text-[#2d6a4f] transition-colors">Milk Production</h2>
                        <p class="text-gray-400 text-sm font-bold uppercase tracking-widest mt-1">Weekly Performance
                            Overview</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex gap-4">
                            <div class="px-4 py-2 bg-green-50 rounded-xl border border-green-100">
                                <p class="text-[10px] font-bold text-green-600 uppercase">Avg Yield</p>
                                <p class="text-lg font-black text-[#2d6a4f]">{{ number_format($avgYield, 1) }} L</p>
                            </div>
                            <div
                                class="px-4 py-2 bg-{{ $trend >= 0 ? 'green' : 'red' }}-50 rounded-xl border border-{{ $trend >= 0 ? 'green' : 'red' }}-100">
                                <p class="text-[10px] font-bold text-{{ $trend >= 0 ? 'green' : 'red' }}-400 uppercase">
                                    Trend
                                </p>
                                <p class="text-lg font-black text-{{ $trend >= 0 ? 'green' : 'red' }}-700">
                                    {{ $trend >= 0 ? '+' : '' }}{{ number_format($trend, 1) }}%</p>
                            </div>
                        </div>
                        <div class="p-2 bg-gray-50 rounded-full group-hover:bg-green-50 transition-colors ml-2 hidden sm:block">
                            <svg id="milk-production-chevron" class="w-6 h-6 text-gray-500 group-hover:text-[#2d6a4f] transition-transform duration-300 transform rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div id="milk-production-content" class="transition-all duration-500 overflow-hidden" style="max-height: 0px; opacity: 0;">
                    <div id="milk-chart" class="w-full h-[400px]"></div>
                </div>
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
                                    <a href="/admin/cows?filters[status][value]=Pregnant"
                                        class="btn-green-dark px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                                        View All
                                        <span class="text-lg leading-none">›</span>
                                    </a>
                                </div>

                                @if ($pregnantCows->count() > 0)
                                    @php $featured = $pregnantCows->first(); @endphp
                                    <div class="cow-sub-card p-5 flex gap-6 bg-white/40">
                                        <div class="w-32 h-32 flex-shrink-0 rounded-2xl overflow-hidden shadow-md">
                                            <img src="{{ $featured->thumbnail ? asset('uploads/' . $featured->thumbnail) : ($featured->images && count($featured->images) ? asset('uploads/' . $featured->images[0]) : asset('images/dashboard2/cow1.png')) }}"
                                                alt="Cow" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-grow flex flex-col justify-between">
                                            <div>
                                                <h5 class="text-2xl font-bold text-gray-800">
                                                    {{ $featured->name ?: $featured->tag_number }}
                                                </h5>
                                                <div class="mt-2 space-y-0.5 text-sm">
                                                    <p class="text-gray-500">Tag: <span
                                                            class="text-gray-800 font-semibold ml-1">{{ $featured->tag_number }}</span>
                                                    </p>
                                                    <p class="text-gray-500">Breed: <span
                                                            class="text-gray-800 font-semibold ml-1">{{ $featured->breed->name ?? '-' }}</span>
                                                    </p>
                                                    <p class="text-gray-500">Age: <span
                                                            class="text-gray-800 font-semibold ml-1">{{ $featured->age }}</span>
                                                    </p>
                                                    <p class="text-gray-500">Last Calving: <span
                                                            class="text-[#2d6a4f] font-bold ml-1">{{ $featured->last_calving_date ? $featured->last_calving_date->format('d M Y') : '-' }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex gap-2 mt-4">
                                                <a href="/admin/cows/{{ $featured->id }}"
                                                    class="bg-[#2d6a4f] text-white py-2 px-5 rounded-xl text-xs font-bold hover:bg-[#1b4332] shadow-sm transition-all">View
                                                    Details</a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="cow-sub-card p-10 text-center text-gray-400">
                                        No pregnant cows recorded.
                                    </div>
                                @endif
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
                                    <a href="/admin/feed-allocations"
                                        class="btn-green-dark px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                                        View All
                                        <span class="text-lg leading-none">›</span>
                                    </a>
                                </div>

                                <div
                                    class="cow-sub-card p-5 flex justify-between items-center bg-white/40 min-h-[148px]">
                                    <div class="space-y-3">
                                        @foreach ($feedSummary as $feed)
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                                    <div class="w-5 h-5 bg-green-500/30 rounded"></div>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-gray-400">{{ $feed->name }}</p>
                                                    <p class="text-sm font-bold text-gray-700">
                                                        {{ number_format($feed->quantity_in_stock, 0) }} {{ $feed->unit_label }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ($feedSummary->count() == 0)
                                            <p class="text-gray-400 text-sm italic">No stock data available</p>
                                        @endif
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
                                    <a href="/admin/inseminations"
                                        class="btn-green-dark px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                                        View All
                                        <span class="text-lg leading-none">›</span>
                                    </a>
                                </div>

                                <div class="cow-sub-card p-5 flex items-center gap-8 bg-white/40 min-h-[148px]">
                                    <div class="text-center">
                                        <p class="text-6xl font-extrabold text-[#2d6a4f] leading-none">12</p>
                                        <p class="text-xs font-bold text-gray-500 uppercase mt-2 tracking-widest">To
                                            Check
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
                                        <h4 class="text-xl font-bold text-[#2d6a4f]">Vaccinations</h4>
                                    </div>
                                    <a href="/admin/vaccinations"
                                        class="btn-green-dark px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                                        View All
                                        <span class="text-lg leading-none">›</span>
                                    </a>
                                </div>

                                <div class="cow-sub-card p-5 bg-white/40 min-h-[148px]">
                                    <p class="text-xs font-bold text-gray-400 mb-4 uppercase tracking-wider">Upcoming
                                        Tasks
                                    </p>
                                    <div class="space-y-3">
                                        @foreach ($upcomingVaccinations as $vac)
                                            <div
                                                class="flex items-center justify-between p-3 bg-white/60 rounded-xl hover:shadow-sm transition-all border border-gray-100">
                                                <div class="flex items-center gap-4">
                                                    <span
                                                        class="text-sm font-bold text-[#2d6a4f]">{{ $vac->cow->tag_number }}</span>
                                                    <span
                                                        class="text-sm font-semibold text-gray-700 truncate max-w-[120px]">{{ $vac->vaccine_name }}</span>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <span
                                                        class="text-xs font-bold text-gray-500 uppercase">{{ $vac->next_due_date ? $vac->next_due_date->format('d M') : '-' }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ($upcomingVaccinations->count() == 0)
                                            <p class="text-gray-400 text-sm italic">No records found</p>
                                        @endif
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
                            <a href="/admin/cows?filters[animal_classification][value]=Bull"
                                class="btn-green-dark px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                                View All Bulls
                                <span class="text-lg leading-none">›</span>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach ($breedingBulls as $bull)
                                <div class="cow-sub-card p-5 flex gap-5 bg-white/40">
                                    <div class="w-1/3 h-full min-h-[140px] rounded-2xl overflow-hidden shadow-sm">
                                        <img src="{{ $bull->thumbnail ? asset('uploads/' . $bull->thumbnail) : ($bull->images && count($bull->images) ? asset('uploads/' . $bull->images[0]) : asset('images/dashboard2/bull1.png')) }}"
                                            alt="Bull" class="w-full h-full object-cover">
                                    </div>
                                    <div class="w-2/3 flex flex-col justify-between">
                                        <div>
                                            <div class="flex justify-between items-start">
                                                <h5 class="text-xl font-bold text-gray-800">{{ $bull->name ?: $bull->tag_number }}</h5>
                                                <span
                                                    class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full uppercase">{{ $bull->status }}</span>
                                            </div>
                                            <div class="mt-2 space-y-0.5 text-xs font-semibold text-gray-500">
                                                <p>Breed: <span class="text-gray-800">{{ $bull->breed->name ?? '-' }}</span></p>
                                                <p>Tag: <span class="text-gray-800">{{ $bull->tag_number }}</span></p>
                                                <p>Age: <span class="text-gray-800">{{ $bull->age }}</span></p>
                                            </div>
                                        </div>
                                        <a href="/admin/cows/{{ $bull->id }}"
                                            class="btn-green-dark mt-4 py-2 w-full rounded-xl text-xs font-bold flex items-center justify-center gap-2">
                                            View Details <span class="text-lg leading-none">›</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Feed Tab Content -->
                    <div id="content-feed" class="tab-content hidden transition-all duration-500">
                        <div class="flex justify-between items-center mb-8">
                            <div class="flex items-center gap-3">
                                <span class="w-2 h-8 bg-orange-500 rounded-full"></span>
                                <h4 class="text-xl font-bold text-gray-800">Recent Calves</h4>
                            </div>
                            <a href="/admin/cows?filters[animal_classification][value]=Calf"
                                class="btn-green-dark px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
                                View All Calves
                                <span class="text-lg leading-none">›</span>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach ($recentCalves as $calf)
                                <div class="cow-sub-card p-5 flex gap-5 bg-white/40">
                                    <div class="w-1/3 h-full min-h-[140px] rounded-2xl overflow-hidden shadow-sm">
                                        <img src="{{ $calf->thumbnail ? asset('uploads/' . $calf->thumbnail) : ($calf->images && count($calf->images) ? asset('uploads/' . $calf->images[0]) : asset('images/dashboard2/calf1.png')) }}"
                                            alt="Calf" class="w-full h-full object-cover">
                                    </div>
                                    <div class="w-2/3 flex flex-col justify-between">
                                        <div>
                                            <h5 class="text-xl font-bold text-gray-800">{{ $calf->name ?: $calf->tag_number }}</h5>
                                            <div class="mt-2 space-y-0.5 text-xs font-semibold text-gray-500">
                                                <p>Gender: <span class="text-gray-800">{{ $calf->gender }}</span></p>
                                                <p>Tag: <span class="text-gray-800">{{ $calf->tag_number }}</span></p>
                                                <p>DOB: <span
                                                        class="text-gray-800">{{ $calf->dob->format('d M Y') }}</span>
                                                </p>
                                                <p>Age: <span class="text-orange-600">{{ $calf->age }}</span></p>
                                            </div>
                                        </div>
                                        <a href="/admin/cows/{{ $calf->id }}"
                                            class="btn-green-dark mt-4 py-2 w-full rounded-xl text-xs font-bold flex items-center justify-center gap-2">
                                            View Details <span class="text-lg leading-none">›</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
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
                    data: {!! json_encode($chartData) !!}
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
                    categories: {!! json_encode($chartLabels) !!},
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    min: 0,
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
                    palette: 'palette1',
                }
            };

            var chart = new ApexCharts(document.querySelector("#milk-chart"), options);
            chart.render();
        </script>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleNavGroup(button) {
            const group = button.closest('.nav-group');
            const items = group.querySelector('.nav-group-items');
            const chevron = button.querySelector('.nav-chevron');
            items.classList.toggle('collapsed');
            chevron.classList.toggle('rotated');
        }

        function toggleMilkProduction() {
            const content = document.getElementById('milk-production-content');
            const chevron = document.getElementById('milk-production-chevron');
            
            if (content.style.maxHeight === '0px') {
                content.style.maxHeight = '500px';
                content.style.opacity = '1';
                chevron.classList.add('rotate-180');
                chevron.classList.remove('rotate-0');
            } else {
                content.style.maxHeight = '0px';
                content.style.opacity = '0';
                chevron.classList.remove('rotate-180');
                chevron.classList.add('rotate-0');
            }
        }
    </script>
</div></div>



