<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Content</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .topic-input-container {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .topic-input-container input {
            flex: 1;
        }

        .remove-topic-btn {
            color: #ef4444;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .add-another-topic {
            color: #3b82f6;
            cursor: pointer;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: inline-flex;
            align-items: center;
        }

        .add-another-topic svg {
            margin-right: 0.25rem;
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

        /* Responsive styles */
        @media (max-width: 768px) {
            .flex.justify-center {
                flex-direction: column;
                align-items: center;
            }

            .flex.justify-center label {
                margin-bottom: 0.5rem;
            }

            .flex.justify-center select {
                width: 100%;
                max-width: 300px;
            }

            .action-buttons {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .action-buttons button {
                flex: 1 1 100%;
            }

            #copy-content-btn {
                order: 1;
            }

            .file-actions {
                flex-direction: column;
                gap: 0.5rem;
            }

            .file-actions a,
            .file-actions button {
                width: 100%;
                text-align: center;
            }
        }

        /* Topic container styling */
        .topics-container {
            margin-top: 1rem;
            padding: 0.75rem;
            background-color: #f9fafb;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
        }

        .topic-item {
            display: inline-block;
            margin: 0.25rem;
            padding: 0.25rem 0.5rem;
            background-color: #e5e7eb;
            border-radius: 9999px;
            font-size: 0.875rem;
        }

        /* Screen title */
        .screen-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #1f2937;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 0.5rem;
        }
    </style>
</head>
<body class="bg-blue-50">
   
        @include('HOD.partials.profile_panel')
    
    <div class="flex flex-1 overflow-hidden">
       
        <div class="flex-1 overflow-auto">
            <div class="container mx-auto px-4 py-6">
                <!-- Screen Title -->
                <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Course Content</h2>

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
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-gray-700 font-medium">Loading content...</span>
                    </div>
                </div>

                <!-- Add Topic Modal -->
                <div id="add-topic-modal"
                    class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Add Topics</h3>
                                <button type="button" class="close-topic-modal text-gray-400 hover:text-gray-500">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div id="topic-content-info" class="mb-4 p-3 bg-gray-50 rounded-md">
                                <!-- Content info will be populated here -->
                            </div>

                            <form id="add-topic-form">
                                <input type="hidden" id="content-id" name="coursecontent_id">

                                <div id="topics-container">
                                    <div class="topic-input-container">
                                        <input type="text" name="topics[]" required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Enter topic name">
                                        <button type="button" class="remove-topic-btn hidden">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <button type="button" id="add-another-topic" class="add-another-topic">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add another topic
                                </button>

                                <div class="flex justify-end space-x-3 mt-4">
                                    <button type="button"
                                        class="close-topic-modal inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Save Topics
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Main Content Container -->
                <div id="course-content-container" class="relative animate-fade-in">
                    <!-- Content will be loaded here dynamically -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // API Configuration
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

        // Add event listener for the add question button in edit modal
        document.addEventListener('click', (e) => {
            if (e.target && e.target.id === 'add-mcq-btn' && e.target.closest('#edit-content-form')) {
                const container = document.getElementById('mcqs-edit-container');
                const questionCount = container.querySelectorAll('.mcq-question').length;

                const questionDiv = document.createElement('div');
                questionDiv.className = 'mcq-question border rounded-lg p-3';
                questionDiv.innerHTML = `
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-medium">Question ${questionCount + 1}</h4>
                <button type="button" class="remove-mcq-btn text-red-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
            
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Question Text</label>
                <input type="text" name="MCQS[${questionCount}][question_text]" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Points</label>
                <input type="number" name="MCQS[${questionCount}][points]" required min="1" value="1"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">Options (Mark the correct answer)</label>
                <div class="space-y-2">
                    ${['option1', 'option2', 'option3', 'option4'].map((opt, idx) => `
                                                                                            <div class="option-container">
                                                                                                <input type="radio" name="MCQS[${questionCount}][Answer]" value="${opt}" ${idx === 0 ? 'checked' : ''}
                                                                                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 mr-2">
                                                                                                <input type="text" name="MCQS[${questionCount}][${opt}]" required
                                                                                                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                                                                    placeholder="Option ${idx + 1}">
                                                                                            </div>
                                                                                        `).join('')}
                </div>
            </div>
            <input type="hidden" name="MCQS[${questionCount}][qNO]" value="${questionCount + 1}">
        `;

                container.appendChild(questionDiv);

                // Add event listener to remove button
                questionDiv.querySelector('.remove-mcq-btn').addEventListener('click', () => {
                    if (container.querySelectorAll('.mcq-question').length > 1 || confirm(
                            'This is the last question. Remove it?')) {
                        container.removeChild(questionDiv);
                        // Renumber remaining questions
                        Array.from(container.querySelectorAll('.mcq-question')).forEach((question,
                            index) => {
                            question.querySelector('h4').textContent = `Question ${index + 1}`;
                            // Update all input names to maintain sequential numbering
                            updateQuestionInputNames(question, index);
                        });
                    }
                });
            }

            // Handle remove question buttons in edit modal
            if (e.target && e.target.classList.contains('remove-mcq-btn') && e.target.closest(
                    '#edit-content-form')) {
                const questionDiv = e.target.closest('.mcq-question');
                const container = document.getElementById('mcqs-edit-container');

                if (container.querySelectorAll('.mcq-question').length > 1 || confirm(
                        'This is the last question. Remove it?')) {
                    container.removeChild(questionDiv);
                    // Renumber remaining questions
                    Array.from(container.querySelectorAll('.mcq-question')).forEach((question, index) => {
                        question.querySelector('h4').textContent = `Question ${index + 1}`;
                        // Update all input names to maintain sequential numbering
                        updateQuestionInputNames(question, index);
                    });
                }
            }
        });

        // Helper function to update question input names when renumbering
        function updateQuestionInputNames(questionDiv, newIndex) {
            // Update question number
            questionDiv.querySelector('input[name$="[qNO]"]').value = newIndex + 1;

            // Update all input names
            const inputs = questionDiv.querySelectorAll('input');
            inputs.forEach(input => {
                const name = input.name;
                if (name.startsWith('MCQS[')) {
                    input.name = name.replace(/MCQS\[\d+\]/, `MCQS[${newIndex}]`);
                }
            });
        }
        // DOM Elements
        const loadingOverlay = document.getElementById('loading-overlay');
        const contentContainer = document.getElementById('course-content-container');
        const toastContainer = document.getElementById('toast-container');
        const addTopicModal = document.getElementById('add-topic-modal');
        const topicContentInfo = document.getElementById('topic-content-info');
        const addTopicForm = document.getElementById('add-topic-form');
        const topicNameInput = document.getElementById('topic-name');

        // Global State
        let contentData = null;
        let filteredContent = null;
        let currentSession = null;
        let currentCourse = null;
        let currentWeek = null;
        let showOnlyNotes = false;
        let currentContentForTopic = null;

        // Initialize the page
        document.addEventListener('DOMContentLoaded', async () => {
            await fetchContent();
            renderContent();

            // Setup modal event listeners
            document.querySelectorAll('.close-topic-modal').forEach(btn => {
                btn.addEventListener('click', () => {
                    addTopicModal.classList.add('hidden');
                });
            });

            addTopicForm.addEventListener('submit', handleAddTopicSubmit);
        });

        // Fetch content from API
        async function fetchContent() {
            showLoading();
            try {
                API_BASE_URL = await getApiBaseUrl();
                const CONTENT_API_URL = `${API_BASE_URL}api/Hod/content`;
                const response = await fetch(CONTENT_API_URL);

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                if (!data.status) throw new Error(data.message);

                contentData = data.data;
                filteredContent = data.data;
                currentSession = Object.keys(data.data)[0];
                currentCourse = Object.keys(data.data[currentSession])[0];

                showToast('Content loaded successfully', 'success');
            } catch (error) {
                console.error('Error fetching content:', error);
                showToast(`Error: ${error.message}`, 'error');
                contentContainer.innerHTML = `
            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">Failed to load content. Please try refreshing the page.</p>
                    </div>
                </div>
            </div>
        `;
            } finally {
                hideLoading();
            }
        }

        function renderContent() {
            if (!contentData) return;

            const sessionOptions = Object.keys(filteredContent).map(session =>
                `<option value="${session}" ${currentSession === session ? 'selected' : ''}>${session}</option>`
            ).join('');

            const currentSessionCourses = filteredContent[currentSession] || {};
            const courseOptions = Object.keys(currentSessionCourses).map(course =>
                `<option value="${course}" ${currentCourse === course ? 'selected' : ''}>${course}</option>`
            ).join('');

            const currentCourseWeeks = currentSessionCourses[currentCourse] || {};
            const weekOptions = ['<option value="all">All Weeks</option>'].concat(
                Object.keys(currentCourseWeeks).map(week =>
                    `<option value="${week}" ${currentWeek === week ? 'selected' : ''}>Week ${week}</option>`
                )
            ).join('');

            const contentToDisplay = getFilteredContent();
            const contentHtml = contentToDisplay.length > 0 ?
                renderContentItems(contentToDisplay) :
                '<div class="p-4 text-gray-500">No content found matching your criteria</div>';

            contentContainer.innerHTML = `
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <div class="flex items-center space-x-4 action-buttons">
                    <button id="refresh-btn" class="bg-blue-100 text-blue-600 px-4 py-2 rounded-md hover:bg-blue-200 transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Refresh
                    </button>
                    <button id="add-content-btn" class="bg-green-100 text-green-600 px-4 py-2 rounded-md hover:bg-green-200 transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Content
                    </button>
                    <button id="copy-content-btn" class="bg-purple-100 text-purple-600 px-4 py-2 rounded-md hover:bg-purple-200 transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Copy Content
                    </button>
                    <button id="upload-topic-excel-btn" class="bg-indigo-100 text-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-200 transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg> Upload Topic Excel
                    </button>
                </div>
                
                <div class="flex items-center space-x-2">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" id="notes-filter" class="rounded text-blue-600" ${showOnlyNotes ? 'checked' : ''}>
                        <span class="text-sm text-gray-600">Show Only Notes</span>
                    </label>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Session</label>
                    <select id="session-select" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        ${sessionOptions}
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                    <select id="course-select" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        ${courseOptions}
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Week</label>
                    <select id="week-select" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        ${weekOptions}
                    </select>
                </div>
            </div>
            
            <div class="space-y-4" id="content-items-container">
                ${contentHtml}
            </div>
        </div>
    `;

            // Setup event listeners
            document.getElementById('refresh-btn').addEventListener('click', handleRefresh);
            document.getElementById('add-content-btn').addEventListener('click', handleAddContent);
            document.getElementById('copy-content-btn').addEventListener('click', handleCopyContent);
            document.getElementById('upload-topic-excel-btn').addEventListener('click', handleUploadTopicExcel);
            document.getElementById('session-select').addEventListener('change', (e) => handleSessionChange(e.target
                .value));
            document.getElementById('course-select').addEventListener('change', (e) => handleCourseChange(e.target.value));
            document.getElementById('week-select').addEventListener('change', (e) => handleWeekChange(e.target.value));
            document.getElementById('notes-filter').addEventListener('change', (e) => toggleNotesFilter(e.target.checked));

            // Add event delegation for dynamic elements
            document.getElementById('content-items-container').addEventListener('click', (e) => {
                if (e.target.classList.contains('edit-btn')) {
                    e.stopPropagation();
                    handleEditClick(e.target.dataset.id);
                }
                if (e.target.classList.contains('view-mcqs-btn')) {
                    e.stopPropagation();
                    toggleMCQSView(e.target);
                }
                if (e.target.classList.contains('view-topics-btn')) {
                    e.stopPropagation();
                    toggleTopicsView(e.target);
                }
                if (e.target.classList.contains('add-topic-btn')) {
                    e.stopPropagation();
                    handleAddTopicClick(e.target.dataset.id);
                }
                if (e.target.classList.contains('download-btn')) {
                    e.stopPropagation();
                    handleDownload(e.target.dataset.url);
                }
            });
        }
        let copyurl1 = "{{ route('hod.courses.add_topic') }}";

        function handleUploadTopicExcel() {
           
            window.location.href = copyurl1;
        }
       
        function getFilteredContent() {
            let content = [];
            const sessionData = filteredContent[currentSession] || {};
            const courseData = sessionData[currentCourse] || {};

            if (currentWeek && currentWeek !== 'all') {
                content = courseData[currentWeek] || [];
            } else {
                content = Object.values(courseData).flat();
            }

            if (showOnlyNotes) {
                content = content.filter(item => item.type === 'Notes');
            }

            return content;
        }

        function renderContentItems(items) {
            return items.map(item => `
        <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition" data-id="${item.course_content_id}">
            <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                <div>
                    <h3 class="font-medium text-gray-900">${item.title}</h3>
                    <div class="flex items-center space-x-2 mt-1">
                        <span class="px-2 py-1 text-xs rounded-full ${getTypeBadgeColor(item.type)}">
                            ${item.type}
                        </span>
                        ${item.week ? `<span class="text-xs text-gray-500">Week ${item.week}</span>` : ''}
                    </div>
                </div>
                <button class="edit-btn bg-blue-100 text-blue-600 px-3 py-1 rounded-md text-sm hover:bg-blue-200 transition" data-id="${item.course_content_id}">
                    Edit
                </button>
            </div>
            
            <div class="p-4">
                ${renderContentDetails(item)}
                
                <div class="mt-4 flex justify-between items-center">
                    ${item.File ? `
                                                                                                <div class="flex space-x-2 file-actions">
                                                                                                    <a href="${item.File}" target="_blank" class="text-sm text-blue-600 hover:underline flex items-center view-file-btn">
                                                                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                                                        </svg>
                                                                                                        View File
                                                                                                    </a>
                                                                                                    <button class="download-btn text-sm text-green-600 hover:underline flex items-center" data-url="${item.File}">
                                                                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                                                        </svg>
                                                                                                        Download
                                                                                                    </button>
                                                                                                </div>
                                                                                            ` : '<div></div>'}
                    
                    ${item.type === 'Notes' ? `
                                                                                                <div class="flex space-x-2">
                                                                                                    <button class="view-topics-btn text-sm text-purple-600 hover:underline flex items-center">
                                                                                                        ${item.topics && item.topics.length > 0 ? 'View Topics' : 'No Topics'}
                                                                                                    </button>
                                                                                                    <button class="add-topic-btn text-sm text-indigo-600 hover:underline flex items-center" data-id="${item.course_content_id}">
                                                                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                                                                        </svg>
                                                                                                        Add Topic
                                                                                                    </button>
                                                                                                </div>
                                                                                            ` : ''}
                </div>
                
                ${item.type === 'Notes' && item.topics && item.topics.length > 0 ? `
                                                                                            <div class="topics-container hidden">
                                                                                                <div class="text-sm text-gray-600 mb-1">Topics:</div>
                                                                                                <div class="flex flex-wrap gap-2">
                                                                                                    ${item.topics.map(topic => `
                                <span class="topic-item">${topic.topic_name}</span>
                            `).join('')}
                                                                                                </div>
                                                                                            </div>
                                                                                        ` : ''}
                
                ${item.type === 'MCQS' && item.MCQS && item.MCQS.length > 0 ? `
                                                                                            <div class="mt-4">
                                                                                                <button class="view-mcqs-btn text-sm text-blue-600 hover:underline flex items-center">
                                                                                                    View MCQS (${item.MCQS.length})
                                                                                                </button>
                                                                                                <div class="mcqs-container hidden mt-2">
                                                                                                    ${item.MCQS.map((mcq, index) => `
                                <div class="mb-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div class="font-medium">Q${index + 1}: ${mcq.Question}</div>
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">${mcq.Points} pts</span>
                                    </div>
                                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-2">
                                        ${['Option 1', 'Option 2', 'Option 3', 'Option 4'].map(opt => `
                                                                                                                    <div class="flex items-center">
                                                                                                                        <input type="radio" disabled ${mcq.Answer === mcq[opt] ? 'checked' : ''} 
                                                                                                                            class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                                                                                                        <label class="text-sm text-gray-700">${mcq[opt]}</label>
                                                                                                                    </div>
                                                                                                                `).join('')}
                                    </div>
                                </div>
                            `).join('')}
                                                                                                </div>
                                                                                            </div>
                                                                                        ` : ''}
            </div>
        </div>
    `).join('');
        }

        function renderContentDetails(item) {
            switch (item.type) {
                case 'Notes':
                    return `
                <div class="text-sm text-gray-600">
                    ${item.File ? 'Lecture notes available' : 'No file attached'}
                </div>
            `;
                case 'MCQS':
                    return `
                <div class="text-sm text-gray-600">
                    ${item.MCQS ? `${item.MCQS.length} questions` : 'No questions available'}
                </div>
            `;
                case 'Quiz':
                case 'Assignment':
                case 'LabTask':
                    return `
                <div class="text-sm text-gray-600">
                    ${item.File ? 'Document available' : 'No document attached'}
                </div>
            `;
                default:
                    return '<div class="text-sm text-gray-600">Content details</div>';
            }
        }

        function getTypeBadgeColor(type) {
            const colors = {
                'Notes': 'bg-blue-100 text-blue-800',
                'MCQS': 'bg-green-100 text-green-800',
                'Quiz': 'bg-purple-100 text-purple-800',
                'Assignment': 'bg-yellow-100 text-yellow-800',
                'LabTask': 'bg-indigo-100 text-indigo-800'
            };
            return colors[type] || 'bg-gray-100 text-gray-800';
        }

        async function handleRefresh() {
            await fetchContent();
            renderContent();
        }
        const addContentUrl = "{{ route('hod.courses.add_content') }}";

        function handleAddContent() {
            window.location.href = addContentUrl;
        }
        let copyurl = "{{ route('hod.courses.copy_content') }}";

        function handleCopyContent() {
            // // Implementation for copying content
            // console.log('Copy content clicked');
            // showToast('Copy content functionality will be implemented here', 'info');
            window.location.href = copyurl;
        }

        function handleSessionChange(session) {
            currentSession = session;
            currentCourse = Object.keys(filteredContent[session])[0];
            currentWeek = null;
            renderContent();
        }

        function handleCourseChange(course) {
            currentCourse = course;
            currentWeek = null;
            renderContent();
        }

        function handleWeekChange(week) {
            currentWeek = week === 'all' ? null : week;
            renderContent();
        }

        function toggleNotesFilter(checked) {
            showOnlyNotes = checked;
            renderContent();
        }

        function handleEditClick(contentId) {
            const content = findContentById(contentId);
            if (!content) return;

            showEditModal(content);
        }

        function findContentById(id) {
            for (const session in filteredContent) {
                for (const course in filteredContent[session]) {
                    for (const week in filteredContent[session][course]) {
                        const items = filteredContent[session][course][week];
                        const found = items.find(item => item.course_content_id == id);
                        if (found) return found;
                    }
                }
            }
            return null;
        }

        function toggleMCQSView(button) {
            const mcqsContainer = button.closest('.border').querySelector('.mcqs-container');
            mcqsContainer.classList.toggle('hidden');
            button.textContent = mcqsContainer.classList.contains('hidden') ?
                `View MCQS (${button.textContent.match(/\d+/)?.[0] || ''})` :
                'Hide MCQS';
        }

        function toggleTopicsView(button) {
            const topicsContainer = button.closest('.border').querySelector('.topics-container');
            topicsContainer.classList.toggle('hidden');
            button.textContent = topicsContainer.classList.contains('hidden') ?
                'View Topics' :
                'Hide Topics';
        }

        function handleAddTopicClick(contentId) {
            const content = findContentById(contentId);
            if (!content) return;

            currentContentForTopic = content;

            // Populate the content info in the modal
            topicContentInfo.innerHTML = `
        <div class="text-sm text-gray-700">
            <div class="font-medium">${content.title}</div>
            <div class="flex items-center space-x-2 mt-1">
                <span class="px-2 py-1 text-xs rounded-full ${getTypeBadgeColor(content.type)}">
                    ${content.type}
                </span>
                ${content.week ? `<span class="text-xs text-gray-500">Week ${content.week}</span>` : ''}
            </div>
        </div>
    `;

            // Set the content ID in the hidden field
            document.getElementById('content-id').value = content.course_content_id;

            // Reset the topics container
            const topicsContainer = document.getElementById('topics-container');
            topicsContainer.innerHTML = `
        <div class="topic-input-container">
            <input type="text" name="topics[]" required
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Enter topic name">
            <button type="button" class="remove-topic-btn hidden">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
    `;

            // Setup event listeners for the topic inputs
            setupTopicInputListeners();

            // Show the modal
            addTopicModal.classList.remove('hidden');
        }

        function setupTopicInputListeners() {
            // Add another topic button
            document.getElementById('add-another-topic').addEventListener('click', () => {
                const topicsContainer = document.getElementById('topics-container');
                const newTopicDiv = document.createElement('div');
                newTopicDiv.className = 'topic-input-container';
                newTopicDiv.innerHTML = `
            <input type="text" name="topics[]" required
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Enter topic name">
            <button type="button" class="remove-topic-btn">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        `;
                topicsContainer.appendChild(newTopicDiv);

                // Add event listener to the new remove button
                newTopicDiv.querySelector('.remove-topic-btn').addEventListener('click', () => {
                    topicsContainer.removeChild(newTopicDiv);

                    // If only one input remains, hide its remove button
                    const topicInputs = topicsContainer.querySelectorAll('.topic-input-container');
                    if (topicInputs.length === 1) {
                        topicInputs[0].querySelector('.remove-topic-btn').classList.add('hidden');
                    }
                });
            });

            // Show remove button for the first input if there are multiple
            const topicInputs = document.getElementById('topics-container').querySelectorAll('.topic-input-container');
            if (topicInputs.length > 1) {
                topicInputs.forEach(input => {
                    input.querySelector('.remove-topic-btn').classList.remove('hidden');
                });
            }
        }
        async function handleAddTopicSubmit(e) {
            e.preventDefault();

            const contentId = document.getElementById('content-id').value;
            if (!contentId) {
                showToast('Error: No content selected', 'error');
                return;
            }

            // Collect all non-empty topic values
            const topicInputs = document.querySelectorAll('input[name="topics[]"]');
            const topics = Array.from(topicInputs)
                .map(input => input.value.trim())
                .filter(topic => topic !== '');

            if (topics.length === 0) {
                showToast('Please enter at least one topic name', 'warning');
                return;
            }

            showLoading();

            try {
                const response = await fetch(`${API_BASE_URL}api/Hod/link-topics`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        coursecontent_id: contentId,
                        topics: topics
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || data.message || 'Failed to add topics');
                }

                showToast(data.message || 'Topics added successfully', 'success');
                await fetchContent();
                renderContent();
                addTopicModal.classList.add('hidden');
            } catch (error) {
                console.error('Error adding topics:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
            }
        }
        async function addTopicToContent(contentId, topicName) {
            console.log(`Adding topic "${topicName}" to content ID: ${contentId}`);
            // Implement your API call here
            return true; // Return true if successful, false otherwise
        }

        function handleDownload(url) {
            if (!url) {
                showToast('No file available for download', 'warning');
                return;
            }
            window.open(url, '_blank');
        }

        function showLoading() {
            loadingOverlay.classList.remove('hidden');
        }

        function hideLoading() {
            loadingOverlay.classList.add('hidden');
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className =
                `toast rounded-md p-4 shadow-lg transform transition-all duration-300 ease-in-out ${getToastClasses(type)}`;
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

        function getToastClasses(type) {
            const classes = {
                'info': 'bg-blue-50 text-blue-800',
                'success': 'bg-green-50 text-green-800',
                'warning': 'bg-yellow-50 text-yellow-800',
                'error': 'bg-red-50 text-red-800'
            };
            return classes[type] || classes['info'];
        }

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


        function showEditModal(content) {
            const modalHtml = `
        <div class="fixed inset-0 z-50 overflow-y-auto modal-overlay" style="background-color: rgba(0,0,0,0.5)">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Content</h3>
                            <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <form id="edit-content-form" class="mt-4 space-y-4">
                            <input type="hidden" name="content_id" value="${content.course_content_id}">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" value="${content.title || ''}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type</label>
                                <input type="text" value="${content.type}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Week</label>
                                <input type="number" value="${content.week || ''}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                            </div>
                            
                            ${renderEditModalTypeFields(content)}
                            
                            <div class="flex justify-end space-x-3 pt-4">
                                <button type="button" class="close-modal inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
    `;

            const modalElement = document.createElement('div');
            modalElement.innerHTML = modalHtml;
            document.body.appendChild(modalElement);

            // Setup event listeners for the modal
            modalElement.querySelector('.modal-overlay').addEventListener('click', (e) => {
                if (e.target.classList.contains('modal-overlay')) {
                    document.body.removeChild(modalElement);
                }
            });

            modalElement.querySelector('.close-modal').addEventListener('click', () => {
                document.body.removeChild(modalElement);
            });

            modalElement.querySelector('#edit-content-form').addEventListener('submit', async (e) => {
                e.preventDefault();
                showLoading();

                try {
                    const formData = new FormData();
                    const contentId = e.target.querySelector('input[name="content_id"]').value;
                    const contentType = content.type;

                    formData.append('coursecontent_id', contentId);

                    if (contentType === 'MCQS') {
                        // Process MCQS questions
                        const questionDivs = modalElement.querySelectorAll('.mcq-question');
                        const mcqsArray = [];

                        questionDivs.forEach((div, index) => {
                            const questionId = div.dataset.id || `new-${Date.now()}-${index}`;
                            const questionNo = div.querySelector(`input[name="MCQS[${index}][qNO]"]`)
                                .value;
                            const questionText = div.querySelector(
                                `input[name="MCQS[${index}][question_text]"]`).value;
                            const points = div.querySelector(`input[name="MCQS[${index}][points]"]`)
                                .value;
                            const answerRadio = div.querySelector(
                                `input[name="MCQS[${index}][Answer]"]:checked`);

                            if (!answerRadio) {
                                throw new Error(
                                    `Please select the correct answer for Question ${index + 1}`);
                            }
                            const answer = answerRadio.value;

                            const options = {
                                option1: div.querySelector(`input[name="MCQS[${index}][option1]"]`)
                                    .value,
                                option2: div.querySelector(`input[name="MCQS[${index}][option2]"]`)
                                    .value,
                                option3: div.querySelector(`input[name="MCQS[${index}][option3]"]`)
                                    .value,
                                option4: div.querySelector(`input[name="MCQS[${index}][option4]"]`)
                                    .value
                            };

                            // Validate required fields
                            if (!questionText || !points || !options.option1 || !options.option2 || !
                                options.option3 || !options.option4) {
                                throw new Error(`Please fill all fields for Question ${index + 1}`);
                            }

                            mcqsArray.push({
                                ID: questionId,
                                qNO: questionNo,
                                question_text: questionText,
                                points: points,
                                option1: options.option1,
                                option2: options.option2,
                                option3: options.option3,
                                option4: options.option4,
                                Answer: answer
                            });
                        });

                        if (mcqsArray.length === 0) {
                            throw new Error('At least one question is required');
                        }

                        formData.append('MCQS', JSON.stringify(mcqsArray));
                    } else {
                        // For other types, add the file if it exists
                        const fileInput = modalElement.querySelector('input[name="file"]');
                        if (fileInput && fileInput.files.length > 0) {
                            formData.append('file', fileInput.files[0]);
                        } else if (!content.File) {
                            throw new Error('File is required for update');
                        }
                    }

                    // Submit to API
                    const response = await fetch(`${API_BASE_URL}api/Hod/content/update`, {
                        method: 'POST',
                        body: formData,
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || data.message || 'Failed to update content');
                    }

                    showToast(data.message || 'Content updated successfully', 'success');
                    await fetchContent();
                    renderContent();
                    document.body.removeChild(modalElement);
                } catch (error) {
                    console.error('Error updating content:', error);
                    showToast(`Error: ${error.message}`, 'error');
                } finally {
                    hideLoading();
                }
            });
            modalElement.querySelector('#add-mcq-btn')?.addEventListener('click', () => {
                const container = modalElement.querySelector('#mcqs-edit-container');
                const newIndex = container.querySelectorAll('.mcq-question').length;
                container.insertAdjacentHTML('beforeend', renderMCQItem({}, newIndex));
            });

            // Remove question button (using event delegation)
            modalElement.querySelector('#mcqs-edit-container')?.addEventListener('click', (e) => {
                if (e.target.closest('.remove-mcq-btn')) {
                    const questionDiv = e.target.closest('.mcq-question');
                    const container = modalElement.querySelector('#mcqs-edit-container');
                    const questionCount = container.querySelectorAll('.mcq-question').length;

                    if (questionCount > 1 || confirm('This is the last question. Remove it?')) {
                        questionDiv.remove();
                        // Renumber remaining questions
                        container.querySelectorAll('.mcq-question').forEach((div, index) => {
                            div.querySelector('h4').textContent = `Question ${index + 1}`;
                            const questionNoInput = div.querySelector('input[name$="[qNO]"]');
                            if (questionNoInput) questionNoInput.value = index + 1;
                        });
                    }
                }
            });
        }

        function renderEditModalTypeFields(content) {
            switch (content.type) {
                case 'Notes':
                case 'Quiz':
                case 'Assignment':
                case 'LabTask':
                    return `
                <div>
                    <label class="block text-sm font-medium text-gray-700">File</label>
                    <input type="file" name="file" 
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    ${content.File ? `
                                                    <div class="mt-2 text-sm text-gray-600">
                                                        Current file: <a href="${content.File}" target="_blank" class="text-blue-600 hover:underline">${content.File.split('/').pop()}</a>
                                                    </div>
                                                ` : ''}
                </div>
            `;
                case 'MCQS':
                    return `
                <div>
                    <label class="block text-sm font-medium text-gray-700">Questions</label>
                    <div id="mcqs-edit-container" class="mt-2 space-y-4">
                        ${content.MCQS ? content.MCQS.map((mcq, qIndex) => renderMCQItem(mcq, qIndex)).join('') : ''}
                    </div>
                    
                    <button type="button" id="add-mcq-btn" class="add-mcq-btn mt-2 flex items-center text-blue-600 hover:text-blue-800">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add New Question
                    </button>
                </div>
            `;
                default:
                    return '';
            }
        }

        function renderMCQItem(mcq = {}, index) {
            const questionNo = mcq.qNO || (index + 1);
            const questionId = mcq.ID || `new-${Date.now()}-${index}`;
            const questionText = mcq.question_text || mcq.Question || '';
            const points = mcq.points || mcq.Points || 1;

            // Get options - handle both old and new format
            const options = {
                option1: mcq.option1 || mcq['Option 1'] || '',
                option2: mcq.option2 || mcq['Option 2'] || '',
                option3: mcq.option3 || mcq['Option 3'] || '',
                option4: mcq.option4 || mcq['Option 4'] || ''
            };

            // Determine correct answer - handle both old and new format
            let answer = mcq.Answer || '';
            if (!answer && mcq.Answer === undefined) {
                // Try to find answer in options if not explicitly set
                if (mcq['Option 1'] === mcq.Answer) answer = 'option1';
                else if (mcq['Option 2'] === mcq.Answer) answer = 'option2';
                else if (mcq['Option 3'] === mcq.Answer) answer = 'option3';
                else if (mcq['Option 4'] === mcq.Answer) answer = 'option4';
            }

            return `
        <div class="mcq-question border rounded-lg p-3" data-id="${questionId}">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-medium">Question ${questionNo}</h4>
                <button type="button" class="remove-mcq-btn text-red-600 hover:text-red-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Question Text</label>
                <input type="text" name="MCQS[${index}][question_text]" value="${questionText}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Points</label>
                <input type="number" name="MCQS[${index}][points]" value="${points}" required min="1"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">Options (Mark the correct answer)</label>
                <div class="space-y-2">
                    ${['option1', 'option2', 'option3', 'option4'].map((opt, idx) => {
                const optionText = options[opt] || '';
                const isChecked = answer === opt ||
                    (idx === 0 && !answer);
                return `
                                                <div class="option-container flex items-center">
                                                    <input type="radio" name="MCQS[${index}][Answer]" value="${opt}" 
                                                        ${isChecked ? 'checked' : ''}
                                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 mr-2">
                                                    <input type="text" name="MCQS[${index}][${opt}]" value="${optionText}" required
                                                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                        placeholder="Option ${idx + 1}">
                                                </div>
                                            `;
            }).join('')}
                </div>
            </div>
            <input type="hidden" name="MCQS[${index}][qNO]" value="${questionNo}">
            <input type="hidden" name="MCQS[${index}][ID]" value="${questionId}">
        </div>
    `;
        }
    </script>
</body>
</html>
