<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - LMS</title>
    @include('components.tailwind-config')
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

        .otp-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .otp-container:hover {
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

        .otp-title {
            font-size: 1.25rem;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 1rem;
            text-align: center;
        }

        .otp-timer {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .timer-text {
            color: var(--dark);
        }

        .timer-count {
            font-weight: 600;
            color: var(--primary);
        }

        .expiry-warning {
            color: #dc2626;
            font-weight: 500;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.6; }
            100% { opacity: 1; }
        }

        .input-group {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .input-field {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            color: var(--dark);
            font-size: 1.2rem;
            letter-spacing: 0.5rem;
            text-align: center;
            transition: all 0.2s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
            background-color: white;
        }

        .verify-btn {
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

        .verify-btn:hover {
            background-color: #083b82;
        }

        .verify-btn:disabled {
            background-color: #94a3b8;
            cursor: not-allowed;
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

       
        #loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .loader-content {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

       
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
    </style>
</head>
<body>
    <div class="otp-container animate-fade-in">
        <div class="university-header">
            <div class="system-name">Learning Management System</div>
        </div>

        <h2 class="otp-title">OTP Verification</h2>
        
        <div class="text-center mb-4 text-gray-600 animate-fade-in delay-100">
            Verifying OTP for: <span class="font-semibold text-primary">{{ session('username') }}</span>
        </div>

        @if(session('smtp_inactive') && session('two_step_otp'))
        <!-- SMTP Inactive Warning and OTP Display -->
        <div style="background-color: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; animate-fade-in delay-100">
            <p style="color: #92400e; font-size: 0.875rem; margin-bottom: 0.5rem; font-weight: 600;">
                ⚠️ SMTP Server Not Active
            </p>
            <p style="color: #78350f; font-size: 0.8125rem; margin: 0;">
                The SMTP server is not active. Please use the static OTP shown below for this sample project.
            </p>
        </div>
        <div style="background-color: #eff6ff; border: 2px solid #3b82f6; border-radius: 8px; padding: 1.5rem; text-align: center; margin-bottom: 1rem; animate-fade-in delay-100">
            <p style="color: #1e40af; font-size: 0.875rem; margin-bottom: 0.5rem; font-weight: 500;">Your Verification Code:</p>
            <p style="color: #1e3a8a; font-size: 2rem; font-weight: bold; letter-spacing: 0.5rem; margin: 0;">{{ session('two_step_otp') }}</p>
        </div>
        @endif

        <div class="otp-timer animate-fade-in delay-100">
            <span class="timer-text">OTP expires in:</span>
            <span id="otpCountdown" class="timer-count">05:00</span>
        </div>

        <form action="{{ route('verify.otp') }}" method="POST" id="otpForm" class="w-full">
            @csrf
            <div class="input-group animate-fade-in delay-200">
                <input type="text" name="otp" id="otpInput" 
                       placeholder="______" 
                       class="input-field"
                       maxlength="6"
                       pattern="\d{6}"
                       title="Please enter exactly 6 digits"
                       required
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>

            <button type="submit" id="verifyBtn" class="verify-btn animate-fade-in delay-200">
                Verify OTP
            </button>

            @if(session('error'))
                <div class="mt-4 text-red-600 text-center animate-fade-in delay-200">
                    {{ session('error') }}
                </div>
            @endif

            <a href="{{ route('login') }}" class="back-link animate-fade-in delay-200">
                Back to Login
            </a>
        </form>

        <div class="contact-info animate-fade-in delay-200">
            <p>Need help? Contact <a href="https://biit.edu.pk/Contact-Us" class="text-primary hover:underline">BIIT Support</a></p>
            <p class="mt-1">© 2025 BIIT University. All rights reserved.</p>
        </div>
    </div>

    <div id="loader">
        <div class="loader-content">
            <div class="spinner"></div>
            <p class="text-lg font-medium text-gray-700">Verifying OTP...</p>
            <p class="text-sm text-gray-500 mt-1">Please wait while we verify your code</p>
        </div>
    </div>

    <script>
      
        let countdownInterval;
        const totalSeconds = 5 * 60;
        let remainingSeconds = totalSeconds;
        let otpExpired = false;

        document.addEventListener('DOMContentLoaded', function() {
            startCountdown();
            const otpInput = document.getElementById('otpInput');
            otpInput.focus();
            
           
            otpInput.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                const cleaned = pastedText.replace(/[^0-9]/g, '').substring(0, 6);
                this.value = cleaned;
            });
        });

        function startCountdown() {
            updateCountdownDisplay(remainingSeconds);
            
            countdownInterval = setInterval(() => {
                remainingSeconds--;
                updateCountdownDisplay(remainingSeconds);
                
                if (remainingSeconds <= 0) {
                    clearInterval(countdownInterval);
                    handleOTPExpired();
                }
            }, 1000);
        }

        function updateCountdownDisplay(seconds) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            const countdownElement = document.getElementById('otpCountdown');
            
            countdownElement.textContent = 
                `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
            
           
            if (seconds <= 60) {
                countdownElement.classList.add('expiry-warning');
            }
        }

        function handleOTPExpired() {
            otpExpired = true;
            const countdownElement = document.getElementById('otpCountdown');
            countdownElement.textContent = "Expired";
            countdownElement.classList.add('expiry-warning');
            
          
            document.getElementById('verifyBtn').disabled = true;
           
            alert('This OTP has expired. Please request a new OTP.');
            
            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 3000);
        }

        document.getElementById('otpForm').addEventListener('submit', function(e) {
          
            if (otpExpired) {
                e.preventDefault();
                alert('This OTP has expired. Please request a new OTP.');
                window.location.href = "{{ route('login') }}";
                return;
            }
            
            
            const otpInput = document.getElementById('otpInput');
            if (otpInput.value.length !== 6) {
                e.preventDefault();
                alert('Please enter a 6-digit OTP code');
                return;
            }
            
            
            document.getElementById('loader').style.display = 'flex';
            
            
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
        });

        window.addEventListener('beforeunload', function() {
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
        });
    </script>
</body>
</html>