<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session List</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        let sessions = [];
        let filteredSessions = [];
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
        async function loadSessions() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Admin/sessions`);
                const data = await response.json();
                if (data.data) {
                    sessions = data.data;
                    filteredSessions = [...sessions];
                    renderSessions();
                }
            } catch (error) {
                console.error("Error fetching sessions:", error);
            }
        }

        function searchSessions() {
            const searchText = document.getElementById("search-input").value.toLowerCase();
            filteredSessions = sessions.filter(session =>
                session.name.toLowerCase().includes(searchText)
            );
            renderSessions();
        }

        function filterByStatus() {
            const statusFilter = document.getElementById("status-filter").value;
            if (statusFilter === "All") {
                filteredSessions = [...sessions];
            } else {
                filteredSessions = sessions.filter(session => session.status === statusFilter);
            }
            renderSessions();
        }

        function renderSessions() {
            const tableBody = document.getElementById("session-table-body");
            const cardsContainer = document.getElementById("session-cards-container");
            tableBody.innerHTML = "";
            cardsContainer.innerHTML = "";

            if (filteredSessions.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-gray-500">No sessions found.</td></tr>';
                cardsContainer.innerHTML = '<div class="p-4 text-center text-gray-500">No sessions found.</div>';
                return;
            }

            filteredSessions.forEach(session => {
                // Table row for desktop view
                tableBody.innerHTML += `
                    <tr class="border-b border-gray-300 text-center">
                        <td class="px-4 py-2">${session.id}</td>
                        <td class="px-4 py-2">${session.name}</td>
                        <td class="px-4 py-2">${session.start_date}</td>
                        <td class="px-4 py-2">${session.end_date}</td>
                        <td class="px-4 py-2">${session.remaining_time}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded ${
                                session.status === 'Current' ? 'bg-green-500 text-white' :
                                session.status === 'Upcoming' ? 'bg-yellow-500 text-white' :
                                'bg-gray-500 text-white'
                            }">${session.status}</span>
                        </td>
                        <td class="px-4 py-2">
                            <button class="bg-blue-500 text-white px-3 py-1 rounded" onclick="openEditForm(${session.id}, '${session.name}', '${session.start_date}', '${session.end_date}')">Edit</button>
                        </td>
                    </tr>`;

                // Card for mobile view
                cardsContainer.innerHTML += `
                    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold text-lg">${session.name}</h3>
                            <span class="px-2 py-1 rounded text-sm ${
                                session.status === 'Current' ? 'bg-green-500 text-white' :
                                session.status === 'Upcoming' ? 'bg-yellow-500 text-white' :
                                'bg-gray-500 text-white'
                            }">${session.status}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mb-3">
                            <div class="text-gray-600 text-sm">ID:</div>
                            <div class="text-sm font-medium">${session.id}</div>

                            <div class="text-gray-600 text-sm">Start Date:</div>
                            <div class="text-sm font-medium">${session.start_date}</div>

                            <div class="text-gray-600 text-sm">End Date:</div>
                            <div class="text-sm font-medium">${session.end_date}</div>

                            <div class="text-gray-600 text-sm">Time Left:</div>
                            <div class="text-sm font-medium">${session.remaining_time}</div>
                        </div>
                        <div class="flex justify-end">
                            <button class="bg-blue-500 text-white px-4 py-1 rounded text-sm" onclick="openEditForm(${session.id}, '${session.name}', '${session.start_date}', '${session.end_date}')">Edit</button>
                        </div>
                    </div>`;
            });
        }

        function resetSearch() {
            document.getElementById("search-input").value = "";
            document.getElementById("status-filter").value = "All";
            filteredSessions = [...sessions];
            renderSessions();
        }

        function openEditForm(id, name, startDate, endDate) {
            document.getElementById("edit-session-id").value = id;
            document.getElementById("edit-session-name").value = name;
            document.getElementById("edit-start-date").value = startDate;
            document.getElementById("edit-end-date").value = endDate;
            document.getElementById("edit-modal").classList.remove("hidden");
        }

        function closeEditForm() {
            document.getElementById("edit-modal").classList.add("hidden");
        }

        function openAddForm() {
            // Reset form fields
            document.getElementById("session-name").value = ""; // Dropdown (Fall/Spring/Summer)
            document.getElementById("session-year").value = ""; // Dropdown for year
            document.getElementById("start-date").value = "";
            document.getElementById("end-date").value = "";

            // Show modal
            document.getElementById("add-session-modal").classList.remove("hidden");
        }

        function closeAddSessionForm() {
            document.getElementById("add-session-modal").classList.add("hidden");
        }

        async function addSession() {
            showLoader();
            API_BASE_URL = await getApiBaseUrl();

            // Get values from form fields
            const name = document.getElementById("session-name").value; // Dropdown (Fall/Spring/Summer)
            const year = parseInt(document.getElementById("session-year").value); // Dropdown for year
            const startDate = document.getElementById("start-date").value;
            const endDate = document.getElementById("end-date").value;

            // Validate Dates
            if (!startDate || !endDate) {
                hideLoader();
                alert("Please select both start and end dates.");
                return;
            }
            if (new Date(startDate) >= new Date(endDate)) {
                hideLoader();
                alert("Start date must be before the end date.");
                return;
            }

            try {
                const response = await fetch(`${API_BASE_URL}api/Insertion/add-session`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        name,
                        year,
                        start_date: startDate,
                        end_date: endDate
                    })
                });

                const data = await response.json();
                if (!response.ok) {
                    hideLoader();
                    throw new Error(data.message || "Failed to add session");
                }
                hideLoader();
                alert(data.message);
                closeAddSessionForm(); // Close the modal after success
                loadSessions(); // Refresh session list
            } catch (error) {
                hideLoader();
                alert(`Error adding session: ${error.message}`);
            }
        }

        async function updateSession() {
            showLoader();
            API_BASE_URL = await getApiBaseUrl();
            const id = document.getElementById("edit-session-id").value;
            const nameInput = document.getElementById("edit-session-name").value;
            const startDate = document.getElementById("edit-start-date").value;
            const endDate = document.getElementById("edit-end-date").value;
            // Validate dates
            if (new Date(startDate) >= new Date(endDate)) {
                hideLoader();
                alert("Start date must be before the end date.");
                return;
            }

            try {
                const response = await fetch(`${API_BASE_URL}api/Insertion/update-session/${id}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        name: nameInput,
                        start_date: startDate,
                        end_date: endDate
                    })
                });

                const data = await response.json();
                if (!response.ok) {
                    hideLoader();
                    throw new Error(data.message || "Failed to update session");
                }
                hideLoader();
                alert(data.message);
                closeEditForm();
                loadSessions();
            } catch (error) {
                hideLoader();
                alert(`Error updating session: ${error.message}`);
            }
        }

        document.addEventListener("DOMContentLoaded", loadSessions);
    </script>
