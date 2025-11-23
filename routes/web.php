<?php

use App\Http\Controllers\RewardController;
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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\UserRewardsController;
use App\Http\Controllers\TreeController;

//---------------------------------------------------- AUTH -------------------------------------------------


//---------------------------------------------------- AUTHENTICATION (LOGIN / REGISTER / VERIFY) -------------------------------------------------

// Email verification
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
Route::get('/', [EcoController::class, 'index'])->name('home');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

//---------------------------------------------------- PUBLIC PAGES -------------------------------------------------

Route::get('/lifestyle', function () {
    return view('lifestyle');
})->name('lifestyle');


Route::get('/quests', [QuestController::class, 'userQuests'])->name('quests');
Route::get('/rewards', function () {
    return view('rewards');
})->name('rewards');

//---------------------------------------------------- ADMIN PAGES (VIEW-ONLY NAVIGATION) -------------------------------------------------

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
        // Admin dashboard + panel pages
        Route::get('/adminHome', fn() => view('admin.adminHome'))->name('adminHome');
        Route::get('/adminUsers', fn() => view('admin.adminUsers'))->name('adminUsers');
        Route::get('/adminQuests', fn() => view('admin.adminQuests'))->name('adminQuests');
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

//---------------------------------------------------- HOME WIDGETS (ECO RANDOM WIDGETS) -------------------------------------------------

Route::get('/widgets/random', [EcoController::class, 'getRandomWidgets'])
    ->name('widgets.random')
    ->middleware('auth');


//---------------------------------------------------- ACTION SYSTEM (USER + ADMIN ACTIONS) -------------------------------------------------

// User action routes
Route::middleware('auth')->group(function () {
    Route::get('/actions', [ActionController::class, 'index'])->name('actions.index');
    Route::get('/actions/{id}', [ActionController::class, 'show'])->name('actions.show');
    Route::post('/actions/{id}/complete', [ActionController::class, 'completeAction'])->name('actions.complete');
    Route::get('/my-actions', [ActionController::class, 'myActions'])->name('actions.my');
});

// Store eco actions
Route::post('/ecoactions/store', [ActionController::class, 'store'])->name('ecoactions.store');


// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/actions', [ActionController::class, 'adminIndex'])->name('admin.actions.index');
    Route::post('/admin/actions', [ActionController::class, 'store'])->name('admin.actions.store');
    Route::put('/admin/actions/{id}', [ActionController::class, 'update'])->name('admin.actions.update');
    Route::delete('/admin/actions/{id}', [ActionController::class, 'destroy'])->name('admin.actions.destroy');
});

//---------------------------------------------------- LIBRARY (USER SIDE) -------------------------------------------------

// User library routes
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

// Lifestyle library view
Route::get('/lifestyle', [LibraryController::class, 'lifestyle'])->name('lifestyle');

// Store new library item
Route::post('/libraries/store', [LibraryController::class, 'store'])->name('libraries.store');

//---------------------------------------------------- LIBRARY (ADMIN SIDE) -------------------------------------------------

// Admin library routes
Route::middleware(['auth'])->group(function () {
    Route::post('/admin/libraries', [LibraryController::class, 'store']);
    Route::put('/admin/libraries/{id}', [LibraryController::class, 'update']);
    Route::delete('/admin/libraries/{id}', [LibraryController::class, 'destroy']);
});

// Admin eco library page
Route::middleware(['auth'])->group(function () {
    Route::get('/adminLifestyle', [LibraryController::class, 'adminIndex'])->name('admin.eco-library');
});

//---------------------------------------------------- ADMIN CONTROLLERS (ADMIN HOME + QUEST MANAGEMENT) -------------------------------------------------

