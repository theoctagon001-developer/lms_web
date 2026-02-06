<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Junior Lecturer List</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --secondary-color: #0ea5e9;
            --accent-color: #8b5cf6;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --light-bg: #f9fafb;
            --card-bg: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #4b5563;
            --text-muted: #9ca3af;
            --border-color: #e5e7eb;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-primary);
            line-height: 1.5;
        }

        .page-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
            padding: 1.5rem;
        }

        /* Header styles */
        .header {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 50;
            padding: 1rem 1.5rem;
            box-shadow: var(--shadow-sm);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-color);
        }

        .logo i {
            font-size: 1.5rem;
        }

        /* Card styles */
        .card {
            background-color: var(--card-bg);
            border-radius: 0.75rem;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--light-bg);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Search box styles */
        .search-container {
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 500px;
        }

        .search-box input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .search-box i {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: var(--transition);
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-secondary {
            background-color: var(--light-bg);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: var(--border-color);
        }

        /* Table styles */
        .table-container {
            overflow-x: auto;
            border-radius: 0.5rem;
            transition: var(--transition);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
        }

        thead {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
        }

        th {
            text-align: left;
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        tbody tr:hover {
            background-color: rgba(79, 70, 229, 0.05);
        }

        .teacher-img {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .teacher-img:hover {
            transform: scale(1.1);
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-primary {
            background-color: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }

        .view-btn {
            padding: 0.5rem 1rem;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            color: white;
            border-radius: 0.375rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            text-decoration: none;
        }

        .view-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Status indicator */
        .search-status {
            margin-bottom: 1rem;
            padding: 0.5rem 1rem;
            background-color: rgba(79, 70, 229, 0.1);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            max-width: max-content;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .empty-state-text {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        /* Loading spinner */
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .spinner {
            width: 2.5rem;
            height: 2.5rem;
            border: 4px solid rgba(79, 70, 229, 0.1);
            border-left-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Mobile responsive styles */
        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin-bottom: 1rem;
                border: 1px solid var(--border-color);
                border-radius: 0.5rem;
                box-shadow: var(--shadow-sm);
                background-color: white;
                overflow: hidden;
            }

            td {
                position: relative;
                padding-left: 50%;
                text-align: left;
                min-height: 45px;
                display: flex;
                align-items: center;
                border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            }

            td:last-child {
                border-bottom: none;
            }

            td:before {
                content: attr(data-label);
                position: absolute;
                left: 1rem;
                width: 45%;
                padding-right: 0.5rem;
                white-space: nowrap;
                font-weight: 600;
                color: var(--text-secondary);
            }

            /* Image cell special styling */
            td:first-child {
                padding: 1rem;
                justify-content: center;
                background-color: var(--light-bg);
            }

            td:first-child:before {
                display: none;
            }

            /* Action buttons styling */
            td:last-child {
                padding: 1rem;
                justify-content: center;
            }

            td:last-child:before {
                display: none;
            }

            .teacher-img {
                width: 4rem;
                height: 4rem;
            }
        }

        /* Theme Toggle Button */
        .theme-toggle {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-lg);
            z-index: 100;
            transition: var(--transition);
        }

        .theme-toggle:hover {
            transform: scale(1.1);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        .page-link {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-weight: 500;
            transition: var(--transition);
            cursor: pointer;
        }

        .page-link.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .page-link:hover:not(.active) {
            background-color: var(--light-bg);
            color: var(--primary-color);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            padding: 1.25rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
        }

        .modal-body {
            padding: 1.25rem;
        }

        .course-tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
        }

        .course-tab {
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: var(--transition);
        }

        .course-tab.active {
            border-bottom-color: var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
        }

        .course-list {
            display: none;
        }

        .course-list.active {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        .course-item {
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            transition: var(--transition);
        }

        .course-item:hover {
            border-color: var(--primary-color);
            box-shadow: var(--shadow-sm);
        }

        .course-name {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .course-details {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .course-detail {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-loading {
            display: flex;
            justify-content: center;
            padding: 2rem;
        }

        .modal-error {
            padding: 2rem;
            text-align: center;
            color: var(--danger-color);
        }

        .footer {
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 1.5rem 0;
            margin-top: 3rem;
        }
         .sticky-top-container {
            background-color: white;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .sticky-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            max-width: 100%;
            margin: 0 auto;
        }

        .sticky-top-bar h1 {
            font-weight: 600;
            color: var(--primary);
            cursor: pointer;
            transition: color 0.2s;
        }

        .sticky-top-bar h1:hover {
            color: var(--primary-dark);
        }
        
        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 1rem;
        }
        
        .footer-copyright {
            color: #6b7280;
            font-size: 0.875rem;
        }

        @media (max-width: 640px) {
            .modal-content {
                width: 95%;
                max-height: 90vh;
            }
            
            .course-tabs {
                flex-direction: column;
                border-bottom: none;
            }
            
            .course-tab {
                border-bottom: none;
                border-left: 2px solid transparent;
            }
            
            .course-tab.active {
                border-bottom: none;
                border-left-color: var(--primary-color);
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="page-container">
        <!-- Header -->
     <div class="sticky-top-container">
    <div class="sticky-top-bar">
        <div class="flex items-center">
            <a href="{{ route('director.dashboard') }}" class="text-xl font-bold text-blue-600">
                Director <span class="hidden sm:inline"></span>
            </a>
        </div>
        @include('DIRECTOR.Profile')
    </div>
</div>
    

        <!-- Mobile Nav -->
      

        <!-- Main Content -->
        <main class="content-wrapper">
            <div class="container mx-auto max-w-6xl">
                <!-- Page Title & Search -->
                <div class="card mb-6">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="fas fa-user-graduate me-2"></i> Junior Lecturer Directory
                        </h2>
                        <a href="{{ route('Director.teachers') }}" class="btn btn-primary">
                            <i class="fas fa-users"></i>
                            <span class="hidden sm:inline">View Senior Teachers</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="search-container">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input 
                                    type="text" 
                                    id="search-input" 
                                    placeholder="Search by name, username, email or CNIC..."
                                    aria-label="Search junior lecturers"
                                >
                            </div>
                            <button onclick="searchTeachers()" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                <span class="hidden sm:inline">Search</span>
                            </button>
                            <button onclick="resetSearch()" class="btn btn-secondary">
                                <i class="fas fa-sync-alt"></i>
                                <span class="hidden sm:inline">Reset</span>
                            </button>
                        </div>
                        <div id="search-status" class="search-status" style="display: none;">
                            <i class="fas fa-filter"></i>
                            Found <span id="search-count">0</span> junior lecturers matching your search
                        </div>
                    </div>
                </div>

                <!-- Teachers Table -->
                <div class="card">
                    <div class="table-container">
                        <table id="teacher-table">
                            <thead>
                                <tr>
                                    <th class="text-center">Profile</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>CNIC</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="teacher-table-body">
                                <!-- Table content will be populated by JavaScript -->
                            </tbody>
                        </table>
                        
                        <!-- Loading Spinner -->
                        <div id="loading-spinner" class="loading-spinner">
                            <div class="spinner"></div>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="card-body">
                        <div id="pagination" class="pagination"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Theme Toggle Button -->
    <div class="theme-toggle" onclick="toggleTheme()">
        <i id="theme-icon" class="fas fa-moon"></i>
    </div>

    <!-- Courses Modal -->
    <div id="courses-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-teacher-name">
                    <i class="fas fa-book mr-2"></i> Junior Lecturer Courses
                </h3>
                <button class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="course-tabs">
                    <button class="course-tab active" data-tab="active-courses">Active Courses</button>
                    <button class="course-tab" data-tab="previous-courses">Previous Courses</button>
                </div>
                
                <div id="modal-loading" class="modal-loading">
                    <div class="spinner"></div>
                </div>
                
                <div id="modal-error" class="modal-error" style="display: none;">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Failed to load courses. Please try again.</p>
                    <button class="btn btn-primary mt-2" onclick="loadCourses()">
                        <i class="fas fa-sync-alt"></i> Retry
                    </button>
                </div>
                
                <div id="active-courses" class="course-list active">
                    <!-- Active courses will be populated here -->
                </div>
                
                <div id="previous-courses" class="course-list">
                    <!-- Previous courses will be populated here -->
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container mx-auto px-4">
            <div class="footer-content">
                <div class="footer-copyright">
                    © Sharjeel | Ali | Sameer Learning Management System
                </div>
            </div>
        </div>
    </footer>

    <script>
        let teachers = [];
        let filteredTeachers = [];
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let currentPage = 1;
        let itemsPerPage = 6;
        let currentTeacherId = null;

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }
        
        function navigateToDashboard() {
            window.location.href = "{{ route('director.dashboard') }}";
        }

        async function loadTeachers() {
            try {
                showLoading(true);
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/junior-lectures`);
                const data = await response.json();
                if (data.Teacher) {
                    teachers = data.Teacher;
                    filteredTeachers = [...teachers];
                    updateSearchCount();
                    renderTeachers();
                }
                showLoading(false);
            } catch (error) {
                console.error("Error fetching junior lecturers:", error);
                showError("Failed to load junior lecturers. Please try again later.");
                showLoading(false);
            }
        }

        function showLoading(isLoading) {
            const tableBody = document.getElementById("teacher-table-body");
            const loadingElement = document.getElementById("loading-spinner");
            
            if (isLoading) {
                tableBody.innerHTML = '';
                loadingElement.style.display = 'flex';
            } else {
                loadingElement.style.display = 'none';
            }
        }

        function showError(message) {
            const tableBody = document.getElementById("teacher-table-body");
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="empty-state">
                        <i class="fas fa-exclamation-circle"></i>
                        <p class="empty-state-text">${message}</p>
                        <button onclick="loadTeachers()" class="btn btn-primary">
                            <i class="fas fa-sync-alt"></i> Try Again
                        </button>
                    </td>
                </tr>
            `;
        }

      function searchTeachers() {
    const searchValue = document.getElementById("search-input").value.trim().toLowerCase();
    
    if (searchValue === '') {
        resetSearch();
        return;
    }
    
    filteredTeachers = teachers.filter(teacher => {
        // Check if teacher and teacher.user exist
        if (!teacher || !teacher.user) return false;
        
        // Convert all searchable fields to lowercase strings for comparison
        const name = teacher.name ? teacher.name.toLowerCase() : '';
        const username = teacher.user.username ? teacher.user.username.toLowerCase() : '';
        const email = teacher.user.email ? teacher.user.email.toLowerCase() : '';
        const cnic = teacher.cnic ? teacher.cnic.toString() : '';
        
        return name.includes(searchValue) ||
               username.includes(searchValue) ||
               email.includes(searchValue) ||
               cnic.includes(searchValue);
    });
    
    currentPage = 1;
    updateSearchCount();
    renderTeachers();
}

// Update the resetSearch function
function resetSearch() {
    document.getElementById("search-input").value = "";
    filteredTeachers = [...teachers];
    currentPage = 1;
    updateSearchCount();
    renderTeachers();
}

        function updateSearchCount() {
            const searchCount = document.getElementById("search-count");
            const searchStatus = document.getElementById("search-status");
            
            if (filteredTeachers.length === teachers.length) {
                searchStatus.style.display = "none";
            } else {
                searchCount.textContent = filteredTeachers.length;
                searchStatus.style.display = "flex";
            }
        }

        function renderTeachers() {
            const tableBody = document.getElementById("teacher-table-body");
            tableBody.innerHTML = "";

            if (filteredTeachers.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-user-slash"></i>
                            <p class="empty-state-text">No junior lecturers found matching your search criteria.</p>
                            <button onclick="resetSearch()" class="btn btn-primary">
                                <i class="fas fa-sync-alt"></i> Reset Search
                            </button>
                        </td>
                    </tr>
                `;
                renderPagination();
                return;
            }

            const startIndex = (currentPage - 1) * itemsPerPage;
            const paginatedTeachers = filteredTeachers.slice(startIndex, startIndex + itemsPerPage);

            paginatedTeachers.forEach((teacher, index) => {
                const row = document.createElement('tr');
                row.className = 'fade-in';
                row.style.animationDelay = `${index * 0.05}s`;
                
                row.innerHTML = `
                    <td class="text-center" data-label="Profile">
                        <img src="${teacher.image ? teacher.image : '/images/male.png'}" alt="Profile" class="teacher-img mx-auto">
                    </td>
                    <td data-label="Name">
                        <div class="font-medium">${teacher.name}</div>
                    </td>
                    <td data-label="Username">
                        <span class="badge badge-primary">${teacher.user ? teacher.user.username : 'N/A'}</span>
                    </td>
                    <td data-label="Email">
                        <a href="mailto:${teacher.user ? teacher.user.email : ''}" class="text-blue-600 hover:underline">
                            ${teacher.user ? teacher.user.email : 'N/A'}
                        </a>
                    </td>
                    <td data-label="CNIC">
                        ${teacher.cnic}
                    </td>
                    <td data-label="Actions">
                        <button class="view-btn" onclick="showTeacherCourses(${teacher.id}, '${teacher.name}')">
                            <i class="fas fa-eye"></i> View
                        </button>
                    </td>
                `;
                
                tableBody.appendChild(row);
            });

            renderPagination();
        }

        function renderPagination() {
            const pagination = document.getElementById("pagination");
            const totalPages = Math.ceil(filteredTeachers.length / itemsPerPage);
            
            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }
            
            let paginationHTML = '';
            
            // Previous button
            paginationHTML += `
                <button 
                    class="page-link ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}" 
                    ${currentPage === 1 ? 'disabled' : 'onclick="changePage(' + (currentPage - 1) + ')"'}
                >
                    <i class="fas fa-chevron-left"></i>
                </button>
            `;
            
            // Page numbers
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
            
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }
            
            if (startPage > 1) {
                paginationHTML += `<button class="page-link" onclick="changePage(1)">1</button>`;
                if (startPage > 2) {
                    paginationHTML += `<span class="px-2">...</span>`;
                }
            }
            
            for (let i = startPage; i <= endPage; i++) {
                paginationHTML += `
                    <button class="page-link ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">
                        ${i}
                    </button>
                `;
            }
            
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    paginationHTML += `<span class="px-2">...</span>`;
                }
                paginationHTML += `<button class="page-link" onclick="changePage(${totalPages})">${totalPages}</button>`;
            }
            
            // Next button
            paginationHTML += `
                <button 
                    class="page-link ${currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''}" 
                    ${currentPage === totalPages ? 'disabled' : 'onclick="changePage(' + (currentPage + 1) + ')"'}
                >
                    <i class="fas fa-chevron-right"></i>
                </button>
            `;
            
            pagination.innerHTML = paginationHTML;
        }

        function changePage(page) {
            currentPage = page;
            renderTeachers();
            // Scroll to top of table
            document.getElementById('teacher-table').scrollIntoView({ behavior: 'smooth' });
        }

        function toggleTheme() {
            document.body.classList.toggle('dark-theme');
            const themeIcon = document.getElementById('theme-icon');
            if (document.body.classList.contains('dark-theme')) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }

        // Modal functions
        function showTeacherCourses(teacherId, teacherName) {
            currentTeacherId = teacherId;
            document.getElementById('modal-teacher-name').innerHTML = `
                <i class="fas fa-book mr-2"></i> ${teacherName}'s Courses
            `;
            
            // Reset modal content
            document.getElementById('active-courses').innerHTML = '';
            document.getElementById('previous-courses').innerHTML = '';
            document.getElementById('modal-error').style.display = 'none';
            document.getElementById('modal-loading').style.display = 'flex';
            
            // Show modal
            document.getElementById('courses-modal').style.display = 'flex';
            
            // Load courses
            loadCourses();
        }

        function closeModal() {
            document.getElementById('courses-modal').style.display = 'none';
        }

       async function loadCourses() {
    try {
        // Show loading state
        document.getElementById('modal-loading').style.display = 'flex';
        document.getElementById('modal-error').style.display = 'none';
        
        // Call your API endpoint for junior lecturers
        const response = await fetch(`${API_BASE_URL}api/JuniorLec/your-courses?teacher_id=${currentTeacherId}`);
        const data = await response.json();
        
        console.log("API Response:", data); // For debugging
        
        // Check for data in the correct structure
        if (data.status === 'success' && data.data) {
            renderCourses(data.data);
        } else {
            throw new Error(data.message || 'Failed to load courses');
        }
    } catch (error) {
        console.error("Error loading courses:", error);
        document.getElementById('modal-error').style.display = 'block';
        document.getElementById('modal-loading').style.display = 'none';
    }
}

   function renderCourses(coursesData) {
    // Hide loading
    document.getElementById('modal-loading').style.display = 'none';
    
    console.log("Rendering courses with data:", coursesData);
    
    // Render active courses
    const activeCoursesContainer = document.getElementById('active-courses');
    if (coursesData.active_courses && coursesData.active_courses.length > 0) {
        let activeCourseHtml = '';
        
        // Iterate through each active course
        coursesData.active_courses.forEach(course => {
            activeCourseHtml += `
                <div class="course-item">
                    <div class="course-name">${course.course_name}</div>
                    <div class="course-details">
                        <div class="course-detail">
                            <i class="fas fa-users"></i>
                            <span>Section: ${course.section_name}</span>
                        </div>
                        <div class="course-detail">
                            <i class="fas fa-clock"></i>
                            <span>Credit Hours: ${course.credit_hours}</span>
                        </div>
                        <div class="course-detail">
                            <i class="fas fa-book"></i>
                            <span>Course Code: ${course.course_code}</span>
                        </div>
                        <div class="course-detail">
                            <i class="fas fa-calendar"></i>
                            <span>Session: ${course.session_name}</span>
                        </div>
                    </div>
                </div>
            `;
        });
        
        activeCoursesContainer.innerHTML = activeCourseHtml;
    } else {
        activeCoursesContainer.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <p class="empty-state-text">No active courses found</p>
            </div>
        `;
    }
    
    // Render previous courses - handle nested structure by semester
    const previousCoursesContainer = document.getElementById('previous-courses');
    if (coursesData.previous_courses && Object.keys(coursesData.previous_courses).length > 0) {
        let html = '';
        
        // Loop through each semester
        for (const semester in coursesData.previous_courses) {
            const semesterCourses = coursesData.previous_courses[semester];
            
            if (semesterCourses && semesterCourses.length > 0) {
                // Add semester heading
                html += `<h3 class="text-lg font-semibold text-primary-color mt-4 mb-2">${semester}</h3>`;
                
                // Add courses for this semester
                semesterCourses.forEach(course => {
                    html += `
                        <div class="course-item">
                            <div class="course-name">${course.course_name}</div>
                            <div class="course-details">
                                <div class="course-detail">
                                    <i class="fas fa-users"></i>
                                    <span>Section: ${course.section_name}</span>
                                </div>
                                <div class="course-detail">
                                    <i class="fas fa-clock"></i>
                                    <span>Credit Hours: ${course.credit_hours}</span>
                                </div>
                                <div class="course-detail">
                                    <i class="fas fa-book"></i>
                                    <span>Course Code: ${course.course_code}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }
        }
        
        previousCoursesContainer.innerHTML = html || `
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <p class="empty-state-text">No previous courses found</p>
            </div>
        `;
    } else {
        previousCoursesContainer.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <p class="empty-state-text">No previous courses found</p>
            </div>
        `;
    }
}

        // Tab switching functionality
    document.addEventListener('DOMContentLoaded', () => {
    loadTeachers();
    
    // Improved search input event listener
    const searchInput = document.getElementById("search-input");
    searchInput.addEventListener("input", function(event) {
        // Add a small delay to prevent rapid firing
        clearTimeout(this.searchTimer);
        this.searchTimer = setTimeout(() => {
            searchTeachers();
        }, 300);
    });
    
    searchInput.addEventListener("keyup", function(event) {
        if (event.key === "Enter") {
            clearTimeout(this.searchTimer);
            searchTeachers();
        }
    });
            
            // Add event listeners for course tabs
            document.querySelectorAll('.course-tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    // Remove active class from all tabs
                    document.querySelectorAll('.course-tab').forEach(t => {
                        t.classList.remove('active');
                    });
                    
                    // Add active class to clicked tab
                    tab.classList.add('active');
                    
                    document.querySelectorAll('.course-tab').forEach(t => {
                        t.classList.remove('active');
                    });
                    
                    // Add active class to clicked tab
                    tab.classList.add('active');
                    
                    // Hide all course lists
                    document.querySelectorAll('.course-list').forEach(list => {
                        list.classList.remove('active');
                    });
                    
                    // Show the corresponding course list
                    const tabId = tab.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
            
            // Close modal when clicking outside of it
            document.getElementById('courses-modal').addEventListener('click', (e) => {
                if (e.target === document.getElementById('courses-modal')) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>