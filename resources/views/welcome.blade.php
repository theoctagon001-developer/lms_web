<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Learning Management System (LMS) - Final Year Project</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#16a34a',
            secondary: '#15803d',
          },
          animation: {
            'fade-in': 'fadeIn 0.8s ease-in',
            'slide-up': 'slideUp 0.8s ease-out',
            'bounce-slow': 'bounce 2s infinite',
            'float': 'float 3s ease-in-out infinite',
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' },
            },
            slideUp: {
              '0%': { transform: 'translateY(30px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' },
            },
            float: {
              '0%, 100%': { transform: 'translateY(0px)' },
              '50%': { transform: 'translateY(-20px)' },
            },
          },
        },
      },
    }
  </script>
  <style>
    @keyframes gradient {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .gradient-bg {
      background: linear-gradient(-45deg, #16a34a, #15803d, #22c55e, #10b981);
      background-size: 400% 400%;
      animation: gradient 15s ease infinite;
    }
    .card-hover {
      transition: all 0.3s ease;
    }
    .card-hover:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    .tech-icon {
      width: 48px;
      height: 48px;
      filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
    }
  </style>
</head>
<body class="bg-gradient-to-br from-green-50 via-white to-green-50 min-h-screen">

  <!-- Animated Header Section -->
  <header class="gradient-bg text-white py-8 shadow-2xl relative overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="container mx-auto px-6 text-center relative z-10 animate-fade-in">
      <h1 class="text-5xl md:text-6xl font-bold mb-4 drop-shadow-lg">Learning Management System</h1>
      <p class="text-xl md:text-2xl text-green-100 font-light">A Comprehensive Digital Learning & Academic Management Platform</p>
      <p class="text-lg text-green-200 mt-3 italic">Final Year Project - BIIT Fall 2021</p>
    </div>
    <!-- Floating shapes -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white opacity-10 rounded-full animate-float"></div>
    <div class="absolute bottom-10 right-10 w-32 h-32 bg-white opacity-10 rounded-full animate-float" style="animation-delay: 1s;"></div>
  </header>

  <!-- Abstract Section -->
  <section class="container mx-auto px-6 py-16 animate-slide-up">
    <div class="bg-white p-10 shadow-xl rounded-2xl border-l-8 border-green-600 transform transition-all duration-300 hover:shadow-2xl">
      <h2 class="text-4xl font-bold text-green-800 mb-6 flex items-center">
        <span class="mr-3">📋</span> Abstract
      </h2>
      <p class="text-gray-700 leading-relaxed text-lg">
        The Learning Management System (LMS) is a powerful digital solution aimed at automating and enhancing academic processes. 
        It is designed to facilitate seamless interactions between students, teachers, and administrators, ensuring a structured learning experience. 
        The system comprises <strong>eight key modules</strong>—Admin, DataCell, Student, Grader, Teacher, Junior Lecturer, HOD, and Director—to optimize course management, student assessment, and institutional administration.
      </p>
    </div>
  </section>

  <!-- Introduction Section -->
  <section class="container mx-auto px-6 py-12 animate-slide-up">
    <div class="bg-white p-10 shadow-xl rounded-2xl border-l-8 border-green-600 transform transition-all duration-300 hover:shadow-2xl">
      <h2 class="text-4xl font-bold text-green-800 mb-6 flex items-center">
        <span class="mr-3">🎓</span> Introduction
      </h2>
      <p class="text-gray-700 leading-relaxed text-lg">
        The LMS is designed to bring innovation to modern education by offering a centralized platform for online learning, grading, and collaboration. 
        It integrates multiple user roles, ensuring efficient management of courses, assignments, exams, and student records. 
        The goal is to provide an <strong>interactive, scalable, and user-friendly</strong> solution for digital learning that adapts to the evolving needs of educational institutions.
      </p>
    </div>
  </section>

  <!-- Modules Overview -->
  <section class="container mx-auto px-6 py-16 bg-gradient-to-br from-green-50 to-white rounded-3xl my-12">
    <h2 class="text-4xl font-bold text-green-800 mb-12 text-center animate-fade-in">
      <span class="inline-block mr-3">🔧</span> System Modules
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      
      <!-- Admin Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up">
        <div class="text-4xl mb-4">👨‍💼</div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Admin</h3>
        <p class="text-gray-600">Oversees system operations, user management, and security protocols.</p>
      </div>

      <!-- Datacell Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.1s;">
        <div class="text-4xl mb-4">📊</div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Datacell</h3>
        <p class="text-gray-600">Manages institutional data, reports, and academic insights.</p>
      </div>

      <!-- Student Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.2s;">
        <div class="text-4xl mb-4">🎓</div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Student</h3>
        <p class="text-gray-600">Accesses courses, submits assignments, and tracks progress.</p>
      </div>

      <!-- Grader Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.3s;">
        <div class="text-4xl mb-4">✅</div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Grader</h3>
        <p class="text-gray-600">Evaluates student performance and assigns grades efficiently.</p>
      </div>

      <!-- Teacher Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.4s;">
        <div class="text-4xl mb-4">👨‍🏫</div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Teacher</h3>
        <p class="text-gray-600">Manages courses, conducts lectures, and assesses student work.</p>
      </div>

      <!-- Junior Lecturer Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.5s;">
        <div class="text-4xl mb-4">👨‍🏫</div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Junior Lecturer</h3>
        <p class="text-gray-600">Assists teachers, provides academic support, and engages students.</p>
      </div>

      <!-- HOD Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.6s;">
        <div class="text-4xl mb-4">🎯</div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">HOD</h3>
        <p class="text-gray-600">Head of Department manages department operations and academic oversight.</p>
      </div>

      <!-- Director Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.7s;">
        <div class="text-4xl mb-4">🏛️</div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Director</h3>
        <p class="text-gray-600">Provides institutional leadership and strategic academic direction.</p>
      </div>
      
    </div>
  </section>

  <!-- Mobile Apps Section -->
  <section class="container mx-auto px-6 py-16 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 rounded-3xl my-12">
    <h2 class="text-4xl font-bold text-gray-800 mb-4 text-center animate-fade-in">
      <span class="inline-block mr-3">📱</span> Mobile Applications
    </h2>
    <p class="text-center text-gray-600 text-lg mb-12">Experience our LMS on the go with our Android mobile apps</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      
      <!-- Flutter App -->
      <div class="bg-white p-8 shadow-xl rounded-2xl text-center card-hover animate-slide-up border-2 border-blue-200">
        <div class="mb-6">
          <img src="{{ asset('flutter.png') }}" alt="Flutter" class="w-24 h-24 mx-auto mb-4 rounded-lg shadow-md" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\'%3E%3Crect width=\'100\' height=\'100\' fill=\'%234256F5\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'white\' font-size=\'20\'%3EFlutter%3C/text%3E%3C/svg%3E'">
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Flutter App</h3>
        <p class="text-gray-600 mb-4">Developed by <strong>Sameer Danish</strong></p>
        <div class="flex justify-center gap-3 mb-6">
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/flutter/flutter-original.svg" alt="Flutter" class="tech-icon">
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/dart/dart-original.svg" alt="Dart" class="tech-icon">
        </div>
        <p class="text-sm text-gray-500 mb-6">Cross-platform mobile application built with Flutter framework, providing seamless user experience across Android devices.</p>
        <a href="https://drive.google.com/drive/folders/13XHBTvUO4mzyTiKVyj2AnMHqMscjzX01?usp=drive_link" target="_blank" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 shadow-md">
          Download App
        </a>
      </div>

      <!-- React Native App -->
      <div class="bg-white p-8 shadow-xl rounded-2xl text-center card-hover animate-slide-up border-2 border-purple-200" style="animation-delay: 0.2s;">
        <div class="mb-6">
          <img src="{{ asset('react_native.png') }}" alt="React Native" class="w-24 h-24 mx-auto mb-4 rounded-lg shadow-md" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\'%3E%3Crect width=\'100\' height=\'100\' fill=\'%2361DAFB\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'white\' font-size=\'16\'%3EReact Native%3C/text%3E%3C/svg%3E'">
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">React Native App</h3>
        <p class="text-gray-600 mb-4">Developed by <strong>Sharjeel Ijaz</strong></p>
        <div class="flex justify-center gap-3 mb-6">
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg" alt="React" class="tech-icon">
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" alt="JavaScript" class="tech-icon">
        </div>
        <p class="text-sm text-gray-500 mb-6">Native mobile application developed using React Native, leveraging JavaScript for cross-platform compatibility.</p>
        <a href="https://drive.google.com/drive/folders/1w9h3ZATA7wGfTttfxEY0iixt1E7-70HH?usp=drive_link" target="_blank" class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 shadow-md">
          Download App
        </a>
      </div>

      <!-- Android Kotlin App -->
      <div class="bg-white p-8 shadow-xl rounded-2xl text-center card-hover animate-slide-up border-2 border-green-200" style="animation-delay: 0.4s;">
        <div class="mb-6">
          <img src="{{ asset('android_kotlin.png') }}" alt="Android Kotlin" class="w-24 h-24 mx-auto mb-4 rounded-lg shadow-md" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\'%3E%3Crect width=\'100\' height=\'100\' fill=\'%237F52FF\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'white\' font-size=\'16\'%3EKotlin%3C/text%3E%3C/svg%3E'">
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Android Kotlin App</h3>
        <p class="text-gray-600 mb-4">Developed by <strong>Muhammad Ali</strong></p>
        <div class="flex justify-center gap-3 mb-6">
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/android/android-original.svg" alt="Android" class="tech-icon">
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/kotlin/kotlin-original.svg" alt="Kotlin" class="tech-icon">
        </div>
        <p class="text-sm text-gray-500 mb-6">Native Android application built with Kotlin, providing optimal performance and native Android experience.</p>
        <a href="https://drive.google.com/drive/folders/1GK7IuzFTzR6wxErfyMog6whfuyrWpcNI?usp=drive_link" target="_blank" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300 shadow-md">
          Download App
        </a>
      </div>

    </div>
    <p class="text-center text-sm text-gray-500 mt-6 italic">* All mobile apps are Android supported only</p>
  </section>

  <!-- Team Members Section -->
  <section class="container mx-auto px-6 py-16">
    <h2 class="text-4xl font-bold text-gray-800 mb-12 text-center animate-fade-in">
      <span class="inline-block mr-3">👥</span> Development Team
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      
      <!-- Sameer Danish -->
      <div class="bg-white p-8 shadow-xl rounded-2xl text-center card-hover animate-slide-up">
        <div class="mb-6">
          <img src="{{ asset('sameer.png') }}" alt="Sameer Danish" class="w-32 h-32 mx-auto rounded-full shadow-lg object-cover border-4 border-green-500" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'128\' height=\'128\'%3E%3Crect width=\'128\' height=\'128\' fill=\'%23e5e7eb\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%236b7280\' font-size=\'16\'%3ESameer%3C/text%3E%3C/svg%3E'">
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Sameer Danish</h3>
        <p class="text-green-600 font-semibold mb-4">Flutter Developer</p>
        <a href="https://linkedin.com/in/sameer-danish" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
          </svg>
          LinkedIn Profile
        </a>
      </div>

      <!-- Sharjeel Ijaz -->
      <div class="bg-white p-8 shadow-xl rounded-2xl text-center card-hover animate-slide-up" style="animation-delay: 0.2s;">
        <div class="mb-6">
          <img src="{{ asset('sharjeel.png') }}" alt="Sharjeel Ijaz" class="w-32 h-32 mx-auto rounded-full shadow-lg object-cover border-4 border-purple-500" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'128\' height=\'128\'%3E%3Crect width=\'128\' height=\'128\' fill=\'%23e5e7eb\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%236b7280\' font-size=\'16\'%3ESharjeel%3C/text%3E%3C/svg%3E'">
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Sharjeel Ijaz</h3>
        <p class="text-purple-600 font-semibold mb-4">React Native Developer</p>
        <a href="https://linkedin.com/in/sharjeel-ijaz" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
          </svg>
          LinkedIn Profile
        </a>
      </div>

      <!-- Muhammad Ali -->
      <div class="bg-white p-8 shadow-xl rounded-2xl text-center card-hover animate-slide-up" style="animation-delay: 0.4s;">
        <div class="mb-6">
          <img src="{{ asset('ali.png') }}" alt="Muhammad Ali" class="w-32 h-32 mx-auto rounded-full shadow-lg object-cover border-4 border-blue-500" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'128\' height=\'128\'%3E%3Crect width=\'128\' height=\'128\' fill=\'%23e5e7eb\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%236b7280\' font-size=\'16\'%3EAli%3C/text%3E%3C/svg%3E'">
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Muhammad Ali</h3>
        <p class="text-blue-600 font-semibold mb-4">Android Kotlin Developer</p>
        <a href="https://linkedin.com/in/muhammad-ali" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
          </svg>
          LinkedIn Profile
        </a>
      </div>

    </div>
  </section>

  <!-- Project Credits Section -->
  <section class="container mx-auto px-6 py-12 animate-slide-up">
    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-10 shadow-2xl rounded-2xl text-center">
      <h2 class="text-4xl font-bold mb-6">Project Credits</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left max-w-3xl mx-auto">
        <div>
          <p class="text-xl mb-2"><strong>👨‍💻 Developed by:</strong></p>
          <p class="text-green-100 text-lg">Sameer Danish, Sharjeel Ijaz, Muhammad Ali</p>
        </div>
        <div>
          <p class="text-xl mb-2"><strong>👨‍🏫 Supervisor:</strong></p>
          <p class="text-green-100 text-lg">Mr. Muhammad Ahsan</p>
        </div>
        <div>
          <p class="text-xl mb-2"><strong>🏛️ Institute:</strong></p>
          <p class="text-green-100 text-lg">Barani Institute of Information Technology (BIIT)</p>
        </div>
        <div>
          <p class="text-xl mb-2"><strong>📅 Batch:</strong></p>
          <p class="text-green-100 text-lg">Fall-2021</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Login Button Section -->
  <section class="container mx-auto px-6 py-16 text-center animate-fade-in">
    <div class="bg-white p-12 shadow-2xl rounded-3xl max-w-2xl mx-auto">
      <h2 class="text-3xl font-bold text-gray-800 mb-6">Ready to Get Started?</h2>
      <p class="text-gray-600 text-lg mb-8">Access the web application to manage your academic activities</p>
      <a href="/login" class="inline-block bg-gradient-to-r from-green-600 to-green-700 text-white px-12 py-4 text-xl font-bold rounded-xl shadow-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105">
        Go to Login Page
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gradient-to-r from-green-800 to-green-900 text-white py-8 mt-16">
    <div class="container mx-auto px-6 text-center">
      <p class="text-gray-300 text-lg">&copy; 2025 Learning Management System | BIIT - All Rights Reserved</p>
      <p class="text-green-200 text-sm mt-2">Final Year Project - Fall 2021</p>
    </div>
  </footer>

</body>
</html>
