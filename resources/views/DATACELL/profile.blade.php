<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .profile-card {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .info-row {
            transition: background-color 0.2s ease;
        }
        .info-row:hover {
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-blue-300 via-blue-200 to-blue-100 min-h-screen p-0 m-0">
    @include('DATACELL.partials.nav')
    
    <div class="max-w-4xl mx-auto p-4 md:p-6">
        <div class="profile-card bg-white rounded-lg overflow-hidden p-6">
            <!-- Profile Header -->
            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                <img class="w-24 h-24 rounded-full border-4 border-blue-500 object-cover" 
                     src="{{ session('profileImage') }}" 
                     alt="Profile Image">
                <div class="text-center md:text-left">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ session('username') }}</h2>
                    <p class="text-gray-600">{{ session('designation') }}</p>
                    <p class="text-blue-500 font-medium">DATACELL</p>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4">Personal Information</h3>
                
                <div class="space-y-2">
                    <div class="info-row grid grid-cols-1 md:grid-cols-3 gap-4 p-3 rounded-lg">
                        <span class="text-gray-600 font-medium">Username:</span>
                        <span class="text-gray-800 md:col-span-2">{{ session('usernames') }}</span>
                    </div>
                    
                    <div class="info-row grid grid-cols-1 md:grid-cols-3 gap-4 p-3 rounded-lg">
                        <span class="text-gray-600 font-medium">User Type:</span>
                        <span class="text-gray-800 md:col-span-2">{{ session('userType') }}</span>
                    </div>
                    
                    <div class="info-row grid grid-cols-1 md:grid-cols-3 gap-4 p-3 rounded-lg">
                        <span class="text-gray-600 font-medium">Current Session:</span>
                        <span class="text-gray-800 md:col-span-2">{{ session('currentSession') }}</span>
                    </div>
                    
                    <div class="info-row grid grid-cols-1 md:grid-cols-3 gap-4 p-3 rounded-lg">
                        <span class="text-gray-600 font-medium">Session Duration:</span>
                        <span class="text-gray-800 md:col-span-2">
                            {{ session('startDate') }} to {{ session('endDate') }}
                        </span>
                    </div>
                    
                    <div class="info-row grid grid-cols-1 md:grid-cols-3 gap-4 p-3 rounded-lg">
                        <span class="text-gray-600 font-medium">Current Week:</span>
                        <span class="text-gray-800 md:col-span-2">Week {{ session('current_week') }}</span>
                    </div>
                </div>
            </div>

            <!-- Department Stats -->
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4">Department Overview</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                        <p class="text-blue-600 font-medium">Courses</p>
                        <p class="text-2xl font-bold text-gray-800">{{ session('course_count') }}</p>
                    </div>
                    
                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                        <p class="text-blue-600 font-medium">Students</p>
                        <p class="text-2xl font-bold text-gray-800">{{ session('student_count') }}</p>
                    </div>
                    
                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                        <p class="text-blue-600 font-medium">Faculty</p>
                        <p class="text-2xl font-bold text-gray-800">{{ session('faculty_count') }}</p>
                    </div>
                </div>
            </div>

            <!-- Edit Button -->
            <div class="mt-8 flex justify-end">
                <a href="{{ route('datacell.edit_profile') }}" 
                   class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition transform hover:-translate-y-1">
                   Edit Profile
                </a>
            </div>
        </div>
    </div>
    @include('components.footer')
</body>
</html>