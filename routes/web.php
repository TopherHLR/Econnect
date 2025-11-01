<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\EcoController;
use App\Http\Controllers\ActionController;

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

Route::get('/quests', function () {
    return view('quests');
})->name('quests');


Route::get('/adminHome', function () {
    return view('adminHome');
})->name('adminHome');

Route::get('/rewards', function () {
    return view('rewards');
})->name('rewards');

Route::get('/adminUsers', function () {
    return view('adminUsers');
})->name('adminUsers');

// ✅ Quests main dashboard
Route::get('/adminQuests', function () {
    return view('adminQuests'); // or the correct filename: adminquests.blade.php
})->name('adminQuests');

// ✅ Quests main dashboard
Route::get('/adminRewards', function () {
    return view('adminRewards'); // or the correct filename: adminquests.blade.php
})->name('adminRewards');

// ✅ Quest Collection page
Route::get('/adminAnalytics', function () {
    return view('adminAnalytics'); // or the correct filename: adminquestCollection.blade.php
})->name('adminAnalytics');

Route::get('/adminSystemAlerts', function () {
    return view('adminSystemAlerts'); // or the correct filename: adminquestCollection.blade.php
})->name('adminSystemAlerts');

Route::get('/adminSettings', function () {
    return view('adminSettings'); // or the correct filename: adminquestCollection.blade.php
})->name('adminSettings');

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

//---------------------------------------------------- ACCOUNT SETTINGS -------------------------------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
});

Route::get('/myprogress', [AccountController::class, 'myProgress'])->name('myprogress');

Route::get('/rewards', [AccountController::class, 'rewards'])->name('rewards');

//---------------------------------------------------- HOME -------------------------------------------------
Route::get('/widgets/random', [EcoController::class, 'getRandomWidgets'])
    ->name('widgets.random')
    ->middleware('auth');


//---------------------------------------------------- ACTION -------------------------------------------------
// User routes
Route::middleware('auth')->group(function () {
    Route::get('/actions', [ActionController::class, 'index'])->name('actions.index');
    Route::get('/actions/{id}', [ActionController::class, 'show'])->name('actions.show');
    Route::post('/actions/{id}/complete', [ActionController::class, 'completeAction'])->name('actions.complete');
    Route::get('/my-actions', [ActionController::class, 'myActions'])->name('actions.my');
});


// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/actions', [ActionController::class, 'adminIndex'])->name('admin.actions.index');
    Route::post('/admin/actions', [ActionController::class, 'store'])->name('admin.actions.store');
    Route::put('/admin/actions/{id}', [ActionController::class, 'update'])->name('admin.actions.update');
    Route::delete('/admin/actions/{id}', [ActionController::class, 'destroy'])->name('admin.actions.destroy');
});

//---------------------------------------------------- LIBRARY -------------------------------------------------
// User routes
Route::middleware('auth')->group(function () {
    Route::get('/libraries', [LibraryController::class, 'index']);
    Route::get('/libraries/{id}', [LibraryController::class, 'show']);
    Route::post('/libraries/{id}/save', [LibraryController::class, 'saveLibrary']);
    Route::delete('/libraries/{id}/unsave', [LibraryController::class, 'unsaveLibrary']);
    Route::get('/my-libraries', [LibraryController::class, 'myLibraries']);
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/libraries', [LibraryController::class, 'store']);
    Route::put('/admin/libraries/{id}', [LibraryController::class, 'update']);
    Route::delete('/admin/libraries/{id}', [LibraryController::class, 'destroy']);
});