</head>
<body class="bg-gray-100">
        @include('HOD.partials.profile_panel')  
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-4">Session List</h2>
        <div class="mb-4 flex flex-col sm:flex-row justify-center items-center gap-4">
            <input type="text" id="search-input" class="border p-2 w-full sm:w-96 rounded" oninput="searchSessions()" placeholder="Search by Name">
            <select id="status-filter" class="border p-2 w-full sm:w-48 rounded" onchange="filterByStatus()">
                <option value="All">All</option>
                <option value="Current">Current</option>
                <option value="Upcoming">Upcoming</option>
                <option value="Previous">Previous</option>
            </select>
            <div class="flex gap-2 w-full sm:w-auto">
                <button onclick="openAddForm()" class="bg-green-500 text-white px-4 py-2 rounded flex-1">Add Session</button>
                <button onclick="resetSearch()" class="bg-gray-500 text-white px-4 py-2 rounded flex-1">Reset</button>
            </div>
        </div>
        <!-- Desktop Table View (hidden on small screens) -->
        <div class="hidden md:block table-container mx-auto max-w-5xl">
            <table class="border border-gray-300 shadow-lg bg-white w-full">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Start Date</th>
                        <th class="px-4 py-2">End Date</th>
                        <th class="px-4 py-2">Time Left</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="session-table-body">
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (shown only on small screens) -->
        <div class="md:hidden mx-auto max-w-5xl">
            <div id="session-cards-container" class="space-y-4">
                <div class="text-center py-4 text-gray-500">Loading...</div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-md mx-4">
            <h2 class="text-xl font-bold mb-4">Edit Session</h2>
            <input type="hidden" id="edit-session-id">
            <div class="mb-3">
                <label class="block font-medium mb-1">Session Name</label>
                <input type="text" id="edit-session-name" class="border p-2 w-full rounded">
            </div>
            <div class="mb-3">
                <label class="block font-medium mb-1">Start Date</label>
                <input type="date" id="edit-start-date" class="border p-2 w-full rounded">
            </div>
            <div class="mb-4">
                <label class="block font-medium mb-1">End Date</label>
                <input type="date" id="edit-end-date" class="border p-2 w-full rounded">
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <button onclick="updateSession()" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Save</button>
                <button onclick="closeEditForm()" class="bg-gray-500 text-white px-4 py-2 rounded w-full">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Add Session Modal -->
    <div id="add-session-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md mx-4">
            <h2 class="text-2xl font-bold mb-4 text-center">Add New Session</h2>

            <!-- Session Name Dropdown -->
            <div class="mb-3">
                <label class="block font-semibold mb-1">Session Name</label>
                <select id="session-name" class="border p-2 w-full rounded">
                    <option value="Fall">Fall</option>
                    <option value="Spring">Spring</option>
                    <option value="Summer">Summer</option>
                </select>
            </div>

            <!-- Year Dropdown -->
            <div class="mb-3">
                <label class="block font-semibold mb-1">Year</label>
                <select id="session-year" class="border p-2 w-full rounded"></select>
            </div>

            <!-- Start Date -->
            <div class="mb-3">
                <label class="block font-semibold mb-1">Start Date</label>
                <input type="date" id="start-date" class="border p-2 w-full rounded">
            </div>

            <!-- End Date -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">End Date</label>
                <input type="date" id="end-date" class="border p-2 w-full rounded">
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-2">
                <button onclick="addSession()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">
                    Save
                </button>
                <button onclick="closeAddSessionForm()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 w-full">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <script>
        // Auto-fill year dropdown (current year ± 5 years)
        function populateYearDropdown() {
            const yearDropdown = document.getElementById("session-year");
            const currentYear = new Date().getFullYear();
            for (let i = currentYear - 5; i <= currentYear + 5; i++) {
                let option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                if (i === currentYear) option.selected = true; // Default to current year
                yearDropdown.appendChild(option);
            }
        }

        // Run function on page load
        window.onload = populateYearDropdown;
    </script>
    @include('components.loader')
    </body>
    </html>

