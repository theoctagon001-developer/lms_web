<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const role = "{{ $role }}";
            const teacherId = "{{ $teacher['id'] }}";

            if (role === "JuniorLecturer") {
                fetchCourseAllocation(teacherId);
            } else if (role === "Teacher") {
                fetchCourseAllocationForTeacher(teacherId);
            }
        });
        
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
        
        async function fetchCourseAllocationForTeacher(id) {
            API_BASE_URL = await getApiBaseUrl();
            const apiUrl = `${API_BASE_URL}api/Teachers/your-courses?teacher_id=${id}`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        displayCoursesForTeacher(data.data.active_courses, 'currentCourses');
                        displayPreviousCoursesForTeacher(data.data.previous_courses, 'previousCourses');
                    }
                })
                .catch(error => console.error("Error fetching teacher courses:", error));
        }

        function displayCoursesForTeacher(courses, sectionId) {
            const section = document.getElementById(sectionId);
            section.innerHTML = "";
            
            if (courses.length === 0) {
                section.innerHTML = `<p class="text-gray-500 text-center">No courses available.</p>`;
                return;
            }

            courses.forEach(course => {
                const showJunior = course.lab === "Yes" && course.junior_name !== "N/A";

                section.innerHTML += `
                <div class="bg-white shadow-md rounded-lg p-4 mb-4 border">
                    <h3 class="text-xl font-semibold text-blue-700">${course.course_name} (${course.course_code})</h3>
                    <p class="text-gray-600">Credit Hours: <strong>${course.credit_hours}</strong> | ${course.course_type}</p>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <p><strong>Section:</strong> ${course.section_name}</p>
                        <p><strong>Session:</strong> ${course.session_name}</p>
                        <p><strong>Program:</strong> ${course.program_name}</p>
                        <p><strong>Lab:</strong> ${course.lab === "Yes" ? "✅ Available" : "❌ Not Available"}</p>
                        <p><strong>Prerequisite:</strong> ${course.prerequisite || "None"}</p>
                    </div>

                    ${showJunior ? `
                    <div class="mt-4 p-3 border-t">
                        <h4 class="text-lg font-semibold text-gray-700">Junior Lecturer</h4>
                        <div class="flex items-center space-x-3">
                            <img src="${course.junior_image ?? 'https://via.placeholder.com/50'}"
                                class="w-12 h-12 rounded-full border">
                            <p class="text-gray-700">${course.junior_name}</p>
                        </div>
                    </div>` : ""}
                </div>`;
            });
        }

        function displayPreviousCoursesForTeacher(previousCourses, sectionId) {
            const section = document.getElementById(sectionId);
            section.innerHTML = "";
            
            if (Object.keys(previousCourses).length === 0) {
                section.innerHTML = `<p class="text-gray-500 text-center">No previous courses available.</p>`;
                return;
            }

            // Iterate through each session
            for (const [session, courses] of Object.entries(previousCourses)) {
                section.innerHTML += `
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-2">${session}</h3>
                        <div class="space-y-4">
                `;
                
                courses.forEach(course => {
                    const showJunior = course.lab === "Yes" && course.junior_name && course.junior_name !== "N/A";
                    
                    section.innerHTML += `
                        <div class="bg-white shadow-md rounded-lg p-4 border">
                            <h3 class="text-xl font-semibold text-blue-700">${course.course_name} (${course.course_code})</h3>
                            <p class="text-gray-600">Credit Hours: <strong>${course.credit_hours}</strong> | ${course.course_type}</p>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <p><strong>Section:</strong> ${course.section_name}</p>
                                <p><strong>Session:</strong> ${course.session_name}</p>
                                <p><strong>Program:</strong> ${course.program_name}</p>
                                <p><strong>Lab:</strong> ${course.lab === "Yes" ? "✅ Available" : "❌ Not Available"}</p>
                                <p><strong>Prerequisite:</strong> ${course.prerequisite || "None"}</p>
                            </div>

                            ${showJunior ? `
                            <div class="mt-4 p-3 border-t">
                                <h4 class="text-lg font-semibold text-gray-700">Junior Lecturer</h4>
                                <div class="flex items-center space-x-3">
                                    <img src="${course.junior_image ?? 'https://via.placeholder.com/50'}"
                                        class="w-12 h-12 rounded-full border">
                                    <p class="text-gray-700">${course.junior_name}</p>
                                </div>
                            </div>` : ""}
                        </div>
                    `;
                });
                
                section.innerHTML += `</div></div>`;
            }
        }

        async function fetchCourseAllocation(jl_id) {
            API_BASE_URL = await getApiBaseUrl();
            fetch(`${API_BASE_URL}api/JuniorLec/your-courses?teacher_id=${jl_id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        displayCourses(data.data.active_courses, 'currentCourses');
                        displayPreviousCourses(data.data.previous_courses, 'previousCourses');
                    }
                })
                .catch(error => console.error("Error fetching data:", error));
        }

        function displayCourses(courses, sectionId) {
            const section = document.getElementById(sectionId);
            section.innerHTML = "";

            if (courses.length === 0) {
                section.innerHTML = `<p class="text-gray-500 text-center">No courses available.</p>`;
                return;
            }

            courses.forEach(course => {
                section.innerHTML += `
                    <div class="bg-white shadow-md rounded-lg p-3 mb-4 border">
                        <div>
                            <h3 class="text-xl font-semibold text-blue-700">${course.course_name} (${course.course_code})</h3>
                            <p class="text-gray-600">Credit Hours: <strong>${course.credit_hours}</strong> | ${course.course_type}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <p><strong>Teacher:</strong> ${course.teacher_name}</p>
                            <p><strong>Section:</strong> ${course.section_name}</p>
                            <p><strong>Session:</strong> ${course.session_name}</p>
                            <p><strong>Program:</strong> ${course.program_name}</p>
                            <p><strong>Lab:</strong> ${course.lab === "Yes" ? "✅ Available" : "❌ Not Available"}</p>
                            <p><strong>Prerequisite:</strong> ${course.prerequisite || "None"}</p>
                        </div>
                    </div>
                `;
            });
        }

        function displayPreviousCourses(previousCourses, sectionId) {
            const section = document.getElementById(sectionId);
            section.innerHTML = "";
            
            if (Object.keys(previousCourses).length === 0) {
                section.innerHTML = `<p class="text-gray-500 text-center">No previous courses available.</p>`;
                return;
            }

            // Iterate through each session
            for (const [session, courses] of Object.entries(previousCourses)) {
                section.innerHTML += `
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-2">${session}</h3>
                        <div class="space-y-4">
                `;
                
                courses.forEach(course => {
                    section.innerHTML += `
                        <div class="bg-white shadow-md rounded-lg p-3 border">
                            <div>
                                <h3 class="text-xl font-semibold text-blue-700">${course.course_name} (${course.course_code})</h3>
                                <p class="text-gray-600">Credit Hours: <strong>${course.credit_hours}</strong> | ${course.course_type}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <p><strong>Teacher:</strong> ${course.teacher_name || 'N/A'}</p>
                                <p><strong>Section:</strong> ${course.section_name}</p>
                                <p><strong>Session:</strong> ${course.session_name}</p>
                                <p><strong>Program:</strong> ${course.program_name}</p>
                                <p><strong>Lab:</strong> ${course.lab === "Yes" ? "✅ Available" : "❌ Not Available"}</p>
                                <p><strong>Prerequisite:</strong> ${course.prerequisite || "None"}</p>
                            </div>
                        </div>
                    `;
                });
                
                section.innerHTML += `</div></div>`;
            }
        }

        function searchCourses() {
            const query = document.getElementById("search").value.toLowerCase();
            document.querySelectorAll("#currentCourses > div, #previousCourses > div > div > div").forEach(course => {
                course.style.display = course.innerText.toLowerCase().includes(query) ? "block" : "none";
            });
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen">
    @include('HOD.partials.profile_panel')

    <div class="flex justify-center items-center min-h-screen p-6">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-5xl">
            <!-- Profile Section -->
            <div class="text-center">
                <img src="{{ $teacher['image'] ?? asset('images/male.png') }}" class="w-32 h-32 rounded-full border-4 border-blue-500 shadow-md mx-auto">
                <h2 class="text-3xl font-bold mt-4">{{ $teacher['name'] }}</h2>
                <p class="text-gray-600 text-lg">{{ $teacher['cnic'] }}</p>
                <p class="text-gray-600 text-lg">Role: {{ $role }}</p>
            </div>

            <div class="mt-6 text-left">
                <div class="grid grid-cols-2 gap-12">
                    <div><strong>Username:</strong> {{ $teacher['user']['username'] }}</div>
                    <div><strong>Gender:</strong> {{ $teacher['gender'] }}</div>
                    <div><strong>Email:</strong> {{ $teacher['user']['email'] }}</div>
                    <div><strong>Date of Birth:</strong> {{ $teacher['date_of_birth'] }}</div>
                </div>
            </div>
            
            @if($role === "Teacher")
            <div class="max-w-4xl mx-auto p-4">
                <!-- Search Bar -->
                <div class="mb-6">
                    <label for="search" class="block text-lg font-semibold text-gray-700 mb-2">Search Courses</label>
                    <input type="text" id="search" onkeyup="searchCourses()"
                           placeholder="Search by session, section, or course name..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Current Courses Section -->
                <h2 class="text-2xl font-bold text-blue-700 border-b-2 border-blue-500 pb-2 mb-4">Current Courses</h2>
                <div id="currentCourses" class="space-y-4"></div>

                <!-- Previous Courses Section -->
                <h2 class="text-2xl font-bold text-gray-700 border-b-2 border-gray-400 pb-2 mt-6 mb-4">Previous Courses</h2>
                <div id="previousCourses" class="space-y-4"></div>
            </div>
            @endif
            
            @if($role === "JuniorLecturer")
            <div class="max-w-4xl mx-auto p-4">
                <!-- Search Bar -->
                <div class="mb-6">
                    <label for="search" class="block text-lg font-semibold text-gray-700 mb-2">Search Courses</label>
                    <input type="text" id="search" onkeyup="searchCourses()"
                           placeholder="Search by session, section, or course name..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Current Courses Section -->
                <h2 class="text-2xl font-bold text-blue-700 border-b-2 border-blue-500 pb-2 mb-4">Current Courses</h2>
                <div id="currentCourses" class="space-y-4"></div>

                <!-- Previous Courses Section -->
                <h2 class="text-2xl font-bold text-gray-700 border-b-2 border-gray-400 pb-2 mt-6 mb-4">Previous Courses</h2>
                <div id="previousCourses" class="space-y-4"></div>
            </div>
            @endif
        </div>
    </div>
</body>
</html>