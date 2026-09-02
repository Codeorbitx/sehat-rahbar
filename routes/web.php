<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard-summary', [DashboardController::class, 'summary'])->name('dashboard.summary');
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients/{patient}/screenings/create', [ScreeningController::class, 'create'])->name('screenings.create');
    Route::post('/patients/{patient}/screenings', [ScreeningController::class, 'store'])->name('screenings.store');
    Route::get('/patients/{patient}/referrals/create', [ReferralController::class, 'create'])->name('referrals.create');
    Route::post('/patients/{patient}/referrals', [ReferralController::class, 'store'])->name('referrals.store');
    Route::get('/screenings/{screening}/result', [ScreeningController::class, 'result'])->name('screenings.result');
});

require __DIR__.'/auth.php';
