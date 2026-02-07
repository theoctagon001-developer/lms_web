<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .table-container {
            transition: all 0.3s ease-in-out;
        }

        .search-active .table-container {
            max-width: 80%;
        }

        /* Mobile card styling */
        .teacher-card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .teacher-card-header {
            display: flex;
            align-items: center;
            padding: 1rem;
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        .teacher-card-content {
            padding: 1rem;
        }

        .teacher-card-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .teacher-card-label {
            font-weight: 500;
            color: #4b5563;
        }

        .teacher-card-footer {
            padding: 1rem;
            text-align: center;
            background-color: #f9fafb;
        }
    </style>
    <script>
        let teachers = [];
        let filteredTeachers = [];
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

        async function loadTeachers() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/junior-lectures`);
                const data = await response.json();
                if (data.Teacher) {
                    teachers = data.Teacher;
                    filteredTeachers = [...teachers];
                    renderTeachers();
                }
            } catch (error) {
                console.error("Error fetching teachers:", error);
            }
        }

        var teacherDetailsBaseRoute = "{{ route('teacher.details', ['teacher' => '__PLACEHOLDER__','role'=>'__ROLE__']) }}";

        function searchTeachers() {
            const searchValue = document.getElementById("search-input").value.toLowerCase();
            filteredTeachers = teachers.filter(teacher =>
                teacher.name.toLowerCase().includes(searchValue)
            );
            renderTeachers();
            document.getElementById("table-wrapper").classList.add("search-active");
        }

        function resetSearch() {
            document.getElementById("search-input").value = "";
            filteredTeachers = [...teachers];
            renderTeachers();
            document.getElementById("table-wrapper").classList.remove("search-active");
        }

        function renderTeachers() {
            const tableBody = document.getElementById("teacher-table-body");
            const cardsContainer = document.getElementById("teacher-cards-container");

            tableBody.innerHTML = "";
            cardsContainer.innerHTML = "";

            if (filteredTeachers.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-gray-500">No teachers found.</td></tr>';
                cardsContainer.innerHTML = '<div class="p-4 text-center text-gray-500">No teachers found.</div>';
                return;
            }

            filteredTeachers.forEach(teacher => {
                const role = btoa('JuniorLecturer'); // Encode the role
                const encodedData = btoa(JSON.stringify(teacher)); // Encode teacher object
                const teacherDetailsUrl = teacherDetailsBaseRoute
                    .replace('__PLACEHOLDER__', encodeURIComponent(encodedData))
                    .replace('__ROLE__', encodeURIComponent(role));

                // Table row for desktop view
                tableBody.innerHTML += `
                    <tr class="border-b border-gray-300 text-center">
                        <td class="px-4 py-2">
                            <img src="${teacher.image ? teacher.image : '{{ asset('images/male.png') }}'}" alt="Profile" class="w-12 h-12 rounded-full mx-auto">
                        </td>
                        <td class="px-4 py-2">${teacher.name}</td>
                        <td class="px-4 py-2">${teacher.user.username}</td>
                        <td class="px-4 py-2">${teacher.user.email}</td>
                        <td class="px-4 py-2">${teacher.gender}</td>
                        <td class="px-4 py-2">${teacher.date_of_birth}</td>
                        <td class="px-4 py-2">${teacher.cnic}</td>
                        <td class="px-4 py-2">
                            <a href="${teacherDetailsUrl}" class="bg-blue-500 text-white px-4 py-2 rounded">
                                View
                            </a>
                        </td>
                    </tr>`;

                // Card for mobile view
                cardsContainer.innerHTML += `
                    <div class="teacher-card">
                        <div class="teacher-card-header">
                            <img src="${teacher.image ? teacher.image : '{{ asset('images/male.png') }}'}" alt="Profile" class="w-14 h-14 rounded-full mr-3">
                            <div>
                                <h3 class="font-bold text-lg">${teacher.name}</h3>
                                <p class="text-sm text-gray-600">${teacher.user.username}</p>
                            </div>
                        </div>
                        <div class="teacher-card-content">
                            <div class="teacher-card-row">
                                <span class="teacher-card-label">Email:</span>
                                <span class="truncate max-w-[60%]">${teacher.user.email}</span>
                            </div>
                            <div class="teacher-card-row">
                                <span class="teacher-card-label">Gender:</span>
                                <span>${teacher.gender}</span>
                            </div>
                            <div class="teacher-card-row">
                                <span class="teacher-card-label">Date of Birth:</span>
                                <span>${teacher.date_of_birth}</span>
                            </div>
                            <div class="teacher-card-row">
                                <span class="teacher-card-label">CNIC:</span>
                                <span>${teacher.cnic}</span>
                            </div>
                        </div>
                        <div class="teacher-card-footer">
                            <a href="${teacherDetailsUrl}" class="bg-blue-500 text-white px-6 py-2 rounded inline-block w-full">
                                View Details
                            </a>
                        </div>
                    </div>`;
            });
        }

        document.addEventListener("DOMContentLoaded", loadTeachers);
    </script>
</head>
<body class="bg-gray-100">
    @include('admin.navbar', [
        'username' => session('username', 'Guest'),
        'profileImage' => session('profileImage', asset('images/male.png')),
        'designation' => session('designation', 'N/A'),
        'type' => session('type', 'User')
    ])
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Junior Lecturer List</h2>

        <div class="mb-4 flex flex-col sm:flex-row justify-center items-center gap-4">
            <input type="text" id="search-input" class="border p-2 w-full sm:w-96 rounded" oninput="searchTeachers()" placeholder="Search by Name">
            <button onclick="resetSearch()" class="bg-gray-500 text-white px-4 py-2 rounded w-full sm:w-auto">Refresh</button>
        </div>

        <!-- Desktop Table View (hidden on small screens) -->
        <div id="table-wrapper" class="table-container mx-auto max-w-5xl hidden md:block">
            <table class="border border-gray-300 shadow-lg bg-white w-full">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Gender</th>
                        <th class="px-4 py-2">Date of Birth</th>
                        <th class="px-4 py-2">CNIC</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="teacher-table-body">
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (shown only on small screens) -->
        <div class="md:hidden mx-auto max-w-5xl">
            <div id="teacher-cards-container" class="space-y-4">
                <div class="text-center py-4 text-gray-500">Loading...</div>
            </div>
        </div>
    </div>
    @include('components.footer')
</body>
</html>
