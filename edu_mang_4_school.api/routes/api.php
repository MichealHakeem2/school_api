<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
// Admin Routes
    Route::get('/admin', 'App\Http\Controllers\AdminController@index')->name('admin.index');
    Route::post('/admin/store', 'App\Http\Controllers\AdminController@store')->name('admin.store');
    Route::get('/admin/show/{id}', 'App\Http\Controllers\AdminController@show')->name('admin.show');
    Route::put('/admin/update/{id}', 'App\Http\Controllers\AdminController@update')->name('admin.update');
    Route::delete('/admin/destroy/{id}', 'App\Http\Controllers\AdminController@destroy')->name('admin.destroy');
    Route::post('/admin/register', 'App\Http\Controllers\AdminController@register')->name('admin.register');
    Route::post('/admin/login', 'App\Http\Controllers\AdminController@login')->name('admin.login');
    Route::post('/admin/logout', 'App\Http\Controllers\AdminController@logout')->name('admin.logout')->middleware(['admin:sanctum', 'verified']);
    // Routes for TeacherRegistrController
    Route::get('/teacher', 'App\Http\Controllers\TeacherRegistrController@index')->name('teacher.index');
    Route::post('/teacher/store', 'App\Http\Controllers\TeacherRegistrController@store')->name('teacher.store');
    Route::get('/teacher/show/{id}', 'App\Http\Controllers\TeacherRegistrController@show')->name('teacher.show');
    Route::put('/teacher/update/{id}', 'App\Http\Controllers\TeacherRegistrController@update')->name('teacher.update');
    Route::delete('/teacher/destroy/{id}', 'App\Http\Controllers\TeacherRegistrController@destroy')->name('teacher.destroy');
    Route::post('/teacher/register', 'App\Http\Controllers\TeacherRegistrController@register')->name('teacher.register');
    Route::post('/teacher/login', 'App\Http\Controllers\TeacherRegistrController@login')->name('teacher.login');
    Route::post('/teacher/logout', 'App\Http\Controllers\TeacherRegistrController@logout')->name('teacher.logout');
    // Routes for StudentRegistrController
    Route::get('/student', 'App\Http\Controllers\StudentRegistrController@index')->name('student.index');
    Route::post('/student/store', 'App\Http\Controllers\StudentRegistrController@store')->name('student.store');
    Route::get('/student/show/{id}', 'App\Http\Controllers\StudentRegistrController@show')->name('student.show');
    Route::put('/student/update/{id}', 'App\Http\Controllers\StudentRegistrController@update')->name('student.update');
    Route::delete('/student/destroy/{id}', 'App\Http\Controllers\StudentRegistrController@destroy')->name('student.destroy');
    Route::post('/student/register', 'App\Http\Controllers\StudentRegistrController@register')->name('student.register');
    Route::post('/student/login', 'App\Http\Controllers\StudentRegistrController@login')->name('student.login');
    Route::post('/student/logout', 'App\Http\Controllers\StudentRegistrController@logout')->name('student.logout');
    // Routes for StaffRegistrController
    Route::get('/staff', 'App\Http\Controllers\StaffRegistrController@index')->name('staff.index');
    Route::post('/staff/store', 'App\Http\Controllers\StaffRegistrController@store')->name('staff.store');
    Route::get('/staff/show/{id}', 'App\Http\Controllers\StaffRegistrController@show')->name('staff.show');
    Route::put('/staff/update/{id}', 'App\Http\Controllers\StaffRegistrController@update')->name('staff.update');
    Route::delete('/staff/destroy/{id}', 'App\Http\Controllers\StaffRegistrController@destroy')->name('staff.destroy');
    Route::post('/staff/register', 'App\Http\Controllers\StaffRegistrController@register')->name('staff.register');
    Route::post('/staff/login', 'App\Http\Controllers\StaffRegistrController@login')->name('staff.login');
    Route::post('/staff/logout', 'App\Http\Controllers\StaffRegistrController@logout')->name('staff.logout');
    // Routes for ParentRegistrController
    Route::get('/parent', 'App\Http\Controllers\ParentRegistrController@index')->name('parent.index');
    Route::post('/parent/store', 'App\Http\Controllers\ParentRegistrController@store')->name('parent.store');
    Route::get('/parent/show/{id}', 'App\Http\Controllers\ParentRegistrController@show')->name('parent.show');
    Route::put('/parent/update/{id}', 'App\Http\Controllers\ParentRegistrController@update')->name('parent.update');
    Route::delete('/parent/destroy/{id}', 'App\Http\Controllers\ParentRegistrController@destroy')->name('parent.destroy');
    Route::post('/parent/register', 'App\Http\Controllers\ParentRegistrController@register')->name('parent.register');
    Route::post('/parent/login', 'App\Http\Controllers\ParentRegistrController@login')->name('parent.login');
    Route::post('/parent/logout', 'App\Http\Controllers\ParentRegistrController@logout')->name('parent.logout');
