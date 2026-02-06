{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grader History</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    @include('admin.navbar')
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-center mb-4">Grader History</h2>

        <!-- Grader Info -->
        <div id="grader-info" class="flex flex-col sm:flex-row items-center gap-4 bg-gray-50 p-4 rounded-lg shadow-md">
        </div>

        <!-- Search Bar -->
        <div class="my-4">
            <input type="text" id="search-session" class="border p-2 w-full rounded-lg" placeholder="Search by Session Name..." oninput="filterAllocations()">
        </div>

        <!-- Current Session Section -->
        <div class="mb-6">
            <h3 class="text-xl font-bold text-blue-600">Current Session</h3>
            <div id="current-session-container" class="space-y-4 mt-2"></div>
        </div>

        <!-- Allocate Button (Hidden by Default) -->
        <div id="allocate-btn-container" class="hidden text-center my-4">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">Allocate A Teacher</button>
        </div>

        <!-- Previous Session Section -->
        <div>
            <h3 class="text-xl font-bold text-gray-700">Previous Sessions</h3>
            <div id="previous-session-container" class="space-y-4 mt-2"></div>
        </div>
    </div>

    <script>
        let API_BASE_URL = "http://127.0.0.1:8001/";
        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }
        async function initializeApiBaseUrl() {
            API_BASE_URL = await getApiBaseUrl();
        }
        document.addEventListener("DOMContentLoaded",
            function() {
                const studentId = "{{ $student_id }}";

                if (!studentId) {
                    alert("Invalid Student ID!");
                    return;
                }
                initializeApiBaseUrl();
                fetch(`${API_BASE_URL}api/Grader/GraderInfo?student_id=${studentId}`)
                    .then(response => response.json())
                    .then(data => displayGraderHistory(data))
                    .catch(error => console.error("Error fetching data:", error));
            });

        function displayGraderHistory(response) {
            if (!response.data || response.data.length === 0) {
                document.getElementById("grader-info").innerHTML = "<p class='text-red-500'>No data found!</p>";
                return;
            }

            const grader = response.data[0];
            const graderInfoDiv = document.getElementById("grader-info");
            const currentSessionContainer = document.getElementById("current-session-container");
            const previousSessionContainer = document.getElementById("previous-session-container");
            const allocateBtnContainer = document.getElementById("allocate-btn-container");

            // Grader Info Card
            graderInfoDiv.innerHTML = `
                <img src="${grader.image || 'https://via.placeholder.com/100'}" alt="Grader Image" class="w-24 h-24 rounded-full border">
                <div>
                    <h3 class="text-lg font-bold">${grader.grader_name} (${grader.grader_RegNo})</h3>
                    <p class="text-gray-600"><strong>Section:</strong> ${grader.grader_section}</p>
                    <p class="text-gray-600"><strong>Status:</strong> ${grader["This Session"]}</p>
                    <p class="text-gray-600"><strong>Type:</strong> ${grader.type}</p>
                </div>
            `;

            // Sorting Allocations
            let hasCurrentSession = false;
            currentSessionContainer.innerHTML = "";
            previousSessionContainer.innerHTML = "";

            grader["Grader Allocations"].forEach(allocation => {
                const teacherImage = allocation.teacher_image ?
                    allocation.teacher_image :
                    `https://ui-avatars.com/api/?name=${allocation.teacher_name}&background=random`;

                const feedbackText = allocation.feedback && allocation.feedback !== "Not Added By Instructor" ?
                    allocation.feedback :
                    "Not Available";

                const predictedRating = predictRating(allocation.feedback);

                const sessionHTML = `
                    <div class="p-4 bg-white shadow rounded-lg border">
                        <div class="flex items-center gap-4">
                            <img src="${teacherImage}" alt="Teacher Image" class="w-16 h-16 rounded-full border">
                            <div>
                                <h4 class="text-lg font-bold">${allocation["session_name"]}</h4>
                                <p class="text-gray-600"><strong>Teacher:</strong> ${allocation.teacher_name}</p>
                                <p class="text-gray-600"><strong>Status:</strong> ${allocation["Allocation Status"]}</p>
                                ${allocation["Session is ? "] === " Previous Session"
                                    ? `<p class="text-gray-600"><strong>Feedback:</strong> ${feedbackText}</p>
                                       <p class="text-yellow-500"><strong>Predicted Rating:</strong> ${predictedRating}</p>`
                                    : ""}
                            </div>
                        </div>
                    </div>
                `;

                if (allocation["Session is ? "] === " Current Session") {
                    hasCurrentSession = true;
                    currentSessionContainer.innerHTML += sessionHTML;
                } else {
                    previousSessionContainer.innerHTML += sessionHTML;
                }
            });

            // Show "Allocate A Teacher" button if no current session data
            allocateBtnContainer.classList.toggle("hidden", hasCurrentSession);
        }

        function filterAllocations() {
            const searchValue = document.getElementById("search-session").value.toLowerCase();
            document.querySelectorAll("#current-session-container > div, #previous-session-container > div").forEach(allocation => {
                const sessionName = allocation.querySelector("h4").textContent.toLowerCase();
                allocation.style.display = sessionName.includes(searchValue) ? "block" : "none";
            });
        }

        function predictRating(feedback) {
            if (!feedback || feedback === "Not Added By Instructor") return "0/10 ⭐"; // Always shows a star

            const lowerFeedback = feedback.toLowerCase();
            if (lowerFeedback.includes("excellent")) return "10/10 ⭐⭐⭐⭐⭐";
            if (lowerFeedback.includes("very good")) return "9/10 ⭐⭐⭐⭐⭐";
            if (lowerFeedback.includes("good")) return "8/10 ⭐⭐⭐⭐";
            if (lowerFeedback.includes("average")) return "5/10 ⭐⭐⭐";
            if (lowerFeedback.includes("poor")) return "3/10 ⭐⭐";
            return "4/10 ⭐⭐"; // Default rating
        }

    </script>
    @include('components.footer')
