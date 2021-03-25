<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\SubCategory;

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

Route::get('/', function () {
    $startDate = request('start');
    $endDate = request('end');
  

    $expense = Category:: where('type', 'expense')->get();
    $income = Category:: where('type', 'income')->get();
    $query = SubCategory::whereNotNull('name');

    if (!is_null($endDate) && !is_null($startDate)) {
        $startDate = date($startDate);
        $endDate = date($endDate);

        $query
        ->whereBetween('created_at', [$startDate, $endDate]);
    } 

    $item = $query->get();
    
    return view('welcome', ['expense' => $expense, 'income' => $income, 'item' => $item]);
});
