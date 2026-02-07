<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporary Enrolments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: #2563eb; /* Changed to blue for consistency */
            --secondary-color: #f8fafc;
            --border-color: #e2e8f0;
            --text-color: #1e293b;
            --accent-color: #3b82f6;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }

        .sticky-top-container {
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .sticky-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .content {
            flex: 1;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }

        .student-card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .student-info {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-weight: 600;
            color: var(--text-color);
        }

        .program-info {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary-color);
            padding: 0.5rem 0;
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 1.5rem;
        }

        .session-container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .session-header {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 1rem;
        }

        .subjects-table-wrapper {
            overflow-x: auto;
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
        }

        .subjects-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .subjects-table th {
            background-color: var(--secondary-color);
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-color);
            border-bottom: 1px solid var(--border-color);
        }

        .subjects-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .subjects-table tr:last-child td {
            border-bottom: none;
        }

        .gpa-info {
            display: flex;
            gap: 2rem;
            margin-top: 1rem;
        }

        .gpa-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .gpa-label {
            font-weight: 600;
            color: var(--text-color);
        }

        .gpa-value {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.125rem;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 8rem;
            color: rgba(203, 213, 225, 0.3);
            font-weight: bold;
            text-align: center;
            pointer-events: none;
            z-index: -1;
            white-space: nowrap;
        }

        .footer {
            background-color: white;
            padding: 1.5rem 0;
            border-top: 1px solid var(--border-color);
        }

        .footer-content {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .footer-copyright {
            font-size: 0.875rem;
            color: #64748b;
        }

        @media (max-width: 768px) {
            .content {
                padding: 1rem;
            }

            .student-info {
                grid-template-columns: 1fr;
            }

            .gpa-info {
                flex-direction: column;
                gap: 0.5rem;
            }

            .watermark {
                font-size: 5rem;
            }
        }

        @media (max-width: 480px) {
            .sticky-top-bar {
                padding: 1rem;
            }

            .session-container {
                padding: 1rem;
            }

            .subjects-table th,
            .subjects-table td {
                padding: 0.5rem;
            }
        }
    </style>
    <script>
        let enrollments = [];
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
    </script>
</head>
<body class="min-h-screen flex flex-col">
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

    <div class="content">
        <div class="watermark">LMS</div>

        <div class="student-card">
            <div class="student-info">
                <div class="info-item">
                    <span class="info-label">Name</span>
                    <span class="info-value">{{ $student['name'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Father's Name</span>
                    <span class="info-value">{{ $student['guardian'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Registration No</span>
                    <span class="info-value">{{ $student['RegNo'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date of Birth</span>
                    <span class="info-value">
                        {{ \Carbon\Carbon::parse($student['date_of_birth'])->format('d-m-Y') ?? 'N/A' }}
                    </span>
                </div>
            </div>

            <div class="program-info">
                Program: {{ $program['description'] ?? 'N/A' }}
            </div>
        </div>

        @foreach ($sessionResults as $session)
            <div class="session-container">
                <div class="session-header">{{ $session['session_name'] ?? 'N/A' }}</div>

                <div class="subjects-table-wrapper">
                    <table class="subjects-table">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Course Code</th>
                                <th>Credit Hours</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($session['subjects'] ?? [] as $subject)
                                <tr>
                                    <td>{{ $subject['course_name'] ?? 'N/A' }}</td>
                                    <td>{{ $subject['course_code'] ?? 'N/A' }}</td>
                                    <td>{{ $subject['credit_hours'] ?? 'N/A' }}</td>
                                    <td>{{ $subject['grade'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="gpa-info">
                    <div class="gpa-item">
                        <span class="gpa-label">GPA:</span>
                        <span class="gpa-value">{{ $session['GPA'] ?? 'N/A' }}</span>
                    </div>
                    <div class="gpa-item">
                        <span class="gpa-label">Total Credit Points:</span>
                        <span class="gpa-value">{{ $session['total_credit_points'] ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        @endforeach
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
</body>
</html>