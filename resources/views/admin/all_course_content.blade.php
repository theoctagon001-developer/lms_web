<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Content</title>
    @vite('resources/css/app.css')
    <style>
        /* Base styles */
        body {
            font-family: 'Inter', sans-serif;
        }

        .max-w-4xl {
            max-width: 56rem; /* Adjust container width */
        }

        .grid {
            display: grid;
        }

        .gap-4 {
            gap: 1rem; /* Spacing between grid items */
        }

        .bg-white {
            background-color: white;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .shadow-lg {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .p-6 {
            padding: 1.5rem;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-center {
            text-align: center;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .mt-6 {
            margin-top: 1.5rem;
        }

        .w-full {
            width: 100%;
        }

        .p-2 {
            padding: 0.5rem;
        }

        .border {
            border-width: 1px;
        }

        .border-gray-300 {
            border-color: #d1d5db;
        }

        .rounded {
            border-radius: 0.375rem;
        }

        .hover\:bg-blue-600:hover {
            background-color: #2563eb;
        }

        .hover\:bg-gray-600:hover {
            background-color: #4b5563;
        }

        .transition {
            transition: all 0.2s ease-in-out;
        }

        .space-y-4 > * + * {
            margin-top: 1rem;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .grid-cols-1 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }

            .p-6 {
                padding: 1rem;
            }

            .text-2xl {
                font-size: 1.25rem;
            }

            .gap-4 {
                gap: 0.5rem;
            }

            .mt-6 {
                margin-top: 1rem;
            }

            .mt-4 {
                margin-top: 0.5rem;
            }

            .mb-4 {
                margin-bottom: 0.5rem;
            }
        }

        /* PDF Viewer Modal */
        #pdfViewerModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        #pdfViewerModal .modal-content {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            max-width: 90%;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        #pdfIframe {
            width: 100%;
            height: 500px;
            border: none;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-4">Course Content</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium">Select Course:</label>
                <select id="courseDropdown" class="w-full p-2 border border-gray-300 rounded">
                    <option value="">Select Course</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Select Session:</label>
                <select id="sessionDropdown" class="w-full p-2 border border-gray-300 rounded">
                    <option value="">Select Session</option>
                </select>
            </div>
        </div>

        <button id="loadButton" class="mt-4 w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
            Load
        </button>

        <!-- Week Filter Dropdown -->
        <div class="mt-6">
            <label class="block text-gray-700 font-medium">Filter by Week:</label>
            <select id="weekFilterDropdown" class="w-full p-2 border border-gray-300 rounded">
                <option value="">View All Weeks</option>
            </select>
            <button id="resetButton" class="mt-2 w-full bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition">
                Reset / View All
            </button>
        </div>

        <!-- PDF Viewer Modal -->
        <div id="pdfViewerModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white p-4 rounded-lg shadow-lg max-w-3xl w-full">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900">PDF Viewer</h2>
                    <button onclick="closePDFViewer()" class="text-red-500 text-lg font-bold">&times;</button>
                </div>
                <iframe id="pdfIframe" class="w-full h-[500px] mt-4 border rounded-lg" frameborder="0"></iframe>
            </div>
        </div>

        <!-- Course Content List -->
        <div id="contentContainer" class="mt-6 space-y-4"></div>
    </div>

    <script>
        // Your existing JavaScript code here
    </script>

    @include('components.footer')
</body>
<style>
    .loader {
        border-width: 4px;
        border-style: solid;
        border-radius: 50%;
        width: 3rem;
        height: 3rem;
        border-color: #3b82f6 transparent #3b82f6 transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
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
    contentContainer.innerHTML = `<div class="text-center mt-4">
        <div class="loader border-4 border-blue-500 border-t-transparent rounded-full w-12 h-12 animate-spin mx-auto"></div>
        <p>Loading...</p>
    </div>`;

    try {
        API_BASE_URL = await getApiBaseUrl();
        const response = await fetch(`${API_BASE_URL}api/Admin/getCourseContent?offered_course_id=${offeredCourseId}`, {
            method: "GET",
            headers: { "Content-Type": "application/json" }
        });

        courseContent = await response.json();
        populateWeekFilter();
        renderContent();
    } catch (error) {
        alert("Failed to fetch course content.");
        console.error(error);
        contentContainer.innerHTML = "<p class='text-red-500'>Failed to load content. Please try again.</p>";
    }
});
    function populateWeekFilter() {
        const weekFilterDropdown = document.getElementById("weekFilterDropdown");
        weekFilterDropdown.innerHTML = '<option value="">View All Weeks</option>';

        const weeks = Object.keys(courseContent);
        weeks.forEach(week => {
            let option = document.createElement("option");
            option.value = week;
            option.textContent = "Week " + week;
            weekFilterDropdown.appendChild(option);
        });
    }

    document.getElementById("weekFilterDropdown").addEventListener("change", () => {
        renderContent();
    });

    document.getElementById("resetButton").addEventListener("click", () => {
        document.getElementById("weekFilterDropdown").value = "";
        renderContent();
    });


    function renderContent() {
const contentContainer = document.getElementById("contentContainer");
contentContainer.innerHTML = "";

const selectedWeek = document.getElementById("weekFilterDropdown").value;
const weeks = selectedWeek ? [selectedWeek] : Object.keys(courseContent);

weeks.forEach(week => {
    const weekSection = document.createElement("div");
    weekSection.classList.add("p-4", "bg-gray-200", "rounded-lg", "shadow-lg");

    let weekTitle = document.createElement("h3");
    weekTitle.classList.add("text-lg", "font-bold", "text-blue-700");
    weekTitle.textContent = `Week ${week}`;
    weekSection.appendChild(weekTitle);

    courseContent[week].forEach(content => {
        let contentDiv = document.createElement("div");
        contentDiv.classList.add("mt-4", "p-4", "bg-white", "rounded-lg", "shadow-lg");

        let title = document.createElement("h4");
        title.classList.add("text-lg", "font-semibold", "text-gray-900");
        title.textContent = content.title;
        contentDiv.appendChild(title);

        let type = document.createElement("p");
        type.classList.add("text-sm", "text-gray-700", "mb-2");
        type.textContent = `Type: ${content.type}`;
        contentDiv.appendChild(type);

        if (content.type === "Quiz" && Array.isArray(content.File)) {
            if (content.File.length === 0) {
                let noFileMsg = document.createElement("p");
                noFileMsg.classList.add("text-sm", "text-red-500", "font-semibold");
                noFileMsg.textContent = "No Quiz file available.";
                contentDiv.appendChild(noFileMsg);
            } else {
                let quizList = document.createElement("div");
                quizList.classList.add("mt-2", "p-3", "bg-gray-100", "rounded-lg", "shadow-sm");

                content.File.forEach(question => {
                    let questionDiv = document.createElement("div");
                    questionDiv.classList.add("mt-2", "p-3", "bg-white", "rounded-lg", "shadow");

                    let questionText = document.createElement("p");
                    questionText.classList.add("font-semibold", "text-gray-900");
                    questionText.textContent = `Q${question["Question NO"]}: ${question.Question}`;
                    questionDiv.appendChild(questionText);

                    for (let i = 1; i <= 4; i++) {
                        let option = document.createElement("p");
                        option.classList.add("text-sm", "text-gray-700", "pl-4");
                        option.textContent = `${i}. ${question[`Option ${i}`]}`;
                        if (question[`Option ${i}`] === question.Answer) {
                            option.classList.add("font-bold", "text-green-600");
                        }
                        questionDiv.appendChild(option);
                    }

                    quizList.appendChild(questionDiv);
                });
                contentDiv.appendChild(quizList);
            }
        } else if (content.type === "Notes" || content.type === "Assignment" || content.type === "Quiz") {
            if (!content.File || content.File.length === 0) {
                let noFileMsg = document.createElement("p");
                noFileMsg.classList.add("text-sm", "text-red-500", "font-semibold");
                noFileMsg.textContent = "No file available.";
                contentDiv.appendChild(noFileMsg);
            } else {
                let btnGroup = document.createElement("div");
                btnGroup.classList.add("flex", "gap-3");

                let viewBtn = document.createElement("button");
                viewBtn.classList.add("px-4", "py-2", "bg-green-500", "text-white", "rounded-lg", "hover:bg-green-600", "transition");
                viewBtn.textContent = "View";
                viewBtn.onclick = () => openPDFViewer(content.File); // Assuming the first file contains the PDF URL
                btnGroup.appendChild(viewBtn);

                let downloadBtn = document.createElement("a");
                downloadBtn.classList.add("px-4", "py-2", "bg-blue-500", "text-white", "rounded-lg", "hover:bg-blue-600", "transition");
                downloadBtn.textContent = "Download";
                downloadBtn.href = content.File;
                downloadBtn.download = content.title; // Assuming the file object has a 'name' field
                btnGroup.appendChild(downloadBtn);

                contentDiv.appendChild(btnGroup);
            }
        }

        if (content.type === "Notes" && content.topics && content.topics.length > 0) {
            let topicList = document.createElement("ul");
            topicList.classList.add("list-disc", "pl-5", "mt-2", "text-gray-800");

            content.topics.forEach(topic => {
                let topicItem = document.createElement("li");
                topicItem.textContent = topic.topic_name;
                topicList.appendChild(topicItem);
            });

            contentDiv.appendChild(topicList);
        }

        weekSection.appendChild(contentDiv);
    });

    contentContainer.appendChild(weekSection);
});
}



</script>
</html>
