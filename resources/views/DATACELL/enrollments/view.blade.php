<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrolments Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
            max-width: 500px;
        }

        .enrolment-card {
            display: none;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: white;
        }

        .enrolment-card .field {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .enrolment-card .field-label {
            font-weight: 600;
            color: #4a5568;
        }

        .enrolment-card .field-value {
            text-align: right;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .enrolment-table {
            min-width: 100%;
            width: auto;
        }

        @media (max-width: 768px) {
            .desktop-table {
                display: none;
            }
            .enrolment-card {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .desktop-table {
                display: block;
            }
            .enrolment-card {
                display: none;
            }
        }

        .edit-icon {
            cursor: pointer;
            margin-left: 5px;
        }

        .no-result-message {
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin: 20px 0;
        }

        .course-info {
            background-color: white;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .course-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .input-error {
            border-color: #ef4444;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: none;
        }

        .action-btn {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            margin: 0 0.125rem;
        }

        .action-btn.edit {
            background-color: #3b82f6;
            color: white;
        }

        .action-btn.delete {
            background-color: #ef4444;
            color: white;
        }

        .collapsible {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .collapsible-header {
            padding: 1rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f1f5f9;
        }

        .collapsible-content {
            padding: 1rem;
            display: none;
        }

        .collapsible.active .collapsible-content {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('DATACELL.partials.nav')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Enrolments Management</h2>
        <!-- Action Buttons -->
       <div class="mb-6 flex flex-wrap gap-4 justify-end">
    
     <a href="{{ route('datacell.add.enroll_excel') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
         📤 Upload Enrolments ( Excel )
    </a>
    <button id="offer-course-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
        ➕ Offer New Course
    </button>
    <a href="{{ route('enrolments.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center">
        👥 Add New Enrolment
    </a>
</div>

        <!-- Offer New Course Panel -->
        <div id="offer-course-panel" class="collapsible mb-6">
            <div class="collapsible-header">
                <h3 class="text-lg font-semibold">Offer New Course</h3>
                <span>➕</span>
            </div>
            <div class="collapsible-content">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Session</label>
                        <select id="session-dropdown" class="border rounded-lg p-2 w-full">
                            <option value="">Select Session</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Course</label>
                        <select id="course-dropdown" class="border rounded-lg p-2 w-full" disabled>
                            <option value="">Select Course</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button id="offer-course-submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Offer Course
                    </button>
                </div>
                <div id="offer-course-loader" class="loader"></div>
                <div id="offer-course-message" class="mt-2 text-sm hidden"></div>
            </div>
        </div>

        <!-- Enrolments Report Section -->
        <div class="mb-6 p-4 bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Enrolments Report Filters</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Session Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Session</label>
                    <select id="report-session-dropdown" class="border rounded-lg p-2 w-full" onchange="loadReportCourses()">
                        <option value="">Select Session</option>
                    </select>
                </div>

                <!-- Course Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Course</label>
                    <select id="report-course-dropdown" class="border rounded-lg p-2 w-full" onchange="loadReportSections()" disabled>
                        <option value="">Select Course</option>
                    </select>
                </div>

                <!-- Section Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Section</label>
                    <select id="report-section-dropdown" class="border rounded-lg p-2 w-full" onchange="loadEnrolments()" disabled>
                        <option value="">Select Section</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Course Info Section -->
        <div id="course-info-container" class="hidden">
            <div class="course-info">
                <h3 class="text-xl font-semibold text-gray-800 mb-3" id="course-title"></h3>
                <div class="course-info-grid">
                    <div>
                        <p><span class="font-medium">Session:</span> <span id="course-session"></span></p>
                        <p><span class="font-medium">Section:</span> <span id="course-section"></span></p>
                    </div>
                    <div>
                        <p><span class="font-medium">Credit Hours:</span> <span id="course-credits"></span></p>
                        <p><span class="font-medium">Lab Course:</span> <span id="course-lab"></span></p>
                    </div>
                </div>
            </div>

            <!-- Student Search -->
            <div id="student-search-container" class="bg-white shadow-md rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Search Students</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Student Name</label>
                        <input type="text" id="search-name" class="border rounded-lg p-2 w-full" 
                               placeholder="Enter student name" oninput="filterStudents()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Registration No</label>
                        <input type="text" id="search-regno" class="border rounded-lg p-2 w-full" 
                               placeholder="Enter registration no" oninput="filterStudents()">
                    </div>
                </div>
                <div class="mt-4">
                    <button onclick="resetStudentSearch()" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        Reset Search
                    </button>
                </div>
            </div>
        </div>

        <!-- Desktop Table View -->
        <div id="enrolment-data-container" class="hidden">
            <div class="bg-white shadow-md rounded-lg overflow-hidden desktop-table">
                <div class="table-container">
                    <table class="enrolment-table min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Image</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Reg No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Semester</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="enrolment-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Enrolments will be loaded here -->
                        </tbody>
                    </table>
                </div>
                <div id="no-results" class="p-4 text-center text-gray-500 hidden">
                    No enrolments found matching your criteria.
                </div>
                <div id="loader" class="loader"></div>
            </div>

            <!-- Mobile Card View -->
            <div id="enrolment-card-container">
                <!-- Enrolment cards will be loaded here -->
            </div>
        </div>

        <!-- No Result Message -->
        <div id="no-enrolment-message" class="no-result-message hidden">
            <p class="text-lg text-gray-600">No enrolment data exists for the selected criteria.</p>
        </div>
    </div>

    <!-- Edit Enrolment Modal -->
    <div id="edit-enrolment-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Enrolment</h3>
                <button onclick="closeModal('edit-enrolment-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Student Name</label>
                <input type="text" id="edit-student-name" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Registration No</label>
                <input type="text" id="edit-reg-no" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Semester</label>
                <input type="text" id="edit-semester" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Section</label>
                <select id="edit-section" class="border rounded-lg p-2 w-full">
                    <option value="">Select Section</option>
                </select>
            </div>

            <input type="hidden" id="edit-student-offered-course-id">

            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('edit-enrolment-modal')" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="updateEnrolment()" 
                        class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
            </div>
            <div id="edit-enrolment-loader" class="loader"></div>
            <div id="edit-enrolment-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Confirm Deletion</h3>
                <button onclick="closeModal('delete-confirmation-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <p class="text-red-600 font-medium">⚠️ Warning: This will remove all academic records of the student for this course.</p>
                <p class="mt-2">Are you sure you want to delete this enrolment?</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Student Name</label>
                <input type="text" id="delete-student-name" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Course</label>
                <input type="text" id="delete-course-name" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Section</label>
                <input type="text" id="delete-section-name" class="border rounded-lg p-2 w-full" readonly>
            </div>

            <input type="hidden" id="delete-student-offered-course-id">

            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('delete-confirmation-modal')" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="deleteEnrolment()" 
                        class="bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
            </div>
            <div id="delete-enrolment-loader" class="loader"></div>
            <div id="delete-enrolment-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <script>
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let allSessions = [];
        let allStudents = [];
        let allSections = [];
        let reportData = [];
        let currentEnrolments = [];
        let filteredEnrolments = [];
        let currentFilters = {
            session: null,
            course: null,
            section: null,
            searchName: '',
            searchRegNo: ''
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

        // Initialize collapsible panels
        function initCollapsiblePanels() {
            document.querySelectorAll('.collapsible-header').forEach(header => {
                header.addEventListener('click', function() {
                    const panel = this.parentElement;
                    panel.classList.toggle('active');
                });
            });
        }

        // Load all sessions for offering courses
        async function loadSessions() {
            try {
                document.getElementById('loader').style.display = 'block';
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/offered_course/all`);
                const data = await response.json();
                
                if (data.status === "success" && data.data) {
                    allSessions = data.data;
                    const sessionDropdown = document.getElementById('session-dropdown');
                    sessionDropdown.innerHTML = '<option value="">Select Session</option>';

                    data.data.forEach(session => {
                        const option = document.createElement('option');
                        option.value = session.session_id;
                        option.textContent = session.session_name;
                        option.setAttribute('data-session-name', session.session_name);
                        sessionDropdown.appendChild(option);
                    });
                }
            } catch (error) {
                console.error("Error fetching sessions:", error);
                showAlert('error', 'Failed to load sessions. Please try again.');
            } finally {
                document.getElementById('loader').style.display = 'none';
            }
        }

        // Load courses for selected session (offer course panel)
        function loadCoursesForSession() {
            const sessionDropdown = document.getElementById('session-dropdown');
            const selectedSessionId = sessionDropdown.value;

            if (!selectedSessionId) {
                document.getElementById('course-dropdown').disabled = true;
                document.getElementById('course-dropdown').innerHTML = '<option value="">Select Course</option>';
                return;
            }

            const selectedSession = allSessions.find(session => session.session_id == selectedSessionId);
            const courseDropdown = document.getElementById('course-dropdown');
            courseDropdown.innerHTML = '<option value="">Select Course</option>';

            if (selectedSession && selectedSession.courses) {
                selectedSession.courses.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course.course_id;
                    option.textContent = `${course.course_code} - ${course.course_name}`;
                    option.setAttribute('data-course-name', course.course_name);
                    option.setAttribute('data-course-code', course.course_code);
                    option.setAttribute('data-is-lab', course.isLab);
                    option.setAttribute('data-credit-hours', course.credit_hours);
                    courseDropdown.appendChild(option);
                });

                courseDropdown.disabled = false;
            }
        }

        // Offer new course
        async function offerCourse() {
            const sessionId = document.getElementById('session-dropdown').value;
            const courseId = document.getElementById('course-dropdown').value;
            
            if (!sessionId || !courseId) {
                showMessage('offer-course-message', 'Please select both session and course', 'error');
                return;
            }
            
            try {
                document.getElementById('offer-course-loader').style.display = 'block';
                document.getElementById('offer-course-message').classList.add('hidden');
                
                const response = await fetch(`${API_BASE_URL}api/Insertion/offered_course/add`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        session_id: sessionId,
                        course_id: courseId
                    })
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    showMessage('offer-course-message', 'Course offered successfully!', 'success');
                    // Reload sessions to get updated data
                    setTimeout(() => {
                        loadSessions();
                        document.getElementById('session-dropdown').value = sessionId;
                        loadCoursesForSession();
                    }, 1500);
                } else {
                    showMessage('offer-course-message', data.message || 'Failed to offer course.', 'error');
                }
            } catch (error) {
                console.error('Error offering course:', error);
                showMessage('offer-course-message', 'An error occurred while offering course.', 'error');
            } finally {
                document.getElementById('offer-course-loader').style.display = 'none';
            }
        }

        // Load report sessions
        async function loadReportSessions() {
            try {
                document.getElementById('loader').style.display = 'block';
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/enrollment/report`);
                const data = await response.json();
                
                if (data.status === "success" && data.data) {
                    reportData = data.data;
                    const sessionDropdown = document.getElementById('report-session-dropdown');
                    sessionDropdown.innerHTML = '<option value="">Select Session</option>';

                    data.data.forEach(session => {
                        const option = document.createElement('option');
                        option.value = session.session_name;
                        option.textContent = session.session_name;
                        option.setAttribute('data-session-name', session.session_name);
                        sessionDropdown.appendChild(option);
                    });
                }
            } catch (error) {
                console.error("Error fetching report sessions:", error);
                showAlert('error', 'Failed to load sessions. Please try again.');
            } finally {
                document.getElementById('loader').style.display = 'none';
            }
        }

        // Load report courses for selected session
        function loadReportCourses() {
            const sessionDropdown = document.getElementById('report-session-dropdown');
            const selectedSessionName = sessionDropdown.value;
            currentFilters.session = selectedSessionName;

            if (!selectedSessionName) {
                document.getElementById('report-course-dropdown').disabled = true;
                document.getElementById('report-course-dropdown').innerHTML = '<option value="">Select Course</option>';
                document.getElementById('report-section-dropdown').disabled = true;
                document.getElementById('report-section-dropdown').innerHTML = '<option value="">Select Section</option>';
                resetEnrolmentView();
                return;
            }

            const selectedSession = reportData.find(session => session.session_name === selectedSessionName);
            const courseDropdown = document.getElementById('report-course-dropdown');
            courseDropdown.innerHTML = '<option value="">Select Course</option>';

            if (selectedSession && selectedSession.courses) {
                selectedSession.courses.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course.course_id;
                    option.textContent = `${course.course_code} - ${course.course_name}`;
                    option.setAttribute('data-course-name', course.course_name);
                    option.setAttribute('data-course-code', course.course_code);
                    option.setAttribute('data-is-lab', course.isLab);
                    option.setAttribute('data-credit-hours', course.credit_hours);
                    courseDropdown.appendChild(option);
                });

                courseDropdown.disabled = false;
                document.getElementById('report-section-dropdown').disabled = true;
                document.getElementById('report-section-dropdown').innerHTML = '<option value="">Select Section</option>';
                resetEnrolmentView();
            }
        }

        // Load report sections for selected course
        function loadReportSections() {
            const sessionDropdown = document.getElementById('report-session-dropdown');
            const selectedSessionName = sessionDropdown.value;
            const courseDropdown = document.getElementById('report-course-dropdown');
            const selectedCourseId = courseDropdown.value;
            currentFilters.course = selectedCourseId;

            if (!selectedCourseId) {
                document.getElementById('report-section-dropdown').disabled = true;
                document.getElementById('report-section-dropdown').innerHTML = '<option value="">Select Section</option>';
                resetEnrolmentView();
                return;
            }

            const selectedSession = reportData.find(session => session.session_name === selectedSessionName);
            const sectionDropdown = document.getElementById('report-section-dropdown');
            sectionDropdown.innerHTML = '<option value="">Select Section</option>';

            if (selectedSession && selectedSession.courses) {
                const selectedCourse = selectedSession.courses.find(course => course.course_id == selectedCourseId);

                if (selectedCourse && selectedCourse.sections) {
                    selectedCourse.sections.forEach(section => {
                        const option = document.createElement('option');
                        option.value = section.section_id;
                        option.textContent = section.section_name;
                        sectionDropdown.appendChild(option);
                    });

                    sectionDropdown.disabled = false;
                    resetEnrolmentView();
                }
            }
        }

        // Load enrolments for selected section
        function loadEnrolments() {
            const sessionDropdown = document.getElementById('report-session-dropdown');
            const selectedSessionName = sessionDropdown.value;
            const courseDropdown = document.getElementById('report-course-dropdown');
            const selectedCourseId = courseDropdown.value;
            const sectionDropdown = document.getElementById('report-section-dropdown');
            const selectedSectionId = sectionDropdown.value;
            currentFilters.section = selectedSectionId;

            if (!selectedSectionId) {
                resetEnrolmentView();
                return;
            }

            const selectedSession = reportData.find(session => session.session_name === selectedSessionName);
            
            if (selectedSession && selectedSession.courses) {
                const selectedCourse = selectedSession.courses.find(course => course.course_id == selectedCourseId);

                if (selectedCourse && selectedCourse.sections) {
                    const selectedSection = selectedCourse.sections.find(section => section.section_id == selectedSectionId);

                    if (selectedSection) {
                        // Update course info display
                        document.getElementById('course-title').textContent = 
                            `${selectedCourse.course_code} - ${selectedCourse.course_name}`;
                        document.getElementById('course-session').textContent = selectedSessionName;
                        document.getElementById('course-section').textContent = selectedSection.section_name;
                        document.getElementById('course-credits').textContent = selectedCourse.credit_hours;
                        document.getElementById('course-lab').textContent = selectedCourse.isLab;

                        // Show the course info and search container
                        document.getElementById('course-info-container').classList.remove('hidden');
                        document.getElementById('student-search-container').classList.remove('hidden');
                        document.getElementById('enrolment-data-container').classList.remove('hidden');
                        document.getElementById('no-enrolment-message').classList.add('hidden');

                        // Set enrolments data
                        currentEnrolments = [...selectedSection.enrollments];
                        filteredEnrolments = [...currentEnrolments];
                        renderEnrolments();
                    } else {
                        showNoEnrolmentMessage();
                    }
                } else {
                    showNoEnrolmentMessage();
                }
            } else {
                showNoEnrolmentMessage();
            }
        }

        // Render enrolments in table and cards
        function renderEnrolments() {
            const tableBody = document.getElementById('enrolment-table-body');
            const cardContainer = document.getElementById('enrolment-card-container');
            const noResults = document.getElementById('no-results');

            tableBody.innerHTML = '';
            cardContainer.innerHTML = '';

            if (filteredEnrolments.length === 0) {
                noResults.classList.remove('hidden');
                return;
            }

            noResults.classList.add('hidden');

            filteredEnrolments.forEach(enrolment => {
                // Add row to desktop table
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            ${enrolment.image ? 
                                `<img src="${enrolment.image}" class="h-10 w-10 rounded-full mr-3 object-cover" alt="${enrolment.name}">` : 
                                `<div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center mr-3">👤</div>`}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${enrolment.regNo}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${enrolment.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${enrolment.semester}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <button onclick="openEditEnrolmentModal(${enrolment.student_offered_course_id}, '${enrolment.name}', '${enrolment.regNo}', '${enrolment.semester}')" 
                                class="action-btn edit">✏️ Edit</button>
                        <button onclick="openDeleteConfirmationModal(${enrolment.student_offered_course_id}, '${enrolment.name}', '${document.getElementById('course-title').textContent}', '${document.getElementById('course-section').textContent}')" 
                                class="action-btn delete">🗑️ Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
                
                // Add card for mobile view
                const card = document.createElement('div');
                card.className = 'enrolment-card';
                card.innerHTML = `
                    <div class="flex items-center mb-3">
                        ${enrolment.image ? 
                            `<img src="${enrolment.image}" class="h-12 w-12 rounded-full mr-3 object-cover" alt="${enrolment.name}">` : 
                            `<div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center mr-3">👤</div>`}
                        <div>
                            <div class="font-medium text-gray-900">${enrolment.name}</div>
                            <div class="text-sm text-gray-500">${enrolment.regNo}</div>
                        </div>
                    </div>
                    <div class="field">
                        <span class="field-label">Semester:</span>
                        <span class="field-value">${enrolment.semester}</span>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button onclick="openEditEnrolmentModal(${enrolment.student_offered_course_id}, '${enrolment.name}', '${enrolment.regNo}', '${enrolment.semester}')" 
                                class="action-btn edit">✏️ Edit</button>
                        <button onclick="openDeleteConfirmationModal(${enrolment.student_offered_course_id}, '${enrolment.name}', '${document.getElementById('course-title').textContent}', '${document.getElementById('course-section').textContent}')" 
                                class="action-btn delete">🗑️ Delete</button>
                    </div>
                `;
                cardContainer.appendChild(card);
            });
        }

        // Filter students by name or regno
        function filterStudents() {
            const nameSearch = document.getElementById('search-name').value.toLowerCase();
            const regNoSearch = document.getElementById('search-regno').value.toLowerCase();
            
            currentFilters.searchName = nameSearch;
            currentFilters.searchRegNo = regNoSearch;

            filteredEnrolments = currentEnrolments.filter(enrolment =>
                (enrolment.name.toLowerCase().includes(nameSearch) || nameSearch === '') &&
                (enrolment.regNo.toLowerCase().includes(regNoSearch) || regNoSearch === '')
            );

            renderEnrolments();
        }

        // Reset student search
        function resetStudentSearch() {
            document.getElementById('search-name').value = '';
            document.getElementById('search-regno').value = '';
            currentFilters.searchName = '';
            currentFilters.searchRegNo = '';
            filteredEnrolments = [...currentEnrolments];
            renderEnrolments();
        }

        // Reset enrolment view
        function resetEnrolmentView() {
            document.getElementById('course-info-container').classList.add('hidden');
            document.getElementById('student-search-container').classList.add('hidden');
            document.getElementById('enrolment-data-container').classList.add('hidden');
            document.getElementById('no-enrolment-message').classList.add('hidden');
            filteredEnrolments = [];
            currentEnrolments = [];
        }

        // Show no enrolment message
        function showNoEnrolmentMessage() {
            document.getElementById('course-info-container').classList.add('hidden');
            document.getElementById('student-search-container').classList.add('hidden');
            document.getElementById('enrolment-data-container').classList.add('hidden');
            document.getElementById('no-enrolment-message').classList.remove('hidden');
        }

        // Load all sections for dropdown
        async function loadAllSections() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Dropdown/AllSection`);
                const data = await response.json();
                
                if (data) {
                    allSections = data;
                    const sectionDropdown = document.getElementById('edit-section');
                    sectionDropdown.innerHTML = '<option value="">Select Section</option>';
                    
                    data.forEach(section => {
                        const option = document.createElement('option');
                        option.value = section.id;
                        option.textContent = section.data;
                        sectionDropdown.appendChild(option);
                    });
                }
            } catch (error) {
                console.error("Error fetching sections:", error);
                showAlert('error', 'Failed to load sections. Please try again.');
            }
        }

        // Open edit enrolment modal
        async function openEditEnrolmentModal(studentOfferedCourseId, name, regNo, semester) {
            document.getElementById('edit-student-name').value = name;
            document.getElementById('edit-reg-no').value = regNo;
            document.getElementById('edit-semester').value = semester;
            document.getElementById('edit-student-offered-course-id').value = studentOfferedCourseId;
            
            // Load sections if not already loaded
            if (allSections.length === 0) {
                await loadAllSections();
            }
            
            // Clear any previous messages
            document.getElementById('edit-enrolment-message').classList.add('hidden');
            
            // Show modal
            document.getElementById('edit-enrolment-modal').style.display = 'flex';
        }

        // Update enrolment
        async function updateEnrolment() {
            const studentOfferedCourseId = document.getElementById('edit-student-offered-course-id').value;
            const newSectionId = document.getElementById('edit-section').value;
            
            if (!newSectionId) {
                showMessage('edit-enrolment-message', 'Please select a section', 'error');
                return;
            }
            
            try {
                document.getElementById('edit-enrolment-loader').style.display = 'block';
                document.getElementById('edit-enrolment-message').classList.add('hidden');
                
                const response = await fetch(`${API_BASE_URL}api/Insertion/enrollment/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: studentOfferedCourseId,
                        section_id: newSectionId
                    })
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    showMessage('edit-enrolment-message', 'Enrolment updated successfully!', 'success');
                    // Reload the report data to get fresh data
                    setTimeout(async () => {
                        await loadReportSessions();
                        // Reapply current filters if any
                        if (currentFilters.session) {
                            document.getElementById('report-session-dropdown').value = currentFilters.session;
                            loadReportCourses();
                            if (currentFilters.course) {
                                document.getElementById('report-course-dropdown').value = currentFilters.course;
                                loadReportSections();
                                if (currentFilters.section) {
                                    document.getElementById('report-section-dropdown').value = currentFilters.section;
                                    loadEnrolments();
                                }
                            }
                        }
                    }, 1500);
                } else {
                    showMessage('edit-enrolment-message', data.message || 'Failed to update enrolment.', 'error');
                }
            } catch (error) {
                console.error('Error updating enrolment:', error);
                showMessage('edit-enrolment-message', 'An error occurred while updating enrolment.', 'error');
            } finally {
                document.getElementById('edit-enrolment-loader').style.display = 'none';
            }
        }

        // Open delete confirmation modal
        function openDeleteConfirmationModal(studentOfferedCourseId, studentName, courseName, sectionName) {
            document.getElementById('delete-student-name').value = studentName;
            document.getElementById('delete-course-name').value = courseName;
            document.getElementById('delete-section-name').value = sectionName;
            document.getElementById('delete-student-offered-course-id').value = studentOfferedCourseId;
            
            // Clear any previous messages
            document.getElementById('delete-enrolment-message').classList.add('hidden');
            
            // Show modal
            document.getElementById('delete-confirmation-modal').style.display = 'flex';
        }

        // Delete enrolment
        async function deleteEnrolment() {
            const studentOfferedCourseId = document.getElementById('delete-student-offered-course-id').value;
            
            try {
                document.getElementById('delete-enrolment-loader').style.display = 'block';
                document.getElementById('delete-enrolment-message').classList.add('hidden');
                
                const response = await fetch(`${API_BASE_URL}api/Insertion/enrollment/remove`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        student_offered_course_id: studentOfferedCourseId
                    })
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    showMessage('delete-enrolment-message', 'Enrolment deleted successfully!', 'success');
                    // Reload the report data to get fresh data
                    setTimeout(async () => {
                        await loadReportSessions();
                        // Reapply current filters if any
                        if (currentFilters.session) {
                            document.getElementById('report-session-dropdown').value = currentFilters.session;
                            loadReportCourses();
                            if (currentFilters.course) {
                                document.getElementById('report-course-dropdown').value = currentFilters.course;
                                loadReportSections();
                                if (currentFilters.section) {
                                    document.getElementById('report-section-dropdown').value = currentFilters.section;
                                    loadEnrolments();
                                }
                            }
                        }
                        closeModal('delete-confirmation-modal');
                    }, 1500);
                } else {
                    showMessage('delete-enrolment-message', data.message || 'Failed to delete enrolment.', 'error');
                }
            } catch (error) {
                console.error('Error deleting enrolment:', error);
                showMessage('delete-enrolment-message', 'An error occurred while deleting enrolment.', 'error');
            } finally {
                document.getElementById('delete-enrolment-loader').style.display = 'none';
            }
        }

        // Close modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Show message
        function showMessage(elementId, message, type) {
            const element = document.getElementById(elementId);
            element.textContent = message;
            element.classList.remove('hidden');
            
            if (type === 'success') {
                element.className = element.className.replace(/text-red-500/g, '') + ' text-green-500';
            } else {
                element.className = element.className.replace(/text-green-500/g, '') + ' text-red-500';
            }
        }

        // Show alert
        function showAlert(type, message) {
            alert(`${type.toUpperCase()}: ${message}`);
        }

        // Initialize the page
        document.addEventListener("DOMContentLoaded", async function() {
            initCollapsiblePanels();
            
            // Load initial data
            await loadSessions();
            await loadReportSessions();
            await loadAllSections();
            
            // Set up event listeners
            document.getElementById('session-dropdown').addEventListener('change', loadCoursesForSession);
            document.getElementById('offer-course-submit').addEventListener('click', offerCourse);
            
            document.getElementById('offer-course-btn').addEventListener('click', function() {
                document.getElementById('offer-course-panel').classList.add('active');
            });
        });
    </script>
    @include('components.footer')
</body>
</html>