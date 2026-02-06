<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher List</title>
    @vite('resources/css/app.css')
    <style>
        .table-container {
            transition: all 0.3s ease-in-out;
        }
        /* Add this to your existing style section */

/* Base table styles */
.table-container {
    overflow-x: auto; /* Remove this line to prevent horizontal scrolling */
    transition: all 0.3s ease-in-out;
}

/* Mobile-first approach */
@media (max-width: 768px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }

    /* Hide table headers (but not display: none, for accessibility) */
    thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }

    tr {
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        background-color: white;
    }

    td {
        /* Make like a row */
        border: none;
        position: relative;
        padding-left: 45% !important;
        text-align: left !important;
        min-height: 45px;
        display: flex;
        align-items: center;
    }

    td:before {
        /* Add labels for each cell */
        content: attr(data-label);
        position: absolute;
        left: 0.75rem;
        width: 45%;
        padding-right: 0.5rem;
        white-space: nowrap;
        font-weight: bold;
        text-align: left;
        color: #333;
    }

    /* Image cell special styling */
    td:first-child {
        padding-left: 0 !important;
        display: flex;
        justify-content: center;
        padding-top: 1rem;
        padding-bottom: 0.5rem;
    }

    td:first-child:before {
        display: none;
    }

    /* Action button styling */
    td:last-child {
        padding: 0.75rem !important;
        display: flex;
        justify-content: center;
    }

    td:last-child:before {
        display: none;
    }

    td:last-child a {
        width: 100%;
        text-align: center;
        padding: 0.75rem;
    }

    /* Search and refresh button */
    .mb-4.flex {
        gap: 0.5rem !important;
    }

    #search-input {
        margin-bottom: 0.5rem;
    }
}

        .search-active .table-container {
            max-width: 80%;
        }

    </style>
    <script>
        let teachers = [];
        let filteredTeachers = [];
        let API_BASE_URL = "http://127.0.0.1:8000/";

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
                const response = await fetch(`${API_BASE_URL}api/Admin/teachers`);
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
    tableBody.innerHTML = "";

    if (filteredTeachers.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-gray-500">No teachers found.</td></tr>';
        return;
    }

    filteredTeachers.forEach(teacher => {
        const role = btoa('Teacher'); // Encode the role
        const encodedData = btoa(JSON.stringify(teacher)); // Encode teacher object

        // Ensure the correct placeholders are used
        const teacherDetailsUrl = teacherDetailsBaseRoute
            .replace('__PLACEHOLDER__', encodeURIComponent(encodedData))
            .replace('__ROLE__', encodeURIComponent(role));

        tableBody.innerHTML += `
            <tr class="border-b border-gray-300 text-center">
                <td class="px-4 py-2">
                    <img src="${teacher.image ? teacher.image : '{{ asset('images/male.png') }}'}" alt="Profile" class="w-12 h-12 rounded-full mx-auto">
                </td>
                <td class="px-4 py-2" data-label="Name">${teacher.name}</td>
                <td class="px-4 py-2" data-label="Username">${teacher.user.username}</td>
                <td class="px-4 py-2" data-label="Email">${teacher.user.email}</td>
                <td class="px-4 py-2" data-label="CNIC">${teacher.cnic}</td>
                <td class="px-4 py-2" data-label="Actions">
                    <a href="${teacherDetailsUrl}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        View
                    </a>
                </td>
            </tr>`;
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
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Teacher List</h2>

        <div class="mb-4 flex flex-col sm:flex-row justify-center items-center gap-4">
            <input type="text" id="search-input" class="border p-2 w-full sm:w-96" oninput="searchTeachers()" placeholder="Search by Name">
            <button onclick="resetSearch()" class="bg-gray-500 text-white px-4 py-2 rounded">Refresh</button>
        </div>
<div id="table-wrapper" class="table-container mx-auto w-full">

            <table class="border border-gray-300 shadow-lg bg-white w-full">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Email</th>

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
    </div>
    @include('components.footer')
</body>

</html>
