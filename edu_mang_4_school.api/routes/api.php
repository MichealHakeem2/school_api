<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use App\Http\Controllers\API\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Authentication Routes for all roles
Route::post('/{role}/register', 'App\Http\Controllers\Auth\RegisterController@register');
Route::post('/{role}/login', 'App\Http\Controllers\Auth\LoginController@login')->name('auth.login');
Route::post('/{role}/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('auth.logout')->middleware(['auth:sanctum', 'verified']);
Route::post('/{role}/email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('auth.email.resend')->middleware('throttle:6,1');

// Admin Routes
Route::prefix('admin')->middleware(['auth:sanctum', 'verified', 'authRole:admin'])->group(function () {
    Route::get('/admin', 'App\Http\Controllers\AdminController@index')->name('admin.index');
    Route::post('/admin', 'App\Http\Controllers\AdminController@store')->name('admin.store');
    Route::get('/admin{id}', 'App\Http\Controllers\AdminController@show')->name('admin.show');
    Route::put('/admin{id}', 'App\Http\Controllers\AdminController@update')->name('admin.update');
    Route::delete('/admin{id}', 'App\Http\Controllers\AdminController@destroy')->name('admin.destroy');
});

// Teacher Routes
Route::prefix('teacher')->middleware(['auth:sanctum', 'verified', 'authRole:teacher'])->group(function () {
    Route::get('/teacher', 'App\Http\Controllers\TeacherController@index')->name('teacher.index');
    Route::post('/teacher', 'App\Http\Controllers\TeacherController@store')->name('teacher.store');
    Route::get('/teacher{id}', 'App\Http\Controllers\TeacherController@show')->name('teacher.show');
    Route::put('/teacher{id}', 'App\Http\Controllers\TeacherController@update')->name('teacher.update');
    Route::delete('/teacher{id}', 'App\Http\Controllers\TeacherController@destroy')->name('teacher.destroy');
});

// Student Routes
Route::prefix('student')->middleware(['auth:sanctum', 'verified', 'authRole:student'])->group(function () {
    Route::get('/student', 'App\Http\Controllers\StudentController@index')->name('student.index');
    Route::post('/student', 'App\Http\Controllers\StudentController@store')->name('student.store');
    Route::get('/student{id}', 'App\Http\Controllers\StudentController@show')->name('student.show');
    Route::put('/student{id}', 'App\Http\Controllers\StudentController@update')->name('student.update');
    Route::delete('/student{id}', 'App\Http\Controllers\StudentController@destroy')->name('student.destroy');
});

// Staff Routes
Route::prefix('staff')->middleware(['auth:sanctum', 'verified', 'authRole:staff'])->group(function () {
    Route::get('/staff', 'App\Http\Controllers\StaffController@index')->name('staff.index');
    Route::post('/staff', 'App\Http\Controllers\StaffController@store')->name('staff.store');
    Route::get('/staff{id}', 'App\Http\Controllers\StaffController@show')->name('staff.show');
    Route::put('/staff{id}', 'App\Http\Controllers\StaffController@update')->name('staff.update');
    Route::delete('/staff{id}', 'App\Http\Controllers\StaffController@destroy')->name('staff.destroy');
});

// Parent Routes
Route::prefix('parent')->middleware(['auth:sanctum', 'verified', 'authRole:parent'])->group(function () {
    Route::get('/parent', 'App\Http\Controllers\ParentController@index')->name('parent.index');
    Route::post('/parent', 'App\Http\Controllers\ParentController@store')->name('parent.store');
    Route::get('/parent{id}', 'App\Http\Controllers\ParentController@show')->name('parent.show');
    Route::put('/parent{id}', 'App\Http\Controllers\ParentController@update')->name('parent.update');
    Route::delete('/parent{id}', 'App\Http\Controllers\ParentController@destroy')->name('parent.destroy');
});

// Grade Routes
Route::middleware(['auth:sanctum', 'verified', 'authRole:admin,staff'])->group(function () {
    Route::get('/grades', 'App\Http\Controllers\GradeController@index')->name('grades.index');
    Route::post('/grades', 'App\Http\Controllers\GradeController@store')->name('grades.store');
    Route::get('/grades/{id}', 'App\Http\Controllers\GradeController@show')->name('grades.show');
    Route::put('/grades/{id}', 'App\Http\Controllers\GradeController@update')->name('grades.update');
    Route::delete('/grades/{id}', 'App\Http\Controllers\GradeController@destroy')->name('grades.destroy');
});

// Exam Routes
Route::middleware(['auth:sanctum', 'verified', 'authRole:admin,staff'])->group(function () {
    Route::get('/exams', 'App\Http\Controllers\ExamController@index')->name('exams.index');
    Route::post('/exams', 'App\Http\Controllers\ExamController@store')->name('exams.store');
    Route::get('/exams/{id}', 'App\Http\Controllers\ExamController@show')->name('exams.show');
    Route::put('/exams/{id}', 'App\Http\Controllers\ExamController@update')->name('exams.update');
    Route::delete('/exams/{id}', 'App\Http\Controllers\ExamController@destroy')->name('exams.destroy');
});

// Course Routes
Route::middleware(['auth:sanctum', 'verified', 'authRole:admin,teacher'])->group(function () {
    Route::get('/courses', 'App\Http\Controllers\CourseController@index')->name('courses.index');
    Route::post('/courses', 'App\Http\Controllers\CourseController@store')->name('courses.store');
    Route::get('/courses/{id}', 'App\Http\Controllers\CourseController@show')->name('courses.show');
    Route::put('/courses/{id}', 'App\Http\Controllers\CourseController@update')->name('courses.update');
    Route::delete('/courses/{id}', 'App\Http\Controllers\CourseController@destroy')->name('courses.destroy');
});

// Classroom Routes
Route::middleware(['auth:sanctum', 'verified', 'authRole:admin,teacher'])->group(function () {
    Route::get('/classrooms', 'App\Http\Controllers\ClassroomController@index')->name('classrooms.index');
    Route::post('/classrooms', 'App\Http\Controllers\ClassroomController@store')->name('classrooms.store');
    Route::get('/classrooms/{id}', 'App\Http\Controllers\ClassroomController@show')->name('classrooms.show');
    Route::put('/classrooms/{id}', 'App\Http\Controllers\ClassroomController@update')->name('classrooms.update');
    Route::delete('/classrooms/{id}', 'App\Http\Controllers\ClassroomController@destroy')->name('classrooms.destroy');
});

// Attendance Routes
Route::middleware(['auth:sanctum', 'verified', 'authRole:admin,teacher'])->group(function () {
    Route::get('/attendances', 'App\Http\Controllers\AttendanceController@index')->name('attendances.index');
    Route::post('/attendances', 'App\Http\Controllers\AttendanceController@store')->name('attendances.store');
    Route::get('/attendances/{id}', 'App\Http\Controllers\AttendanceController@show')->name('attendances.show');
    Route::put('/attendances/{id}', 'App\Http\Controllers\AttendanceController@update')->name('attendances.update');
    Route::delete('/attendances/{id}', 'App\Http\Controllers\AttendanceController@destroy')->name('attendances.destroy');
});
