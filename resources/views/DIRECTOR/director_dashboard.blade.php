<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Director Dashboard | LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Core styling with enhanced visual elements */
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column; /* For footer at bottom */
        }

        /* Main content container with reduced side spacing */
        .main-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.5rem 1rem; /* Reduced side padding */
            flex: 1 0 auto; /* For footer positioning */
        }

        /* Sticky top bar styling from original code */
        .sticky-top-container {
            position: sticky;
            top: 0;
            z-index: 40;
            background: white;
        }

        .sticky-top-bar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Welcome card styling from original code */
        .welcome-card {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.5);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 240px;
        }

        .welcome-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .welcome-text {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 24px;
        }

        .session-info {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 12px 16px;
            border-radius: 12px;
            margin-top: auto;
        }

        .session-detail {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .session-detail:last-child {
            margin-bottom: 0;
        }

        .session-icon {
            margin-right: 12px;
            font-size: 18px;
        }

        /* Stats card styling from original code */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .stat-card {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            flex-shrink: 0;
        }

        .stat-content {
            flex-grow: 1;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 14px;
            color: #6b7280;
        }

        /* Enhanced quick action styling with REDUCED SPACING */
        .section-divider {
            position: relative;
            height: 40px; /* Further reduced */
            margin: 16px 0; /* Further reduced */
            overflow: hidden;
        }

        .section-divider::before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 50%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.3), transparent);
        }

        .section-divider::after {
            content: attr(data-title);
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 0 20px;
            color: #3b82f6;
            font-weight: 600;
            font-size: 1.1rem;
            white-space: nowrap;
            box-shadow: 0 0 0 10px white;
        }

        .action-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(226, 232, 240, 0.8);
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 20px;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-height: 160px;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2);
            border-color: rgba(165, 180, 252, 0.5);
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #6366f1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .action-card:hover::before {
            opacity: 1;
        }

        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            font-size: 24px;
            color: white;
            background: linear-gradient(135deg, var(--icon-color-1), var(--icon-color-2));
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-name {
            font-size: 15px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 8px;
        }

        .card-description {
            font-size: 13px;
            color: #6b7280;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Slightly reduced card width */
            gap: 16px; /* Reduced gap */
        }

        /* Section spacing has been reduced */
        .section-content {
            margin-bottom: 24px; /* Further reduced */
        }

        /* Color variables */
        :root {
            --icon-blue-1: #3b82f6;
            --icon-blue-2: #2563eb;
            --icon-purple-1: #8b5cf6;
            --icon-purple-2: #7c3aed;
            --icon-green-1: #10b981;
            --icon-green-2: #059669;
            --icon-orange-1: #f59e0b;
            --icon-orange-2: #d97706;
            --icon-red-1: #ef4444;
            --icon-red-2: #dc2626;
            --icon-indigo-1: #6366f1;
            --icon-indigo-2: #4f46e5;
            --icon-teal-1: #14b8a6;
            --icon-teal-2: #0d9488;
            --icon-amber-1: #f59e0b;
            --icon-amber-2: #d97706;
        }

        /* Footer styling */
        .footer {
            flex-shrink: 0;
            background-color: #1e3a8a;
            color: white;
            padding: 1rem 0;
            text-align: center;
            margin-top: 2rem;
        }

        .footer-content {
            padding: 0.5rem 0;
        }

        .footer-copyright {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .welcome-card {
                min-height: auto;
            }
        }

        @media (max-width: 576px) {
            .cards-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* SVG icon styling */
        .svg-icon {
            width: 24px;
            height: 24px;
            fill: currentColor;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Top Bar from original code -->
    <div class="sticky-top-container">
        <div class="sticky-top-bar">
            <div class="flex items-center">
                <h1 class="text-xl font-bold text-blue-600">
                    Director <span class="hidden sm:inline">Dashboard</span>
                </h1>
            </div>
            @include('DIRECTOR.Profile')
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Welcome Card and Stats from original code -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="welcome-card">
                <div>
                    <h1 class="welcome-title">Welcome, {{ session('username', 'Director') }}</h1>
                    <p class="welcome-text">Manage your institution with real-time insights and powerful tools</p>
                </div>
                <div class="session-info">
                    <div class="session-detail">
                        <span class="session-icon">🚀</span>
                        <span>Current Session: {{ session('currentSession', 'Spring 2025') }}</span>
                    </div>
                    <div class="session-detail">
                        <span class="session-icon">🏛️</span>
                        <span>Session Start: {{ session('startDate', 'Jan 15, 2025') }}</span>
                    </div>
                    <div class="session-detail">
                        <span class="session-icon">🎓</span>
                        <span>Session End: {{ session('endDate', 'May 30, 2025') }}</span>
                    </div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-blue-500">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M12 3L1 9l11 6 9-4.91V17h2V9M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ session('faculty_count', '42') }}</div>
                        <div class="stat-label">Faculty Members</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-purple-500">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M12 3L1 9l11 6 9-4.91V17h2V9M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
                            <path d="M18 12l-5-3v6l5-3z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ session('student_count', '834') }}</div>
                        <div class="stat-label">Total Students</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-green-500">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ session('course_count', '28') }}</div>
                        <div class="stat-label">Active Courses</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-yellow-500">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM17.99 9l-1.41-1.42-6.59 6.59-2.58-2.57-1.42 1.41 4 3.99z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ session('offer_count', '156') }}</div>
                        <div class="stat-label">Pending Requests</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TIMETABLE, STUDENTS, AND STAFF IN ONE SECTION -->
        <div class="section-divider" data-title="Main Navigation"></div>
        
        <div class="section-content">
            <div class="cards-grid">
                <!-- Timetable Card -->
                <a href="{{ route('timetable.view') }}" class="action-card">
                    <div class="card-icon" style="--icon-color-1: var(--icon-blue-1); --icon-color-2: var(--icon-blue-2);">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM9 10H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm-8 4H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2z"/>
                        </svg>
                    </div>
                    <h3 class="card-name">View Timetable</h3>
                    <p class="card-description">Complete institutional schedule</p>
                    <div class="mt-3 text-blue-500 text-sm font-medium flex items-center justify-center">
                        <span>View Now</span>
                        <svg class="svg-icon ml-2" style="width: 14px; height: 14px;" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Students Card -->
                <a href="{{ route('Director.student') }}" class="action-card">
                    <div class="card-icon" style="--icon-color-1: var(--icon-green-1); --icon-color-2: var(--icon-green-2);">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                        </svg>
                    </div>
                    <h3 class="card-name">View Students</h3>
                    <p class="card-description">Browse all registered students</p>
                    <div class="mt-3 text-green-500 text-sm font-medium flex items-center justify-center">
                        <span>View Students</span>
                        <svg class="svg-icon ml-2" style="width: 14px; height: 14px;" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Faculty Card -->
                <a href="{{ route('Director.teachers') }}" class="action-card">
                    <div class="card-icon" style="--icon-color-1: var(--icon-indigo-1); --icon-color-2: var(--icon-indigo-2);">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <h3 class="card-name">View Faculty</h3>
                    <p class="card-description">Manage teaching staff</p>
                    <div class="mt-3 text-indigo-500 text-sm font-medium flex items-center justify-center">
                        <span>View Faculty</span>
                        <svg class="svg-icon ml-2" style="width: 14px; height: 14px;" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Excluded Days Card -->
                <a href="{{ route('Director.excludedDays') }}" class="action-card">
                    <div class="card-icon" style="--icon-color-1: var(--icon-orange-1); --icon-color-2: var(--icon-orange-2);">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM9 10H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm-8 4H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2z"/>
                            <path d="M17 13h-5v5h5v-5z" fill="white"/>
                        </svg>
                    </div>
                    <h3 class="card-name">Excluded Days</h3>
                    <p class="card-description">Set holidays and special days</p>
                    <div class="mt-3 text-orange-500 text-sm font-medium flex items-center justify-center">
                        <span>Manage Now</span>
                        <svg class="svg-icon ml-2" style="width: 14px; height: 14px;" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                
                <a href="{{ route('Director.auditdirector') }}" class="action-card">
                    <div class="card-icon" style="--icon-color-1: var(--icon-orange-1); --icon-color-2: var(--icon-orange-2);">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                        </svg>
                    </div>
                    <h3 class="card-name">Audit Report</h3>
                    <p class="card-description">See All Courses Audit Report</p>
                    <div class="mt-3 text-orange-500 text-sm font-medium flex items-center justify-center">
                        <span>Manage Now</span>
                        <svg class="svg-icon ml-2" style="width: 14px; height: 14px;" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Academic Management Section -->
        <div class="section-divider" data-title="Academic Management"></div>

        <div class="section-content">
            <div class="cards-grid">
                <!-- Academic Sessions -->
                <a href="{{ route('Director.session') }}" class="action-card">
                    <div class="card-icon" style="--icon-color-1: var(--icon-teal-1); --icon-color-2: var(--icon-teal-2);">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M17 10H7v2h10v-2zm2-7h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                        </svg>
                    </div>
                    <h3 class="card-name">Academic Sessions</h3>
                    <p class="card-description">Manage terms and semesters</p>
                    <div class="mt-3 text-teal-500 text-sm font-medium flex items-center justify-center">
                        <span>View Sessions</span>
                        <svg class="svg-icon ml-2" style="width: 14px; height: 14px;" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Course Content -->
                <a href="{{ route('Director.course_content') }}" class="action-card">
                    <div class="card-icon" style="--icon-color-1: var(--icon-amber-1); --icon-color-2: var(--icon-amber-2);">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M3 5v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.11 0-2 .9-2 2zm12 4c0 1.66-1.34 3-3 3s-3-1.34-3-3 1.34-3 3-3 3 1.34 3 3zm-9 8c0-2 4-3.1 6-3.1s6 1.1 6 3.1v1H6v-1z"/>
                        </svg>
                    </div>
                    <h3 class="card-name">Course Content</h3>
                    <p class="card-description">Review course materials</p>
                    <div class="mt-3 text-amber-500 text-sm font-medium flex items-center justify-center">
                        <span>View Content</span>
                        <svg class="svg-icon ml-2" style="width: 14px; height: 14px;" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Courses -->
                <a href="{{ route('Director.course') }}" class="action-card">
                    <div class="card-icon" style="--icon-color-1: var(--icon-red-1); --icon-color-2: var(--icon-red-2);">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                        </svg>
                    </div>
                    <h3 class="card-name">Courses</h3>
                    <p class="card-description">Browse course catalog</p>
                    <div class="mt-3 text-red-500 text-sm font-medium flex items-center justify-center">
                        <span>View Courses</span>
                        <svg class="svg-icon ml-2" style="width: 14px; height: 14px;" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Course Allocations -->
                <a href="{{ route('Director.course_allocation') }}" class="action-card">
                    <div class="card-icon" style="--icon-color-1: #ec4899; --icon-color-2: #db2777;">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            <path d="M19 7l-1.41-1.41L9 16.17 4.83 12l-1.42 1.41L9 19 21 7z"/>
                        </svg>
                    </div>
                    <h3 class="card-name">Course Allocations</h3>
                    <p class="card-description">Manage assignments</p>
                    <div class="mt-3 text-pink-500 text-sm font-medium flex items-center justify-center">
                        <span>View Allocations</span>
                        <svg class="svg-icon ml-2" style="width: 14px; height: 14px;" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                
                <a href="{{ route('Director.examdirector') }}" class="action-card">
                    <div class="card-icon" style="--icon-color-1: var(--icon-orange-1); --icon-color-2: var(--icon-orange-2);">
                        <svg class="svg-icon" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM12 7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zm-1 3.5h-1v-1h1v1zm1.5 0h-1v-1h1v1zm1.5 0h-1v-1h1v1z"/>
                        </svg>
                    </div>
                    <h3 class="card-name">Exam Details</h3>
                    <p class="card-description">See All Section Exam Details</p>
                    <div class="mt-3 text-orange-500 text-sm font-medium flex items-center justify-center">
                        <span>View Now</span>
                        <svg class="svg-icon ml-2" style="width: 14px; height: 14px;" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container mx-auto">
            <div class="footer-content">
                <div class="footer-copyright">
                    © Sharjeel | Ali | Sameer Learning Management System
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Add animation to cards when they come into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = "1";
                    entry.target.style.transform = "translateY(0)";
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.action-card').forEach(card => {
            card.style.opacity = "0";
            card.style.transform = "translateY(20px)";
            card.style.transition = "all 0.4s ease-out";
            observer.observe(card);
        });

        // Activity logging function
        function logFunction(name) {
            const actionName = name
                .replace(/([A-Z])/g, ' $1')
                .replace(/(\b\w)/g, firstChar => firstChar.toUpperCase())
                .trim();

            console.log(`Action logged: ${actionName} at ${new Date().toLocaleTimeString()}`);
        }

        // Add click event listeners to all action links
        document.querySelectorAll('a[href^="{{ route("]').forEach(link => {
            link.addEventListener('click', function() {
                const action = this.querySelector('.card-name').textContent;
                logFunction(action);
            });
        });
    </script>
</body>
</html>