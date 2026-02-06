<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session List | LMS</title>
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

        /* Session cards styling */
        .session-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
            padding: 20px;
            margin-bottom: 16px;
        }
        
        .session-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        
        .current-session {
            border-left-color: #10b981;
        }
        
        .upcoming-session {
            border-left-color: #f59e0b;
        }
        
        .previous-session {
            border-left-color: #6b7280;
        }
        
        .status-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .search-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 24px 0;
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
        
        /* Spacing adjustments */
        .main-content {
            padding-bottom: 3rem;
        }
        
        .section-title {
            margin-bottom: 1.5rem;
            color: #1e40af;
            font-weight: 600;
        }

        /* Profile panel styling */
        .profile-panel {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .profile-image {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .profile-name {
            font-weight: 500;
            color: #1f2937;
        }
    </style>
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
            const cardsContainer = document.getElementById("session-cards-container");
            cardsContainer.innerHTML = "";

            if (filteredSessions.length === 0) {
                cardsContainer.innerHTML = `
                    <div class="text-center py-8 bg-white rounded-xl shadow-sm">
                        <i class="fas fa-calendar-times text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No sessions match your search criteria</p>
                    </div>`;
                return;
            }

            filteredSessions.forEach(session => {
                // Determine status class and color
                let statusClass = '';
                let statusColor = '';
                if (session.status === 'Current') {
                    statusClass = 'current-session';
                    statusColor = 'bg-green-100 text-green-800';
                } else if (session.status === 'Upcoming') {
                    statusClass = 'upcoming-session';
                    statusColor = 'bg-yellow-100 text-yellow-800';
                } else {
                    statusClass = 'previous-session';
                    statusColor = 'bg-gray-100 text-gray-800';
                }

                cardsContainer.innerHTML += `
                    <div class="session-card ${statusClass}">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                    <i class="fas fa-calendar-alt text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">${session.name}</h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="status-badge ${statusColor}">${session.status}</span>
                                        <span class="text-sm text-gray-500">${session.remaining_time}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 sm:text-right">
                                <div>${session.end_date}</div>
                            </div>
                        </div>
                    </div>`;
            });
        }

        document.addEventListener("DOMContentLoaded", loadSessions);
    </script>
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
    <div class="container mx-auto px-4 py-8 main-content">
        <div class="max-w-6xl mx-auto">
            <!-- Search and Filter Section -->
            <div class="search-container">
                <h2 class="section-title text-2xl font-bold mb-6">Academic Sessions</h2>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-1">
                        <input 
                            type="text" 
                            id="search-input" 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search sessions..."
                            oninput="searchSessions()"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    <select 
                        id="status-filter" 
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        onchange="filterByStatus()"
                    >
                        <option value="All">All Sessions</option>
                        <option value="Current">Current</option>
                        <option value="Upcoming">Upcoming</option>
                        <option value="Previous">Previous</option>
                    </select>
                </div>
            </div>

            <!-- Sessions List -->
            <div id="session-cards-container" class="mt-6 space-y-4">
                <div class="text-center py-12 bg-white rounded-xl shadow-sm">
                    <div class="animate-pulse flex flex-col items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full mb-4"></div>
                        <div class="h-4 bg-blue-100 rounded w-1/3 mb-2"></div>
                        <div class="h-4 bg-blue-100 rounded w-1/2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Simplified Footer -->
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