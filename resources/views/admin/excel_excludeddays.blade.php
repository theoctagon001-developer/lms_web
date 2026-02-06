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
        }
        .day-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
        /* Date input custom styling */
        input[type="date"] {
            position: relative;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding: 0.5rem 1rem;
            background-color: white;
        }
        /* Make sure the calendar icon is visible and clickable */
        input[type="date"]::-webkit-calendar-picker-indicator {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            cursor: pointer;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-blue-100 via-blue-50 to-blue-100 min-h-screen p-0 m-0">
    @include('admin.navbar')

    <div class="max-w-6xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Excluded Days Management</h1>
            <button id="addDayBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add Excluded Day
            </button>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Tabs -->
            <div class="flex border-b">
                <button id="viewTab" class="px-4 py-3 font-medium text-blue-600 border-b-2 border-blue-600">View Excluded Days</button>
                <button id="uploadTab" class="px-4 py-3 font-medium text-gray-500">Bulk Upload</button>
            </div>

            <!-- View Panel -->
            <div id="viewPanel" class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-700">Current Excluded Days</h2>
                    <div class="relative">
                        <select id="filterType" class="appearance-none bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="all">All Types</option>
                            <option value="Holiday">Holiday</option>
                            <option value="Exam">Exam</option>
                            <option value="Reschedule">Reschedule</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Days List -->
                <div id="daysList" class="grid gap-4">
                    <div class="flex justify-center items-center py-12">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                        <span class="ml-2">Loading excluded days...</span>
                    </div>
                </div>
            </div>

            <!-- Upload Panel -->
            <div id="uploadPanel" class="p-6 hidden">
                <div class="max-w-md mx-auto bg-white rounded-lg p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Upload Excluded Days</h2>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="excelFile">
                            Select Excel File
                        </label>
                        <div class="flex items-center">
                            <label class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue-100">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span class="mt-2 text-base leading-normal" id="fileName">Select a file</span>
                                <input id="excelFile" type="file" class="hidden" accept=".xls,.xlsx" />
                            </label>
                        </div>
                    </div>
                    <button id="uploadBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline disabled:opacity-50" disabled>
                        Upload File
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="dayModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800" id="modalTitle">Add Excluded Day</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="dayForm" class="p-6">
                <input type="hidden" id="dayId">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="dateWrapper">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <div id="dateWrapper" class="relative">
                        <input type="date" id="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <!-- Add a visible calendar icon that will trigger the date picker -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="type">
                        Type <span class="text-red-500">*</span>
                    </label>
                    <select id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select Type</option>
                        <option value="Holiday">Holiday</option>
                        <option value="Exam">Exam</option>
                        <option value="Reschedule">Reschedule</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="reason">
                        Reason <span class="text-red-500">*</span>
                    </label>
                    <textarea id="reason" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelBtn" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit" id="saveBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let currentAction = 'add'; // 'add' or 'edit'
        let excludedDays = [];

        // Initialize the application
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                // Get API base URL
                API_BASE_URL = await getApiBaseUrl();
                console.log('Using API URL:', API_BASE_URL);

                // Set minimum date to today for the date picker
                document.getElementById('date').min = new Date().toISOString().split('T')[0];

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
                    <div class="text-center py-8 text-red-500">
                        Error loading excluded days: ${error.message}
                    </div>
                `;
            } finally {
                showLoading(false);
            }
        }

        function renderDaysList(filterType = 'all') {
            const container = document.getElementById('daysList');

            if (excludedDays.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        No excluded days found.
                    </div>
                `;
                return;
            }

            // Filter days if needed
            const filteredDays = filterType === 'all'
                ? excludedDays
                : excludedDays.filter(day => day.type === filterType);

            if (filteredDays.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        No excluded days match the selected filter.
                    </div>
                `;
                return;
            }

            container.innerHTML = filteredDays.map(day => `
                <div class="day-card bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center mb-2">
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full text-white
                                        ${day.type === 'Holiday' ? 'badge-holiday' :
                                          day.type === 'Exam' ? 'badge-exam' : 'badge-reschedule'}">
                                        ${day.type}
                                    </span>
                                    <span class="ml-2 text-sm text-gray-500">${new Date(day.date).toLocaleDateString()}</span>
                                </div>
                                <h3 class="font-medium text-gray-800">${day.reason}</h3>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="editDay(${day.id})" class="text-blue-600 hover:text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                                <button onclick="deleteDay(${day.id})" class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function showLoading(show) {
            if (show) {
                document.getElementById('daysList').innerHTML = `
                    <div class="flex justify-center items-center py-12">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                        <span class="ml-2">Loading...</span>
                    </div>
                `;
            }
        }

        function setupEventListeners() {
            // Ensure date picker works by creating a click handler for the wrapper
            document.getElementById('dateWrapper').addEventListener('click', function(e) {
                // If the click is on the wrapper but not on the input, focus and click the input
                if (e.target.id === 'dateWrapper') {
                    const dateInput = document.getElementById('date');
                    dateInput.focus();
                    // Use a small delay to ensure the input is focused before clicking
                    setTimeout(() => {
                        // Create and dispatch a mouse event on the date input to open the picker
                        const clickEvent = new MouseEvent('mousedown', {
                            bubbles: true,
                            cancelable: true,
                            view: window
                        });
                        dateInput.dispatchEvent(clickEvent);
                    }, 10);
                }
            });

            // Tab switching
            document.getElementById('viewTab').addEventListener('click', () => {
                document.getElementById('viewPanel').classList.remove('hidden');
                document.getElementById('uploadPanel').classList.add('hidden');
                document.getElementById('viewTab').classList.add('text-blue-600', 'border-blue-600');
                document.getElementById('viewTab').classList.remove('text-gray-500');
                document.getElementById('uploadTab').classList.add('text-gray-500');
                document.getElementById('uploadTab').classList.remove('text-blue-600', 'border-blue-600');
            });

            document.getElementById('uploadTab').addEventListener('click', () => {
                document.getElementById('uploadPanel').classList.remove('hidden');
                document.getElementById('viewPanel').classList.add('hidden');
                document.getElementById('uploadTab').classList.add('text-blue-600', 'border-blue-600');
                document.getElementById('uploadTab').classList.remove('text-gray-500');
                document.getElementById('viewTab').classList.add('text-gray-500');
                document.getElementById('viewTab').classList.remove('text-blue-600', 'border-blue-600');
            });

            // Filter
            document.getElementById('filterType').addEventListener('change', (e) => {
                renderDaysList(e.target.value);
            });

            // File upload
            document.getElementById('excelFile').addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    document.getElementById('fileName').textContent = file.name;
                    document.getElementById('uploadBtn').disabled = false;
                }
            });

            document.getElementById('uploadBtn').addEventListener('click', async () => {
                const fileInput = document.getElementById('excelFile');
                if (!fileInput.files[0]) {
                    showAlert('Please select a file first', 'error');
                    return;
                }

                const formData = new FormData();
                formData.append('excel_file', fileInput.files[0]);

                try {
                    showLoading(true);
                    const response = await fetch(`${API_BASE_URL}api/Uploading/excel-upload/excluded_days`, {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        showAlert('File uploaded successfully!', 'success');
                        await loadExcludedDays();
                        // Switch back to view tab
                        document.getElementById('viewTab').click();
                    } else {
                        throw new Error(result.message || 'Upload failed');
                    }
                } catch (error) {
                    console.error('Upload error:', error);
                    showAlert(`Upload failed: ${error.message}`, 'error');
                } finally {
                    showLoading(false);
                }
            });

            // Modal controls
            document.getElementById('addDayBtn').addEventListener('click', () => {
                currentAction = 'add';
                document.getElementById('modalTitle').textContent = 'Add Excluded Day';
                document.getElementById('dayForm').reset();
                document.getElementById('dayId').value = '';
                // Enable date field for adding new dates
                document.getElementById('date').disabled = false;
                document.getElementById('dayModal').classList.remove('hidden');
            });

            document.getElementById('closeModal').addEventListener('click', () => {
                document.getElementById('dayModal').classList.add('hidden');
            });

            document.getElementById('cancelBtn').addEventListener('click', () => {
                document.getElementById('dayModal').classList.add('hidden');
            });

            document.getElementById('dayForm').addEventListener('submit', async (e) => {
                e.preventDefault();

                const dayData = {
                    date: document.getElementById('date').value,
                    type: document.getElementById('type').value,
                    reason: document.getElementById('reason').value
                };

                try {
                    showLoading(true);
                    let response, result;

                    if (currentAction === 'add') {
                        // Add new day
                        response = await fetch(`${API_BASE_URL}api/Admin/excluded-days`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(dayData)
                        });
                    } else {
                        // Update existing day
                        const dayId = document.getElementById('dayId').value;
                        response = await fetch(`${API_BASE_URL}api/Admin/excluded-days/${dayId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                type: dayData.type,
                                reason: dayData.reason
                            })
                        });
                    }

                    result = await response.json();

                    if (response.ok && result.status) {
                        showAlert(`Day ${currentAction === 'add' ? 'added' : 'updated'} successfully!`, 'success');
                        document.getElementById('dayModal').classList.add('hidden');
                        await loadExcludedDays();
                    } else {
                        throw new Error(result.message || `${currentAction === 'add' ? 'Add' : 'Update'} failed`);
                    }
                } catch (error) {
                    console.error('Error saving day:', error);
                    showAlert(`Failed to ${currentAction} day: ${error.message}`, 'error');
                } finally {
                    showLoading(false);
                }
            });
        }

      async function editDay(id) {
    const day = excludedDays.find(d => d.id === id);
    if (!day) return;

    currentAction = 'edit';
    document.getElementById('modalTitle').textContent = 'Edit Excluded Day';
    document.getElementById('dayId').value = day.id;
    document.getElementById('date').value = day.date;
    document.getElementById('type').value = day.type;
    document.getElementById('reason').value = day.reason;


    document.getElementById('date').readOnly = true;

    document.getElementById('dayModal').classList.remove('hidden');
}
        async function deleteDay(id) {
            if (!confirm('Are you sure you want to delete this excluded day?')) return;

            try {
                showLoading(true);
                const response = await fetch(`${API_BASE_URL}api/Admin/excluded-days/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const result = await response.json();

                if (response.ok && result.status) {
                    showAlert('Day deleted successfully!', 'success');
                    await loadExcludedDays();
                } else {
                    throw new Error(result.message || 'Delete failed');
                }
            } catch (error) {
                console.error('Error deleting day:', error);
                showAlert(`Failed to delete day: ${error.message}`, 'error');
            } finally {
                showLoading(false);
            }
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
