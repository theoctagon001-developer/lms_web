<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function previewImage(event) {
            const image = document.getElementById('profilePreview');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function triggerFileInput() {
            document.getElementById('profileImageInput').click();
        }
    </script>
</head>
@php
$profileImage = session('profileImage', asset('images/male.png'));
$userName = session('username', 'Guest');
$designation = session('designation', 'N/A');
$userId = session('userId', '');
$userType = session('userType', 'User');
$email = session('email', '');
$phoneNumber = session('phoneNumber', '');
@endphp
<body class="bg-gradient-to-r from-blue-300 via-blue-200 to-blue-100 min-h-screen p-0 m-0">
    @include('components.navbar', [
    'username' => $userName,
    'profileImage' => $profileImage,
    'designation' => $designation,
    'type' => $userType
    ])

    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Edit Profile</h2>
            <div class="flex justify-center relative mb-6">
                <div class="relative">
                    <img id="profilePreview" src="{{ $profileImage }}" class="w-32 h-32 rounded-full object-cover border-4 border-gray-300 cursor-pointer" onclick="triggerFileInput()">
                    <span class="absolute bottom-1 right-1 bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer shadow-md text-lg font-bold" onclick="triggerFileInput()">+</span>
                    <input type="file" id="profileImageInput" class="hidden" accept="image/*" onchange="previewImage(event)">
                </div>
            </div>

            <form id="updateProfileForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700">Name</label>
                        <input type="text" id="username" value="{{ $userName }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                    </div>
                    <div>
                        <label class="block text-gray-700">Email</label>
                        <input type="email" id="email" value="{{ $email }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                    </div>
                    <div>
                        <label class="block text-gray-700">Phone Number</label>
                        <input type="text" id="phoneNumber" value="{{ $phoneNumber }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                    </div>
                    <div>
                        <label class="block text-gray-700">Password</label>
                        <input type="password" id="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                    </div>
                    <div>
                        <label class="block text-gray-700">Designation</label>
                        <input type="text" id="designation" value="{{ $designation }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 mt-1">
                    </div>
                </div>
                <div class="flex justify-center mt-6">
                    <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300 shadow-md">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
   @include('components.loader')
   @include('components.footer')
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }
        API_BASE_URL = getApiBaseUrl();
        document.getElementById("updateProfileForm").addEventListener("submit", async function(event) {
            event.preventDefault();
            showLoader();
            API_BASE_URL=await getApiBaseUrl();
            let formData = new FormData();
            let userId = "{{ session('userId') }}";
            let role = "{{ session('userType') }}";
            let id="{{session('Id')}}";
            formData.append("id", id);
            formData.append("role", role);
            formData.append("name", document.getElementById("username").value.trim());
            formData.append("phone_number", document.getElementById("phoneNumber").value.trim());
            formData.append("Designation", document.getElementById("designation").value.trim());
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();
            if (email) formData.append("email", email);
            if (password) formData.append("password", password);
            let imageInput = document.getElementById("profileImageInput");
            if (imageInput.files.length > 0) {
                formData.append("image", imageInput.files[0]);
            }
            try {
                let response = await fetch(`${API_BASE_URL}api/Insertion/update-single-user`, {
                    method: "POST"
                    , body: formData
                });
                let result = await response.json();
                if (response.ok) {
                    sessionStorage.setItem("profileImage", result['image']);
                    sessionStorage.setItem("username", result['name']);
                    sessionStorage.setItem("phoneNumber", result['phone']);
                    sessionStorage.setItem("designation", result['designation']);
                    sessionStorage.setItem("usernames", result['username']);
                    hideLoader();
                    alert("✅ Profile updated successfully!");

                    location.reload();
                } else {
                    hideLoader();
                    alert("⚠️ Failed to update profile: " + result.message);
                }
            } catch (error) {
                hideLoader();
                console.error("❌ Error updating profile:", error);
                alert("⚠️ An unexpected error occurred. Please try again." + error);
            }
        });
    });

</script>
</html>
