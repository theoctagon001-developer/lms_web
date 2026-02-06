<!-- resources/views/HOD/partials/drawer.blade.php -->
<div id="mobile-drawer" class="fixed inset-0 z-50 hidden transition-opacity duration-300">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-gray-500 bg-opacity-75" onclick="toggleDrawer()"></div>
    <div class="relative flex flex-col w-80 h-full bg-white shadow-xl transform transition-transform duration-300 ease-in-out -translate-x-full">
        <!-- Drawer header -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center mr-2">
                    <img src="/images/home.png" class="w-5 h-5 filter brightness-0 invert" alt="Logo">
                </div>
                <h2 class="text-lg font-semibold text-gray-800">Academic Portal</h2>
            </div>
            <button type="button" onclick="toggleDrawer()" class="rounded-md p-1 text-gray-400 hover:text-gray-500 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="overflow-y-auto flex-grow py-2 px-3">
            <ul class="flex flex-col space-y-1">
                <li class="px-2">
                    <div class="flex flex-row items-center h-8">
                        <div class="text-sm font-light tracking-wide text-gray-500">Menu</div>
                    </div>
                </li>
                <li>
                    <a href="{{ route('hod.dashboard') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 {{ request()->routeIs('hod.dashboard') ? 'border-indigo-500 bg-gray-50' : 'border-transparent' }} hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Dashboard</span>
                    </a>
                </li>
                
                <!-- Management Section -->
                <li class="px-2">
                    <div class="flex flex-row items-center h-8">
                        <div class="text-sm font-light tracking-wide text-gray-500">Management</div>
                    </div>
                </li>
                <li>
                    <a href="{{ route('hod.teachers.add') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 {{ request()->routeIs('hod.teachers.add') ? 'border-indigo-500 bg-gray-50' : 'border-transparent' }} hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <img src="/images/icons8-teacher-50.png" class="w-5 h-5 filter brightness-0 opacity-70">
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Teacher Add</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hod.juniors.add') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 {{ request()->routeIs('hod.juniors.add') ? 'border-indigo-500 bg-gray-50' : 'border-transparent' }} hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <img src="/images/junior.png" class="w-5 h-5 filter brightness-0 opacity-70">
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Junior Lecturer</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hod.courses.add') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 {{ request()->routeIs('hod.courses.add') ? 'border-indigo-500 bg-gray-50' : 'border-transparent' }} hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <img src="/images/course.png" class="w-5 h-5 filter brightness-0 opacity-70">
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Course Add</span>
                    </a>
                </li>

                <!-- Allocation Section -->
                <li class="px-2">
                    <div class="flex flex-row items-center h-8">
                        <div class="text-sm font-light tracking-wide text-gray-500">Allocation</div>
                    </div>
                </li>
                <li>
                    <a href="{{ route('hod.courses.allocation') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 {{ request()->routeIs('hod.courses.allocation') ? 'border-indigo-500 bg-gray-50' : 'border-transparent' }} hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <img src="/images/course allocation.png" class="w-5 h-5 filter brightness-0 opacity-70">
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Course Allocation</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hod.juniors.allocation') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 {{ request()->routeIs('hod.juniors.allocation') ? 'border-indigo-500 bg-gray-50' : 'border-transparent' }} hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <img src="/images/course allocation.png" class="w-5 h-5 filter brightness-0 opacity-70">
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Junior Allocation</span>
                    </a>
                </li>

                <!-- Content & Exams Section -->
                <li class="px-2">
                    <div class="flex flex-row items-center h-8">
                        <div class="text-sm font-light tracking-wide text-gray-500">Content & Exams</div>
                    </div>
                </li>
                <li>
                    <a href="{{ route('hod.courses.content') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 {{ request()->routeIs('hod.courses.content') ? 'border-indigo-500 bg-gray-50' : 'border-transparent' }} hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <img src="/images/content.png" class="w-5 h-5 filter brightness-0 opacity-70">
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Course Content</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hod.exams.create') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 {{ request()->routeIs('hod.exams.create') ? 'border-indigo-500 bg-gray-50' : 'border-transparent' }} hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <img src="/images/exam.png" class="w-5 h-5 filter brightness-0 opacity-70">
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Exam Creation</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hod.courses.content.copy') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 {{ request()->routeIs('hod.courses.content.copy') ? 'border-indigo-500 bg-gray-50' : 'border-transparent' }} hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <img src="/images/session.png" class="w-5 h-5 filter brightness-0 opacity-70">
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Copy Content</span>
                    </a>
                </li>

                <!-- Sessions & Archives Section -->
                <li class="px-2">
                    <div class="flex flex-row items-center h-8">
                        <div class="text-sm font-light tracking-wide text-gray-500">Sessions & Archives</div>
                    </div>
                </li>
                <li>
                    <a href="{{ route('hod.sessions.add') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 {{ request()->routeIs('hod.sessions.add') ? 'border-indigo-500 bg-gray-50' : 'border-transparent' }} hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <img src="/images/session.png" class="w-5 h-5 filter brightness-0 opacity-70">
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Add Sessions</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hod.archives.manage') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 {{ request()->routeIs('hod.archives.manage') ? 'border-indigo-500 bg-gray-50' : 'border-transparent' }} hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <img src="/images/archives.png" class="w-5 h-5 filter brightness-0 opacity-70">
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Manage Archives</span>
                    </a>
                </li>

                <!-- Settings Section -->
                <li class="px-2">
                    <div class="flex flex-row items-center h-8">
                        <div class="text-sm font-light tracking-wide text-gray-500">Settings</div>
                    </div>
                </li>
                <li>
                   
                    <a href="{{ route('logout1') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-indigo-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    // Toggle drawer function
    function toggleDrawer() {
        const drawer = document.getElementById('mobile-drawer');
        const drawerPanel = drawer.querySelector('div:last-child');
        
        if (drawer.classList.contains('hidden')) {
            // Open drawer
            drawer.classList.remove('hidden');
            setTimeout(() => {
                drawerPanel.classList.remove('-translate-x-full');
            }, 20);
        } else {
            // Close drawer
            drawerPanel.classList.add('-translate-x-full');
            setTimeout(() => {
                drawer.classList.add('hidden');
            }, 300);
        }
    }

    // Close drawer when clicking on any link
    document.querySelectorAll('#mobile-drawer a').forEach(link => {
        link.addEventListener('click', () => {
            toggleDrawer();
        });
    });

    // Initialize active sections
    document.addEventListener('DOMContentLoaded', function() {
        // Automatically close drawer on desktop view
        function handleResize() {
            if (window.innerWidth >= 768) { // md breakpoint
                const drawer = document.getElementById('mobile-drawer');
                const drawerPanel = drawer.querySelector('div:last-child');
                drawer.classList.add('hidden');
                drawerPanel.classList.add('-translate-x-full');
            }
        }

        // Run on load and on resize
        handleResize();
        window.addEventListener('resize', handleResize);
    });
</script>