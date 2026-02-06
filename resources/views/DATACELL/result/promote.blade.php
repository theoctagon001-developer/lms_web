<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Promotion System</title>
    @vite('resources/css/app.css')
    <style>
        /* Loader Styles */
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
            display: none;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
        }
        
        /* Table Styles */
        .dropped-row {
            background-color: #fee2e2;
        }
        
        .promoted-row {
            background-color: #dcfce7;
        }
        
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        
        .data-table {
            min-width: 100%;
            width: auto;
        }
        
        /* Responsive Card View */
        .card-view {
            display: none;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: white;
        }
        
        .dropped-card {
            border-left: 4px solid #ef4444;
        }
        
        .promoted-card {
            border-left: 4px solid #10b981;
        }
        
        .card-view .field {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        
        .card-view .field-label {
            font-weight: 600;
            color: #4a5568;
        }
        
        .card-view .field-value {
            text-align: right;
        }
        
        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            .desktop-view {
                display: none;
            }
            .card-view {
                display: block;
            }
        }
        
        @media (min-width: 769px) {
            .desktop-view {
                display: block;
            }
            .card-view {
                display: none;
            }
        }
        
        /* Alert Styles */
        .alert-box {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        
        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            border-left: 4px solid #ef4444;
        }
        
        .alert-icon {
            font-size: 1.25rem;
            margin-right: 0.75rem;
        }
        
        /* Input Validation */
        .input-error {
            border-color: #ef4444;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: none;
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('DATACELL.partials.nav')
    
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-700 text-center mb-6">Student Promotion System</h2>
        
        <!-- Promotion Criteria Section -->
        <div class="mb-6 p-4 bg-white shadow-md rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Promotion Criteria</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Semester Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Select Semester (1-11)</label>
                    <select id="semester-select" class="border rounded-lg p-2 w-full">
                        <option value="">Select Semester</option>
                        @for($i = 1; $i <= 11; $i++)
                            <option value="{{ $i }}">Semester {{ $i }}</option>
                        @endfor
                    </select>
                    <div id="semester-error" class="error-message">Please select a semester between 1-11</div>
                </div>
                
                <!-- CGPA Criteria -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">CGPA Criteria (0.00-4.00)</label>
                    <input type="number" id="cgpa-input" step="0.01" min="0" max="4.01" 
                           class="border rounded-lg p-2 w-full" placeholder="Enter CGPA threshold">
                    <div id="cgpa-error" class="error-message">Please enter a valid CGPA between 0.00-4.00</div>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button id="promote-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Promote Students
                </button>
            </div>
        </div>
        
        <!-- Confirmation Modal -->
        <div id="confirm-modal" class="modal-overlay">
            <div class="modal-content">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Confirm Promotion</h3>
                    <button onclick="closeModal('confirm-modal')" class="text-gray-500 hover:text-gray-700">
                        ✕
                    </button>
                </div>
                <div class="mb-4">
                    <p>You are about to promote students from <span id="confirm-semester" class="font-semibold"></span> with CGPA ≥ <span id="confirm-cgpa" class="font-semibold"></span>.</p>
                    <p class="mt-2 text-sm text-gray-600">This action cannot be undone.</p>
                </div>
                <div class="flex justify-end space-x-2">
                    <button onclick="closeModal('confirm-modal')" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                    <button onclick="processPromotion()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Confirm</button>
                </div>
                <div id="confirm-loader" class="loader"></div>
            </div>
        </div>
        
        <!-- Alert Box -->
        <div id="alert-box" class="alert-box hidden">
            <span id="alert-icon" class="alert-icon"></span>
            <div>
                <h3 id="alert-title" class="font-semibold"></h3>
                <p id="alert-message" class="text-sm"></p>
            </div>
        </div>
        
        <!-- Results Section -->
        <div id="results-section" class="hidden">
            <h3 id="results-title" class="text-xl font-bold text-gray-800 mb-4"></h3>
            
            <!-- Desktop Table View -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden desktop-view mb-6">
                <div class="table-container">
                    <table class="data-table min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Reg No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Prev Sem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">New Sem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">CGPA</th>
                            </tr>
                        </thead>
                        <tbody id="results-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Results will be loaded here -->
                        </tbody>
                    </table>
                </div>
                <div id="no-results" class="p-4 text-center text-gray-500 hidden">
                    No promotion results to display.
                </div>
                <div id="results-loader" class="loader"></div>
            </div>
            
            <!-- Mobile Card View -->
            <div id="results-card-container">
                <!-- Results cards will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        let API_BASE_URL = "{{ config('app.url') }}";
        let promotionResults = [];
        
        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }
        
        function validateInputs() {
            let isValid = true;
            const semester = document.getElementById('semester-select').value;
            const cgpa = document.getElementById('cgpa-input').value;
            
            // Validate semester
            if (!semester || semester < 1 || semester > 11) {
                document.getElementById('semester-error').style.display = 'block';
                document.getElementById('semester-select').classList.add('input-error');
                isValid = false;
            } else {
                document.getElementById('semester-error').style.display = 'none';
                document.getElementById('semester-select').classList.remove('input-error');
            }
            
            // Validate CGPA
            if (!cgpa || cgpa < 0 || cgpa > 4.01) {
                document.getElementById('cgpa-error').style.display = 'block';
                document.getElementById('cgpa-input').classList.add('input-error');
                isValid = false;
            } else {
                document.getElementById('cgpa-error').style.display = 'none';
                document.getElementById('cgpa-input').classList.remove('input-error');
            }
            
            return isValid;
        }
        
        function showConfirmationModal() {
            if (!validateInputs()) return;
            
            const semester = document.getElementById('semester-select').value;
            const cgpa = document.getElementById('cgpa-input').value;
            
            document.getElementById('confirm-semester').textContent = `Semester ${semester}`;
            document.getElementById('confirm-cgpa').textContent = cgpa;
            document.getElementById('confirm-modal').style.display = 'flex';
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        function showAlert(type, message, title = '') {
            const alertBox = document.getElementById('alert-box');
            const alertIcon = document.getElementById('alert-icon');
            const alertTitle = document.getElementById('alert-title');
            const alertMessage = document.getElementById('alert-message');
            
            // Reset classes
            alertBox.classList.remove('alert-success', 'alert-error', 'hidden');
            
            if (type === 'success') {
                alertBox.classList.add('alert-success');
                alertIcon.textContent = '✅';
                alertTitle.textContent = title || 'Success';
            } else {
                alertBox.classList.add('alert-error');
                alertIcon.textContent = '❌';
                alertTitle.textContent = title || 'Error';
            }
            
            alertMessage.textContent = message;
            alertBox.classList.remove('hidden');
            
            // Scroll to alert
            alertBox.scrollIntoView({ behavior: 'smooth' });
        }
        
        async function processPromotion() {
            const semester = document.getElementById('semester-select').value;
            const cgpa = document.getElementById('cgpa-input').value;
            
            document.getElementById('confirm-loader').style.display = 'block';
            
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Datacells/promote-students`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        semester: semester,
                        cgpa_criteria: cgpa
                    })
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    // Handle server-side validation errors
                    if (data.errors) {
                        const errorMessages = Object.values(data.errors).join('\n');
                        throw new Error(errorMessages);
                    }
                    throw new Error(data.message || 'Failed to process promotion');
                }
                
                promotionResults = data.data || [];
                showResults(data, semester);
                showAlert('success', data.message, 'Promotion Successful');
            } catch (error) {
                showAlert('error', error.message, 'Promotion Failed');
            } finally {
                document.getElementById('confirm-loader').style.display = 'none';
                closeModal('confirm-modal');
            }
        }
        
        function showResults(response, semester) {
            const resultsSection = document.getElementById('results-section');
            const resultsTitle = document.getElementById('results-title');
            
            // Show results section
            resultsSection.classList.remove('hidden');
            
            // Set title
            resultsTitle.textContent = `Semester ${semester} Promotion List`;
            
            // Render results
            renderResults();
        }
        
        function renderResults() {
            const tableBody = document.getElementById("results-table-body");
            const cardContainer = document.getElementById("results-card-container");
            tableBody.innerHTML = "";
            cardContainer.innerHTML = "";
            
            if (!promotionResults || promotionResults.length === 0) {
                document.getElementById('no-results').classList.remove('hidden');
                return;
            }
            
            document.getElementById('no-results').classList.add('hidden');
            
            promotionResults.forEach(student => {
                const isDropped = student['Promotion Status'] === 'Dropped' || student['Promotion Status'].includes('Dropped');
                const isPromoted = student['Promotion Status'] === 'Promoted';
                
                // Format CGPA - handle both string and number types
                const cgpa = parseFloat(student.CGPA);
                const formattedCGPA = isNaN(cgpa) ? student.CGPA : cgpa.toFixed(2);
                
                // Table row
                const row = document.createElement('tr');
                if (isDropped) row.classList.add('dropped-row');
                if (isPromoted) row.classList.add('promoted-row');
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">${student.RegNo}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${student.Name}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${student['Previous Semester']}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${student['New Semester']}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${isPromoted ? '✅ Promoted' : '❌ Dropped'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">${formattedCGPA}</td>
                `;
                tableBody.appendChild(row);
                
                // Mobile card
                const card = document.createElement('div');
                card.className = 'card-view';
                if (isDropped) card.classList.add('dropped-card');
                if (isPromoted) card.classList.add('promoted-card');
                
                card.innerHTML = `
                    <div class="field">
                        <span class="field-label">Reg No:</span>
                        <span class="field-value">${student.RegNo}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Name:</span>
                        <span class="field-value">${student.Name}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Previous Sem:</span>
                        <span class="field-value">${student['Previous Semester']}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">New Sem:</span>
                        <span class="field-value">${student['New Semester']}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Status:</span>
                        <span class="field-value">
                            ${isPromoted ? '✅ Promoted' : '❌ Dropped'}
                        </span>
                    </div>
                    <div class="field">
                        <span class="field-label">CGPA:</span>
                        <span class="field-value">${formattedCGPA}</span>
                    </div>
                `;
                cardContainer.appendChild(card);
            });
        }
        
        // Event Listeners
        document.getElementById('promote-btn').addEventListener('click', showConfirmationModal);
    </script>

    @include('components.footer')
</body>

</html>