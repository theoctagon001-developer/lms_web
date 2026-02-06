{{--
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grader List</title>
    @vite('resources/css/app.css')
    <style>
        .table-container {
            transition: all 0.3s ease-in-out;
        }

        .search-active .table-container {
            max-width: 80%;
        }
    </style>
    <script>
        let graders = [];
        let filteredGraders = [];
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let itemsToShow = 10;
        let selectedType = "";
        let selectedStatus = "";

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        async function loadGraders() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/grades`);
                const data = await response.json();
                console.log('graders info' + data)
                if (data.Grader) {
                    console.log(data)
                    graders = data.Grader;
                    console.log(data)
                    filteredGraders = [...graders];
                    renderGraders();
                }
            } catch (error) {
                console.error("Error fetching graders:", error);
            }
        }

        function searchGraders() {
            const nameSearch = document.getElementById("search-name").value.toLowerCase();
            const teacherSearch = document.getElementById("search-teacher").value.toLowerCase();

            filteredGraders = graders.filter(grader =>
                (grader.name.toLowerCase().includes(nameSearch) || nameSearch === "") &&
                (grader["Grader of Teacher in Current Session"].toLowerCase().includes(teacherSearch) || teacherSearch === "") &&
                (selectedType === "" || grader.type === selectedType) &&
                (selectedStatus === "" || grader.status === selectedStatus)
            );

            renderGraders();
            document.getElementById("table-wrapper").classList.add("search-active");
        }

        function resetSearch() {
            document.getElementById("search-name").value = "";
            document.getElementById("search-teacher").value = "";
            document.getElementById("status-filter").value = "";
            document.querySelectorAll("input[name='type-filter']").forEach(radio => radio.checked = false);
            selectedType = "";
            selectedStatus = "";
            filteredGraders = [...graders];
            renderGraders();
            document.getElementById("table-wrapper").classList.remove("search-active");
        }

        function handleTypeFilter(type) {
            selectedType = type;
            searchGraders();
        }

        function handleStatusFilter(status) {
            selectedStatus = status;
            searchGraders();
        }


        function renderGraders() {
            const tableBody = document.getElementById("grader-table-body");
            const mobileContainer = document.getElementById("grader-mobile-container");

            // Clear both containers
            tableBody.innerHTML = "";
            mobileContainer.innerHTML = "";

            if (filteredGraders.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-gray-500">No graders found.</td></tr>';
                mobileContainer.innerHTML = '<div class="text-center py-4 text-gray-500">No graders found.</div>';
                return;
            }

            // In renderGraders() function:
            filteredGraders.forEach(grader => {
                const studentDetailsUrl = `{{ route('grader.details') }}?student_id=${grader.student_id}`;


                console.log(`History URL for ${grader.student_id}:`, studentDetailsUrl);



                let actionButton = `<a href="${studentDetailsUrl}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded mr-2">History</a>`;

                // If the grader is inactive, add the Assign button too
                if (grader.status.toLowerCase() !== "active") {
                    actionButton += `<button onclick="assignGrader(${grader.grader_id}, '${grader.name}', '${grader.regNo}', '${grader.image}')" class="bg-green-500 text-white px-3 py-1 rounded">Assign</button>`;
                }



                tableBody.innerHTML += `
            <tr class="border-b border-gray-300 text-center hover:bg-gray-50">
                <td class="px-4 py-2">${grader.name}</td>
                <td class="px-4 py-2">${grader.status}</td>
                <td class="px-4 py-2">${grader["Grader of Teacher in Current Session"]}</td>
                <td class="px-4 py-2">
                    ${actionButton}
                </td>
            </tr>`;

                // Add card to mobile container
                mobileContainer.innerHTML += `
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                <div class="bg-blue-500 text-white px-4 py-2 font-medium text-center">
                    ${grader.name}
                </div>
                <div class="divide-y divide-gray-200">
                    <div class="flex justify-between items-center px-4 py-3">
                        <span class="font-medium text-gray-700">Status:</span>
                        <span class="${grader.status.toLowerCase() === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'} py-1 px-2 rounded-full text-sm">
                            ${grader.status}
                        </span>
                    </div>
                    <div class="flex justify-between items-center px-4 py-3">
                        <span class="font-medium text-gray-700">Grader Of:</span>
                        <span class="text-gray-800">${grader["Grader of Teacher in Current Session"]}</span>
                    </div>
                    <div class="px-4 py-3 flex flex-col space-y-2">
                        <div class="w-full">
                            ${grader.status.toLowerCase() === "active" ?
                        `<a href="${studentDetailsUrl}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded block text-center">History</a>` :
                        `<button onclick="assignGrader(${grader.grader_id}, '${grader.name}','${grader.regNo}','${grader.image}')" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded block text-center w-full">Assign</button>`
                    }
                        </div>
                    </div>
                </div>
            </div>`;
            });
        }


        async function confirmAssignment() {
            try {
                let API_BASE_URL = await getApiBaseUrl();
                let graderId = document.getElementById("graderId").value;
                let teacherId = document.getElementById("assignTeacherDropdown").value; // Changed ID here

                if (!teacherId) {
                    alert("Please select a teacher.");
                    return;
                }

                let requestData = {
                    teacher_id: teacherId,
                    grader_id: graderId
                };

                let response = await fetch(`${API_BASE_URL}api/Datacells/assign-grader`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(requestData)
                });

                let data = await response.json();

                if (data.status === "success") {
                    alert(`Success: ${data.message}\nGrader ID: ${data.grader_id}\nTeacher ID: ${data.teacher_id}\nSession ID: ${data.session_id}`);
                    await loadGraders();
                    closeModal();
                } else if (data.status === "error") {
                    alert(`Error: ${data.message}\nGrader ID: ${data.grader_id}\nSession ID: ${data.session_id}`);
                } else {
                    alert("Unexpected response from server");
                    console.error(data);
                }
            } catch (error) {
                alert("An unexpected error occurred: " + error.message);
                console.error(error);
            }
        }

        async function assignGrader(graderId, name, regNo, imageUrl = null) {
            document.getElementById("graderName").innerText = name;
            document.getElementById("graderRegNo").innerText = "RegNo: " + regNo;
            document.getElementById("graderId").value = graderId;

            let imageElement = document.getElementById("graderImage");
            let defaultAvatar = document.getElementById("defaultAvatar");

            if (imageUrl) {
                imageElement.src = imageUrl;
                imageElement.classList.remove("hidden");
                defaultAvatar.classList.add("hidden");
            } else {
                imageElement.classList.add("hidden");
                defaultAvatar.classList.remove("hidden");
            }

            try {
                API_BASE_URL = await getApiBaseUrl();
                let response = await fetch(`${API_BASE_URL}api/Dropdown/get-teachers`);
                let data = await response.json();

                let teacherDropdown = document.getElementById("assignTeacherDropdown"); // Changed ID here
                teacherDropdown.innerHTML = `<option value="">Select Teacher</option>`;

                if (data && data.length > 0) {
                    data.forEach(teacher => {
                        let option = document.createElement("option");
                        option.value = teacher.id;
                        option.textContent = teacher.name;
                        teacherDropdown.appendChild(option);
                    });
                } else {
                    teacherDropdown.innerHTML = `<option value="">No Teachers Available</option>`;
                }
            } catch (error) {
                console.error("Error fetching teachers:", error);
                alert("Failed to load teachers. Please try again.");
            }

            document.getElementById("assignModal").classList.remove("hidden");
        }
        function closeModal() {
            document.getElementById("assignModal").classList.add("hidden");
        }

        document.addEventListener("DOMContentLoaded", loadGraders);
        async function openAddGraderForm() {
            document.getElementById("addGraderForm").classList.remove("hidden");
            await populateDropdowns();
        }

        async function populateDropdowns() {
            let API_BASE_URL = await getApiBaseUrl();

            try {
                let teachersResponse = await fetch(`${API_BASE_URL}api/Dropdown/get-teachers`);
                let teachersData = await teachersResponse.json();
                let teacherDropdown = document.getElementById("teacherDropdown");
                teacherDropdown.innerHTML = '<option value="">Select Teacher</option>';
                teachersData.forEach(teacher => {
                    teacherDropdown.innerHTML += `<option value="${teacher.id}">${teacher.name}</option>`;
                });

                // Fetch students
                let studentsResponse = await fetch(`${API_BASE_URL}api/Dropdown/get-students`);
                let studentsData = await studentsResponse.json();
                let studentDropdown = document.getElementById("studentDropdown");
                studentDropdown.innerHTML = '<option value="">Select Student</option>';
                studentsData.forEach(student => {
                    studentDropdown.innerHTML += `<option value="${student.id}">${student.name}</option>`;
                });

                // Fetch sessions
                let sessionResponse = await fetch(`${API_BASE_URL}api/Dropdown/AllSession`);
                let sessionData = await sessionResponse.json();
                let sessionDropdown = document.getElementById("sessionDropdown");
                sessionData.forEach(student => {
                    sessionDropdown.innerHTML += `<option value="${student.id}">${student.name}</option>`;
                });


            } catch (error) {
                alert("Failed to fetch dropdown data: " + error.message);
            }
        }
        async function addGrader() {
            try {
                let API_BASE_URL = await getApiBaseUrl();
                let teacherId = document.getElementById("teacherDropdown").value;
                let studentId = document.getElementById("studentDropdown").value;
                let sessionId = document.getElementById("sessionDropdown").value;
                let type = document.getElementById("typeDropdown").value;

                // Validation
                if (!teacherId || !studentId || !sessionId) {
                    alert("Please fill in all required fields.");
                    return;
                }

                let requestData = {
                    teacher_id: teacherId,
                    grader_id: studentId,
                    session_id: sessionId,
                    type: type || null
                };

                let response = await fetch(`${API_BASE_URL}api/Datacells/add-grader`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(requestData)
                });

                let data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to add grader');
                }

                if (data.status === "success") {
                    alert(`Success: ${data.message || 'Grader added successfully!'}`);
                    resetAddGraderForm();
                    document.getElementById("addGraderForm").classList.add("hidden");
                    await loadGraders();
                } else {
                    throw new Error(data.message || parseErrorMessage(data.error));
                }
            } catch (error) {
                console.error('Add Grader Error:', error);
                alert(`Error: ${error.message}`);
            }
        }

        function parseErrorMessage(error) {
            if (!error) return "Unknown error occurred";

            if (typeof error === 'string') return error;

            if (Array.isArray(error)) {
                return error.join('\n');
            }

            if (typeof error === 'object') {
                return Object.entries(error)
                    .map(([key, value]) => `${key}: ${Array.isArray(value) ? value.join(', ') : value}`)
                    .join('\n');
            }

            return "Unexpected error format";
        }

        function parseErrorMessage(error) {
            if (typeof error === 'string') {
                return error; // Return as-is if it's already plain text
            } else if (typeof error === 'object' && error !== null) {
                if (Array.isArray(error)) {
                    return error.join(', '); // Convert array errors to comma-separated text
                } else {
                    let messages = [];
                    for (const key in error) {
                        if (Array.isArray(error[key])) {
                            messages.push(`${key}: ${error[key].join(', ')}`);
                        } else {
                            messages.push(`${key}: ${error[key]}`);
                        }
                    }
                    return messages.join('\n'); // Return as multi-line text
                }
            }
            return "An unexpected error occurred."; // Default fallback
        }

        function resetAddGraderForm() {
            document.getElementById("teacherDropdown").value = "";
            document.getElementById("studentDropdown").value = "";
            document.getElementById("typeDropdown").value = "";
        }

    </script>
</head>

<body class="bg-gray-100">
    @include('admin.navbar')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Graders For Current
            Session</h2>

        <div class="mb-6 p-4 bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 text-center sm:text-left">Search & Filters</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Search by Grader Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Grader Name</label>
                    <input type="text" id="search-name" class="border rounded-lg p-2 w-full" oninput="searchGraders()"
                        placeholder="Enter grader name">
                </div>

                <!-- Search by Teacher Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Teacher Name</label>
                    <input type="text" id="search-teacher" class="border rounded-lg p-2 w-full"
                        oninput="searchGraders()" placeholder="Enter teacher name">
                </div>

                <!-- Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Type</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="type-filter" value="merit" onclick="handleTypeFilter(this.value)">
                            <span class="text-sm text-gray-700">Merit-based</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="type-filter" value="need-based"
                                onclick="handleTypeFilter(this.value)">
                            <span class="text-sm text-gray-700">Need-based</span>
                        </label>
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                    <select id="status-filter" class="border rounded-lg p-2 w-full"
                        onchange="handleStatusFilter(this.value)">
                        <option value="">Select Status</option>
                        <option value="active">Active</option>
                        <option value="in-active">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-between mt-4">
                <button onclick="resetSearch()" class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg">
                    Reset Filters
                </button>
                <div class="btn"> <button onclick="openAddGraderForm()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                        Add Grader
                    </button>
                    <a href="{{ route('show.grader') }}"
                        class="bg-green-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg inline-block">
                        Upload Excel
                    </a>

                </div>

            </div>
        </div>
        <div id="addGraderForm" class="hidden mb-6 p-4 bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 text-center sm:text-left">Add New Grader</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Teacher Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Select Teacher</label>
                    <select id="teacherDropdown" class="border rounded-lg p-2 w-full">
                        <option value="">Select Teacher</option>
                    </select>
                </div>

                <!-- Student Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Select Student</label>
                    <select id="studentDropdown" class="border rounded-lg p-2 w-full">
                        <option value="">Select Student</option>
                    </select>
                </div>

                <!-- Session Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Select Session</label>
                    <select id="sessionDropdown" class="border rounded-lg p-2 w-full">
                        <option value="">Select Session</option>
                    </select>
                </div>

                <!-- Type (Optional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Type (Optional)</label>
                    <select id="typeDropdown" class="border rounded-lg p-2 w-full">
                        <option value="">Select Type</option>
                        <option value="merit">Merit-based</option>
                        <option value="need-based">Need-based</option>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center sm:justify-end mt-4">
                <button onclick="addGrader()" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                    Submit
                </button>
            </div>
        </div>
        <div id="table-wrapper" class="table-container mx-auto max-w-7xl overflow-x-auto">
            <!-- Regular table for desktop -->
            <table class="border border-gray-300 shadow-lg bg-white w-full hidden sm:table">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 min-w-120">Grader Of</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody id="grader-table-body"></tbody>
            </table>

            <!-- Mobile cards container (only shows on small screens) -->
            <div class="sm:hidden">
                <div id="grader-mobile-container" class="space-y-4 px-2"></div>
            </div>
        </div>
    </div>

    <div id="assignModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 w-96 sm:w-[450px] rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-700 mb-4 text-center">Assign Grader</h2>

            <!-- Grader Info Section -->
            <div class="flex flex-col items-center">
                <!-- Circular Image Placeholder -->
                <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                    <img id="graderImage" src="" class="w-full h-full object-cover hidden">
                    <span id="defaultAvatar" class="text-gray-500 text-sm">No Image</span>
                </div>

                <!-- Grader Name & RegNo -->
                <p id="graderName" class="mt-2 text-lg font-bold text-gray-800"></p>
                <p id="graderRegNo" class="text-gray-600 text-sm"></p>

                <!-- Hidden Grader ID -->
                <input type="hidden" id="graderId">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Select Teacher</label>
                <select id="assignTeacherDropdown" class="border rounded-lg p-2 w-full">
                    <option value="">Select Teacher</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between mt-6">
                <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="confirmAssignment()"
                    class="bg-green-500 text-white px-4 py-2 rounded-md">Confirm</button>
            </div>
        </div>
    </div>

    @include('components.footer')
</body>

</html> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grader List</title>
    @vite('resources/css/app.css')
    <style>
        .table-container {
            transition: all 0.3s ease-in-out;
        }

        .search-active .table-container {
            max-width: 80%;
        }
    </style>
    <script>
        let graders = [];
        let filteredGraders = [];
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let itemsToShow = 10;
        let selectedType = "";
        let selectedStatus = "";

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        async function loadGraders() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/grades`);
                const data = await response.json();
                console.log('graders info' + data)
                if (data.Grader) {
                    console.log(data)
                    graders = data.Grader;
                    console.log(data)
                    filteredGraders = [...graders];
                    renderGraders();
                }
            } catch (error) {
                console.error("Error fetching graders:", error);
            }
        }

        function searchGraders() {
            const nameSearch = document.getElementById("search-name").value.toLowerCase();
            const teacherSearch = document.getElementById("search-teacher").value.toLowerCase();

            filteredGraders = graders.filter(grader =>
                (grader.name.toLowerCase().includes(nameSearch) || nameSearch === "") &&
                (grader["Grader of Teacher in Current Session"].toLowerCase().includes(teacherSearch) || teacherSearch === "") &&
                (selectedType === "" || grader.type === selectedType) &&
                (selectedStatus === "" || grader.status === selectedStatus)
            );

            renderGraders();
            document.getElementById("table-wrapper").classList.add("search-active");
        }

        function resetSearch() {
            document.getElementById("search-name").value = "";
            document.getElementById("search-teacher").value = "";
            document.getElementById("status-filter").value = "";
            document.querySelectorAll("input[name='type-filter']").forEach(radio => radio.checked = false);
            selectedType = "";
            selectedStatus = "";
            filteredGraders = [...graders];
            renderGraders();
            document.getElementById("table-wrapper").classList.remove("search-active");
        }

        function handleTypeFilter(type) {
            selectedType = type;
            searchGraders();
        }

        function handleStatusFilter(status) {
            selectedStatus = status;
            searchGraders();
        }

        function renderGraders() {
            const tableBody = document.getElementById("grader-table-body");
            const mobileContainer = document.getElementById("grader-mobile-container");

            // Clear both containers
            tableBody.innerHTML = "";
            mobileContainer.innerHTML = "";

            if (filteredGraders.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-gray-500">No graders found.</td></tr>';
                mobileContainer.innerHTML = '<div class="text-center py-4 text-gray-500">No graders found.</div>';
                return;
            }

            filteredGraders.forEach(grader => {
                const studentDetailsUrl = `{{ route('grader.details') }}?student_id=${grader.student_id}`;

                console.log(`History URL for ${grader.student_id}:`, studentDetailsUrl);

                // Base action buttons - History is always shown
                let actionButton = `<a href="${studentDetailsUrl}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded mr-2">History</a>`;

                // Show Remove button only if grader is active
                if (grader.status.toLowerCase() === "active") {
                    actionButton += `<button onclick="confirmRemoveGrader(${grader.grader_id})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Remove</button>`;
                }
                // If the grader is inactive, show Assign button
                else {
                    actionButton += `<button onclick="assignGrader(${grader.grader_id}, '${grader.name}', '${grader.regNo}', '${grader.image}')" class="bg-green-500 text-white px-3 py-1 rounded">Assign</button>`;
                }

                tableBody.innerHTML += `
            <tr class="border-b border-gray-300 text-center hover:bg-gray-50">
                <td class="px-4 py-2">${grader.name}</td>
                <td class="px-4 py-2">${grader.status}</td>
                <td class="px-4 py-2">${grader["Grader of Teacher in Current Session"]}</td>
                <td class="px-4 py-2">
                    ${actionButton}
                </td>
            </tr>`;

                // Add card to mobile container
                mobileContainer.innerHTML += `
            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                <div class="bg-blue-500 text-white px-4 py-2 font-medium text-center">
                    ${grader.name}
                </div>
                <div class="divide-y divide-gray-200">
                    <div class="flex justify-between items-center px-4 py-3">
                        <span class="font-medium text-gray-700">Status:</span>
                        <span class="${grader.status.toLowerCase() === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'} py-1 px-2 rounded-full text-sm">
                            ${grader.status}
                        </span>
                    </div>
                    <div class="flex justify-between items-center px-4 py-3">
                        <span class="font-medium text-gray-700">Grader Of:</span>
                        <span class="text-gray-800">${grader["Grader of Teacher in Current Session"]}</span>
                    </div>
                    <div class="px-4 py-3 flex flex-col space-y-2">
                        <div class="w-full flex gap-2">
                            <a href="${studentDetailsUrl}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded block text-center flex-1">History</a>
                            ${grader.status.toLowerCase() === "active" ?
                        `<button onclick="confirmRemoveGrader(${grader.grader_id})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded block text-center flex-1">Remove</button>`
                        : ''}
                        </div>
                        ${grader.status.toLowerCase() !== "active" ?
                        `<button onclick="assignGrader(${grader.grader_id}, '${grader.name}','${grader.regNo}','${grader.image}')" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded block text-center w-full">Assign</button>`
                        : ''}
                    </div>
                </div>
            </div>`;
            });
        }
        async function confirmRemoveGrader(graderId) {
            if (confirm("Are you sure you want to remove this student as grader?")) {
                await removeGrader(graderId);
            }
        }

        async function removeGrader(graderId) {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Datacells/remove-grader`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ grader_id: graderId })
                });

                const data = await response.json();

                if (data.status === "success") {
                    alert(`Success: ${data.message}`);
                    await loadGraders();
                } else {
                    alert(`Error: ${data.message}`);
                }
            } catch (error) {
                console.error("Error removing grader:", error);
                alert("An error occurred while removing the grader.");
            }
        }

        async function confirmAssignment() {
            try {
                let API_BASE_URL = await getApiBaseUrl();
                let graderId = document.getElementById("graderId").value;
                let teacherId = document.getElementById("assignTeacherDropdown").value;

                if (!teacherId) {
                    alert("Please select a teacher.");
                    return;
                }

                let requestData = {
                    teacher_id: teacherId,
                    grader_id: graderId
                };

                let response = await fetch(`${API_BASE_URL}api/Datacells/assign-grader`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(requestData)
                });

                let data = await response.json();

                if (data.status === "success") {
                    alert(`Success: ${data.message}\nGrader ID: ${data.grader_id}\nTeacher ID: ${data.teacher_id}\nSession ID: ${data.session_id}`);
                    await loadGraders();
                    closeModal();
                } else if (data.status === "error") {
                    alert(`Error: ${data.message}\nGrader ID: ${data.grader_id}\nSession ID: ${data.session_id}`);
                } else {
                    alert("Unexpected response from server");
                    console.error(data);
                }
            } catch (error) {
                alert("An unexpected error occurred: " + error.message);
                console.error(error);
            }
        }

        async function assignGrader(graderId, name, regNo, imageUrl = null) {
            document.getElementById("graderName").innerText = name;
            document.getElementById("graderRegNo").innerText = "RegNo: " + regNo;
            document.getElementById("graderId").value = graderId;

            let imageElement = document.getElementById("graderImage");
            let defaultAvatar = document.getElementById("defaultAvatar");

            if (imageUrl) {
                imageElement.src = imageUrl;
                imageElement.classList.remove("hidden");
                defaultAvatar.classList.add("hidden");
            } else {
                imageElement.classList.add("hidden");
                defaultAvatar.classList.remove("hidden");
            }

            try {
                API_BASE_URL = await getApiBaseUrl();
                let response = await fetch(`${API_BASE_URL}api/Dropdown/get-teachers`);
                let data = await response.json();

                let teacherDropdown = document.getElementById("assignTeacherDropdown");
                teacherDropdown.innerHTML = `<option value="">Select Teacher</option>`;

                if (data && data.length > 0) {
                    data.forEach(teacher => {
                        let option = document.createElement("option");
                        option.value = teacher.id;
                        option.textContent = teacher.name;
                        teacherDropdown.appendChild(option);
                    });
                } else {
                    teacherDropdown.innerHTML = `<option value="">No Teachers Available</option>`;
                }
            } catch (error) {
                console.error("Error fetching teachers:", error);
                alert("Failed to load teachers. Please try again.");
            }

            document.getElementById("assignModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("assignModal").classList.add("hidden");
        }

        document.addEventListener("DOMContentLoaded", loadGraders);

        async function openAddGraderForm() {
            document.getElementById("addGraderForm").classList.remove("hidden");
            await populateDropdowns();
        }

        async function populateDropdowns() {
            let API_BASE_URL = await getApiBaseUrl();

            try {
                let teachersResponse = await fetch(`${API_BASE_URL}api/Dropdown/get-teachers`);
                let teachersData = await teachersResponse.json();
                let teacherDropdown = document.getElementById("teacherDropdown");
                teacherDropdown.innerHTML = '<option value="">Select Teacher</option>';
                teachersData.forEach(teacher => {
                    teacherDropdown.innerHTML += `<option value="${teacher.id}">${teacher.name}</option>`;
                });

                // Fetch students
                let studentsResponse = await fetch(`${API_BASE_URL}api/Dropdown/get-students`);
                let studentsData = await studentsResponse.json();
                let studentDropdown = document.getElementById("studentDropdown");
                studentDropdown.innerHTML = '<option value="">Select Student</option>';
                studentsData.forEach(student => {
                    studentDropdown.innerHTML += `<option value="${student.id}">${student.name}</option>`;
                });

                // Fetch sessions
                let sessionResponse = await fetch(`${API_BASE_URL}api/Dropdown/AllSession`);
                let sessionData = await sessionResponse.json();
                let sessionDropdown = document.getElementById("sessionDropdown");
                sessionData.forEach(student => {
                    sessionDropdown.innerHTML += `<option value="${student.id}">${student.name}</option>`;
                });

            } catch (error) {
                alert("Failed to fetch dropdown data: " + error.message);
            }
        }

        async function addGrader() {
            try {
                let API_BASE_URL = await getApiBaseUrl();
                let teacherId = document.getElementById("teacherDropdown").value;
                let studentId = document.getElementById("studentDropdown").value;
                let sessionId = document.getElementById("sessionDropdown").value;
                let type = document.getElementById("typeDropdown").value;

                // Validation
                if (!teacherId || !studentId || !sessionId) {
                    alert("Please fill in all required fields.");
                    return;
                }

                let requestData = {
                    teacher_id: teacherId,
                    grader_id: studentId,
                    session_id: sessionId,
                    type: type || null
                };

                let response = await fetch(`${API_BASE_URL}api/Datacells/add-grader`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(requestData)
                });

                let data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to add grader');
                }

                if (data.status === "success") {
                    alert(`Success: ${data.message || 'Grader added successfully!'}`);
                    resetAddGraderForm();
                    document.getElementById("addGraderForm").classList.add("hidden");
                    await loadGraders();
                } else {
                    throw new Error(data.message || parseErrorMessage(data.error));
                }
            } catch (error) {
                console.error('Add Grader Error:', error);
                alert(`Error: ${error.message}`);
            }
        }

        function parseErrorMessage(error) {
            if (!error) return "Unknown error occurred";

            if (typeof error === 'string') return error;

            if (Array.isArray(error)) {
                return error.join('\n');
            }

            if (typeof error === 'object') {
                return Object.entries(error)
                    .map(([key, value]) => `${key}: ${Array.isArray(value) ? value.join(', ') : value}`)
                    .join('\n');
            }

            return "Unexpected error format";
        }

        function resetAddGraderForm() {
            document.getElementById("teacherDropdown").value = "";
            document.getElementById("studentDropdown").value = "";
            document.getElementById("typeDropdown").value = "";
        }

    </script>
