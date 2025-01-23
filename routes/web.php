<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventMemberController;
use App\Exports\EventsExport;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk halaman beranda (home)
Route::get('/', [HomeController::class, 'home'])->name('home');

// Route untuk halaman login admin (GET)
Route::get('/login', [AuthController::class, 'login'])->name('login');

// Route untuk autentikasi login admin (POST)
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');

// Route untuk logout admin (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Route untuk halaman dashboard admin (hanya bisa diakses jika sudah login)
Route::middleware(['auth'])->get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// Route CRUD untuk anggota
Route::resource('members', MemberController::class);

// CRUD Role
Route::resource('roles', RoleController::class);

// CRUD Permission
Route::resource('permissions', PermissionController::class);

// CRUD User
Route::resource('users', UserController::class);

// CRUD Kategori
Route::resource('kategoris', KategoriController::class);
Route::post('kategoris/{kategori}/reactivate', [KategoriController::class, 'reactivate'])->name('kategoris.reactivate');

Route::get('events/export', function () {
    return Excel::download(new EventsExport, 'events.xlsx');
})->name('events.export');

// CRUD Event
Route::resource('events', EventController::class);

Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::post('events/{event}/reactivate', [EventController::class, 'reactivate'])->name('events.reactivate');

// API untuk mendapatkan data dropdown dan data terfilter
Route::post('/getDropdownData', [KategoriController::class, 'getDropdownData'])->name('getDropdownData');
Route::post('/getFilteredData', [KategoriController::class, 'getFilteredData'])->name('getFilteredData');

// Rute untuk halaman user home
Route::middleware(['auth:member'])->get('/home', [HomeController::class, 'home'])->name('user.home');

// Route untuk halaman login user (GET)
Route::get('/user/auth/login', [AuthUserController::class, 'showLoginForm'])->name('user.auth.login_user');

// Route untuk autentikasi login user (POST)
Route::post('/user/auth/login', [AuthUserController::class, 'login']);

// Route untuk halaman registrasi user
Route::get('/user/auth/register', [AuthUserController::class, 'showRegisterForm'])->name('user.auth.register_user');
Route::post('/user/auth/register', [AuthUserController::class, 'register']);

// Route untuk logout user
Route::post('/user/auth/logout', [AuthUserController::class, 'logout'])->name('logout.user');

// Route untuk detail event
Route::get('/user/events/{event}', [EventController::class, 'ShowEventDetail'])->name('user.events_details');

// Rute untuk menghapus member
Route::delete('/events/{event_id}/members/{member_id}', [EventController::class, 'destroyMember'])->name('events.members.destroy');

//route untuk register event user
Route::post('/events/register/{id}', [EventController::class, 'register'])->name('events.register');

//route untuk menampilkan event saya
Route::get('/myevent', [EventController::class, 'myEvents'])->name('user.myevent');

Route::get('/events/{event_id}/members/create', [EventMemberController::class, 'create'])->name('events.members.create');
Route::post('/events/{event_id}/members', [EventMemberController::class, 'store'])->name('events.members.store');

Route::get('/members/{id}/editpassword', [MemberController::class, 'editPassword'])->name('members.editPassword');
Route::put('/members/{id}/update-password', [MemberController::class, 'updatePassword'])->name('members.update-password');

Route::get('events/{event_id}/export-pdf', [EventController::class, 'exportPdf'])->name('events.export_pdf');

Route::middleware('auth:member')->group(function () {
    Route::get('/editprofile', [AuthUserController::class, 'editProfile'])->name('user.editprofile');
    Route::put('/editprofile', [AuthUserController::class, 'updateProfile'])->name('user.profile.update');  // Menggunakan PUT untuk pembaruan
    Route::get('/editpassword', [AuthUserController::class, 'editPassword'])->name('user.editpassword');
    Route::post('/editpassword', [AuthUserController::class, 'updatePassword'])->name('user.update-password');
});
// Route untuk menampilkan halaman verifikasi OTP
Route::get('verify-otp/{member_id}', [AuthUserController::class, 'showVerifyOtpForm'])->name('user.auth.verify_otp.form');

// Route untuk menangani verifikasi OTP
Route::post('verify-otp/{member_id}', [AuthUserController::class, 'verifyOtp'])->name('user.auth.verify_otp');
