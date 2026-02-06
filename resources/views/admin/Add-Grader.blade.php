<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Grader Requests</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-r from-blue-300 via-blue-200 to-blue-100 min-h-screen p-0 m-0">
    @include('admin.navbar')

    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <div class="w-full bg-blue-600 text-white text-center py-2 text-lg font-semibold shadow-md rounded-t-lg">
            Pending Grader Requests
        </div>

        <div id="requestsContainer" class="p-4">
            <div class="flex justify-center items-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                <span class="ml-2">Loading requests...</span>
            </div>
        </div>
    </div>

<script>
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

    document.addEventListener('DOMContentLoaded', async () => {
        try {
            API_BASE_URL = await getApiBaseUrl();
            console.log('Using API URL:', API_BASE_URL);
            await loadPendingRequests();
        } catch (error) {
            console.error('Initialization error:', error);
            showAlert('Failed to load requests. Please try again.', 'error');
        }
    });

    async function loadPendingRequests() {
        try {
            console.log('Fetching requests from:', `${API_BASE_URL}api/Admin/grader_req/list`);
            const response = await fetch(`${API_BASE_URL}api/Admin/grader_req/list`);

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const result = await response.json();
            console.log('API Response:', result);
            if (result.status && Array.isArray(result.data)) {
                renderRequests(result.data);
            } else {
                throw new Error('Unexpected response format');
            }
        } catch (error) {
            console.error('Error loading requests:', error);
            document.getElementById('requestsContainer').innerHTML = `
                <div class="text-center py-8 text-red-500">
                    Error loading requests: ${error.message}
                </div>
            `;
        }
    }

    function renderRequests(requests) {
        const container = document.getElementById('requestsContainer');

        if (requests.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8 text-gray-500">
                    No pending grader requests found.
                </div>
            `;
            return;
        }

        container.innerHTML = `
            <div class="space-y-4">
                ${requests.map(request => `
                    <div class="border rounded-lg p-4 bg-white shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg">${request.grader.name}</h3>
                                <p class="text-gray-600">Registration: ${request.grader.RegNo}</p>
                                <p class="text-gray-600">Requested: ${new Date(request.requested_at).toLocaleString()}</p>
                                ${request.teacher ? `<p class="text-gray-600">Teacher: ${request.teacher}</p>` : ''}
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="processRequest(${request.id}, 'accept')"
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                                    Accept
                                </button>
                                <button onclick="processRequest(${request.id}, 'reject')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                                    Reject
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }

    async function processRequest(id, action) {
        if (!confirm(`Are you sure you want to ${action} this request?`)) return;

        try {
            const response = await fetch(`${API_BASE_URL}api/Admin/grader_req/process`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id, action })
            });

            const result = await response.json();


            const alertType = result.status === "success" ? "success" : "error";
            showAlert(result.message, alertType);


            if (result.status ) {
                await loadPendingRequests();
            }
        } catch (error) {
            console.error('Error processing request:', error);
            showAlert(`Failed to ${action} request: ${error.message}`, 'error');
        }
    }

    function showAlert(message, type = 'info') {

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
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-20px)';
        alert.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

        setTimeout(() => {
            alert.style.opacity = '1';
            alert.style.transform = 'translateY(0)';
        }, 10);

      
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';

            setTimeout(() => alert.remove(), 300);
        }, 5000);
    }
</script>
</body>
</html>
