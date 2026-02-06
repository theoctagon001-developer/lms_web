<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notifications</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-r from-blue-300 via-blue-200 to-blue-100 min-h-screen p-0 m-0">
        @include('HOD.partials.profile_panel')
    <div class="flex flex-1 overflow-hidden">
        <div class="container mx-auto px-4 py-8 flex-grow">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
                <h1 class="text-2xl font-bold text-blue-800 mb-6">Send Notification</h1>
                <form id="notificationForm">
                    @csrf
                    <div class="mb-4">
                        <input type="checkbox" id="broadcast" checked onchange="toggleBroadcast()">
                        <label for="broadcast" class="text-sm font-medium text-gray-700">Broadcast</label>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recipient</label>
                        <select id="recipient_type" name="recipient_type" class="w-full px-4 py-2 border rounded-md"
                            onchange="updateSearchBy()">
                            <option value="" selected>Select</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="lecturer">Junior Lecturer</option>
                        </select>
                    </div>
                    <div class="mb-4 hidden" id="searchByContainer">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search By</label>
                        <select id="search_by" class="w-full px-4 py-2 border rounded-md" onchange="clearSelection()">
                            <option value="section">Section</option>
                            <option value="name">Name</option>
                        </select>
                    </div>
                    <div class="mb-4 hidden" id="searchBox">
                        <input type="text" id="searchInput" placeholder="Search..."
                            class="w-full px-4 py-2 border rounded-md" onfocus="showSuggestions()"
                            oninput="filterSuggestions()">
                        <div id="suggestions" class="mt-2 bg-gray-100 rounded-md shadow-md p-2 hidden"></div>
                    </div>
                    <div class="mb-4" id="selectedItems"></div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" id="title" class="w-full px-4 py-2 border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea name="message" id="message" rows="5" class="w-full px-4 py-2 border rounded-md"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">URL (Optional)</label>
                        <input type="url" name="url" id="url" class="w-full px-4 py-2 border rounded-md"
                            placeholder="https://example.com">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Image (Optional)</label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="w-full px-4 py-2 border rounded-md">
                        <p class="text-xs text-gray-500 mt-1">Maximum file size: 2MB</p>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="sendNotification()"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Send</button>
                    </div>
                </form>
                <div class="w-full my-10"></div>

            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const urlInput = document.getElementById('url');
                    const imageInput = document.getElementById('image');

                    urlInput.addEventListener('input', function() {
                        imageInput.disabled = !!urlInput.value.trim();
                    });

                    imageInput.addEventListener('change', function() {
                        urlInput.disabled = imageInput.files.length > 0;
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
                    const colors = {
                        success: "bg-green-600",
                        error: "bg-red-600",
                        warning: "bg-yellow-600",
                        info: "bg-blue-600",
                    };
                    const alertDiv = document.createElement("div");
                    alertDiv.id = "custom-alert";
                    alertDiv.className =
                        `${colors[type]} text-white fixed top-24 right-5 px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-slide-in transition-all duration-300 z-50`;
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
                    }, 10000);
                }
            </script>

            <div id="loader"
                class="hidden fixed top-0 left-0 flex w-full h-full justify-center items-center bg-white bg-opacity-50">
                <div
                    class="w-20 h-20 border-4 border-transparent text-blue-400 text-4xl animate-spin flex items-center justify-center border-t-blue-400 rounded-full">
                    <div
                        class="w-16 h-16 border-4 border-transparent text-red-400 text-2xl animate-spin flex items-center justify-center border-t-red-400 rounded-full">
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script>
            let students = [];
            let sections = [];
            let teachers = [];
            let lecturers = [];
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

            async function initializeApiBaseUrl() {
                API_BASE_URL = await getApiBaseUrl();
                let response = await fetch(`${API_BASE_URL}api/Dropdown/AllStudent`, {
                    method: "GET"
                });
                students = await response.json();
                let res = await fetch(`${API_BASE_URL}api/Dropdown/AllTeacher`, {
                    method: "GET"
                });
                teachers = await res.json();
                let resp = await fetch(`${API_BASE_URL}api/Dropdown/AllJL`, {
                    method: "GET"
                });
                lecturers = await resp.json();
                let respon = await fetch(`${API_BASE_URL}api/Dropdown/AllSections`, {
                    method: "GET"
                });
                sections = await respon.json();
            }

            initializeApiBaseUrl();

            function toggleBroadcast() {
                const isBroadcast = document.getElementById('broadcast').checked;
                document.getElementById('recipient_type').disabled = isBroadcast;
                document.getElementById('searchByContainer').style.display = isBroadcast ? 'none' : 'block';
                document.getElementById('searchBox').style.display = isBroadcast ? 'none' : 'block';
                if (isBroadcast) {
                    clearSelection();
                }
            }

            function updateSearchBy() {
                let recipient = document.getElementById('recipient_type').value;
                let searchBy = document.getElementById('search_by');
                searchBy.innerHTML = '';

                if (recipient === 'student') {
                    searchBy.innerHTML = '<option value="section">Section</option><option value="name">Name</option>';
                } else if (recipient === 'teacher' || recipient === 'lecturer') {
                    searchBy.innerHTML = '<option value="name">Name</option>';
                }
                clearSelection();
            }

            function clearSelection() {
                document.getElementById('selectedItems').innerHTML = '';
                document.getElementById('searchInput').value = '';
                document.getElementById('suggestions').classList.add('hidden');
            }

            function filterSuggestions() {
                let query = document.getElementById('searchInput').value.toLowerCase();
                let recipient = document.getElementById('recipient_type').value;
                let searchBy = document.getElementById('search_by').value;
                let list = [];

                if (recipient === 'student' && searchBy === 'section') list = sections;
                if (recipient === 'student' && searchBy === 'name') list = students;
                if (recipient === 'teacher') list = teachers;
                if (recipient === 'lecturer') list = lecturers;

                let suggestions = list.filter(item => item.toLowerCase().includes(query));
                let suggestionsBox = document.getElementById('suggestions');

                suggestionsBox.innerHTML = suggestions.length ?
                    suggestions.map(s => `<div class='cursor-pointer p-1 hover:bg-blue-200' onclick='selectItem("${s}")'>${s}</div>
    `).join('') :
                    '<div class="text-red-500">No match found</div>';

                suggestionsBox.classList.toggle('hidden', suggestions.length === 0);
            }

            function showSuggestions() {
                if (document.getElementById('searchInput').value) {
                    document.getElementById('suggestions').classList.remove('hidden');
                }
            }

            function selectItem(item) {
                let selectedDiv = document.getElementById('selectedItems');
                if (!Array.from(selectedDiv.children).some(child => child.textContent.includes(item))) {
                    let label = document.createElement('span');
                    label.className = "bg-blue-300 text-white px-2 py-1 m-1 rounded inline-block";
                    label.innerHTML = `${item} <span class='text-red-500 cursor-pointer'
        onclick='this.parentElement.remove()'>❌</span>`;
                    selectedDiv.appendChild(label);
                }
            }

            async function sendNotification() {
                showLoader();
                event.preventDefault(); // Prevent default form submission
                // showAlert('none');
                let responses = [];
                let errors = [];
                let sender = "{{ session('userType') }}";
                let sender_id = "{{ session('userId') }}";
                let title = document.querySelector('input[name="title"]').value.trim();
                let description = document.querySelector('textarea[name="message"]').value.trim();
                let url = document.querySelector('input[name="url"]').value.trim();
                let broadcast = document.getElementById('broadcast').checked;
                let recipientType = document.getElementById('recipient_type').value;
                let searchBy = document.getElementById('search_by')?.value || null;
                let imageInput = document.getElementById('image');
                let imageFile = imageInput.files.length > 0 ? imageInput.files[0] : null;

                //let selectedNames = Array.from(document.getElementById('selectedItems').children).map(item =>item.textContent.trim());
                let selectedNames = Array.from(document.getElementById('selectedItems').children)
                    .map(item => item.childNodes[0].textContent.trim());

                if (!title || !description) {
                    hideLoader();
                    showAlert("❌ Error: Title and Message are required.");
                    return;
                }

                let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";

                async function getApiBaseUrl() {
                    try {
                        let response = await fetch('/get-api-url');
                        let data = await response.json();
                        return data.api_base_url;
                    } catch (error) {
                        console.error("⚠️ Failed to fetch API base URL:", error);
                        return API_BASE_URL;
                    }
                }

                API_BASE_URL = await getApiBaseUrl(); // Ensure we get the correct URL
                let apiUrl = API_BASE_URL + "api/Insertion/send-notification";

                const sendFormData = async (formData) => {
                    try {
                        let response = await fetch(apiUrl, {
                            method: "POST",
                            body: formData, // FormData handles file and text both
                        });
                        let result = await response.json();

                        if (response.ok) {
                            return {
                                success: true,
                                message: result.message
                            };
                        } else {
                            return {
                                success: false,
                                message: result.message || result.error || "Unknown server error."
                            };
                        }
                    } catch (error) {
                        return {
                            success: false,
                            message: `Unable to reach the server. ${error.message}`
                        };
                    }
                };


                if (broadcast) {
                    let formData = new FormData();
                    formData.append("title", title);
                    formData.append("description", description);
                    formData.append("sender", sender);
                    formData.append("sender_id", sender_id);
                    formData.append("reciever", recipientType || "");
                    formData.append("Brodcast", 1);
                    formData.append("url", url || "");
                    if (imageFile) formData.append("image", imageFile);

                    const result = await sendFormData(formData);
                    if (result.success) {
                        responses.push(result.message);
                    } else {
                        errors.push("❌ Broadcast Failed: " + result.message);
                    }
                } else {
                    if (!selectedNames.length) {
                        hideLoader();
                        showAlert("❌ Error: Please select a name or use broadcast mode.");
                        return;
                    }

                    for (let name of selectedNames) {
                        let formData = new FormData();
                        formData.append("title", title);
                        formData.append("description", description);
                        formData.append("sender", sender);
                        formData.append("sender_id", sender_id);
                        formData.append("reciever", recipientType || "");
                        formData.append("Brodcast", 0);
                        formData.append("url", url || "");
                        if (imageFile) formData.append("image", imageFile);

                        if (recipientType === "student" && searchBy === "section") {
                            formData.append("Student_Section_Name", name);
                        } else {
                            formData.append("TL_receiver_name", name);
                        }

                        const result = await sendFormData(formData);
                        if (result.success) {
                            responses.push(`✅ ${name}: ${result.message}`);
                        } else {
                            errors.push(`❌ ${name}: ${result.message}`);
                        }
                    }
                }
                hideLoader();
                // Display messages
                if (responses.length) {
                    showAlert("✅ Success:\n" + responses.join("\n"), "success");
                }
                if (errors.length) {
                    showAlert("❌ Errors:\n" + errors.join("\n"));
                }
            }
        </script>
</body>
</html>
