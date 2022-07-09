<?php

use App\Livewire;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/livewire', function () {

    $livewire = new Livewire;

    $component = $livewire->fromSnapshot(request('snapshot'));
    if ($method = request('callMethod')) {
        $livewire->callMethod($component, $method);
    }

    [$html, $snapshot] = $livewire->toSnapshot($component);
    return ['html' => $html, 'snapshot' => $snapshot];
    //return html and snapshot;
});
Route::get('/', function () {
    return view('welcome');
});
