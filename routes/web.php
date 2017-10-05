<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::post('/', function () {
    $ids = DB::table('quizzes')
            //->where('category_id', '=', config('const.numCategoryIdBeginner'))
            ->inRandomOrder()
            ->limit(10)
            ->pluck('id');

    return view('quiz.index')->with('ids', json_encode($ids))
                             ->with('quizNum', count($ids));
});

Route::get('/getonequiz/{id}', function ($id) {
    return json_encode(DB::table('quizzes')
        ->join('answers', 'quizzes.answers_id', '=', 'answers.id')
        ->select('quizzes.*', 'answers.*')
        ->where('quizzes.id', '=', $id)
        //->where('quizzes.category_id', '=', config('const.numCategoryIdBeginner'))
        ->first());
});