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

Route::post('/category', function () {
    $name = request('name');
    $type = request('type');

    $category = new Category();
    $category->name = $name;
    $category->type = $type;

    $category->save();

    return redirect('/add');
});

Route::get('/add', function() {
    $category = Category::all();

    return view('add', ['category' => $category]);
});

Route::post('/add', function() {
    $name = request('name');
    $amount = request('amount');
    $category = request('category');

    $newItem = new SubCategory();
    $newItem->name = $name;
    $newItem->amount = $amount;
    $newItem->category_id = $category;
    $newItem->save();

    return redirect('/');
});
