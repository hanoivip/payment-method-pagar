<?php

use Illuminate\Support\Facades\Route;

Route::any('/pagar/callback', 'Hanoivip\PaymentMethodPagar\PagarController@callback')->name('pagar.callback');