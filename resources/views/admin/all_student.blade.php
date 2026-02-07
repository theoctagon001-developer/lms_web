
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Ensure responsiveness */
        @media (max-width: 768px) {
            .search-container {
                flex-direction: column;
                gap: 10px;
            }
            .table-container {
                overflow-x: auto;
            }
        }/* Replace your existing style section with this */

/* Base styles */
.table-container {
    transition: all 0.3s ease-in-out;
}

/* Search container responsiveness */
.search-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.5rem;
}

/* Mobile-first table transformation */
@media (max-width: 768px) {
    .search-container {
        flex-direction: column;
        width: 100%;
    }

    .search-container input,
    .search-container select,
    .search-container button {
        width: 100%;
        margin-bottom: 0.5rem;
    }

    /* Card-style table transformation */
    table, thead, tbody, th, td, tr {
        display: block;
    }

    /* Hide table headers visually but keep them for screen readers */
    thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }

    tr {
        margin-bottom: 1.5rem;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        background-color: white;
    }

    td {
        /* Style as rows instead of columns */
        border: none;
        position: relative;
        padding-left: 50% !important;
        text-align: left !important;
        min-height: 45px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #f0f0f0;
    }

    td:last-child {
        border-bottom: none;
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

    /* Special styling for image cell */
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
}
    </style>

    <script>
        let students = [];
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

        async function loadStudents() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/AllStudent`);
                const data = await response.json();
                if (data.Student) {
                    students = data.Student;
                    renderStudents(students);
                }
            } catch (error) {
                console.error("Error fetching students:", error);
            }
        }

        function searchStudents() {
            const searchQuery = document.getElementById("search-name").value.toLowerCase();
            const sectionQuery = document.getElementById("search-section").value.toLowerCase();
            const cgpaFilter = document.getElementById("search-cgpa").value;
            const cgpaValue = parseFloat(document.getElementById("cgpa-value").value);

            let filteredStudents = students.filter(student => {
                const matchName = student.RegNo.toLowerCase().includes(searchQuery) ||
                                 student.name.toLowerCase().includes(searchQuery);

                const matchSection = student.section_id.toLowerCase().includes(sectionQuery);

                const matchCgpa = !cgpaValue ? true : (
                    cgpaFilter === "greater" ? student.cgpa >= cgpaValue :
                    cgpaFilter === "less" ? student.cgpa <= cgpaValue :
                    student.cgpa == cgpaValue
                );

                return matchName && matchSection && matchCgpa;
            });

            renderStudents(filteredStudents);
        }

        function resetSearch() {
            document.getElementById("search-name").value = "";
            document.getElementById("search-section").value = "";
            document.getElementById("search-cgpa").value = "greater";
            document.getElementById("cgpa-value").value = "";
            renderStudents(students);
        }

        function renderStudents(studentList) {
    const tableBody = document.getElementById("student-table-body");
    tableBody.innerHTML = "";

    if (studentList.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="10" class="text-center py-4 text-gray-500">No students found.</td></tr>';
        return;
    }

    studentList.forEach(student => {
        const encodedData = btoa(JSON.stringify(student)); // Encode student object in Base64
        const studentDetailsUrl = `{{ route('student.details', ['student' => '__PLACEHOLDER__']) }}`.replace('__PLACEHOLDER__', encodedData);

        tableBody.innerHTML += `
            <tr class="border-b border-gray-300 text-center">
                <td class="px-4 py-2">
                    <img src="${student.image || '{{ asset('images/male.png') }}'}" alt="Profile" class="w-12 h-12 rounded-full mx-auto">
                </td>
                <td class="px-4 py-2" data-label="Reg No">${student.RegNo}</td>
                <td class="px-4 py-2" data-label="Name">${student.name}</td>
                <td class="px-4 py-2" data-label="CGPA">${student.cgpa}</td>
                <td class="px-4 py-2" data-label="Guardian">${student.guardian}</td>
                <td class="px-4 py-2" data-label="Section">${student.section_id}</td>
                <td class="px-4 py-2" data-label="Program">${student.program.name}</td>
                <td class="px-4 py-2" data-label="Intake Session">${student.session.name}-${student.session.year}</td>
                <td class="px-4 py-2" data-label="Actions">
                    <a href="${studentDetailsUrl}" class="bg-blue-500 text-white px-4 py-2 rounded w-full block">View</a>
                </td>
            </tr>`;
    });
}
        document.addEventListener("DOMContentLoaded", loadStudents);
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
        <h2 class="text-2xl font-bold text-blue-700 text-center mb-4">Student List</h2>

        <div class="mb-4 flex flex-wrap justify-center gap-4 search-container">
            <input type="text" id="search-name" class="border p-2 w-full sm:w-72" oninput="searchStudents()" placeholder="Search by Reg No or Name">
            <input type="text" id="search-section" class="border p-2 w-full sm:w-72" oninput="searchStudents()" placeholder="Search by Section">

            <select id="search-cgpa" class="border p-2 w-full sm:w-36" onchange="searchStudents()">
                <option value="greater">≥ Greater than</option>
                <option value="equal">= Equal to</option>
                <option value="less">≤ Less than</option>
            </select>
            <input type="number" id="cgpa-value" class="border p-2 w-full sm:w-36" oninput="searchStudents()" placeholder="CGPA Value" step="0.01">

            <button onclick="resetSearch()" class="bg-gray-500 text-white px-4 py-2 rounded">Refresh</button>
        </div>

        <div class="table-container mx-auto max-w-6xl">
            <table class="border border-gray-300 shadow-lg bg-white w-full">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Reg No</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">CGPA</th>

                        <th class="px-4 py-2">Guardian</th>
                        <th class="px-4 py-2">Section</th>
                        <th class="px-4 py-2">Program</th>
                        <th class="px-4 py-2">Intake Session</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="student-table-body">
                    <tr><td colspan="10" class="text-center py-4 text-gray-500">Loading...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    @include('components.footer')
</body>
</html>

