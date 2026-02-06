<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Add Student</title>
    @vite('resources/css/app.css')
    <style>
        .btn {
            transition: transform 0.3s ease-in-out;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .form-input {
            @apply p-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200;
        }

        .form-label {
            @apply block text-gray-700 font-medium mb-1;
        }

        .form-group {
            @apply mb-4;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 8px 10px -6px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-r from-blue-50 to-indigo-100 min-h-screen p-0 m-0">
    @include('DATACELL.partials.nav')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto bg-white p-6 md:p-8 rounded-xl shadow-lg card-hover animate-fade-in">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-center text-blue-600">Student Registration</h2>
                <p class="text-center text-gray-500 mt-2">Enter student details to create a new account</p>
            </div>

            <form id="studentForm" enctype="multipart/form-data" class="mx-auto">
                <!-- Profile Image Upload -->
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-blue-300 shadow-md hover:border-blue-500 transition-all duration-300">
                            <img id="profilePreview" src="/default-profile.png" class="w-full h-full object-cover cursor-pointer" onclick="triggerFileInput()">
                        </div>
                        <span class="absolute bottom-1 right-1 bg-blue-500 hover:bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer shadow-md text-lg transition-all duration-200" onclick="triggerFileInput()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                        </span>
                        <input type="file" id="profileImageInput" name="image" class="hidden" accept="image/*" onchange="previewImage(event)">
                    </div>
                </div>
                <button type="button" class="block mx-auto bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm mb-8 transition-colors duration-200" onclick="removeImage()">
                    <span class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                        Remove Image
                    </span>
                </button>

                <!-- Form Fields -->
                <div class="bg-blue-50 p-6 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold text-blue-700 mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <div class="form-group">
                            <label class="form-label" for="name">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" class="form-input" required placeholder="Enter full name">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="RegNo">Registration Number <span class="text-red-500">*</span></label>
                            <input type="text" name="RegNo" id="RegNo" class="form-input" required placeholder="e.g., 2023-CS-101">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" class="form-input" required placeholder="student@example.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="gender">Gender <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" class="form-input" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="date_of_birth">Date of Birth <span class="text-red-500">*</span></label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="guardian">Guardian Name</label>
                            <input type="text" name="guardian" id="guardian" class="form-input" placeholder="Parent/Guardian name">
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-50 p-6 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold text-indigo-700 mb-4">Academic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <div class="form-group">
                            <label class="form-label" for="program_id">Program <span class="text-red-500">*</span></label>
                            <select name="program_id" id="program_id" class="form-input w-40" required>
                                <option value="">Select Program</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cgpa">CGPA</label>
                            <input type="number" name="cgpa" id="cgpa" class="form-input w-20 ml-5" step="0.01" min="0" max="4.0" placeholder="e.g., 3.50">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="session_id">Session <span class="text-red-500">*</span></label>
                            <select name="session_id" id="session_id" class="form-input" required>
                                <option value="">Select Session</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="section_id">Section <span class="text-red-500">*</span></label>
                            <select name="section_id" id="section_id" class="form-input" required>
                                <option value="">Select Section</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="status">Status <span class="text-red-500">*</span></label>
                            <select name="status" id="status" class="form-input" required>
                                <option value="">Select Status</option>
                                <option value="Graduate">Graduate</option>
                                <option value="UnderGraduate">Undergraduate</option>
                                <option value="Freeze">Freeze</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="btn bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-3 px-8 rounded-lg font-bold text-lg shadow-lg hover:shadow-xl flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                        <span>Register Student</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
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

        document.addEventListener("DOMContentLoaded", async function() {
            API_BASE_URL = await getApiBaseUrl();
            fetchDropdownData(`${API_BASE_URL}api/Dropdown/AllSession`, 'session_id');
            fetchDropdownData(`${API_BASE_URL}api/Dropdown/AllProgram`, 'program_id');
            fetchDropdownData(`${API_BASE_URL}api/Dropdown/AllSection`, 'section_id');
        });

        function fetchDropdownData(apiUrl, elementId) {
            fetch(apiUrl)
                .then(response => response.json())
                .then(response => {
                    const dropdown = document.getElementById(elementId);
                    dropdown.innerHTML = '<option value="">Select an option</option>';
                    response.forEach(item => {
                        dropdown.innerHTML += `<option value="${item.id}">${item.data}</option>`;
                    });
                })
                .catch(error => console.error("Error fetching data:", error));
        }

        function triggerFileInput() {
            document.getElementById('profileImageInput').click();
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('profilePreview').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function removeImage() {
            document.getElementById('profilePreview').src = '/default-profile.png';
            document.getElementById('profileImageInput').value = "";
        }

        document.getElementById('studentForm').addEventListener('submit', async function(event) {
            showLoader();
            event.preventDefault();
            API_BASE_URL = await getApiBaseUrl();
            const formData = new FormData(this);


            fetch(`${API_BASE_URL}api/Insertion/add-single-student`, {
                    method: 'POST'
                    , body: formData
                })
                .then(async response => {
                    let data;
                    try {
                        data = await response.json(); // Attempt to parse JSON response
                    } catch (error) {
                        throw new Error(`Unexpected server response: ${response.statusText}`);
                    }

                    if (!response.ok) {
                        throw new Error(data.errors || `Error ${response.status}: Something went wrong`);
                    }

                    return data;
                })
                .then(data => {
                    if (data.username && data.password) {
                        hideLoader();
                        showAlert(`✅ ${data.message}\n👤 Username: ${data.username}\n🔑 Password: ${data.password}`,'success');
                    } else {
                        hideLoader();
                        showAlert(`✅ ${data.message}`);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    hideLoader();
                    let errorMessage = error.message || "Something went wrong!";
                if (typeof error.errors === "object") {
                    errorMessage += "\n" + Object.values(error.errors).flat().join("\n");
                } else if (typeof error.errors === "string") {
                    errorMessage += "\n" + error.errors; // Directly append if it's a string
                }
                    showAlert(`❌ ${errorMessage}`);
                });


        });
        window.addEventListener("load", function() {
            document.getElementById("loader").classList.add("hidden");
        });

        function showLoader() {
            document.getElementById("loader").classList.remove("hidden");
        }

        function hideLoader() {
            document.getElementById("loader").classList.add("hidden");
        }
        function showAlert(message, type = "error") {
        // Remove existing alert if present
        const existingAlert = document.getElementById("custom-alert");
        if (existingAlert) existingAlert.remove();

        // Define alert colors based on type
        const colors = {
            success: "bg-green-600"
            , error: "bg-red-600"
            , warning: "bg-yellow-600"
            , info: "bg-blue-600"
        , };

        // Create alert div
        const alertDiv = document.createElement("div");
        alertDiv.id = "custom-alert";
        alertDiv.className = `${colors[type]} text-white fixed top-24 right-5 px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-slide-in transition-all duration-300 z-50`;

        // Alert icon (SVG)
        const icon = document.createElement("div");
        icon.innerHTML = `
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.29 3.86L1.82 18.14A2 2 0 003.73 21h16.54a2 2 0 001.91-2.86L13.71 3.86a2 2 0 00-3.42 0zM12 9v4m0 4h.01">
            </path>
        </svg>`;

        // Alert message
        const messageText = document.createElement("span");
        messageText.className = "font-semibold";
        messageText.innerText = message;

        // Close button
        const closeButton = document.createElement("button");
        closeButton.innerHTML = "✖";
        closeButton.className = "text-white hover:text-gray-300 focus:outline-none";
        closeButton.onclick = () => alertDiv.remove();

        // Append elements to alert
        alertDiv.appendChild(icon);
        alertDiv.appendChild(messageText);
        alertDiv.appendChild(closeButton);

        // Append alert to body
        document.body.appendChild(alertDiv);

        // Auto-remove alert after 4 seconds
        setTimeout(() => {
            alertDiv.remove();
            // location.reload();
        }, 10000);
    }

    </script>
    @include('components.loader')
    @include('components.footer')
</body>
</html>
