<!-- Sidebar Navigation -->
<nav class="md:hidden sidebar-container bg-white w-full md:w-64 h-16 md:h-auto fixed bottom-0 md:relative z-20 border-t md:border-t-0 md:border-r border-gray-200">
    <div class="h-full flex flex-col">
        <div class="md:hidden flex justify-around items-center h-full">
            <a href="{{ route('hod.dashboard') }}" class="flex flex-col items-center p-2 text-primary-500">
                <i class="fas fa-home"></i>
                <span class="text-xs mt-1">Home</span>
            </a>
            <a href="{{ route('hod.teachers.view') }}" class="flex flex-col items-center p-2 text-gray-500 hover:text-primary-500">
                <i class="fas fa-chalkboard-teacher"></i>
                <span class="text-xs mt-1">Teachers</span>
            </a>
            <a href="{{ route('hod.courses.content') }}" class="flex flex-col items-center p-2 text-gray-500 hover:text-primary-500">
                <i class="fas fa-book"></i>
                <span class="text-xs mt-1">Contents</span>
            </a>
            <a href="{{ route('hod.exams.create') }}" class="flex flex-col items-center p-2 text-gray-500 hover:text-primary-500">
                <i class="fas fa-chalkboard-teacher mr-2"></i> 
                <span class="text-xs mt-1">Junior Lec</span>
            </a>
            <a href="{{ route('hod.courses.allocation') }}" class="flex flex-col items-center p-2 text-gray-500 hover:text-primary-500">
                <i class="fas fa-tasks mr-2"></i>
                <span class="text-xs mt-1">Allocations</span>
            </a>
        </div>
    </div>
</nav>