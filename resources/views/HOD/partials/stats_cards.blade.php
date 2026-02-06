<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Faculty Count -->
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Faculty Members</p>
                <p class="text-2xl font-semibold text-gray-800">{{ session('faculty_count', 0) }}</p>
            </div>
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-chalkboard-teacher text-xl"></i>
            </div>
        </div>
        <a href="{{ route('hod.teachers.view') }}" class="mt-2 inline-flex items-center text-sm text-blue-500 hover:text-blue-700">
            View all <i class="fas fa-chevron-right ml-1"></i>
        </a>
    </div>

    <!-- Junior Count -->
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Students</p>
                <p class="text-2xl font-semibold text-gray-800">{{ session('student_count', 0) }}</p>
            </div>
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fas fa-user-graduate text-xl"></i>
            </div>
        </div>
        <a href="{{ route('hod.juniors.view') }}" class="mt-2 inline-flex items-center text-sm text-green-500 hover:text-green-700">
            View all <i class="fas fa-chevron-right ml-1"></i>
        </a>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Courses</p>
                <p class="text-2xl font-semibold text-gray-800">{{ session('course_count', 0) }}</p>
            </div>
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <i class="fas fa-book text-xl"></i>
            </div>
        </div>
        <a href="{{ route('hod.courses.view') }}" class="mt-2 inline-flex items-center text-sm text-purple-500 hover:text-purple-700">
            View all <i class="fas fa-chevron-right ml-1"></i>
        </a>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-amber-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Offered Courses</p>
                <p class="text-2xl font-semibold text-gray-800">{{ session('offer_count', 0) }}</p>
            </div>
            <div class="p-3 rounded-full bg-amber-100 text-amber-500">
                <i class="fas fa-tasks text-xl"></i>
            </div>
        </div>
        <a href="{{ route('hod.courses.allocation') }}" class="mt-2 inline-flex items-center text-sm text-amber-500 hover:text-amber-700">
            View all <i class="fas fa-chevron-right ml-1"></i>
        </a>
    </div>
</div>