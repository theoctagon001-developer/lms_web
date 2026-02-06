<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Management</title>
    @vite('resources/css/app.css')
    <style>
        /* Base styles */
        body {
            font-family: 'Inter', sans-serif;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .toast {
            animation: slide-in 0.3s ease-out;
        }

        .toast.fade-out {
            opacity: 0;
            transform: translateX(1rem);
            transition: opacity 0.3s ease-in, transform 0.3s ease-in;
        }

        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateX(1rem);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Exam card styles */
        .exam-card {
            transition: all 0.3s ease;
            border-left: 4px solid;
        }

        .exam-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .mid-exam {
            border-left-color: #3b82f6;
        }

        .final-exam {
            border-left-color: #10b981;
        }

        .no-exam {
            border-left-color: #6b7280;
        }

        /* Question table styles */
        .question-table {
            width: 100%;
            border-collapse: collapse;
        }

        .question-table th, .question-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .question-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
        }

        .question-table tr:last-child td {
            border-bottom: none;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .exam-grid {
                grid-template-columns: 1fr;
            }
            
            .filter-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .filter-container select {
                width: 100%;
            }
            
            .question-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    
        @include('HOD.partials.profile_panel')
    
    <div class="flex flex-1 overflow-hidden">
        <div class="flex-1 overflow-auto">
            <div class="container mx-auto px-4 py-6">
                <!-- Screen Title -->
                <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-6">Exam Management</h2>

                <!-- Toast Notifications Container -->
                <div id="toast-container" class="fixed top-4 right-4 space-y-2 z-50 w-full max-w-xs"></div>

                <!-- Loading Overlay -->
                <div id="loading-overlay"
                    class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-lg p-6 shadow-lg flex items-center space-x-4">
                        <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 001 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-gray-700 font-medium">Loading...</span>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                    <div class="filter-container flex flex-wrap items-center gap-4 mb-4">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Session</label>
                            <select id="session-select" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Session</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                            <select id="course-select" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" disabled>
                                <option value="">Select Course</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button id="refresh-btn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Course Info Section -->
                <div id="course-info-container" class="bg-white rounded-lg shadow-md p-4 mb-6 hidden">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Course Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Course Name</p>
                            <p id="course-name" class="font-medium text-gray-900"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Course Code</p>
                            <p id="course-code" class="font-medium text-gray-900"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Lab</p>
                            <p id="course-lab" class="font-medium text-gray-900"></p>
                        </div>
                    </div>
                </div>

                <!-- Exams Section -->
                <div id="exams-container" class="grid grid-cols-1 md:grid-cols-2 gap-6 exam-grid">
                    <!-- Exams will be loaded here -->
                </div>

                <!-- Edit Exam Modal -->
                <div id="edit-exam-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Update Exam</h3>
                                <button type="button" class="close-exam-modal text-gray-400 hover:text-gray-500">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <form id="edit-exam-form" class="space-y-4">
                                <input type="hidden" id="edit-exam-id" name="exam_id">
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Exam Type</label>
                                        <input type="text" id="edit-exam-type" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Marks</label>
                                        <input type="text" id="edit-exam-total-marks" class="w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                                    </div>
                                </div>

                                <div>
                                    <label for="edit-exam-solid-marks" class="block text-sm font-medium text-gray-700 mb-1">Solid Marks</label>
                                    <input type="number" id="edit-exam-solid-marks" name="Solid_marks" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Question Paper</label>
                                    <div id="current-question-paper" class="mb-2">
                                        <a href="#" target="_blank" class="text-blue-600 hover:underline flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span id="current-question-paper-name">Current Question Paper</span>
                                        </a>
                                    </div>
                                    <input type="file" id="edit-exam-question-paper" name="QuestionPaper" accept=".pdf"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>

                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <label class="block text-sm font-medium text-gray-700">Questions</label>
                                        <button type="button" id="add-question-btn" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Add Question
                                        </button>
                                    </div>
                                    
                                    <div id="questions-container" class="space-y-3">
                                        <!-- Questions will be added here -->
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button" class="close-exam-modal inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // API Configuration
        let API_BASE_URL = "http://127.0.0.1:8000/";
         const programId = "{{ session('program_id') }}";
         async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }
        // DOM Elements
        const loadingOverlay = document.getElementById('loading-overlay');
        const toastContainer = document.getElementById('toast-container');
        const sessionSelect = document.getElementById('session-select');
        const courseSelect = document.getElementById('course-select');
        const refreshBtn = document.getElementById('refresh-btn');
        const courseInfoContainer = document.getElementById('course-info-container');
        const examsContainer = document.getElementById('exams-container');
        const editExamModal = document.getElementById('edit-exam-modal');
        const editExamForm = document.getElementById('edit-exam-form');
        const questionsContainer = document.getElementById('questions-container');
        const addQuestionBtn = document.getElementById('add-question-btn');

        // Global State
        let examData = null;
        let currentCourse = null;

        // Initialize the page
        document.addEventListener('DOMContentLoaded', async () => {
            await fetchExamData();
            setupEventListeners();
        });

        // Fetch exam data from API
        async function fetchExamData() {
            API_BASE_URL = await getApiBaseUrl();
            showLoading();
            try {
                const response = await fetch(`${API_BASE_URL}api/Hod/exam/all/${programId}`);
                
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                if (!data.status) throw new Error(data.message);

                examData = data.data;
                populateSessionDropdown();
                showToast('Exam data loaded successfully', 'success');
            } catch (error) {
                console.error('Error fetching exam data:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
            }
        }

        // Populate session dropdown
        function populateSessionDropdown() {
            sessionSelect.innerHTML = '<option value="">Select Session</option>';
            
            examData.forEach(session => {
                const option = document.createElement('option');
                option.value = session.session_id;
                option.textContent = session.session_name;
                sessionSelect.appendChild(option);
            });
        }

        // Populate course dropdown based on selected session
        function populateCourseDropdown(sessionId) {
            courseSelect.innerHTML = '<option value="">Select Course</option>';
            courseSelect.disabled = true;
            
            const selectedSession = examData.find(s => s.session_id == sessionId);
            if (!selectedSession) return;

            selectedSession.courses.forEach(course => {
                const option = document.createElement('option');
                option.value = course.offered_course_id;
                option.textContent = `${course.course_code} - ${course.course_name}`;
                option.dataset.course = JSON.stringify(course);
                courseSelect.appendChild(option);
            });
            
            courseSelect.disabled = false;
        }

        // Display course information
        function displayCourseInfo(course) {
            currentCourse = course;
            
            document.getElementById('course-name').textContent = course.course_name;
            document.getElementById('course-code').textContent = course.course_code;
            document.getElementById('course-lab').textContent = course.lab;
            
            courseInfoContainer.classList.remove('hidden');
            renderExams();
        }

        // Render exams for the selected course
        function renderExams() {
            examsContainer.innerHTML = '';
            
            if (!currentCourse) return;

            // Mid Term Exam Card
            const midExamCard = createExamCard('Mid Term', currentCourse.Mid);
            examsContainer.appendChild(midExamCard);

            // Final Term Exam Card
            const finalExamCard = createExamCard('Final Term', currentCourse.Final);
            examsContainer.appendChild(finalExamCard);
        }

        // Create exam card
        function createExamCard(type, examData) {
            const card = document.createElement('div');
            card.className = `exam-card bg-white rounded-lg shadow-md p-4 ${type.toLowerCase().includes('mid') ? 'mid-exam' : 'final-exam'} ${!examData ? 'no-exam' : ''}`;
            
            const title = document.createElement('h3');
            title.className = 'text-lg font-semibold text-gray-800 mb-2';
            title.textContent = type;
            
            const content = document.createElement('div');
            
            if (examData) {
                // Exam exists
                const totalMarks = document.createElement('p');
                totalMarks.className = 'text-sm text-gray-600 mb-1';
                totalMarks.innerHTML = `<span class="font-medium">Total Marks:</span> ${examData.total_marks}`;
                
                const solidMarks = document.createElement('p');
                solidMarks.className = 'text-sm text-gray-600 mb-3';
                solidMarks.innerHTML = `<span class="font-medium">Solid Marks:</span> ${examData.Solid_marks}`;
                
                const questionPaper = document.createElement('div');
                questionPaper.className = 'mb-3';
                const paperLink = document.createElement('a');
                paperLink.href = examData.QuestionPaper;
                paperLink.target = '_blank';
                paperLink.className = 'text-blue-600 hover:underline flex items-center';
                paperLink.innerHTML = `
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Question Paper
                `;
                questionPaper.appendChild(paperLink);
                
                const questionsTable = document.createElement('div');
                questionsTable.className = 'mb-4';
                questionsTable.innerHTML = `
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Question Breakdown</h4>
                    <table class="question-table">
                        <thead>
                            <tr>
                                <th>Q#</th>
                                <th>Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${examData.questions.map(q => `
                                <tr>
                                    <td>${q.q_no}</td>
                                    <td>${q.marks}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                `;
                
                const updateBtn = document.createElement('button');
                updateBtn.className = 'mt-3 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition';
                updateBtn.textContent = 'Update Exam';
                updateBtn.onclick = () => openEditExamModal(examData);
                
                content.appendChild(totalMarks);
                content.appendChild(solidMarks);
                content.appendChild(questionPaper);
                content.appendChild(questionsTable);
                content.appendChild(updateBtn);
            } else {
                // No exam
                const noExamText = document.createElement('p');
                noExamText.className = 'text-sm text-gray-600 mb-3';
                noExamText.textContent = 'No exam created yet';
                
                const createBtn = document.createElement('a');
                createBtn.href = `/hod/exam/create?offered_course_id=${currentCourse.offered_course_id}&type=${type.toLowerCase().includes('mid') ? 'mid' : 'final'}&course_name=${currentCourse.course_name}`;
                createBtn.className = 'mt-3 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition';
                createBtn.textContent = 'Create Exam';
                
                content.appendChild(noExamText);
                content.appendChild(createBtn);
            }
            
            card.appendChild(title);
            card.appendChild(content);
            
            return card;
        }

        // Open edit exam modal
        function openEditExamModal(exam) {
            document.getElementById('edit-exam-id').value = exam.exam_id;
            document.getElementById('edit-exam-type').value = exam.type;
            document.getElementById('edit-exam-total-marks').value = exam.total_marks;
            document.getElementById('edit-exam-solid-marks').value = exam.Solid_marks;
            
            const paperLink = document.getElementById('current-question-paper').querySelector('a');
            paperLink.href = exam.QuestionPaper;
            document.getElementById('current-question-paper-name').textContent = exam.QuestionPaper.split('/').pop();
            
            // Clear and populate questions
            questionsContainer.innerHTML = '';
            exam.questions.forEach((q, index) => {
                addQuestionToForm(q.q_no, q.marks, index);
            });
            
            editExamModal.classList.remove('hidden');
        }

        // Add question to form
        function addQuestionToForm(qNo, marks, index) {
            const questionDiv = document.createElement('div');
            questionDiv.className = 'flex items-center space-x-3';
            questionDiv.innerHTML = `
                <div class="flex-1">
                    <label class="block text-xs text-gray-500 mb-1">Question No</label>
                    <input type="number" name="questions[${index}][q_no]" value="${qNo}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="flex-1">
                    <label class="block text-xs text-gray-500 mb-1">Marks</label>
                    <input type="number" name="questions[${index}][marks]" value="${marks}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <button type="button" class="remove-question-btn text-red-600 hover:text-red-800 mt-5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            `;
            
            questionsContainer.appendChild(questionDiv);
            
            // Add event listener to remove button
            questionDiv.querySelector('.remove-question-btn').addEventListener('click', () => {
                if (questionsContainer.children.length > 1 || confirm('This is the last question. Remove it?')) {
                    questionDiv.remove();
                }
            });
        }

        // Handle exam form submission
        async function handleExamFormSubmit(e) {
            e.preventDefault();
            showLoading();
            
            try {
                const formData = new FormData(editExamForm);
                
                // Validate at least one question exists
                const questionInputs = document.querySelectorAll('input[name^="questions["]');
                if (questionInputs.length === 0) {
                    throw new Error('At least one question is required');
                }
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Hod/exam/update`, {
                    method: 'POST',
                    body: formData,
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.error||data.error|| 'Failed to update exam');
                }
                
                showToast(data.message || 'Exam updated successfully', 'success');
                await fetchExamData();
                
                // Refresh the current course display if it's the same course
                if (currentCourse) {
                    const selectedSession = examData.find(s => 
                        s.courses.some(c => c.offered_course_id == currentCourse.offered_course_id)
                    );
                    
                    if (selectedSession) {
                        const updatedCourse = selectedSession.courses.find(
                            c => c.offered_course_id == currentCourse.offered_course_id
                        );
                        
                        if (updatedCourse) {
                            displayCourseInfo(updatedCourse);
                        }
                    }
                }
                
                editExamModal.classList.add('hidden');
            } catch (error) {
                console.error('Error updating exam:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
            }
        }

        // Setup event listeners
        function setupEventListeners() {
            // Session dropdown change
            sessionSelect.addEventListener('change', (e) => {
                const sessionId = e.target.value;
                if (sessionId) {
                    populateCourseDropdown(sessionId);
                    courseInfoContainer.classList.add('hidden');
                    examsContainer.innerHTML = '';
                }
            });
            
            // Course dropdown change
            courseSelect.addEventListener('change', (e) => {
                const selectedOption = e.target.selectedOptions[0];
                if (selectedOption.value) {
                    const course = JSON.parse(selectedOption.dataset.course);
                    displayCourseInfo(course);
                } else {
                    courseInfoContainer.classList.add('hidden');
                    examsContainer.innerHTML = '';
                }
            });
            
            // Refresh button
            refreshBtn.addEventListener('click', async () => {
                await fetchExamData();
                
                // Reset selections
                sessionSelect.value = '';
                courseSelect.innerHTML = '<option value="">Select Course</option>';
                courseSelect.disabled = true;
                courseInfoContainer.classList.add('hidden');
                examsContainer.innerHTML = '';
            });
            
            // Add question button
            addQuestionBtn.addEventListener('click', () => {
                const nextIndex = questionsContainer.children.length;
                addQuestionToForm(nextIndex + 1, 0, nextIndex);
            });
            
            // Close modal button
            document.querySelector('.close-exam-modal').addEventListener('click', () => {
                editExamModal.classList.add('hidden');
            });
            
            // Form submission
            editExamForm.addEventListener('submit', handleExamFormSubmit);
        }

        // Show loading overlay
        function showLoading() {
            loadingOverlay.classList.remove('hidden');
        }

        // Hide loading overlay
        function hideLoading() {
            loadingOverlay.classList.add('hidden');
        }

        // Show toast notification
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast rounded-md p-4 shadow-lg transform transition-all duration-300 ease-in-out ${getToastClasses(type)}`;
            toast.style.animation = 'slide-in 0.3s ease-out';
            toast.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        ${getToastIcon(type)}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">${message}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button type="button" class="toast-close-button">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('fade-out');
                setTimeout(() => toast.remove(), 300);
            }, 5000);

            toast.querySelector('.toast-close-button').addEventListener('click', () => {
                toast.remove();
            });
        }

        // Get toast classes based on type
        function getToastClasses(type) {
            const classes = {
                'info': 'bg-blue-50 text-blue-800',
                'success': 'bg-green-50 text-green-800',
                'warning': 'bg-yellow-50 text-yellow-800',
                'error': 'bg-red-50 text-red-800'
            };
            return classes[type] || classes['info'];
        }

        // Get toast icon based on type
        function getToastIcon(type) {
            const icons = {
                'info': `
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                    </svg>
                `,
                'success': `
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                `,
                'warning': `
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                `,
                'error': `
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                `
            };
            return icons[type] || icons['info'];
        }
    </script>
</body>
</html>