<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
    'auth:web'
])->namespace('Hanoivip\PaymentMethodPagar')
->group(function () {
    Route::get('/pagar/channels', 'PagarController@listChannel')->name('pagar.channels');
	Route::post('/pagar/channels', 'PagarController@selectChannel')->name('pagar.channels.select');
});

Route::middleware([
    'web',
    'admin'
])->namespace('Hanoivip\PaymentMethodPagar')
->prefix('ecmin')
->group(function () {
    // Module index
    Route::get('/pagar', 'Admin@index')->name('ecmin.tsr');
    
});