</body>

</html> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grader History</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;


            color: #333;
        }

        .container {

            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .grader-card {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #3498db;
        }

        .grader-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            border: 3px solid #e2e8f0;
        }

        .grader-info {
            flex-grow: 1;
        }

        .grader-name {
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 5px 0;
            color: #2c3e50;
        }

        .grader-detail {
            margin: 3px 0;
            font-size: 14px;
            color: #555;
        }

        .session-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e8f0;
        }

        .current-session .section-title {
            color: #27ae60;
        }

        .previous-sessions .section-title {
            color: #7f8c8d;
        }

        .allocation-card {
            padding: 15px;
            margin-bottom: 15px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #3498db;
            transition: transform 0.2s;
        }

        .allocation-card:hover {
            transform: translateY(-2px);
        }

        .allocation-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .teacher-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            background-color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #555;
        }

        .allocation-title {
            font-weight: 600;
            margin: 0;
            color: #2c3e50;
        }

        .allocation-detail {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .feedback {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #ddd;
            font-style: italic;
        }

        .rating {
            color: #f39c12;
            font-weight: bold;
        }

        .search-box {
            width: 100%;
            padding: 10px 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            font-style: italic;
        }

        .status-active {
            color: #27ae60;
            font-weight: bold;
        }

        .status-inactive {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>

<body>
       @include('admin.navbar')
    <div class="container">
        <h1>Grader History</h1>

        <!-- Grader Information -->
        <div id="grader-info" class="grader-card">
            <!-- Will be populated by JavaScript -->
        </div>

        <!-- Search Box -->
        <input type="text" id="search-session" class="search-box" placeholder="Search by session name..." oninput="filterAllocations()">

        <!-- Current Session -->
        <div class="session-section current-session">
            <h2 class="section-title">Current Session</h2>
            <div id="current-session-container">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>

        <!-- Previous Sessions -->
        <div class="session-section previous-sessions">
            <h2 class="section-title">Previous Sessions</h2>
            <div id="previous-session-container">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // API Configuration
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

        // Get student ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const studentId = urlParams.get('student_id') || '1';
        console.log("Received student ID:", studentId);

        // Function to fetch grader history from API
        async function fetchGraderHistory() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Grader/GraderInfo?student_id=${studentId}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log("API Response:", data);
                return data;
            } catch (error) {
                console.error("Error fetching grader history:", error);
                return null;
            }
        }

        // Function to display grader history
        function displayGraderHistory(response) {
            if (!response || !response.data || response.data.length === 0) {
                document.getElementById("grader-info").innerHTML = '<div class="no-data">No grader information found</div>';
                return;
            }

            const grader = response.data[0];

            // Display grader information
            const graderInfoDiv = document.getElementById("grader-info");
            graderInfoDiv.innerHTML = `
                <img src="${grader.image || ''}" onerror="this.onerror=null;this.src='';this.style.display='none';" class="grader-image">
                <div class="grader-info">
                    <h2 class="grader-name">${grader.grader_name}</h2>
                    <p class="grader-detail"><strong>Registration No:</strong> ${grader.grader_RegNo}</p>
                    <p class="grader-detail"><strong>Section:</strong> ${grader.grader_section}</p>
                    <p class="grader-detail"><strong>Status:</strong> <span class="${grader["This Session"] === 'active' ? 'status-active' : 'status-inactive'}">${grader["This Session"]}</span></p>
                    <p class="grader-detail"><strong>Type:</strong> ${grader.type}</p>
                </div>
            `;

            // Display allocations
            const currentSessionContainer = document.getElementById("current-session-container");
            const previousSessionContainer = document.getElementById("previous-session-container");

            currentSessionContainer.innerHTML = '';
            previousSessionContainer.innerHTML = '';

            let hasCurrentSession = false;

            if (grader["Grader Allocations"] && grader["Grader Allocations"].length > 0) {
                grader["Grader Allocations"].forEach(allocation => {
                    // Create teacher initials for placeholder image
                    const teacherName = allocation.teacher_name || 'Teacher';
                    const initials = teacherName.split(' ').map(n => n[0]).join('').toUpperCase();

                    const feedbackText = allocation.feedback && allocation.feedback !== "Not Added By Instructor"
                        ? allocation.feedback
                        : "No feedback available";

                    const rating = predictRating(allocation.feedback);

                    const allocationCard = `
                        <div class="allocation-card">
                            <div class="allocation-header">
                                <div class="teacher-image">${initials}</div>
                                <div>
                                    <h3 class="allocation-title">${allocation.session_name}</h3>
                                    <p class="allocation-detail"><strong>Teacher:</strong> ${allocation.teacher_name}</p>
                                    <p class="allocation-detail"><strong>Status:</strong> <span class="${allocation["Allocation Status"] === 'active' ? 'status-active' : 'status-inactive'}">${allocation["Allocation Status"]}</span></p>
                                </div>
                            </div>
                            ${allocation["Session is ? "] === "Previous Session" ? `
                                <div class="feedback">
                                    <p><strong>Feedback:</strong> ${feedbackText}</p>

                                </div>
                            ` : ''}
                        </div>
                    `;

                    if (allocation["Session is ? "] === "Current Session") {
                        hasCurrentSession = true;
                        currentSessionContainer.innerHTML += allocationCard;
                    } else {
                        previousSessionContainer.innerHTML += allocationCard;
                    }
                });
            }

            if (!hasCurrentSession) {
                currentSessionContainer.innerHTML = '<div class="no-data">No current session allocation found</div>';
            }

            if (previousSessionContainer.innerHTML === '') {
                previousSessionContainer.innerHTML = '<div class="no-data">No previous session records found</div>';
            }
        }

        // Function to filter allocations by session name
        function filterAllocations() {
            const searchValue = document.getElementById("search-session").value.toLowerCase();
            const allocations = document.querySelectorAll(".allocation-card");

            allocations.forEach(allocation => {
                const sessionName = allocation.querySelector(".allocation-title").textContent.toLowerCase();
                allocation.style.display = sessionName.includes(searchValue) ? "block" : "none";
            });
        }

        // Function to predict rating based on feedback
        function predictRating(feedback) {
            if (!feedback || feedback === "Not Added By Instructor") {
                return "Not rated";
            }

            // Simple rating prediction based on keywords
            const lowerFeedback = feedback.toLowerCase();

            if (lowerFeedback.includes("excellent") || lowerFeedback.includes("outstanding")) {
                return "★★★★★ (5/5)";
            } else if (lowerFeedback.includes("very good") || lowerFeedback.includes("great")) {
                return "★★★★☆ (4/5)";
            } else if (lowerFeedback.includes("good") || lowerFeedback.includes("satisfactory")) {
                return "★★★☆☆ (3/5)";
            } else if (lowerFeedback.includes("average") || lowerFeedback.includes("adequate")) {
                return "★★☆☆☆ (2/5)";
            } else if (lowerFeedback.includes("poor") || lowerFeedback.includes("needs improvement")) {
                return "★☆☆☆☆ (1/5)";
            } else {
                return "★★★☆☆ (3/5)";
            }
        }
        document.addEventListener("DOMContentLoaded", async function() {
            const response = await fetchGraderHistory();
            displayGraderHistory(response);
        });
    </script>
</body>
</html>
