<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Allocation</title>
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

        /* Course card styles */
        .course-card {
            transition: all 0.3s ease;
            border-left: 4px solid #3b82f6;
        }

        .course-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Allocation card styles */
        .allocation-card {
            border-left: 3px solid #10b981;
        }

        .junior-card {
            border-left: 3px solid #f59e0b;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .filter-container {
                flex-direction: column;
                gap: 1rem;
            }

            .filter-container select,
            .filter-container input {
                width: 100%;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
</head>

<body class="bg-gray-50">

    @include('HOD.partials.profile_panel')

    <div class="flex flex-1 overflow-hidden">

        <div class="flex-1 overflow-auto">
            <div class="container mx-auto px-4 py-6">
                <!-- Screen Title -->
                <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-6">Teacher Allocation Management
                </h2>

                <!-- Toast Notifications Container -->
                <div id="toast-container" class="fixed top-4 right-4 space-y-2 z-50 w-full max-w-xs"></div>

                <!-- Loading Overlay -->
                <div id="loading-overlay"
                    class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-lg p-6 shadow-lg flex items-center space-x-4">
                        <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 001 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-gray-700 font-medium">Loading...</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 mb-6">
                    <button id="upload-excel-btn"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition flex items-center">
                        📤 Upload Teacher Allocation (Excel)
                    </button>
                    <button id="upload-junior-excel-btn"
                        class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 transition flex items-center">
                        📤 Upload Junior Allocation (Excel)
                    </button>
                </div>

                <!-- Filter Section -->
                <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Allocations</h3>
                    <div class="filter-container flex flex-wrap items-center gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Session</label>
                            <select id="session-filter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Sessions</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                            <select id="course-filter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                disabled>
                                <option value="">All Courses</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                            <select id="section-filter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                disabled>
                                <option value="">All Sections</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teacher</label>
                            <select id="teacher-filter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                disabled>
                                <option value="">All Teachers</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Junior Lecturer</label>
                            <select id="junior-filter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                disabled>
                                <option value="">All Juniors</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status-filter"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All</option>
                                <option value="unallocated">Unallocated Courses</option>
                                <option value="no_junior">Courses without Junior</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button id="reset-filters-btn"
                                class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition flex items-center">
                                🔄 Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Allocations Container -->
                <div id="allocations-container" class="space-y-6">
                    <!-- Allocations will be loaded here -->
                </div>

                <!-- Add Teacher Allocation Modal -->
                <div id="add-teacher-modal"
                    class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">➕ Add Teacher Allocation</h3>
                                <button type="button" class="close-teacher-modal text-gray-400 hover:text-gray-500">
                                    ✖
                                </button>
                            </div>

                            <form id="add-teacher-form" class="space-y-4">
                                <input type="hidden" id="teacher-offered-course-id" name="offered_course_id">

                                <div>
                                    <label for="teacher-section"
                                        class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                                    <select id="teacher-section" name="section_id" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Section</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="teacher-select"
                                        class="block text-sm font-medium text-gray-700 mb-1">Teacher</label>
                                    <select id="teacher-select" name="teacher_id" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Teacher</option>
                                    </select>
                                </div>

                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button"
                                        class="close-teacher-modal inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Update Teacher Allocation Modal -->
                <div id="update-teacher-modal"
                    class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">✏️ Update Teacher Allocation</h3>
                                <button type="button"
                                    class="close-update-teacher-modal text-gray-400 hover:text-gray-500">
                                    ✖
                                </button>
                            </div>

                            <form id="update-teacher-form" class="space-y-4">
                                <input type="hidden" id="update-teacher-offered-course-id"
                                    name="teacher_offered_course_id">

                                <div>
                                    <label for="update-teacher-select"
                                        class="block text-sm font-medium text-gray-700 mb-1">Teacher</label>
                                    <select id="update-teacher-select" name="teacher_id" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Teacher</option>
                                    </select>
                                </div>

                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button"
                                        class="close-update-teacher-modal inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add/Update Junior Allocation Modal -->
                <div id="junior-modal"
                    class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900" id="junior-modal-title">➕ Add Junior
                                    Allocation</h3>
                                <button type="button" class="close-junior-modal text-gray-400 hover:text-gray-500">
                                    ✖
                                </button>
                            </div>

                            <form id="junior-form" class="space-y-4">
                                <input type="hidden" id="junior-teacher-offered-course-id"
                                    name="teacher_offered_course_id">

                                <div>
                                    <label for="junior-select"
                                        class="block text-sm font-medium text-gray-700 mb-1">Junior Lecturer</label>
                                    <select id="junior-select" name="junior_id" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Junior Lecturer</option>
                                    </select>
                                </div>

                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button"
                                        class="close-junior-modal inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Upload Excel Modal -->
                <div id="upload-excel-modal"
                    class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900" id="upload-modal-title">📤 Upload
                                    Teacher Allocation (Excel)</h3>
                                <button type="button" class="close-upload-modal text-gray-400 hover:text-gray-500">
                                    ✖
                                </button>
                            </div>

                            <form id="upload-excel-form" class="space-y-4" enctype="multipart/form-data">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Excel File</label>
                                    <input type="file" id="excel-file" name="excel_file" accept=".xlsx,.xls"
                                        required
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>

                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button"
                                        class="close-upload-modal inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Upload
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
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
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
        const allocationsContainer = document.getElementById('allocations-container');

        // Filter Elements
        const sessionFilter = document.getElementById('session-filter');
        const courseFilter = document.getElementById('course-filter');
        const sectionFilter = document.getElementById('section-filter');
        const teacherFilter = document.getElementById('teacher-filter');
        const juniorFilter = document.getElementById('junior-filter');
        const statusFilter = document.getElementById('status-filter');
        const resetFiltersBtn = document.getElementById('reset-filters-btn');

        // Modal Elements
        const addTeacherModal = document.getElementById('add-teacher-modal');
        const updateTeacherModal = document.getElementById('update-teacher-modal');
        const juniorModal = document.getElementById('junior-modal');
        const uploadExcelModal = document.getElementById('upload-excel-modal');

        // Form Elements
        const addTeacherForm = document.getElementById('add-teacher-form');
        const updateTeacherForm = document.getElementById('update-teacher-form');
        const juniorForm = document.getElementById('junior-form');
        const uploadExcelForm = document.getElementById('upload-excel-form');

        // Button Elements
        const uploadExcelBtn = document.getElementById('upload-excel-btn');
        const uploadJuniorExcelBtn = document.getElementById('upload-junior-excel-btn');

        // Global State
        let allocationData = {};
        let filteredData = {};
        let sections = [];
        let teachers = [];
        let juniors = [];
        let currentFilters = {
            session: '',
            course: '',
            section: '',
            teacher: '',
            junior: '',
            status: ''
        };

        // Initialize the page
        document.addEventListener('DOMContentLoaded', async () => {
            await fetchAllocationData();
            setupEventListeners();
        });

        // Fetch allocation data from API
        async function fetchAllocationData() {
            showLoading();
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Hod/allocation/history/${programId}`);

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                if (!data.status) throw new Error(data.message);

                allocationData = data.data;
                populateSessionDropdown();
                applyFilters();
                showToast('Allocation data loaded successfully', 'success');
            } catch (error) {
                console.error('Error fetching allocation data:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
            }
        }

        // Populate session dropdown
        function populateSessionDropdown() {
            sessionFilter.innerHTML = '<option value="">All Sessions</option>';

            Object.keys(allocationData).forEach(session => {
                const option = document.createElement('option');
                option.value = session;
                option.textContent = session;
                sessionFilter.appendChild(option);
            });
        }

        // Populate course dropdown based on selected session
        function populateCourseDropdown(session) {
            courseFilter.innerHTML = '<option value="">All Courses</option>';
            courseFilter.disabled = true;

            if (!session || !allocationData[session]) return;

            allocationData[session].forEach(course => {
                const option = document.createElement('option');
                option.value = course.course.id;
                option.textContent = `${course.course.code} - ${course.course.name}`;
                option.dataset.lab = course.course.lab;
                courseFilter.appendChild(option);
            });

            courseFilter.disabled = false;
            populateTeacherAndJuniorDropdowns(session);
        }

        // Populate teacher and junior dropdowns based on selected session
        function populateTeacherAndJuniorDropdowns(session) {
            const teacherSet = new Set();
            const juniorSet = new Set();

            allocationData[session].forEach(course => {
                course.teacher_allocations.forEach(allocation => {
                    if (allocation.teacher_name) {
                        teacherSet.add(allocation.teacher_name);
                    }
                    if (allocation.junior_allocation && allocation.junior_allocation.name) {
                        juniorSet.add(allocation.junior_allocation.name);
                    }
                });
            });

            // Populate teacher filter
            teacherFilter.innerHTML = '<option value="">All Teachers</option>';
            Array.from(teacherSet).forEach(teacher => {
                const option = document.createElement('option');
                option.value = teacher;
                option.textContent = teacher;
                teacherFilter.appendChild(option);
            });
            teacherFilter.disabled = false;

            // Populate junior filter
            juniorFilter.innerHTML = '<option value="">All Juniors</option>';
            Array.from(juniorSet).forEach(junior => {
                const option = document.createElement('option');
                option.value = junior;
                option.textContent = junior;
                juniorFilter.appendChild(option);
            });
            juniorFilter.disabled = false;
        }

        // Populate section dropdown
        async function populateSectionDropdown() {
            sectionFilter.innerHTML = '<option value="">All Sections</option>';
            sectionFilter.disabled = true;

            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Dropdown/AllSection`);
                if (!response.ok) throw new Error('Failed to fetch sections');

                const data = await response.json();
                sections = data;

                data.forEach(section => {
                    const option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.data;
                    sectionFilter.appendChild(option);
                });

                sectionFilter.disabled = false;
            } catch (error) {
                console.error('Error fetching sections:', error);
                showToast('Failed to load sections', 'error');
            }
        }

        async function populateTeacherSectionDropdown() {
            const teacherSection = document.getElementById('teacher-section');
            if (!teacherSection) return console.error('teacher-section dropdown not found');

            teacherSection.innerHTML = '<option value="">Select Section</option>';
            teacherSection.disabled = true;

            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Dropdown/AllSection`);
                if (!response.ok) throw new Error('Failed to fetch sections');

                const data = await response.json();

                data.forEach(section => {
                    const option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.data;
                    teacherSection.appendChild(option);
                });

                teacherSection.disabled = false;
            } catch (error) {
                console.error('Error fetching teacher-section options:', error);
                showToast('Failed to load sections', 'error');
            }
        }

        // Fetch teachers for dropdown
        async function fetchTeachers() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Dropdown/get-teachers`);
                if (!response.ok) throw new Error('Failed to fetch teachers');

                const data = await response.json();
                teachers = data;

                const teacherSelect = document.getElementById('teacher-select');
                const updateTeacherSelect = document.getElementById('update-teacher-select');

                teacherSelect.innerHTML = '<option value="">Select Teacher</option>';
                updateTeacherSelect.innerHTML = '<option value="">Select Teacher</option>';

                data.forEach(teacher => {
                    const option = document.createElement('option');
                    option.value = teacher.id;
                    option.textContent = teacher.name;

                    const updateOption = option.cloneNode(true);
                    teacherSelect.appendChild(option);
                    updateTeacherSelect.appendChild(updateOption);
                });
            } catch (error) {
                console.error('Error fetching teachers:', error);
                showToast('Failed to load teachers', 'error');
            }
        }

        // Fetch juniors for dropdown
        async function fetchJuniors() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Dropdown/get-juniors`);
                if (!response.ok) throw new Error('Failed to fetch juniors');

                const data = await response.json();
                juniors = data;

                const juniorSelect = document.getElementById('junior-select');
                juniorSelect.innerHTML = '<option value="">Select Junior Lecturer</option>';

                data.forEach(junior => {
                    const option = document.createElement('option');
                    option.value = junior.id;
                    option.textContent = junior.name;
                    juniorSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error fetching juniors:', error);
                showToast('Failed to load junior lecturers', 'error');
            }
        }

        // Apply filters to the data
        function applyFilters() {
            filteredData = {};

            // Filter by session
            const sessionFilterValue = currentFilters.session;
            const sessionsToShow = sessionFilterValue ? {
                    [sessionFilterValue]: allocationData[sessionFilterValue]
                } :
                allocationData;

            // Filter by course, section, teacher, junior, and status
            Object.keys(sessionsToShow).forEach(session => {
                filteredData[session] = sessionsToShow[session].filter(course => {
                    // Filter by course
                    if (currentFilters.course && course.course.id != currentFilters.course) {
                        return false;
                    }

                    // Filter by section
                    if (currentFilters.section) {
                        const hasSection = course.teacher_allocations.some(allocation =>
                            allocation.section_id == currentFilters.section
                        );
                        if (!hasSection) return false;
                    }

                    // Filter by teacher
                    if (currentFilters.teacher) {
                        const hasTeacher = course.teacher_allocations.some(allocation =>
                            allocation.teacher_name === currentFilters.teacher
                        );
                        if (!hasTeacher) return false;
                    }

                    // Filter by junior
                    if (currentFilters.junior) {
                        const hasJunior = course.teacher_allocations.some(allocation =>
                            allocation.junior_allocation &&
                            allocation.junior_allocation.name === currentFilters.junior
                        );
                        if (!hasJunior) return false;
                    }

                    // Filter by status
                    if (currentFilters.status === 'unallocated') {
                        return course.teacher_allocations.length === 0;
                    } else if (currentFilters.status === 'no_junior') {
                        return course.course.lab === 1 &&
                            course.teacher_allocations.some(allocation =>
                                !allocation.junior_allocation
                            );
                    }

                    return true;
                });
            });

            renderAllocations();
        }

        // Render allocations based on filtered data
        function renderAllocations() {
            allocationsContainer.innerHTML = '';

            if (Object.keys(filteredData).length === 0) {
                allocationsContainer.innerHTML = `
                    <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                        No allocation data found matching your filters
                    </div>
                `;
                return;
            }

            Object.keys(filteredData).forEach(session => {
                const sessionDiv = document.createElement('div');
                sessionDiv.className = 'space-y-4';

                const sessionHeader = document.createElement('div');
                sessionHeader.className = 'bg-blue-100 rounded-lg p-4';
                sessionHeader.innerHTML = `
                    <h3 class="text-lg font-semibold text-blue-800">📅 ${session}</h3>
                `;

                const coursesContainer = document.createElement('div');
                coursesContainer.className = 'space-y-4 pl-4';

                filteredData[session].forEach(course => {
                    const courseDiv = document.createElement('div');
                    courseDiv.className = 'course-card bg-white rounded-lg shadow-md p-4';

                    // Course header with add button if no allocations
                    const courseHeader = document.createElement('div');
                    courseHeader.className = 'flex justify-between items-center mb-4';

                    const courseInfo = document.createElement('div');
                    courseInfo.innerHTML = `
                        <h4 class="font-medium text-gray-900">${course.course.code} - ${course.course.name}</h4>
                        <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                            <span>👥 Enrollment: ${course.enrollment_count}</span>
                            <span>${course.course.lab ? '🧪 Lab Course' : '📚 Theory Course'}</span>
                        </div>
                    `;

                    const addButton = document.createElement('button');
                    addButton.className =
                        'bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 transition text-sm flex items-center';
                    addButton.innerHTML = '➕ Add Allocation';
                    addButton.onclick = () => openAddTeacherModal(course.course.id);

                    courseHeader.appendChild(courseInfo);
                    courseHeader.appendChild(addButton);
                    courseDiv.appendChild(courseHeader);

                    // Render allocations
                    if (course.teacher_allocations.length > 0) {
                        const allocationsList = document.createElement('div');
                        allocationsList.className = 'space-y-3';

                        course.teacher_allocations.forEach(allocation => {
                            const allocationDiv = document.createElement('div');
                            allocationDiv.className =
                                'allocation-card bg-white rounded-lg border border-gray-200 p-4';

                            // Teacher info
                            const teacherInfo = document.createElement('div');
                            teacherInfo.className = 'flex justify-between items-start';

                            const teacherDetails = document.createElement('div');
                            teacherDetails.className = 'flex items-center space-x-3';

                            // Teacher image or placeholder
                            const teacherImage = document.createElement('div');
                            teacherImage.className =
                                'flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden';

                            if (allocation.teacher_image) {
                                teacherImage.innerHTML =
                                    `<img src="${allocation.teacher_image}" alt="${allocation.teacher_name}" class="h-full w-full object-cover">`;
                            } else {
                                teacherImage.innerHTML = '👨‍🏫';
                            }

                            const teacherText = document.createElement('div');
                            teacherText.innerHTML = `
                                <p class="font-medium text-gray-900">${allocation.teacher_name}</p>
                                <p class="text-sm text-gray-600">📌 ${allocation.section_name} (👥 ${allocation.enrollment_in_section})</p>
                            `;

                            teacherDetails.appendChild(teacherImage);
                            teacherDetails.appendChild(teacherText);

                            // Teacher actions
                            const teacherActions = document.createElement('div');
                            teacherActions.className = 'flex space-x-2';






                            const encodedData = btoa(JSON.stringify(
                                allocation)); // Encode allocation object in Base64
                            const viewDetailsUrl =
                                `{{ route('hod.allocation.details', parameters: ['allocation' => '__PLACEHOLDER__']) }}`
                                .replace('__PLACEHOLDER__', encodedData);

                            const viewDetailsBtn = document.createElement('a');
                            viewDetailsBtn.href = viewDetailsUrl;
                            viewDetailsBtn.className =
                                'bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm flex items-center';
                            viewDetailsBtn.innerHTML = 'View Details';





                            const editTeacherBtn = document.createElement('button');
                            editTeacherBtn.className =
                                'text-blue-600 hover:text-blue-800 text-sm flex items-center';
                            editTeacherBtn.innerHTML = '✏️ Edit';
                            editTeacherBtn.onclick = () => openUpdateTeacherModal(allocation.id,
                                allocation.teacher_name);

                            teacherActions.appendChild(editTeacherBtn);
                            teacherActions.appendChild(viewDetailsBtn);

                            teacherInfo.appendChild(teacherDetails);
                            teacherInfo.appendChild(teacherActions);

                            allocationDiv.appendChild(teacherInfo);

                            // Junior allocation if lab course
                            if (course.course.lab === 1) {
                                const juniorDiv = document.createElement('div');
                                juniorDiv.className =
                                    'junior-card mt-3 bg-gray-50 rounded-lg border border-gray-200 p-3 ml-8';

                                if (allocation.junior_allocation) {
                                    const juniorInfo = document.createElement('div');
                                    juniorInfo.className = 'flex justify-between items-start';

                                    const juniorDetails = document.createElement('div');
                                    juniorDetails.className = 'flex items-center space-x-3';

                                    const juniorImage = document.createElement('div');
                                    juniorImage.className =
                                        'flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden';

                                    if (allocation.junior_allocation.image) {
                                        juniorImage.innerHTML =
                                            `<img src="${allocation.junior_allocation.image}" alt="${allocation.junior_allocation.name}" class="h-full w-full object-cover">`;
                                    } else {
                                        juniorImage.innerHTML = '👩‍🏫';
                                    }

                                    const juniorText = document.createElement('div');
                                    juniorText.innerHTML = `
                                        <p class="text-sm font-medium text-gray-900">${allocation.junior_allocation.name}</p>
                                        <p class="text-xs text-gray-600">Junior Lecturer</p>
                                    `;

                                    juniorDetails.appendChild(juniorImage);
                                    juniorDetails.appendChild(juniorText);

                                    const juniorActions = document.createElement('div');
                                    juniorActions.className = 'flex space-x-2';

                                    const editJuniorBtn = document.createElement('button');
                                    editJuniorBtn.className =
                                        'text-yellow-600 hover:text-yellow-800 text-xs flex items-center';
                                    editJuniorBtn.innerHTML = '✏️ Edit';
                                    editJuniorBtn.onclick = () => openJuniorModal(allocation.id,
                                        allocation.junior_allocation.name, true);

                                    juniorActions.appendChild(editJuniorBtn);

                                    juniorInfo.appendChild(juniorDetails);
                                    juniorInfo.appendChild(juniorActions);

                                    juniorDiv.appendChild(juniorInfo);
                                } else {
                                    const addJuniorBtn = document.createElement('button');
                                    addJuniorBtn.className =
                                        'text-yellow-600 hover:text-yellow-800 text-sm flex items-center';
                                    addJuniorBtn.innerHTML = '➕ Add Junior Allocation';
                                    addJuniorBtn.onclick = () => openJuniorModal(allocation.id,
                                        null, false);

                                    juniorDiv.appendChild(addJuniorBtn);
                                }

                                allocationDiv.appendChild(juniorDiv);
                            }

                            allocationsList.appendChild(allocationDiv);
                        });

                        courseDiv.appendChild(allocationsList);
                    }

                    coursesContainer.appendChild(courseDiv);
                });

                sessionDiv.appendChild(sessionHeader);
                sessionDiv.appendChild(coursesContainer);
                allocationsContainer.appendChild(sessionDiv);
            });
        }

        // Open add teacher modal
        async function openAddTeacherModal(offeredCourseId) {
            showLoading();
            try {
                // Fetch sections and teachers if not already loaded
                if (sections.length === 0) await populateTeacherSectionDropdown();
                if (teachers.length === 0) await fetchTeachers();

                document.getElementById('teacher-offered-course-id').value = offeredCourseId;

                // Reset form
                document.getElementById('teacher-section').value = '';
                document.getElementById('teacher-select').value = '';

                addTeacherModal.classList.remove('hidden');
            } catch (error) {
                console.error('Error opening add teacher modal:', error);
                showToast('Failed to prepare form', 'error');
            } finally {
                hideLoading();
            }
        }

        // Open update teacher modal
        async function openUpdateTeacherModal(teacherOfferedCourseId, currentTeacherName) {
            showLoading();
            try {
                if (teachers.length === 0) await fetchTeachers();

                document.getElementById('update-teacher-offered-course-id').value = teacherOfferedCourseId;

                // Set current teacher as selected
                const updateTeacherSelect = document.getElementById('update-teacher-select');
                updateTeacherSelect.value = '';

                // Try to find the current teacher in the dropdown
                for (let i = 0; i < updateTeacherSelect.options.length; i++) {
                    if (updateTeacherSelect.options[i].text === currentTeacherName) {
                        updateTeacherSelect.value = updateTeacherSelect.options[i].value;
                        break;
                    }
                }

                updateTeacherModal.classList.remove('hidden');
            } catch (error) {
                console.error('Error opening update teacher modal:', error);
                showToast('Failed to prepare form', 'error');
            } finally {
                hideLoading();
            }
        }

        // Open junior modal (for add or update)
        async function openJuniorModal(teacherOfferedCourseId, currentJuniorName, isUpdate) {
            showLoading();
            try {
                if (juniors.length === 0) await fetchJuniors();

                document.getElementById('junior-teacher-offered-course-id').value = teacherOfferedCourseId;

                // Set modal title based on action
                document.getElementById('junior-modal-title').textContent =
                    isUpdate ? '✏️ Update Junior Allocation' : '➕ Add Junior Allocation';

                // Reset or set current junior
                const juniorSelect = document.getElementById('junior-select');
                juniorSelect.value = '';

                if (isUpdate && currentJuniorName) {
                    // Try to find the current junior in the dropdown
                    for (let i = 0; i < juniorSelect.options.length; i++) {
                        if (juniorSelect.options[i].text === currentJuniorName) {
                            juniorSelect.value = juniorSelect.options[i].value;
                            break;
                        }
                    }
                }

                juniorModal.classList.remove('hidden');
            } catch (error) {
                console.error('Error opening junior modal:', error);
                showToast('Failed to prepare form', 'error');
            } finally {
                hideLoading();
            }
        }

        // Open upload excel modal
        function openUploadExcelModal(isJunior = false) {
            document.getElementById('upload-modal-title').textContent =
                isJunior ? '📤 Upload Junior Allocation (Excel)' : '📤 Upload Teacher Allocation (Excel)';
            document.getElementById('excel-file').value = '';
            uploadExcelModal.classList.remove('hidden');
        }

        // Handle add teacher form submission
        async function handleAddTeacherForm(e) {
            e.preventDefault();
            showLoading();

            try {
                const formData = new FormData(addTeacherForm);

                const payload = {
                    offered_course_id: formData.get('offered_course_id'),
                    teacher_id: formData.get('teacher_id'),
                    section_id: formData.get('section_id')
                };
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Hod/allocation/add`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to add teacher allocation');
                }

                showToast(data.message || 'Teacher allocation added successfully', 'success');
                await fetchAllocationData();
                addTeacherModal.classList.add('hidden');
            } catch (error) {
                console.error('Error adding teacher allocation:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
            }
        }

        // Handle update teacher form submission
        async function handleUpdateTeacherForm(e) {
            e.preventDefault();
            showLoading();

            try {
                const formData = new FormData(updateTeacherForm);
                const payload = {
                    teacher_offered_course_id: formData.get('teacher_offered_course_id'),
                    teacher_id: formData.get('teacher_id')
                };
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Hod/allocation/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to update teacher allocation');
                }

                showToast(data.message || 'Teacher allocation updated successfully', 'success');
                await fetchAllocationData();
                updateTeacherModal.classList.add('hidden');
            } catch (error) {
                console.error('Error updating teacher allocation:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
            }
        }

        // Handle junior form submission
        async function handleJuniorForm(e) {
            e.preventDefault();
            showLoading();

            try {
                const formData = new FormData(juniorForm);
                const payload = {
                    teacher_offered_course_id: formData.get('teacher_offered_course_id'),
                    junior_id: formData.get('junior_id')
                };
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Hod/allocation/junior/add_update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to update junior allocation');
                }

                showToast(data.message || 'Junior allocation updated successfully', 'success');
                await fetchAllocationData();
                juniorModal.classList.add('hidden');
            } catch (error) {
                console.error('Error updating junior allocation:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
            }
        }

        // Handle upload excel form submission
        async function handleUploadExcelForm(e) {
            e.preventDefault();
            showLoading();

            try {
                const formData = new FormData(uploadExcelForm);
                const isJunior = document.getElementById('upload-modal-title').textContent.includes('Junior');
                const endpoint = isJunior ? 'junior/upload' : 'upload';
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Hod/allocation/${endpoint}`, {
                    method: 'POST',
                    body: formData,
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to upload Excel file');
                }

                showToast(data.message || 'Excel file uploaded successfully', 'success');
                await fetchAllocationData();
                uploadExcelModal.classList.add('hidden');
            } catch (error) {
                console.error('Error uploading Excel file:', error);
                showToast(`Error: ${error.message}`, 'error');
            } finally {
                hideLoading();
            }
        }

        // Setup event listeners
        function setupEventListeners() {
            // Session filter change
            sessionFilter.addEventListener('change', (e) => {
                currentFilters.session = e.target.value;
                populateCourseDropdown(currentFilters.session);
                applyFilters();
            });

            // Course filter change
            courseFilter.addEventListener('change', (e) => {
                currentFilters.course = e.target.value;
                applyFilters();
            });

            // Section filter change
            sectionFilter.addEventListener('change', (e) => {
                currentFilters.section = e.target.value;
                applyFilters();
            });

            // Teacher filter change
            teacherFilter.addEventListener('change', (e) => {
                currentFilters.teacher = e.target.value;
                applyFilters();
            });

            // Junior filter change
            juniorFilter.addEventListener('change', (e) => {
                currentFilters.junior = e.target.value;
                applyFilters();
            });

            // Status filter change
            statusFilter.addEventListener('change', (e) => {
                currentFilters.status = e.target.value;
                applyFilters();
            });

            // Reset filters button
            resetFiltersBtn.addEventListener('click', () => {
                sessionFilter.value = '';
                courseFilter.value = '';
                sectionFilter.value = '';
                teacherFilter.value = '';
                juniorFilter.value = '';
                statusFilter.value = '';

                currentFilters = {
                    session: '',
                    course: '',
                    section: '',
                    teacher: '',
                    junior: '',
                    status: ''
                };

                courseFilter.disabled = true;
                sectionFilter.disabled = true;
                teacherFilter.disabled = true;
                juniorFilter.disabled = true;
                applyFilters();
            });

            // Upload Excel buttons
            uploadExcelBtn.addEventListener('click', () => openTeacherAllocationExcel());
            uploadJuniorExcelBtn.addEventListener('click', () => openJuniorAllocationExcel());

            function openTeacherAllocationExcel() {
                const url = "{{ route('hod.courses.add_teacher_allocation') }}";
                window.location.href = url;
            }

            function openJuniorAllocationExcel() {
                const url = "{{ route('hod.courses.add_junior_allocation') }}";
                window.location.href = url;
            }
            // Modal close buttons
            document.querySelector('.close-teacher-modal').addEventListener('click', () => {
                addTeacherModal.classList.add('hidden');
            });

            document.querySelector('.close-update-teacher-modal').addEventListener('click', () => {
                updateTeacherModal.classList.add('hidden');
            });

            document.querySelector('.close-junior-modal').addEventListener('click', () => {
                juniorModal.classList.add('hidden');
            });

            document.querySelector('.close-upload-modal').addEventListener('click', () => {
                uploadExcelModal.classList.add('hidden');
            });

            // Form submissions
            addTeacherForm.addEventListener('submit', handleAddTeacherForm);
            updateTeacherForm.addEventListener('submit', handleUpdateTeacherForm);
            juniorForm.addEventListener('submit', handleJuniorForm);
            uploadExcelForm.addEventListener('submit', handleUploadExcelForm);
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
                            ✖
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
                'info': 'ℹ️',
                'success': '✅',
                'warning': '⚠️',
                'error': '❌'
            };
            return icons[type] || icons['info'];
        }
    </script>
</body>

</html>
