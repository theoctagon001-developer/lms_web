<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Dashboard | LMS</title>
    @vite('resources/css/app.css')
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --primary-light: #93c5fd;
            --secondary: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-700: #374151;
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
        }

        body.hod-dashboard {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;

            background: linear-gradient(135deg, #f0f7ff 0%, #a9d1f8 50%, #4c9bef 100%);
            min-height: 100vh;

            line-height: 1.5;
        }

        .hod-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Use different class names to avoid conflicts with navbar */
        .hod-flex {
            display: flex;
        }

        .hod-items-center {
            align-items: center;
        }


        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .bg-white {
            background-color: var(--white);
        }

        .p-4 {
            padding: 1rem;
        }

        .shadow-md {
            box-shadow: var(--shadow-md);
        }

        .relative {
            position: relative;
        }

        .z-50 {
            z-index: 50;
        }

        .sticky {
            position: sticky;
        }

        .top-0 {
            top: 0;
        }

        .w-full {
            width: 100%;
        }

        .space-x-3>*+* {
            margin-left: 0.75rem;
        }

        .text-blue-500 {
            color: #3b82f6;
        }

        .text-2xl {
            font-size: 1.5rem;
        }

        .md-hidden {
            display: none;
        }

        @media (max-width: 768px) {
            .md-hidden {
                display: block;
            }

            .md-flex {
                display: none;
            }
        }

        .font-bold {
            font-weight: 700;
        }

        .text-blue-600 {
            color: var(--primary-dark);
        }

        .text-xl {
            font-size: 1.25rem;
        }

        .lg-text-4xl {
            font-size: 2.25rem;
        }

        .ml-auto {
            margin-left: auto;
        }

        .mr-5 {
            margin-right: 1.25rem;
        }

        .space-x-10>*+* {
            margin-left: 2.5rem;
        }

        .text-red-500 {
            color: var(--danger);
        }

        .ml-5 {
            margin-left: 1.25rem;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .w-11 {
            width: 2.75rem;
        }

        .h-10 {
            height: 2.5rem;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .border {
            border-width: 1px;
        }

        .border-gray-300 {
            border-color: var(--gray-300);
        }

        .flex-col {
            flex-direction: column;
        }

        .text-gray-600 {
            color: var(--gray-700);
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-gray-400 {
            color: var(--gray-300);
        }

        /* Main Content */
        .main-content {
            padding: 2rem 0;
        }

        .max-w-7xl {
            max-width: 80rem;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        /* Announcement Banner */
        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--primary), var(--primary-dark));
        }

        .text-white {
            color: var(--white);
        }

        .rounded-xl {
            border-radius: var(--rounded-xl);
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .mb-8 {
            margin-bottom: 2rem;
        }

        .whitespace-nowrap {
            white-space: nowrap;
        }

        .md-text-base {
            font-size: 1rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .space-x-16>*+* {
            margin-left: 4rem;
        }

        .space-x-20>*+* {
            margin-left: 5rem;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .col-span-3 {
            grid-column: span 3;
        }

        .col-span-4 {
            grid-column: span 4;
        }

        .col-span-6 {
            grid-column: span 6;
        }

        .col-span-8 {
            grid-column: span 8;
        }

        /* Cards */
        .card {
            background-color: var(--white);
            border-radius: var(--rounded-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--rounded-md);
            display: flex;
            align-items: center;
            justify-content: center;
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

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--gray-700);
            font-size: 0.875rem;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            background-color: var(--white);
            border-radius: var(--rounded-lg);
            text-align: center;
            text-decoration: none;
            color: var(--gray-900);
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            background-color: var(--primary);
            color: var(--white);
        }

        .action-btn .icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .action-btn .text {
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* Week Progress */
        .progress-container {
            background-color: var(--white);
            border-radius: var(--rounded-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 2rem;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .progress-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .progress-ring {
            width: 60px;
            height: 60px;
        }

        .progress-ring__circle {
            transition: stroke-dashoffset 0.5s ease;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .progress-bar {
            margin-top: 1rem;
            height: 8px;
            background-color: var(--gray-200);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background-color: var(--primary);
        }

        /* Data Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .data-table th,
        .data-table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .data-table th {
            background-color: var(--gray-100);
            font-weight: 600;
            color: var(--gray-700);
        }

        .data-table tr:hover {
            background-color: var(--gray-100);
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            padding: 2rem 0;
            margin-top: 3rem;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-text {
            margin-bottom: 1rem;
        }

        /* Animation */
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

        .animate-fade {
            animation: fadeIn 0.5s ease-out forwards;
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

        /* Marquee Animation */
        @keyframes marquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-100%);
            }
        }

        .marquee-container {
            display: flex;
            min-width: 200%;
            animation: marquee 50s linear infinite;
        }

        .relative:hover .marquee-container {
            animation-play-state: paused;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {

            .col-span-4,
            .col-span-8 {
                grid-column: span 12;
            }

            .dashboard-grid {
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .quick-actions {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }

            .col-span-3,
            .col-span-6 {
                grid-column: span 12;
            }
        }

        @media (max-width: 640px) {
            .announcement-content {
                flex-direction: column;
                gap: 1rem;
            }

            .announcement-text {
                flex-direction: column;
                gap: 0.5rem;
            }

            .announcement-item {
                white-space: normal;
            }

            .quick-actions {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
        }
    </style>
</head>

<body class="hod-dashboard">
    @include('HOD.partials.profile_panel')

    <main class="main-content">
        <div class="max-w-7xl mx-auto px-3 py-3">
            <div
                class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-md rounded-xl overflow-hidden mb-8">
                <div
                    class="marquee-container flex space-x-16 whitespace-nowrap text-sm md-text-base font-medium px-4 py-3">
                    <div class="marquee flex space-x-20">
                        <span>🚀 Current Session : {{ session('currentSession') }}</span>
                        <span>🏛️ Session Start Date : {{ session('startDate') }}</span>
                        <span>🎓 Session End Date : {{ session('endDate') }}</span>
                        <span>📢 Students Week Soon</span>
                        <span>📝 Mids: 25 March 2025</span>
                    </div>
                    <div class="marquee flex space-x-16">
                        <span>🚀 Current Session : {{ session('currentSession') }}</span>
                        <span>🏛️ Session Start Date : {{ session('startDate') }}</span>
                        <span>🎓 Session End Date : {{ session('endDate') }}</span>
                        <span>📢 New Student Portal Launched!</span>
                        <span>📝 Exam Forms Submission Ends Soon</span>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="dashboard-grid">
                <div class="col-span-3 animate-fade delay-100">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Faculty Members</h3>
                            <div class="card-icon blue">👨‍🏫</div>
                        </div>
                        <div class="stat-value">{{ session('faculty_count') }}</div>
                        <div class="stat-label">Total Faculty in Department</div>
                    </div>
                </div>

                <div class="col-span-3 animate-fade delay-100">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Students</h3>
                            <div class="card-icon green">👨‍🎓</div>
                        </div>
                        <div class="stat-value">{{ session('student_count') }}</div>
                        <div class="stat-label">Registered Students</div>
                    </div>
                </div>

                <div class="col-span-3 animate-fade delay-200">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Total Courses</h3>
                            <div class="card-icon orange">📚</div>
                        </div>
                        <div class="stat-value">{{ session('course_count') }}</div>
                        <div class="stat-label">Courses in Department</div>
                    </div>
                </div>

                <div class="col-span-3 animate-fade delay-200">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Offered Courses</h3>
                            <div class="card-icon red">📝</div>
                        </div>
                        <div class="stat-value">{{ session('offer_count') }}</div>
                        <div class="stat-label">Courses This Session</div>
                    </div>
                </div>
            </div>

            <!-- Week Progress -->
            <div class="card animate-fade delay-300 mb-6"> <!-- Added mb-6 for bottom margin -->
                <div class="card-header">
                    <h3 class="card-title">Academic Session Progress</h3>
                    <a href="{{ route('hod.sessions.add') }}">
                        <div class="card-icon blue cursor-pointer">📅</div>
                    </a>

                </div>
                <div class="flex flex-col md:flex-row items-center justify-between gap-4 p-4">

                    <div class="relative w-24 h-24 flex-shrink-0">
                        <svg class="w-full h-full" viewBox="0 0 36 36">
                            <!-- Background circle -->
                            <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#e5e7eb"
                                stroke-width="2"></circle>
                            <!-- Progress circle -->
                            <circle id="progress-ring-circle" cx="18" cy="18" r="15.9155" fill="none"
                                stroke="#3b82f6" stroke-width="3" stroke-linecap="round" stroke-dasharray="100 100"
                                transform="rotate(-90 18 18)"></circle>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-lg font-bold text-gray-800" id="week-progress-text">
                                {{ session('current_week', 1) }}
                            </span>
                            <span class="text-xs text-gray-500">Week</span>
                        </div>
                    </div>

                    <!-- Session Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-700">Session:</span>
                            <span class="text-sm text-gray-600">{{ session('currentSession') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-700">Duration:</span>
                            <span class="text-sm text-gray-600">
                                {{ session('startDate') }} - {{ session('endDate') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-700">Total Weeks:</span>
                            <span class="text-sm text-gray-600">
                                {{ str_contains(session('currentSession'), 'Fall') || str_contains(session('currentSession'), 'Spring') ? 16 : 8 }}
                            </span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full md:w-auto md:flex-1">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Week 1</span>
                            <span>
                                {{ str_contains(session('currentSession'), 'Fall') || str_contains(session('currentSession'), 'Spring') ? 16 : 8 }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            @php
                                $totalWeeks =
                                    str_contains(session('currentSession'), 'Fall') ||
                                    str_contains(session('currentSession'), 'Spring')
                                        ? 16
                                        : 8;
                                $currentWeek = session('current_week', 1);
                                $percentCompleted = round(($currentWeek / $totalWeeks) * 100);
                            @endphp
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentCompleted }}%"></div>
                        </div>
                        <div class="text-right mt-1">
                            <span class="text-xs font-medium text-blue-600">{{ $percentCompleted }}% completed</span>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const currentWeek = {{ session('current_week', 1) }};
                    const totalWeeks =
                        {{ str_contains(session('currentSession'), 'Fall') || str_contains(session('currentSession'), 'Spring') ? 16 : 8 }};
                    const progressPercentage = (currentWeek / totalWeeks) * 100;

                    const circle = document.getElementById('progress-ring-circle');
                    const radius = circle.r.baseVal.value;
                    const circumference = 2 * Math.PI * radius;
                    const offset = circumference - (progressPercentage / 100) * circumference;

                    circle.style.strokeDasharray = circumference;
                    circle.style.strokeDashoffset = offset;
                });
            </script>

            <!-- Quick Actions -->
            <div class="dashboard-grid">
                <div class="col-span-8 animate-fade delay-300">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                        </div>
                        <div class="quick-actions">
                            <a href="{{ route('hod.teachers.view') }}" class="action-btn"
                                onclick="logFunction('Teachers');">
                                <span class="icon">👩‍🏫</span>
                                <span class="text">Manage Teachers</span>
                            </a>
                            <a href="{{ route('hod.juniors.view') }}" class="action-btn"
                                onclick="logFunction('Juniors');">
                                <span class="icon">🧑‍🎓</span>
                                <span class="text">Manage Juniors</span>
                            </a>
                            <a href="{{ route('hod.courses.view') }}" class="action-btn"
                                onclick="logFunction('Course');">
                                <span class="icon">📘</span>
                                <span class="text">Manage Courses</span>
                            </a>
                            <a href="{{ route('hod.courses.allocation') }}" class="action-btn"
                                onclick="logFunction('Course Allocation');">
                                <span class="icon">📋</span>
                                <span class="text">Manage Course Allocation</span>
                            </a>
                            <a href="{{ route('hod.courses.content') }}" class="action-btn"
                                onclick="logFunction('Course Content');">
                                <span class="icon">📄</span>
                                <span class="text">Manage Course Content</span>
                            </a>
                            <a href="{{ route('hod.exams.create') }}" class="action-btn"
                                onclick="logFunction('Exam');">
                                <span class="icon">🧪</span>
                                <span class="text">Manage Exam</span>
                            </a>
                            <a href="{{ route('Audit_Report') }}" class="action-btn"
                                onclick="logFunction('Audit Report');">
                                <span class="icon">📊</span>
                                <span class="text">Audit Report</span>
                            </a>
                            <a href="{{ route('task_limit') }}" class="action-btn"
                                onclick="logFunction('Task Limit');">
                                <span class="icon">⏱️</span>
                                <span class="text">Set Task Limit</span>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="col-span-4 animate-fade delay-300">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Activity</h3>
                            <div class="card-icon blue">🔄</div>
                        </div>
                        <div class="data-table-container">
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

            <!-- Additional Actions -->
            <div class="dashboard-grid">
                <div class="col-span-6 animate-fade">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sessions & Archives</h3>
                        </div>
                        <div class="quick-actions">
                            <a href="{{ route('hod.sessions.add') }}" class="action-btn"
                                onclick="logFunction('Add Sessions');">
                                <span class="icon">📅</span>
                                <span class="text">Manage Sessions</span>
                            </a>
                            <a href="{{ route('hod.archives.manage') }}" class="action-btn"
                                onclick="logFunction('Manage Archives');">
                                <span class="icon">🗄️</span>
                                <span class="text">Manage Archives</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-span-6 animate-fade">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">More Options</h3>
                        </div>
                        <div class="quick-actions">
                            <a href="{{ route('hod.timetable.view') }}" class="action-btn"
                                onclick="logFunction('View Timetable');">
                                <span class="icon">📅</span>
                                <span class="text">View Timetable</span>
                            </a>
                            <a href="{{ route('hod.notifications.send') }}" class="action-btn"
                                onclick="logFunction('Send Notifications');">
                                <span class="icon">📨</span>
                                <span class="text">Send Notifications</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <h2 class="footer-title">Learning Management System</h2>
            <p class="footer-text">Comprehensive platform for educational management</p>
            <p>&copy; 2025 LMS. All Rights Reserved.</p>
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

        // Sample activity data (in a real app, this would come from your backend)
        const activities = [{
                action: "New teacher added",
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
                action: "New junior added",
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

        // Function to add a new activity (simulating real-time updates)
        function addNewActivity(action) {
            const now = new Date();
            const timeString = now.toLocaleTimeString();

            // Add new activity to the beginning of the array
            activities.unshift({
                action: action,
                time: timeString
            });

            // Keep only the last 5 activities
            if (activities.length > 5) {
                activities.pop();
            }

            updateActivityFeed();
        }

        // Initialize the activity feed
        updateActivityFeed();

        // Simulate real-time updates (in a real app, you would use WebSockets)
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
        }, 30000); // Update every 30 seconds

        // Simple animation trigger
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.animate-fade');
            elements.forEach(el => {
                el.style.opacity = '0';
            });

            setTimeout(() => {
                elements.forEach(el => {
                    el.style.opacity = '1';
                });
            }, 100);

            // Week progress circle animation
            const currentWeek = {{ session('current_week', 1) }};
            const totalWeeks =
                {{ str_contains(session('currentSession'), 'Fall') || str_contains(session('currentSession'), 'Spring') ? 16 : 8 }};
            const progressPercentage = (currentWeek / totalWeeks) * 100;

            const circle = document.getElementById('progress-ring-circle');
            const radius = circle.r.baseVal.value;
            const circumference = radius * 2 * Math.PI;

            circle.style.strokeDasharray = `${circumference} ${circumference}`;
            circle.style.strokeDashoffset = circumference - (progressPercentage / 100) * circumference;
        });
    </script>
</body>

</html>
