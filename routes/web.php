<?php

use App\Exceptions\ValidationException;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\ContohMiddleware;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

Route::get('/pzn',function(){
    return "Hello Ivriel";
});

Route::redirect('/youtube','/pzn');

Route::get('/conflict/{name}',function($name){
    return "Conflict $name";
});

Route::get('/conflict/Ivriel',function(){
    return "Conflict Ivriel Gunawan";
});

Route::get('/controller/hello/{name}', [\App\Http\Controllers\HelloController::class, 'hello']);
Route::get('/controller/hello/request', [\App\Http\Controllers\HelloController::class, 'request']);

Route::fallback(function(){
    return "404 by Ivriel";
});

Route::view('/hello','hello',['name'=>'Ivriel']);

Route::get('/hello-again',function(){
    return view('hello',['name'=>'Ivriel Gunawan']);
});

Route::get('/hello-world',function(){
    return view('hello.world',['name'=>'Ivriel Gunawann']);
});

Route::get('/products/{id}',function($productId){ // route params 
    return "Product $productId";
});

Route::get('/products/{id}/items/{item}',function($productId,$itemId){ // route params > 1 parameter
    return "Product $productId, Item $itemId";
}); 

Route::get('/categories/{id}',function($categoryId){
    return "Category $categoryId";
}) -> where('id','[0-9]+'); // dimana id harus number dan dari angka 0-9 serta boleh lebih dari 1(regex)

Route::get('/users/{id?}',function($userId = '404'){ // kalau optional parameter maka harus kasih default value di  function closure
    return "User $userId";
});

Route::get('/input/hello',[\App\Http\Controllers\InputController::class,'hello']);
Route::post('/input/hello',[\App\Http\Controllers\InputController::class,'hello']);
Route::post('/input/hello/first',[\App\Http\Controllers\InputController::class,'helloFirstName']);
Route::post('/input/hello/input',[\App\Http\Controllers\InputController::class,'helloInput']);
Route::post('/input/hello/array',[\App\Http\Controllers\InputController::class,'helloArray']);  
Route::post('/input/type',[\App\Http\Controllers\InputController::class,'inputType']);

Route::post('/input/filter/only',[\App\Http\Controllers\InputController::class,'filterOnly']);
Route::post('/input/filter/except',[\App\Http\Controllers\InputController::class,'filterExcept']);
Route::post('/input/filter/merge',[\App\Http\Controllers\InputController::class,'filterMerge']);

Route::post('/file/upload',[FileController::class,'upload'])->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/response/hello',[ResponseController::class,'response']);
Route::get('/response/header',[ResponseController::class,'header']);

Route::prefix("/response/type")->group(function(){
    Route::get('/view',[ResponseController::class,'responseView']);
    Route::get('/file',[ResponseController::class,'responseFile']);
    Route::get('/json',[ResponseController::class,'responseJson']);
    Route::get('/download',[ResponseController::class,'responseDownload']);
});

Route::controller(CookieController::class)->group(function(){ 
    Route::get('/cookie/set','createCookie');
    Route::get("/cookie/get",'getCookie');
    Route::get("/cookie/clear",'clearCookie');
});

Route::get("/redirect/from",[RedirectController::class,"redirectFrom"]);
Route::get("/redirect/to",[RedirectController::class,"redirectTo"]);
Route::get("/redirect/name",[RedirectController::class,"redirectName"]);
Route::get("/redirect/name/{name}",[RedirectController::class,"redirectHello"])->name("redirect-hello");
Route::get("/redirect/named",function(){
    // return route('redirect-hello',['name'=>'Ivriel']);
    // return url()->route('redirect-hello',['name'=>'Ivriel']);
    return URL::route('redirect-hello',['name'=>'Ivriel']);
});
Route::get("/redirect/action",[RedirectController::class,"redirectAction"]);
Route::get("/redirect/away",[RedirectController::class,"redirectAway"]);

Route::middleware(['contoh:IVR,401'])->prefix('/middleware')->group(function(){
    Route::get("/api",function(){
    return "OK";
});
    Route::get("/group",function(){
        return "GROUP";
    });
});

Route::get('/url/action',function(){
    // return action([FormController::class,'form'],[]);
    // return url()->action([FormController::class,'form'],[]);
    return URL::action([FormController::class,'form'],[]);
});

Route::get('/form',[FormController::class,'form']);
Route::post("/form",[FormController::class,"submitForm"]);

Route::get('/url/current',function(){
     return URL::full();
});

Route::get("/session/create",[SessionController::class,'createSession']);
Route::get("/session/get",[SessionController::class,'getSession']);

Route::get('/error/sample',function(){
    throw new Exception('Sample Error');
});

Route::get("/error/manual",function(){
    report(new Exception("Sample Error"));
    return "OK"; 
});
Route::get("/error/validation",function(){
    throw new ValidationException("Validation Error");
});

Route::get("/abort/400",function(){
    abort(400,"Ups Validation Error");
});

Route::get("/abort/401",function(){
    abort(401);
});

Route::get("/abort/500",function(){
    abort(500);
});