// Admin routes
Route::middleware(['auth'])->group(function () {

    // Admin-only filter
    Route::group([
        'middleware' => function ($request, $next) {
            if (Auth::check() && Auth::user()->user_type === 'admin') {
                return $next($request);
            }
            abort(403, 'Unauthorized access.');
        }
    ], function () {

         // Admin homepage controller
        Route::get('/adminHome',  [AdminController::class, 'home'])->name('adminHome');

         // Admin user list
        Route::get('/adminUsers', fn() => view('admin.adminUsers'))->name('adminUsers');

         // Admin quest listing
        Route::get('/adminQuests', [QuestController::class, 'index'])->name('adminQuests');

        // ✅ Add this POST route for storing quests
        Route::post('/admin/quests', [QuestController::class, 'store'])->name('quests.store');
    });
});
Route::post('/user/{user}/set-inactive', [AdminController::class, 'setInactive']);

//---------------------------------------------------- QUEST ADMIN (APPROVE / RECOVER / ARCHIVE / PROCESS) -------------------------------------------------
// Quest management: updating status, recovering, archiving, and processing submissions

Route::post('/quests/{quest}/status', [QuestController::class, 'updateStatus'])->name('quests.updateStatus');
Route::post('/quests/{quest}/recover', [QuestController::class, 'recover'])->name('quests.recover');
Route::post('/quests/{quest}/recover2', [QuestController::class, 'recover2'])->name('quests.recover2');
Route::post('/quests/{quest}/archive', [QuestController::class, 'archive'])->name('quests.archive');
Route::post('/quests/process', [QuestController::class, 'process'])->name('submissions.process');
Route::put('/quests/{quest}', [QuestController::class, 'update'])->name('quests.update');


//---------------------------------------------------- QUEST USER (ACCEPT / SUBMIT QUEST)-------------------------------------------------
// User interactions with quests: accepting and submitting quest entries

Route::post('/quests/accept', [QuestSubmissionController::class, 'store'])->name('quests.accept');
Route::post('/quests/submit', [QuestSubmissionController::class, 'submit'])->name('quests.submit');


//---------------------------------------------------- ADMIN USERS (EXTRA ROUTE) -------------------------------------------------
// Admin page for viewing users list

Route::get('/adminUsers', [AdminController::class, 'index'])->name('adminUsers');

//---------------------------------------------------- VOUCHER -------------------------------------------------
Route::post('/vouchers/store', [App\Http\Controllers\VoucherController::class, 'store'])
     ->name('vouchers.store');


Route::get('/adminRewards', [VoucherController::class, 'index'])->name('adminRewards');

Route::put('/rewards/update/{id}', [VoucherController::class, 'update'])->name('rewards.update');
Route::put('/rewards/recover/{id}', [VoucherController::class, 'recover'])->name('rewards.recover');


Route::delete('/rewards/delete/{id}', [VoucherController::class, 'destroy'])->name('rewards.delete');

Route::put('/user-voucher/status/{id}', [VoucherController::class, 'updateUserVoucherStatus'])
    ->name('userVoucher.updateStatus');

Route::middleware(['auth'])->group(function () {
    Route::get('/rewards', [UserRewardsController::class, 'index'])->name('rewards.index');
    Route::post('/rewards/redeem/{voucherId}', [UserRewardsController::class, 'redeemVoucher'])->name('rewards.redeem');
});

Route::post('/admin/voucher/redeem/{qr_code}', [VoucherController::class, 'redeemByQrCode'])
    ->name('admin.voucher.redeem');

//---------------------------------------------------- NOTIFICATION -------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/mark-read/{id}', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications', [NotificationController::class, 'create']); // optional if creating via API
});

Route::get('/about', function () {
    return view('about');
})->name('about');

//---------------------------------------------------- LEADERBOARD -------------------------------------------------
Route::get('/leaderboard', [App\Http\Controllers\LeaderboardController::class, 'index'])
    ->name('leaderboard');

Route::post('/tree/tap', [TreeController::class, 'tapTree']);

Route::post('/submissions/{submission}/update-status', [QuestController::class, 'updateStatusQuestAdmin']);

