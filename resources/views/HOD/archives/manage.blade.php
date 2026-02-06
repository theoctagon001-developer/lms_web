<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIIT Folder Details</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        const MAX_STORAGE = 50 * 1024; // 50 GB in MB
        let folderSizeMB = 0; // Storage in MB
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

        function convertToMB(sizeString) {
            let size = parseFloat(sizeString);
            if (sizeString.includes("TB")) return size * 1024 * 1024;
            if (sizeString.includes("GB")) return size * 1024;
            if (sizeString.includes("KB")) return size / 1024;
            return size;
        }

        async function loadFolderDetails() {
            API_BASE_URL = await getApiBaseUrl();
            try {
                const response = await fetch(`${API_BASE_URL}api/Archives/Directory`);
                const data = await response.json();

                if (data.details) {
                    folderSizeMB = convertToMB(data.total_size);
                    document.getElementById("folderSize").innerText = data.total_size;
                    document.getElementById("totalSizeText").innerText = `of 50 GB`;

                    updateProgressBar();
                    renderFolders(data.details);
                }
            } catch (error) {
                console.error("Error fetching folder details:", error);
            }
        }

        function updateProgressBar() {
            let usagePercent = (folderSizeMB / MAX_STORAGE) * 100;
            let progressOffset = 251.2 - (251.2 * (usagePercent / 100));

            document.getElementById("progressCircle").setAttribute("stroke-dashoffset", progressOffset);

            let warningText = document.getElementById("warningMessage");
            if (folderSizeMB >= 10 * 1024) {
                warningText.innerText = "⚠️ Warning: You are nearing your storage limit!";
                warningText.classList.remove("hidden");
            } else {
                warningText.classList.add("hidden");
            }
        }

        function renderFolders(folders) {
            let temporaryMemory = document.getElementById("temporaryMemory");
            let permanentMemory = document.getElementById("permanentMemory");

            temporaryMemory.innerHTML = "";
            permanentMemory.innerHTML = "";

            folders.forEach(folder => {
                let folderItem = document.createElement("div");
                folderItem.className = "flex justify-between p-3 border-b";

                if (folder.folder_name === "Transcript") {
                    folderItem.innerHTML = `
                        <span>${folder.folder_name}</span>
                        <span>${folder.size}</span>
                        <button class="bg-red-500 text-white px-3 py-1 rounded" onclick="cleanTemporaryMemory()">Clean</button>
                    `;
                    temporaryMemory.appendChild(folderItem);
                } else {
                    folderItem.innerHTML = `
                        <a href="${API_BASE_URL}folder/${folder.folder_name}" class="text-blue-500">
                            ${folder.folder_name}
                        </a>
                        <span>${folder.size}</span>
                        <button class="bg-green-500 text-white px-3 py-1 rounded" onclick="compressFolder('${folder.path}')">Compress</button>
                    `;
                    permanentMemory.appendChild(folderItem);
                }
            });
        }

        async function compressFolder(folderPath) {
            try {
                let formData = new FormData();
                formData.append("folder_path", folderPath);
                API_BASE_URL = await getApiBaseUrl();

                let response = await fetch(`${API_BASE_URL}api/Archives/compress-folder`, {
                    method: "POST",
                    body: formData,
                });

                let data = await response.json();

                if (response.ok) {
                    alert(
                        `✅ Compression Successful!\n\n` +
                        `📂 Folder Path: ${data.folder_path}\n` +
                        `📁 Total Files: ${data.total_files}\n` +
                        `📉 Compressed Files: ${data.compressed_files}\n` +
                        `⏳ Size Before: 5.65 MB\n` +
                        `⚡ Size After: ${data.size_after}\n` +
                        `🔥 Size Reduced: ${data.size_reduced}`
                    );
                } else {
                    alert(`❌ Compression Failed!\nError: ${data.message}`);
                }
            } catch (error) {
                alert(`❌ API Request Failed!\nError: ${error.message}`);
            }
        }

        async function cleanTemporaryMemory() {
            showLoader();
            if (!confirm("Are you sure you want to clean the Transcript folder? This action cannot be undone.")) {
                hideLoader();
                return;
            }
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Archives/clean-transcript`, {
                    method: "DELETE",
                    headers: { "Content-Type": "application/json" },
                });

                const result = await response.json();

                if (response.ok) {
                    hideLoader();
                    alert("Temporary memory cleaned successfully!");
                    loadFolderDetails();
                } else {
                    hideLoader();
                    alert("Error: " + result.message);
                }
            } catch (error) {
                hideLoader();
                console.error("Error cleaning temporary memory:", error);
                alert("Failed to clean temporary memory. Please try again.");
            }
        }
        window.onload = loadFolderDetails;

    </script>
</head>

<body class="bg-gray-100">
    
        @include('HOD.partials.profile_panel')
  
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">

            <div class="relative w-48 h-48 mx-auto">
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span id="folderSize" class="text-lg font-medium text-blue-500">0 MB</span>
                    <span id="totalSizeText" class="text-xs text-gray-500">of 50 GB</span>
                </div>
                <svg class="w-full h-full" viewBox="0 0 100 100">
                    <circle class="text-gray-300" stroke-width="6" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50"></circle>
                    <circle id="progressCircle" class="text-blue-500 transition-all duration-500 ease-out" stroke-width="6" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" stroke-dasharray="251.2" stroke-dashoffset="251.2" stroke-linecap="round"></circle>
                </svg>
            </div>
            <p id="warningMessage" class="text-red-600 font-semibold mt-2 hidden"></p>
            <h2 class="text-xl font-bold mt-4">BIIT</h2>
            <div id="temporaryMemory" class="mt-6"></div>
            <div id="permanentMemory" class="mt-6"></div>
            <div class="w-full my-10"></div>
        </div>
    </div>
    @include('components.loader')

</body>

</html>
