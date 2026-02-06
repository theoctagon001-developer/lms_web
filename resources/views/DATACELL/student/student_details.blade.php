<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Dashboard</title>
    @vite('resources/css/app.css')
    <style>
        .session-container {
            transition: all 0.3s ease-in-out;
        }
        .table-sm td, .table-sm th {
            font-size: 12px;
        }
        @media (max-width: 640px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
            .profile-info {
                flex-direction: column;
                align-items: flex-start;
            }
            .profile-info p {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            .tab-button {
                padding: 0.5rem;
                font-size: 0.875rem;
            }
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            .action-buttons a, .action-buttons button {
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-r from-blue-300 via-blue-200 to-blue-100 min-h-screen p-0 m-0">
    @include('DATACELL.partials.nav')
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-300 via-blue-200 to-blue-100 py-4 px-2 md:py-6 md:px-4">
        <div class="bg-white shadow-lg rounded-lg p-4 md:p-6 lg:p-8 w-full max-w-7xl mx-2">
            <!-- Profile Section -->
            <div class="flex flex-col items-center">
                <img src="{{ !empty($student['image']) ? $student['image'] : asset('images/male.png') }}"
                     alt="Profile Image"
                     class="w-24 h-24 md:w-32 md:h-32 lg:w-40 lg:h-40 rounded-full border-4 border-blue-500 shadow-md object-cover">
                <h2 class="text-xl md:text-2xl lg:text-3xl font-bold mt-3 text-center">{{ $student['name'] }}</h2>
                <p class="text-gray-600 text-sm md:text-base lg:text-lg">{{ $student['RegNo'] }}</p>
            </div>

            <!-- Student Information -->
            <div class="mt-4 md:mt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4 lg:gap-6 profile-grid">
                    <div class="flex justify-between profile-info">
                        <p class="text-sm md:text-base lg:text-lg font-semibold w-1/2">Father's Name:</p>
                        <p class="text-sm md:text-base lg:text-lg w-1/2 truncate">{{ $student['guardian'] }}</p>
                    </div>
                    <div class="flex justify-between profile-info">
                        <p class="text-sm md:text-base lg:text-lg font-semibold w-1/2">CGPA:</p>
                        <p class="text-sm md:text-base lg:text-lg w-1/2">{{ $student['cgpa'] }}</p>
                    </div>
                    <div class="flex justify-between profile-info">
                        <p class="text-sm md:text-base lg:text-lg font-semibold w-1/2">Gender:</p>
                        <p class="text-sm md:text-base lg:text-lg w-1/2">{{ $student['gender'] }}</p>
                    </div>
                    <div class="flex justify-between profile-info">
                        <p class="text-sm md:text-base lg:text-lg font-semibold w-1/2">Date of Birth:</p>
                        <p class="text-sm md:text-base lg:text-lg w-1/2">{{ $student['date_of_birth'] }}</p>
                    </div>
                    <div class="flex justify-between profile-info">
                        <p class="text-sm md:text-base lg:text-lg font-semibold mr-2 w-1/2">Program:</p>
                        <p class="text-sm md:text-base lg:text-lg w-1/2 truncate">{{ $student['program']['name'] }}</p>
                    </div>
                    <div class="flex justify-between profile-info">
                        <p class="text-sm md:text-base lg:text-lg font-semibold w-1/2">Section</p>
                        <p class="text-sm md:text-base lg:text-lg w-1/2">{{ $student['section']['semester'] }}{{ $student['section']['group'] }}</p>
                    </div>
                    <div class="flex justify-between profile-info">
                        <p class="text-sm md:text-base lg:text-lg font-semibold w-1/2">Session:</p>
                        <p class="text-sm md:text-base lg:text-lg w-1/2">{{ $student['session']['name'] }} - {{ $student['session']['year'] }}</p>
                    </div>
                    <div class="flex justify-between profile-info">
                        <p class="text-sm md:text-base lg:text-lg font-semibold w-1/2">Program Description:</p>
                        <p class="text-sm md:text-base lg:text-lg w-1/2 truncate">{{ $student['program']['description'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 md:mt-6 lg:mt-8 flex flex-col sm:flex-row justify-center gap-2 md:gap-4 action-buttons">
                <a href="{{ route('datacell.transcript.view', ['student_id' => $student['id']]) }}"
                   class="w-full sm:w-auto px-4 py-2 md:px-5 md:py-2 text-sm md:text-base bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition text-center">
                    View Transcript
                </a>
                <button onclick="downloadTranscript({{ $student['id'] }})"
                        class="w-full sm:w-auto px-4 py-2 md:px-5 md:py-2 text-sm md:text-base bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition">
                    Download Transcript
                </button>
            </div>

            <!-- Enrollments Section -->
            <div class="mt-4 md:mt-6 lg:mt-8">
                <div class="flex justify-center border-b-2 border-gray-200">
                    <button class="tab-button px-3 py-2 md:px-4 md:py-2 text-sm md:text-base lg:text-lg font-semibold text-blue-600 border-b-4 border-blue-600 focus:outline-none"
                            onclick="showTab('current')">
                        Current Enrollments
                    </button>
                    <button class="tab-button px-3 py-2 md:px-4 md:py-2 text-sm md:text-base lg:text-lg font-semibold text-gray-600 hover:text-blue-600 border-b-4 border-transparent hover:border-blue-600 focus:outline-none"
                            onclick="showTab('previous')">
                        Previous Enrollments
                    </button>
                </div>

                <!-- Current Enrollments Tab -->
                <div id="current" class="tab-content mt-3 md:mt-4">
                    <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-blue-700 mb-2 md:mb-4 text-center">Registration Form</h2>

                    <div id="current-summary" class="bg-white p-3 md:p-4 lg:p-6 rounded-lg shadow-md mb-3 md:mb-4 border border-gray-300">
                        <div class="flex justify-between items-center mb-1 md:mb-2">
                            <span class="text-sm md:text-base font-bold text-gray-700">Total Credit Hours:</span>
                            <span id="total-credit-hours" class="text-sm md:text-base italic text-gray-600">0</span>
                        </div>
                        <div class="flex justify-between items-center mb-1 md:mb-2">
                            <span class="text-sm md:text-base font-bold text-gray-700">Session:</span>
                            <span id="current-session" class="text-sm md:text-base italic text-gray-600">{{ $student['session']['name'] }} - {{ $student['session']['year'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm md:text-base font-bold text-gray-700">Current Section:</span>
                            <span id="current-section" class="text-sm md:text-base italic text-gray-600">N/A</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300 text-xs md:text-sm">
                            <thead>
                                <tr class="bg-blue-500 text-white">
                                    <th class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5 lg:px-3 lg:py-2">Course No.</th>
                                    <th class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5 lg:px-3 lg:py-2">Credits</th>
                                    <th class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5 lg:px-3 lg:py-2">Title</th>
                                    <th class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5 lg:px-3 lg:py-2">Section</th>
                                    <th class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5 lg:px-3 lg:py-2">Short</th>
                                    <th class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5 lg:px-3 lg:py-2">Type</th>
                                    <th class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5 lg:px-3 lg:py-2">Teacher</th>
                                    <th class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5 lg:px-3 lg:py-2">Lab</th>
                                </tr>
                            </thead>
                            <tbody id="current-enrollments">
                                <tr>
                                    <td colspan="8" class="text-center p-2 md:p-4 text-gray-500">Loading...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Previous Enrollments Tab -->
                <div id="previous" class="tab-content mt-3 md:mt-4 hidden">
                    <div class="container mx-auto p-2 md:p-4 lg:p-6">
                        <h2 class="text-center text-lg md:text-xl lg:text-2xl font-bold text-gray-800 mb-3 md:mb-4 lg:mb-6">Previous Enrollments</h2>

                        <!-- Search Bar -->
                        <div class="mb-3 md:mb-4">
                            <input type="text" id="searchSessions"
                                   class="w-full px-3 py-2 md:px-4 md:py-2 text-sm md:text-base border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                   placeholder="Search by Session...">
                        </div>

                        <div id="previousEnrollmentsContainer" class="space-y-3 md:space-y-4">
                            <div class="text-center text-gray-500">Loading previous enrollments...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global API URL configuration
        let API_BASE_URL = "http://192.168.1.13:8000/";

        // Tab Management
        function showTab(tab) {
            document.getElementById('current').classList.add('hidden');
            document.getElementById('previous').classList.add('hidden');
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('text-blue-600', 'border-blue-600');
                btn.classList.add('text-gray-600', 'hover:text-blue-600', 'border-transparent', 'hover:border-blue-600');
            });

            document.getElementById(tab).classList.remove('hidden');
            event.currentTarget.classList.add('text-blue-600', 'border-blue-600');

            // If showing previous tab and it's empty, try fetching again
            if (tab === 'previous' && document.getElementById('previousEnrollmentsContainer').innerText.includes('Loading')) {
                fetchCurrentEnrollments();
            }
        }

        // API Base URL Helper
        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        // Transcript Download
        async function downloadTranscript(studentId) {
            try {
                let API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Students/TranscriptPDF?student_id=${studentId}`);

                if (!response.ok) {
                    throw new Error("Failed to fetch transcript.");
                }

                const blob = await response.blob();
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = `Transcript_${studentId}.pdf`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(link.href);
            } catch (error) {
                console.error("Error downloading transcript:", error);
                alert("Failed to download transcript.");
            }
        }
        async function fetchCurrentEnrollments() {
            try {
                const API_BASE_URL = await getApiBaseUrl();
                const studentId = {{ $student['id'] }};
                const response = await fetch(`${API_BASE_URL}api/Students/getAllEnrollments?student_id=${studentId}`);
                const data = await response.json();

                console.log('API Response:', data);

                if (data.success) {
                    if (data.CurrentCourses) {
                        displayCurrentEnrollments(data.CurrentCourses);
                    }
                    if (data.PreviousCourses) {
                        renderPreviousEnrollments(data.PreviousCourses);
                    }
                } else {
                    throw new Error("Failed to fetch enrollments");
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById("current-enrollments").innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center p-2 md:p-4 text-red-500">Error loading data</td>
                    </tr>`;
                document.getElementById("previousEnrollmentsContainer").innerHTML = `
                    <div class="text-center text-red-500">Error loading previous enrollments</div>`;
            }
        }

        // Display Current Enrollments
        function displayCurrentEnrollments(courses) {
            const tableBody = document.getElementById("current-enrollments");

            if (!Array.isArray(courses) || courses.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center p-2 md:p-4 text-gray-500">No current enrollments found</td>
                    </tr>`;
                return;
            }

            let totalCreditHours = 0;
            let sectionCounts = {};
            tableBody.innerHTML = "";

            courses.forEach(course => {
                totalCreditHours += course.credit_hours || 0;
                sectionCounts[course.section] = (sectionCounts[course.section] || 0) + 1;

                tableBody.innerHTML += `
                    <tr class="border border-gray-300 text-center hover:bg-gray-50">
                        <td class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5">${course.course_code || 'N/A'}</td>
                        <td class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5">${course.credit_hours || 0}</td>
                        <td class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5">${course.course_name || 'N/A'}</td>
                        <td class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5">${course.section || 'N/A'}</td>
                        <td class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5">${course["Short Form"] || 'N/A'}</td>
                        <td class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5">${course.Type || 'N/A'}</td>
                        <td class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5 truncate max-w-xs">${course.teacher_name || 'N/A'}</td>
                        <td class="border border-gray-300 px-1 py-1 md:px-2 md:py-1.5">${course.Is === 'Lab' ? 'Yes' : 'No'}</td>
                    </tr>`;
            });

            // Update summary
            document.getElementById("total-credit-hours").textContent = totalCreditHours;
            const mostFrequentSection = Object.keys(sectionCounts).reduce((a, b) =>
                sectionCounts[a] > sectionCounts[b] ? a : b, "N/A");
            document.getElementById("current-section").textContent = mostFrequentSection;
        }

        // Render Previous Enrollments
        function renderPreviousEnrollments(enrollments) {
            const container = document.getElementById("previousEnrollmentsContainer");

            if (!enrollments || Object.keys(enrollments).length === 0) {
                container.innerHTML = `
                    <div class="bg-white shadow-lg rounded-lg p-4 text-center text-red-500">
                        No previous enrollments found
                    </div>`;
                return;
            }

            container.innerHTML = "";

            Object.entries(enrollments).forEach(([session, courses]) => {
                const sessionId = session.replace(/\s+/g, '');
                const totalCreditHours = courses.reduce((sum, course) => sum + (course.credit_hours || 0), 0);

                let coursesHTML = '';
                courses.forEach(course => {
                    const resultInfo = course["result Info"] || {};
                    const resultTable = `
                        <table class="w-full text-xs text-gray-700 border border-gray-300 bg-gray-200 rounded-lg">
                            <tr class="border-b"><th class="px-1 py-0.5 border">Mid</th><td class="px-1 py-0.5">${resultInfo.mid ?? "N/A"}</td></tr>
                            <tr class="border-b"><th class="px-1 py-0.5 border">Final</th><td class="px-1 py-0.5">${resultInfo.final ?? "N/A"}</td></tr>
                            <tr class="border-b"><th class="px-1 py-0.5 border">Internal</th><td class="px-1 py-0.5">${resultInfo.internal ?? "N/A"}</td></tr>
                            <tr class="border-b"><th class="px-1 py-0.5 border">Lab</th><td class="px-1 py-0.5">${resultInfo.lab ?? "N/A"}</td></tr>
                            <tr class="border-b"><th class="px-1 py-0.5 border">Grade</th><td class="px-1 py-0.5">${resultInfo.grade ?? "N/A"}</td></tr>
                            <tr><th class="px-1 py-0.5 border">QP</th><td class="px-1 py-0.5">${resultInfo.quality_points ?? "N/A"}</td></tr>
                        </table>
                    `;

                    coursesHTML += `
                        <tr class="hover:bg-gray-100 transition">
                            <td class="px-1 py-1 md:px-2 md:py-1.5 border truncate max-w-xs">${course.course_name || 'N/A'}</td>
                            <td class="px-1 py-1 md:px-2 md:py-1.5 border">${course.course_code || 'N/A'}</td>
                            <td class="px-1 py-1 md:px-2 md:py-1.5 border">${course.credit_hours || 0}</td>
                            <td class="px-1 py-1 md:px-2 md:py-1.5 border">${course.Type || 'N/A'}</td>
                            <td class="px-1 py-1 md:px-2 md:py-1.5 border">${course["Short Form"] || 'N/A'}</td>
                            <td class="px-1 py-1 md:px-2 md:py-1.5 border">${course["Pre-Requisite/Main"] || 'N/A'}</td>
                            <td class="px-1 py-1 md:px-2 md:py-1.5 border">${course.section || 'N/A'}</td>
                            <td class="px-1 py-1 md:px-2 md:py-1.5 border truncate max-w-xs">${course.teacher_name || 'N/A'}</td>
                            <td class="px-1 py-1 md:px-2 md:py-1.5 border">${course.Is === 'Lab' ? 'Yes' : 'No'}</td>
                            <td class="px-1 py-1 md:px-2 md:py-1.5 border">${resultTable}</td>
                        </tr>
                    `;
                });

                container.innerHTML += `
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-300 session-container">
                        <button class="w-full text-left px-3 py-2 md:px-4 md:py-3 bg-blue-600 text-white font-semibold text-sm md:text-base flex justify-between items-center"
                                onclick="toggleSession('${sessionId}')">
                            <span>${session} (Credits: ${totalCreditHours})</span>
                            <span class="text-base md:text-lg">▼</span>
                        </button>
                        <div id="${sessionId}" class="hidden p-2 md:p-4 lg:p-6 bg-gray-100">
                            <div class="overflow-x-auto">
                                <table class="w-full text-xs md:text-sm text-left text-gray-700 border border-gray-300 rounded-lg">
                                    <thead class="bg-gray-300 text-gray-800 uppercase font-semibold">
                                        <tr>
                                            <th class="px-1 py-1 md:px-2 md:py-1.5 border">Course</th>
                                            <th class="px-1 py-1 md:px-2 md:py-1.5 border">Code</th>
                                            <th class="px-1 py-1 md:px-2 md:py-1.5 border">Credits</th>
                                            <th class="px-1 py-1 md:px-2 md:py-1.5 border">Type</th>
                                            <th class="px-1 py-1 md:px-2 md:py-1.5 border">Short</th>
                                            <th class="px-1 py-1 md:px-2 md:py-1.5 border">Pre-Req</th>
                                            <th class="px-1 py-1 md:px-2 md:py-1.5 border">Sec</th>
                                            <th class="px-1 py-1 md:px-2 md:py-1.5 border">Teacher</th>
                                            <th class="px-1 py-1 md:px-2 md:py-1.5 border">Lab</th>
                                            <th class="px-1 py-1 md:px-2 md:py-1.5 border">Result</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-300">
                                        ${coursesHTML}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        // Toggle Session Visibility
        function toggleSession(sessionId) {
            const sessionDiv = document.getElementById(sessionId);
            sessionDiv.classList.toggle("hidden");

            // Update the arrow icon
            const button = sessionDiv.previousElementSibling;
            const arrow = button.querySelector('span:last-child');
            arrow.textContent = sessionDiv.classList.contains('hidden') ? '▼' : '▲';
        }

        // Search Functionality
        function setupSearch() {
            const searchInput = document.getElementById("searchSessions");
            if (!searchInput) return;

            searchInput.addEventListener("input", function() {
                const filter = this.value.toLowerCase();
                document.querySelectorAll("#previousEnrollmentsContainer > div").forEach(session => {
                    const sessionName = session.querySelector("button span:first-child").textContent.toLowerCase();
                    session.style.display = sessionName.includes(filter) ? "" : "none";
                });
            });
        }

        // Initialize the page
        document.addEventListener("DOMContentLoaded", function() {
            fetchCurrentEnrollments();
            setupSearch();
        });
    </script>
</body>
</html>