</head>

<body class="bg-gray-100">
    @include('admin.navbar')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Graders For Current
            Session</h2>

        <div class="mb-6 p-4 bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 text-center sm:text-left">Search & Filters</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Search by Grader Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Grader Name</label>
                    <input type="text" id="search-name" class="border rounded-lg p-2 w-full" oninput="searchGraders()"
                        placeholder="Enter grader name">
                </div>

                <!-- Search by Teacher Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Teacher Name</label>
                    <input type="text" id="search-teacher" class="border rounded-lg p-2 w-full"
                        oninput="searchGraders()" placeholder="Enter teacher name">
                </div>

                <!-- Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Type</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="type-filter" value="merit" onclick="handleTypeFilter(this.value)">
                            <span class="text-sm text-gray-700">Merit-based</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="type-filter" value="need-based"
                                onclick="handleTypeFilter(this.value)">
                            <span class="text-sm text-gray-700">Need-based</span>
                        </label>
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                    <select id="status-filter" class="border rounded-lg p-2 w-full"
                        onchange="handleStatusFilter(this.value)">
                        <option value="">Select Status</option>
                        <option value="active">Active</option>
                        <option value="in-active">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-between mt-4">
                <button onclick="resetSearch()" class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg">
                    Reset Filters
                </button>
                <div class="btn"> <button onclick="openAddGraderForm()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                        Add Grader
                    </button>
                    <a href="{{ route('show.grader') }}"
                        class="bg-green-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg inline-block">
                        Upload Excel
                    </a>

                </div>

            </div>
        </div>
        <div id="addGraderForm" class="hidden mb-6 p-4 bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 text-center sm:text-left">Add New Grader</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Teacher Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Select Teacher</label>
                    <select id="teacherDropdown" class="border rounded-lg p-2 w-full">
                        <option value="">Select Teacher</option>
                    </select>
                </div>

                <!-- Student Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Select Student</label>
                    <select id="studentDropdown" class="border rounded-lg p-2 w-full">
                        <option value="">Select Student</option>
                    </select>
                </div>

                <!-- Session Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Select Session</label>
                    <select id="sessionDropdown" class="border rounded-lg p-2 w-full">
                        <option value="">Select Session</option>
                    </select>
                </div>

                <!-- Type (Optional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Type (Optional)</label>
                    <select id="typeDropdown" class="border rounded-lg p-2 w-full">
                        <option value="">Select Type</option>
                        <option value="merit">Merit-based</option>
                        <option value="need-based">Need-based</option>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center sm:justify-end mt-4">
                <button onclick="addGrader()" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                    Submit
                </button>
            </div>
        </div>
        <div id="table-wrapper" class="table-container mx-auto max-w-7xl overflow-x-auto">
            <!-- Regular table for desktop -->
            <table class="border border-gray-300 shadow-lg bg-white w-full hidden sm:table">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 min-w-120">Grader Of</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody id="grader-table-body"></tbody>
            </table>

            <!-- Mobile cards container (only shows on small screens) -->
            <div class="sm:hidden">
                <div id="grader-mobile-container" class="space-y-4 px-2"></div>
            </div>
        </div>
    </div>

    <div id="assignModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 w-96 sm:w-[450px] rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-700 mb-4 text-center">Assign Grader</h2>

            <!-- Grader Info Section -->
            <div class="flex flex-col items-center">
                <!-- Circular Image Placeholder -->
                <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                    <img id="graderImage" src="" class="w-full h-full object-cover hidden">
                    <span id="defaultAvatar" class="text-gray-500 text-sm">No Image</span>
                </div>

                <!-- Grader Name & RegNo -->
                <p id="graderName" class="mt-2 text-lg font-bold text-gray-800"></p>
                <p id="graderRegNo" class="text-gray-600 text-sm"></p>

                <!-- Hidden Grader ID -->
                <input type="hidden" id="graderId">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Select Teacher</label>
                <select id="assignTeacherDropdown" class="border rounded-lg p-2 w-full">
                    <option value="">Select Teacher</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between mt-6">
                <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                <button onclick="confirmAssignment()"
                    class="bg-green-500 text-white px-4 py-2 rounded-md">Confirm</button>
            </div>
        </div>
    </div>

    @include('components.footer')
</body>

</html>