{{-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .table-container {
            transition: all 0.3s ease-in-out;
        }
        .search-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
        }
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .pagination-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
            border-radius: 0.25rem;
        }

        .pagination-btn.active {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 1.5rem;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: 1rem;
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
                gap: 0.5rem;
            }

            td:last-child:before {
                display: none;
            }

            td:last-child a {
                width: 100%;
                text-align: center;
                padding: 0.5rem;
            }

            /* Modal adjustments for mobile */
            .modal-content {
                margin: 10% auto;
                width: 95%;
                padding: 1rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions button {
                width: 100%;
            }
        }

        /* Action buttons styling */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .view-btn {
            background-color: #3b82f6;
            color: white;
        }

        .edit-btn {
            background-color: #f59e0b;
            color: white;
        }

        .view-btn:hover, .edit-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Top action buttons */
        .top-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .top-actions button {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-btn {
            background-color: #10b981;
            color: white;
        }

        .bulk-add-btn {
            background-color: #6366f1;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('DATACELL.partials.nav')

    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4 flex-wrap gap-4">
            <h2 class="text-2xl font-bold text-blue-700">Student List</h2>
            <div class="top-actions">
                <button class="add-btn" onclick="window.location.href='{{ route('datacell.add.student') }}'">
                    <i class="fas fa-plus"></i> Add Student
                </button>
                <button class="bulk-add-btn" onclick="window.location.href='{{ route('datacell.add.student_excel') }}'">
                    <i class="fas fa-file-import"></i> Add Bulk Student
                </button>
            </div>
        </div>

        <div class="mb-4 flex flex-wrap justify-center gap-4 search-container">
            <input type="text" id="search-name" class="border p-2 w-full sm:w-72" oninput="searchStudents()" placeholder="Search by Reg No or Name">
            <input type="text" id="search-section" class="border p-2 w-full sm:w-72" oninput="searchStudents()" placeholder="Search by Section">

            <select id="search-cgpa" class="border p-2 w-full sm:w-36" onchange="searchStudents()">
                <option value="greater">≥ Greater than</option>
                <option value="equal">= Equal to</option>
                <option value="less">≤ Less than</option>
            </select>
            <input type="number" id="cgpa-value" class="border p-2 w-full sm:w-36" oninput="searchStudents()" placeholder="CGPA Value" step="0.01" min="0" max="4.00">

            <select id="items-per-page" class="border p-2 w-full sm:w-36" onchange="changeItemsPerPage()">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>

            <button onclick="resetSearch()" class="bg-gray-500 text-white px-4 py-2 rounded">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
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

        <div class="pagination-container">
            <button id="first-page" class="pagination-btn" onclick="goToPage(1)" disabled>
                <i class="fas fa-angle-double-left"></i>
            </button>
            <button id="prev-page" class="pagination-btn" onclick="prevPage()" disabled>
                <i class="fas fa-angle-left"></i>
            </button>
            <span id="page-info" class="px-2">Page 1 of 1</span>
            <button id="next-page" class="pagination-btn" onclick="nextPage()" disabled>
                <i class="fas fa-angle-right"></i>
            </button>
            <button id="last-page" class="pagination-btn" onclick="goToPage(1)" disabled>
                <i class="fas fa-angle-double-right"></i>
            </button>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 class="text-xl font-bold mb-4">Edit Student</h3>
            <form id="editStudentForm">
                <input type="hidden" id="edit-student-id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="edit-regno">Registration No</label>
                        <input type="text" id="edit-regno" name="RegNo">
                    </div>
                    <div class="form-group">
                        <label for="edit-name">Name</label>
                        <input type="text" id="edit-name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="edit-cgpa">CGPA</label>
                        <input type="number" id="edit-cgpa" name="cgpa" step="0.01" min="0" max="4.00">
                    </div>
                    <div class="form-group">
                        <label for="edit-gender">Gender</label>
                        <select id="edit-gender" name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-dob">Date of Birth</label>
                        <input type="date" id="edit-dob" name="date_of_birth">
                    </div>
                    <div class="form-group">
                        <label for="edit-guardian">Guardian</label>
                        <input type="text" id="edit-guardian" name="guardian">
                    </div>
                    <div class="form-group">
                        <label for="edit-section">Section</label>
                        <select id="edit-section" name="section_id"></select>
                    </div>
                    <div class="form-group">
                        <label for="edit-session">Session</label>
                        <select id="edit-session" name="session_id"></select>
                    </div>
                    <div class="form-group">
                        <label for="edit-status">Status</label>
                        <select id="edit-status" name="status">
                            <option value="UnderGraduate">UnderGraduate</option>
                            <option value="Graduate">Graduate</option>
                            <option value="Freeze">Freeze</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-program">Program</label>
                        <select id="edit-program" name="program_name">
                            <option value="BCS">BCS</option>
                            <option value="BSE">BSE</option>
                            <option value="BAI">BAI</option>
                            <option value="BIT">BIT</option>
                        </select>
                    </div>
                    <div class="form-group md:col-span-2">
                        <label for="edit-image">Profile Image</label>
                        <input type="file" id="edit-image" name="image" accept="image/jpeg,image/png,image/jpg">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    @include('components.footer')

    <script>
        let students = [];
        let filteredStudents = [];
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let currentPage = 1;
        let itemsPerPage = 10;
        let totalPages = 1;

        // DOM elements
        const editModal = document.getElementById("editModal");
        const closeBtn = document.querySelector(".close");
        const editForm = document.getElementById("editStudentForm");

        // Event listeners
        closeBtn.onclick = closeModal;
        window.onclick = function(event) {
            if (event.target == editModal) {
                closeModal();
            }
        };

        editForm.onsubmit = function(e) {
            e.preventDefault();
            updateStudent();
        };

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
                    filteredStudents = [...students];
                    renderStudents();
                    updatePagination();
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

            filteredStudents = students.filter(student => {
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

            currentPage = 1; // Reset to first page when searching
            renderStudents();
            updatePagination();
        }

        function resetSearch() {
            document.getElementById("search-name").value = "";
            document.getElementById("search-section").value = "";
            document.getElementById("search-cgpa").value = "greater";
            document.getElementById("cgpa-value").value = "";
            filteredStudents = [...students];
            currentPage = 1;
            renderStudents();
            updatePagination();
        }

        function changeItemsPerPage() {
            itemsPerPage = parseInt(document.getElementById("items-per-page").value);
            currentPage = 1;
            renderStudents();
            updatePagination();
        }

        function renderStudents() {
            const tableBody = document.getElementById("student-table-body");
            tableBody.innerHTML = "";

            if (filteredStudents.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="10" class="text-center py-4 text-gray-500">No students found.</td></tr>';
                return;
            }

            // Calculate pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredStudents.length);
            totalPages = Math.ceil(filteredStudents.length / itemsPerPage);

            for (let i = startIndex; i < endIndex; i++) {
                const student = filteredStudents[i];
                const encodedData = btoa(JSON.stringify(student));
                const studentDetailsUrl = `{{ route('datacell.student.details', ['student' => '__PLACEHOLDER__']) }}`.replace('__PLACEHOLDER__', encodedData);

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
                            <a href="${studentDetailsUrl}" class="action-btn view-btn">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button onclick="openEditModal('${student.id}')" class="action-btn edit-btn">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>`;
            }
        }

        function updatePagination() {
            document.getElementById("page-info").textContent = `Page ${currentPage} of ${totalPages}`;
            
            document.getElementById("first-page").disabled = currentPage === 1;
            document.getElementById("prev-page").disabled = currentPage === 1;
            document.getElementById("next-page").disabled = currentPage === totalPages || totalPages === 0;
            document.getElementById("last-page").disabled = currentPage === totalPages || totalPages === 0;
        }

        function goToPage(page) {
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                renderStudents();
                updatePagination();
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderStudents();
                updatePagination();
            }
        }

        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                renderStudents();
                updatePagination();
            }
        }

        async function openEditModal(studentId) {
            try {
                // Show loading state
                document.getElementById("edit-student-id").value = studentId;
                editModal.style.display = "block";

                // Fetch student details
                const response = await fetch(`${API_BASE_URL}api/Admin/AllStudent`);
                const data = await response.json();
                const student = data.Student.find(s => s.id == studentId);

                if (student) {
                    // Populate form fields
                    document.getElementById("edit-regno").value = student.RegNo || '';
                    document.getElementById("edit-name").value = student.name || '';
                    document.getElementById("edit-cgpa").value = student.cgpa || '';
                    document.getElementById("edit-gender").value = student.gender || 'Male';
                    document.getElementById("edit-dob").value = student.date_of_birth || '';
                    document.getElementById("edit-guardian").value = student.guardian || '';
                    document.getElementById("edit-status").value = student.status || 'UnderGraduate';
                    document.getElementById("edit-program").value = student.program.name || 'BCS';

                    // Load sections and sessions
                    await loadDropdowns();
                    
                    // Set section and session if available
                    if (student.section_id) {
                        document.getElementById("edit-section").value = student.section_id;
                    }
                    if (student.session_id) {
                        document.getElementById("edit-session").value = student.session_id;
                    }
                }
            } catch (error) {
                console.error("Error opening edit modal:", error);
                alert("Failed to load student details. Please try again.");
                closeModal();
            }
        }

        async function loadDropdowns() {
            try {
                // Load sections
                const sectionsResponse = await fetch(`${API_BASE_URL}api/Dropdown/AllSection`);
                const sectionsData = await sectionsResponse.json();
                const sectionSelect = document.getElementById("edit-section");
                sectionSelect.innerHTML = sectionsData.map(section => 
                    `<option value="${section.id}">${section.data}</option>`
                ).join('');

                // Load sessions
                const sessionsResponse = await fetch(`${API_BASE_URL}api/Dropdown/AllSession`);
                const sessionsData = await sessionsResponse.json();
                const sessionSelect = document.getElementById("edit-session");
                sessionSelect.innerHTML = sessionsData.map(session => 
                    `<option value="${session.id}">${session.name}</option>`
                ).join('');
            } catch (error) {
                console.error("Error loading dropdowns:", error);
            }
        }

        function closeModal() {
            editModal.style.display = "none";
            editForm.reset();
        }

        async function updateStudent() {
            const studentId = document.getElementById("edit-student-id").value;
            const formData = new FormData(editForm);
            
            // Remove empty fields before sending
            for (let [key, value] of formData.entries()) {
                if (value === '' || value === null) {
                    formData.delete(key);
                }
            }

            try {
                const response = await fetch(`${API_BASE_URL}api/Datacells/student/update/${studentId}`, {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (result.status) {
                    alert('Student updated successfully!');
                    closeModal();
                    loadStudents(); // Refresh the list
                } else {
                    alert(`Error: ${result.message || 'Failed to update student'}`);
                    if (result.errors) {
                        console.error('Validation errors:', result.errors);
                    }
                }
            } catch (error) {
                console.error("Error updating student:", error);
                alert("Failed to update student. Please try again.");
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            loadStudents();
            
            // Set CSRF token for AJAX requests
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                const meta = document.createElement('meta');
                meta.name = 'csrf-token';
                meta.content = '{{ csrf_token() }}';
                document.head.appendChild(meta);
            }
        });
    </script>
</body>
</html> --}}










{{-- CODE                                            11111111111111111111111111111 --}}






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    @vite('resources/css/app.css')
    
    <style>
        .table-container {
            transition: all 0.3s ease-in-out;
        }
        .search-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
        }
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .pagination-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
            border-radius: 0.25rem;
        }

        .pagination-btn.active {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 1.5rem;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: 1rem;
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
                gap: 0.5rem;
            }

            td:last-child:before {
                display: none;
            }

            td:last-child a {
                width: 100%;
                text-align: center;
                padding: 0.5rem;
            }

            /* Modal adjustments for mobile */
            .modal-content {
                margin: 10% auto;
                width: 95%;
                padding: 1rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions button {
                width: 100%;
            }
        }

        /* Action buttons styling */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .view-btn {
            background-color: #3b82f6;
            color: white;
        }

        .edit-btn {
            background-color: #f59e0b;
            color: white;
        }

        .view-btn:hover, .edit-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Top action buttons */
        .top-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .top-actions button {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-btn {
            background-color: #10b981;
            color: white;
        }

        .bulk-add-btn {
            background-color: #6366f1;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('DATACELL.partials.nav')

    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4 flex-wrap gap-4">
            <h2 class="text-2xl font-bold text-blue-700">Student List</h2>
            <div class="top-actions">
                <button class="add-btn" onclick="window.location.href='{{ route('datacell.add.student') }}'">
                    ➕ Add Student
                </button>
                <button class="bulk-add-btn" onclick="window.location.href='{{ route('datacell.add.student_excel') }}'">
                    📄 Add Bulk Student
                </button>
            </div>
        </div>

        <div class="mb-4 flex flex-wrap justify-center gap-4 search-container">
            <input type="text" id="search-name" class="border p-2 w-full sm:w-72" oninput="searchStudents()" placeholder="Search by Reg No or Name">
            <input type="text" id="search-section" class="border p-2 w-full sm:w-72" oninput="searchStudents()" placeholder="Search by Section">
            
            <select id="search-status" class="border p-2 w-full sm:w-36" onchange="searchStudents()">
                <option value="">All Status</option>
                <option value="UnderGraduate">UnderGraduate</option>
                <option value="Graduate">Graduate</option>
                <option value="Freeze">Freeze</option>
            </select>

            <select id="search-cgpa" class="border p-2 w-full sm:w-36" onchange="searchStudents()">
                <option value="greater">≥ Greater than</option>
                <option value="equal">= Equal to</option>
                <option value="less">≤ Less than</option>
            </select>
            <input type="number" id="cgpa-value" class="border p-2 w-full sm:w-36" oninput="searchStudents()" placeholder="CGPA Value" step="0.01" min="0" max="4.00">

            <select id="items-per-page" class="border p-2 w-full sm:w-36" onchange="changeItemsPerPage()">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>

            <button onclick="resetSearch()" class="bg-gray-500 text-white px-4 py-2 rounded">
                🔄 Refresh
            </button>
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
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="student-table-body">
                    <tr><td colspan="10" class="text-center py-4 text-gray-500">Loading...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            <button id="first-page" class="pagination-btn" onclick="goToPage(1)" disabled>
                «
            </button>
            <button id="prev-page" class="pagination-btn" onclick="prevPage()" disabled>
                ‹
            </button>
            <span id="page-info" class="px-2">Page 1 of 1</span>
            <button id="next-page" class="pagination-btn" onclick="nextPage()" disabled>
                ›
            </button>
            <button id="last-page" class="pagination-btn" onclick="goToPage(1)" disabled>
                »
            </button>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h3 class="text-xl font-bold mb-4">Edit Student</h3>
            <form id="editStudentForm">
                <input type="hidden" id="edit-student-id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="edit-regno">Registration No</label>
                        <input type="text" id="edit-regno" name="RegNo">
                    </div>
                    <div class="form-group">
                        <label for="edit-name">Name</label>
                        <input type="text" id="edit-name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="edit-cgpa">CGPA</label>
                        <input type="number" id="edit-cgpa" name="cgpa" step="0.01" min="0" max="4.00">
                    </div>
                    <div class="form-group">
                        <label for="edit-gender">Gender</label>
                        <select id="edit-gender" name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-dob">Date of Birth</label>
                        <input type="date" id="edit-dob" name="date_of_birth">
                    </div>
                    <div class="form-group">
                        <label for="edit-guardian">Guardian</label>
                        <input type="text" id="edit-guardian" name="guardian">
                    </div>
                    <div class="form-group">
                        <label for="edit-section">Section</label>
                        <select id="edit-section" name="section_id"></select>
                    </div>
                    <div class="form-group">
                        <label for="edit-session">Session</label>
                        <select id="edit-session" name="session_id"></select>
                    </div>
                    <div class="form-group">
                        <label for="edit-status">Status</label>
                        <select id="edit-status" name="status">
                            <option value="UnderGraduate">UnderGraduate</option>
                            <option value="Graduate">Graduate</option>
                            <option value="Freeze">Freeze</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-program">Program</label>
                        <select id="edit-program" name="program_name">
                            <option value="BCS">BCS</option>
                            <option value="BSE">BSE</option>
                            <option value="BAI">BAI</option>
                            <option value="BIT">BIT</option>
                        </select>
                    </div>
                    <div class="form-group md:col-span-2">
                        <label for="edit-image">Profile Image</label>
                        <input type="file" id="edit-image" name="image" accept="image/jpeg,image/png,image/jpg">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    @include('components.footer')

    <script>
        let students = [];
        let filteredStudents = [];
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let currentPage = 1;
        let itemsPerPage = 10;
        let totalPages = 1;

        // DOM elements
        const editModal = document.getElementById("editModal");
        const closeBtn = document.querySelector(".close");
        const editForm = document.getElementById("editStudentForm");

        // Event listeners
        closeBtn.onclick = closeModal;
        window.onclick = function(event) {
            if (event.target == editModal) {
                closeModal();
            }
        };

        editForm.onsubmit = function(e) {
            e.preventDefault();
            updateStudent();
        };

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
                    filteredStudents = [...students];
                    renderStudents();
                    updatePagination();
                }
            } catch (error) {
                console.error("Error fetching students:", error);
            }
        }

        function searchStudents() {
            const searchQuery = document.getElementById("search-name").value.toLowerCase();
            const sectionQuery = document.getElementById("search-section").value.toLowerCase();
            const statusQuery = document.getElementById("search-status").value;
            const cgpaFilter = document.getElementById("search-cgpa").value;
            const cgpaValue = parseFloat(document.getElementById("cgpa-value").value);

            filteredStudents = students.filter(student => {
                const matchName = student.RegNo.toLowerCase().includes(searchQuery) ||
                                 student.name.toLowerCase().includes(searchQuery);

                const matchSection = student.section_id.toLowerCase().includes(sectionQuery);
                
                const matchStatus = !statusQuery ? true : student.status === statusQuery;

                const matchCgpa = !cgpaValue ? true : (
                    cgpaFilter === "greater" ? student.cgpa >= cgpaValue :
                    cgpaFilter === "less" ? student.cgpa <= cgpaValue :
                    student.cgpa == cgpaValue
                );

                return matchName && matchSection && matchStatus && matchCgpa;
            });

            currentPage = 1; // Reset to first page when searching
            renderStudents();
            updatePagination();
        }

        function resetSearch() {
            document.getElementById("search-name").value = "";
            document.getElementById("search-section").value = "";
            document.getElementById("search-status").value = "";
            document.getElementById("search-cgpa").value = "greater";
            document.getElementById("cgpa-value").value = "";
            filteredStudents = [...students];
            currentPage = 1;
            renderStudents();
            updatePagination();
        }

        function changeItemsPerPage() {
            itemsPerPage = parseInt(document.getElementById("items-per-page").value);
            currentPage = 1;
            renderStudents();
            updatePagination();
        }

        function renderStudents() {
            const tableBody = document.getElementById("student-table-body");
            tableBody.innerHTML = "";

            if (filteredStudents.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="10" class="text-center py-4 text-gray-500">No students found.</td></tr>';
                return;
            }

            // Calculate pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredStudents.length);
            totalPages = Math.ceil(filteredStudents.length / itemsPerPage);

            for (let i = startIndex; i < endIndex; i++) {
                const student = filteredStudents[i];
                const encodedData = btoa(JSON.stringify(student));
                const studentDetailsUrl = `{{ route('datacell.student.details', ['student' => '__PLACEHOLDER__']) }}`.replace('__PLACEHOLDER__', encodedData);

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
                        <td class="px-4 py-2" data-label="Status">${student.status || 'N/A'}</td>
                        <td class="px-4 py-2" data-label="Actions">
                            <a href="${studentDetailsUrl}" class="action-btn view-btn">
                                👁️
                            </a>
                            <button onclick="openEditModal('${student.id}')" class="action-btn edit-btn">
                                ✏️
                            </button>
                        </td>
                    </tr>`;
            }
        }

        function updatePagination() {
            document.getElementById("page-info").textContent = `Page ${currentPage} of ${totalPages}`;
            
            document.getElementById("first-page").disabled = currentPage === 1;
            document.getElementById("prev-page").disabled = currentPage === 1;
            document.getElementById("next-page").disabled = currentPage === totalPages || totalPages === 0;
            document.getElementById("last-page").disabled = currentPage === totalPages || totalPages === 0;
        }

        function goToPage(page) {
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                renderStudents();
                updatePagination();
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderStudents();
                updatePagination();
            }
        }

        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                renderStudents();
                updatePagination();
            }
        }

        async function openEditModal(studentId) {
            try {
                // Show loading state
                document.getElementById("edit-student-id").value = studentId;
                editModal.style.display = "block";

                // Fetch student details
                const response = await fetch(`${API_BASE_URL}api/Admin/AllStudent`);
                const data = await response.json();
                const student = data.Student.find(s => s.id == studentId);

                if (student) {
                    // Populate form fields
                    document.getElementById("edit-regno").value = student.RegNo || '';
                    document.getElementById("edit-name").value = student.name || '';
                    document.getElementById("edit-cgpa").value = student.cgpa || '';
                    document.getElementById("edit-gender").value = student.gender || 'Male';
                    document.getElementById("edit-dob").value = student.date_of_birth || '';
                    document.getElementById("edit-guardian").value = student.guardian || '';
                    document.getElementById("edit-status").value = student.status || 'UnderGraduate';
                    document.getElementById("edit-program").value = student.program.name || 'BCS';

                    // Load sections and sessions
                    await loadDropdowns();
                    
                    // Set section and session if available
                    if (student.section_id) {
                        document.getElementById("edit-section").value = student.section_id;
                    }
                    if (student.session_id) {
                        document.getElementById("edit-session").value = student.session_id;
                    }
                }
            } catch (error) {
                console.error("Error opening edit modal:", error);
                alert("Failed to load student details. Please try again.");
                closeModal();
            }
        }

        async function loadDropdowns() {
            try {
                // Load sections
                const sectionsResponse = await fetch(`${API_BASE_URL}api/Dropdown/AllSection`);
                const sectionsData = await sectionsResponse.json();
                const sectionSelect = document.getElementById("edit-section");
                sectionSelect.innerHTML = sectionsData.map(section => 
                    `<option value="${section.id}">${section.data}</option>`
                ).join('');

                // Load sessions
                const sessionsResponse = await fetch(`${API_BASE_URL}api/Dropdown/AllSession`);
                const sessionsData = await sessionsResponse.json();
                const sessionSelect = document.getElementById("edit-session");
                sessionSelect.innerHTML = sessionsData.map(session => 
                    `<option value="${session.id}">${session.name}</option>`
                ).join('');
            } catch (error) {
                console.error("Error loading dropdowns:", error);
            }
        }

        function closeModal() {
            editModal.style.display = "none";
            editForm.reset();
        }

        async function updateStudent() {
            const studentId = document.getElementById("edit-student-id").value;
            const formData = new FormData(editForm);
            
            // Remove empty fields before sending
            for (let [key, value] of formData.entries()) {
                if (value === '' || value === null) {
                    formData.delete(key);
                }
            }

            try {
                const response = await fetch(`${API_BASE_URL}api/Datacells/student/update/${studentId}`, {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (result.status) {
                    alert('Student updated successfully!');
                    closeModal();
                    loadStudents(); // Refresh the list
                } else {
                    alert(`Error: ${result.message || 'Failed to update student'}`);
                    if (result.errors) {
                        console.error('Validation errors:', result.errors);
                    }
                }
            } catch (error) {
                console.error("Error updating student:", error);
                alert("Failed to update student. Please try again.");
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            loadStudents();
            
            // Set CSRF token for AJAX requests
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                const meta = document.createElement('meta');
                meta.name = 'csrf-token';
                meta.content = '{{ csrf_token() }}';
                document.head.appendChild(meta);
            }
        });
    </script>
</body>
</html>
