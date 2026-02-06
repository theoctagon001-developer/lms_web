<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Section Management</title>
    @vite('resources/css/app.css')
    <style>
        .program-card {
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .program-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .semester-block {
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
        }

        .semester-block:last-child {
            border-bottom: none;
        }

        .section-item {
            transition: background-color 0.2s;
            border-bottom: 1px solid #f1f5f9;
        }

        .section-item:last-child {
            border-bottom: none;
        }

        .section-item:hover {
            background-color: #f8fafc;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 0.375rem;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .modal-loader {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 10;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            display: none;
        }

        .form-container.active {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen p-0 m-0">
    @include('DATACELL.partials.nav')

    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Section Management</h1>
                <p class="text-gray-600">Manage all academic sections and student distributions</p>
            </div>
            <div class="flex space-x-3">
                <!-- Quick Filters -->
                <div class="dropdown relative">
                    <button id="programFilterBtn"
                        class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg flex items-center">
                        <span>Filter by Program</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div class="dropdown-content p-2" id="programFilter">
                        <!-- Populated by JavaScript -->
                    </div>
                </div>
                <div class="dropdown relative" id="semesterFilterContainer" style="display: none;">
                    <button id="semesterFilterBtn"
                        class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg flex items-center">
                        <span>Filter by Semester</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div class="dropdown-content p-2" id="semesterFilter">
                        <!-- Populated by JavaScript -->
                    </div>
                </div>
                <button id="addSectionBtn"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    ➕ Add New Section
                </button>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        📊
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Programs</p>
                        <h3 id="totalPrograms" class="text-xl font-bold">0</h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        👥
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Students</p>
                        <h3 id="totalStudents" class="text-xl font-bold">0</h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        🏫
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Semesters</p>
                        <h3 id="totalSemesters" class="text-xl font-bold">0</h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                        📚
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Sections</p>
                        <h3 id="totalSections" class="text-xl font-bold">0</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Programs Container -->
        <div id="programsContainer" class="space-y-6">
            <div class="flex justify-center items-center py-12">
                <div class="loader"></div>
                <span class="ml-2">Loading sections data...</span>
            </div>
        </div>
    </div>

    <!-- Add Section Modal -->
    <div id="sectionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 relative">
            <div class="modal-loader hidden" id="modalLoader">
                <div class="loader"></div>
            </div>
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800">Add New Section</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>

            <div class="p-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Section Type</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="sectionType" value="regular" checked
                                class="form-radio h-5 w-5 text-blue-600" onchange="toggleSectionFormat()">
                            <span class="ml-2">Regular</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="sectionType" value="extra"
                                class="form-radio h-5 w-5 text-blue-600" onchange="toggleSectionFormat()">
                            <span class="ml-2">Extra</span>
                        </label>
                    </div>
                </div>

                <!-- Regular Section Form -->
                <form id="regularForm" class="form-container active">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="program">
                            Program <span class="text-red-500">*</span>
                        </label>
                        <select id="program"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                            <option value="">Select Program</option>
                            <option value="BCS">BCS</option>
                            <option value="BSE">BSE</option>
                            <option value="BAI">BAI</option>
                            <option value="BIT">BIT</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="semester">
                            Semester <span class="text-red-500">*</span>
                        </label>
                        <select id="semester"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                            <option value="">Select Semester</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="group">
                            Group <span class="text-red-500">*</span>
                        </label>
                        <select id="group"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                            <option value="">Select Group</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                        </select>
                    </div>
                    <div class="mb-4 bg-blue-50 p-3 rounded border border-blue-100">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Section Name</label>
                        <div class="text-lg font-mono" id="generatedSectionName">BCS-1A</div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelBtn"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" id="saveRegularBtn"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                            Save Regular Section
                        </button>
                    </div>
                </form>

                <!-- Extra Section Form -->
                <form id="extraForm" class="form-container">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="prefix">
                            Prefix <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="prefix"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="e.g., HS, DS" required>
                        <p class="text-xs text-gray-500 mt-1">This will be combined with "ExtraSection" (e.g.,
                            HSExtraSection)</p>
                    </div>
                    <div class="mb-4 bg-blue-50 p-3 rounded border border-blue-100">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Section Name</label>
                        <div class="text-lg font-mono" id="extraSectionName">ExtraSection</div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelBtnExtra"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" id="saveExtraBtn"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                            Save Extra Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let API_BASE_URL = "https://lms-backend-dqdn.onrender.com/";
        let sectionsData = {};
        let currentProgramFilter = null;
        let currentSemesterFilter = null;
        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                await loadSectionsData();
                setupEventListeners();
            } catch (error) {
                console.error('Initialization error:', error);
                showAlert('Failed to initialize. Please refresh the page.', 'error');
            }
        });

        async function loadSectionsData() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/get/sections`);
                const result = await response.json();

                if (result.status === "success") {
                    // Sort the data
                    sectionsData = sortSectionsData(result.sections);
                    renderPrograms();
                    updateSummaryStats(result);
                    populateProgramFilter();
                } else {
                    throw new Error('Failed to load sections data');
                }
            } catch (error) {
                console.error('Error loading sections:', error);
                document.getElementById('programsContainer').innerHTML = `
                    <div class="text-center py-8 text-red-500">
                        Error loading sections: ${error.message}
                    </div>
                `;
            }
        }

        function sortSectionsData(data) {
            const sortedData = {};

            // Sort programs alphabetically
            const sortedPrograms = Object.keys(data).sort();

            sortedPrograms.forEach(program => {
                sortedData[program] = {
                    total_students: data[program].total_students,
                    data: {}
                };

                // Sort semesters numerically
                const sortedSemesters = Object.keys(data[program].data).sort((a, b) => parseInt(a) - parseInt(b));

                sortedSemesters.forEach(semester => {
                    // Sort sections alphabetically within each semester
                    const sortedSections = [...data[program].data[semester]].sort((a, b) =>
                        a.name.localeCompare(b.name)
                    );

                    sortedData[program].data[semester] = sortedSections;
                });
            });

            return sortedData;
        }

        function populateProgramFilter() {
            const filterContainer = document.getElementById('programFilter');
            filterContainer.innerHTML = '';

            // Add "All Programs" option
            const allOption = document.createElement('a');
            allOption.href = '#';
            allOption.className = 'block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded';
            allOption.textContent = 'All Programs';
            allOption.onclick = (e) => {
                e.preventDefault();
                currentProgramFilter = null;
                currentSemesterFilter = null;
                document.getElementById('programFilterBtn').innerHTML =
                    'Filter by Program <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
                document.getElementById('semesterFilterContainer').style.display = 'none';
                renderPrograms();
            };
            filterContainer.appendChild(allOption);

            // Add divider
            filterContainer.appendChild(document.createElement('hr'));

            // Add each program as a filter option
            Object.keys(sectionsData).forEach(program => {
                const option = document.createElement('a');
                option.href = '#';
                option.className = 'block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded';
                option.textContent = program;
                option.onclick = (e) => {
                    e.preventDefault();
                    currentProgramFilter = program;
                    document.getElementById('programFilterBtn').innerHTML =
                        `${program} <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>`;
                    populateSemesterFilter(program);
                    document.getElementById('semesterFilterContainer').style.display = 'block';
                    document.getElementById('semesterFilterBtn').innerHTML =
                        'Filter by Semester <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
                    currentSemesterFilter = null;
                    filterByProgram(program);
                };
                filterContainer.appendChild(option);
            });
        }

        function populateSemesterFilter(program) {
            const filterContainer = document.getElementById('semesterFilter');
            filterContainer.innerHTML = '';

            if (!sectionsData[program]) return;

            // Add "All Semesters" option
            const allOption = document.createElement('a');
            allOption.href = '#';
            allOption.className = 'block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded';
            allOption.textContent = 'All Semesters';
            allOption.onclick = (e) => {
                e.preventDefault();
                currentSemesterFilter = null;
                document.getElementById('semesterFilterBtn').innerHTML =
                    'Filter by Semester <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
                filterByProgram(currentProgramFilter);
            };
            filterContainer.appendChild(allOption);

            // Add divider
            filterContainer.appendChild(document.createElement('hr'));

            // Add each semester as a filter option
            const semesters = Object.keys(sectionsData[program].data).sort((a, b) => parseInt(a) - parseInt(b));

            semesters.forEach(semester => {
                const option = document.createElement('a');
                option.href = '#';
                option.className = 'block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded';
                option.textContent = `Semester ${semester}`;
                option.onclick = (e) => {
                    e.preventDefault();
                    currentSemesterFilter = semester;
                    document.getElementById('semesterFilterBtn').innerHTML =
                        `Semester ${semester} <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>`;
                    filterByProgramAndSemester(currentProgramFilter, semester);
                };
                filterContainer.appendChild(option);
            });
        }

        function filterByProgram(program) {
            const container = document.getElementById('programsContainer');
            container.innerHTML = '';

            if (!sectionsData[program]) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        No data available for ${program}
                    </div>
                `;
                return;
            }

            const programCard = document.createElement('div');
            programCard.className = 'program-card bg-white rounded-lg shadow overflow-hidden border border-gray-200';

            programCard.innerHTML = `
                <div class="flex justify-between items-center bg-blue-600 text-white px-4 py-3">
                    <h2 class="text-lg font-bold">${program}</h2>
                    <span class="bg-white text-blue-600 px-2 py-1 rounded-full text-sm font-semibold">
                        ${sectionsData[program].total_students || 0} Students
                    </span>
                </div>
                <div class="p-4">
                    ${renderSemesters(program, sectionsData[program].data)}
                </div>
            `;

            container.appendChild(programCard);
        }

        function filterByProgramAndSemester(program, semester) {
            const container = document.getElementById('programsContainer');
            container.innerHTML = '';

            if (!sectionsData[program] || !sectionsData[program].data[semester]) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        No data available for ${program} Semester ${semester}
                    </div>
                `;
                return;
            }

            const programCard = document.createElement('div');
            programCard.className = 'program-card bg-white rounded-lg shadow overflow-hidden border border-gray-200';

            // Calculate total students for this semester
            const semesterStudents = sectionsData[program].data[semester].reduce(
                (total, section) => total + (section.student_count || 0), 0
            );

            programCard.innerHTML = `
                <div class="flex justify-between items-center bg-blue-600 text-white px-4 py-3">
                    <h2 class="text-lg font-bold">${program} - Semester ${semester}</h2>
                    <span class="bg-white text-blue-600 px-2 py-1 rounded-full text-sm font-semibold">
                        ${semesterStudents} Students
                    </span>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                ${sectionsData[program].data[semester].map(section => `
                                                <tr class="section-item">
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        ${section.name}
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-right">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            ${section.student_count || 0} Students
                                                        </span>
                                                    </td>
                                                </tr>
                                            `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;

            container.appendChild(programCard);
        }

        function updateSummaryStats(data) {
            document.getElementById('totalStudents').textContent = data.total_students || 0;

            // Calculate other stats from sectionsData
            const programs = Object.keys(data.sections || {});
            document.getElementById('totalPrograms').textContent = programs.length;

            let totalSemesters = 0;
            let totalSections = 0;

            programs.forEach(program => {
                const semesters = Object.keys(data.sections[program].data || {});
                totalSemesters += semesters.length;

                semesters.forEach(semester => {
                    totalSections += data.sections[program].data[semester].length;
                });
            });

            document.getElementById('totalSemesters').textContent = totalSemesters;
            document.getElementById('totalSections').textContent = totalSections;
        }

        function renderPrograms() {
            const container = document.getElementById('programsContainer');
            container.innerHTML = '';

            if (!sectionsData || Object.keys(sectionsData).length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        No section data available.
                    </div>
                `;
                return;
            }

            Object.entries(sectionsData).forEach(([program, programData]) => {
                const programCard = document.createElement('div');
                programCard.className =
                    'program-card bg-white rounded-lg shadow overflow-hidden border border-gray-200';

                // Program header with total students
                programCard.innerHTML = `
                    <div class="flex justify-between items-center bg-blue-600 text-white px-4 py-3">
                        <h2 class="text-lg font-bold">${program}</h2>
                        <span class="bg-white text-blue-600 px-2 py-1 rounded-full text-sm font-semibold">
                            ${programData.total_students || 0} Students
                        </span>
                    </div>
                    <div class="p-4">
                        ${renderSemesters(program, programData.data)}
                    </div>
                `;

                container.appendChild(programCard);
            });
        }

        function renderSemesters(program, semestersData) {
            let html = '';

            Object.entries(semestersData).forEach(([semester, sections]) => {
                // Calculate total students in this semester
                const semesterStudents = sections.reduce((total, section) => total + (section.student_count || 0),
                    0);

                html += `
                    <div class="semester-block">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-semibold text-gray-700">Semester ${semester}</h3>
                            <span class="text-sm bg-gray-100 px-2 py-1 rounded">
                                ${semesterStudents} Students
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    ${sections.map(section => `
                                                    <tr class="section-item">
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            ${section.name}
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-right">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                ${section.student_count || 0} Students
                                                            </span>
                                                        </td>
                                                    </tr>
                                                `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
            });

            return html;
        }

        function setupEventListeners() {
            // Modal controls
            document.getElementById('addSectionBtn').addEventListener('click', () => {
                document.getElementById('sectionModal').classList.remove('hidden');
                document.getElementById('regularForm').reset();
                document.getElementById('extraForm').reset();
                updateGeneratedSectionName();
                updateExtraSectionName();
            });

            document.getElementById('closeModal').addEventListener('click', () => {
                document.getElementById('sectionModal').classList.add('hidden');
            });

            document.getElementById('cancelBtn').addEventListener('click', () => {
                document.getElementById('sectionModal').classList.add('hidden');
            });

            document.getElementById('cancelBtnExtra').addEventListener('click', () => {
                document.getElementById('sectionModal').classList.add('hidden');
            });

            // Form field changes
            document.getElementById('program').addEventListener('change', updateGeneratedSectionName);
            document.getElementById('semester').addEventListener('change', updateGeneratedSectionName);
            document.getElementById('group').addEventListener('change', updateGeneratedSectionName);
            document.getElementById('prefix').addEventListener('input', updateExtraSectionName);

            // Regular form submission
            document.getElementById('regularForm').addEventListener('submit', async (e) => {
                e.preventDefault();

                const program = document.getElementById('program').value;
                const semester = document.getElementById('semester').value;
                const group = document.getElementById('group').value;

                if (!program || !semester || !group) {
                    showAlert('Please fill all required fields for regular section', 'error');
                    return;
                }

                const sectionName = `${program}-${semester}${group}`;

                try {
                    // Show loading state
                    document.getElementById('modalLoader').classList.remove('hidden');
                    const saveBtn = document.getElementById('saveRegularBtn');
                    saveBtn.disabled = true;
                    saveBtn.innerHTML = 'Saving...';
                    API_BASE_URL = await getApiBaseUrl();
                    const response = await fetch(`${API_BASE_URL}api/Insertion/insert-section`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            name: sectionName
                        })
                    });

                    const result = await response.json();

                    if (response.ok && result.status) {
                        showAlert('Regular section added successfully!', 'success');
                        document.getElementById('sectionModal').classList.add('hidden');
                        await loadSectionsData();
                    } else {
                        throw new Error(result.message || 'Failed to add regular section');
                    }
                } catch (error) {
                    console.error('Error adding regular section:', error);
                    showAlert(`Failed to add regular section: ${error.message}`, 'error');
                } finally {
                    document.getElementById('modalLoader').classList.add('hidden');
                    const saveBtn = document.getElementById('saveRegularBtn');
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = 'Save Regular Section';
                }
            });

            // Extra form submission
            document.getElementById('extraForm').addEventListener('submit', async (e) => {
                e.preventDefault();

                const prefix = document.getElementById('prefix').value.trim();
                if (!prefix) {
                    showAlert('Prefix is required for Extra sections', 'error');
                    return;
                }

                const sectionName = `${prefix}ExtraSection`;

                try {
                    // Show loading state
                    document.getElementById('modalLoader').classList.remove('hidden');
                    const saveBtn = document.getElementById('saveExtraBtn');
                    saveBtn.disabled = true;
                    saveBtn.innerHTML = 'Saving...';
                    API_BASE_URL = await getApiBaseUrl();
                    const response = await fetch(`${API_BASE_URL}api/Insertion/insert-section`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            name: sectionName
                        })
                    });

                    const result = await response.json();

                    if (response.ok && result.status) {
                        showAlert('Extra section added successfully!', 'success');
                        document.getElementById('sectionModal').classList.add('hidden');
                        await loadSectionsData();
                    } else {
                        throw new Error(result.message || 'Failed to add extra section');
                    }
                } catch (error) {
                    console.error('Error adding extra section:', error);
                    showAlert(`Failed to add extra section: ${error.message}`, 'error');
                } finally {
                    document.getElementById('modalLoader').classList.add('hidden');
                    const saveBtn = document.getElementById('saveExtraBtn');
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = 'Save Extra Section';
                }
            });
        }

        function toggleSectionFormat() {
            const sectionType = document.querySelector('input[name="sectionType"]:checked').value;

            if (sectionType === 'regular') {
                document.getElementById('regularForm').classList.add('active');
                document.getElementById('extraForm').classList.remove('active');
            } else {
                document.getElementById('regularForm').classList.remove('active');
                document.getElementById('extraForm').classList.add('active');
                updateExtraSectionName();
            }
        }

        function updateGeneratedSectionName() {
            const program = document.getElementById('program').value || 'BCS';
            const semester = document.getElementById('semester').value || '1';
            const group = document.getElementById('group').value || 'A';

            document.getElementById('generatedSectionName').textContent = `${program}-${semester}${group}`;
        }

        function updateExtraSectionName() {
            const prefix = document.getElementById('prefix').value.trim();
            const sectionName = prefix ? `${prefix}ExtraSection` : 'ExtraSection';
            document.getElementById('extraSectionName').textContent = sectionName;
        }

        function showAlert(message, type = 'info') {
            const alert = document.createElement('div');
            alert.className = `fixed top-4 right-4 px-6 py-4 rounded-md text-white ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            } shadow-lg z-50`;
            alert.textContent = message;
            document.body.appendChild(alert);

            // Add animation
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            alert.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

            setTimeout(() => {
                alert.style.opacity = '1';
                alert.style.transform = 'translateY(0)';
            }, 10);

            // Remove after 5 seconds
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        }
    </script>
</body>

</html>
