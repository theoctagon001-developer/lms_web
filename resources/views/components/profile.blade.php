
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Dashboard</title>
    @vite('resources/css/app.css')
</head>
@php
$profileImage = session('profileImage', asset('images/male.png'));
$userName = session('username', 'Guest');
$designation = session('designation', 'N/A');
$type=session('userType', 'User');
$imagePath = asset('images/male.png');
@endphp
<body class="bg-gradient-to-r from-blue-300 via-blue-200 to-blue-100 min-h-screen p-0 m-0">
    @include('components.navbar', [
        'username' => session('username', 'Guest'),
        'profileImage' => session('profileImage', asset('images/male.png')),
        'designation' => session('designation', 'N/A'),
        'type' => session('userType', 'User')
    ])
    

    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
            <div class="flex items-center space-x-4">
                <img class="w-24 h-24 rounded-full border-4 border-blue-500 object-cover" src="{{ session('profileImage') }}" alt="Profile Image">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">{{ session('username') }}</h2>
                    <p class="text-gray-600">{{ session('designation') }}</p>
                    <p class="text-sm text-gray-500">📞 {{ session('phoneNumber') }}</p>
                </div>
            </div>
            <div class="mt-6">
                <table class="w-full border-collapse">
                    <tr class="border-b">
                        <td class="py-2 text-gray-600 font-semibold">Username:</td>
                        <td class="py-2 text-gray-800">{{ session('usernames') }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 text-gray-600 font-semibold">User Type:</td>
                        <td class="py-2 text-gray-800">{{ session('userType') }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 text-gray-600 font-semibold">Current Session:</td>
                        <td class="py-2 text-gray-800">{{ session('currentSession') }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 text-gray-600 font-semibold">Start Date:</td>
                        <td class="py-2 text-gray-800">{{ session('startDate') }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 text-gray-600 font-semibold">End Date:</td>
                        <td class="py-2 text-gray-800">{{ session('endDate') }}</td>
                    </tr>
                </table>
            </div>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition">Edit Profile</a>
            </div>
        </div>
    </div>
    @include('components.footer')
</body>

</html> 


