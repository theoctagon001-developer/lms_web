<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporary Enrolments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .btn {
            transition: transform 0.3s ease-in-out;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        /* Loading spinner */
        .loading-spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid #2563eb;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .enrollment-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .enrollment-card img {
                margin-bottom: 1rem;
                align-self: center;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }

            .action-buttons button {
                width: 100%;
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-r from-blue-300 via-blue-200 to-blue-100 min-h-screen flex flex-col justify-between">
    @include('DATACELL.partials.nav')
    <div class="max-w-6xl mx-auto py-8 px-4 flex-1">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-700 mb-4 text-center">Temporary Enrolments</h2>
            <p class="text-gray-500 text-center mb-6">Manage and review student enrolment requests.</p>

            <!-- Search Fields -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <input type="text" id="searchRegNo" class="p-2 border rounded w-full"
                    placeholder="Search by RegNo or Name">
                <input type="text" id="searchSection" class="p-2 border rounded w-full"
                    placeholder="Search by Section">
                <input type="text" id="searchCourse" class="p-2 border rounded w-full"
                    placeholder="Search by Course">
            </div>

            <div id="loadingIndicator" class="loading-spinner"></div>
            <div id="enrollmentsContainer" class="space-y-6"></div>
            <div id="noResults" class="text-center text-gray-500 py-4 hidden">No enrollment requests found.</div>
        </div>
    </div>

    <script>
        let enrollments = [];
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";

        document.addEventListener("DOMContentLoaded", async () => {
            try {
                API_BASE_URL = await getApiBaseUrl();
                await loadData();
                
                // Setup search event listeners
                document.querySelectorAll("input").forEach(input => {
                    input.addEventListener("keyup", filterEnrollments);
                });
            } catch (error) {
                console.error("Initialization error:", error);
            }
        });

        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }

        async function loadData() {
            try {
                document.getElementById('loadingIndicator').style.display = 'block';
                document.getElementById('enrollmentsContainer').innerHTML = '';
                document.getElementById('noResults').classList.add('hidden');
                
                let response = await fetch(`${API_BASE_URL}api/Datacells/temporary-enrollments`);
                if (!response.ok) throw new Error('Network response was not ok');
                
                let result = await response.json();
                if (!result.data || result.data.length === 0) {
                    document.getElementById('noResults').classList.remove('hidden');
                    return;
                }
                
                enrollments = result.data.sort((a, b) => new Date(b["Date Time"]) - new Date(a["Date Time"]));
                displayEnrollments(enrollments);
            } catch (error) {
                console.error("Error fetching enrollments:", error);
                document.getElementById('enrollmentsContainer').innerHTML = `
                    <div class="text-center text-red-500 py-4">
                        Failed to load enrollments. Please try again later.
                    </div>
                `;
            } finally {
                document.getElementById('loadingIndicator').style.display = 'none';
            }
        }

        function filterEnrollments() {
            const regNoQuery = document.getElementById("searchRegNo").value.toLowerCase();
            const sectionQuery = document.getElementById("searchSection").value.toLowerCase();
            const courseQuery = document.getElementById("searchCourse").value.toLowerCase();
            
            const filtered = enrollments.filter(e =>
                (e["RegNo"].toLowerCase().includes(regNoQuery) || 
                 e["Student Name"].toLowerCase().includes(regNoQuery)) &&
                e["Section Name"].toLowerCase().includes(sectionQuery) &&
                e["Course Name"].toLowerCase().includes(courseQuery)
            );
            
            displayEnrollments(filtered);
            
            if (filtered.length === 0) {
                document.getElementById('noResults').classList.remove('hidden');
            } else {
                document.getElementById('noResults').classList.add('hidden');
            }
        }

        function displayEnrollments(data) {
            const container = document.getElementById("enrollmentsContainer");
            container.innerHTML = "";
            
            data.forEach(enrollment => {
                const div = document.createElement("div");
                div.className = "bg-gray-50 p-4 md:p-6 rounded-lg shadow-md enrollment-card flex flex-col md:flex-row md:items-center md:space-x-4";
                const studentImage = enrollment["image"] ? enrollment["image"] : 'images/default_avatar.png';

                div.innerHTML = `
                    <img src="${studentImage}" alt="Student Avatar" class="w-16 h-16 rounded-full shadow-md self-center md:self-auto">
                    <div class="flex-1 mt-4 md:mt-0">
                        <h3 class="text-lg md:text-xl font-bold text-gray-700">${enrollment["Student Name"]} (${enrollment["RegNo"]})</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                            <p class="text-gray-500"><strong>Teacher:</strong> ${enrollment["Teacher Name"]}</p>
                            <p class="text-gray-500"><strong>Course:</strong> ${enrollment["Course Name"]}</p>
                            <p class="text-gray-500"><strong>Section:</strong> ${enrollment["Section Name"]}</p>
                            <p class="text-gray-500"><strong>Session:</strong> ${enrollment["Session Name"]}</p>
                            <p class="text-gray-500"><strong>Venue:</strong> ${enrollment["Venue"]}</p>
                            <p class="text-gray-500"><strong>Requested At:</strong> ${new Date(enrollment["Date Time"]).toLocaleString()}</p>
                        </div>
                        ${enrollment["Message"] ? `<p class="italic text-gray-600 mt-2">${enrollment["Message"]}</p>` : ''}
                        <div class="mt-4 action-buttons flex flex-col sm:flex-row gap-2">
                            <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded btn" 
                                    onclick="acceptEnrollment('${enrollment["Request id"]}')">
                                Accept
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded btn" 
                                    onclick="rejectEnrollment('${enrollment["Request id"]}')">
                                Reject
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(div);
            });
        }

        async function processTemporaryEnrollment(tempEnrollId, verification) {
            if (!confirm(`Are you sure you want to ${verification.toLowerCase()} this enrollment request?`)) {
                return;
            }

            try {
                const response = await fetch(`${API_BASE_URL}api/Datacells/process-temporary-enrollments`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        temp_enroll_id: tempEnrollId,
                        verification: verification
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    alert(`Success: ${data.message}`);
                    await loadData(); // Reload data after successful API call
                } else {
                    throw new Error(data.message || 'Failed to process request');
                }
            } catch (error) {
                console.error('Error:', error);
                alert(`Error: ${error.message}`);
            }
        }

        // Global functions for button clicks
        window.acceptEnrollment = function(tempEnrollId) {
            processTemporaryEnrollment(tempEnrollId, 'Accepted');
        };

        window.rejectEnrollment = function(tempEnrollId) {
            processTemporaryEnrollment(tempEnrollId, 'Rejected');
        };
    </script>

    @include('components.footer')
</body>

</html>