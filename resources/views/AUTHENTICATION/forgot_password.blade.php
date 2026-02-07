<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #0a4da3;
            --primary-light: #3b82f6;
            --secondary: #f97316;
            --dark: #1e293b;
            --light: #f8fafc;
        }
        
        body {
            background-color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
        }

        .forgot-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .forgot-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12);
        }

        .university-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .system-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .forgot-title {
            font-size: 1.25rem;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .input-field {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.5rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            color: var(--dark);
            font-size: 0.9375rem;
            transition: all 0.2s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
            background-color: white;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            width: 18px;
            height: 18px;
        }

        .action-btn {
            width: 100%;
            padding: 0.875rem;
            border-radius: 8px;
            background-color: var(--primary);
            color: white;
            font-weight: 500;
            font-size: 0.9375rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 0.5rem;
        }

        .action-btn:hover {
            background-color: #083b82;
        }

        .back-link {
            display: block;
            color: #64748b;
            font-size: 0.8125rem;
            text-align: center;
            margin-top: 1.25rem;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: var(--primary);
        }

        .contact-info {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
            font-size: 0.75rem;
            color: #64748b;
            text-align: center;
        }

        /* Progress Steps */
        .progress-container {
            display: flex;
            align-items: center;
            width: 100%;
            margin-bottom: 20px;
            position: relative;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 10%;
            width: 80%;
            height: 4px;
            background: #e2e8f0;
            transform: translateY(-50%);
            z-index: 0;
            transition: width 0.3s, background 0.3s;
        }

        .progress-bar {
            display: flex;
            justify-content: space-between;
            width: 100%;
            z-index: 1;
        }

        .step {
            width: 30px;
            height: 30px;
            background: #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--dark);
            position: relative;
            z-index: 2;
            font-size: 0.75rem;
        }

        .step.active {
            background: var(--primary);
            color: white;
        }

        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>
</head>
<body>
    <div class="forgot-container">
        <div class="university-header animate-fade-in">
            <div class="system-name">Learning Management System</div>
        </div>

        <h2 class="forgot-title animate-fade-in delay-100">Reset Your Password</h2>
        
        <div class="progress-container animate-fade-in delay-200">
            <div class="progress-line" id="progress-line"></div>
            <div class="progress-bar">
                <div id="step1" class="step active">1</div>
                <div id="step2" class="step">2</div>
                <div id="step3" class="step">3</div>
            </div>
        </div>

        <div id="step1-content" class="step-content active animate-fade-in delay-200">
            <p class="mb-4 text-sm text-gray-600 text-center">Enter your email to receive a verification code.</p>
            
            <div class="input-group">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="email" id="email" placeholder="Enter Your Email" class="input-field" required>
            </div>

            <button onclick="sendOTP()" class="action-btn animate-fade-in delay-300">
                Send Verification Code
            </button>

            <a href="{{ route('login') }}" class="back-link animate-fade-in delay-300">
                Back to Login
            </a>
        </div>

        <!-- OTP Display Section (shown after OTP is generated) -->
        <div id="otp-display-section" class="step-content" style="display: none;">
            <div style="background-color: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                <p style="color: #92400e; font-size: 0.875rem; margin-bottom: 0.5rem; font-weight: 600;">
                    ⚠️ SMTP Server Not Active
                </p>
                <p style="color: #78350f; font-size: 0.8125rem; margin: 0;">
                    The SMTP server is not active. Please use the static OTP shown below for this sample project.
                </p>
            </div>
            <div style="background-color: #eff6ff; border: 2px solid #3b82f6; border-radius: 8px; padding: 1.5rem; text-align: center; margin-bottom: 1rem;">
                <p style="color: #1e40af; font-size: 0.875rem; margin-bottom: 0.5rem; font-weight: 500;">Your Verification Code:</p>
                <p id="displayed-otp" style="color: #1e3a8a; font-size: 2rem; font-weight: bold; letter-spacing: 0.5rem; margin: 0;">------</p>
            </div>
        </div>

      
        <div id="step2-content" class="step-content animate-fade-in delay-200">
            <p class="mb-4 text-sm text-gray-600 text-center">Enter the verification code sent to your email.</p>
            
            <div class="input-group">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8 12H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="text" id="code" placeholder="Enter Verification Code" class="input-field" required>
            </div>

            <button onclick="verifyOTP()" class="action-btn animate-fade-in delay-300">
                Verify Code
            </button>

            <a href="{{ route('login') }}" class="back-link animate-fade-in delay-300">
                Back to Login
            </a>
        </div>

      
        <div id="step3-content" class="step-content animate-fade-in delay-200">
            <p class="mb-4 text-sm text-gray-600 text-center">Create your new password.</p>
            
            <div class="input-group">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 15V17M6 21H18C19.1046 21 20 20.1046 20 19V13C20 11.8954 19.1046 11 18 11H6C4.89543 11 4 11.8954 4 13V19C4 20.1046 4.89543 21 6 21ZM16 11V7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7V11H16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="password" id="password" placeholder="New Password" class="input-field" required>
            </div>

            <div class="input-group">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 15V17M6 21H18C19.1046 21 20 20.1046 20 19V13C20 11.8954 19.1046 11 18 11H6C4.89543 11 4 11.8954 4 13V19C4 20.1046 4.89543 21 6 21ZM16 11V7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7V11H16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="password" id="confirm-password" placeholder="Confirm Password" class="input-field" required>
            </div>

            <button onclick="updatePassword()" class="action-btn animate-fade-in delay-300">
                Update Password
            </button>

            <a href="{{ route('login') }}" class="back-link animate-fade-in delay-300">
                Back to Login
            </a>
        </div>

        <div class="contact-info animate-fade-in delay-300">
            <p>Need help? Contact <a href="https://biit.edu.pk/Contact-Us" class="text-blue-600 hover:underline">BIIT Support</a></p>
            <p class="mt-1">© 2025 BIIT University. All rights reserved.</p>
        </div>
    </div>

 
    <div id="loader" class="hidden fixed top-0 left-0 w-full h-full flex justify-center items-center bg-white bg-opacity-50 z-50">
        <div class="w-20 h-20 border-4 border-transparent text-blue-400 text-4xl animate-spin flex items-center justify-center border-t-blue-400 rounded-full">
            <div class="w-16 h-16 border-4 border-transparent text-red-400 text-2xl animate-spin flex items-center justify-center border-t-red-400 rounded-full"></div>
        </div>
    </div>

    <script>
      
        window.addEventListener("load", function() {
            document.getElementById("loader").classList.add("hidden");
        });

        function showLoader() {
            document.getElementById("loader").classList.remove("hidden");
        }

        function hideLoader() {
            document.getElementById("loader").classList.add("hidden");
        }

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
        async function initializeApiBaseUrl() {
            API_BASE_URL = await getApiBaseUrl();
        }

        function nextStep(step) {
            document.querySelectorAll('.step-content').forEach(el => {
                el.classList.remove('active');
            });
            document.querySelectorAll('.step').forEach(el => {
                el.classList.remove('active');
            });
            
            document.getElementById(`step${step + 1}-content`).classList.add('active');
            document.getElementById(`step${step + 1}`).classList.add('active');

            let progressLine = document.getElementById('progress-line');
            if (step === 1) {
                progressLine.style.width = "40%";
                progressLine.style.background = "var(--primary)";
            } else if (step === 2) {
                progressLine.style.width = "85%";
            }
        }

       
        function sendOTP() {
            showLoader();
            let email = document.getElementById("email").value.trim();
            if (!email) {
                hideLoader();
                alert("Please enter your email!");
                return;
            }
            initializeApiBaseUrl();
            fetch(`${API_BASE_URL}api/forgot-password`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        email: email
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        hideLoader();
                        localStorage.setItem("user_id", data.user_id);
                        // Display OTP if provided (SMTP inactive)
                        if (data.otp) {
                            document.getElementById("displayed-otp").textContent = data.otp;
                            document.getElementById("otp-display-section").style.display = "block";
                        }
                        alert(data.message);
                        nextStep(1);
                    } else {
                        hideLoader();
                        alert("Email doesn't exist. Please try again.");
                    }
                })
                .catch(error => console.error("Error:", error)).finally(() => {
                    hideLoader();
                });
        }

       
        function verifyOTP() {
            showLoader();
            let otp = document.getElementById("code").value.trim();
            let user_id = localStorage.getItem("user_id");

            if (!otp) {
                hideLoader();
                alert("Please enter the OTP!");
                return;
            }
            initializeApiBaseUrl();
            fetch(`${API_BASE_URL}api/verify-otp`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        user_id: user_id,
                        otp: otp
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        hideLoader();
                        alert(data.message);
                        nextStep(2);
                    } else {
                        hideLoader();
                        alert("Invalid OTP. Please try again.");
                    }
                })
                .catch(error => console.error("Error:", error)).finally(() => {
                    hideLoader();
                });
        }

        function updatePassword() {
            showLoader();
            let newPassword = document.getElementById("password").value.trim();
            let confirmPassword = document.getElementById("confirm-password").value.trim();
            let user_id = localStorage.getItem("user_id");

            if (!newPassword || !confirmPassword) {
                hideLoader();
                alert("Please fill in both password fields!");
                return;
            }

            if (newPassword !== confirmPassword) {
                hideLoader();
                alert("Passwords do not match!");
                return;
            }
            initializeApiBaseUrl();
            fetch(`${API_BASE_URL}api/update-pass`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        user_id: user_id,
                        new_password: newPassword
                    })
                })
                .then(response => response.json())
                .then(data => {
                    hideLoader();
                    alert(data.message);
                   
                })
                .catch(error => console.error("Error:", error)).finally(() => {
                    hideLoader();
                });
        }
    </script>
</body>
</html>