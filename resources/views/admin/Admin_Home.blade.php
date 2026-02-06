<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | LMS</title>
    @vite('resources/css/app.css')
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --primary-light: #93c5fd;
            --secondary: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --rounded-sm: 0.25rem;
            --rounded-md: 0.5rem;
            --rounded-lg: 0.75rem;
            --rounded-xl: 1rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: var(--gray-100);
            color: var(--gray-900);
            line-height: 1.5;
            overflow-x: hidden;
        }

        body.admin-dashboard {
            background: linear-gradient(135deg, #f0f7ff 0%, #a9d1f8 50%, #4c9bef 100%);
            min-height: 100vh;
        }

        .admin-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Navbar styles */
        .navbar {
            background-color: var(--white);
            box-shadow: var(--shadow-md);
            padding: 0.75rem 1rem;
            position: sticky;
            top: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-dark);
        }

        .navbar-toggler {
            display: none;
            border: none;
            background: none;
            cursor: pointer;
            padding: 0.5rem;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-left: auto;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-link {
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .profile-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            position: relative;
        }

        .profile-image {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-light);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-name {
            font-weight: 600;
            color: var(--gray-900);
        }

        .profile-role {
            font-size: 0.75rem;
            color: var(--gray-600);
        }

        /* Main Content */
        .main-content {
            padding: 1.5rem 0;
        }

        .container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Announcement Banner */
        .announcement-banner {
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border-radius: var(--rounded-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .marquee-wrapper {
            overflow: hidden;
            width: 100%;
        }

        .marquee-container {
            display: flex;
            gap: 2rem;
            white-space: nowrap;
            animation: marquee 40s linear infinite;
        }

        .marquee-content {
            display: flex;
            gap: 2rem;
            padding: 0.75rem 1rem;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .announcement-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Dashboard Grid System */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        /* Responsive column sizing */
        .col-span-12 {
            grid-column: span 12;
        }

        .col-span-6 {
            grid-column: span 6;
        }

        .col-span-4 {
            grid-column: span 4;
        }

        .col-span-3 {
            grid-column: span 3;
        }

        /* Card Components */
        .card {
            background-color: var(--white);
            border-radius: var(--rounded-lg);
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: var(--rounded-md);
            font-size: 1.25rem;
        }

        .card-icon.blue {
            background-color: #dbeafe;
            color: var(--primary-dark);
        }

        .card-icon.green {
            background-color: #d1fae5;
            color: var(--secondary);
        }

        .card-icon.red {
            background-color: #fee2e2;
            color: var(--danger);
        }

        .card-icon.orange {
            background-color: #fef3c7;
            color: var(--warning);
        }

        /* Stats Card */
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: var(--gray-900);
        }

        .stat-label {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        /* Action Buttons Grid */
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.25rem 1rem;
            background-color: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--rounded-md);
            text-decoration: none;
            color: var(--gray-800);
            transition: all 0.2s ease;
            text-align: center;
        }

        .action-btn:hover {
            background-color: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .action-btn .icon {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .action-btn .text {
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* Data Tables */
        .table-container {
            overflow-x: auto;
            border-radius: var(--rounded-md);
            background-color: var(--white);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .data-table th,
        .data-table td {
            padding: 0.75rem 1rem;
            text-align: left;
        }

        .data-table th {
            background-color: var(--gray-50);
            font-weight: 600;
            color: var(--gray-700);
            border-bottom: 1px solid var(--gray-200);
        }

        .data-table td {
            border-bottom: 1px solid var(--gray-200);
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:hover td {
            background-color: var(--gray-50);
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: 2rem 0;
            margin-top: 2rem;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
            text-align: center;
        }

        .footer-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-text {
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .copyright {
            opacity: 0.8;
            font-size: 0.875rem;
            margin-top: 1rem;
        }

        /* Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .dashboard-grid {
                gap: 1rem;
            }
        }

        @media (max-width: 992px) {
            .col-md-6 {
                grid-column: span 6;
            }

            .col-md-12 {
                grid-column: span 12;
            }

            .actions-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }

            .card-title {
                font-size: 1rem;
            }

            .stat-value {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-grid {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .navbar-toggler {
                display: block;
            }

            .navbar-collapse {
                width: 100%;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }

            .navbar-collapse.show {
                max-height: 500px;
            }

            .navbar-menu {
                flex-direction: column;
                width: 100%;
                gap: 1rem;
                margin-top: 1rem;
            }

            .navbar-nav {
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
            }

            .profile-menu {
                width: 100%;
                justify-content: flex-start;
            }

            .col-span-3,
            .col-span-4,
            .col-span-6,
            .col-span-8,
            .col-span-12,
            .col-md-6,
            .col-md-12,
            .col-sm-6,
            .col-sm-12 {
                width: 100%;
                margin-bottom: 1rem;
            }

            .actions-grid {
                grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            }

            .main-content {
                padding: 1rem 0;
            }

            .container {
                padding: 0 0.75rem;
            }

            .announcement-banner {
                margin-bottom: 1rem;
            }

            .announcement-item {
                font-size: 0.8rem;
            }

            .card {
                margin-bottom: 0;
            }

            .card-header {
                padding: 0.75rem 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .stat-label {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .dashboard-grid {
                gap: 0.75rem;
            }

            .actions-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }

            .action-btn {
                padding: 0.75rem 0.5rem;
                border-radius: var(--rounded-sm);
            }

            .action-btn .icon {
                font-size: 1.25rem;
                margin-bottom: 0.5rem;
            }

            .action-btn .text {
                font-size: 0.75rem;
            }

            .card-header {
                padding: 0.75rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .card-title {
                font-size: 0.9rem;
            }

            .card-icon {
                width: 2rem;
                height: 2rem;
                font-size: 1rem;
            }

            .stat-value {
                font-size: 1.25rem;
                margin-bottom: 0.2rem;
            }

            .stat-label {
                font-size: 0.7rem;
            }

            .marquee-content {
                gap: 1rem;
                padding: 0.5rem;
            }

            .footer {
                padding: 1.5rem 0;
                margin-top: 1.5rem;
            }

            .footer-title {
                font-size: 1.25rem;
                margin-bottom: 0.75rem;
            }

            .footer-text {
                font-size: 0.8rem;
                margin-bottom: 0.75rem;
            }

            .copyright {
                font-size: 0.75rem;
            }

            .data-table th,
            .data-table td {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body class="admin-dashboard">
    @include('admin.navbar', [
        'username' => session('username', 'Guest'),
        'profileImage' => session('profileImage', asset('images/male.png')),
        'designation' => session('designation', 'N/A'),
        'type' => session('type', 'User'),
    ])
    <main class="main-content">
        <div class="container">
            <div class="announcement-banner fade-in">
                <div class="marquee-wrapper">
                    <div class="marquee-container">
                        <div class="marquee-content">
                            <span class="announcement-item">🚀 Current Session: {{ session('currentSession') }}</span>
                            <span class="announcement-item">🏛️ Session Start: {{ session('startDate') }}</span>
                            <span class="announcement-item">🎓 Session End: {{ session('endDate') }}</span>
                            <span class="announcement-item">📢 Students Week Soon</span>
                            <span class="announcement-item">📝 Mids: 25 March 2025</span>
                        </div>
                        <div class="marquee-content">
                            <span class="announcement-item">🚀 Current Session: {{ session('currentSession') }}</span>
                            <span class="announcement-item">🏛️ Session Start: {{ session('startDate') }}</span>
                            <span class="announcement-item">🎓 Session End: {{ session('endDate') }}</span>
                            <span class="announcement-item">📢 New Student Portal Live!</span>
                            <span class="announcement-item">📝 Exam Forms Due Soon</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-grid">
                <div class="col-span-3 col-md-6 col-xs-12 fade-in delay-100">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Courses</h3>
                            <div class="card-icon blue">📚</div>
                        </div>
                        <div class="card-body">
                            <div class="stat-value">{{ session('course_count') }}</div>
                            <div class="stat-label">Total Courses in System</div>
                        </div>
                    </div>
                </div>

                <div class="col-span-3 col-md-6 col-xs-12 fade-in delay-100">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Offered</h3>
                            <div class="card-icon green">📝</div>
                        </div>
                        <div class="card-body">
                            <div class="stat-value">{{ session('offer_count') }}</div>
                            <div class="stat-label">Courses This Session</div>
                        </div>
                    </div>
                </div>

                <div class="col-span-3 col-md-6 col-xs-12 fade-in delay-200">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Students</h3>
                            <div class="card-icon orange">👨‍🎓</div>
                        </div>
                        <div class="card-body">
                            <div class="stat-value">{{ session('student_count') }}</div>
                            <div class="stat-label">Registered Students</div>
                        </div>
                    </div>
                </div>

                <div class="col-span-3 col-md-6 col-xs-12 fade-in delay-200">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Faculty</h3>
                            <div class="card-icon red">👨‍🏫</div>
                        </div>
                        <div class="card-body">
                            <div class="stat-value">{{ session('faculty_count') }}</div>
                            <div class="stat-label">Teaching Staff</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-grid">
                <div class="col-span-8 col-md-12 fade-in delay-300">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="actions-grid">
                                <a href="{{ route('all.student') }}" class="action-btn"
                                    onclick="logFunction('Students Viewed');">
                                    <span class="icon">🧑‍🎓</span>
                                    <span class="text">View Students</span>
                                </a>

                                <a href="{{ route('all.teacher') }}" class="action-btn"
                                    onclick="logFunction('Teachers Viewed');">
                                    <span class="icon">🧑‍🏫</span>
                                    <span class="text">View Teachers</span>
                                </a>

                                <a href="{{ route('all.junior') }}" class="action-btn"
                                    onclick="logFunction('Junior Lecturers Viewed');">
                                    <span class="icon">👨‍🔬</span>
                                    <span class="text">View Junior Lecturers</span>
                                </a>

                                <a href="{{ route('all.course') }}" class="action-btn"
                                    onclick="logFunction('Courses Viewed');">
                                    <span class="icon">📘</span>
                                    <span class="text">View Courses</span>
                                </a>

                                <a href="{{ route('all.course_allocation') }}" class="action-btn"
                                    onclick="logFunction('Course Allocations');">
                                    <span class="icon">🗂️</span>
                                    <span class="text">Course Allocations</span>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-4 col-md-12 fade-in delay-300">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Activity</h3>
                            <div class="card-icon blue">🔄</div>
                        </div>
                        <div class="card-body">
                            <div class="table-container">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id="activity-feed">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-grid">
                <div class="col-span-6 col-md-12 fade-in delay-400">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Upload And Approvals</h3>
                        </div>
                        <div class="card-body">
                            <div class="actions-grid">

                                <a href="{{ route('all.grader') }}" class="action-btn"
                                    onclick="logFunction('Assign Graders');">
                                    <span class="icon">🧑‍🏫</span>
                                    <span class="text">Manage Graders</span>
                                </a>

                                <a href="{{ route('all.Graders') }}" class="action-btn"
                                    onclick="logFunction('View Archives');">
                                    <span class="icon">📥</span>
                                    <span class="text">Requested Graders (Demands)</span>
                                </a>

                                <a href="{{ route('full.timetable') }}" class="action-btn"
                                    onclick="logFunction('TimeTable Viewed');">
                                    <span class="icon">📆</span>
                                    <span class="text">View Timetable</span>
                                </a>

                                <a href="{{ route('show.timetable') }}" class="action-btn"
                                    onclick="logFunction('Timetable Uploaded');">
                                    <span class="icon">🗓️</span>
                                    <span class="text">Upload Timetable</span>
                                </a>
<a href="{{ route('date_sheet') }}" class="action-btn"
   onclick="logFunction('Viewing Date Sheet');">
    <span class="icon">📅</span>
    <span class="text">View Date Sheet</span>
</a>



                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-6 col-md-12 fade-in delay-400">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Additional Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="actions-grid">
                                <a href="{{ route('all.session') }}" class="action-btn"
                                    onclick="logFunction('Sessions Viewed');">
                                    <span class="icon">📅</span>
                                    <span class="text">View Session</span>
                                </a>
                                <a href="{{ route('show.excel_excludedDays') }}" class="action-btn"
                                    onclick="logFunction('Added Excluded days');">
                                    <span class="icon">🚫</span>
                                    <span class="text">Add Excluded Days</span>
                                </a>

                                <a href="{{ route('send.notification') }}" class="action-btn"
                                    onclick="logFunction('Notifications Viewed');">
                                    <span class="icon">📨</span>
                                    <span class="text">Send Notification</span>
                                </a>
                                {{-- <a href="{{route('add.admin')}}" class="action-btn" onclick="logFunction('Add Admin');">
                                    <span class="icon">👤</span>
                                    <span class="text">Add Admin</span>
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <h2 class="footer-title">Learning Management System</h2>
            <p class="footer-text">Comprehensive platform for educational management</p>
            <p class="copyright">&copy; 2025 LMS. All Rights Reserved.</p>
            <p>Sameer | Ali | Sharjeel</p>
        </div>
    </footer>

    <script>
       
        let callLog = [];
        const MAX_LOG_ENTRIES = 6;

        function logFunction(name) {
            const actionName = name
                .replace(/([A-Z])/g, ' $1')
                .replace(/(\b\w)/g, firstChar => firstChar.toUpperCase())
                .trim();

            callLog.unshift({
                name: actionName,
                time: new Date().toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                })
            });

            if (callLog.length > MAX_LOG_ENTRIES) {
                callLog = callLog.slice(0, MAX_LOG_ENTRIES);
            }

            updateActivityFeed();
        }

       
        const activities = [{
                action: "New student registered",
                time: "Just now"
            },
            {
                action: "Course updated",
                time: "5 minutes ago"
            },
            {
                action: "Notification sent",
                time: "30 minutes ago"
            },
            {
                action: "System backup completed",
                time: "2 hours ago"
            },
            {
                action: "New teacher added",
                time: "5 hours ago"
            }
        ];

        function updateActivityFeed() {
            const feed = document.getElementById('activity-feed');
            feed.innerHTML = callLog.map(entry => `
                <tr>
                    <td>${entry.name}</td>
                    <td>${entry.time}</td>
                </tr>
            `).join('');
        }
        function addNewActivity(action) {
            const now = new Date();
            const timeString = now.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });

            callLog.unshift({
                name: action,
                time: timeString
            });

            if (callLog.length > MAX_LOG_ENTRIES) {
                callLog = callLog.slice(0, MAX_LOG_ENTRIES);
            }

            updateActivityFeed();
        }
        document.addEventListener('DOMContentLoaded', function() {
           
            activities.forEach(activity => {
                callLog.push({
                    name: activity.action,
                    time: activity.time
                });
            });
            updateActivityFeed();
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');

            if (navbarToggler && navbarCollapse) {
                navbarToggler.addEventListener('click', function() {
                    navbarCollapse.classList.toggle('show');
                });
            }
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach(el => {
                el.style.opacity = '0';
            });

            setTimeout(() => {
                fadeElements.forEach(el => {
                    el.style.opacity = '1';
                });
            }, 100);

            setInterval(() => {
                const sampleActions = [
                    "New login detected",
                    "Course material updated",
                    "Grade submission received",
                    "System maintenance completed",
                    "New enrollment request"
                ];
                const randomAction = sampleActions[Math.floor(Math.random() * sampleActions.length)];
                addNewActivity(randomAction);
            }, 30000);
        });
    </script>
</body>

</html>
