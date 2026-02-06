<div class="relative">

    <script>
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.classList.toggle('hidden');
            dropdown.classList.toggle('animate-fade-in');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileBtn = document.getElementById('profile-btn');
            const dropdown = document.getElementById('profile-dropdown');

            if (!profileBtn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

    </script>
    <button id="profile-btn" onclick="toggleProfileDropdown()" class="flex items-center space-x-2 focus:outline-none">
        <div class="relative">
            <img class="h-8 w-8 rounded-full object-cover" src="{{ session('profileImage') }}" alt="Profile">
            <span class="absolute bottom-0 right-0 block h-2 w-2 rounded-full bg-green-500 ring-2 ring-white"></span>
        </div>
        <div class="text-left">
            <p class="text-sm font-medium text-gray-700">{{ session('username') }}</p>
            <p class="text-xs text-gray-500">{{ session('designation') }}</p>
        </div>
    </button>

    <!-- Dropdown menu -->
    <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg overflow-hidden z-30 border border-gray-200 animate-slide-down">
        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
            <p class="text-sm font-medium text-gray-700">{{ session('username') }}</p>
            <p class="text-xs text-gray-500 truncate">{{ session('designation') }} - {{ session('department') }}</p>
        </div>
        
        <div class="px-4 py-3 space-y-2">
            <div class="flex items-center text-sm text-gray-700">
                <i class="fas fa-id-card mr-2 text-gray-500"></i>
                <span>{{ session('usernames') }}</span>
            </div>
            <div class="flex items-center text-sm text-gray-700">
                <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                <span>Session: {{ session('currentSession') }}</span>
            </div>
            <div class="flex items-center text-sm text-gray-700">
                <i class="fas fa-clock mr-2 text-gray-500"></i>
                <span>{{ session('startDate') }} to {{ session('endDate') }}</span>
            </div>
        </div>
        
        <div class="border-t border-gray-200">
            <a href="{{ route('Director.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-user-cog mr-2"></i> Update Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>