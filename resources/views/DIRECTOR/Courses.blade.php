<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List | Director Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --secondary: #f9fafb;
            --text: #1f2937;
            --text-light: #6b7280;
            --border: #e5e7eb;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background-color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sticky-top-container {
            background-color: white;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .sticky-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            max-width: 100%;
            margin: 0 auto;
        }

        .sticky-top-bar h1 {
            font-weight: 600;
            color: var(--primary);
            cursor: pointer;
            transition: color 0.2s;
        }

        .sticky-top-bar h1:hover {
            color: var(--primary-dark);
        }

        .main-container {
            flex: 1;
            padding: 2rem 1rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--primary);
            border-radius: 3px;
        }

        .search-container {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        .search-inputs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .search-input {
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: white;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background-color: var(--secondary);
        }

        .table-container {
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: var(--primary);
            color: white;
            font-weight: 500;
            padding: 1rem;
            text-align: left;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: var(--secondary);
        }

        .footer {
            background-color: white;
            padding: 1.5rem 0;
            margin-top: auto;
            box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.1);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            text-align: center;
            color: var(--text-light);
            font-size: 0.875rem;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .sticky-top-bar {
                padding: 0.75rem 1rem;
            }
            
            .main-container {
                padding: 1rem;
            }
            
            .search-inputs {
                grid-template-columns: 1fr;
            }
            
            .table-container {
                border-radius: 0;
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
                border: 1px solid var(--border);
                border-radius: 0.5rem;
                padding: 0.5rem;
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
                font-weight: 600;
                color: var(--text);
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
                document.getElementById("course-table-body").innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4 text-red-500">
                            Failed to load courses. Please try again later.
                        </td>
                    </tr>`;
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
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            <i class="fas fa-search mr-2"></i>No courses found matching your criteria
                        </td>
                    </tr>`;
                return;
            }

            filteredCourses.forEach(course => {
                tableBody.innerHTML += `
                    <tr>
                        <td data-label="Code">${course.code}</td>
                        <td data-label="Name">${course.name}</td>
                        <td data-label="Credit Hours">${course.credit_hours}</td>
                        <td data-label="Pre-Req">${course.pre_req_main || '-'}</td>
                        <td data-label="Lab">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${course.lab == 1 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                                ${course.lab == 1 ? 'Lab' : 'No Lab'}
                            </span>
                        </td>
                        <td data-label="Short Form">${course.description || '-'}</td>
                    </tr>`;
            });
        }

        function navigateToDashboard() {
            window.location.href = "{{ route('director.dashboard') }}";
        }

        document.addEventListener("DOMContentLoaded", loadCourses);
    </script>
</head>
<body>
    <div class="sticky-top-container">
        <div class="sticky-top-bar">
            <div class="flex items-center">
                <h1 class="text-xl font-bold text-blue-600" onclick="navigateToDashboard()">
                    <i ></i>Director <span class="hidden sm:inline"></span>
                </h1>
            </div>
            @include('DIRECTOR.Profile')
        </div>
    </div>

    <div class="main-container">
        <h2 class="page-title">Course List</h2>

        <div class="search-container">
            <div class="search-inputs">
                <input type="text" id="search-name" class="search-input" oninput="searchCourses()" placeholder="Search by Course Name">
                <input type="text" id="search-code" class="search-input" oninput="searchCourses()" placeholder="Search by Course Code">
            </div>
            <div class="flex justify-end gap-2">
                <button onclick="resetSearch()" class="btn btn-secondary">
                    <i class="fas fa-sync-alt mr-2"></i>Reset
                </button>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Credit Hours</th>
                        <th>Pre-Req</th>
                        <th>Lab</th>
                        <th>Short Form</th>
                    </tr>
                </thead>
                <tbody id="course-table-body">
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Loading courses...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            © Sharjeel | Ali | Sameer Learning Management System
        </div>
    </footer>

    @include('components.loader')
</body>
</html>