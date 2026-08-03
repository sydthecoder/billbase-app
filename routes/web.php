<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard'); 
});

require base_path('app/Modules/Auth/Routes.php');
require base_path('app/Modules/Dashboard/Routes.php');
require base_path('app/Modules/Lookup/Routes.php');
require base_path('app/Modules/Customers/Routes.php');
require base_path('app/Modules/Products/Routes.php');
require base_path('app/Modules/Quotes/Routes.php');
require base_path('app/Modules/Invoices/Routes.php');
require base_path('app/Modules/Payments/Routes.php');
require base_path('app/Modules/Settings/Routes.php');