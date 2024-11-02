<?php

use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

require __DIR__.'/setup.php';
require __DIR__.'/auth.php';
require __DIR__.'/pwa.php';

Route::middleware(['auth', 'verified'])->group(function () {
    // Main page
    Route::get('/myfeed', [HomeController::class, 'myFeed'])->name('myfeed');
    Route::get('/saved-stories', [HomeController::class, 'savedStories'])->name('saved.stories');
    Route::get('/saved-comments', [HomeController::class, 'savedComments'])->name('saved.comments');

    //Create Story
    Route::get('/new-story', [StoryController::class, 'create'])->name('story.create');
    Route::get('story/{story}/edit', [StoryController::class, 'edit'])->name('story.edit');

    // Create Community
    Route::prefix('c')->group(function () {
        Route::get('create', [CommunityController::class, 'create'])->name('community.create');
        Route::get('{community:slug}/settings', [CommunityController::class, 'settings'])->name('community.settings');
    });

    // User Profile
    Route::get('/@{user:username}/settings', [UserController::class, 'settings'])->name('user.settings');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/followers', [DashboardController::class, 'followers'])->name('user.dashboard.followers');
    Route::get('/dashboard/following/users', [DashboardController::class, 'followingUsers'])->name('user.dashboard.following.users');
    Route::get('/dashboard/following/communities', [DashboardController::class, 'followingCommunities'])->name('user.dashboard.following.communities');
});

if (config('alma.default_feed') === 'popular') {
    Route::get('/', [HomeController::class, 'popular'])->name('home');
    Route::get('/latest', [HomeController::class, 'latest'])->name('latest');
} else {
    Route::get('/', [HomeController::class, 'latest'])->name('home');
    Route::get('/popular', [HomeController::class, 'popular'])->name('popular');
}

Route::get('/featured', [HomeController::class, 'featured'])->name('featured');
Route::get('/communities', [HomeController::class, 'topCommunities'])->name('top.communities');

// Story show page
Route::get('/story/{story:slug}', [StoryController::class, 'show'])->name('story.show')->middleware('online');

// Contact Form
Route::get('/contact', [ContactController::class, 'show'])->name('contact-form.show');

// Tags
Route::get('/tags', [TagsController::class, 'index'])->name('tags');
Route::get('/tag/{tag:normalized}', [TagsController::class, 'show'])->name('tag.show');

// User Profile
Route::get('{user:username}', [UserController::class, 'show'])->name('user.show');

// Pages
Route::get('p/{page:slug}', [PageController::class, 'show'])->name('page.show');

// Communities
Route::prefix('c')->group(function () {
    Route::get('/{community:slug}', [CommunityController::class, 'show'])->name('community.show');
});
