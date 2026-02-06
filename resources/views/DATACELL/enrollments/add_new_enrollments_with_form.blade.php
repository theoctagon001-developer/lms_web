<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Enrolment</title>
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a365d;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #4a5568;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 1rem;
        }

        .form-input:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-primary {
            background-color: #4299e1;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #3182ce;
        }

        .btn-secondary {
            background-color: #e2e8f0;
            color: #4a5568;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #cbd5e0;
        }

        /* Student search styles */
        .student-search-container {
            position: relative;
        }

        .student-search-results {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            max-height: 300px;
            overflow-y: auto;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 0 0 0.375rem 0.375rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 10;
            display: none;
        }

        .student-result-item {
            padding: 0.75rem;
            cursor: pointer;
            border-bottom: 1px solid #e2e8f0;
        }

        .student-result-item:hover {
            background-color: #f7fafc;
        }

        .selected-students-list {
            margin-top: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            padding: 0.5rem;
        }

        .selected-student {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem;
            background-color: #f7fafc;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .remove-student {
            color: #e53e3e;
            cursor: pointer;
            font-weight: bold;
        }

        /* Response list styles */
        .response-list {
            margin-top: 1.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            padding: 1rem;
        }

        .response-item {
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 0.25rem;
        }

        .response-success {
            background-color: #f0fff4;
            color: #2f855a;
            border-left: 4px solid #38a169;
        }

        .response-error {
            background-color: #fff5f5;
            color: #c53030;
            border-left: 4px solid #e53e3e;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('DATACELL.partials.nav')
    <div class="container mx-auto px-4 py-8">
        <div class="form-container">
            <h1 class="form-title">Add New Enrolment</h1>
            
            <form id="add-enrolment-form">
                <div class="form-grid">
                    <!-- Session Selection -->
                    <div class="form-group">
                        <label for="enrolment-session" class="form-label">Session</label>
                        <select id="enrolment-session" class="form-input" required>
                            <option value="">Select Session</option>
                        </select>
                        <div id="session-error" class="error-message">Please select a session</div>
                    </div>

                    <!-- Course Selection -->
                    <div class="form-group">
                        <label for="enrolment-course" class="form-label">Course</label>
                        <select id="enrolment-course" class="form-input" disabled required>
                            <option value="">Select Course</option>
                        </select>
                        <div id="course-error" class="error-message">Please select a course</div>
                    </div>

                    <!-- Section Selection -->
                    <div class="form-group">
                        <label for="enrolment-section" class="form-label">Section</label>
                        <select id="enrolment-section" class="form-input" disabled required>
                            <option value="">Select Section</option>
                        </select>
                        <div id="section-error" class="error-message">Please select a section</div>
                    </div>

                    <!-- Student Search -->
                    <div class="form-group">
                        <label class="form-label">Add Students</label>
                        <div class="student-search-container">
                            <input type="text" id="student-search" class="form-input" placeholder="Search by name or ARID number">
                            <div id="student-search-results" class="student-search-results"></div>
                        </div>
                        <div id="selected-students" class="selected-students-list hidden">
                            <div class="text-sm font-medium mb-2">Selected Students:</div>
                            <div id="selected-students-list"></div>
                        </div>
                        <div id="student-error" class="error-message">Please add at least one student</div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="window.history.back()" class="btn btn-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Add Enrolments
                    </button>
                </div>

                <div id="add-enrolment-loader" class="loader"></div>
                <div id="add-enrolment-message" class="hidden mt-4 p-3 rounded"></div>
                
                <!-- Response List -->
                <div id="response-list" class="response-list hidden">
                    <h3 class="text-lg font-medium mb-3">Enrolment Results:</h3>
                    <div id="response-items"></div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let reportData = [];
        let allSections = [];
        let selectedStudents = [];
        let studentSearchTimeout = null;

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        // Load report sessions for dropdown
        async function loadReportSessions() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/enrollment/report`);
                const data = await response.json();
                
                if (data.status === "success" && data.data) {
                    reportData = data.data;
                    const sessionDropdown = document.getElementById('enrolment-session');
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
            }
        }

        // Load all sections from standalone API (independent of session/course)
        async function loadAllSections() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Dropdown/AllSection`);
                const data = await response.json();
                
                if (data) {
                    allSections = data;
                    const sectionDropdown = document.getElementById('enrolment-section');
                    sectionDropdown.innerHTML = '<option value="">Select Section</option>';
                    
                    data.forEach(section => {
                        const option = document.createElement('option');
                        option.value = section.id;
                        option.textContent = section.data;
                        sectionDropdown.appendChild(option);
                    });
                    
                    // Enable section dropdown (independent of other selections)
                    sectionDropdown.disabled = false;
                }
            } catch (error) {
                console.error("Error fetching sections:", error);
                showAlert('error', 'Failed to load sections. Please try again.');
            }
        }

        // Load courses for selected session
        function loadEnrolmentSessionCourses() {
            const sessionDropdown = document.getElementById('enrolment-session');
            const selectedSessionName = sessionDropdown.value;

            if (!selectedSessionName) {
                document.getElementById('enrolment-course').disabled = true;
                document.getElementById('enrolment-course').innerHTML = '<option value="">Select Course</option>';
                return;
            }

            const selectedSession = reportData.find(session => session.session_name === selectedSessionName);
            const courseDropdown = document.getElementById('enrolment-course');
            courseDropdown.innerHTML = '<option value="">Select Course</option>';

            if (selectedSession && selectedSession.courses) {
                selectedSession.courses.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course.course_id;
                    option.textContent = `${course.course_code} - ${course.course_name}`;
                    courseDropdown.appendChild(option);
                });

                courseDropdown.disabled = false;
            }
        }

        // Search students by name or ARID
        async function searchStudents(query) {
            if (!query || query.length < 2) {
                document.getElementById('student-search-results').style.display = 'none';
                return;
            }

            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Dropdown/AllStudentData`);
                const data = await response.json();
                
                if (data) {
                    const results = data.filter(student => {
                        const searchStr = query.toLowerCase();
                        return (
                            student.Format.toLowerCase().includes(searchStr) || 
                            (student.ARID && student.ARID.toLowerCase().includes(searchStr))
                        );
                    });

                    displaySearchResults(results);
                }
            } catch (error) {
                console.error("Error searching students:", error);
                showAlert('error', 'Failed to search students. Please try again.');
            }
        }

        // Display student search results
        function displaySearchResults(students) {
            const resultsContainer = document.getElementById('student-search-results');
            resultsContainer.innerHTML = '';

            if (students.length === 0) {
                resultsContainer.innerHTML = '<div class="student-result-item">No students found</div>';
                resultsContainer.style.display = 'block';
                return;
            }

            students.forEach(student => {
                // Skip if student is already selected
                if (selectedStudents.some(s => s.id === student.id)) {
                    return;
                }

                const item = document.createElement('div');
                item.className = 'student-result-item';
                item.innerHTML = student.Format;
                item.addEventListener('click', () => {
                    addSelectedStudent(student);
                    document.getElementById('student-search').value = '';
                    resultsContainer.style.display = 'none';
                });
                resultsContainer.appendChild(item);
            });

            resultsContainer.style.display = 'block';
        }

        // Add student to selected list
        function addSelectedStudent(student) {
            // Check if student is already selected
            if (selectedStudents.some(s => s.id === student.id)) {
                return;
            }

            selectedStudents.push(student);
            updateSelectedStudentsList();
        }

        // Remove student from selected list
        function removeSelectedStudent(studentId) {
            selectedStudents = selectedStudents.filter(student => student.id !== studentId);
            updateSelectedStudentsList();
        }

        // Update the selected students list UI
        function updateSelectedStudentsList() {
            const container = document.getElementById('selected-students');
            const list = document.getElementById('selected-students-list');
            list.innerHTML = '';

            if (selectedStudents.length === 0) {
                container.classList.add('hidden');
                return;
            }

            container.classList.remove('hidden');

            selectedStudents.forEach(student => {
                const item = document.createElement('div');
                item.className = 'selected-student';
                item.innerHTML = `
                    <span>${student.Format}</span>
                    <span class="remove-student" data-id="${student.id}">×</span>
                `;
                list.appendChild(item);
            });

            // Add event listeners to remove buttons
            document.querySelectorAll('.remove-student').forEach(button => {
                button.addEventListener('click', (e) => {
                    const studentId = parseInt(e.target.getAttribute('data-id'));
                    removeSelectedStudent(studentId);
                });
            });
        }

        // Validate form
        function validateForm() {
            let isValid = true;
            
            // Validate session
            if (!document.getElementById('enrolment-session').value) {
                document.getElementById('enrolment-session').classList.add('input-error');
                document.getElementById('session-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('enrolment-session').classList.remove('input-error');
                document.getElementById('session-error').style.display = 'none';
            }
            
            // Validate course
            if (!document.getElementById('enrolment-course').value) {
                document.getElementById('enrolment-course').classList.add('input-error');
                document.getElementById('course-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('enrolment-course').classList.remove('input-error');
                document.getElementById('course-error').style.display = 'none';
            }
            
            // Validate section
            if (!document.getElementById('enrolment-section').value) {
                document.getElementById('enrolment-section').classList.add('input-error');
                document.getElementById('section-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('enrolment-section').classList.remove('input-error');
                document.getElementById('section-error').style.display = 'none';
            }
            
            // Validate students
            if (selectedStudents.length === 0) {
                document.getElementById('student-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('student-error').style.display = 'none';
            }
            
            return isValid;
        }

        // Add new enrolments for all selected students
        async function addEnrolments() {
            const sessionName = document.getElementById('enrolment-session').value;
            const courseId = document.getElementById('enrolment-course').value;
            const sectionId = document.getElementById('enrolment-section').value;
            
            if (!validateForm()) {
                return;
            }
            
            try {
                document.getElementById('add-enrolment-loader').style.display = 'block';
                document.getElementById('add-enrolment-message').classList.add('hidden');
                document.getElementById('response-list').classList.add('hidden');
                document.getElementById('response-items').innerHTML = '';
                
                // First, we need to get the offered_course_id for this session and course
                const session = reportData.find(s => s.session_name === sessionName);
                if (!session) {
                    showMessage('add-enrolment-message', 'Session not found', 'error');
                    return;
                }
                
                const course = session.courses.find(c => c.course_id == courseId);
                if (!course) {
                    showMessage('add-enrolment-message', 'Course not found', 'error');
                    return;
                }
                
                // Assuming we can use the first section's offered_course_id (may need API adjustment)
                let offeredCourseId =course.offered_course_id;
                // if (course.sections && course.sections.length > 0) {
                //     const section = course.sections.find(s => s.section_id == sectionId);
                //     if (section && section.enrollments && section.enrollments.length > 0) {
                //         offeredCourseId = section.enrollments[0].student_offered_course_id;
                //     }
                // }
                
                if (!offeredCourseId) {
                    showMessage('add-enrolment-message', 'Could not determine offered course. Please add at least one enrolment first.', 'error');
                    return;
                }
                const responseList = document.getElementById('response-items');
                const responseContainer = document.getElementById('response-list');
                responseContainer.classList.remove('hidden');  
                let successCount = 0;
                let errorCount = 0; 
                for (const student of selectedStudents) {
                    try {
                        const response = await fetch(`${API_BASE_URL}api/Insertion/enrollment/add`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                student_id: student.id,
                                offered_course_id: offeredCourseId,
                                section_id: sectionId
                            })
                        });
                        
                        const data = await response.json();
                        
                        const responseItem = document.createElement('div');
                        responseItem.className = 'response-item';
                        
                        if (data.status === 'success') {
                            responseItem.classList.add('response-success');
                            responseItem.innerHTML = `
                                <strong>${student.Format}</strong>: Enrolment added successfully
                            `;
                            successCount++;
                        } else {
                            responseItem.classList.add('response-error');
                            responseItem.innerHTML = `
                                <strong>${student.Format}</strong>: ${data.message || 'Failed to add enrolment'}
                            `;
                            errorCount++;
                        }
                        
                        responseList.appendChild(responseItem);
                    } catch (error) {
                        console.error(`Error enrolling student ${student.id}:`, error);
                        
                        const responseItem = document.createElement('div');
                        responseItem.className = 'response-item response-error';
                        responseItem.innerHTML = `
                            <strong>${student.Format}</strong>: An error occurred while adding enrolment
                        `;
                        errorCount++;
                        
                        responseList.appendChild(responseItem);
                    }
                }
                
                // Show summary message
                showMessage(
                    'add-enrolment-message',
                    `Processed ${selectedStudents.length} students. Success: ${successCount}, Errors: ${errorCount}`,
                    errorCount === 0 ? 'success' : 'warning'
                );
                
                // Clear selected students if all were successful
                if (errorCount === 0) {
                    selectedStudents = [];
                    updateSelectedStudentsList();
                }
            } catch (error) {
                console.error('Error in enrollment process:', error);
                showMessage('add-enrolment-message', 'An error occurred while processing enrolments.', 'error');
            } finally {
                document.getElementById('add-enrolment-loader').style.display = 'none';
            }
        }

        // Show message
        function showMessage(elementId, message, type) {
            const element = document.getElementById(elementId);
            element.textContent = message;
            element.classList.remove('hidden');
            
            if (type === 'success') {
                element.className = 'bg-green-100 text-green-700 mt-4 p-3 rounded';
            } else if (type === 'warning') {
                element.className = 'bg-yellow-100 text-yellow-700 mt-4 p-3 rounded';
            } else {
                element.className = 'bg-red-100 text-red-700 mt-4 p-3 rounded';
            }
        }

        // Show alert
        function showAlert(type, message) {
            alert(`${type.toUpperCase()}: ${message}`);
        }

        // Initialize the page
        document.addEventListener("DOMContentLoaded", async function() {
            // Load initial data
            await loadReportSessions();
            await loadAllSections(); // Load sections independently
            
            // Set up event listeners
            document.getElementById('enrolment-session').addEventListener('change', loadEnrolmentSessionCourses);
            
            // Enable course dropdown when session is selected
            document.getElementById('enrolment-session').addEventListener('change', function() {
                document.getElementById('enrolment-course').disabled = !this.value;
            });
            
            // Enable section dropdown (already enabled by loadAllSections)
            
            // Student search functionality
            document.getElementById('student-search').addEventListener('input', (e) => {
                clearTimeout(studentSearchTimeout);
                studentSearchTimeout = setTimeout(() => {
                    searchStudents(e.target.value);
                }, 300);
            });
            
            // Hide search results when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.student-search-container')) {
                    document.getElementById('student-search-results').style.display = 'none';
                }
            });
            
            // Form submission
            document.getElementById('add-enrolment-form').addEventListener('submit', function(e) {
                e.preventDefault();
                addEnrolments();
            });
        });
    </script>
    @include('components.footer')
</body>
</html>