<?php

use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Dashboard\UserNotifications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', App\Livewire\Home::class)->name('home');

Route::prefix('bands')->group(function () {
    Route::get('/', App\Livewire\Bands\Index::class)->name('bands.index');
    Route::get('/{id}', App\Livewire\Bands\Show::class)->name('bands.show');
});

Route::prefix('songs')->group(function () {
    Route::get('/', App\Livewire\Songs\Index::class)->name('songs.index');
    Route::get('/{slug}', App\Livewire\Songs\Show::class)->name('songs.show');
});
//
Route::prefix('tutorials')->group(function () {
    Route::get('/', App\Livewire\Tutorials\Index::class)->name('tutorials.index');
    Route::get('/{slug}', App\Livewire\Tutorials\Show::class)->name('tutorials.show');
});

    Route::middleware('auth')->group(function () {
        Route::prefix('setlists')->group(function () {
            Route::get('/', App\Livewire\SetLists\Index::class)->name('setlists.index');
            Route::get('/{setList:id}', App\Livewire\SetLists\Show::class)->name('setlists.show');
        });
    });

Route::get('/notifications', UserNotifications::class)
    ->middleware('auth')
    ->name('notifications');

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Route::get('settings/password', App\Livewire\Dashboard\PasswordUpdate::class)->name('settings.password');
    Route::get('favourites', App\Livewire\Dashboard\Favorites::class)->name('favourites');
});

Route::post('/telegram/webhook', function (Request $request) {
    $update = $request->all();
    if (isset($update['message']['chat']['id'])) {
        $user = User::where('telegram_id', '@' . $update['message']['from']['username'])->first();
        if ($user) {
            $user->update(['telegram_id' => $update['message']['chat']['id']]);
        }
    }
    return response('OK', 200);
});

require __DIR__.'/auth.php';
