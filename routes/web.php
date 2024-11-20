<?php

use App\Http\Controllers\EventController;
use \App\Http\Controllers\OrderController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TortaController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get("reporte/{anio}/{mes?}", ReporteController::class)->name("reporte");
Route::prefix("administrador")->middleware(["rol:administrador"])->group(function () {
    Route::get("", function () {
        $orders = Order::all();
        return Inertia::render("Admin/Dashboard", compact("orders"));
    })->name('dashboard');
    Route::prefix("event")->group(function () {
        Route::get("", [EventController::class, 'index'])->name('events.index');
        Route::post("", [EventController::class, 'store'])->name('events.store');
        Route::post("{id}", [EventController::class, 'update'])->name('events.update');
        Route::delete("{id}", [EventController::class, 'destroy'])->name('events.destroy');
    });
    Route::prefix("torta")->group(function () {
        Route::get("", [TortaController::class, 'index'])->name('torta.index');
        Route::post("", [TortaController::class, 'store'])->name('torta.store');
        Route::post("{id}", [TortaController::class, 'update'])->name('torta.update');
        Route::delete("{id}", [TortaController::class, 'destroy'])->name('torta.destroy');
    });
    Route::prefix("order")->group(function () {
        Route::get("", [OrderController::class, 'index'])->name('orders.index');
        Route::post("", [OrderController::class, 'store'])->name('orders.store');
        Route::post("{id}", [OrderController::class, 'update'])->name('orders.update');
        Route::delete("{id}", [OrderController::class, 'destroy'])->name('orders.destroy');
    });
});

Route::middleware('rol:cliente')->group(function () {
    Route::prefix('pedido')->group(function () {
        Route::get('/{slug}', [OrderController::class, 'clientIndex'])->name('client.order.index');
        Route::get('', [OrderController::class, 'clientRedirect']);
        Route::post('', [OrderController::class, 'clientStore'])->name('client.order.store');
    });
    Route::get('rastreo', [OrderController::class, 'clientRastreoIndex'])->name('client.order.rastreo');
});

require __DIR__ . '/auth.php';
