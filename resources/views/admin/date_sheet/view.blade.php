<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Sheet</title>
    @vite('resources/css/app.css')
    
    <style>
        /* Base styles */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e40af;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background-color: #2563eb;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
        }
        
        .session-info {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #1e40af;
            text-align: center;
        }
        
        .time-slot-label {
            font-size: 1.125rem;
            font-weight: 600;
            margin: 1.5rem 0 1rem 0;
            color: #000;
            text-align: center;
        }
        
        .filter-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .filter-select {
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            min-width: 150px;
        }
        
        .slot-container {
            margin-bottom: 2rem;
        }
        
        .date-sheet-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        .date-sheet-table th, 
        .date-sheet-table td {
            border: 1px solid #e5e7eb;
            padding: 0.75rem;
            text-align: center;
        }
        
        .date-sheet-table th {
            background-color: #f3f4f6;
            font-weight: 600;
            color: #374151;
            position: sticky;
            top: 0;
        }
        
        .date-sheet-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .exam-cell {
            min-width: 120px;
            height: 80px;
            vertical-align: middle;
        }
        
        .today-exam {
            background-color: #dbeafe;
            font-weight: 600;
        }
        
        .course-info {
            font-size: 0.875rem;
        }
        
        .course-code {
            font-weight: 600;
            color: #1e40af;
        }
        
        .no-data {
            color: #6b7280;
            font-style: italic;
            text-align: center;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .filter-container {
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }
            
            .filter-select {
                width: 100%;
                max-width: 300px;
            }
            
            .date-sheet-table {
                font-size: 0.75rem;
            }
            
            .exam-cell {
                min-width: 80px;
                height: 60px;
                padding: 0.25rem;
            }
            
            .course-info {
                font-size: 0.7rem;
            }
        }
        
        @media (max-width: 480px) {
            .date-sheet-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    @include('admin.navbar', [
        'username' => session('username', 'Guest'),
        'profileImage' => session('profileImage', asset('images/male.png')),
        'designation' => session('designation', 'N/A'),
        'type' => session('userType', 'User')
    ])

    <div class="container">
        <div class="header">
            <h1 class="title">Date Sheet</h1>
            <button class="btn btn-primary" onclick="window.location.href='{{ route('datacell.upload.datesheet') }}'">
                📤 Upload New Date Sheet Excel
            </button>
        </div>
        
        <div id="session-info" class="session-info">Loading session...</div>
        
        <div class="filter-container">
            <select id="exam-type" class="filter-select" onchange="filterDateSheet()">
                <option value="Mid">Mid Term</option>
                <option value="Final">Final Term</option>
            </select>
            
            <select id="time-slot" class="filter-select" onchange="filterDateSheet()">
                <option value="all">All Time Slots</option>
                <!-- Will be populated dynamically -->
            </select>
        </div>
        
        <div id="date-sheet-container">
            <!-- Will be populated dynamically -->
            <div class="no-data">Loading date sheet...</div>
        </div>
    </div>

    <script>
        let API_BASE_URL = "http://192.168.0.111:8000/";
        let dateSheetData = {};
        let allSections = new Set();
        
        async function getApiBaseUrl() {
            try {
                let response = await fetch('/get-api-url');
                let data = await response.json();
                return data.api_base_url;
            } catch (error) {
                return API_BASE_URL;
            }
        }
        
        async function loadDateSheet() {
            try {
                API_BASE_URL = await getApiBaseUrl();
                const response = await fetch(`${API_BASE_URL}api/Insertion/datesheet/full`);
                const data = await response.json();
                
                if (data.error) {
                    document.getElementById('session-info').textContent = `Error: ${data.error}`;
                    document.getElementById('date-sheet-container').innerHTML = 
                        `<div class="no-data">${data.error}</div>`;
                    return;
                }
                
                dateSheetData = data;
                allSections = new Set();
                
                // Extract all unique sections
                ['Mid', 'Final'].forEach(type => {
                    if (dateSheetData[type]) {
                        Object.values(dateSheetData[type]).forEach(slot => {
                            Object.keys(slot).forEach(section => {
                                allSections.add(section);
                            });
                        });
                    }
                });
                
                // Update UI
                updateSessionInfo();
                populateTimeSlotDropdown();
                filterDateSheet();
            } catch (error) {
                console.error("Error loading date sheet:", error);
                document.getElementById('date-sheet-container').innerHTML = 
                    `<div class="no-data">Failed to load date sheet. Please try again.</div>`;
            }
        }
        
        function updateSessionInfo() {
            const examType = document.getElementById('exam-type').value;
            document.getElementById('session-info').textContent = 
                `${dateSheetData.SESSION || 'N/A'} ${examType} Date Sheet`;
        }
        
        function populateTimeSlotDropdown() {
            const timeSlotSelect = document.getElementById('time-slot');
            timeSlotSelect.innerHTML = '<option value="all">All Time Slots</option>';
            
            const timeSlots = new Set();
            const examType = document.getElementById('exam-type').value;
            
            if (dateSheetData[examType]) {
                Object.keys(dateSheetData[examType]).forEach(slot => {
                    timeSlots.add(slot);
                });
            }
            
            // Add options for each time slot
            let slotCount = 1;
            
            Array.from(timeSlots).sort().forEach(slot => {
                const option = document.createElement('option');
                option.value = slot;
                option.textContent = `Slot ${slotCount} (${slot})`;
                timeSlotSelect.appendChild(option);
                slotCount++;
            });
        }
        
        function filterDateSheet() {
            updateSessionInfo();
            const examType = document.getElementById('exam-type').value;
            const timeSlot = document.getElementById('time-slot').value;
            
            let filteredData = {};
            filteredData[examType] = dateSheetData[examType] ? {...dateSheetData[examType]} : {};
            
            // Filter by time slot if specified
            if (timeSlot !== 'all') {
                Object.keys(filteredData[examType]).forEach(slot => {
                    if (slot !== timeSlot) {
                        delete filteredData[examType][slot];
                    }
                });
            }
            
            renderDateSheet(filteredData, examType);
        }
        
        function renderDateSheet(data, examType) {
            const container = document.getElementById('date-sheet-container');
            container.innerHTML = '';
            
            if (!data[examType] || Object.keys(data[examType]).length === 0) {
                container.innerHTML = '<div class="no-data">No date sheet data found for the selected filters.</div>';
                return;
            }
            
            Object.keys(data[examType]).sort().forEach(slot => {
                const slotData = data[examType][slot];
                
                // Add time slot label
                const timeSlotLabel = document.createElement('div');
                timeSlotLabel.className = 'time-slot-label';
                timeSlotLabel.textContent = `Time Slot: ${slot}`;
                container.appendChild(timeSlotLabel);
                
                // Create table for this slot
                const table = document.createElement('table');
                table.className = 'date-sheet-table';
                
                // Create table header with sections
                const thead = document.createElement('thead');
                const headerRow = document.createElement('tr');
                
                const emptyHeader = document.createElement('th');
                emptyHeader.textContent = 'Date/Day';
                headerRow.appendChild(emptyHeader);
                
                // Get all sections in this slot
                const sectionsInSlot = Object.keys(slotData);
                
                // Create headers for each section
                sectionsInSlot.forEach(section => {
                    const th = document.createElement('th');
                    th.textContent = section;
                    headerRow.appendChild(th);
                });
                
                thead.appendChild(headerRow);
                table.appendChild(thead);
                
                // Create table body
                const tbody = document.createElement('tbody');
                
                // Collect all unique dates across all sections
                const allDates = new Set();
                
                sectionsInSlot.forEach(section => {
                    slotData[section].forEach(exam => {
                        allDates.add(exam.Date + '|' + exam.Day);
                    });
                });
                
                // Convert to array and sort by date
                const sortedDates = Array.from(allDates).sort((a, b) => {
                    const dateA = a.split('|')[0];
                    const dateB = b.split('|')[0];
                    return new Date(dateA.split('-').reverse().join('-')) - 
                           new Date(dateB.split('-').reverse().join('-'));
                });
                
                // Create rows for each date
                sortedDates.forEach(dateDay => {
                    const [date, day] = dateDay.split('|');
                    const row = document.createElement('tr');
                    
                    // Add date/day cell
                    const dateCell = document.createElement('td');
                    dateCell.textContent = `${date}\n(${day})`;
                    
                    // Highlight if today
                    const isToday = slotData[sectionsInSlot[0]].some(exam => 
                        exam.Date === date && exam.isToday === 'Yes'
                    );
                    
                    if (isToday) {
                        dateCell.classList.add('today-exam');
                    }
                    
                    row.appendChild(dateCell);
                    
                    // Add exam cells for each section
                    sectionsInSlot.forEach(section => {
                        const exam = slotData[section].find(e => e.Date === date);
                        const examCell = document.createElement('td');
                        examCell.className = 'exam-cell';
                        
                        if (exam) {
                            examCell.innerHTML = `
                                <div class="course-info">
                                    <div class="course-code">${exam['Course Code']}</div>
                                    <div>${exam['Course Name']}</div>
                                </div>
                            `;
                            
                            if (exam.isToday === 'Yes') {
                                examCell.classList.add('today-exam');
                            }
                        }
                        
                        row.appendChild(examCell);
                    });
                    
                    tbody.appendChild(row);
                });
                
                table.appendChild(tbody);
                container.appendChild(table);
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            loadDateSheet();
            
            // Update when exam type changes
            document.getElementById('exam-type').addEventListener('change', function() {
                populateTimeSlotDropdown();
                filterDateSheet();
            });
        });
    </script>
</body>
</html>