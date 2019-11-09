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
    return view('auth.login');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    /*
     * Gerando rotas resource dos modelos criados
     */
    foreach (array_filter(array_diff(scandir(app_path()), ['..', '.']), function ($value) {
        return str_contains($value, '.php');
    }) as $model) {
        $model = substr($model, 0, -4); // removing '.php' from filename
        $controller = "{$model}Controller"; // following larapattern as Model => ModelController
        if (file_exists(app_path("Http/Controllers/$controller.php"))) { // Checking if the Controller does exist
            $resourceMethods = array_diff( // getting only the resource methods implemented into Controller
                get_class_methods("\\App\\Http\\Controllers\\$controller"),
                get_class_methods('\\App\\Http\\Controllers\\Controller')
            );
            Route::resource(snake_case($model), $controller, ['only' => $resourceMethods]);
        }
    }
});
