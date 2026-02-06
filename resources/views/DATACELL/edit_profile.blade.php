<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | LMS</title>
    @vite('resources/css/app.css')
    <style>
        .profile-edit-container {
            max-width: 500px;
            margin: 0 auto;
        }
        .profile-image-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto;
        }
        .profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #3b82f6;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .edit-icon {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #3b82f6;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-blue-300 via-blue-200 to-blue-100 min-h-screen p-0 m-0">
   @include('DATACELL.partials.nav')
    
    <div class="profile-edit-container p-4">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden p-6">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Edit Profile</h2>
            
            <!-- Profile Image Section -->
            <div class="mb-8 text-center">
                <div class="profile-image-wrapper">
                    <img id="profilePreview" 
                         src="{{ session('profileImage', asset('images/male.png')) }}" 
                         class="profile-image"
                         onclick="triggerFileInput()">
                    <div class="edit-icon" onclick="triggerFileInput()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                    </div>
                </div>
                <input type="file" id="profileImageInput" class="hidden" accept="image/*" onchange="previewImage(event)">
                <p class="text-sm text-gray-500 mt-2">Click image to change</p>
            </div>

            <!-- Edit Form -->
            <form id="updateProfileForm" class="space-y-4">
                <!-- Display non-editable info -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Name</p>
                            <p class="font-medium">{{ session('username') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Designation</p>
                            <p class="font-medium">{{ session('designation') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Editable fields -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" 
                           value="{{ session('email', '') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" id="password" 
                           placeholder="Leave blank to keep current password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('components.loader')
    @include('components.footer')

    <script>
        // Image preview and upload handling
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

        // Form submission
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

            document.getElementById("updateProfileForm").addEventListener("submit", async function(event) {
                event.preventDefault();
                showLoader();
                
                try {
                    API_BASE_URL = await getApiBaseUrl();
                    const hodId = "{{ session('Id') }}";
                    const formData = new FormData();
                    
                    // Get form values
                    const email = document.getElementById("email").value.trim();
                    const password = document.getElementById("password").value.trim();
                    const imageInput = document.getElementById("profileImageInput");
                    
                    // Append data if provided
                    if (email) formData.append("email", email);
                    if (password) formData.append("password", password);
                    if (imageInput.files.length > 0) {
                        formData.append("image", imageInput.files[0]);
                    }
                    
                    // Make API request
                    const response = await fetch(`${API_BASE_URL}api/Datacells/update/${hodId}`, {
                        method: "POST",
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok || response.message=='HOD info updated successfully') {
                        alert("Profile updated successfully!");
                        window.location.reload();
                    } else {
                        let errorMsg = result.error || 'Failed to update profile';
                        if (result.messages) {
                            errorMsg = Object.values(result.messages).join('\n');
                        }
                        alert("Error: " + errorMsg);
                    }
                } catch (error) {
                    console.error("Error updating profile:", error);
                    alert("An error occurred. Please try again.");
                } finally {
                    hideLoader();
                }
            });
        });
    </script>
</body>
</html>