<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserControllerV1;
use App\Http\Controllers\Api\UserControllerV2;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostControllerV2;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Simple Concept

//Token Based Authentication with Laravel Sanctum 
Route::post('/login', [UserController::class, 'login']);
Route::middleware(['auth:sanctum'])->post('/logout', [UserController::class, 'logout']);
//User Routes for CRUD operations
Route::get('/getallusers', [UserController::class, 'index']);
Route::post('/postuser', [UserController::class, 'store']);
Route::get('/getuser/{id}', [UserController::class, 'show']);
Route::patch('/updateuser/{id}', [UserController::class, 'update']);
Route::delete('/deleteuser/{id}', [UserController::class, 'destroy']);
//Post Routes for CRUD operations
Route::get('/getallposts',[PostController::class, 'index']);
Route::post('/postpost', [PostController::class, 'store']);
Route::get('/getpost/{id}', [PostController::class, 'show']);
//Use post method in postman and add _method as PATCH in body of the form
Route::patch('/updatepost/{id}', [PostController::class, 'update']);
Route::delete('/deletepost/{id}', [PostController::class, 'delete']);

//Advanced Concept

//Api versioning (v1 and v2) to make updates and improvements to your API without breaking existing client applications.
Route::prefix('v1')->group(function(){
    //Get a user from a resource
    Route::get('/getfirstuser',[UserControllerV1::class, 'getfirstuser']);
    //Get all users collection from a resource
    Route::get('/getalluserscollection',[UserControllerV1::class, 'getalluserscollection']);
    //Get all users from a resource with specific keys
    Route::get('/getalluserscollectionwithspecifickeys',[UserControllerV1::class, 'getalluserscollectionwithspecifickeys']);
    //Get all users from a resource preserving the keys of the API request
    Route::get('/getalluserscollectionpreservingkeys',[UserControllerV1::class, 'getalluserscollectionpreservingkeys']);
    //Show all users according to related posts from a resource using v1 api
    Route::get('/getalluserswithpostcollection',[UserControllerV1::class, 'getalluserswithpostcollection']);
    //Show all users according to related posts from a resource using v1 api with data wrapping
    Route::get('/datawrappingtogetalluserswithpostcollection',[UserControllerV1::class, 'getalluserswithpostcollectiondatawrapping']);
});
Route::prefix('v2')->group(function(){
    //Get a user from a resouce using v2 api
    Route::get('/getfirstuser',[UserControllerV2::class, 'getfirstuser']);
    //Show all users according to related posts from a resouce using v2 api
    Route::get('/getalluserswithpostcollection',[UserControllerV2::class, 'getalluserswithpostcollection']);
    //Filtering the data to show all the latest created posts first from a resource using v2 api
    Route::get('/filterlatestposts',[PostControllerV2::class, 'filterlatestposts']);
    //Rate limiting to control the number of requests a user can make using v2 api
    //Throttle permits access upto (n) number of requests per minute as provided in the RouteServiceProvider
    //If the requests exceeds the limit, it return a 429 status response ( Too many requests ) 
    // Route::middleware('throttle:api')->group(function () {
        //Apply the rate limiting middleware to all the api routes
    // });
    //Throttle permits access upto 2 number of requests per minute manually for a group or set of routes
    Route::middleware('throttle:2,1')->group(function () {
        Route::get('/getallusersemailsratelimiting',[UserControllerV2::class, 'getallusersemailsratelimiting']);
        Route::get('/getallpostsimagesratelimiting',[PostControllerV2::class, 'getallpostsimagesratelimiting']);
    });
    //Throttle permits access upto 3 number of requests per minute manually for a particular route
    Route::get('/getallnamesofusersratelimiting',[UserControllerV2::class, 'getallnamesofusersratelimiting'])->middleware('throttle:3,1');
});
