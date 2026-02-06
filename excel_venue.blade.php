<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Venue</title>
    @vite('resources/css/app.css')
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .nav-item {
            position: relative;
            color: #4b5563;
            font-weight: 600;
            transition: color 0.3s ease-in-out;
        }

        .nav-item:hover {
            color: #1d4ed8;
        }

        .nav-item::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -2px;
            width: 0;
            height: 2px;
            background-color: #1d4ed8;
            transition: width 0.3s ease-in-out, left 0.3s ease-in-out;
        }

        .nav-item:hover::after {
            width: 100%;
            left: 0;
        }

        .btn:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }

    </style>

</head>

<body class="bg-gradient-to-r from-blue-300 via-blue-200 to-blue-100 min-h-screen p-0 m-0">
    @include('components.navbar', [
        'username' => session('username', 'Guest'),
        'profileImage' => session('profileImage', asset('images/male.png')),
        'designation' => session('designation', 'N/A'),
        'type' => session('type', 'User')
    ])


    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6 text-center">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Upload Venue Data</h2>
        <br>
        <div class="flex justify-center space-x-4 ">

            <label for="timetableUpload" class=" btn cursor-pointer bg-orange-500 text-white w-64 py-3 rounded-lg hover:bg-orange transition text-center">
                Select File
            </label>
            <input type="file" id="timetableUpload" class="hidden" accept="image/*, application/pdf, .xls, .xlsx">


            <button id="submitButton" class="btn bg-blue-500 text-white w-64 py-3 rounded-lg hover:bg-blue transition" disabled>
                Submit
            </button>
        </div>


        <p id="fileNameDisplay" class="text-gray-600 mt-4"></p>
    </div>




    <div id="timetableContainer"></div>
    <footer class="bg-blue-600 p-2 mt-20 shadow-md text-center">
        <h4 class=" font-bold text-2xl mb-4 mt-4 text-white">Learning Management System</h4>
        <p class="text-white text-1xl">&copy; 2025 LMS. All Rights Reserved.</p>
        <p class="text-white text-1xl">Sameer | Ali | Sharjeel</p>
    </footer>
</body>
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
        async function initializeApiBaseUrl() {
            API_BASE_URL = await getApiBaseUrl();
        }
        initializeApiBaseUrl();
    document.getElementById("timetableUpload").addEventListener("change", function() {
        let file = this.files[0];
        let fileNameDisplay = document.getElementById("fileNameDisplay");

        if (file) {
            fileNameDisplay.textContent = "Selected File: " + file.name;
            document.getElementById("submitButton").disabled = false; // Enable Submit Button
        }
    });

    document.getElementById("submitButton").addEventListener("click", function() {
        showAlert("Submitted", "success");
    });
    document.getElementById("submitButton").addEventListener("click", async function() {
                let fileInput = document.getElementById("timetableUpload");
                let file = fileInput.files[0];

                if (!file) {
                    showAlert("Please select a file before submitting.");
                    return;
                }

                let formData = new FormData();
                formData.append("excel_file", file);
                let submitButton = document.getElementById("submitButton");
                submitButton.disabled = true;
                submitButton.textContent = "Uploading...";

                try {
                    initializeApiBaseUrl();
                    let response = await fetch(`${API_BASE_URL}api/Uploading/excel-upload/venues`, {
                        method: "POST"
                        , body: formData
                    , });

                    let result = await response.json();
                    if (response.status === 200) {
                           
                            renderTimetable(result.data);
                            showAlert(`Upload Successful!\nSuccessfully Added Records Count: ${result.data["Total Processed"]}\nFaulty Records Count: ${result.data["Total Errors"]}`, 'success');
                        }
                        else {
                            showAlert(`Upload Failed: Not Uploaded \n ${response.message??'N/A'}`);
                        }
                    } catch (error) {
                        showAlert("An error occurred while uploading.");
                    } finally {
                        submitButton.disabled = false;
                        submitButton.textContent = "Submit";
                    }
                });

            function showAlert(message, type = "error") {
                // Remove existing alert if present
                const existingAlert = document.getElementById("custom-alert");
                if (existingAlert) existingAlert.remove();

                // Define alert colors based on type
                const colors = {
                    success: "bg-green-600"
                    , error: "bg-red-600"
                    , warning: "bg-yellow-600"
                    , info: "bg-blue-600"
                , };

                // Create alert div
                const alertDiv = document.createElement("div");
                alertDiv.id = "custom-alert";
                alertDiv.className = `${colors[type]} text-white fixed top-24 right-5 px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 animate-slide-in transition-all duration-300 z-50`;

                // Alert icon (SVG)
                const icon = document.createElement("div");
                icon.innerHTML = `
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.29 3.86L1.82 18.14A2 2 0 003.73 21h16.54a2 2 0 001.91-2.86L13.71 3.86a2 2 0 00-3.42 0zM12 9v4m0 4h.01">
            </path>
        </svg>`;

                // Alert message
                const messageText = document.createElement("span");
                messageText.className = "font-semibold";
                messageText.innerText = message;

                // Close button
                const closeButton = document.createElement("button");
                closeButton.innerHTML = "✖";
                closeButton.className = "text-white hover:text-gray-300 focus:outline-none";
                closeButton.onclick = () => alertDiv.remove();

                // Append elements to alert
                alertDiv.appendChild(icon);
                alertDiv.appendChild(messageText);
                alertDiv.appendChild(closeButton);

                // Append alert to body
                document.body.appendChild(alertDiv);

                // Auto-remove alert after 4 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 10000);
            }
            function renderTimetable(response) {
        let success = response['Successful']; // Typo in API response (should be "Success")
        let error = response['FaultyData'];
        const container = document.getElementById("timetableContainer");

        const successTable = `
            <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
                <h2 class="text-2xl font-bold text-green-700 mb-4 text-center">✅ Successfully Added Records</h2>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300 text-gray-700">
                        <thead>
                            <tr class="bg-green-500 text-white">
                                <th class="border border-gray-300 p-2">Status</th>
                                <th class="border border-gray-300 p-2">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${success.map(record => `
                                <tr class="bg-green-100">
                                    <td class="border p-2 text-center">${record.status}</td>
                                    <td class="border p-2 text-center">${record.data}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        `;

        const errorTable = `
            <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
                <h2 class="text-2xl font-bold text-red-700 mb-4 text-center">❌ Faulty Records</h2>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300 text-gray-700">
                        <thead>
                            <tr class="bg-red-500 text-white">
                                <th class="border border-gray-300 p-2">Status</th>
                                <th class="border border-gray-300 p-2">Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${error.map(record => `
                                <tr class="bg-red-100">
                                    <td class="border p-2 text-center">${record.status}</td>
                                    <td class="border p-2 text-center">${record.Issue??record.Record}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        `;

        container.innerHTML = successTable + errorTable;
    }

</script>

</html>
