<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LMS</title>
    @vite('resources/css/app.css')
    <style>
        :root {
            --primary: #0a4da3;
            --primary-light: #3b82f6;
            --secondary: #f97316;
            --dark: #1e293b;
            --light: #f8fafc;
        }
        
        * {
            box-sizing: border-box;
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

        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden; /* Added to prevent any overflow */
        }

        .login-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12);
        }

        .university-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .university-logo {
            height: 50px;
            margin-bottom: 0.5rem;
        }

        .system-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .login-title {
            font-size: 1.25rem;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.25rem;
            width: 100%; /* Ensure full width within container */
        }

        .input-field {
            width: calc(100% - 2px); /* Account for border */
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

        .login-btn {
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

        .login-btn:hover {
            background-color: #083b82;
        }

        .forgot-link {
            display: block;
            color: #64748b;
            font-size: 0.8125rem;
            text-align: center;
            margin-top: 1.25rem;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
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

        /* Responsive adjustments */
        @media (max-width: 480px) {
            body {
                padding: 15px;
            }
            
            .login-container {
                padding: 1.5rem;
                max-width: 100%;
            }
            
            .system-name {
                font-size: 1.3rem;
            }
            
            .login-title {
                font-size: 1.1rem;
                margin-bottom: 1.25rem;
            }
            
            .input-field {
                padding: 0.75rem 1rem 0.75rem 2.5rem;
                font-size: 0.9rem;
                width: calc(100% - 2px);
            }
            
            .login-btn {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
            
            .contact-info {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 360px) {
            .login-container {
                padding: 1.25rem;
            }
            
            .system-name {
                font-size: 1.2rem;
            }
            
            .login-title {
                font-size: 1rem;
            }
            
            .input-field {
                padding: 0.65rem 0.9rem 0.65rem 2.3rem;
                width: calc(100% - 2px);
            }
            
            .input-icon {
                left: 0.8rem;
                width: 16px;
                height: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="university-header animate-fade-in">
          
            <div class="system-name">Learning Management System</div>
        </div>

        <h2 class="login-title animate-fade-in delay-100">Sign in to your account</h2>
        
        <form action="{{ route('handleLogin') }}" method="POST" class="w-full">
            @csrf
            <div class="input-group animate-fade-in delay-200">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="text" id="username" name="username" placeholder="Username" class="input-field" required>
            </div>

            <div class="input-group animate-fade-in delay-200">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 15V17M6 21H18C19.1046 21 20 20.1046 20 19V13C20 11.8954 19.1046 11 18 11H6C4.89543 11 4 11.8954 4 13V19C4 20.1046 4.89543 21 6 21ZM16 11V7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7V11H16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="password" id="password" name="password" placeholder="Password" class="input-field" required>
            </div>

            <button type="submit" class="login-btn animate-fade-in delay-300">
                Sign In
            </button>

            <a href="{{route('forgot')}}" class="forgot-link animate-fade-in delay-300">
                Forgot password?
            </a>
        </form>

        <div class="contact-info animate-fade-in delay-300">
            <p>Need help? Contact <a href="https://biit.edu.pk/Contact-Us" class="text-blue-600 hover:underline">BIIT Support</a></p>
            <p class="mt-1">© 2025 BIIT University. All rights reserved.</p>
        </div>
    </div>
    <script>
        function clearSession() {
            fetch("{{ route('clear.session') }}", {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log(data.message);
                } else {
                    console.log('Failed to clear session');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        setTimeout(() => {
            let errorAlert = document.getElementById('success-alert');
            if (errorAlert) {
                errorAlert.style.display = 'none';
                clearSession();
            }
        }, 5000);
        
        setTimeout(() => {
            let errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 5000);
    </script>
    @include('components.loader')
</body>
</html>