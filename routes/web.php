<?php

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TeacherTransferController;
use App\Http\Controllers\PrincipalTransferController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Landing page routes
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/about', [LandingPageController::class, 'about'])->name('landing.about');
Route::get('/features', [LandingPageController::class, 'features'])->name('landing.features');
Route::get('/contact', [LandingPageController::class, 'contact'])->name('landing.contact');
Route::get('/login-as', [LandingPageController::class, 'loginRedirection'])->name('landing.login-redirection');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/changepassword', [ProfileController::class, 'passwordreset'])->name('password.change');
Route::post('/changepassword', [ProfileController::class, 'updatePassword'])->name('password.change.submit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/attachment', [ProfileController::class, 'attachment'])->name('profile.attachment');
});

Route::middleware('auth')->group(function () {
    Route::get('/settings/dashboard', [SettingsController::class, 'index'])->name('settings.dashboard');
    Route::get('/settings/permissionlist', [SettingsController::class, 'permissionlist'])->name('settings.permissionlist');
    Route::get('/settings/updatepermissions', [SettingsController::class, 'updatePermission'])->name('settings.updatepermission');
    Route::post('/settings/updatepermissions', [SettingsController::class, 'storePermission'])->name('settings.storepermission');
    Route::get('/settings/rolepermission', [SettingsController::class, 'rolePermission'])->name('settings.rolepermission');
    Route::post('/settings/rolepermission', [SettingsController::class, 'storeRolePermission'])->name('settings.storerolepermission');
    // Route::get('/settings/roleslist', [SettingsController::class, 'roleslist'])->name('settings.roleslist');
    // Route::post('/settings/roleslist', [SettingsController::class, 'rolesstore'])->name('settings.rolesstore');
    // Route::post('/settings/roleslistupdate', [SettingsController::class, 'rolesupdate'])->name('settings.rolesupdate');

    Route::prefix('settings')->name('settings.')->group(function () {
        // Roles Management
        Route::prefix('roles')->name('roles.')->group(function () {
            // List roles
            Route::get('/', [RoleController::class, 'index'])->name('list');

            // Store new role
            Route::post('/', [RoleController::class, 'store'])->name('store');

            // Toggle status (enable/disable)
            Route::patch('/{role}/toggle', [RoleController::class, 'toggle'])->name('toggle');

            // Delete role
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
        });
    });

    Route::get('/myprofile', [UserController::class, 'myprofile'])->name('profile.myprofile')->middleware('permission:my_profile');
    Route::get('/myprofileedit', [UserController::class, 'myprofileedit'])->name('profile.myprofileedit');
    Route::post('/myprofilestore', [UserController::class, 'myprofilestore'])->name('profile.myprofilestore');
    Route::get('/myappointment', [UserController::class, 'myappointment'])->name('profile.myappointment');

    /* Teacher Section */
    Route::get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard')->middleware('permission:slts_dashboard');
    Route::get('/teacher/reportlist', [TeacherController::class, 'reportlist'])->name('teacher.reportlist')->middleware('permission:slts_report_list');
    Route::get('/teacher/fullreport', [TeacherController::class, 'fullreport'])->name('teacher.fullreport')->middleware('permission:slts_full_report');
    Route::get('/teacher/fullreportPDF', [TeacherController::class, 'fullreportPDF'])->name('teacher.fullreportPDF')->middleware('permission:slts_full_report_pdf');
    Route::post('/teacher/exportfullreportpdf', [TeacherController::class, 'exportfullreportPDF'])->name('teacher.exportfullreportpdf');
    Route::get('/teacher/transferreport', [TeacherTransferController::class, 'transferreport'])->name('teacher.transferreport');
    Route::get('/teacher/register', [TeacherController::class, 'create'])->name('teacher.register')->middleware('permission:slts_register');
    Route::post('/teacher/register', [TeacherController::class, 'store'])->name('teacher.store');

    Route::get('/teacher/profile', [TeacherController::class, 'profile'])->name('teacher.profile')->middleware('permission:slts_profile')->middleware('permission:slts_profile');
    Route::get('/teacher/profileedit', [TeacherController::class, 'profileedit'])->name('teacher.profileedit')->middleware('permission:slts_profile_edit');
    Route::post('/teacher/profileupdate', [TeacherController::class, 'profileupdate'])->name('teacher.profileupdate');


    /* Teacher Transfer Section */
    Route::get('/teacher/transferdashboard', [TeacherTransferController::class, 'index'])->name('teacher.transferdashboard');
    Route::get('/teacher/transfer', [TeacherTransferController::class, 'teacherindex'])->name('teacher.transfer');
    Route::post('/teacher/transfercompleate', [TeacherTransferController::class, 'teacherstore'])->name('teacher.transferstore');
    Route::get('/teacher-transfers-pdf', [TeacherTransferController::class, 'teacherPersonalPdf']);
    Route::get('/teachertransferprincipallist', [TeacherTransferController::class, 'teachertransferprincipallist'])->name('teacher.transferprincipallist');
    Route::get('/teachertransferzonelist', [TeacherTransferController::class, 'teachertransferzonelist'])->name('teacher.transferzonelist');
    Route::get('/teachertransferprincipalprofile', [TeacherTransferController::class, 'teachertransferprincipalprofile'])->name('teacher.transferprincipalprofile');
    Route::get('/teachertransferzonalprofile', [TeacherTransferController::class, 'teachertransferzonalprofile'])->name('teacher.transferzonalprofile');
    Route::post('/teachertransferprincipalprofileconfirm', [TeacherTransferController::class, 'teachertransferprincipalprofilestore'])->name('teacher.transferprincipalprofilestore');
    Route::post('/teachertransferzonalprofileconfirm', [TeacherTransferController::class, 'teachertransferzonalprofilestore'])->name('teacher.transferzonalprofilestore');
    Route::get('/teachertransfersummary', [TeacherTransferController::class, 'transfersummary'])->name('teacher.transfersummary');


    /* principal Section */
    Route::get('/principal/dashboard', [PrincipalController::class, 'index'])->name('principal.dashboard')->middleware('permission:slps_dashboard');
    Route::get('/principal/reportlist', [PrincipalController::class, 'reportlist'])->name('principal.reportlist')->middleware('permission:slps_report_list');
    Route::get('/principal/fullreport', [PrincipalController::class, 'fullreport'])->name('principal.fullreport')->middleware('permission:slps_full_report');
    Route::get('/principal/fullreportPDF', [PrincipalController::class, 'fullreportPDF'])->name('principal.fullreportPDF')->middleware('permission:slps_full_report_pdf');
    //Route::get('/principal/fullreportpdf', [PrincipalController::class, 'fullreportPDF'])->name('principal.fullreportpdf');
    Route::post('/principal/exportfullreportpdf', [PrincipalController::class, 'exportfullreportPDF'])->name('principal.exportfullreportpdf');
    Route::get('/principal/transferreport', [PrincipalTransferController::class, 'transferreport'])->name('principal.transferreport');
    Route::get('/principal/transferreportPDF', [PrincipalTransferController::class, 'transferreportPDF'])->name('principal.transferreportPDF');
    Route::post('/principal/exporttransferreportpdf', [PrincipalTransferController::class, 'exporttransferreportPDF'])->name('principal.exporttransferreportpdf');
    Route::get('/principal/register', [PrincipalController::class, 'create'])->name('principal.register')->middleware('permission:slps_register');
    Route::post('/principal/register', [PrincipalController::class, 'store'])->name('principal.store');

    Route::get('/principal/profile', [PrincipalController::class, 'profile'])->name('principal.profile')->middleware('permission:slps_profile');
    Route::get('/principal/profileedit', [PrincipalController::class, 'profileedit'])->name('principal.profileedit')->middleware('permission:slps_profile_edit');
    Route::post('/principal/profileupdate', [PrincipalController::class, 'profileupdate'])->name('principal.profileupdate');

    /* Principal Transfer Section */
    Route::get('/principal/transferdashboard', [PrincipalTransferController::class, 'index'])->name('principal.transferdashboard');
    Route::get('/principal/transfer', [PrincipalTransferController::class, 'principalindex'])->name('principal.transfer');
    Route::post('/principal/transfercompleate', [PrincipalTransferController::class, 'principalstore'])->name('principal.transferstore');
    Route::get('/principal-transfers-pdf', [PrincipalTransferController::class, 'principalPersonalPdf']);
    Route::get('/principaltransferprincipallist', [PrincipalTransferController::class, 'principaltransferprincipallist'])->name('principal.transferprincipallist');
    Route::get('/principaltransferzonelist', [PrincipalTransferController::class, 'principaltransferzonelist'])->name('principal.transferzonelist');
    Route::get('/principaltransferprincipalprofile', [PrincipalTransferController::class, 'principaltransferprincipalprofile'])->name('principal.transferprincipalprofile');
    Route::get('/principaltransferzonalprofile', [PrincipalTransferController::class, 'principaltransferzonalprofile'])->name('principal.transferzonalprofile');
    Route::post('/principaltransferprincipalprofileconfirm', [PrincipalTransferController::class, 'principaltransferprincipalprofilestore'])->name('principal.transferprincipalprofilestore');
    Route::post('/principaltransferzonalprofileconfirm', [PrincipalTransferController::class, 'principaltransferzonalprofilestore'])->name('principal.transferzonalprofilestore');
    Route::get('/principaltransfersummary', [PrincipalTransferController::class, 'transfersummary'])->name('principal.transfersummary');


Route::get('/school/profile', [SchoolController::class, 'profile'])->name('school.profile');
Route::get('/school/classprofile/{id?}', [SchoolController::class, 'classprofile'])->name('school.classprofile');
Route::get('/school/classsetup', [SchoolController::class, 'classsetup'])->name('school.classsetup');
Route::post('/school/classprofile/{id?}', [SchoolController::class, 'classstore'])->name('school.classstore');

Route::get('/school/dashboard', [SchoolController::class, 'index'])->name('school.dashboard')->middleware('permission:school_dashboard');
Route::get('/school/register', [SchoolController::class, 'create'])->name('school.register')->middleware('permission:school_register');
Route::post('/school/register', [SchoolController::class, 'store'])->name('school.store');
Route::get('/school/reportlist', [SchoolController::class, 'reportlist'])->name('school.reportlist')->middleware('permission:school_report_list');
Route::get('/school/fullreport', [SchoolController::class, 'fullreport'])->name('school.fullreport')->middleware('permission:school_full_report');
Route::get('/school/fullreportPDF', [SchoolController::class, 'fullreportPDF'])->name('school.fullreportPDF');
Route::post('/school/exportfullreportpdf', [SchoolController::class, 'exportfullreportPDF'])->name('school.exportfullreportpdf');

Route::get('/school/reports', [SchoolController::class, 'reports'])->name('school.reports');
Route::get('/school/classdashboard', [SchoolController::class, 'classindex'])->name('school.classdashboard');
});



require __DIR__.'/auth.php';
