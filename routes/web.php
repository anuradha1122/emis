<?php

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeacherController;
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

    Route::get('/myprofile', [UserController::class, 'myprofile'])->name('profile.myprofile');
    Route::get('/myprofileedit', [UserController::class, 'myprofileedit'])->name('profile.myprofileedit');
    Route::post('/myprofilestore', [UserController::class, 'myprofilestore'])->name('profile.myprofilestore');
    Route::get('/myappointment', [UserController::class, 'myappointment'])->name('profile.myappointment');

    /* Teacher Section */
    Route::get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');
    Route::get('/teacher/reportlist', [TeacherController::class, 'reportlist'])->name('teacher.reportlist');
    Route::get('/teacher/fullreport', [TeacherController::class, 'fullreport'])->name('teacher.fullreport');
    Route::get('/teacher/fullreportPDF', [TeacherController::class, 'fullreportPDF'])->name('teacher.fullreportPDF');
    Route::get('/teacher/fullreportpdf', [TeacherController::class, 'fullreportPDF'])->name('teacher.fullreportpdf');
    Route::post('/teacher/exportfullreportpdf', [TeacherController::class, 'exportfullreportPDF'])->name('teacher.exportfullreportpdf');
    Route::get('/teacher/register', [TeacherController::class, 'create'])->name('teacher.register');
    Route::post('/teacher/register', [TeacherController::class, 'store'])->name('teacher.store');

    Route::get('/teacher/profile', [TeacherController::class, 'profile'])->name('teacher.profile');
    Route::get('/teacher/profileedit', [TeacherController::class, 'profileedit'])->name('teacher.profileedit');
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

    /* Non Academic Section */
    Route::get('/nonacademic/dashboard', [UserController::class, 'nonacademicindex'])->name('nonacademic.dashboard');
    Route::get('/nonacademic/register', [UserController::class, 'nonacademiccreate'])->name('nonacademic.register');
    Route::post('/nonacademic/register', [UserController::class, 'nonacademicstore'])->name('nonacademic.store');
    Route::get('/nonacademic/search', [UserController::class, 'nonacademicsearch'])->name('nonacademic.search');
    Route::get('/nonacademic/reports', [UserController::class, 'nonacademicreports'])->name('nonacademic.reports');
    Route::get('/nonacademic/fullreportcurrent', [UserController::class, 'nonacademicfullreportcurrent'])->name('nonacademic.fullreportcurrent');
    Route::get('/nonacademic/profile', [UserController::class, 'nonacademicprofile'])->name('nonacademic.profile');
    Route::get('/nonacademic/profileedit', [UserController::class, 'nonacademicprofileedit'])->name('nonacademic.profileedit');
    Route::post('/nonacademic/profileupdate', [UserController::class, 'nonacademicprofileupdate'])->name('nonacademic.profileupdate');


    Route::get('/principal/dashboard', [UserController::class, 'principalindex'])->name('principal.dashboard');
    Route::get('/principal/register', [UserController::class, 'principalcreate'])->name('principal.register');
    Route::post('/principal/register', [UserController::class, 'principalstore'])->name('principal.store');
    Route::get('/principal/search', [UserController::class, 'principalsearch'])->name('principal.search');
    Route::get('/principal/reports', [UserController::class, 'principalreports'])->name('principal.reports');
    Route::get('/principal/fullreportcurrent', [UserController::class, 'principalfullreportcurrent'])->name('principal.fullreportcurrent');
    Route::get('/principal/profile', [UserController::class, 'principalprofile'])->name('principal.profile');
    Route::get('/principal/profileedit', [UserController::class, 'principalprofileedit'])->name('principal.profileedit');
    Route::post('/principal/profileupdate', [UserController::class, 'principalprofileupdate'])->name('principal.profileupdate');
    Route::get('/principal/transfer', [TransferController::class, 'principalindex'])->name('principal.transfer');

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

Route::get('/sleas/dashboard', [UserController::class, 'sleasindex'])->name('sleas.dashboard');
Route::get('/sleas/register', [UserController::class, 'sleascreate'])->name('sleas.register');
Route::post('/sleas/register', [UserController::class, 'sleasstore'])->name('sleas.store');
Route::get('/sleas/search', [UserController::class, 'sleassearch'])->name('sleas.search');
Route::get('/sleas/reports', [UserController::class, 'sleasreports'])->name('sleas.reports');
Route::get('/sleas/fullreportcurrent', [UserController::class, 'sleasfullreportcurrent'])->name('sleas.fullreportcurrent');
Route::get('/sleas/profile', [UserController::class, 'sleasprofile'])->name('sleas.profile');

Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
Route::get('/student/register', [StudentController::class, 'create'])->name('student.register');
Route::post('/student/register', [StudentController::class, 'store'])->name('student.store');
Route::get('/student/search', [StudentController::class, 'search'])->name('student.search');
Route::get('/student/reports', [StudentController::class, 'reports'])->name('student.reports');
Route::get('/student/profile', [StudentController::class, 'profile'])->name('student.profile');
Route::get('/student/{studentNo}', [StudentController::class, 'idpdf'])->name('student.id');


Route::get('/school/search', [SchoolController::class, 'search'])->name('school.search');
Route::get('/school/profile/{id?}', [SchoolController::class, 'profile'])->name('school.profile');
Route::get('/school/classprofile/{id?}', [SchoolController::class, 'classprofile'])->name('school.classprofile');
Route::get('/school/classsetup', [SchoolController::class, 'classsetup'])->name('school.classsetup');
Route::post('/school/classprofile/{id?}', [SchoolController::class, 'classstore'])->name('school.classstore');

Route::get('/school/dashboard', [SchoolController::class, 'index'])->name('school.dashboard');
Route::get('/school/reports', [SchoolController::class, 'reports'])->name('school.reports');
Route::get('/school/classdashboard', [SchoolController::class, 'classindex'])->name('school.classdashboard');
});



require __DIR__.'/auth.php';
