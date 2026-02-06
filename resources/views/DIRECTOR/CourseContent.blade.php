<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Content | LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Core styling with enhanced visual elements */
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            min-height: 100vh;
        }

        /* Sticky top bar styling from director dashboard */
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

        /* Main content container */
        .main-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        /* Card styling */
        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Form elements */
        .form-select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background-color: white;
            transition: all 0.2s;
        }

        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            text-align: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        /* Content items */
        .week-section {
            background-color: #f9fafb;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .week-title {
            color: #1e40af;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .content-item {
            background-color: white;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .content-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .content-type {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .type-notes {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .type-assignment {
            background-color: #f0fdf4;
            color: #166534;
        }

        .type-quiz {
            background-color: #fef2f2;
            color: #991b1b;
        }

        /* PDF Viewer Modal */
        .pdf-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 12px;
            width: 90%;
            max-width: 900px;
            max-height: 90vh;
            overflow: hidden;
        }

        .modal-header {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 0;
            height: calc(90vh - 60px);
        }

        /* Footer styling */
        .footer {
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 1.5rem 0;
            margin-top: 3rem;
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

        /* Loader animation */
        .loader {
            border: 4px solid #e5e7eb;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 2rem auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .main-container {
                padding: 0 1rem;
            }
            
            .content-card {
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Director Dashboard Top Bar -->
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

    <!-- Main Content -->
    <div class="main-container">
        <div class="content-card">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Course Content</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Select Course:</label>
                    <select id="courseDropdown" class="form-select">
                        <option value="">Select Course</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Select Session:</label>
                    <select id="sessionDropdown" class="form-select">
                        <option value="">Select Session</option>
                    </select>
                </div>
            </div>

            <button id="loadButton" class="btn btn-primary w-full">
                Load Content
            </button>

            <!-- Week Filter -->
            <div class="mt-8">
                <label class="block text-gray-700 font-medium mb-2">Filter by Week:</label>
                <div class="flex gap-2">
                    <select id="weekFilterDropdown" class="form-select flex-1">
                        <option value="">View All Weeks</option>
                    </select>
                    <button id="resetButton" class="btn btn-secondary">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Container -->
        <div id="contentContainer" class="mt-6"></div>
    </div>

    <!-- PDF Viewer Modal -->
    <div id="pdfViewerModal" class="pdf-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-lg font-semibold text-gray-900">PDF Viewer</h3>
                <button onclick="closePDFViewer()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="pdfIframe" class="w-full h-full" frameborder="0"></iframe>
            </div>
        </div>
    </div>

    <!-- Footer -->
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
        let offeredCourses = [];
        let courseContent = {};
        let API_BASE_URL = "http://127.0.0.1:8000/";

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        document.addEventListener("DOMContentLoaded", async () => {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Dropdown/AllOfferedCourse`);
                offeredCourses = await response.json();

                const courseDropdown = document.getElementById("courseDropdown");
                const sessionDropdown = document.getElementById("sessionDropdown");

                const courses = [...new Set(offeredCourses.map(item => item.course))];
                const sessions = [...new Set(offeredCourses.map(item => item.session))];

                courses.forEach(course => {
                    let option = document.createElement("option");
                    option.value = course;
                    option.textContent = course;
                    courseDropdown.appendChild(option);
                });

                sessions.forEach(session => {
                    let option = document.createElement("option");
                    option.value = session;
                    option.textContent = session;
                    sessionDropdown.appendChild(option);
                });
            } catch (error) {
                alert("Failed to fetch course data.");
                console.error(error);
            }
        });

        document.getElementById("loadButton").addEventListener("click", async () => {
            const selectedCourse = document.getElementById("courseDropdown").value;
            const selectedSession = document.getElementById("sessionDropdown").value;
            const contentContainer = document.getElementById("contentContainer");

            if (!selectedCourse || !selectedSession) {
                alert("Please select both course and session.");
                return;
            }

            const matchedCourse = offeredCourses.find(item =>
                item.course === selectedCourse && item.session === selectedSession
            );

            if (!matchedCourse) {
                alert("No matching course found.");
                return;
            }

            const offeredCourseId = matchedCourse.id;

            // Show Loader
            contentContainer.innerHTML = `
                <div class="content-card text-center">
                    <div class="loader"></div>
                    <p class="text-gray-600 mt-2">Loading course content...</p>
                </div>
            `;

            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/getCourseContent?offered_course_id=${offeredCourseId}`);
                courseContent = await response.json();
                populateWeekFilter();
                renderContent();
            } catch (error) {
                contentContainer.innerHTML = `
                    <div class="content-card text-center">
                        <p class="text-red-500 font-medium">Failed to load content. Please try again.</p>
                    </div>
                `;
                console.error(error);
            }
        });

        function populateWeekFilter() {
            const weekFilterDropdown = document.getElementById("weekFilterDropdown");
            // Keep the "View All Weeks" option
            weekFilterDropdown.innerHTML = '<option value="">View All Weeks</option>';

            const weeks = Object.keys(courseContent);
            weeks.forEach(week => {
                let option = document.createElement("option");
                option.value = week;
                option.textContent = `Week ${week}`;
                weekFilterDropdown.appendChild(option);
            });
        }

        document.getElementById("weekFilterDropdown").addEventListener("change", renderContent);
        document.getElementById("resetButton").addEventListener("click", () => {
            document.getElementById("weekFilterDropdown").value = "";
            renderContent();
        });

        function renderContent() {
            const contentContainer = document.getElementById("contentContainer");
            contentContainer.innerHTML = "";

            const selectedWeek = document.getElementById("weekFilterDropdown").value;
            const weeks = selectedWeek ? [selectedWeek] : Object.keys(courseContent);

            if (weeks.length === 0) {
                contentContainer.innerHTML = `
                    <div class="content-card text-center">
                        <p class="text-gray-600">No content available for the selected filters.</p>
                    </div>
                `;
                return;
            }

            weeks.forEach(week => {
                const weekSection = document.createElement("div");
                weekSection.className = "week-section";
                
                const weekTitle = document.createElement("h3");
                weekTitle.className = "week-title";
                weekTitle.textContent = `Week ${week}`;
                weekSection.appendChild(weekTitle);

                courseContent[week].forEach(content => {
                    const contentDiv = document.createElement("div");
                    contentDiv.className = "content-item";

                    // Content title
                    const title = document.createElement("h4");
                    title.className = "content-title";
                    title.textContent = content.title;
                    contentDiv.appendChild(title);

                    // Content type badge
                    const typeBadge = document.createElement("span");
                    typeBadge.className = `content-type type-${content.type.toLowerCase()}`;
                    typeBadge.textContent = content.type;
                    contentDiv.appendChild(typeBadge);

                    // Handle different content types
                    if (content.type === "Quiz" && Array.isArray(content.File)) {
                        if (content.File.length === 0) {
                            const noQuizMsg = document.createElement("p");
                            noQuizMsg.className = "text-sm text-gray-500";
                            noQuizMsg.textContent = "No quiz questions available.";
                            contentDiv.appendChild(noQuizMsg);
                        } else {
                            const quizContainer = document.createElement("div");
                            quizContainer.className = "mt-3 space-y-3";

                            content.File.forEach(question => {
                                const questionDiv = document.createElement("div");
                                questionDiv.className = "p-3 bg-gray-50 rounded-lg";

                                const questionText = document.createElement("p");
                                questionText.className = "font-medium text-gray-800";
                                questionText.textContent = `Q${question["Question NO"]}: ${question.Question}`;
                                questionDiv.appendChild(questionText);

                                const optionsList = document.createElement("div");
                                optionsList.className = "mt-2 space-y-1 pl-4";

                                for (let i = 1; i <= 4; i++) {
                                    const option = document.createElement("p");
                                    option.className = "text-sm";
                                    if (question[`Option ${i}`] === question.Answer) {
                                        option.className += " text-green-600 font-semibold";
                                    }
                                    option.textContent = `${i}. ${question[`Option ${i}`]}`;
                                    optionsList.appendChild(option);
                                }

                                questionDiv.appendChild(optionsList);
                                quizContainer.appendChild(questionDiv);
                            });

                            contentDiv.appendChild(quizContainer);
                        }
                    } else if (content.File && content.File.length > 0) {
                        const btnGroup = document.createElement("div");
                        btnGroup.className = "flex gap-2 mt-3";

                        // View button
                        const viewBtn = document.createElement("button");
                        viewBtn.className = "btn btn-primary flex-1";
                        viewBtn.innerHTML = '<i class="fas fa-eye mr-2"></i> View';
                        viewBtn.onclick = () => openPDFViewer(content.File);
                        btnGroup.appendChild(viewBtn);

                        // Download button
                        const downloadBtn = document.createElement("a");
                        downloadBtn.className = "btn btn-secondary flex-1";
                        downloadBtn.innerHTML = '<i class="fas fa-download mr-2"></i> Download';
                        downloadBtn.href = content.File;
                        downloadBtn.download = content.title;
                        btnGroup.appendChild(downloadBtn);

                        contentDiv.appendChild(btnGroup);
                    } else {
                        const noFileMsg = document.createElement("p");
                        noFileMsg.className = "text-sm text-gray-500";
                        noFileMsg.textContent = "No file available for this content.";
                        contentDiv.appendChild(noFileMsg);
                    }

                    // Topics list for Notes
                    if (content.type === "Notes" && content.topics && content.topics.length > 0) {
                        const topicsTitle = document.createElement("p");
                        topicsTitle.className = "mt-3 text-sm font-medium text-gray-700";
                        topicsTitle.textContent = "Topics Covered:";
                        contentDiv.appendChild(topicsTitle);

                        const topicsList = document.createElement("ul");
                        topicsList.className = "list-disc pl-5 mt-1 space-y-1";

                        content.topics.forEach(topic => {
                            const topicItem = document.createElement("li");
                            topicItem.className = "text-sm text-gray-600";
                            topicItem.textContent = topic.topic_name;
                            topicsList.appendChild(topicItem);
                        });

                        contentDiv.appendChild(topicsList);
                    }

                    weekSection.appendChild(contentDiv);
                });

                contentContainer.appendChild(weekSection);
            });
        }

        function openPDFViewer(pdfUrl) {
            const modal = document.getElementById("pdfViewerModal");
            const iframe = document.getElementById("pdfIframe");
            
            iframe.src = pdfUrl;
            modal.style.display = "flex";
            document.body.style.overflow = "hidden";
        }

        function closePDFViewer() {
            const modal = document.getElementById("pdfViewerModal");
            const iframe = document.getElementById("pdfIframe");
            
            iframe.src = "";
            modal.style.display = "none";
            document.body.style.overflow = "auto";
        }
    </script>
</body>
</html>