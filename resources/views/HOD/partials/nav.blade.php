<!-- Professional Collapsible Sidebar Navigation (Hidden on Mobile) -->
<nav class="sidebar-container hidden md:flex flex-col bg-gradient-to-b from-gray-50 to-white w-64 h-screen fixed z-20 border-r border-gray-200 shadow-sm">
<!-- Professional Sidebar Navigation -->
<div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-gray-50 text-gray-800">
    <div class="fixed flex flex-col top-0 left-0 w-64 bg-white h-full border-r">
      <div class="flex items-center justify-center h-14 border-b">
        <div>Academic Portal - HOD Panel</div>
      </div>
      <div class="overflow-y-auto overflow-x-hidden flex-grow">
        <ul class="flex flex-col py-4 space-y-1">
          <li class="px-5">
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
          <li class="px-5">
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
          <li class="px-5">
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
          <li class="px-5">
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
          <li class="px-5">
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
          <li class="px-5">
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
</nav>

<script>
    // Toggle section panels
    function toggleSection(sectionId) {
        const panel = document.getElementById(`${sectionId}-panel`);
        const arrow = document.getElementById(`${sectionId}-arrow`);
        
        panel.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
        
        // Store state in localStorage
        const isOpen = !panel.classList.contains('hidden');
        localStorage.setItem(`sidebar-${sectionId}-open`, isOpen);
    }
    
    // Initialize sections based on localStorage and current route
    document.addEventListener('DOMContentLoaded', function() {
        ['management', 'allocation', 'content', 'sessions'].forEach(section => {
            const panel = document.getElementById(`${section}-panel`);
            const arrow = document.getElementById(`${section}-arrow`);
            const isOpen = localStorage.getItem(`sidebar-${section}-open`) === 'true';
            
            // Check if any child link is active
            const hasActiveChild = panel.querySelector('a.bg-primary-50') !== null;
            
            if (isOpen || hasActiveChild) {
                panel.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            }
        });
    });
</script>