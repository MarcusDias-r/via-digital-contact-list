<?php

use App\Http\Controllers\ContactController;
use App\Models\Contact;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get ('/',                [ContactController::class, 'index'])->name('home');
Route::get ('/get_contact/{id}',[ContactController::class, 'getContact'])->name('get.contact');
Route::get ('/contactList',     [ContactController::class, 'getContacts'])->name('get.contacts');
Route::post('/search',          [ContactController::class, 'searchContacts'])->name('search.contact');
Route::post('/change_photo',    [ContactController::class, 'changePhoto'])->name('change.photo');
Route::resource('contacts', ContactController::class)->names([
    'store'   => 'contact.store',
    'edit'    => 'contact.edit',
    'update'  => 'contact.update',
    'destroy' => 'contact.destroy'
]);

