<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');



Route::resource("users", UserController::class);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::view('manage-users', 'manage-users')
    ->middleware(['auth', 'verified'])
    ->name('manage-users')->middleware("permission:administrator");
Route::view('assigned', 'assigned')
    ->middleware(['auth', 'verified'])
    ->name('assigned');
Route::view('manage-course', 'manage-course')
    ->middleware(['auth', 'verified'])
    ->name('manage-course');
Route::view('manage-role', 'manage-role')
    ->middleware(['auth', 'verified'])
    ->name('manage-role')->middleware("permission:administrator");
Route::view('learning-materials', 'learning-materials')
    ->middleware(['auth', 'verified'])
    ->name('learning-materials');
Route::view('quizzes', 'quizzes')
    ->middleware(['auth', 'verified'])
    ->name('quizzes');
Route::view('examination', 'examination')
    ->middleware(['auth', 'verified'])
    ->name('examination');
Route::view('virtual-meetings', 'virtual-meetings')
    ->middleware(['auth', 'verified'])
    ->name('virtual-meetings')->middleware("permission:administratornull");
Route::view('enroll', 'enroll')
    ->middleware(['auth', 'verified'])
    ->name('enroll');
Route::view('assignment-upload', 'assignment-upload')
    ->middleware(['auth', 'verified'])
    ->name('assignment-upload');
Route::view('activity-upload', 'activity-upload')
    ->middleware(['auth', 'verified'])
    ->name('activity-upload');
Route::view('performance-task-upload', 'performance-task-upload')
    ->middleware(['auth', 'verified'])
    ->name('performance-task-upload');
Route::view('take-quiz', 'take-quiz')
    ->middleware(['auth', 'verified'])
    ->name('take-quiz');
Route::view('take-exam', 'take-exam')
    ->middleware(['auth', 'verified'])
    ->name('take-exam');
Route::view('current-enroll', 'current-enroll')
    ->middleware(['auth', 'verified'])
    ->name('current-enroll');
Route::view('about-us', 'about-us')
    ->name('about-us');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';


