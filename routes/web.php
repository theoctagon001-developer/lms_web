<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Services\ApiConfig;

// Backend health check route
Route::get('/backend-status', function () {
    try {
        ApiConfig::init();
        $backendUrl = ApiConfig::getApiBaseUrl();
        
        $response = Http::timeout(120)->get($backendUrl . 'api/health');
        
        if ($response->successful()) {
            $data = $response->json();
            return response()->json([
                'status' => 'success',
                'backend' => [
                    'url' => $backendUrl,
                    'working' => true,
                    'database' => $data['database'] ?? null
                ],
                'timestamp' => now()->toDateTimeString()
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'backend' => [
                    'url' => $backendUrl,
                    'working' => false,
                    'error' => 'Backend returned non-success status'
                ],
                'timestamp' => now()->toDateTimeString()
            ], 503);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'backend' => [
                'url' => ApiConfig::getApiBaseUrl() ?? 'unknown',
                'working' => false,
                'error' => $e->getMessage()
            ],
            'timestamp' => now()->toDateTimeString()
        ], 503);
    }
});

//````````````````````````````````DATACELL ( SAMEER )```````````````````````````````````//
Route::prefix('datacell')->group(function () {
    //TEMP_ENROLLMENTS
    Route::view('/approve/temp/enroll', 'DATACELL.temporary_enrollments.temp')->name('Datacell.temp.enroll');
    //PROFILE
    Route::view('/datacell/profile', 'DATACELL.profile')->name('datacell.profile');
    Route::view('/datacell/profile/edit', 'DATACELL.edit_profile')->name('datacell.edit_profile');
    //NOTIFICATIONS
    Route::view('/notification', 'DATACELL.Notification.notification_sending')->name('datacell.notification');
    //MANAGE-USERS
    Route::view('/account/manage', 'DATACELL.manage_users.account_recovery')->name('datacell.user');
    //EXCEL
    Route::view('/add/enroll', 'DATACELL.enrollments.add_enroll_excel')->name('datacell.add.enroll_excel');
    Route::view('/add/student/excel', 'DATACELL.student.add_student_excel')->name('datacell.add.student_excel');
    Route::view('/add/exam/excel', 'DATACELL.exam.add_exam_excel')->name('datacell.add.exam_excel');
    Route::view('/add/result/excel', 'DATACELL.result.add_result_excel')->name('datacell.add.result_excel');
    //USER_MANAGEMENT
    Route::view('/add/admin', 'DATACELL.manage_users.add_admin')->name('datacell.add.admin');
    Route::view('/add/datacell', 'DATACELL.manage_users.add_datacell')->name('datacell.add.datacell');
    Route::view('/add/hod', 'DATACELL.manage_users.add_hod')->name('datacell.add.hod');
    Route::view('/add/student', 'DATACELL.student.add_student')->name('datacell.add.student');
    Route::view('/add/director', 'DATACELL.manage_users.add_director')->name('datacell.add.director');
    //Section_Info
    Route::view('/view/sections', 'DATACELL.section_info.section_info')->name('datacell.view.section');
    //EXAM
    Route::view('/view/exam', 'DATACELL.exam.exam')->name('datacell.view.exam');
    //Student_Flow
    Route::view('/datacell/view/exam', 'DATACELL.student.view')->name('datacell.view.student');
    Route::get('/datacell/student/details', function (Request $request) {
        $studentEncoded = $request->query('student');
        if (!$studentEncoded) {
            return redirect()->back()->with('error', 'Invalid student data');
        }
        $student = json_decode(base64_decode($studentEncoded), true);

        return view('DATACELL.student.student_details', compact('student'));
    })->name('datacell.student.details');
    Route::get('/datacell/transcript/{student_id}', [AuthController::class, 'TranscriptDatacell'])->name('datacell.transcript.view');
    //Result_Flow
    Route::view('/view/result', 'DATACELL.result.view')->name('datacell.view.result');
    //Enrollments
    Route::view('/enroll/view', 'DATACELL.enrollments.view')->name('datacell.view.enroll');
    //Degree_Program
    Route::view('/degree_program', 'DATACELL.Degree_Program.degree_program')->name('degree_program');
    //Parent
    Route::view('/parent_add', 'DATACELL.Parent.add_parent')->name('parents.add');
    Route::view('/parent_view', 'DATACELL.Parent.view_parents')->name('parents.view');
    Route::view('/re_enroll', 'DATACELL.Parent.review_re_enroll')->name('re_enroll.request');
    //PROMOTION SCENRAIO
    Route::view('/promote/students', 'DATACELL.result.promote')->name('promote');
    //EDIT-MANAGEMENT
    Route::view('/manage/staff', 'DATACELL.Core_Management.Manage_Management')->name('manage_staff');
    //Add-Enroll
    Route::view('/single/enrollments', 'DATACELL.enrollments.add_new_enrollments_with_form')->name('enrolments.create');

});
//```````````````````````````````````HOD ( SAMEER )``````````````````````````````````//
Route::prefix('hod')->group(function () {
    Route::view('/dashboard', 'HOD.hod_dashboard')->name('hod.dashboard1');
    // Management
    Route::view('/teachers/add', 'HOD.teachers.add')->name('hod.teachers.add');
    Route::view('/juniors/add', 'HOD.juniors.add')->name('hod.juniors.add');
    Route::view('/courses/add', 'HOD.courses.add')->name('hod.courses.add');
    // Allocation
    Route::view('/courses/allocation', 'HOD.courses.allocation')->name('hod.courses.allocation');
    Route::get('/course-details', function (Request $request) {
        $studentEncoded = $request->query('course');
        if (!$studentEncoded) {
            return redirect()->back()->with('error', 'Invalid course data');
        }
        $course = json_decode(base64_decode($studentEncoded), true);

        return view('hod.courses.section_detail', compact('course'));
    })->name('course.details');
    Route::view('/juniors/allocation', 'HOD.juniors.allocation')->name('hod.juniors.allocation');
    // Content & Exams
    Route::view('/courses/content', 'HOD.courses.content')->name('hod.courses.content');
    Route::view('/courses/content/copy', 'HOD.courses.content_copy')->name('hod.courses.content.copy');
    Route::view('/exams/create', 'HOD.exams.view_exam')->name('hod.exams.create');
    Route::get('/exam/create', function (Request $request) {
        $offered_course_id = $request->query('offered_course_id');
        $type = $request->query('type');
        $course_name = $request->query('course_name');
        return view('HOD.exams.create', [
            'offered_course_id' => $offered_course_id,
            'type' => $type,
            'course_name' => $course_name,
        ]);
    })->name('hod.exam.create');
    Route::view('/content/create', 'HOD.courses.add_content')->name('hod.courses.add_content');
    // Sessions & Archives
    Route::view('/sessions/add', 'HOD.sessions.add')->name('hod.sessions.add');
    Route::view('/archives/manage', 'HOD.archives.manage')->name('hod.archives.manage');
    Route::view('/teachers/view', 'HOD.teachers.view')->name('hod.teachers.view');
    Route::get('/hod/teacher/details', function (Request $request) {
        $studentEncoded = $request->query('teacher');
        $roleEncoded = $request->query('role');
        if (!$studentEncoded || !$roleEncoded) {
            return redirect()->back()->with('error', 'Invalid teacher data');
        }
        $teacher = json_decode(base64_decode($studentEncoded), true);
        $role = base64_decode($roleEncoded);
        return view('HOD.teachers.details', compact('teacher', 'role'));
    })->name('hod.teacher.details');
    Route::get('/hod/allocation/details', function (Request $request) {
        $studentEncoded = $request->query('allocation');
        if (!$studentEncoded) {
            return redirect()->back()->with('error', 'Invalid course data');
        }
        $course = json_decode(base64_decode($studentEncoded), true);
        return view('HOD.courses.section_detail', compact('course'));
    })->name('hod.allocation.details');
    Route::view('/juniors/view', 'HOD.juniors.view')->name('hod.juniors.view');
    Route::view('/courses/view', 'HOD.courses.view')->name('hod.courses.view');
    Route::view('/courses/copy', 'HOD.courses.copy_content')->name('hod.courses.copy_content');

    Route::get('/timetable', [AuthController::class, 'FullTimetable1'])->name('hod.timetable.view');
    Route::get('/full/timetable', function () {
        $timetable = session('timetable');
        return view('HOD.timetable.view', compact('timetable'));
    })->name('hod.full');
    // Extra
    Route::view('/notifications/send', 'HOD.notifications.send')->name('hod.notifications.send');
    Route::view('/credentials/update', 'HOD.credentials.update')->name('hod.credentials.update');
    //EXCEL
    Route::view('/topic/excel', 'HOD.courses.add_topic_excel')->name('hod.courses.add_topic');
    Route::view('/teacher/allocation/excel', 'HOD.courses.add_teacher_allocation')->name('hod.courses.add_teacher_allocation');
    Route::view('/junior/allocation/excel', 'HOD.courses.add_junior_allocation')->name('hod.courses.add_junior_allocation');


    Route::view('/teacher/excel', 'HOD.teachers.add_teacher_excel')->name('hod.teachers.add_teacher_excel');
    Route::view('/junior/excel', 'HOD.juniors.add_junior_excel')->name('hod.juniors.add_junior_excel');
    Route::view('/course/excel', 'HOD.courses.add_course_excel')->name('hod.courses.add_course_excel');
    Route::view('/hod/profile', 'HOD.profile')->name('hod.profile');
    Route::view('/hod/profile/edit', 'HOD.edit_profile')->name('hod.edit_profile');
    //Add-Task-Limit
    Route::view('/add_limit', 'Hod.Task_Limit.add_task_limit')->name('task_limit');
    //Audit
    Route::view('/audit/report', 'Hod.Audit_Report.Audit')->name('Audit_Report');
});
//````````````````````````````````ADMIN ( SHARJEEL )`````````````````````//~
Route::prefix('admin')->group(function () {
    // ----------------------adminnnnnnnnnnnnnnnnnnnn--------------

    Route::get('/admin/dashboard', function () {
        $userData = session('userData');

        if (!empty($userData['user_id'])) {
            session(['user_id' => $userData['user_id']]);
        }


        return view('admin.Admin_Home', compact('userData'));
    })->name('admin.dashboard1');

    Route::get('/admin/transcript/{student_id}', [AuthController::class, 'Transcript'])->name('transcript.view');

    Route::get('/teacher/details', function (Request $request) {
        $studentEncoded = $request->query('teacher');
        $roleEncoded = $request->query('role');
        if (!$studentEncoded || !$roleEncoded) {
            return redirect()->back()->with('error', 'Invalid teacher data');
        }
        $teacher = json_decode(base64_decode($studentEncoded), true);
        $role = base64_decode($roleEncoded);
        return view('admin.teacher_profile', compact('teacher', 'role'));
    })->name('teacher.details');
    Route::get('/send/notification', function () {
        return view('admin.notification_sending');
    })->name('send.notification');

    Route::get('/all_students', function () {
        return view('admin.all_student');
    })->name('all.student');
    Route::get('/all_course', function () {
        return view('admin.all_course');
    })->name('all.course');
    Route::get('/all_teacher', function () {
        return view('admin..all_teacher');
    })->name('all.teacher');
    Route::get('/all_junior', function () {
        return view('admin.all_junior');
    })->name('all.junior');
    Route::get('/all_grader', function () {
        return view('admin.all_grader');
    })->name('all.grader');
    Route::get('/all_session', function () {
        return view('admin.all_sessions');
    })->name('all.session');
    Route::get('/all_content', function () {
        return view('admin.all_course_content');
    })->name('all.course_content');
    Route::get('/all_course_allocation', function () {
        return view('admin.all_course_allocation');
    })->name('all.course_allocation');
    Route::get('/Graders', function () {
        return view('admin.Add-Grader');
    })->name('all.Graders');

    Route::get('/admin/enrollments', function () {
        return view('admin.excel_enrollments');
    })->name('show.enrollments');
    Route::get('/admin/all_temp_enrollments', function () {
        return view('admin.temp');
    })->name('temp.enroll');
    Route::get('/admin/upload-timetable', function () {
        return view('admin.UploadTimetable');
    })->name('show.timetable');

    Route::get('/timetable', [AuthController::class, 'FullTimetable'])->name('full.timetable');
    Route::get('/admin/full-timetable', function () {
        $timetable = session('timetable');
        return view('admin.full_timetable', compact('timetable'));
    })->name('full');
    Route::get('/student/details', function (Request $request) {
        $studentEncoded = $request->query('student');
        if (!$studentEncoded) {
            return redirect()->back()->with('error', 'Invalid student data');
        }
        $student = json_decode(base64_decode($studentEncoded), true);

        return view('admin.student_details', compact('student'));
    })->name('student.details');
    Route::get('/admin/excludeddays', function () {
        return view('admin.excel_excludeddays');
    })->name('show.excel_excludedDays');

    Route::get('/admin/grader_assign', function () {
        return view('admin.excel_graderList');
    })->name('show.grader');
    //--------------------------------------------------------ADMIN-DATACELL(DASHBOARD PROFILE HANDLING)----------------------------------------
    Route::get('/profile', function () {
        return view('components.profile');
    })->name('profile');
    Route::get('/profile/edit', function () {
        return view('components.edit_profile');
    })->name('profile.edit');
    Route::post('/update/profile', [AuthController::class, 'updateProfile'])->name('change.log');

    Route::get('/grader/info', function (Request $request) {
        $studentEncoded = $request->query('student_id');
        if (!$studentEncoded) {
            return redirect()->back()->with('error', 'Invalid student data');
        }
        $student_id = json_decode(base64_decode($studentEncoded), true);

        return view('admin.grader_info', compact('student_id'));
    })->name('grader.details');


    Route::get('/students', function () {
        $students = session('students');
        return view('admin.all_student', compact('students'));
    })->name('datacell.student');

    Route::get('/add/admin', function () {
        return view('admin.admin');
    })->name('add.admin');

    Route::get('/teacher/details', function (Request $request) {
        $studentEncoded = $request->query('teacher');
        $roleEncoded = $request->query('role');
        if (!$studentEncoded || !$roleEncoded) {
            return redirect()->back()->with('error', 'Invalid teacher data');
        }
        $teacher = json_decode(base64_decode($studentEncoded), true);
        $role = base64_decode($roleEncoded);
        return view('admin.teacher_profile', compact('teacher', 'role'));
    })->name('teacher.details');
    Route::view('/date_sheet/view', 'admin.date_sheet.view')->name('date_sheet');
    Route::view('/date_sheet/add', 'admin.date_sheet.add')->name('datacell.upload.datesheet');

});
//`````````````````````````````````DIRECTOR ( Ali )`````````````````````//
Route::prefix('director')->group(function () {
    Route::get('/transcript/{student_id}', [AuthController::class, 'Transcript2'])->name('Director.transcript.view');
    Route::get('/course-details', function (Request $request) {
        $studentEncoded = $request->query('course');
        if (!$studentEncoded) {
            return redirect()->back()->with('error', 'Invalid course data');
        }
        $course = json_decode(base64_decode($studentEncoded), true);

        return view('DIRECTOR.course_section_info', compact('course'));
    })->name('Director.course.details');
    Route::get('/all_session', function () {
        return view('DIRECTOR.All_Sessions');
    })->name('Director.session');
    Route::get('/all_content', function () {
        return view('DIRECTOR.CourseContent');
    })->name('Director.course_content');
    Route::get('/all_course', function () {
        return view('DIRECTOR.Courses');
    })->name('Director.course');
    Route::get('/all_course_allocation', function () {
        return view('DIRECTOR.Allocated_Courses');
    })->name('Director.course_allocation');

    Route::get('/timetable', [AuthController::class, 'FullTimetable2'])->name('timetable.view');
    Route::get('/full-timetable', function () {
        $timetable = session('timetable');
        return view('DIRECTOR.Timetable', compact('timetable'));
    })->name('Director.timetable');

    Route::get('/all_students', function () {
        return view('DIRECTOR.All_Student');
    })->name('Director.student');
    Route::view('/teachers', 'DIRECTOR.All_Teacher')->name('Director.teachers');

    Route::get('/all_junior', function () {
        return view('DIRECTOR.All_Junior');
    })->name('Director.junior');
    Route::get('/profile/edit', function () {
        return view('DIRECTOR.Edit_Profile');
    })->name('Director.edit');
    Route::get('/student/details', function (Request $request) {
        $studentEncoded = $request->query('student');
        if (!$studentEncoded) {
            return redirect()->back()->with('error', 'Invalid student data');
        }
        $student = json_decode(base64_decode($studentEncoded), true);

        return view('DIRECTOR.Trancript', compact('student'));
    })->name('Director.details');
    Route::get('/excludeddays', function () {
        return view('DIRECTOR.ExcludedDays');
    })->name('Director.excludedDays');
    Route::get('/AuditReport', function () {
        return view('DIRECTOR.Adut_Director');
    })->name('Director.auditdirector');
    Route::get('/ExamDetail', function () {
        return view('DIRECTOR.Exam_Director');
    })->name('Director.examdirector');
});


