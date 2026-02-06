<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results Management</title>
    @vite('resources/css/app.css')
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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

        .result-card {
            display: none;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: white;
        }

        .result-card .field {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .result-card .field-label {
            font-weight: 600;
            color: #4a5568;
        }

        .result-card .field-value {
            text-align: right;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .result-table {
            min-width: 100%;
            width: auto;
        }

        @media (max-width: 768px) {
            .desktop-table {
                display: none;
            }

            .result-card {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .desktop-table {
                display: block;
            }

            .result-card {
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

        .marks-distribution {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .mark-badge {
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
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
    </style>
</head>

<body class="bg-gray-100">
    @include('DATACELL.partials.nav')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Exam Results Management</h2>

        <div class="mb-6 p-4 bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Result Filters</h3>
            <div class="flex justify-end mb-4">
                <button onclick="window.location.href='{{ route('datacell.add.result_excel') }}'"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    📤 Upload Result (Excel)
                </button>
            </div>


            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Session Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Session</label>
                    <select id="session-dropdown" class="border rounded-lg p-2 w-full" onchange="loadCourses()">
                        <option value="">Select Session</option>
                    </select>
                </div>

                <!-- Course Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Course</label>
                    <select id="course-dropdown" class="border rounded-lg p-2 w-full" onchange="loadSections()"
                        disabled>
                        <option value="">Select Course</option>
                    </select>
                </div>

                <!-- Section Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Section</label>
                    <select id="section-dropdown" class="border rounded-lg p-2 w-full" onchange="loadResults()"
                        disabled>
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

                <div class="mt-4">
                    <h4 class="text-lg font-medium text-gray-700 mb-2">Marks Distribution</h4>
                    <div id="marks-distribution" class="marks-distribution">
                        <!-- Marks breakdown will be populated here -->
                    </div>
                </div>
            </div>

            <!-- Student Search -->
            <div id="student-search-container" class="bg-white shadow-md rounded-lg p-4 mb-6 hidden">
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
        <div id="result-data-container" class="hidden">
            <div class="bg-white shadow-md rounded-lg overflow-hidden desktop-table">
                <div class="table-container">
                    <table class="result-table min-w-full divide-y divide-gray-200">
                        <thead id="result-table-header" class="bg-blue-500 text-white">
                            <!-- Header will be populated dynamically -->
                        </thead>
                        <tbody id="result-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Students will be loaded here -->
                        </tbody>
                    </table>
                </div>
                <div id="no-results" class="p-4 text-center text-gray-500 hidden">
                    No students found matching your criteria.
                </div>
                <div id="loader" class="loader"></div>
            </div>

            <!-- Mobile Card View -->
            <div id="result-card-container">
                <!-- Student cards will be loaded here -->
            </div>
        </div>

        <!-- No Result Message -->
        <div id="no-result-message" class="no-result-message hidden">
            <p class="text-lg text-gray-600">No result data exists for the selected criteria.</p>
        </div>
    </div>

    <!-- Edit Result Modal -->
    <div id="edit-result-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Result</h3>
                <button onclick="closeModal('edit-result-modal')" class="text-gray-500 hover:text-gray-700">
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

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Mid Marks (Max: <span
                            id="mid-max"></span>)</label>
                    <input type="number" id="edit-mid" class="border rounded-lg p-2 w-full" min="0"
                        oninput="validateMarkInput(this, 'mid')">
                    <div id="mid-error" class="error-message">Cannot exceed maximum marks</div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Final Marks (Max: <span
                            id="final-max"></span>)</label>
                    <input type="number" id="edit-final" class="border rounded-lg p-2 w-full" min="0"
                        oninput="validateMarkInput(this, 'final')">
                    <div id="final-error" class="error-message">Cannot exceed maximum marks</div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Internal Marks (Max: <span
                            id="internal-max"></span>)</label>
                    <input type="number" id="edit-internal" class="border rounded-lg p-2 w-full" min="0"
                        oninput="validateMarkInput(this, 'internal')">
                    <div id="internal-error" class="error-message">Cannot exceed maximum marks</div>
                </div>
                <div id="lab-input-container" class="hidden">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Lab Marks (Max: <span
                            id="lab-max"></span>)</label>
                    <input type="number" id="edit-lab" class="border rounded-lg p-2 w-full" min="0"
                        oninput="validateMarkInput(this, 'lab')">
                    <div id="lab-error" class="error-message">Cannot exceed maximum marks</div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Quality Points</label>
                    <input type="number" id="edit-quality-points" class="border rounded-lg p-2 w-full"
                        min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Grade</label>
                    <select id="edit-grade" class="border rounded-lg p-2 w-full">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="F">F</option>
                    </select>
                </div>
            </div>

            <input type="hidden" id="edit-student-offered-course-id">

            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('edit-result-modal')"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="updateResult()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
            </div>
            <div id="edit-result-loader" class="loader"></div>
            <div id="edit-result-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <script>
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let allResults = [];
        let filteredStudents = [];
        let currentCourse = null;
        let currentSection = null;
        let currentHeader = null;
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

        async function loadSessions() {
            try {
                document.getElementById('loader').style.display = 'block';
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/result/report`);
                const data = await response.json();

                if (data.status === "success" && data.data) {
                    allResults = data.data;
                    const sessionDropdown = document.getElementById('session-dropdown');
                    sessionDropdown.innerHTML = '<option value="">Select Session</option>';

                    data.data.forEach(session => {
                        const option = document.createElement('option');
                        option.value = session.session_name;
                        option.textContent = session.session_name;
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

        function loadCourses() {
            const sessionDropdown = document.getElementById('session-dropdown');
            const selectedSession = sessionDropdown.value;
            currentFilters.session = selectedSession;

            if (!selectedSession) {
                document.getElementById('course-dropdown').disabled = true;
                document.getElementById('course-dropdown').innerHTML = '<option value="">Select Course</option>';
                document.getElementById('section-dropdown').disabled = true;
                document.getElementById('section-dropdown').innerHTML = '<option value="">Select Section</option>';
                resetResultView();
                return;
            }

            const selectedSessionData = allResults.find(session => session.session_name === selectedSession);
            const courseDropdown = document.getElementById('course-dropdown');
            courseDropdown.innerHTML = '<option value="">Select Course</option>';

            if (selectedSessionData && selectedSessionData.courses) {
                selectedSessionData.courses.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course.course_id;
                    option.textContent = `${course.course_code} - ${course.course_name}`;
                    option.setAttribute('data-course-name', course.course_name);
                    option.setAttribute('data-course-code', course.course_code);
                    option.setAttribute('data-is-lab', course.isLab);
                    option.setAttribute('data-credit-hours', course.credit_hours);
                    option.setAttribute('data-result-header', JSON.stringify(course.restul_header));
                    courseDropdown.appendChild(option);
                });

                courseDropdown.disabled = false;
                document.getElementById('section-dropdown').disabled = true;
                document.getElementById('section-dropdown').innerHTML = '<option value="">Select Section</option>';
                resetResultView();
            }
        }

        function loadSections() {
            const sessionDropdown = document.getElementById('session-dropdown');
            const selectedSession = sessionDropdown.value;
            const courseDropdown = document.getElementById('course-dropdown');
            const selectedCourseId = courseDropdown.value;
            currentFilters.course = selectedCourseId;

            if (!selectedCourseId) {
                document.getElementById('section-dropdown').disabled = true;
                document.getElementById('section-dropdown').innerHTML = '<option value="">Select Section</option>';
                resetResultView();
                return;
            }

            const selectedSessionData = allResults.find(session => session.session_name === selectedSession);
            const sectionDropdown = document.getElementById('section-dropdown');
            sectionDropdown.innerHTML = '<option value="">Select Section</option>';

            if (selectedSessionData && selectedSessionData.courses) {
                const selectedCourse = selectedSessionData.courses.find(course => course.course_id == selectedCourseId);

                if (selectedCourse && selectedCourse.sections) {
                    selectedCourse.sections.forEach(section => {
                        const option = document.createElement('option');
                        option.value = section.section_id;
                        option.textContent = section.section_name;
                        sectionDropdown.appendChild(option);
                    });

                    sectionDropdown.disabled = false;
                    resetResultView();
                }
            }
        }

        function loadResults() {
            const sessionDropdown = document.getElementById('session-dropdown');
            const selectedSession = sessionDropdown.value;
            const courseDropdown = document.getElementById('course-dropdown');
            const selectedCourseId = courseDropdown.value;
            const sectionDropdown = document.getElementById('section-dropdown');
            const selectedSectionId = sectionDropdown.value;
            currentFilters.section = selectedSectionId;

            if (!selectedSectionId) {
                resetResultView();
                return;
            }

            const selectedSessionData = allResults.find(session => session.session_name === selectedSession);

            if (selectedSessionData && selectedSessionData.courses) {
                const selectedCourse = selectedSessionData.courses.find(course => course.course_id == selectedCourseId);

                if (selectedCourse && selectedCourse.sections) {
                    const selectedSection = selectedCourse.sections.find(section => section.section_id ==
                        selectedSectionId);

                    if (selectedSection) {
                        // Set current course and section info
                        currentCourse = selectedCourse;
                        currentSection = selectedSection;
                        currentHeader = JSON.parse(courseDropdown.options[courseDropdown.selectedIndex].getAttribute(
                            'data-result-header'));

                        // Update course info display
                        document.getElementById('course-title').textContent =
                            `${currentCourse.course_code} - ${currentCourse.course_name}`;
                        document.getElementById('course-session').textContent = selectedSession;
                        document.getElementById('course-section').textContent = selectedSection.section_name;
                        document.getElementById('course-credits').textContent = currentCourse.credit_hours;
                        document.getElementById('course-lab').textContent = currentCourse.isLab;

                        // Update marks distribution
                        const marksDistribution = document.getElementById('marks-distribution');
                        marksDistribution.innerHTML = '';

                        // Add all mark components
                        for (const [key, value] of Object.entries(currentHeader)) {
                            if (key !== 'quality_points' && key !== 'grade') {
                                const badge = document.createElement('div');
                                badge.className = 'mark-badge';
                                badge.textContent = `${key.charAt(0).toUpperCase() + key.slice(1)}: ${value}`;
                                marksDistribution.appendChild(badge);
                            }
                        }

                        // Add total marks if it exists
                        if (currentHeader.total_marks) {
                            const totalBadge = document.createElement('div');
                            totalBadge.className = 'mark-badge bg-green-100 text-green-800';
                            totalBadge.textContent = `Total: ${currentHeader.total_marks}`;
                            marksDistribution.appendChild(totalBadge);
                        }

                        // Add quality points if it exists
                        if (currentHeader.quality_points) {
                            const qpBadge = document.createElement('div');
                            qpBadge.className = 'mark-badge bg-purple-100 text-purple-800';
                            qpBadge.textContent = `Quality Points: ${currentHeader.quality_points}`;
                            marksDistribution.appendChild(qpBadge);
                        }

                        // Show the course info and search container
                        document.getElementById('course-info-container').classList.remove('hidden');
                        document.getElementById('student-search-container').classList.remove('hidden');
                        document.getElementById('result-data-container').classList.remove('hidden');
                        document.getElementById('no-result-message').classList.add('hidden');

                        // Set students data
                        filteredStudents = [...selectedSection.result];
                        renderStudents();
                    } else {
                        showNoResultMessage();
                    }
                } else {
                    showNoResultMessage();
                }
            } else {
                showNoResultMessage();
            }
        }

        function renderStudents() {
            const tableHeader = document.getElementById('result-table-header');
            const tableBody = document.getElementById('result-table-body');
            const cardContainer = document.getElementById('result-card-container');
            const noResults = document.getElementById('no-results');

            tableHeader.innerHTML = '';
            tableBody.innerHTML = '';
            cardContainer.innerHTML = '';

            if (filteredStudents.length === 0) {
                noResults.classList.remove('hidden');
                return;
            }

            noResults.classList.add('hidden');

            // Create table header
            const headerRow = document.createElement('tr');

            const regNoHeader = document.createElement('th');
            regNoHeader.className = 'px-6 py-3 text-left text-xs font-medium uppercase tracking-wider';
            regNoHeader.textContent = 'Reg No';
            headerRow.appendChild(regNoHeader);

            const nameHeader = document.createElement('th');
            nameHeader.className = 'px-6 py-3 text-left text-xs font-medium uppercase tracking-wider';
            nameHeader.textContent = 'Name';
            headerRow.appendChild(nameHeader);

            // Add result headers (mid, final, internal, lab)
            for (const [key, value] of Object.entries(currentHeader)) {
                if (key !== 'quality_points' && key !== 'grade' && key !== 'total_marks') {
                    const resultHeader = document.createElement('th');
                    resultHeader.className = 'px-6 py-3 text-center text-xs font-medium uppercase tracking-wider';
                    resultHeader.textContent = `${key.charAt(0).toUpperCase() + key.slice(1)} (${value})`;
                    headerRow.appendChild(resultHeader);
                }
            }

            // Add total marks header
            const totalHeader = document.createElement('th');
            totalHeader.className = 'px-6 py-3 text-center text-xs font-medium uppercase tracking-wider';
            totalHeader.textContent = 'Total';
            headerRow.appendChild(totalHeader);

            // Add quality points header
            const qpHeader = document.createElement('th');
            qpHeader.className = 'px-6 py-3 text-center text-xs font-medium uppercase tracking-wider';
            qpHeader.textContent = 'Quality Points';
            headerRow.appendChild(qpHeader);

            // Add grade header
            const gradeHeader = document.createElement('th');
            gradeHeader.className = 'px-6 py-3 text-center text-xs font-medium uppercase tracking-wider';
            gradeHeader.textContent = 'Grade';
            headerRow.appendChild(gradeHeader);

            // Add action header
            const actionHeader = document.createElement('th');
            actionHeader.className = 'px-6 py-3 text-center text-xs font-medium uppercase tracking-wider';
            actionHeader.textContent = 'Actions';
            headerRow.appendChild(actionHeader);

            tableHeader.appendChild(headerRow);

            // Add student rows
            filteredStudents.forEach(student => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';

                // Reg No
                const regNoCell = document.createElement('td');
                regNoCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
                regNoCell.textContent = student.regNo;
                row.appendChild(regNoCell);

                // Name
                const nameCell = document.createElement('td');
                nameCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
                nameCell.textContent = student.name;
                row.appendChild(nameCell);

                // Result marks (mid, final, internal, lab)
                for (const [key, maxValue] of Object.entries(currentHeader)) {
                    if (key !== 'quality_points' && key !== 'grade' && key !== 'total_marks') {
                        const markCell = document.createElement('td');
                        markCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center';

                        const markValue = student.result[key] !== null ? student.result[key] : 'Not Added';
                        markCell.textContent = markValue;

                        row.appendChild(markCell);
                    }
                }

                // Total marks
                const totalCell = document.createElement('td');
                totalCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center';
                totalCell.textContent = student.result.total_marks !== null ? student.result.total_marks : 'N/A';
                row.appendChild(totalCell);

                // Quality Points
                const qpCell = document.createElement('td');
                qpCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center';
                qpCell.textContent = student.result.quality_points !== null ? student.result.quality_points : 'N/A';
                row.appendChild(qpCell);

                // Grade
                const gradeCell = document.createElement('td');
                gradeCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center';
                gradeCell.textContent = student.result.grade || 'N/A';
                row.appendChild(gradeCell);

                // Action
                const actionCell = document.createElement('td');
                actionCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center';

                const editButton = document.createElement('button');
                editButton.className = 'text-blue-600 hover:text-blue-800';
                editButton.textContent = '✏️ Edit';
                editButton.onclick = () => openEditResultModal(student);
                actionCell.appendChild(editButton);

                row.appendChild(actionCell);

                tableBody.appendChild(row);

                // Mobile card
                const card = document.createElement('div');
                card.className = 'result-card';

                // Card header
                const cardHeader = document.createElement('div');
                cardHeader.className = 'flex items-center mb-3';

                const avatar = document.createElement('div');
                avatar.className = 'h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center mr-3';
                avatar.textContent = '👤';
                cardHeader.appendChild(avatar);

                const studentInfo = document.createElement('div');

                const nameElement = document.createElement('div');
                nameElement.className = 'font-medium text-gray-900';
                nameElement.textContent = student.name;
                studentInfo.appendChild(nameElement);

                const regNoElement = document.createElement('div');
                regNoElement.className = 'text-sm text-gray-500';
                regNoElement.textContent = student.regNo;
                studentInfo.appendChild(regNoElement);

                cardHeader.appendChild(studentInfo);
                card.appendChild(cardHeader);

                // Result marks (mid, final, internal, lab)
                for (const [key, maxValue] of Object.entries(currentHeader)) {
                    if (key !== 'quality_points' && key !== 'grade' && key !== 'total_marks') {
                        const field = document.createElement('div');
                        field.className = 'field';

                        const fieldLabel = document.createElement('span');
                        fieldLabel.className = 'field-label';
                        fieldLabel.textContent = `${key.charAt(0).toUpperCase() + key.slice(1)} (${maxValue}):`;

                        const fieldValue = document.createElement('span');
                        fieldValue.className = 'field-value';
                        fieldValue.textContent = student.result[key] !== null ? student.result[key] : 'Not Added';

                        field.appendChild(fieldLabel);
                        field.appendChild(fieldValue);
                        card.appendChild(field);
                    }
                }

                // Total marks
                const totalField = document.createElement('div');
                totalField.className = 'field';

                const totalLabel = document.createElement('span');
                totalLabel.className = 'field-label';
                totalLabel.textContent = 'Total:';

                const totalValue = document.createElement('span');
                totalValue.className = 'field-value';
                totalValue.textContent = student.result.total_marks !== null ? student.result.total_marks : 'N/A';

                totalField.appendChild(totalLabel);
                totalField.appendChild(totalValue);
                card.appendChild(totalField);

                // Quality Points
                const qpField = document.createElement('div');
                qpField.className = 'field';

                const qpLabel = document.createElement('span');
                qpLabel.className = 'field-label';
                qpLabel.textContent = 'Quality Points:';

                const qpValue = document.createElement('span');
                qpValue.className = 'field-value';
                qpValue.textContent = student.result.quality_points !== null ? student.result.quality_points :
                    'N/A';

                qpField.appendChild(qpLabel);
                qpField.appendChild(qpValue);
                card.appendChild(qpField);

                // Grade
                const gradeField = document.createElement('div');
                gradeField.className = 'field';

                const gradeLabel = document.createElement('span');
                gradeLabel.className = 'field-label';
                gradeLabel.textContent = 'Grade:';

                const gradeValue = document.createElement('span');
                gradeValue.className = 'field-value';
                gradeValue.textContent = student.result.grade || 'N/A';

                gradeField.appendChild(gradeLabel);
                gradeField.appendChild(gradeValue);
                card.appendChild(gradeField);

                // Edit button
                const editField = document.createElement('div');
                editField.className = 'field';

                const editButtonCard = document.createElement('button');
                editButtonCard.className = 'w-full bg-blue-500 text-white py-2 rounded-md';
                editButtonCard.textContent = '✏️ Edit Result';
                editButtonCard.onclick = () => openEditResultModal(student);
                editField.appendChild(editButtonCard);

                card.appendChild(editField);

                cardContainer.appendChild(card);
            });
        }

        function validateMarkInput(input, field) {
            const maxValue = currentHeader[field];
            const value = parseInt(input.value) || 0;
            const errorElement = document.getElementById(`${field}-error`);

            if (value > maxValue) {
                input.classList.add('input-error');
                errorElement.style.display = 'block';
                return false;
            } else {
                input.classList.remove('input-error');
                errorElement.style.display = 'none';
                return true;
            }
        }

        function validateAllInputs() {
            let isValid = true;

            if (!validateMarkInput(document.getElementById('edit-mid'), 'mid')) isValid = false;
            if (!validateMarkInput(document.getElementById('edit-final'), 'final')) isValid = false;
            if (!validateMarkInput(document.getElementById('edit-internal'), 'internal')) isValid = false;

            if ('lab' in currentHeader) {
                if (!validateMarkInput(document.getElementById('edit-lab'), 'lab')) isValid = false;
            }

            return isValid;
        }

        function openEditResultModal(student) {
            document.getElementById('edit-student-name').value = student.name;
            document.getElementById('edit-reg-no').value = student.regNo;
            document.getElementById('edit-student-offered-course-id').value = student.student_offered_course_id;

            // Set max values
            document.getElementById('mid-max').textContent = currentHeader.mid;
            document.getElementById('final-max').textContent = currentHeader.final;
            document.getElementById('internal-max').textContent = currentHeader.internal;

            // Set current values or empty if null
            document.getElementById('edit-mid').value = student.result.mid !== null ? student.result.mid : '';
            document.getElementById('edit-final').value = student.result.final !== null ? student.result.final : '';
            document.getElementById('edit-internal').value = student.result.internal !== null ? student.result.internal :
                '';

            // Handle lab field
            const labInputContainer = document.getElementById('lab-input-container');
            if ('lab' in currentHeader) {
                labInputContainer.classList.remove('hidden');
                document.getElementById('lab-max').textContent = currentHeader.lab;
                document.getElementById('edit-lab').value = student.result.lab !== null ? student.result.lab : '';
            } else {
                labInputContainer.classList.add('hidden');
            }

            // Set quality points and grade
            document.getElementById('edit-quality-points').value = student.result.quality_points !== null ? student.result
                .quality_points : '';
            document.getElementById('edit-grade').value = student.result.grade || 'A';

            // Clear any previous messages and errors
            document.getElementById('edit-result-message').classList.add('hidden');
            document.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
            document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');

            // Show modal
            document.getElementById('edit-result-modal').style.display = 'flex';
        }

        async function updateResult() {
            // Validate all inputs first
            if (!validateAllInputs()) {
                showMessage('edit-result-message', 'Please correct the errors in the form', 'error');
                return;
            }

            const studentOfferedCourseId = document.getElementById('edit-student-offered-course-id').value;
            const mid = document.getElementById('edit-mid').value;
            const final = document.getElementById('edit-final').value;
            const internal = document.getElementById('edit-internal').value;
            const lab = document.getElementById('edit-lab').value;
            const qualityPoints = document.getElementById('edit-quality-points').value;
            const grade = document.getElementById('edit-grade').value;

            // Prepare data for API
            const data = {
                student_offered_course_id: studentOfferedCourseId,
                mid: mid || 0,
                final: final || 0,
                internal: internal || 0,
                quality_points: qualityPoints || 0,
                grade: grade || 'F'
            };

            if ('lab' in currentHeader) {
                data.lab = lab || 0;
            }

            try {
                document.getElementById('edit-result-loader').style.display = 'block';
                document.getElementById('edit-result-message').classList.add('hidden');

                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/update/result`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });

                const responseData = await response.json();

                if (responseData.status === 'success') {
                    showMessage('edit-result-message', 'Result updated successfully!', 'success');

                    // Reload the data while maintaining current filters
                    setTimeout(async () => {
                        closeModal('edit-result-modal');
                        await reloadDataWithCurrentFilters();
                    }, 1500);
                } else {
                    showMessage('edit-result-message', responseData.message || 'Failed to update result.', 'error');
                }
            } catch (error) {
                console.error('Error updating result:', error);
                showMessage('edit-result-message', 'An error occurred while updating result.', 'error');
            } finally {
                document.getElementById('edit-result-loader').style.display = 'none';
            }
        }

        async function reloadDataWithCurrentFilters() {
            try {
                document.getElementById('loader').style.display = 'block';
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/result/report`);
                const data = await response.json();

                if (data.status === "success" && data.data) {
                    allResults = data.data;

                    // Reapply current filters
                    if (currentFilters.session) {
                        document.getElementById('session-dropdown').value = currentFilters.session;
                        loadCourses();

                        if (currentFilters.course) {
                            document.getElementById('course-dropdown').value = currentFilters.course;
                            loadSections();

                            if (currentFilters.section) {
                                document.getElementById('section-dropdown').value = currentFilters.section;
                                loadResults();

                                // Reapply search filters if any
                                if (currentFilters.searchName || currentFilters.searchRegNo) {
                                    document.getElementById('search-name').value = currentFilters.searchName;
                                    document.getElementById('search-regno').value = currentFilters.searchRegNo;
                                    filterStudents();
                                }
                            }
                        }
                    }
                }
            } catch (error) {
                console.error("Error reloading data:", error);
                showAlert('error', 'Failed to reload data. Please try again.');
            } finally {
                document.getElementById('loader').style.display = 'none';
            }
        }

        function filterStudents() {
            const nameSearch = document.getElementById('search-name').value.toLowerCase();
            const regNoSearch = document.getElementById('search-regno').value.toLowerCase();

            currentFilters.searchName = nameSearch;
            currentFilters.searchRegNo = regNoSearch;

            filteredStudents = currentSection.result.filter(student =>
                (student.name.toLowerCase().includes(nameSearch) || nameSearch === '') &&
                (student.regNo.toLowerCase().includes(regNoSearch) || regNoSearch === '')
            );

            renderStudents();
        }

        function resetStudentSearch() {
            document.getElementById('search-name').value = '';
            document.getElementById('search-regno').value = '';
            currentFilters.searchName = '';
            currentFilters.searchRegNo = '';
            filteredStudents = [...currentSection.result];
            renderStudents();
        }

        function resetResultView() {
            document.getElementById('course-info-container').classList.add('hidden');
            document.getElementById('student-search-container').classList.add('hidden');
            document.getElementById('result-data-container').classList.add('hidden');
            document.getElementById('no-result-message').classList.add('hidden');
            filteredStudents = [];
            currentCourse = null;
            currentSection = null;
            currentHeader = null;
        }

        function showNoResultMessage() {
            document.getElementById('course-info-container').classList.add('hidden');
            document.getElementById('student-search-container').classList.add('hidden');
            document.getElementById('result-data-container').classList.add('hidden');
            document.getElementById('no-result-message').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

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

        function showAlert(type, message) {
            alert(`${type.toUpperCase()}: ${message}`);
        }

        document.addEventListener("DOMContentLoaded", loadSessions);
    </script>

    @include('components.footer')
</body>

</html>
