<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Numbers Management</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
          :root {
            --primary-color: #4361EE;
            --active-color: #4CC9F0;
            --previous-color: #6C757D;
            --light-background: #F8F9FA;
            --text-primary: #212529;
            --text-secondary: #6C757D;
            --success-color: #28A745;
            --warning-color: #FFC107;
            --danger-color: #DC3545;
            --card-background: #FFFFFF;
            --info-color: #17A2B8;
            --header-bg: #1E3A8A;
            --footer-bg: #1E3A8A;
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
          .header {
            background-color: var(--header-bg);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .header-title:hover {
            opacity: 0.9;
        }
        
        .header-title i {
            font-size: 1.75rem;
        }
      

        .exam-card {
            display: none;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .exam-card .field {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .exam-card .field:last-child {
            border-bottom: none;
        }

        .exam-card .field-label {
            font-weight: 600;
            color: #4a5568;
        }
            .sticky-top-container {
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .sticky-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .exam-card .field-value {
            text-align: right;
            color: #2d3748;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
        }
         .footer {
            background-color: #f8f9fa;
            padding: 1rem 0;
            text-align: center;
            margin-top: 2rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            color: #6c757d;
            font-size: 0.875rem;
        }

        .exam-table {
            min-width: 100%;
            width: auto;
            border-collapse: collapse;
        }

        .exam-table th {
            background-color: #3b82f6;
            color: white;
            padding: 12px 15px;
            text-align: left;
        }

        .exam-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .exam-table tr:hover {
            background-color: #f8fafc;
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

        .no-exam-message {
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* Header Styles */
        .sticky-top-container {
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .sticky-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Footer Styles */
         .footer {
            background-color: var(--footer-bg);
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
            margin-top: 2rem;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            font-size: 0.9rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }
        
        .footer-content a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-content a:hover {
            text-decoration: underline;
        }

        /* Badge Styles */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .badge-blue {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-icon {
            margin-right: 0.25rem;
            font-size: 0.75rem;
        }

        /* Card Header Styles */
        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .card-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 9999px;
            background-color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: #4a5568;
        }

        /* Info Box Styles */
        .info-box {
            background-color: #f8fafc;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .info-box-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .info-box-title i {
            margin-right: 0.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .info-item {
            margin-bottom: 0.5rem;
        }

        .info-label {
            font-weight: 600;
            color: #4a5568;
            font-size: 0.875rem;
        }

        .info-value {
            color: #2d3748;
            margin-top: 0.25rem;
        }

        /* Question Breakdown */
        .question-breakdown {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        /* Search Container */
        .search-container {
            background-color: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .search-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .search-title i {
            margin-right: 0.5rem;
        }

        /* Responsive Grid */
        .responsive-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        /* Main Container */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Page Title */
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 1.5rem;
            text-align: center;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Sticky Header -->
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
        <h1 class="page-title">
            <i class="fas fa-clipboard-list mr-2"></i>Exam Numbers Management
        </h1>

        <!-- Filters Section -->
        <div class="info-box">
            <h3 class="info-box-title">
                <i class="fas fa-filter"></i>Exam Filters
            </h3>
            <div class="responsive-grid">
                <!-- Session Dropdown -->
                <div>
                    <label class="info-label">Session</label>
                    <select id="session-dropdown" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="loadCourses()">
                        <option value="">Select Session</option>
                    </select>
                </div>

                <!-- Course Dropdown -->
                <div>
                    <label class="info-label">Course</label>
                    <select id="course-dropdown" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="loadSections()" disabled>
                        <option value="">Select Course</option>
                    </select>
                </div>

                <!-- Section Dropdown -->
                <div>
                    <label class="info-label">Section</label>
                    <select id="section-dropdown" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="loadExamType()" disabled>
                        <option value="">Select Section</option>
                    </select>
                </div>

                <!-- Exam Type Dropdown -->
                <div>
                    <label class="info-label">Exam Type</label>
                    <select id="exam-type-dropdown" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="loadExamData()" disabled>
                        <option value="">Select Exam Type</option>
                        <option value="Mid">Mid</option>
                        <option value="Final">Final</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Exam Info Section -->
        <div id="exam-info-container" class="info-box hidden">
            <h3 class="info-box-title">
                <i class="fas fa-info-circle"></i>Exam Information
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Session</div>
                    <div class="info-value" id="exam-session"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Course</div>
                    <div class="info-value" id="exam-course"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Section</div>
                    <div class="info-value" id="exam-section"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Exam Type</div>
                    <div class="info-value" id="exam-type"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Total Marks</div>
                    <div class="info-value" id="exam-total-marks"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Solid Marks</div>
                    <div class="info-value" id="exam-solid-marks"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Question Paper</div>
                    <div class="info-value">
                        <a id="exam-question-paper" href="#" target="_blank" class="text-blue-600 hover:underline hidden">
                            <i class="fas fa-file-pdf mr-1"></i>View Question Paper
                        </a>
                        <span id="no-question-paper" class="text-gray-500">Not available</span>
                    </div>
                </div>
            </div>

            <!-- Question Breakdown -->
            <div class="mt-4">
                <div class="info-label">Question Breakdown</div>
                <div id="question-breakdown" class="question-breakdown">
                    <!-- Questions will be populated here -->
                </div>
            </div>
        </div>

        <!-- Student Search -->
        <div id="student-search-container" class="search-container hidden">
            <h3 class="search-title">
                <i class="fas fa-search"></i>Search Students
            </h3>
            <div class="responsive-grid">
                <div>
                    <label class="info-label">Student Name</label>
                    <input type="text" id="search-name" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter student name" oninput="filterStudents()">
                </div>
                <div>
                    <label class="info-label">Registration No</label>
                    <input type="text" id="search-regno" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter registration no" oninput="filterStudents()">
                </div>
            </div>
            <div class="mt-4">
                <button onclick="resetStudentSearch()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-undo mr-2"></i>Reset Search
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
                    <i class="fas fa-exclamation-circle mr-2"></i>No students found matching your criteria.
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
            <i class="fas fa-clipboard-question text-3xl text-gray-400 mb-3"></i>
            <p class="text-lg text-gray-600">No exam data exists for the selected criteria.</p>
        </div>
    </div>

    <!-- Footer -->
   <footer class="footer">
        <div class="footer-content">
            © Sharjeel | Ali | Sameer Learning Management System
        </div>
    </footer>

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
                                const noQuestionPaper = document.getElementById('no-question-paper');
                                
                                if (currentExam.question_paper) {
                                    questionPaperLink.href = `${API_BASE_URL}${currentExam.question_paper}`;
                                    questionPaperLink.classList.remove('hidden');
                                    noQuestionPaper.classList.add('hidden');
                                } else {
                                    questionPaperLink.classList.add('hidden');
                                    noQuestionPaper.classList.remove('hidden');
                                }

                                // Set question breakdown
                                const questionBreakdown = document.getElementById('question-breakdown');
                                questionBreakdown.innerHTML = '';
                                currentQuestions = currentExam.questions || [];

                                currentQuestions.forEach(question => {
                                    const questionBadge = document.createElement('div');
                                    questionBadge.className = 'badge badge-blue';
                                    questionBadge.innerHTML = `<i class="fas fa-question-circle badge-icon"></i>Q${question.q_no} (${question.marks} marks)`;
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
                    markCell.textContent = questionMark.obtained_marks !== null ? questionMark.obtained_marks : 'N/A';
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
                cardHeader.className = 'card-header';

                const avatar = document.createElement('div');
                avatar.className = 'card-avatar';
                avatar.innerHTML = '<i class="fas fa-user"></i>';
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
                    fieldLabel.textContent = `Q${question.q_no} (${question.marks} marks):`;

                    const fieldValue = document.createElement('span');
                    fieldValue.className = 'field-value';
                    fieldValue.textContent = questionMark.obtained_marks !== null ? questionMark.obtained_marks : 'N/A';

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
                function navigateToDashboard() {
            window.location.href = "{{ route('director.dashboard') }}";
        }

        function showAlert(type, message) {
            alert(`${type.toUpperCase()}: ${message}`);
        }

        document.addEventListener("DOMContentLoaded", loadSessions);
    </script>
</body>

</html>