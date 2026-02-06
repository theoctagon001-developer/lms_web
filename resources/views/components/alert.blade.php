<script>
    function showAlert(message, type = "error") {
        const existingAlert = document.getElementById("custom-alert");
        if (existingAlert) existingAlert.remove();

        const colors = {
            success: "bg-green-600", error: "bg-red-600",
            warning: "bg-yellow-600", info: "bg-blue-600"
        };

        const alertDiv = document.createElement("div");
        alertDiv.id = "custom-alert";
        alertDiv.className = `${colors[type]} text-white fixed top-20 md:top-10 md:right-5 left-5 md:left-auto px-6 py-4 rounded-lg shadow-lg flex items-center justify-between space-x-3 animate-slide-in transition-all duration-300 z-50 w-[90%] md:w-auto`;

        const icon = document.createElement("div");
        icon.innerHTML = `
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.29 3.86L1.82 18.14A2 2 0 003.73 21h16.54a2 2 0 001.91-2.86L13.71 3.86a2 2 0 00-3.42 0zM12 9v4m0 4h.01">
            </path>
        </svg>`;

        const messageText = document.createElement("span");
        messageText.className = "font-semibold";
        messageText.innerText = message;

        const closeButton = document.createElement("button");
        closeButton.innerHTML = "✖";
        closeButton.className = "text-white hover:text-gray-300 focus:outline-none ml-auto";
        closeButton.onclick = () => alertDiv.remove();

        alertDiv.appendChild(icon);
        alertDiv.appendChild(messageText);
        alertDiv.appendChild(closeButton);
        document.body.appendChild(alertDiv);

        setTimeout(() => alertDiv.remove(), 5000);
    }
</script>
