<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Learning Management System (LMS) - Final Year Project</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
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
            'slide-down': 'slideDown 0.8s ease-out',
            'scale-in': 'scaleIn 0.5s ease-out',
            'bounce-slow': 'bounce 2s infinite',
            'float': 'float 3s ease-in-out infinite',
            'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            'shimmer': 'shimmer 2s infinite',
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
            slideDown: {
              '0%': { transform: 'translateY(-30px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' },
            },
            scaleIn: {
              '0%': { transform: 'scale(0.9)', opacity: '0' },
              '100%': { transform: 'scale(1)', opacity: '1' },
            },
            float: {
              '0%, 100%': { transform: 'translateY(0px)' },
              '50%': { transform: 'translateY(-20px)' },
            },
            shimmer: {
              '0%': { backgroundPosition: '-1000px 0' },
              '100%': { backgroundPosition: '1000px 0' },
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
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .card-hover:hover {
      transform: translateY(-12px) scale(1.02);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .tech-icon {
      width: 48px;
      height: 48px;
      filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
      transition: transform 0.3s ease;
    }
    .tech-icon:hover {
      transform: scale(1.2) rotate(5deg);
    }
    .icon-wrapper {
      width: 64px;
      height: 64px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 16px;
      margin: 0 auto 1rem;
      transition: all 0.3s ease;
    }
    .icon-wrapper:hover {
      transform: scale(1.1) rotate(5deg);
    }
    .glass-effect {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .profile-placeholder {
      width: 128px;
      height: 128px;
      border-radius: 50%;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 3rem;
      font-weight: bold;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body class="bg-gradient-to-br from-green-50 via-white to-green-50 min-h-screen">

  <!-- Animated Header Section -->
  <header class="gradient-bg text-white py-12 shadow-2xl relative overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="container mx-auto px-6 text-center relative z-10 animate-fade-in">
      <div class="mb-6 inline-block">
        <svg class="w-20 h-20 mx-auto mb-4 animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
      </div>
      <h1 class="text-5xl md:text-6xl font-bold mb-4 drop-shadow-lg">Learning Management System</h1>
      <p class="text-xl md:text-2xl text-green-100 font-light">A Comprehensive Digital Learning & Academic Management Platform</p>
      <p class="text-lg text-green-200 mt-3 italic">Final Year Project - BIIT Fall 2021</p>
    </div>
    <!-- Floating shapes -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white opacity-10 rounded-full animate-float"></div>
    <div class="absolute bottom-10 right-10 w-32 h-32 bg-white opacity-10 rounded-full animate-float" style="animation-delay: 1s;"></div>
    <div class="absolute top-1/2 right-20 w-16 h-16 bg-white opacity-10 rounded-full animate-float" style="animation-delay: 0.5s;"></div>
  </header>

  <!-- Abstract Section -->
  <section class="container mx-auto px-6 py-16 animate-slide-up">
    <div class="bg-white p-10 shadow-xl rounded-2xl border-l-8 border-green-600 transform transition-all duration-300 hover:shadow-2xl">
      <h2 class="text-4xl font-bold text-green-800 mb-6 flex items-center">
        <div class="icon-wrapper bg-green-100 text-green-600 mr-4">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        Abstract
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
        <div class="icon-wrapper bg-green-100 text-green-600 mr-4">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
          </svg>
        </div>
        Introduction
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
    <h2 class="text-4xl font-bold text-green-800 mb-12 text-center animate-fade-in flex items-center justify-center">
      <svg class="w-10 h-10 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
      </svg>
      System Modules
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      
      <!-- Admin Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up">
        <div class="icon-wrapper bg-green-100 text-green-600">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Admin</h3>
        <p class="text-gray-600">Oversees system operations, user management, and security protocols.</p>
      </div>

      <!-- Datacell Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.1s;">
        <div class="icon-wrapper bg-blue-100 text-blue-600">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Datacell</h3>
        <p class="text-gray-600">Manages institutional data, reports, and academic insights.</p>
      </div>

      <!-- Student Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.2s;">
        <div class="icon-wrapper bg-purple-100 text-purple-600">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v9"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Student</h3>
        <p class="text-gray-600">Accesses courses, submits assignments, and tracks progress.</p>
      </div>

      <!-- Grader Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.3s;">
        <div class="icon-wrapper bg-yellow-100 text-yellow-600">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Grader</h3>
        <p class="text-gray-600">Evaluates student performance and assigns grades efficiently.</p>
      </div>

      <!-- Teacher Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.4s;">
        <div class="icon-wrapper bg-indigo-100 text-indigo-600">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Teacher</h3>
        <p class="text-gray-600">Manages courses, conducts lectures, and assesses student work.</p>
      </div>

      <!-- Junior Lecturer Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.5s;">
        <div class="icon-wrapper bg-pink-100 text-pink-600">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Junior Lecturer</h3>
        <p class="text-gray-600">Assists teachers, provides academic support, and engages students.</p>
      </div>

      <!-- HOD Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.6s;">
        <div class="icon-wrapper bg-red-100 text-red-600">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">HOD</h3>
        <p class="text-gray-600">Head of Department manages department operations and academic oversight.</p>
      </div>

      <!-- Director Module -->
      <div class="bg-white p-6 shadow-lg rounded-xl text-center border-b-4 border-green-600 card-hover animate-slide-up" style="animation-delay: 0.7s;">
        <div class="icon-wrapper bg-teal-100 text-teal-600">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-semibold text-green-700 mb-3">Director</h3>
        <p class="text-gray-600">Provides institutional leadership and strategic academic direction.</p>
      </div>
      
    </div>
  </section>

  <!-- Mobile Apps Section -->
  <section class="container mx-auto px-6 py-16 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 rounded-3xl my-12">
    <h2 class="text-4xl font-bold text-gray-800 mb-4 text-center animate-fade-in flex items-center justify-center">
      <svg class="w-10 h-10 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
      </svg>
      Mobile Applications
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
        <a href="https://drive.google.com/drive/folders/13XHBTvUO4mzyTiKVyj2AnMHqMscjzX01?usp=drive_link" target="_blank" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 shadow-md">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
          </svg>
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
        <a href="https://drive.google.com/drive/folders/1w9h3ZATA7wGfTttfxEY0iixt1E7-70HH?usp=drive_link" target="_blank" class="inline-flex items-center bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 shadow-md">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
          </svg>
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
        <a href="https://drive.google.com/drive/folders/1GK7IuzFTzR6wxErfyMog6whfuyrWpcNI?usp=drive_link" target="_blank" class="inline-flex items-center bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300 shadow-md">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
          </svg>
          Download App
        </a>
      </div>

    </div>
    <p class="text-center text-sm text-gray-500 mt-6 italic">* All mobile apps are Android supported only</p>
  </section>

  <!-- Team Members Section -->
  <section class="container mx-auto px-6 py-16">
    <h2 class="text-4xl font-bold text-gray-800 mb-12 text-center animate-fade-in flex items-center justify-center">
      <svg class="w-10 h-10 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
      </svg>
      Development Team
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      
      <!-- Sameer Danish -->
      <div class="bg-white p-8 shadow-xl rounded-2xl text-center card-hover animate-slide-up">
        <div class="mb-6">
          <svg class="w-32 h-32 mx-auto rounded-full shadow-lg border-4 border-green-500" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg">
            <circle cx="64" cy="64" r="64" fill="url(#grad1)"/>
            <defs>
              <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
              </linearGradient>
            </defs>
            <text x="50%" y="50%" text-anchor="middle" dy=".35em" fill="white" font-size="48" font-weight="bold">SD</text>
          </svg>
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
          <svg class="w-32 h-32 mx-auto rounded-full shadow-lg border-4 border-purple-500" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg">
            <circle cx="64" cy="64" r="64" fill="url(#grad2)"/>
            <defs>
              <linearGradient id="grad2" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#f093fb;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#f5576c;stop-opacity:1" />
              </linearGradient>
            </defs>
            <text x="50%" y="50%" text-anchor="middle" dy=".35em" fill="white" font-size="48" font-weight="bold">SI</text>
          </svg>
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
          <svg class="w-32 h-32 mx-auto rounded-full shadow-lg border-4 border-blue-500" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg">
            <circle cx="64" cy="64" r="64" fill="url(#grad3)"/>
            <defs>
              <linearGradient id="grad3" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#4facfe;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#00f2fe;stop-opacity:1" />
              </linearGradient>
            </defs>
            <text x="50%" y="50%" text-anchor="middle" dy=".35em" fill="white" font-size="48" font-weight="bold">MA</text>
          </svg>
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
      <h2 class="text-4xl font-bold mb-6 flex items-center justify-center">
        <svg class="w-10 h-10 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
        </svg>
        Project Credits
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left max-w-3xl mx-auto">
        <div class="flex items-start">
          <svg class="w-6 h-6 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
          </svg>
          <div>
            <p class="text-xl mb-2 font-semibold">Developed by:</p>
            <p class="text-green-100 text-lg">Sameer Danish, Sharjeel Ijaz, Muhammad Ali</p>
          </div>
        </div>
        <div class="flex items-start">
          <svg class="w-6 h-6 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          <div>
            <p class="text-xl mb-2 font-semibold">Supervisor:</p>
            <p class="text-green-100 text-lg">Mr. Muhammad Ahsan</p>
          </div>
        </div>
        <div class="flex items-start">
          <svg class="w-6 h-6 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
          </svg>
          <div>
            <p class="text-xl mb-2 font-semibold">Institute:</p>
            <p class="text-green-100 text-lg">Barani Institute of Information Technology (BIIT)</p>
          </div>
        </div>
        <div class="flex items-start">
          <svg class="w-6 h-6 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
          <div>
            <p class="text-xl mb-2 font-semibold">Batch:</p>
            <p class="text-green-100 text-lg">Fall-2021</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Login Button Section -->
  <section class="container mx-auto px-6 py-16 text-center animate-fade-in">
    <div class="bg-white p-12 shadow-2xl rounded-3xl max-w-2xl mx-auto">
      <div class="mb-6">
        <svg class="w-16 h-16 mx-auto text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
        </svg>
      </div>
      <h2 class="text-3xl font-bold text-gray-800 mb-6">Ready to Get Started?</h2>
      <p class="text-gray-600 text-lg mb-8">Access the web application to manage your academic activities</p>
      <a href="/login" class="inline-flex items-center bg-gradient-to-r from-green-600 to-green-700 text-white px-12 py-4 text-xl font-bold rounded-xl shadow-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
        </svg>
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
