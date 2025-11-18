<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\EcoController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\QuestSubmissionController;
use App\Http\Controllers\AdminController;
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

//---------------------------------------------------- EWAN -------------------------------------------------

Route::get('/lifestyle', function () {
    return view('lifestyle');
})->name('lifestyle');


Route::get('/quests', [QuestController::class, 'userQuests'])->name('quests');
Route::get('/rewards', function () {
    return view('rewards');
})->name('rewards');

//---------------------------------------------------- ADMIN -------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // Wrap admin routes in a closure-based group
    Route::group([
        'middleware' => function ($request, $next) {
            if (Auth::check() && Auth::user()->user_type === 'admin') {
                return $next($request);
            }
            abort(403, 'Unauthorized access.');
        }
    ], function () {
        Route::get('/adminHome', fn() => view('admin.adminHome'))->name('adminHome');
        Route::get('/adminUsers', fn() => view('admin.adminUsers'))->name('adminUsers');
        Route::get('/adminQuests', fn() => view('admin.adminQuests'))->name('adminQuests');
        Route::get('/adminRewards', fn() => view('admin.adminRewards'))->name('adminRewards');
        Route::get('/adminAnalytics', fn() => view('admin.adminAnalytics'))->name('adminAnalytics');
        Route::get('/adminSystemAlerts', fn() => view('admin.adminSystemAlerts'))->name('adminSystemAlerts');
        Route::get('/adminSettings', fn() => view('admin.adminSettings'))->name('adminSettings');
        Route::get('/adminLifestyle', fn() => view('admin.adminLifestyle'))->name('adminLifestyle');
    });
});
//---------------------------------------------------- MOCK API FOR ECO MODAL -------------------------------------------------



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

Route::post('/ecoactions/store', [ActionController::class, 'store'])->name('ecoactions.store');


// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/actions', [ActionController::class, 'adminIndex'])->name('admin.actions.index');
    Route::post('/admin/actions', [ActionController::class, 'store'])->name('admin.actions.store');
    Route::put('/admin/actions/{id}', [ActionController::class, 'update'])->name('admin.actions.update');
    Route::delete('/admin/actions/{id}', [ActionController::class, 'destroy'])->name('admin.actions.destroy');
});

//---------------------------------------------------- LIBRARY -------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/libraries', [LibraryController::class, 'index'])->name('libraries.index');
    Route::get('/libraries/{id}', [LibraryController::class, 'show'])->name('libraries.show');
    Route::post('/libraries/{id}/save', [LibraryController::class, 'saveLibrary'])->name('libraries.save');
    Route::delete('/libraries/{id}/unsave', [LibraryController::class, 'unsaveLibrary'])->name('libraries.unsave');
    Route::post('/libraries/{id}/mark-done', [LibraryController::class, 'markDone'])->name('libraries.mark-done');
    Route::get('/my-libraries', [LibraryController::class, 'myLibraries'])->name('libraries.my');
});

// New route for fetching a single EcoAction
Route::get('/actions/{id}', [LibraryController::class, 'showAction']);

Route::get('/lifestyle', [LibraryController::class, 'lifestyle'])->name('lifestyle');


Route::post('/libraries/store', [LibraryController::class, 'store'])->name('libraries.store');


// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::post('/admin/libraries', [LibraryController::class, 'store']);
    Route::put('/admin/libraries/{id}', [LibraryController::class, 'update']);
    Route::delete('/admin/libraries/{id}', [LibraryController::class, 'destroy']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/adminLifestyle', [LibraryController::class, 'adminIndex'])->name('admin.eco-library');
});

// Admin routes
Route::middleware(['auth'])->group(function () {

    Route::group([
        'middleware' => function ($request, $next) {
            if (Auth::check() && Auth::user()->user_type === 'admin') {
                return $next($request);
            }
            abort(403, 'Unauthorized access.');
        }
    ], function () {
        Route::get('/adminHome',  [AdminController::class, 'home'])->name('adminHome');
        Route::get('/adminUsers', fn() => view('admin.adminUsers'))->name('adminUsers');
        Route::get('/adminQuests', [QuestController::class, 'index'])->name('adminQuests');

        // ✅ Add this POST route for storing quests
        Route::post('/admin/quests', [QuestController::class, 'store'])->name('quests.store');
    });
});

//---------------------------------------------------- QUEST ADMIN -------------------------------------------------
Route::post('/quests/{quest}/status', [QuestController::class, 'updateStatus'])->name('quests.updateStatus');
Route::post('/quests/{quest}/recover', [QuestController::class, 'recover'])->name('quests.recover');
Route::post('/quests/{quest}/recover2', [QuestController::class, 'recover2'])->name('quests.recover2');
Route::post('/quests/{quest}/archive', [QuestController::class, 'archive'])->name('quests.archive');
Route::post('/quests/process', [QuestController::class, 'process'])->name('submissions.process');

//---------------------------------------------------- QUEST USER -------------------------------------------------
Route::post('/quests/accept', [QuestSubmissionController::class, 'store'])->name('quests.accept');
Route::post('/quests/submit', [QuestSubmissionController::class, 'submit'])->name('quests.submit');



Route::get('/adminUsers', [AdminController::class, 'users'])->name('adminUsers');
