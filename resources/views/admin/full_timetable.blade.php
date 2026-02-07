<?php
$sections = array_keys($timetable);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Base styles */
        body {
            font-family: 'Inter', sans-serif;
        }

        .max-w-6xl {
            max-width: 72rem; /* Adjust container width */
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
            }
            to {
                opacity: 1;
            }
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

            /* Make dropdown full-width on mobile */
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

            /* Adjust table layout for mobile */
            table {
                font-size: 0.5rem; /* Reduce font size for better fit */
            }

            th, td {
                padding: 0.2rem; /* Reduce padding for smaller screens */
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
                table.style.display = (selectedSection === 'all' || tableSection === selectedSection) ? '' : 'none';
            });
        }
    </script>
</head>

<body class="bg-blue-50">
    @include('admin.navbar', [
        'username' => session('username', 'Guest'),
        'profileImage' => session('profileImage', asset('images/male.png')),
        'designation' => session('designation', 'N/A'),
        'type' => session('userType', 'User')
    ])

    <div class="max-w-6xl mx-auto p-4">
        <h2 class="text-2xl md:text-3xl font-bold text-center text-blue-600 mb-6 animate-fade-in">Timetable</h2>

        <!-- Section Dropdown -->
        <div class="flex justify-center mb-6">
            <label for="sectionDropdown" class="mr-2 font-semibold text-lg">Select Section:</label>
            <select id="sectionDropdown" class="border p-2 rounded">
                <option value="all">All Sections</option>
                @foreach($sections as $section)
                <option value="{{ $section }}">{{ $section }}</option>
                @endforeach
            </select>
        </div>

        <div class="container mx-auto p-4">
            <h2 class="text-xl font-bold text-center mb-4">Full Timetable</h2>

            @foreach($timetable as $section => $schedule)
            <div class="mb-8 section-table" data-section="{{ $section }}">
                <h3 class="text-lg font-bold text-center mb-2">{{ $section }}</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-400 text-center">
                        <thead>
                            <tr class="bg-gray-200">
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
                            '8:30 - 9:30', '9:30 - 10:30', '10:30 - 11:30', '11:30 - 12:30', '12:30 - 1:30',
                            '2:00 - 3:00', '3:00 - 4:00', '4:00 - 5:00', '5:00 - 6:00'
                            ];
                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                            $formattedSchedule = [];
                            foreach ($schedule as $class) {
                            $teacherData = ($class['teacher'] == 'N/A') ? ($class['junior_lecturer'] ?? 'N/A') : (($class['junior_lecturer'] == 'N/A') ? ($class['teacher'] ?? 'N/A') : $class['teacher'] . ', ' . $class['junior_lecturer']);
                            $teacherData = $class['description'] . ' _( ' . $teacherData . ' )_ ' . $class['venue'];
                            $formattedSchedule[$class['time']][$class['day']] = $teacherData;
                            }
                            @endphp

                            @foreach($timeSlots as $time)
                            <tr>
                                <td class="border border-gray-400  p-2 font-bold">{{ $time }}</td>
                                @foreach($days as $day)
                                <td class="border border-gray-400 p-2">{{ $formattedSchedule[$time][$day] ?? '' }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
