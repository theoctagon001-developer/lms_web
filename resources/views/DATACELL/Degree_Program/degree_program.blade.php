<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Degree Courses Management</title>
    @vite('resources/css/app.css')
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
            display: none;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .semester-header {
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1rem;
            margin-top: 1.5rem;
            border-radius: 0.375rem 0.375rem 0 0;
        }
        .program-header {
            background-color: #1e40af;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1rem;
            margin-top: 2rem;
            border-radius: 0.375rem;
        }
        .batch-header {
            background-color: #1e3a8a;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1rem;
            margin-top: 2.5rem;
            border-radius: 0.375rem;
        }
        .btn-remove {
            background-color: #ef4444;
            color: white;
        }
        .btn-remove:hover {
            background-color: #dc2626;
        }
        .btn-edit {
            background-color: #3b82f6;
            color: white;
        }
        .btn-edit:hover {
            background-color: #2563eb;
        }
        .btn-add {
            background-color: #10b981;
            color: white;
        }
        .btn-add:hover {
            background-color: #059669;
        }
        .btn-filter {
            background-color: #f59e0b;
            color: white;
        }
        .btn-filter:hover {
            background-color: #d97706;
        }
        .action-btn {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            margin-left: 0.5rem;
            font-size: 0.875rem;
        }
        .filter-container {
            background-color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }
        .course-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }
        .course-table th {
            background-color: #60a5fa;
            color: white;
            padding: 0.75rem 1rem;
            text-align: left;
        }
        .course-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .course-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .course-table tr:hover {
            background-color: #f1f5f9;
        }
        .empty-semester {
            background-color: #f3f4f6;
            padding: 1rem;
            text-align: center;
            color: #6b7280;
            border-radius: 0 0 0.375rem 0.375rem;
            margin-bottom: 1.5rem;
        }
        .add-course-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 50;
        }
        @media (max-width: 768px) {
            .course-table {
                display: block;
                overflow-x: auto;
            }
            .filter-container .grid {
                grid-template-columns: 1fr;
            }
            .add-course-btn {
                bottom: 1rem;
                right: 1rem;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('DATACELL.partials.nav')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-6">Degree Courses Management</h2>

        <!-- Filter Section -->
        <div class="filter-container">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Filter Courses</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Batch</label>
                    <select id="filter-batch" class="border rounded-lg p-2 w-full">
                        <option value="">All Batches</option>
                        <!-- Will be populated by API -->
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Program</label>
                    <select id="filter-program" class="border rounded-lg p-2 w-full">
                        <option value="">All Programs</option>
                        <option value="BCS">BCS</option>
                        <option value="BSE">BSE</option>
                        <option value="BAI">BAI</option>
                        <option value="BIT">BIT</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button id="apply-filter-btn" class="btn-filter px-4 py-2 rounded-lg w-full">
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div id="content-area">
            <div id="loader" class="loader"></div>
            <div id="no-results" class="p-4 text-center text-gray-500 hidden">
                No degree courses found matching your criteria.
            </div>
            <div id="courses-container">
                <!-- Courses will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Add Course Modal -->
    <div id="add-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Add New Course</h3>
                <button onclick="closeModal('add-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Program</label>
                    <select id="program-select" class="border rounded-lg p-2 w-full">
                        <option value="">Select Program</option>
                        <option value="BCS">BCS</option>
                        <option value="BSE">BSE</option>
                        <option value="BAI">BAI</option>
                        <option value="BIT">BIT</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Semester</label>
                    <select id="semester-select" class="border rounded-lg p-2 w-full">
                        <option value="">Select Semester</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                        <option value="3">Semester 3</option>
                        <option value="4">Semester 4</option>
                        <option value="5">Semester 5</option>
                        <option value="6">Semester 6</option>
                        <option value="7">Semester 7</option>
                        <option value="8">Semester 8</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Batch</label>
                    <select id="session-select" class="border rounded-lg p-2 w-full">
                        <option value="">Select Batch</option>
                        <!-- Will be populated by API -->
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Course</label>
                    <select id="course-select" class="border rounded-lg p-2 w-full">
                        <option value="">Select Course</option>
                        <!-- Will be populated by API -->
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('add-modal')" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="addNewCourse()" class="btn-add px-4 py-2 rounded-md">Add Course</button>
            </div>
            <div id="add-modal-loader" class="loader"></div>
            <div id="add-modal-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Update Semester</h3>
                <button onclick="closeModal('edit-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">New Semester</label>
                <select id="edit-semester-select" class="border rounded-lg p-2 w-full">
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                    <option value="5">Semester 5</option>
                    <option value="6">Semester 6</option>
                    <option value="7">Semester 7</option>
                    <option value="8">Semester 8</option>
                </select>
            </div>
            <input type="hidden" id="edit-course-id">
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('edit-modal')" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="updateCourseSemester()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
            </div>
            <div id="edit-modal-loader" class="loader"></div>
            <div id="edit-modal-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <!-- Add Course Floating Button -->
    <button id="open-add-modal" class="add-course-btn btn-add px-4 py-3 rounded-full shadow-lg">
        ＋ Add Course
    </button>

    <script>
        let API_BASE_URL = "http://127.0.0.1:8000/";
        let allCourses = {};
        let allSessions = [];
        let allCourseData = [];
        let filteredCourses = {};

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        async function loadInitialData() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                document.getElementById('loader').style.display = 'block';
                
                // Load all data in parallel
                const [sessionsResponse, coursesResponse, degreeCoursesResponse] = await Promise.all([
                    fetch(`${API_BASE_URL}api/Dropdown/AllSession`),
                    fetch(`${API_BASE_URL}api/Dropdown/AllCourseData`),
                    fetch(`${API_BASE_URL}api/Insertion/AllDegreeCourses`)
                ]);

                const [sessionsData, coursesData, degreeCoursesData] = await Promise.all([
                    sessionsResponse.json(),
                    coursesResponse.json(),
                    degreeCoursesResponse.json()
                ]);

                allSessions = sessionsData;
                allCourseData = coursesData;
                allCourses = degreeCoursesData;
                filteredCourses = JSON.parse(JSON.stringify(allCourses));

                // Populate dropdowns
                populateSessionDropdowns();
                populateCourseDropdown();
                renderCourses();
            } catch (error) {
                console.error("Error loading initial data:", error);
                showAlert('error', 'Failed to load data. Please try again.');
            } finally {
                document.getElementById('loader').style.display = 'none';
            }
        }

        function populateSessionDropdowns() {
            // For filter dropdown
            const filterSelect = document.getElementById('filter-batch');
            filterSelect.innerHTML = '<option value="">All Batches</option>';
            
            // For add modal dropdown
            const addSelect = document.getElementById('session-select');
            addSelect.innerHTML = '<option value="">Select Batch</option>';
            
            allSessions.forEach(session => {
                const option1 = document.createElement('option');
                option1.value = session.name;
                option1.textContent = session.name;
                filterSelect.appendChild(option1);

                const option2 = document.createElement('option');
                option2.value = session.id;
                option2.textContent = session.name;
                addSelect.appendChild(option2);
            });
        }

        function populateCourseDropdown() {
            const select = document.getElementById('course-select');
            select.innerHTML = '<option value="">Select Course</option>';
            
            allCourseData.forEach(course => {
                const option = document.createElement('option');
                option.value = course.id;
                option.textContent = `${course.code} - ${course.course}`;
                select.appendChild(option);
            });
        }

        function applyFilters() {
            const batchFilter = document.getElementById('filter-batch').value;
            const programFilter = document.getElementById('filter-program').value;
            
            filteredCourses = {};
            
            // If no filters selected, show all
            if (!batchFilter && !programFilter) {
                filteredCourses = JSON.parse(JSON.stringify(allCourses));
                renderCourses();
                return;
            }
            
            // Apply filters
            for (const [batchName, programs] of Object.entries(allCourses)) {
                // Filter by batch
                if (batchFilter && !batchName.includes(batchFilter)) {
                    continue;
                }
                
                const filteredPrograms = {};
                for (const [programName, semesters] of Object.entries(programs)) {
                    // Filter by program
                    if (programFilter && programName !== programFilter) {
                        continue;
                    }
                    
                    filteredPrograms[programName] = semesters;
                }
                
                if (Object.keys(filteredPrograms).length > 0) {
                    filteredCourses[batchName] = filteredPrograms;
                }
            }
            
            renderCourses();
        }

        function renderCourses() {
            const container = document.getElementById('courses-container');
            container.innerHTML = '';

            if (Object.keys(filteredCourses).length === 0) {
                document.getElementById('no-results').classList.remove('hidden');
                return;
            }

            document.getElementById('no-results').classList.add('hidden');

            // Iterate through each batch (session)
            for (const [batchName, programs] of Object.entries(filteredCourses)) {
                const batchSection = document.createElement('div');
                
                const batchHeader = document.createElement('div');
                batchHeader.className = 'batch-header';
                batchHeader.textContent = `Batch: ${batchName}`;
                batchSection.appendChild(batchHeader);

                // Iterate through each program in the batch
                for (const [programName, semesters] of Object.entries(programs)) {
                    const programSection = document.createElement('div');
                    
                    const programHeader = document.createElement('div');
                    programHeader.className = 'program-header';
                    programHeader.textContent = `Program: ${programName}`;
                    programSection.appendChild(programHeader);

                    // Show all semesters 1-8, even if empty
                    for (let semester = 1; semester <= 8; semester++) {
                        const semesterSection = document.createElement('div');
                        
                        const semesterHeader = document.createElement('div');
                        semesterHeader.className = 'semester-header';
                        semesterHeader.textContent = `Semester ${semester}`;
                        semesterSection.appendChild(semesterHeader);

                        const semesterData = semesters[semester] || [];
                        
                        if (semesterData.length === 0) {
                            const emptyMsg = document.createElement('div');
                            emptyMsg.className = 'empty-semester';
                            emptyMsg.textContent = 'No courses in this semester';
                            semesterSection.appendChild(emptyMsg);
                        } else {
                            // Create table for courses
                            const table = document.createElement('table');
                            table.className = 'course-table';
                            
                            const thead = document.createElement('thead');
                            thead.innerHTML = `
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            `;
                            table.appendChild(thead);
                            
                            const tbody = document.createElement('tbody');
                            semesterData.forEach((course, index) => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${index + 1}</td>
                                    <td>${course.course_code}</td>
                                    <td>${course.course_name}</td>
                                    <td>
                                        <button onclick="openEditModal(${course.id}, ${course.semester})" class="btn-edit action-btn">Edit</button>
                                        <button onclick="deleteCourse(${course.id})" class="btn-remove action-btn">Remove</button>
                                    </td>
                                `;
                                tbody.appendChild(row);
                            });
                            table.appendChild(tbody);
                            semesterSection.appendChild(table);
                        }
                        
                        programSection.appendChild(semesterSection);
                    }
                    
                    batchSection.appendChild(programSection);
                }
                
                container.appendChild(batchSection);
            }
        }

        async function addNewCourse() {
            const program = document.getElementById('program-select').value;
            const semester = document.getElementById('semester-select').value;
            const sessionId = document.getElementById('session-select').value;
            const courseId = document.getElementById('course-select').value;
            
            if (!program || !semester || !sessionId || !courseId) {
                showModalMessage('add-modal-message', 'Please fill all fields', 'error');
                return;
            }
            
            try {
                document.getElementById('add-modal-loader').style.display = 'block';
                document.getElementById('add-modal-message').classList.add('hidden');
                
                const response = await fetch(`${API_BASE_URL}api/Insertion/addDegreeCourse`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                       
                    },
                    body: JSON.stringify({
                        semester: semester,
                        program_name: program,
                        course_id: courseId,
                        session_id: sessionId
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showModalMessage('add-modal-message', data.message || 'Course added successfully', 'success');
                    // Reload the data
                    await loadInitialData();
                    // Close modal after delay
                    setTimeout(() => {
                        closeModal('add-modal');
                    }, 1500);
                } else {
                    showModalMessage('add-modal-message', data.message || 'Failed to add course', 'error');
                }
            } catch (error) {
                console.error('Error adding course:', error);
                showModalMessage('add-modal-message', 'An error occurred while adding the course', 'error');
            } finally {
                document.getElementById('add-modal-loader').style.display = 'none';
            }
        }

        async function deleteCourse(id) {
            if (!confirm('Are you sure you want to remove this course?')) {
                return;
            }
            
            try {
                const response = await fetch(`${API_BASE_URL}api/Insertion/deleteDegreeCourse/${id}`, {
                    method: 'DELETE',
                    
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showAlert('success', data.message || 'Course removed successfully');
                    // Reload the data
                    await loadInitialData();
                } else {
                    showAlert('error', data.message || 'Failed to remove course');
                }
            } catch (error) {
                console.error('Error removing course:', error);
                showAlert('error', 'An error occurred while removing the course');
            }
        }

        function openEditModal(id, currentSemester) {
            document.getElementById('edit-course-id').value = id;
            document.getElementById('edit-semester-select').value = currentSemester;
            document.getElementById('edit-modal-message').classList.add('hidden');
            document.getElementById('edit-modal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        async function updateCourseSemester() {
            const id = document.getElementById('edit-course-id').value;
            const newSemester = document.getElementById('edit-semester-select').value;
            
            if (!id || !newSemester) {
                showModalMessage('edit-modal-message', 'Please select a semester', 'error');
                return;
            }
            
            try {
                document.getElementById('edit-modal-loader').style.display = 'block';
                
                const response = await fetch(`${API_BASE_URL}api/Insertion/updateDegreeCourse/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                       
                    },
                    body: JSON.stringify({
                        semester: newSemester
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showModalMessage('edit-modal-message', data.message || 'Semester updated successfully', 'success');
                    // Close modal and reload after delay
                    setTimeout(() => {
                        closeModal('edit-modal');
                        loadInitialData();
                    }, 1500);
                } else {
                    showModalMessage('edit-modal-message', data.message || 'Failed to update semester', 'error');
                }
            } catch (error) {
                console.error('Error updating semester:', error);
                showModalMessage('edit-modal-message', 'An error occurred while updating the semester', 'error');
            } finally {
                document.getElementById('edit-modal-loader').style.display = 'none';
            }
        }

        function showModalMessage(elementId, message, type) {
            const element = document.getElementById(elementId);
            element.textContent = message;
            element.classList.remove('hidden');
            
            if (type === 'success') {
                element.className = element.className.replace(/text-red-500/g, '') + ' text-green-500';
            } else {
                element.className = element.className.replace(/text-green-500/g, '') + ' text-red-500';
            }
        }

        function showAlert(type, message) {
            alert(`${type.toUpperCase()}: ${message}`);
        }

        // Initialize the page
        document.addEventListener("DOMContentLoaded", function() {
            loadInitialData();
            document.getElementById('apply-filter-btn').addEventListener('click', applyFilters);
            document.getElementById('open-add-modal').addEventListener('click', () => {
                document.getElementById('add-modal').style.display = 'flex';
            });
        });
    </script>

    @include('components.footer')
</body>

</html>