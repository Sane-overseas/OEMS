<?php
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\ExamScheduleController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\SuperAdmin\SecurityLogController;
use App\Http\Controllers\Admin\AdminSecurityLogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SuperAdmin\Auth\LoginController as SuperAdminLoginController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\SchoolController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\StaffRequestController as SuperAdminStaffRequestController;
use App\Http\Controllers\SuperAdmin\AdminRequestController as SuperAdminAdminRequestController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\StaffRequestController;
use App\Http\Controllers\Admin\RequestController as AdminRequestController;
use App\Http\Controllers\Admin\StudentController;

// Public Welcome Page
Route::get('/clear-cache', function () {

    // Only allow in local or admin environment for security
    if (!app()->environment(['local', 'staging', 'production'])) {
        abort(403, 'Unauthorized.');
    }

    // Clear all caches
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return "All caches cleared successfully!";
})->name('clear.cache');

Route::view('/', 'welcome')->name('welcome');

// SuperAdmin Routes
Route::prefix('superadmin')->name('superadmin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Guest SuperAdmin (NOT logged in)
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest:superadmin')->group(function () {

        Route::get('login', [SuperAdminLoginController::class, 'showLoginForm'])
            ->name('login');

        Route::post('login', [SuperAdminLoginController::class, 'login'])
            ->name('login.submit');

        Route::get('login-otp', [SuperAdminLoginController::class, 'showOtpForm'])
            ->name('otp.form');

        Route::post('login-otp', [SuperAdminLoginController::class, 'sendOtp'])
            ->name('otp.send');

        Route::get('verify-otp', [SuperAdminLoginController::class, 'showVerifyOtpForm'])
            ->name('otp.verify.form');

        Route::post('verify-otp', [SuperAdminLoginController::class, 'verifyOtp'])
            ->name('otp.verify');
    });


    /*
    |--------------------------------------------------------------------------
    | Authenticated SuperAdmin
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:superadmin')->group(function () {

        // logout
        Route::post('logout', [SuperAdminLoginController::class, 'logout'])
            ->name('logout');

        // dashboard
        Route::get('dashboard', [SuperAdminDashboardController::class, 'index'])
            ->name('dashboard');

        // security logs
        Route::get('security-logs', [SecurityLogController::class, 'index'])
            ->name('security.logs');

        Route::get('security-logs/export', [SecurityLogController::class, 'export'])
            ->name('security.logs.export');


        // School Management
        Route::prefix('schools')->name('schools.')->group(function () {

            Route::get('/', [SchoolController::class, 'index'])->name('index');
            Route::get('create', [SchoolController::class, 'create'])->name('create');
            Route::post('store', [SchoolController::class, 'store'])->name('store');
            Route::get('{school}/create-admin', [SchoolController::class, 'createAdmin'])->name('create-admin');
            Route::post('{school}/admin-store', [AdminController::class, 'storeSchoolAdmin'])->name('admin-store');
            Route::get('{school}/edit', [SchoolController::class, 'edit'])->name('edit');
            Route::put('{school}', [SchoolController::class, 'update'])->name('update');
            Route::get('{school}/edit-admin', [SchoolController::class, 'editAdmin'])->name('edit-admin');
            Route::put('{school}/admin-update/{admin}', [AdminController::class, 'updateSchoolAdmin'])->name('admin-update');

        });

        // Admin Management
        Route::prefix('admins')->name('admins.')->group(function () {

            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::get('create', [AdminController::class, 'create'])->name('create');
            Route::post('/', [AdminController::class, 'store'])->name('store');
            Route::get('{admin}/edit', [AdminController::class, 'edit'])->name('edit');
            Route::put('{admin}', [AdminController::class, 'update'])->name('update');

        });

        // Staff Approval Queue
        Route::prefix('staff-requests')->name('staff-requests.')->group(function () {

            Route::get('/', [SuperAdminStaffRequestController::class, 'index'])->name('index');
            Route::get('{staffRequest}', [SuperAdminStaffRequestController::class, 'show'])->name('show');
            Route::post('{staffRequest}/approve', [SuperAdminStaffRequestController::class, 'approve'])->name('approve');
            Route::post('{staffRequest}/reject', [SuperAdminStaffRequestController::class, 'reject'])->name('reject');

        });

        // Admin Reset/Block Requests
        Route::prefix('admin-requests')->name('admin-requests.')->group(function () {

            Route::get('/', [SuperAdminAdminRequestController::class, 'index'])->name('index');
            Route::post('{adminRequest}/action', [SuperAdminAdminRequestController::class, 'action'])->name('action');

        });

    });

});


// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Show login form (password + OTP)
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');

    // Password login submit
    Route::post('login', [AdminLoginController::class, 'login'])->name('login.submit');

    // Send OTP email
    Route::post('send-otp', [AdminLoginController::class, 'sendOtp'])->name('send.otp');

    // Show OTP verification form
    Route::get('verify-otp', [AdminLoginController::class, 'otpForm'])->name('otp.verify.form');

    // Verify OTP and login
    Route::post('verify-otp', [AdminLoginController::class, 'verifyOtp'])->name('verify.otp');
    Route::get('security-logs', [AdminSecurityLogController::class, 'index'])
        ->name('security.logs');
    Route::get(
        'security-logs/export',
        [AdminSecurityLogController::class, 'export']
    )->name('security.logs.export');

    // Authenticated Admin area
    Route::middleware('auth:admin')->group(function () {
        Route::view('dashboard', 'admin.dashboard')->name('dashboard');
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

        // Staff Creation Wizard
        Route::prefix('staff/create')->name('staff.create.')->group(function () {
            Route::get('step-1', [StaffRequestController::class, 'step1'])->name('step1');
            Route::post('step-1', [StaffRequestController::class, 'postStep1'])->name('postStep1');
            Route::get('step-2', [StaffRequestController::class, 'step2'])->name('step2');
            Route::post('step-2', [StaffRequestController::class, 'postStep2'])->name('postStep2');
            Route::get('step-3', [StaffRequestController::class, 'step3'])->name('step3');
            Route::post('step-3', [StaffRequestController::class, 'postStep3'])->name('postStep3');
            Route::get('review', [StaffRequestController::class, 'review'])->name('review');
            Route::post('submit', [StaffRequestController::class, 'submit'])->name('submit');
        });

        Route::get('requests/staff/create', [AdminRequestController::class, 'createStaffRequest'])->name('requests.staff.create');
        Route::post('requests/staff', [AdminRequestController::class, 'storeStaffRequest'])->name('requests.staff.store');

        // Student Management
        Route::resource('students', StudentController::class);
    });

    Route::get('questions/bulk-upload', [QuestionController::class, 'bulkForm'])
        ->name('questions.bulk.form');

    Route::post('questions/bulk-upload', [QuestionController::class, 'bulkUpload'])
        ->name('questions.bulk.upload');

    Route::resource('questions', QuestionController::class)
        ->except(['show']);



    Route::get('exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('exams/create', [ExamController::class, 'create'])->name('exams.create');
    Route::post('exams', [ExamController::class, 'store'])->name('exams.store');

    Route::get('exams/{id}/questions', [ExamController::class, 'questions'])
        ->name('exams.questions');

    Route::post('exams/{id}/questions', [ExamController::class, 'attachQuestions'])
        ->name('exams.attach');

    Route::get('exams/{id}/schedule', [ExamScheduleController::class, 'create'])
        ->name('exams.schedule');

    Route::post('exams/{id}/schedule', [ExamScheduleController::class, 'store'])
        ->name('exams.schedule.store');

    Route::post('exams/{id}/publish', [ExamController::class, 'publish'])
        ->name('exams.publish');

    Route::post('exams/{id}/close', [ExamController::class, 'close'])
        ->name('exams.close');
    Route::get('exams/{id}', [ExamController::class, 'show'])
        ->name('exams.show');
    Route::get('exams/{id}/edit', [ExamController::class, 'edit'])
        ->name('exams.edit');

    Route::put('exams/{id}', [ExamController::class, 'update'])
        ->name('exams.update');


    // Route::prefix('exams')->name('exams.')->group(function () {

    //     Route::get('/', [ExamController::class, 'index'])
    //         ->name('index');

    //     Route::get('create', [ExamController::class, 'create'])
    //         ->name('create');

    //     Route::post('/', [ExamController::class, 'store'])
    //         ->name('store');

    //     Route::get('{exam}/questions', [ExamController::class, 'editQuestions'])
    //         ->name('edit-questions');

    //     Route::post('{exam}/questions', [ExamController::class, 'attachQuestions'])
    //         ->name('attach-questions');
    //     Route::post(
    //         '{exam}/publish',
    //         [ExamController::class, 'publish']
    //     )->name('publish');

    //     Route::post(
    //         '{exam}/close',
    //         [ExamController::class, 'close']
    //     )->name('close');


    // });

    // Route::get(
    //     'exams/{exam}/schedule',
    //     [ExamScheduleController::class, 'create']
    // )->name('exams.schedule');

    // Route::post(
    //     'exams/{exam}/schedule',
    //     [ExamScheduleController::class, 'store']
    // )->name('exams.schedule.store');

});
