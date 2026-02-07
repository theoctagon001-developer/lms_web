<script src="https://cdn.tailwindcss.com"></script>
<div class="flex items-center print:hidden bg-blue-500 p-2 shadow-md z-50 sticky top-0 w-full">
    <div class="flex items-center space-x-3">
        <button onclick="toggleMenu()" class="text-white text-2xl md:hidden">&#9776;</button>
        <a href="{{ route('datacell.dashboard') }}" class="font-bold text-white text-1xl lg:text-2xl">LMS</a>
    </div>
    <div class="hidden md:flex space-x-10 ml-auto mr-5 text-white"> 
        <a href="{{ route('datacell.dashboard') }}" class="nav-item">Home</a>
        <a href="#" onclick="document.getElementById('logout-form').submit();" class="nav-item" style=" font-weight:700">Logout</a>
    </div>
    <div class="ml-auto md:ml-5 flex items-center space-x-3">
        <a href="{{ route('datacell.profile') }}" class="flex items-center space-x-3 cursor-pointer hover:bg-blue-600 p-2 rounded-lg transition-colors">
            <div class="w-11 h-10 rounded-full border border-gray-300 overflow-hidden bg-white flex items-center justify-center">
                <img src="{{ session('profileImage', asset('images/male.png')) }}" alt="Profile Image"
                    class="w-full h-full object-contain">
            </div>
            <div class="flex flex-col">
                <span class="text-white font-semibold">{{ session('username', 'Guest') }}</span>
                <span class="text-sm text-gray-200">Datacell</span>
            </div>
        </a>
    </div>
</div>
<div id="mobileMenu" class="hidden fixed inset-0 bg-white z-50 shadow-lg p-4 md:hidden min-h-screen">
    <button onclick="toggleMenu()" class="text-gray-500 text-2xl absolute top-4 right-4">✖</button>
    <div class="flex flex-col space-y-4 mt-10">
        <a href="{{ route('datacell.dashboard') }}" class="block py-2 px-4 text-gray-600 font-semibold hover:bg-gray-100">Home</a>
        <a href="{{ route('send.notification') }}" class="block py-2 px-4 text-gray-600 font-semibold hover:bg-gray-100">Send Notification</a>
        <div class="block py-2 px-4 text-gray-600 font-semibold hover:bg-gray-100 cursor-pointer" onclick="toggleSubMenu('bulkUploadMenu')">
            Bulk Uploads <span class="float-right">▼</span>
        </div>
        <div id="bulkUploadMenu" class="hidden pl-4">
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Student Via Excel</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Student Via Form</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Enrollments Via Excel</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Exam Via Excel</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Subject Result Via Excel</a>
        </div>
        <div class="block py-2 px-4 text-gray-600 font-semibold hover:bg-gray-100 cursor-pointer" onclick="toggleSubMenu('userManagementMenu')">
            User Management <span class="float-right">▼</span>
        </div>
        <div id="userManagementMenu" class="hidden pl-4">
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Add Admin</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Add Datacell</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Add HOD</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Add Director</a>
        </div>
        <div class="block py-2 px-4 text-gray-600 font-semibold hover:bg-gray-100 cursor-pointer" onclick="toggleSubMenu('approvalsMenu')">
            Approvals <span class="float-right">▼</span>
        </div>
        <div id="approvalsMenu" class="hidden pl-4">
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Approve Enrollments</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Approve Improvements</a>
        </div>
        <a href="#" onclick="document.getElementById('logout-form').submit();"
          style="color: red; font-weight:700" class="block py-2 px-4 font-bold hover:bg-gray-100">Logout</a>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
    function toggleMenu() {
        document.getElementById("mobileMenu").classList.toggle("hidden");
    }
    
    function toggleSubMenu(menuId) {
        document.getElementById(menuId).classList.toggle("hidden");
    }
</script>

<style>
    @keyframes marquee {
        from { transform: translateX(0); }
        to { transform: translateX(-100%); }
    }
    .marquee-container {
        display: flex;
        min-width: 200%;
        animation: marquee 50s linear infinite;
    }
    .relative:hover .marquee-container {
        animation-play-state: paused;
    }
    .btn-hover:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease-in-out;
    }
    .fade-in {
        animation: fadeIn 1s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .nav-item {
        position: relative;
        color: #ffffff;
        font-weight: 600;
        transition: color 0.3s ease-in-out;
    }
    .nav-item:hover{
        transform: translateY(-2px);
        transition-delay: 5s;
    }
    .nav-item::after {
        content: "";
        position: absolute;
        left: 50%;
        bottom: -2px;
        width: 0;
        height: 2px;
        background-color: #ffffff;
        transition: width 0.3s ease-in-out, left 0.3s ease-in-out;
    }
    .nav-item:hover::after {
        width: 100%;
        left: 0;
    }
</style>