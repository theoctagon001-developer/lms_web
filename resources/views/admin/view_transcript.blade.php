<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporary Enrolments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: #015d05;
            --secondary-color: #f2f2f2;
            --border-color: #ddd;
            --text-color: #333;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: clamp(20px, 5vw, 28px);
            color: var(--primary-color);
        }

        .header h2 {
            margin: 0;
            font-size: clamp(16px, 4vw, 20px);
        }

        .content {
            flex: 1;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }

        .student-info {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .student-info tr {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 8px;
        }

        .student-info td {
            padding: 5px;
            flex: 1 1 300px;
        }

        .session-container {
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
           background: transparent
        }

        .subjects-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            overflow-x: auto;
        }

        .subjects-table-wrapper {
            overflow-x: auto;
            margin-bottom: 15px;
        }

        .subjects-table th, .subjects-table td {
            border: 1px solid var(--border-color);
            padding: 8px;
            text-align: left;
        }

        .subjects-table th {
            background-color: var(--secondary-color);
            position: sticky;
            top: 0;
        }

        .session-header {
            margin-bottom: 15px;
            font-weight: bold;
            font-size: clamp(16px, 4vw, 18px);
            color: var(--primary-color);
            padding-bottom: 8px;
            border-bottom: 2px solid var(--primary-color);
        }

        .gpa-info {
            margin-top: 15px;
            font-weight: bold;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .gpa-info p {
            margin: 5px 0;
        }

        /* Watermark Style */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: clamp(60px, 15vw, 120px);
            color: rgba(0, 0, 0, 0.1);
            font-weight: bold;
            text-align: center;
            pointer-events: none;
            z-index: -1;
            white-space: nowrap;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content {
                padding: 15px;
            }

            .session-container {
                padding: 10px;
            }

            .subjects-table th, .subjects-table td {
                padding: 6px;
                font-size: 14px;
            }

            .student-info td {
                flex: 1 1 100%;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 10px;
            }

            .subjects-table th, .subjects-table td {
                padding: 4px;
                font-size: 13px;
            }

            .gpa-info {
                flex-direction: column;
                gap: 5px;
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
<body class="bg-gradient-to-r from-blue-200 via-blue-100 to-blue-100 min-h-screen flex flex-col">
    @include('admin.navbar', [
        'username' => session('username', 'Guest'),
        'profileImage' => session('profileImage', asset('images/male.png')),
        'designation' => session('designation', 'N/A'),
        'type' => session('userType', 'User')
    ])
    <div class="content">
        <div class="watermark">L M S</div>

        <table class="student-info">
            <tr>
                <td>Name:<strong> {{ $student['name'] ?? 'N/A' }}</strong></td>
                <td>Father's Name:<strong> {{ $student['guardian'] ?? 'N/A' }}</strong></td>
            </tr>
            <tr>
                <td>Registration No: <strong>{{ $student['RegNo'] ?? 'N/A' }}</strong></td>
               <td>Date of Birth:
  <strong>
    {{ \Carbon\Carbon::parse($student['date_of_birth'])->format('d-m-Y') ?? 'N/A' }}
  </strong>
</td>

            </tr>
        </table>

        <p>Program: <strong>{{ $program['description'] ?? 'N/A' }}</strong></p>

        @foreach ($sessionResults as $session)
            <div class="session-container">
                <div class="session-header">Session: {{ $session['session_name'] ?? 'N/A' }}</div>

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
                    <p><strong>GPA:</strong> {{ $session['GPA'] ?? 'N/A' }}</p>
                    <p><strong>Total Credit Points:</strong> {{ $session['total_credit_points'] ?? 'N/A' }}</p>
                </div>
            </div>
        @endforeach
    </div>
    @include('components.footer')
</body>
</html>
