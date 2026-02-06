<?php
$sections = array_keys($timetable);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #eef2ff, #dbeafe);
            color: #1e293b;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .max-w-6xl {
            max-width: 72rem;
        }
        .p-4 {
            padding: 1rem;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .md\:text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-center {
            text-align: center;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }

        .border {
            border-width: 1px;
        }

        .border-gray-400 {
            border-color: #9ca3af;
        }

        .p-2 {
            padding: 0.5rem;
        }

        .rounded {
            border-radius: 0.375rem;
        }

        .bg-gray-200 {
            background-color: #e5e7eb;
        }

        .bg-blue-600 {
            background-color: #2563eb;
        }

        .text-blue-600 {
            color: #2563eb;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .overflow-x-auto {
            overflow-x: auto;
        }

        .w-full {
            width: 100%;
        }

        .border-collapse {
            border-collapse: collapse;
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

        /* Enhanced styles */
        .timetable-header {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            padding: 1.5rem 1rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            margin-bottom: 1.5rem;
        }

        .section-dropdown {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 0.75rem;
            transition: all 0.2s ease;
        }

        .section-dropdown:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .section-dropdown select {
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            padding: 0.5rem;
            background-color: #f0f9ff;
            transition: all 0.2s ease;
        }

        .section-dropdown select:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }

        .section-title {
            font-weight: 600;
            color: #1e40af;
            border-bottom: 2px solid #3b82f6;
            display: inline-block;
            padding-bottom: 0.375rem;
            margin-bottom: 1rem;
        }

        .timetable-container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .timetable-container table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .timetable-container th {
            background-color: #2563eb;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.025em;
            padding: 0.75rem 0.5rem;
        }

        .timetable-container th:first-child {
            background-color: #1e40af;
        }

        .timetable-container td {
            border: 1px solid #e2e8f0;
            padding: 0.75rem 0.5rem;
            transition: all 0.15s ease;
        }

        .timetable-container td:first-child {
            background-color: #f8fafc;
            font-weight: 600;
            color: #334155;
        }

        .timetable-container tr:nth-child(4) td {
            background-color: #f0f9ff;
        }

        .timetable-container tr:nth-child(4) td:first-child {
            background-color: #e0f2fe;
        }

        .class-details {
            padding: 0.25rem;
            border-radius: 0.25rem;
            transition: all 0.2s ease;
        }

        .class-details:hover {
            background-color: #f0f9ff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .class-name {
            font-weight: 600;
            color: #1d4ed8;
            margin-bottom: 0.25rem;
        }

        .class-teacher, .class-venue {
            font-size: 0.75rem;
            color: #64748b;
        }

        /* New Sticky Top Bar Styles */
        .sticky-top-container {
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .sticky-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1.5rem;
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
        }

        /* Footer styles */
        .footer {
            margin-top: auto;
            background-color: #1e40af;
            color: white;
            padding: 1rem 0;
            width: 100%;
        }

        .footer-content {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0.5rem 0;
        }

        .footer-copyright {
            font-size: 0.875rem;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .text-2xl {
                font-size: 1.25rem;
            }

            .md\:text-3xl {
                font-size: 1.5rem;
            }

            .text-lg {
                font-size: 1rem;
            }

            .p-4 {
                padding: 0.5rem;
            }

            .mb-6 {
                margin-bottom: 1rem;
            }

            .mb-4 {
                margin-bottom: 0.5rem;
            }

            .mb-2 {
                margin-bottom: 0.25rem;
            }

            .mr-2 {
                margin-right: 0.25rem;
            }

            .p-2 {
                padding: 0.25rem;
            }

            .timetable-container th, 
            .timetable-container td {
                padding: 0.5rem 0.25rem;
                font-size: 0.75rem;
            }

            .class-name {
                font-size: 0.75rem;
            }

            .class-teacher, .class-venue {
                font-size: 0.65rem;
            }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('sectionDropdown').addEventListener('change', filterTimetable);
        });

        function filterTimetable() {
            let selectedSection = document.getElementById('sectionDropdown').value;

            document.querySelectorAll('.section-table').forEach(table => {
                let tableSection = table.dataset.section;
                
                if (selectedSection === 'all' || tableSection === selectedSection) {
                    table.style.display = '';
                    table.classList.add('animate-fade-in');
                } else {
                    table.style.display = 'none';
                }
            });
        }
    </script>
