<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datacell Dashboard | LMS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: var(--gray-100);
            color: var(--gray-900);
            line-height: 1.5;
            overflow-x: hidden;
        }

        body.datacell-dashboard {
            background: linear-gradient(135deg, #f0f7ff 0%, #a9d1f8 50%, #4c9bef 100%);
            min-height: 100vh;
        }

        .datacell-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
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
        }
    </style>
</head>

<body class="datacell-dashboard">
    @include('DATACELL.partials.nav')
    <main class="main-content">
        <div class="container">
            <div class="announcement-banner fade-in">
                <div class="marquee-wrapper">
                    <div class="marquee-container">
                        <div class="marquee-content">
                            <span class="announcement-item">🚀 Current Session: {{ session('currentSession') }}</span>
                            <span class="announcement-item">🏛️ Session Start: {{ session('startDate') }}</span>
                            <span class="announcement-item">🎓 Session End: {{ session('endDate') }}</span>
                            <span class="announcement-item">📢 Data Entry Deadline: 25 March 2025</span>
                            <span class="announcement-item">📝 System Maintenance: Every Friday 2-4 AM</span>
                        </div>
                        <div class="marquee-content">
                            <span class="announcement-item">🚀 Current Session: {{ session('currentSession') }}</span>
                            <span class="announcement-item">🏛️ Session Start: {{ session('startDate') }}</span>
                            <span class="announcement-item">🎓 Session End: {{ session('endDate') }}</span>
                            <span class="announcement-item">📢 New Data Entry Guidelines Published</span>
                            <span class="announcement-item">📝 Backup Your Data Regularly</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
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

            <!-- Bulk Management Sections -->
            <div class="dashboard-grid">
                <div class="col-span-6 col-md-12 fade-in delay-300">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Information View</h3>
                        </div>
                        <div class="card-body">
                            <div class="actions-grid">
                                <a href="{{ route('datacell.view.student') }}" class="action-btn"
                                    onclick="logFunction('Student');">
                                    <span class="icon">🧑‍🎓</span>
                                    <span class="text">Manage Students</span>
                                </a>

                                <a href="{{ route('datacell.view.enroll') }}" class="action-btn"
                                    onclick="logFunction('Enrollments Full View');">
                                    <span class="icon">📝</span>
                                    <span class="text">Manage Enrollments</span>
                                </a>

                                <a href="{{ route('datacell.view.exam') }}" class="action-btn"
                                    onclick="logFunction('Exam Full View');">
                                    <span class="icon">🧪</span>
                                    <span class="text">Manage Exam Marks</span>
                                </a>

                                <a href="{{ route('datacell.view.result') }}" class="action-btn"
                                    onclick="logFunction('Full Subject Result View');">
                                    <span class="icon">📊</span>
                                    <span class="text">Manage Subject Result</span>
                                </a>

                                <a href="{{ route('degree_program') }}" class="action-btn"
                                    onclick="logFunction('Full Subject Result View');">
                                    <span class="icon">🎓</span>
                                    <span class="text">Manage Degree Program</span>
                                </a>

                                <a href="{{ route('parents.view') }}" class="action-btn"
                                    onclick="logFunction('Full Subject Result View');">
                                    <span class="icon">👪</span>
                                    <span class="text">Manage Parent Profile</span>
                                </a>

                                <a href="{{ route('promote') }}" class="action-btn"
                                    onclick="logFunction('Student Promotion Page');">
                                    <span class="icon">📈</span>
                                    <span class="text">Promote Students</span>
                                </a>
                                {{-- <a href="{{ route('Datacell.temp.enroll') }}" class="action-btn"
                                    onclick="logFunction('Approve Enrollments');">
                                    <span class="icon">✅</span>
                                    <span class="text">Approve Temporary Enrollments</span>
                                </a> --}}

                                <a href="{{ route('re_enroll.request') }}" class="action-btn"
                                    onclick="logFunction('Approve Improvements');">
                                    <span class="icon">🔁</span>
                                    <span class="text">Approve Re-Enrollments / Improvements</span>
                                </a>



                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-6 col-md-12 fade-in delay-300">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="actions-grid">


                                <a href="{{ route('datacell.notification') }}" class="action-btn"
                                    onclick="logFunction('Send Notification');">
                                    <span class="icon">📨</span>
                                    <span class="text">Send Notification</span>
                                </a>

                                <a href="{{ route('datacell.view.section') }}" class="action-btn"
                                    onclick="logFunction('Manage Section');">
                                    <span class="icon">📂</span>
                                    <span class="text">Manage Sections</span>
                                </a>

                                <a href="{{ route('datacell.user') }}" class="action-btn"
                                    onclick="logFunction('Manage User');">
                                    <span class="icon">👤</span>
                                    <span class="text">Manage Accounts</span>
                                </a>
                                <a href="{{ route('manage_staff') }}" class="action-btn"
                                    onclick="logFunction('Manage Staff Page');">
                                    <span class="icon">👔</span>
                                    <span class="text">Manage Staff</span>
                                </a>
                            </div>
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
        // Activity Log
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

        // Initial sample activity data
        const activities = [{
                action: "New student data uploaded",
                time: "Just now"
            },
            {
                action: "Exam results updated",
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
                action: "New enrollment approved",
                time: "5 hours ago"
            }
        ];

        function updateActivityFeed() {
            const feed = document.getElementById('activity-feed');
            if (feed) {
                feed.innerHTML = callLog.map(entry => `
                    <tr>
                        <td>${entry.name}</td>
                        <td>${entry.time}</td>
                    </tr>
                `).join('');
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Populate initial activity feed
            activities.forEach(activity => {
                callLog.push({
                    name: activity.action,
                    time: activity.time
                });
            });
            updateActivityFeed();

            // Initialize animations
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach(el => {
                el.style.opacity = '0';
            });

            setTimeout(() => {
                fadeElements.forEach(el => {
                    el.style.opacity = '1';
                });
            }, 100);

            // Simulate real-time updates
            setInterval(() => {
                const sampleActions = [
                    "New data entry detected",
                    "Course material updated",
                    "Grade submission received",
                    "System maintenance completed",
                    "New enrollment request"
                ];
                const randomAction = sampleActions[Math.floor(Math.random() * sampleActions.length)];
                logFunction(randomAction);
            }, 30000); // Update every 30 seconds
        });
    </script>
</body>

</html>
