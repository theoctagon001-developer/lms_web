<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Numbers Management</title>
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

        .exam-card {
            display: none;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: white;
        }

        .exam-card .field {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .exam-card .field-label {
            font-weight: 600;
            color: #4a5568;
        }

        .exam-card .field-value {
            text-align: right;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .exam-table {
            min-width: 100%;
            width: auto;
        }

        @media (max-width: 768px) {
            .desktop-table {
                display: none;
            }

            .exam-card {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .desktop-table {
                display: block;
            }

            .exam-card {
                display: none;
            }
        }

        .edit-icon {
            cursor: pointer;
            margin-left: 5px;
        }

        .no-exam-message {
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('DATACELL.partials.nav')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Exam Numbers Management</h2>

        <div class="mb-6 p-4 bg-white shadow-md rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Exam Filters</h3>
                {{-- <button onclick="{{ route('datacell.add.exam_excel') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                    📤 Upload Exam Marks
                </button> --}}
                <a href="{{ route('datacell.add.exam_excel') }}" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                    📤 Upload Exam Marks
                </a>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
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
                    <select id="section-dropdown" class="border rounded-lg p-2 w-full" onchange="loadExamType()"
                        disabled>
                        <option value="">Select Section</option>
                    </select>
                </div>

                <!-- Exam Type Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Exam Type</label>
                    <select id="exam-type-dropdown" class="border rounded-lg p-2 w-full" onchange="loadExamData()"
                        disabled>
                        <option value="">Select Exam Type</option>
                        <option value="Mid">Mid</option>
                        <option value="Final">Final</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Exam Info Section -->
        <div id="exam-info-container" class="bg-white shadow-md rounded-lg p-4 mb-6 hidden">
            <h3 class="text-xl font-semibold text-gray-800 mb-3">Exam Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p><span class="font-medium">Session:</span> <span id="exam-session"></span></p>
                    <p><span class="font-medium">Course:</span> <span id="exam-course"></span></p>
                    <p><span class="font-medium">Section:</span> <span id="exam-section"></span></p>
                </div>
                <div>
                    <p><span class="font-medium">Exam Type:</span> <span id="exam-type"></span></p>
                    <p><span class="font-medium">Total Marks:</span> <span id="exam-total-marks"></span></p>
                    <p><span class="font-medium">Solid Marks:</span> <span id="exam-solid-marks"></span></p>
                </div>
            </div>
            <div class="mt-4">
                <p><span class="font-medium">Question Paper:</span>
                    <a id="exam-question-paper" href="#" target="_blank"
                        class="text-blue-600 hover:underline">View Question Paper</a>
                </p>
            </div>

            <!-- Question Breakdown -->
            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-700 mb-2">Question Breakdown</h4>
                <div id="question-breakdown" class="flex flex-wrap gap-2">
                    <!-- Questions will be populated here -->
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

        <!-- Desktop Table View -->
        <div id="exam-data-container" class="hidden">
            <div class="bg-white shadow-md rounded-lg overflow-hidden desktop-table">
                <div class="table-container">
                    <table class="exam-table min-w-full divide-y divide-gray-200">
                        <thead id="exam-table-header" class="bg-blue-500 text-white">
                            <!-- Header will be populated dynamically -->
                        </thead>
                        <tbody id="exam-table-body" class="bg-white divide-y divide-gray-200">
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
            <div id="exam-card-container">
                <!-- Student cards will be loaded here -->
            </div>
        </div>

        <!-- No Exam Message -->
        <div id="no-exam-message" class="no-exam-message hidden">
            <p class="text-lg text-gray-600">No exam data exists for the selected criteria.</p>
        </div>
    </div>

    <!-- Edit Marks Modal -->
    <div id="edit-marks-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Marks</h3>
                <button onclick="closeModal('edit-marks-modal')" class="text-gray-500 hover:text-gray-700">
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
                <label class="block text-sm font-medium text-gray-600 mb-1">Question No</label>
                <input type="text" id="edit-question-no" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Total Marks</label>
                <input type="text" id="edit-total-marks" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Obtained Marks</label>
                <input type="number" id="edit-obtained-marks" class="border rounded-lg p-2 w-full" min="0">
            </div>

            <input type="hidden" id="edit-exam-id">
            <input type="hidden" id="edit-question-id">
            <input type="hidden" id="edit-student-id">

            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('edit-marks-modal')"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="updateMarks()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
            </div>
            <div id="edit-marks-loader" class="loader"></div>
            <div id="edit-marks-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <!-- Upload Exam Marks Modal -->

    <script>
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let examData = [];
        let filteredStudents = [];
        let currentExam = null;
        let currentQuestions = [];

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
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/exam/report`);
                const data = await response.json();

                if (data.status === "success" && data.data) {
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
            }
        }

        async function loadCourses() {
            const sessionDropdown = document.getElementById('session-dropdown');
            const selectedSession = sessionDropdown.value;

            if (!selectedSession) {
                document.getElementById('course-dropdown').disabled = true;
                document.getElementById('course-dropdown').innerHTML = '<option value="">Select Course</option>';
                document.getElementById('section-dropdown').disabled = true;
                document.getElementById('section-dropdown').innerHTML = '<option value="">Select Section</option>';
                document.getElementById('exam-type-dropdown').disabled = true;
                resetExamView();
                return;
            }

            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/exam/report`);
                const data = await response.json();

                if (data.status === "success" && data.data) {
                    const selectedSessionData = data.data.find(session => session.session_name === selectedSession);

                    if (selectedSessionData && selectedSessionData.courses) {
                        const courseDropdown = document.getElementById('course-dropdown');
                        courseDropdown.innerHTML = '<option value="">Select Course</option>';

                        selectedSessionData.courses.forEach(course => {
                            const option = document.createElement('option');
                            option.value = course.course_id;
                            option.textContent = `${course.course_code} - ${course.course_name}`;
                            option.setAttribute('data-course-name', course.course_name);
                            option.setAttribute('data-course-code', course.course_code);
                            courseDropdown.appendChild(option);
                        });

                        courseDropdown.disabled = false;
                        document.getElementById('section-dropdown').disabled = true;
                        document.getElementById('section-dropdown').innerHTML =
                            '<option value="">Select Section</option>';
                        document.getElementById('exam-type-dropdown').disabled = true;
                        resetExamView();
                    }
                }
            } catch (error) {
                console.error("Error fetching courses:", error);
                showAlert('error', 'Failed to load courses. Please try again.');
            }
        }

        async function loadSections() {
            const sessionDropdown = document.getElementById('session-dropdown');
            const selectedSession = sessionDropdown.value;
            const courseDropdown = document.getElementById('course-dropdown');
            const selectedCourseId = courseDropdown.value;

            if (!selectedCourseId) {
                document.getElementById('section-dropdown').disabled = true;
                document.getElementById('section-dropdown').innerHTML = '<option value="">Select Section</option>';
                document.getElementById('exam-type-dropdown').disabled = true;
                resetExamView();
                return;
            }

            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/exam/report`);
                const data = await response.json();

                if (data.status === "success" && data.data) {
                    const selectedSessionData = data.data.find(session => session.session_name === selectedSession);

                    if (selectedSessionData && selectedSessionData.courses) {
                        const selectedCourse = selectedSessionData.courses.find(course => course.course_id ==
                            selectedCourseId);

                        if (selectedCourse && selectedCourse.sections) {
                            const sectionDropdown = document.getElementById('section-dropdown');
                            sectionDropdown.innerHTML = '<option value="">Select Section</option>';

                            selectedCourse.sections.forEach(section => {
                                const option = document.createElement('option');
                                option.value = section.section_id;
                                option.textContent = section.section_name;
                                sectionDropdown.appendChild(option);
                            });

                            sectionDropdown.disabled = false;
                            document.getElementById('exam-type-dropdown').disabled = true;
                            resetExamView();
                        }
                    }
                }
            } catch (error) {
                console.error("Error fetching sections:", error);
                showAlert('error', 'Failed to load sections. Please try again.');
            }
        }

        function loadExamType() {
            const sectionDropdown = document.getElementById('section-dropdown');
            const selectedSectionId = sectionDropdown.value;

            if (!selectedSectionId) {
                document.getElementById('exam-type-dropdown').disabled = true;
                resetExamView();
                return;
            }

            document.getElementById('exam-type-dropdown').disabled = false;
            resetExamView();
        }

        async function loadExamData() {
            const sessionDropdown = document.getElementById('session-dropdown');
            const selectedSession = sessionDropdown.value;
            const courseDropdown = document.getElementById('course-dropdown');
            const selectedCourseId = courseDropdown.value;
            const selectedCourseName = courseDropdown.options[courseDropdown.selectedIndex].getAttribute(
                'data-course-name');
            const selectedCourseCode = courseDropdown.options[courseDropdown.selectedIndex].getAttribute(
                'data-course-code');
            const sectionDropdown = document.getElementById('section-dropdown');
            const selectedSectionId = sectionDropdown.value;
            const selectedSectionName = sectionDropdown.options[sectionDropdown.selectedIndex].text;
            const examTypeDropdown = document.getElementById('exam-type-dropdown');
            const selectedExamType = examTypeDropdown.value;

            if (!selectedExamType) {
                resetExamView();
                return;
            }

            try {
                document.getElementById('loader').style.display = 'block';
                document.getElementById('exam-data-container').classList.add('hidden');
                document.getElementById('no-exam-message').classList.add('hidden');
                document.getElementById('exam-info-container').classList.add('hidden');
                document.getElementById('student-search-container').classList.add('hidden');

                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/exam/report`);
                const data = await response.json();

                if (data.status === "success" && data.data) {
                    const selectedSessionData = data.data.find(session => session.session_name === selectedSession);

                    if (selectedSessionData && selectedSessionData.courses) {
                        const selectedCourse = selectedSessionData.courses.find(course => course.course_id ==
                            selectedCourseId);

                        if (selectedCourse && selectedCourse.sections) {
                            const selectedSection = selectedCourse.sections.find(section => section.section_id ==
                                selectedSectionId);

                            if (selectedSection && selectedSection.exams) {
                                currentExam = selectedSection.exams[selectedExamType];

                                if (!currentExam) {
                                    document.getElementById('no-exam-message').classList.remove('hidden');
                                    document.getElementById('exam-info-container').classList.add('hidden');
                                    document.getElementById('student-search-container').classList.add('hidden');
                                    document.getElementById('exam-data-container').classList.add('hidden');
                                    return;
                                }

                                // Set exam info
                                document.getElementById('exam-session').textContent = selectedSession;
                                document.getElementById('exam-course').textContent =
                                    `${selectedCourseCode} - ${selectedCourseName}`;
                                document.getElementById('exam-section').textContent = selectedSectionName;
                                document.getElementById('exam-type').textContent = selectedExamType;
                                document.getElementById('exam-total-marks').textContent = currentExam.total_marks;
                                document.getElementById('exam-solid-marks').textContent = currentExam.solid_marks;

                                const questionPaperLink = document.getElementById('exam-question-paper');
                                if (currentExam.question_paper) {
                                    questionPaperLink.href = `${API_BASE_URL}${currentExam.question_paper}`;
                                    questionPaperLink.classList.remove('hidden');
                                } else {
                                    questionPaperLink.classList.add('hidden');
                                }

                                // Set question breakdown
                                const questionBreakdown = document.getElementById('question-breakdown');
                                questionBreakdown.innerHTML = '';
                                currentQuestions = currentExam.questions || [];

                                currentQuestions.forEach(question => {
                                    const questionBadge = document.createElement('div');
                                    questionBadge.className =
                                        'bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm';
                                    questionBadge.textContent = `Q${question.q_no} (${question.marks} marks)`;
                                    questionBreakdown.appendChild(questionBadge);
                                });

                                // Set students data
                                examData = currentExam.students || [];
                                filteredStudents = [...examData];

                                // Show the containers
                                document.getElementById('exam-info-container').classList.remove('hidden');
                                document.getElementById('student-search-container').classList.remove('hidden');
                                document.getElementById('exam-data-container').classList.remove('hidden');

                                renderStudents();
                            } else {
                                document.getElementById('no-exam-message').classList.remove('hidden');
                                document.getElementById('exam-info-container').classList.add('hidden');
                                document.getElementById('student-search-container').classList.add('hidden');
                                document.getElementById('exam-data-container').classList.add('hidden');
                            }
                        }
                    }
                }
            } catch (error) {
                console.error("Error fetching exam data:", error);
                showAlert('error', 'Failed to load exam data. Please try again.');
            } finally {
                document.getElementById('loader').style.display = 'none';
            }
        }

        function renderStudents() {
            const tableHeader = document.getElementById('exam-table-header');
            const tableBody = document.getElementById('exam-table-body');
            const cardContainer = document.getElementById('exam-card-container');
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

            // Add question headers
            currentQuestions.forEach(question => {
                const questionHeader = document.createElement('th');
                questionHeader.className = 'px-6 py-3 text-center text-xs font-medium uppercase tracking-wider';
                questionHeader.textContent = `Q${question.q_no} (${question.marks})`;
                headerRow.appendChild(questionHeader);
            });

            const totalHeader = document.createElement('th');
            totalHeader.className = 'px-6 py-3 text-center text-xs font-medium uppercase tracking-wider';
            totalHeader.textContent = 'Total';
            headerRow.appendChild(totalHeader);

            const solidHeader = document.createElement('th');
            solidHeader.className = 'px-6 py-3 text-center text-xs font-medium uppercase tracking-wider';
            solidHeader.textContent = 'Solid';
            headerRow.appendChild(solidHeader);

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

                // Question marks
                currentQuestions.forEach(question => {
                    const questionMark = student.question_marks.find(q => q.question_id === question.id) ||
                    {};

                    const markCell = document.createElement('td');
                    markCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center';

                    const markContainer = document.createElement('div');
                    markContainer.className = 'flex items-center justify-center';

                    const markValue = document.createElement('span');
                    markValue.textContent = questionMark.obtained_marks !== null ? questionMark
                        .obtained_marks : 'N/A';
                    markContainer.appendChild(markValue);

                    if (questionMark.obtained_marks !== null) {
                        const editIcon = document.createElement('span');
                        editIcon.className = 'edit-icon';
                        editIcon.textContent = '✏️';
                        editIcon.onclick = () => openEditMarksModal(
                            currentExam.exam_id,
                            question.id,
                            student.student_id,
                            student.name,
                            student.regNo,
                            question.q_no,
                            question.marks,
                            questionMark.obtained_marks
                        );
                        markContainer.appendChild(editIcon);
                    } else {
                        const addIcon = document.createElement('span');
                        addIcon.className = 'edit-icon';
                        addIcon.textContent = '➕';
                        addIcon.onclick = () => openEditMarksModal(
                            currentExam.exam_id,
                            question.id,
                            student.student_id,
                            student.name,
                            student.regNo,
                            question.q_no,
                            question.marks,
                            null
                        );
                        markContainer.appendChild(addIcon);
                    }

                    markCell.appendChild(markContainer);
                    row.appendChild(markCell);
                });

                // Total marks
                const totalCell = document.createElement('td');
                totalCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center';
                totalCell.textContent = student.total_obtained;
                row.appendChild(totalCell);

                // Solid marks
                const solidCell = document.createElement('td');
                solidCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center';
                solidCell.textContent = student.solid_obtained;
                row.appendChild(solidCell);

                tableBody.appendChild(row);

                // Mobile card
                const card = document.createElement('div');
                card.className = 'exam-card';

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

                // Question marks
                currentQuestions.forEach(question => {
                    const questionMark = student.question_marks.find(q => q.question_id === question.id) ||
                    {};

                    const field = document.createElement('div');
                    field.className = 'field';

                    const fieldLabel = document.createElement('span');
                    fieldLabel.className = 'field-label';
                    fieldLabel.textContent = `Q${question.q_no} (${question.marks}):`;

                    const fieldValue = document.createElement('span');
                    fieldValue.className = 'field-value';

                    const markValue = document.createElement('span');
                    markValue.textContent = questionMark.obtained_marks !== null ? questionMark
                        .obtained_marks : 'N/A';
                    fieldValue.appendChild(markValue);

                    if (questionMark.obtained_marks !== null) {
                        const editIcon = document.createElement('span');
                        editIcon.className = 'edit-icon';
                        editIcon.textContent = '✏️';
                        editIcon.onclick = () => openEditMarksModal(
                            currentExam.exam_id,
                            question.id,
                            student.student_id,
                            student.name,
                            student.regNo,
                            question.q_no,
                            question.marks,
                            questionMark.obtained_marks
                        );
                        fieldValue.appendChild(editIcon);
                    } else {
                        const addIcon = document.createElement('span');
                        addIcon.className = 'edit-icon';
                        addIcon.textContent = '➕';
                        addIcon.onclick = () => openEditMarksModal(
                            currentExam.exam_id,
                            question.id,
                            student.student_id,
                            student.name,
                            student.regNo,
                            question.q_no,
                            question.marks,
                            null
                        );
                        fieldValue.appendChild(addIcon);
                    }

                    field.appendChild(fieldLabel);
                    field.appendChild(fieldValue);
                    card.appendChild(field);
                });

                // Total marks
                const totalField = document.createElement('div');
                totalField.className = 'field';

                const totalLabel = document.createElement('span');
                totalLabel.className = 'field-label';
                totalLabel.textContent = 'Total:';

                const totalValue = document.createElement('span');
                totalValue.className = 'field-value';
                totalValue.textContent = student.total_obtained;

                totalField.appendChild(totalLabel);
                totalField.appendChild(totalValue);
                card.appendChild(totalField);

                // Solid marks
                const solidField = document.createElement('div');
                solidField.className = 'field';

                const solidLabel = document.createElement('span');
                solidLabel.className = 'field-label';
                solidLabel.textContent = 'Solid:';

                const solidValue = document.createElement('span');
                solidValue.className = 'field-value';
                solidValue.textContent = student.solid_obtained;

                solidField.appendChild(solidLabel);
                solidField.appendChild(solidValue);
                card.appendChild(solidField);

                cardContainer.appendChild(card);
            });
        }

        function filterStudents() {
            const nameSearch = document.getElementById('search-name').value.toLowerCase();
            const regNoSearch = document.getElementById('search-regno').value.toLowerCase();

            filteredStudents = examData.filter(student =>
                (student.name.toLowerCase().includes(nameSearch) || nameSearch === '') &&
                (student.regNo.toLowerCase().includes(regNoSearch) || regNoSearch === '')
            );

            renderStudents();
        }

        function resetStudentSearch() {
            document.getElementById('search-name').value = '';
            document.getElementById('search-regno').value = '';
            filteredStudents = [...examData];
            renderStudents();
        }

        function resetExamView() {
            document.getElementById('exam-info-container').classList.add('hidden');
            document.getElementById('student-search-container').classList.add('hidden');
            document.getElementById('exam-data-container').classList.add('hidden');
            document.getElementById('no-exam-message').classList.add('hidden');
            examData = [];
            filteredStudents = [];
            currentExam = null;
            currentQuestions = [];
        }

        function openEditMarksModal(examId, questionId, studentId, studentName, regNo, questionNo, totalMarks,
            obtainedMarks) {
            document.getElementById('edit-exam-id').value = examId;
            document.getElementById('edit-question-id').value = questionId;
            document.getElementById('edit-student-id').value = studentId;
            document.getElementById('edit-student-name').value = studentName;
            document.getElementById('edit-reg-no').value = regNo;
            document.getElementById('edit-question-no').value = questionNo;
            document.getElementById('edit-total-marks').value = totalMarks;
            document.getElementById('edit-obtained-marks').value = obtainedMarks || '';
            document.getElementById('edit-obtained-marks').max = totalMarks;
            document.getElementById('edit-marks-message').classList.add('hidden');
            document.getElementById('edit-marks-modal').style.display = 'flex';
        }

        function openUploadModal() {

        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        async function updateMarks() {
            const examId = document.getElementById('edit-exam-id').value;
            const questionId = document.getElementById('edit-question-id').value;
            const studentId = document.getElementById('edit-student-id').value;
            const obtainedMarks = document.getElementById('edit-obtained-marks').value;
            const totalMarks = document.getElementById('edit-total-marks').value;

            if (obtainedMarks === '') {
                showMessage('edit-marks-message', 'Please enter obtained marks.', 'error');
                return;
            }

            if (parseFloat(obtainedMarks) > parseFloat(totalMarks)) {
                showMessage('edit-marks-message', `Obtained marks cannot exceed ${totalMarks}.`, 'error');
                return;
            }

            try {
                document.getElementById('edit-marks-loader').style.display = 'block';
                document.getElementById('edit-marks-message').classList.add('hidden');

                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/update-student-question-marks`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        exam_id: examId,
                        question_id: questionId,
                        student_id: studentId,
                        obtained_marks: obtainedMarks
                    })
                });

                const data = await response.json();

                if (data.status === true) {
                    showMessage('edit-marks-message', data.message || 'Marks updated successfully!', 'success');

                    // Reload the exam data without refreshing the page
                    setTimeout(() => {
                        closeModal('edit-marks-modal');
                        loadExamData();
                    }, 1500);
                } else {
                    showMessage('edit-marks-message', data.message || 'Failed to update marks.', 'error');
                }
            } catch (error) {
                console.error('Error updating marks:', error);
                showMessage('edit-marks-message', 'An error occurred while updating marks.', 'error');
            } finally {
                document.getElementById('edit-marks-loader').style.display = 'none';
            }
        }

        async function uploadExamMarks() {
            const fileInput = document.getElementById('exam-marks-file');
            const file = fileInput.files[0];

            if (!file) {
                showMessage('upload-message', 'Please select a file to upload.', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('file', file);

            try {
                document.getElementById('upload-loader').style.display = 'block';
                document.getElementById('upload-message').classList.add('hidden');

                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/upload-exam-marks`, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.status === true) {
                    showMessage('upload-message', data.message || 'File uploaded successfully!', 'success');

                    // Reload the current view if we're already showing exam data
                    setTimeout(() => {
                        closeModal('upload-modal');
                        if (currentExam) {
                            loadExamData();
                        }
                    }, 1500);
                } else {
                    showMessage('upload-message', data.message || 'Failed to upload file.', 'error');
                }
            } catch (error) {
                console.error('Error uploading file:', error);
                showMessage('upload-message', 'An error occurred while uploading file.', 'error');
            } finally {
                document.getElementById('upload-loader').style.display = 'none';
            }
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
