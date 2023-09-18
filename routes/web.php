<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\WebHookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Producto;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
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
Route::get('/', function () {
    $productos = Producto::all();
    return view('index', compact('productos'));
});
Route::get('/producto/comentar', [ComentarioController::class, 'CrearComentario']);
Route::get('/procesar', function(){
    return view('procesar');
})->name('procesar');

Route::post('/payment', function(Request $request){
    $rules = [
        'direccion' => ['required', 'max:100', 'min:10'],
        'telefono' => ['required','numeric', 'min:8'],
    ];
    $customMessages = [
        'direccion.required' => 'Necesitamos que completes la direccion',
        'direccion.max' => 'Direccion demaciado larga',
        'direccion.min' => 'Direccion demaciado corto',
        'telefono.required' => 'Necesitamos que agreges un numero de contacto',
        'telefono.min' => 'Telefono demaciado corto',
        'telefono.numeric' => 'Solo numeros por favor',
    ];
    $request->validate($rules, $customMessages);
    $lista_productos = $request->input("productos");
    $id_productos = $request->input("id_productos");
    $direccion = $request->direccion;
    $telefono = $request->telefono;
    $total_precios = $request->total_precios;
    return view('confirmar', compact('direccion', 'telefono', 'lista_productos', 'id_productos', 'total_precios'));
})->name('payment');

Route::get('/terminar', function(){
    return view('limpiarStorage');
})->name('terminar');

Route::get('/pdf/view/{factura}', function($id){
    $ticket = Ticket::findOrFail($id);
    $pdf = Pdf::loadView('pdf.index', compact('ticket'));
    return $pdf->stream();
    //return $pdf->download('invoice.pdf');
    // para q no lo deje volver hdp
});
Route::get('/pdf/download/{factura}', function($id){
    $ticket = Ticket::findOrFail($id);
    $pdf = Pdf::loadView('pdf.index', compact('ticket'));
    return $pdf->download('factura.pdf');
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
