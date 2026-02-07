<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Parent</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
<div class="bg-white rounded-lg shadow-md w-full max-w-lg p-6 relative">
    <h1 class="text-2xl font-bold mb-6 text-center">Add New Parent</h1>
    <div id="loader" class="hidden absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-50 rounded">
        <div class="loader border-4 border-blue-500 border-t-transparent rounded-full w-10 h-10 animate-spin"></div>
    </div>
    <div id="alertBox" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <h2 class="text-xl font-semibold text-green-600 mb-3">Parent Added Successfully!</h2>
            <p id="alertMessage" class="mb-4 text-gray-700 text-sm"></p>
            <button onclick="document.getElementById('alertBox').classList.add('hidden')"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded">
                Close
            </button>
        </div>
    </div>
    <form id="parentForm" class="space-y-5">
        <div>
            <label for="student_id" class="block mb-1 font-medium text-gray-700">Select Student <span class="text-red-500">*</span></label>
            <select id="student_id" name="student_id" required
                    class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Select Student --</option>
            </select>
            <p id="studentError" class="text-red-600 text-sm mt-1 hidden">Please select a student.</p>
        </div>
        <div>
            <label for="name" class="block mb-1 font-medium text-gray-700">Parent Name <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" required
                   class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="Parent full name"/>
            <p id="nameError" class="text-red-600 text-sm mt-1 hidden">Please enter a name.</p>
        </div>
        <div>
            <label for="relation_with_student" class="block mb-1 font-medium text-gray-700">Relation with Student <span class="text-red-500">*</span></label>
            <select id="relation_with_student" name="relation_with_student" required
                    class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Select Relation --</option>
                <option value="Father">Father</option>
                <option value="Mother">Mother</option>
                <option value="Guardian">Guardian</option>
                <option value="Other">Other</option>
            </select>
            <p id="relationError" class="text-red-600 text-sm mt-1 hidden">Please select a relation.</p>
        </div>

        <div>
            <label for="contact" class="block mb-1 font-medium text-gray-700">Contact Number</label>
            <input type="text" id="contact" name="contact" maxlength="11" minlength="11"
                   class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="11-digit contact number (optional)" />
            <p id="contactError" class="text-red-600 text-sm mt-1 hidden">Contact must be exactly 11 digits.</p>
        </div>

        <div>
            <label for="address" class="block mb-1 font-medium text-gray-700">Address</label>
            <textarea id="address" name="address" rows="3" placeholder="Optional address"
                      class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"></textarea>
        </div>
        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded">
            Add Parent
        </button>
        <p id="formMessage" class="mt-4 text-center font-semibold"></p>
    </form>
</div>
<style>
    .loader {
        border-top-color: transparent;
        border-radius: 50%;
    }
</style>
<script>
    const studentDropdown = document.getElementById('student_id');
    const loader = document.getElementById('loader');
    const alertBox = document.getElementById('alertBox');
    const alertMessage = document.getElementById('alertMessage');
    const formMessage = document.getElementById('formMessage');
    fetch('https://lms-backend-dqdn.onrender.com/api/Dropdown/AllStudentData')
        .then(res => res.json())
        .then(data => {
            data.forEach(student => {
                const opt = document.createElement('option');
                opt.value = student.id;
                opt.textContent = student.Format;
                studentDropdown.appendChild(opt);
            });
        })
        .catch(() => {
            formMessage.textContent = "Unable to load student list.";
            formMessage.classList.add('text-red-600');
        });

    function validateContact(value) {
        return value === '' || (/^\d{11}$/.test(value));
    }

    document.getElementById('parentForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const student_id = studentDropdown.value;
        const name = document.getElementById('name').value.trim();
        const relation = document.getElementById('relation_with_student').value;
        const contact = document.getElementById('contact').value.trim();
        const address = document.getElementById('address').value.trim();
        ['studentError', 'nameError', 'relationError', 'contactError'].forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });

        let hasError = false;

        if (!student_id) {
            document.getElementById('studentError').classList.remove('hidden');
            hasError = true;
        }
        if (!name) {
            document.getElementById('nameError').classList.remove('hidden');
            hasError = true;
        }
        if (!relation) {
            document.getElementById('relationError').classList.remove('hidden');
            hasError = true;
        }
        if (!validateContact(contact)) {
            document.getElementById('contactError').classList.remove('hidden');
            hasError = true;
        }

        if (hasError) return;

        loader.classList.remove('hidden');

        fetch('https://lms-backend-dqdn.onrender.com/api/parents/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                student_id: student_id,
                name: name,
                relation_with_student: relation,
                contact: contact || null,
                address: address || null
            })
        })
        .then(async response => {
            const resData = await response.json();
            if (!response.ok) throw resData;

            // Show modal alert with username & password
            document.getElementById('parentForm').reset();
            alertMessage.innerHTML = `
                ${resData.message}<br><br>
                <strong>Username:</strong> ${resData.username}<br>
                <strong>Password:</strong> ${resData.password}
            `;
            alertBox.classList.remove('hidden');
        })
        .catch(err => {
            formMessage.textContent = err?.message || "Something went wrong.";
            formMessage.classList.add('text-red-600');
        })
        .finally(() => {
            loader.classList.add('hidden');
        });
    });
</script>
</body>
</html>