</head>

<body class="bg-blue-50">
    <!-- New Top Bar -->
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

    <div class="max-w-6xl mx-auto p-4">
        <div class="timetable-header animate-fade-in">
            <h2 class="text-2xl md:text-3xl font-bold text-center text-white mb-2">Academic Timetable</h2>
            <p class="text-blue-100 text-center text-sm">Your weekly class schedule</p>
        </div>

        <!-- Section Dropdown -->
        <div class="flex justify-center mb-6">
            <div class="section-dropdown flex items-center">
                <i class="fas fa-filter text-blue-500 mr-3"></i>
                <label for="sectionDropdown" class="mr-2 font-semibold text-lg">Select Section:</label>
                <select id="sectionDropdown" class="border p-2 rounded">
                    <option value="all">All Sections</option>
                    @foreach($sections as $section)
                    <option value="{{ $section }}">{{ $section }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="container mx-auto p-4">
            @foreach($timetable as $section => $schedule)
            <div class="section-table mb-8" data-section="{{ $section }}">
                <h3 class="section-title text-lg font-bold text-center mb-2">{{ $section }}</h3>
                <div class="timetable-container">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-400 text-center">
                            <thead>
                                <tr>
                                    <th class="border border-gray-400 p-2"></th>
                                    <th class="border border-gray-400 p-2">Monday</th>
                                    <th class="border border-gray-400 p-2">Tuesday</th>
                                    <th class="border border-gray-400 p-2">Wednesday</th>
                                    <th class="border border-gray-400 p-2">Thursday</th>
                                    <th class="border border-gray-400 p-2">Friday</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $timeSlots = [
                                '8:30 - 9:30', '9:30 - 10:30', '10:30 - 11:30', '11:30 - 12:30',
                                '2:00 - 3:00', '3:00 - 4:00', '4:00 - 5:00', '5:00 - 6:00'
                                ];
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                                $formattedSchedule = [];
                                foreach ($schedule as $class) {
                                    // Skip 12:30 - 1:30 lunch break slot
                                    if ($class['time'] === '12:30 - 1:30') {
                                        continue;
                                    }
                                    $teacherData = ($class['teacher'] == 'N/A') ? ($class['junior_lecturer'] ?? 'N/A') : (($class['junior_lecturer'] == 'N/A') ? ($class['teacher'] ?? 'N/A') : $class['teacher'] . ', ' . $class['junior_lecturer']);
                                    $formattedSchedule[$class['time']][$class['day']] = [
                                        'description' => $class['description'],
                                        'teacher' => $teacherData,
                                        'venue' => $class['venue']
                                    ];
                                }
                                @endphp

                                @foreach($timeSlots as $time)
                                <tr>
                                    <td class="border border-gray-400 p-2 font-bold">
                                        {{ $time }}
                                    </td>
                                    @foreach($days as $day)
                                    <td class="border border-gray-400 p-2">
                                        @if(isset($formattedSchedule[$time][$day]))
                                        <div class="class-details">
                                            <div class="class-name">{{ $formattedSchedule[$time][$day]['description'] }}</div>
                                            <div class="class-teacher">
                                                <i class="fas fa-user-tie text-blue-500 mr-1"></i>
                                                {{ $formattedSchedule[$time][$day]['teacher'] }}
                                            </div>
                                            <div class="class-venue">
                                                <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                                                {{ $formattedSchedule[$time][$day]['venue'] }}
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- New Footer -->
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