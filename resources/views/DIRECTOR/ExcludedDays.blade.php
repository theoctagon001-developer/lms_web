<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Excluded Days Management</title>
    @vite('resources/css/app.css')
    <style>
        .day-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .day-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        .day-card.holiday {
            border-left-color: #F59E0B;
        }
        .day-card.exam {
            border-left-color: #10B981;
        }
        .day-card.reschedule {
            border-left-color: #3B82F6;
        }
        .badge-holiday {
            background-color: #F59E0B;
        }
        .badge-exam {
            background-color: #10B981;
        }
        .badge-reschedule {
            background-color: #3B82F6;
        }
        .sticky-top-bar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .footer {
            background-color: #f8fafc;
            padding: 1.5rem 0;
            border-top: 1px solid #e2e8f0;
            margin-top: 2rem;
        }
        .footer-content {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #64748b;
        }
        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background-color: #f9fafb;
            border-radius: 0.5rem;
            border: 1px dashed #cbd5e1;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Top Bar -->
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

    <div class="flex-grow container mx-auto px-4 py-6 max-w-6xl">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Excluded Days</h1>
                <p class="text-gray-500 mt-1">Manage days excluded from the academic schedule</p>
            </div>
            <button id="refreshBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                </svg>
                Refresh
            </button>
        </div>

        <!-- Filter and Search Section -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center">
                    <span class="text-gray-700 mr-2">Filter by:</span>
                    <select id="filterType" class="appearance-none bg-gray-50 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">
                        <option value="all">All Types</option>
                        <option value="Holiday">Holiday</option>
                        <option value="Exam">Exam</option>
                        <option value="Reschedule">Reschedule</option>
                    </select>
                </div>
                <div class="flex items-center flex-grow md:justify-end">
                    <div class="relative w-full md:w-64">
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Search by reason..." 
                            class="w-full bg-gray-50 border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Excluded Days List</h2>
                    <div class="flex items-center space-x-2">
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 rounded-full bg-yellow-500 mr-1"></span>
                            <span class="text-sm text-gray-600">Holiday</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-1"></span>
                            <span class="text-sm text-gray-600">Exam</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-3 h-3 rounded-full bg-blue-500 mr-1"></span>
                            <span class="text-sm text-gray-600">Reschedule</span>
                        </div>
                    </div>
                </div>

                <!-- Days List -->
                <div id="daysList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Loading skeleton will be replaced by actual content -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shimmer h-24"></div>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shimmer h-24"></div>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shimmer h-24"></div>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shimmer h-24"></div>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shimmer h-24"></div>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shimmer h-24"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container mx-auto px-4">
            <div class="footer-content">
                <div class="footer-copyright">
                    © Sharjeel | Ali | Sameer Learning Management System
                </div>
            </div>
        </div>
    </footer>

    <script>
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let excludedDays = [];

        // Initialize the application
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                // Get API base URL
                API_BASE_URL = await getApiBaseUrl();
                console.log('Using API URL:', API_BASE_URL);

                // Load excluded days
                await loadExcludedDays();

                // Setup event listeners
                setupEventListeners();
            } catch (error) {
                console.error('Initialization error:', error);
                showAlert('Failed to initialize. Please refresh the page.', 'error');
            }
        });

        async function getApiBaseUrl() {
            try {
                const response = await fetch('/get-api-url');
                const data = await response.json();
                return data.api_base_url;
            } catch (error) {
                console.warn('Using default API URL');
                return API_BASE_URL;
            }
        }

        async function loadExcludedDays() {
            try {
                showLoading(true);
                const response = await fetch(`${API_BASE_URL}api/Admin/excluded-days`);

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const result = await response.json();
                console.log('Excluded days:', result);

                if (result.status && Array.isArray(result.data)) {
                    excludedDays = result.data;
                    renderDaysList();
                } else {
                    throw new Error('Invalid response format');
                }
            } catch (error) {
                console.error('Error loading excluded days:', error);
                document.getElementById('daysList').innerHTML = `
                    <div class="col-span-full empty-state">
                        <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">Error Loading Data</h3>
                        <p class="text-gray-500 mt-1">Error: ${error.message}</p>
                        <button id="retryBtn" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Retry
                        </button>
                    </div>
                `;
                
                // Add retry button functionality
                document.getElementById('retryBtn')?.addEventListener('click', loadExcludedDays);
            } finally {
                showLoading(false);
            }
        }

        function renderDaysList(filterType = 'all', searchTerm = '') {
            const container = document.getElementById('daysList');

            if (excludedDays.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full empty-state">
                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">No Excluded Days</h3>
                        <p class="text-gray-500 mt-1">No excluded days have been added yet.</p>
                    </div>
                `;
                return;
            }

            // Filter days if needed
            let filteredDays = excludedDays;
            
            // Apply type filter if not "all"
            if (filterType !== 'all') {
                filteredDays = filteredDays.filter(day => day.type === filterType);
            }
            
            // Apply search term if provided
            if (searchTerm) {
                const term = searchTerm.toLowerCase();
                filteredDays = filteredDays.filter(day => 
                    day.reason.toLowerCase().includes(term)
                );
            }

            if (filteredDays.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full empty-state">
                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">No Matching Results</h3>
                        <p class="text-gray-500 mt-1">Try adjusting your search or filter criteria.</p>
                    </div>
                `;
                return;
            }

            // Sort the days by date (newest first)
            filteredDays.sort((a, b) => new Date(b.date) - new Date(a.date));

            container.innerHTML = filteredDays.map(day => {
                const date = new Date(day.date);
                const formattedDate = date.toLocaleDateString('en-US', {
                    weekday: 'short',
                    month: 'short', 
                    day: 'numeric', 
                    year: 'numeric'
                });
                
                const typeClass = day.type.toLowerCase();
                
                return `
                <div class="day-card ${typeClass} bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md">
                    <div class="p-4">
                        <div class="flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full text-white
                                    ${day.type === 'Holiday' ? 'badge-holiday' :
                                      day.type === 'Exam' ? 'badge-exam' : 'badge-reschedule'}">
                                    ${day.type}
                                </span>
                                <span class="text-sm text-gray-500 font-medium">${formattedDate}</span>
                            </div>
                            <h3 class="font-medium text-gray-800">${day.reason}</h3>
                        </div>
                    </div>
                </div>
                `;
            }).join('');
        }

        function showLoading(show) {
            // Loading is controlled by the presence/absence of the shimmer elements
            // which are already in the HTML. They'll be replaced when data loads.
        }

        function setupEventListeners() {
            // Filter change
            document.getElementById('filterType').addEventListener('change', (e) => {
                const searchTerm = document.getElementById('searchInput').value;
                renderDaysList(e.target.value, searchTerm);
            });
            
            // Search input
            document.getElementById('searchInput').addEventListener('input', (e) => {
                const filterType = document.getElementById('filterType').value;
                renderDaysList(filterType, e.target.value);
            });
            
            // Refresh button
            document.getElementById('refreshBtn').addEventListener('click', loadExcludedDays);
        }

        function showAlert(message, type = 'info') {
            // Determine the background color based on the alert type
            let bgColor;
            switch(type) {
                case 'success':
                    bgColor = 'bg-green-500';
                    break;
                case 'error':
                    bgColor = 'bg-red-500';
                    break;
                case 'info':
                default:
                    bgColor = 'bg-blue-500';
                    break;
            }

            const alert = document.createElement('div');
            alert.className = `fixed top-4 right-4 px-6 py-4 rounded-md text-white ${bgColor} shadow-lg z-50`;
            alert.textContent = message;
            document.body.appendChild(alert);

            // Add subtle animation
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            alert.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

            setTimeout(() => {
                alert.style.opacity = '1';
                alert.style.transform = 'translateY(0)';
            }, 10);

            // Remove the alert after 5 seconds with a fade-out effect
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';

                setTimeout(() => alert.remove(), 300);
            }, 5000);
        }
    </script>
</body>
</html>