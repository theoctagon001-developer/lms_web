<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Base styles */
        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3b82f6; /* Blue-500 */
            color: white;
        }

        tr:hover {
            background-color: #f9fafb; /* Gray-50 */
        }

        /* Mobile-first responsive styles */
        @media (max-width: 768px) {
            .table-container {
                overflow-x: hidden; /* Prevent horizontal scrolling */
            }

            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin-bottom: 1rem;
                border: 1px solid #ccc;
                border-radius: 0.5rem;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                background-color: white;
            }

            td {
                border: none;
                position: relative;
                padding-left: 50% !important;
                text-align: left !important;
                min-height: 45px;
                display: flex;
                align-items: center;
            }

            td:before {
                content: attr(data-label);
                position: absolute;
                left: 12px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
                color: #333;
            }

            /* Special handling for action buttons */
            td:last-child {
                padding: 0.75rem !important;
                display: flex;
                justify-content: center;
            }

            td:last-child:before {
                display: none;
            }

            td:last-child button {
                width: 100%;
                text-align: center;
                padding: 0.75rem;
            }

            /* Search container adjustments */
            .search-container {
                flex-direction: column;
                gap: 0.5rem;
            }

            .search-container input, .search-container button {
                width: 100%;
            }
        }
    </style>
    <script>
        let courses = [];
        let filteredCourses = [];
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

        async function loadCourses() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/courses`);
                const data = await response.json();
                if (data.Courses) {
                    courses = data.Courses;
                    filteredCourses = [...courses];
                    renderCourses();
                }
            } catch (error) {
                console.error("Error fetching courses:", error);
            }
        }

        function searchCourses() {
            const nameSearch = document.getElementById("search-name").value.toLowerCase();
            const codeSearch = document.getElementById("search-code").value.toLowerCase();

            filteredCourses = courses.filter(course =>
                (course.name.toLowerCase().includes(nameSearch) || nameSearch === "") &&
                (course.code.toLowerCase().includes(codeSearch) || codeSearch === "")
            );

            renderCourses();
        }

        function resetSearch() {
            document.getElementById("search-name").value = "";
            document.getElementById("search-code").value = "";
            filteredCourses = [...courses];
            renderCourses();
        }

        function renderCourses() {
            const tableBody = document.getElementById("course-table-body");
            tableBody.innerHTML = "";

            if (filteredCourses.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-gray-500">No courses found.</td></tr>';
                return;
            }

            filteredCourses.forEach(course => {
                tableBody.innerHTML += `
                    <tr class="border-b border-gray-300 text-center">
                        <td class="px-4 py-2" data-label="Code">${course.code}</td>
                        <td class="px-4 py-2" data-label="Name">${course.name}</td>
                        <td class="px-4 py-2" data-label="Credit Hours">${course.credit_hours}</td>
                        <td class="px-4 py-2" data-label="Pre-Req">${course.pre_req_main}</td>
                        <td class="px-4 py-2" data-label="Lab">${course.lab == 1 ? 'Lab' : 'No Lab'}</td>
                        <td class="px-4 py-2" data-label="Short Form">${course.description}</td>
                        <td class="px-4 py-2" data-label="Action">

                        </td>
                    </tr>`;
            });
        }

        document.addEventListener("DOMContentLoaded", loadCourses);
    </script>
</head>
<body class="bg-gray-100">
    @include('admin.navbar', [
        'username' => session('username', 'Guest'),
        'profileImage' => session('profileImage', asset('images/male.png')),
        'designation' => session('designation', 'N/A'),
        'type' => session('userType', 'User')
    ])
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Course List</h2>

        <div class="mb-4 flex flex-col sm:flex-row justify-center items-center gap-4 search-container">
            <input type="text" id="search-name" class="border p-2 w-full sm:w-96" oninput="searchCourses()" placeholder="Search by Course Name">
            <input type="text" id="search-code" class="border p-2 w-full sm:w-96" oninput="searchCourses()" placeholder="Search by Course Code">
            <button onclick="resetSearch()" class="bg-gray-500 text-white px-4 py-2 rounded">Refresh</button>
        </div>

        <div class="table-container mx-auto max-w-5xl">
            <table class="border border-gray-300 shadow-lg bg-white w-full">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2">Code</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Credit Hours</th>
                        <th class="px-4 py-2">Pre-Req</th>
                        <th class="px-4 py-2">Lab</th>
                        <th class="px-4 py-2">Short Form</th>

                    </tr>
                </thead>
                <tbody id="course-table-body">
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @include('components.loader')
    @include('components.footer')
</body>
</html>

