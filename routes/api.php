<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Tag\TagController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Main\MainController;
use App\Http\Controllers\Offer\OfferController;
use App\Http\Controllers\Blog\BlogTagController;
use App\Http\Controllers\Main\MainTagController;
use App\Http\Controllers\Blog\BlogMainController;
use App\Http\Controllers\Main\MainBlogController;
use App\Http\Controllers\Blog\BlogOfferController;
use App\Http\Controllers\Main\MainOfferController;
use App\Http\Controllers\Benefit\BenefitController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Section\SectionController;
use App\Http\Controllers\Tag\TagActivityController;
use App\Http\Controllers\Blog\BlogBenefitController;
use App\Http\Controllers\Blog\BlogSectionController;
use App\Http\Controllers\Main\MainBenefitController;
use App\Http\Controllers\Main\MainContactController;
use App\Http\Controllers\Main\MainSectionController;
use App\Http\Controllers\Activity\ActivityController;
use App\Http\Controllers\Blog\BlogActivityController;
use App\Http\Controllers\Blog\BlogCategoryController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Main\MainActivityController;
use App\Http\Controllers\Main\MainCategoryController;
use App\Http\Controllers\User\RegisteredUserController;
use App\Http\Controllers\Activity\ActivityTagController;
use App\Http\Controllers\Activity\ActivityBlogController;
use App\Http\Controllers\Activity\ActivityMainController;
use App\Http\Controllers\Category\CategoryBlogController;
use App\Http\Controllers\Activity\ActivityOfferController;
use App\Http\Controllers\Activity\ActivityBenefitController;
use App\Http\Controllers\Activity\ActivitySectionController;
use App\Http\Controllers\Activity\ActivityCategoryController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Main App
Route::apiResource('mains', MainController::class)->only(['index', 'show', 'update']);
Route::apiResource('mains.offers', MainOfferController::class)->only(['index', 'store']);
Route::apiResource('mains.benefits', MainBenefitController::class)->only(['index', 'store']);
Route::apiResource('mains.activities', MainActivityController::class)->only(['index', 'show', 'store']);
Route::apiResource('mains.sections', MainSectionController::class)->only(['index', 'store']);
Route::apiResource('mains.blogs', MainBlogController::class)->only(['index', 'show', 'store']);
Route::apiResource('mains.tags', MainTagController::class)->only(['index']);
Route::apiResource('mains.categories', MainCategoryController::class)->only(['index']);
Route::apiResource('mains.contacts', MainContactController::class)->only(['store']);


Route::apiResource('tags.activities', TagActivityController::class)->only(['index']);

Route::middleware('auth:sanctum')->group(function() {

    Route::get('user', [UserController::class, 'user']);

    // Activities
    Route::apiResource('activities', ActivityController::class)->except(['store']);
    Route::apiResource('activities.tags', ActivityTagController::class)->only(['index', 'update', 'destroy']);
    Route::apiResource('activities.mains', ActivityMainController::class)->only(['index']);
    Route::apiResource('activities.benefits', ActivityBenefitController::class)->only(['index']);
    Route::apiResource('activities.offers', ActivityOfferController::class)->only(['index']);
    Route::apiResource('activities.sections', ActivitySectionController::class)->only(['index']);
    Route::apiResource('activities.blogs', ActivityBlogController::class)->only(['index']);
    Route::apiResource('activities.categories', ActivityCategoryController::class)->only(['index']);
    Route::post('/activities/restore', [ActivityController::class, 'restore']);
    Route::post('/activities/delete', [ActivityController::class, 'delete']);

    // Benefits
    Route::apiResource('benefits', BenefitController::class)->except(['store']);

    // Blogs(news)
    Route::apiResource('blogs', BlogController::class)->except(['store']);
    Route::apiResource('blogs.categories', BlogCategoryController::class)->only(['index', 'update', 'destroy']);
    Route::apiResource('blogs.mains', BlogMainController::class)->only(['index']);
    Route::apiResource('blogs.sections', BlogSectionController::class)->only(['index']);
    Route::apiResource('blogs.offers', BlogOfferController::class)->only(['index']);
    Route::apiResource('blogs.benefits', BlogBenefitController::class)->only(['index']);
    Route::apiResource('blogs.activities', BlogActivityController::class)->only(['index']);
    Route::apiResource('blogs.tags', BlogTagController::class)->only(['index']);
    Route::post('/blogs/restore', [BlogController::class, 'restore']);
    Route::post('/blogs/delete', [BlogController::class, 'delete']);

    // Categories
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('categories.blogs', CategoryBlogController::class)->only(['index']);
    Route::post('/categories/restore', [CategoryController::class, 'restore']);
    Route::post('/categories/delete', [CategoryController::class, 'delete']);

    // Offers
    Route::apiResource('offers', OfferController::class)->except(['store']);
    Route::post('/offers/restore', [OfferController::class, 'restore']);
    Route::post('/offers/delete', [OfferController::class, 'delete']);

    // Sections
    Route::apiResource('sections', SectionController::class)->only(['index', 'show', 'update']);

    //Tags
    Route::apiResource('tags', TagController::class);

    Route::post('/tags/restore', [TagController::class, 'restore']);
    Route::post('/tags/delete', [TagController::class, 'delete']);

    //Users
    Route::apiResource('users', RegisteredUserController::class)->only(['index', 'destroy', 'store', 'update']);
    Route::post('/users/restore', [RegisteredUserController::class, 'restore']);
    Route::post('/users/delete', [RegisteredUserController::class, 'delete']);

    //Contacts
    Route::apiResource('contacts', ContactController::class)->except(['store']);
    Route::post('/contacts/restore', [ContactController::class, 'restore']);
    Route::post('/contacts/delete', [ContactController::class, 'delete']);

});


