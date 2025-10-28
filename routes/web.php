<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//---------------------------------------------------- AUTH -------------------------------------------------

Route::get('/verify-email', [AuthController::class, 'showVerificationForm'])->name('verify.email.form');
Route::post('/verify-email', [AuthController::class, 'verifyAndCreate'])->name('verify.email.submit');

// Sign up routes
Route::get('/signup', [AuthController::class, 'showRegisterForm'])->name('signup');
Route::post('/register', [AuthController::class, 'sendVerificationCode'])->name('register');

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Example home route (redirect destination)
Route::get('/', function () {
    return view('home'); // create home.blade.php later
})->name('home');

//---------------------------------------------------- AUTH -------------------------------------------------

Route::get('/lifestyle', function () {
    return view('lifestyle');
})->name('lifestyle');


//---------------------------------------------------- MOCK API FOR ECO MODAL -------------------------------------------------

Route::get('/api/ecoTopic/{id}', function ($id) {
    return response()->json([
        'id' => $id,
        'title' => 'Understanding Carbon Emissions',
        'description' => 'Carbon emissions trap heat and contribute to global warming.',
        'related_facts' => 'CO₂ emissions from cars and factories are major contributors.',
        'references' => 'NASA Climate Facts, IPCC Reports'
    ]);
});

Route::get('/api/ecoAction/{id}', function ($id) {
    return response()->json([
        'id' => $id,
        'title' => "Eco Action #$id",
        'image' => "eco-action$id.jpg",
        'step1' => "Step 1 for action #$id: Start small habits.",
        'step2' => "Step 2: Practice daily mindfulness about resources.",
        'step3' => "Step 3: Encourage friends to do the same.",
        'progress' => "50%",
    ]);
});