//-------DONOT TOUCH-----DONOT TOUCH---------COMPLETED--------DONOT TOUCH--------DONOT TOUCH---------DONOT TOUCH---------//
Route::get('/get-api-url', [ApiController::class, 'getApiUrl']);
Route::get('/update-api', [ApiController::class, 'updateApiUrl']);
Route::get('/dev_mood', function () {
    return view('layouts.your_baseUrl');
})->name('dev.mood');
Route::get('/clear-session', function () {
    Session::flush();
    return response()->json(['status' => 'success', 'message' => 'Session cleared successfully.']);
})->name('clear.session');
Route::get('/', function () {
    //  Session::flush();
    return view('AUTHENTICATION.login');
})->name('login');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('handleLogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout1');
Route::get('/forgot-password', function () {
    return view('AUTHENTICATION.forgot_password');
})->name('forgot');
Route::get('/OOps', function () {
    return view('AUTHENTICATION.un_authorized');
})->name('caught.it');
Route::get('/verify-otp-show', function () {
    return view('AUTHENTICATION.Login_verification');
})->name('otp.form');
Route::post('/verify-otp-ver', [AuthController::class, 'verifyOTP'])->name('verify.otp');
Route::get('/datacell/dashboard', function () {
    if (session('userType') !== 'Datacell') {
        return redirect()->route('caught.it');
    }
    $userData = session('userData');
    if (!empty($userData['user_id'])) {
        session(['user_id' => $userData['user_id']]);
    }return view('DATACELL.datacell_dashboard', compact('userData'));
})->name('datacell.dashboard');
Route::get('/admin/dashboard', function () {
    if (session('userType') !== 'Admin') {
        return redirect()->route('caught.it');
    }
    $userData = session('userData');
    if (!empty($userData['user_id'])) {
        session(['user_id' => $userData['user_id']]);
    }return view('admin.Admin_Home', compact('userData'));
})->name('admin.dashboard');
Route::get('/hod/dashboard', function () {
    if (session('userType') !== 'HOD') {
        return redirect()->route('caught.it');
    }
    return view('HOD.hod_dashboard');
})->name('hod.dashboard');
Route::get('/director/dashboard', function () {
    if (session('userType') !== 'Director') {
        return redirect()->route('caught.it');
    }
    return view('DIRECTOR.director_dashboard');
})->name('director.dashboard');