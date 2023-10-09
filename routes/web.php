<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WebHookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Producto;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});
Route::get('/google-auth/callback', function () {
    $user_obtenido = Socialite::driver('google')->stateless()->user();
    try {
        $user = User::updateOrCreate([
            'google_id' => $user_obtenido->id,
        ], [
            'name' => $user_obtenido->name,
            'email' => $user_obtenido->email
        ]);
    }catch (\Exception $error){
        throw ValidationException::withMessages([
            'email' => trans('Lo siento! No puedes registrarte ni logearte con este correo por que ya esta en uso'),
        ]);
    }
    Auth::login($user);
    return redirect('/');
});
Route::get('/facebook-auth/redirect', function () {
    return Socialite::driver('facebook')->redirect();
});
Route::get('/facebook-auth/callback', function () {
    $user_obtenido = Socialite::driver('facebook')->stateless()->user();
    $user = User::updateOrCreate([
        'facebook_id' => $user_obtenido->id,
    ], [
        'name' => $user_obtenido->name,
        'email' => $user_obtenido->email
    ]);
    Auth::login($user);
    return redirect('/');
});
Route::resource('productos', ProductoController::class);
Route::resource('categorias', CategoriaController::class);
Route::get('/', function (Request $request) {
    $msg = $request->msg;
    return view('index', compact('msg'));
});
Route::get('/producto/comentar', [ComentarioController::class, 'CrearComentario']);
Route::middleware('auth')->group(function () {
    Route::get('/procesar', [ShopController::class, 'Procesar'])->name('procesar');
    Route::post('/payment', [ShopController::class, 'Payment'])->name('payment');
    Route::get('/terminar', )->name('terminar');
    Route::get('/pdf/view/{factura}', [ShopController::class, 'ShowPdf']);
    Route::get('/pdf/download/{factura}', [ShopController::class, 'DownloadPdf']);
});

// webhook
Route::post('webhooks', WebHookController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ProfileController::class, 'UpdateAvatar'])->name('profile.updateavatar');
    Route::get('/factura/{id}', [ProfileController::class, 'ShowFactura']);
});

require __DIR__.'/auth.php';