// Grade Routes
    Route::get('/grades', 'App\Http\Controllers\GradeController@index')->name('grades.index');
    Route::post('/grades/store', 'App\Http\Controllers\GradeController@store')->name('grades.store');
    Route::get('/grades/show/{id}', 'App\Http\Controllers\GradeController@show')->name('grades.show');
    Route::put('/grades/update/{id}', 'App\Http\Controllers\GradeController@update')->name('grades.update');
    Route::delete('/grades/destroy/{id}{id}', 'App\Http\Controllers\GradeController@destroy')->name('grades.destroy');

// Exam Routes
    Route::get('/exams', 'App\Http\Controllers\ExamController@index')->name('exams.index');
    Route::post('/exams/store', 'App\Http\Controllers\ExamController@store')->name('exams.store');
    Route::get('/exams/show/{id}', 'App\Http\Controllers\ExamController@show')->name('exams.show');
    Route::put('/exams/update/{id}', 'App\Http\Controllers\ExamController@update')->name('exams.update');
    Route::delete('/exams/destroy/{id}{id}', 'App\Http\Controllers\ExamController@destroy')->name('exams.destroy');

// Course Routes
    Route::get('/courses', 'App\Http\Controllers\CourseController@index')->name('courses.index');
    Route::post('/courses/store', 'App\Http\Controllers\CourseController@store')->name('courses.store');
    Route::get('/courses/show/{id}', 'App\Http\Controllers\CourseController@show')->name('courses.show');
    Route::put('/courses/update/{id}', 'App\Http\Controllers\CourseController@update')->name('courses.update');
    Route::delete('/courses/destroy/{id}', 'App\Http\Controllers\CourseController@destroy')->name('courses.destroy');

// Classroom Routes
    Route::get('/classrooms', 'App\Http\Controllers\ClassroomController@index')->name('classrooms.index');
    Route::post('/classrooms/store', 'App\Http\Controllers\ClassroomController@store')->name('classrooms.store');
    Route::get('/classrooms/show/{id}', 'App\Http\Controllers\ClassroomController@show')->name('classrooms.show');
    Route::put('/classrooms/update/{id}', 'App\Http\Controllers\ClassroomController@update')->name('classrooms.update');
    Route::delete('/classrooms/destroy/{id}', 'App\Http\Controllers\ClassroomController@destroy')->name('classrooms.destroy');

// Attendance Routes
    Route::get('/attendances', 'App\Http\Controllers\AttendanceController@index')->name('attendances.index');
    Route::post('/attendances/store', 'App\Http\Controllers\AttendanceController@store')->name('attendances.store');
    Route::get('/attendances/show/{id}', 'App\Http\Controllers\AttendanceController@show')->name('attendances.show');
    Route::put('/attendances/update/{id}', 'App\Http\Controllers\AttendanceController@update')->name('attendances.update');
    Route::delete('/attendances/destroy/{id}', 'App\Http\Controllers\AttendanceController@destroy')->name('attendances.destroy');
