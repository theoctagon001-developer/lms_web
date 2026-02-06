<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Base URL Config</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">API Base URL Configuration</h2>
        <label class="block text-lg font-semibold text-gray-700 mb-2">Current API Base URL:</label>
        <p id="apiBaseUrl" class="text-indigo-600 font-bold text-lg bg-gray-100 p-3 rounded mb-4">
            Loading...
        </p>
        <input type="text" id="newApiUrl" placeholder="Enter new API Base URL"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
        <button onclick="requestPassword()"
            class="w-full mt-4 bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
            Update API URL
        </button>
    </div>

    <script>
        function fetchApiBaseUrl() {
            fetch('/get-api-url')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('apiBaseUrl').textContent = data.api_base_url;
                    document.getElementById('newApiUrl').value = data.api_base_url;
                })
                .catch(error => console.error("Error fetching API Base URL:", error));
        }

        fetchApiBaseUrl();

        function requestPassword() {
            let password = prompt("🔑 Enter developer password to update API URL:");

            if (password !== "developer") {
                alert("❌ Unauthorized: Incorrect password.");
                return;
            }

            updateApiBaseUrl();
        }

        function updateApiBaseUrl() {
            let newUrl = document.getElementById('newApiUrl').value;

            if (!newUrl) {
                alert("Please enter a valid URL!");
                return;
            }

            let confirmUpdate = confirm(`⚠️ WARNING: Are you sure you want to update the Base URL? 
This will affect API calls across the whole software!`);
            if (!confirmUpdate) return;
            fetch(`/update-api?url=${encodeURIComponent(newUrl)}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('apiBaseUrl').textContent = data.api_base_url;
                    document.getElementById('newApiUrl').value = data.api_base_url;
                    alert("✅ API Base URL updated successfully!");
                })
                .catch(error => console.error("Error updating API Base URL:", error));
        }
    </script>

</body>

</html>
