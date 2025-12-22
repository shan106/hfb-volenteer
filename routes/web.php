<?php



use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\FaqController;

// Admin-specifieke controllers
use App\Http\Controllers\AdminFaqController;
use App\Http\Controllers\Admin\NewsItemController as AdminNewsItemController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;





Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('news', AdminNewsItemController::class)->except(['show']);

        Route::get('faq', [AdminFaqController::class, 'index'])->name('faq.index');
        Route::get('faq/create', [AdminFaqController::class, 'create'])->name('faq.create');
        Route::post('faq', [AdminFaqController::class, 'store'])->name('faq.store');
        Route::get('faq/{faq}/edit', [AdminFaqController::class, 'edit'])->name('faq.edit');
        Route::put('faq/{faq}', [AdminFaqController::class, 'update'])->name('faq.update');
        Route::delete('faq/{faq}', [AdminFaqController::class, 'destroy'])->name('faq.destroy');

        
        Route::post('faq-categories', [AdminFaqController::class, 'storeCategory'])->name('faq.categories.store');
        Route::put('faq-categories/{category}', [AdminFaqController::class, 'updateCategory'])->name('faq.categories.update');
        Route::delete('faq-categories/{category}', [AdminFaqController::class, 'destroyCategory'])->name('faq.categories.destroy');
    });


Route::get('/users', [UserProfileController::class, 'index'])
    ->name('users.index');


Route::get('/users/{user}', [UserProfileController::class, 'show'])
    ->name('users.show');   



Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');


Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline.index');


Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');



Route::middleware('auth')->group(function () {
    Route::post('/timeline', [TimelineController::class, 'store'])->name('timeline.store');
    Route::delete('/timeline/{post}', [TimelineController::class, 'destroy'])->name('timeline.destroy');
});




require __DIR__.'/auth.php';
