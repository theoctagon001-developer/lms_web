<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Limits Management</title>
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
            max-width: 500px;
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
        .course-card {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: white;
        }
        .course-card .field {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .course-card .field-label {
            font-weight: 600;
            color: #4a5568;
        }
        .course-card .field-value {
            text-align: right;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        .course-table {
            min-width: 100%;
            width: auto;
        }
        .task-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .task-badge.Quiz {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .task-badge.Assignment {
            background-color: #e0f2fe;
            color: #0369a1;
        }
        .task-badge.LabTask {
            background-color: #dcfce7;
            color: #166534;
        }
        @media (max-width: 768px) {
            .desktop-table {
                display: none;
            }
            .course-card {
                display: block;
            }
        }
        @media (min-width: 769px) {
            .desktop-table {
                display: block;
            }
            .course-card {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('DATACELL.partials.nav')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Task Limits Management</h2>

        <div class="mb-6 p-4 bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Add New Task Limit</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Session Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Session</label>
                    <select id="session-dropdown" class="border rounded-lg p-2 w-full" onchange="loadCoursesBySession()">
                        <option value="">Select Session</option>
                    </select>
                </div>

                <!-- Course Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Course</label>
                    <select id="course-dropdown" class="border rounded-lg p-2 w-full" disabled>
                        <option value="">Select Course</option>
                    </select>
                </div>

                <!-- Add Button -->
                <div class="flex items-end">
                    <button onclick="openAddModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg w-full">
                        Add Task Limit
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Details Section -->
        <div id="course-details-container" class="hidden">
            <h3 class="text-xl font-semibold text-gray-700 mb-3">Course Task Limits</h3>
            
            <!-- Desktop Table View -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden desktop-table mb-6">
                <div class="table-container">
                    <table class="course-table min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Course Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Course Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Credit Hours</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Lab Course</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Task Limits</th>
                            </tr>
                        </thead>
                        <tbody id="course-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Courses will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div id="course-card-container">
                <!-- Course cards will be loaded here -->
            </div>
        </div>

        <!-- No Data Message -->
        <div id="no-data" class="p-4 text-center text-gray-500 hidden">
            No task limits found. Select a session to view courses.
        </div>

        <!-- Loader -->
        <div id="loader" class="loader"></div>
    </div>

    <!-- Add Task Limit Modal -->
    <div id="add-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Add Task Limit</h3>
                <button onclick="closeModal('add-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Session</label>
                <input type="text" id="modal-session" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Course</label>
                <input type="text" id="modal-course" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Task Type</label>
                <select id="task-type" class="border rounded-lg p-2 w-full">
                    <option value="">Select Task Type</option>
                    <option value="Quiz">Quiz</option>
                    <option value="Assignment">Assignment</option>
                    <option value="LabTask">Lab Task</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Task Limit</label>
                <input type="number" id="task-limit" class="border rounded-lg p-2 w-full" placeholder="Enter task limit" min="1">
            </div>
            <input type="hidden" id="offered-course-id">
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('add-modal')" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="addTaskLimit()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add</button>
            </div>
            <div id="add-loader" class="loader"></div>
            <div id="add-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <!-- Edit Task Limit Modal -->
    <div id="edit-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Task Limit</h3>
                <button onclick="closeModal('edit-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Task Type</label>
                <input type="text" id="edit-task-type" class="border rounded-lg p-2 w-full" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">Task Limit</label>
                <input type="number" id="edit-task-limit" class="border rounded-lg p-2 w-full" placeholder="Enter task limit" min="1">
            </div>
            <input type="hidden" id="edit-task-id">
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('edit-modal')" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="updateTaskLimit()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
            </div>
            <div id="edit-loader" class="loader"></div>
            <div id="edit-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Confirm Deletion</h3>
                <button onclick="closeModal('delete-modal')" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            <div class="mb-4">
                <p>Are you sure you want to delete this task limit?</p>
                <p class="font-semibold mt-2" id="delete-task-info"></p>
            </div>
            <input type="hidden" id="delete-task-id">
            <div class="flex justify-end space-x-2">
                <button onclick="closeModal('delete-modal')" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="confirmDeleteTaskLimit()" class="bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
            </div>
            <div id="delete-loader" class="loader"></div>
            <div id="delete-message" class="mt-2 text-sm hidden"></div>
        </div>
    </div>

    <script>
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
         const programId = "{{ session('program_id') }}";
        let allSessions = [];
        let allCourses = [];
        let groupedCourses = {};
        let currentSelectedSession = '';
        let currentSelectedCourseId = '';

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
                document.getElementById('loader').style.display = 'block';
                document.getElementById('no-data').classList.add('hidden');
                document.getElementById('course-details-container').classList.add('hidden');
                
                API_BASE_URL = await getApiBaseUrl();
                
                // Load sessions and courses
                const [sessionsResponse, coursesResponse] = await Promise.all([
                    fetch(`${API_BASE_URL}api/Dropdown/Program/AllOfferedCourse/${programId}`),
                    fetch(`${API_BASE_URL}api/Insertion/AllLimitRecord/${programId}`)
                ]);
                
                const sessionsData = await sessionsResponse.json();
                const coursesData = await coursesResponse.json();
                
                if (sessionsData && Array.isArray(sessionsData)) {
                    allSessions = sessionsData;
                    populateSessionDropdown();
                    
                    // Restore selected session if exists
                    if (currentSelectedSession) {
                        document.getElementById('session-dropdown').value = currentSelectedSession;
                        loadCoursesBySession();
                        
                        // Restore selected course if exists
                        if (currentSelectedCourseId) {
                            setTimeout(() => {
                                document.getElementById('course-dropdown').value = currentSelectedCourseId;
                                loadCourseDetails(currentSelectedSession);
                            }, 100);
                        }
                    }
                }
                
                if (coursesData.status && coursesData.data) {
                    groupedCourses = coursesData.data;
                }
            } catch (error) {
                console.error("Error loading initial data:", error);
                showAlert('error', 'Failed to load initial data. Please try again.');
            } finally {
                document.getElementById('loader').style.display = 'none';
            }
        }

        function populateSessionDropdown() {
            const sessionDropdown = document.getElementById('session-dropdown');
            sessionDropdown.innerHTML = '<option value="">Select Session</option>';
            
            // Extract unique sessions
            const uniqueSessions = [...new Set(allSessions.map(item => item.session))];
            
            uniqueSessions.forEach(session => {
                const option = document.createElement('option');
                option.value = session;
                option.textContent = session;
                sessionDropdown.appendChild(option);
            });
        }

        function loadCoursesBySession() {
            const sessionDropdown = document.getElementById('session-dropdown');
            const courseDropdown = document.getElementById('course-dropdown');
            currentSelectedSession = sessionDropdown.value;
            
            courseDropdown.innerHTML = '<option value="">Select Course</option>';
            courseDropdown.disabled = true;
            
            if (!currentSelectedSession) {
                document.getElementById('course-details-container').classList.add('hidden');
                document.getElementById('no-data').classList.remove('hidden');
                return;
            }
            
            // Filter courses for selected session
            const sessionCourses = allSessions.filter(item => item.session === currentSelectedSession);
            
            if (sessionCourses.length > 0) {
                courseDropdown.disabled = false;
                sessionCourses.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course.id;
                    option.textContent = course.course;
                    option.dataset.courseName = course.course;
                    courseDropdown.appendChild(option);
                });
                
                // Load course details for the selected session
                loadCourseDetails(currentSelectedSession);
            } else {
                document.getElementById('course-details-container').classList.add('hidden');
                document.getElementById('no-data').classList.remove('hidden');
            }
        }

        function loadCourseDetails(sessionKey) {
            const courseDetailsContainer = document.getElementById('course-details-container');
            const noDataMessage = document.getElementById('no-data');
            
            if (groupedCourses[sessionKey]) {
                renderCourses(groupedCourses[sessionKey]);
                courseDetailsContainer.classList.remove('hidden');
                noDataMessage.classList.add('hidden');
            } else {
                courseDetailsContainer.classList.add('hidden');
                noDataMessage.classList.remove('hidden');
            }
        }

        function renderCourses(courses) {
            const tableBody = document.getElementById('course-table-body');
            const cardContainer = document.getElementById('course-card-container');
            tableBody.innerHTML = '';
            cardContainer.innerHTML = '';

            courses.forEach(course => {
                // Create task limits display
                const taskLimits = course.task_limits.map(limit => {
                    return `
                        <span class="task-badge ${limit.task_type}">
                            ${limit.task_type}: ${limit.task_limit}
                            <span class="ml-2 cursor-pointer" onclick="openEditModal(${limit.id}, '${limit.task_type}', ${limit.task_limit})">✏️</span>
                            <span class="ml-1 cursor-pointer" onclick="openDeleteModal(${limit.id}, '${limit.task_type}')">🗑️</span>
                        </span>
                    `;
                }).join('') || '<span class="text-gray-500">No task limits set</span>';

                // Add row to desktop table
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${course.code}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${course.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${course.credit_hours}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${course.lab}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">${taskLimits}</td>
                `;
                tableBody.appendChild(row);
                
                // Add card for mobile view
                const card = document.createElement('div');
                card.className = 'course-card';
                card.innerHTML = `
                    <div class="mb-3">
                        <div class="font-medium text-gray-900">${course.code} - ${course.name}</div>
                        <div class="text-sm text-gray-500">Credit Hours: ${course.credit_hours} | Lab: ${course.lab}</div>
                    </div>
                    <div class="field">
                        <span class="field-label">Task Limits:</span>
                        <span class="field-value">
                            <div class="flex flex-wrap">${taskLimits}</div>
                        </span>
                    </div>
                `;
                cardContainer.appendChild(card);
            });
        }

        function openAddModal() {
            const sessionDropdown = document.getElementById('session-dropdown');
            const courseDropdown = document.getElementById('course-dropdown');
            const selectedSession = sessionDropdown.value;
            currentSelectedCourseId = courseDropdown.value;
            const selectedCourseName = courseDropdown.options[courseDropdown.selectedIndex]?.dataset.courseName || '';
            
            if (!selectedSession || !currentSelectedCourseId) {
                showAlert('error', 'Please select both session and course');
                return;
            }
            
            document.getElementById('modal-session').value = selectedSession;
            document.getElementById('modal-course').value = selectedCourseName;
            document.getElementById('offered-course-id').value = currentSelectedCourseId;
            document.getElementById('task-type').value = '';
            document.getElementById('task-limit').value = '';
            document.getElementById('add-message').classList.add('hidden');
            document.getElementById('add-modal').style.display = 'flex';
        }

        function openEditModal(taskId, taskType, taskLimit) {
            document.getElementById('edit-task-id').value = taskId;
            document.getElementById('edit-task-type').value = taskType;
            document.getElementById('edit-task-limit').value = taskLimit;
            document.getElementById('edit-message').classList.add('hidden');
            document.getElementById('edit-modal').style.display = 'flex';
        }

        function openDeleteModal(taskId, taskType) {
            document.getElementById('delete-task-id').value = taskId;
            document.getElementById('delete-task-info').textContent = `Task Type: ${taskType}`;
            document.getElementById('delete-message').classList.add('hidden');
            document.getElementById('delete-modal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        async function addTaskLimit() {
            const offeredCourseId = document.getElementById('offered-course-id').value;
            const taskType = document.getElementById('task-type').value;
            const taskLimit = document.getElementById('task-limit').value.trim();
            
            if (!taskType) {
                showMessage('add-message', 'Please select a task type', 'error');
                return;
            }
            
            if (!taskLimit || isNaN(taskLimit) || parseInt(taskLimit) < 1) {
                showMessage('add-message', 'Please enter a valid task limit (minimum 1)', 'error');
                return;
            }
            
            try {
                document.getElementById('add-loader').style.display = 'block';
                document.getElementById('add-message').classList.add('hidden');
               
                const response = await fetch(`${API_BASE_URL}api/Insertion/insert-task-limit`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                   
                    body: JSON.stringify({
                        offered_course_id: offeredCourseId,
                        task_type: taskType,
                        task_limit: parseInt(taskLimit)
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showMessage('add-message', 'Task limit added successfully!', 'success');
                    // Reload the data while preserving filters
                    setTimeout(() => {
                        closeModal('add-modal');
                        loadInitialData();
                    }, 1500);
                } else {
                    showMessage('add-message', data.error || 'Failed to add task limit', 'error');
                }
            } catch (error) {
                console.error('Error adding task limit:', error);
                showMessage('add-message', 'An error occurred while adding task limit', 'error');
            } finally {
                document.getElementById('add-loader').style.display = 'none';
            }
        }

        async function updateTaskLimit() {
            const taskId = document.getElementById('edit-task-id').value;
            const taskLimit = document.getElementById('edit-task-limit').value.trim();
            
            if (!taskLimit || isNaN(taskLimit) || parseInt(taskLimit) < 1) {
                showMessage('edit-message', 'Please enter a valid task limit (minimum 1)', 'error');
                return;
            }
            
            try {
                document.getElementById('edit-loader').style.display = 'block';
                document.getElementById('edit-message').classList.add('hidden');
                
                const response = await fetch(`${API_BASE_URL}api/Insertion/edit-task-limit`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: taskId,
                        task_limit: parseInt(taskLimit)
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showMessage('edit-message', 'Task limit updated successfully!', 'success');
                    // Reload the data while preserving filters
                    setTimeout(() => {
                        closeModal('edit-modal');
                        loadInitialData();
                    }, 1500);
                } else {
                    showMessage('edit-message', data.error || 'Failed to update task limit', 'error');
                }
            } catch (error) {
                console.error('Error updating task limit:', error);
                showMessage('edit-message', 'An error occurred while updating task limit', 'error');
            } finally {
                document.getElementById('edit-loader').style.display = 'none';
            }
        }

        async function confirmDeleteTaskLimit() {
            const taskId = document.getElementById('delete-task-id').value;
            
            try {
                document.getElementById('delete-loader').style.display = 'block';
                document.getElementById('delete-message').classList.add('hidden');
                
                const response = await fetch(`${API_BASE_URL}api/Insertion/delete-task-limit`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: taskId
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showMessage('delete-message', 'Task limit deleted successfully!', 'success');
                    // Reload the data while preserving filters
                    setTimeout(() => {
                        closeModal('delete-modal');
                        loadInitialData();
                    }, 1500);
                } else {
                    showMessage('delete-message', data.error || 'Failed to delete task limit', 'error');
                }
            } catch (error) {
                console.error('Error deleting task limit:', error);
                showMessage('delete-message', 'An error occurred while deleting task limit', 'error');
            } finally {
                document.getElementById('delete-loader').style.display = 'none';
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

        document.addEventListener("DOMContentLoaded", loadInitialData);
    </script>
    @include('components.footer')
</body>
</html>