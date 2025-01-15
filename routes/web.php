<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\Utils\BlockController;
use App\Http\Controllers\Utils\EditorJsController;
use App\Http\Controllers\Utils\FavoriteController;
use App\Http\Controllers\Utils\FollowController;
use App\Http\Controllers\Utils\LikeController;
use App\Http\Controllers\Utils\PinStoryController;
use App\Http\Controllers\Utils\SuspendUserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__.'/installer.php';
require __DIR__.'/auth.php';
require __DIR__.'/pwa.php';

Route::feeds();

Route::get('cronjob', [CronJobController::class, 'run'])->name('cronjob');

Route::name('feed.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/active', [HomeController::class, 'active'])->name('active');
    Route::get('/top/today', [HomeController::class, 'topToday'])->name('top.today');
    Route::get('/top/week', [HomeController::class, 'topWeek'])->name('top.week');
    Route::get('/top/month', [HomeController::class, 'topMonth'])->name('top.month');
    Route::get('/top/year', [HomeController::class, 'topYear'])->name('top.year');
    Route::get('/top/alltime', [HomeController::class, 'topAllTime'])->name('top.all-time');
});

Route::get('/featured', [HomeController::class, 'featured'])->name('featured');
Route::get('/communities', [HomeController::class, 'communities'])->name('communities');
// Contact Form
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Explore
Route::get('/explore', [ExploreController::class, 'explore'])->name('explore');
Route::get('/explore/users', [ExploreController::class, 'exploreTopUsers'])->name('explore.users');
Route::get('/explore/communities', [ExploreController::class, 'exploreTopCommunities'])->name('explore.communities');
Route::get('/search', [ExploreController::class, 'search'])->name('search');
Route::get('/search/units', [ExploreController::class, 'units'])->name('search.units');
Route::get('/search/users', [ExploreController::class, 'users'])->name('search.users');
Route::get('/search/communities', [ExploreController::class, 'communities'])->name('search.communities');

// Tags
Route::get('/tags', [TagsController::class, 'index'])->name('tags');
Route::get('/tag/{tag:normalized}', [TagsController::class, 'show'])->name('tag.show');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', '2fa.verify'])->group(function () {
    Route::get('/my', [HomeController::class, 'myFeed'])->name('feed.user');
    Route::get('/communities/mine', [HomeController::class, 'myCommunities'])->name('communities.my');
    Route::name('bookmarks.')->prefix('bookmarks')->group(function () {
        Route::get('/', [BookmarkController::class, 'stories'])->name('stories');
        Route::get('comments', [BookmarkController::class, 'comments'])->name('comments');
    });

    Route::name('story.')->prefix('story')->group(function () {
        Route::get('/create', [StoryController::class, 'create'])->name('create');
        Route::post('/{story:id}/save', [StoryController::class, 'save'])->name('save');
        Route::post('/{story:id}/update', [StoryController::class, 'save'])->name('update');
        Route::post('/{story:id}/publish', [StoryController::class, 'publish'])->name('publish');
        Route::get('/{story:id}/edit', [StoryController::class, 'edit'])->name('edit');
        Route::delete('/delete/{story}', [StoryController::class, 'destroy'])->name('destroy');
        Route::get('/repost/{story}/create', [StoryController::class, 'repost'])->name('repost.create');
        Route::name('utils.')->group(function () {
            Route::post('/utils/favorite', [FavoriteController::class, 'toggleFavoriteStory'])->name('favorite');
            Route::post('/utils/liked', [LikeController::class, 'toggleLike'])->name('liked');
            Route::post('/utils/pinned', PinStoryController::class)->name('pinned');
        });
        Route::name('editor.')->group(function () {
            Route::post('/upload/image', [EditorJsController::class, 'uploadImage'])->name('image.upload');
            Route::post('/upload/video', [EditorJsController::class, 'uploadVideo'])->name('video.upload');
            Route::post('/upload/audio', [EditorJsController::class, 'uploadAudio'])->name('audio.upload');
            Route::post('/delete-media', [EditorJsController::class, 'deleteUploadedMedia'])->name('delete.media');
        });
        Route::get('user/communities/joined', [StoryController::class, 'getUserJoinedCommunities'])->name('user.communities.joined');
    });

    Route::name('comment.')->prefix('comment')->group(function () {
        Route::post('/{story:slug}/store', [CommentController::class, 'store'])->name('store');
        Route::patch('/{comment:id}/update', [CommentController::class, 'update'])->name('update');
        Route::post('/{comment:id}/reply', [CommentController::class, 'reply'])->name('reply');
        Route::delete('/{comment:id}/delete', [CommentController::class, 'destroy'])->name('destroy');
        Route::name('utils.')->group(function () {
            Route::post('/utils/favorite', [FavoriteController::class, 'favoriteComment'])->name('favorite');
            Route::post('/utils/unfavorite', [FavoriteController::class, 'unfavoriteComment'])->name('unfavorite');
            Route::post('/utils/like', [LikeController::class, 'toggleLikeComment'])->name('like');
        });
    });

    Route::name('report.')->prefix('reports')->group(function () {
        Route::post('user', [ReportController::class, 'user'])->name('user');
        Route::post('story', [ReportController::class, 'story'])->name('story');
        Route::post('comment', [ReportController::class, 'comment'])->name('comment');
    });

    // User notification
    Route::prefix('notifications')->as('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/notifications-box', [NotificationController::class, 'getNotificationsBox'])->name('box');
        Route::get('/unreaded-count', [NotificationController::class, 'unreadedNotificationsCount'])->name('unreaded-count');
        Route::post('/marked', [NotificationController::class, 'markAsRead'])->name('marked');
        Route::post('/marked/{id}/follower', [NotificationController::class, 'markAsReadFollower'])->name('marked-follower');
        Route::post('/marked/{id}/comment', [NotificationController::class, 'markAsReadComment'])->name('marked-comment');
        Route::post('/marked/{id}/comment-reply', [NotificationController::class, 'markAsReadCommentReply'])->name('marked-comment-reply');
        Route::post('/marked/{id}/comment-mention', [NotificationController::class, 'markAsReadCommentMentioned'])->name('marked-comment-mention');
        Route::post('/marked/{id}/story-favorite', [NotificationController::class, 'markAsReadStoryFavorited'])->name('marked-story-favorite');
        Route::post('/marked/{id}/reported-story', [NotificationController::class, 'markAsReadReportedStory'])->name('marked-reported-story');
        Route::post('/marked/{id}/reported-comment', [NotificationController::class, 'markAsReadReportedComment'])->name('marked-reported-comment');
        Route::post('/marked/{id}/reported-user', [NotificationController::class, 'markAsReadReportedUser'])->name('marked-reported-user');
        Route::post('/marked/{id}/liked-story', [NotificationController::class, 'markAsReadLikedStory'])->name('marked-liked-story');
        Route::post('/marked/{id}/liked-comment', [NotificationController::class, 'markAsReadLikedComment'])->name('marked-liked-comment');
        Route::post('/delete', [NotificationController::class, 'deleteAllNotifications'])->name('delete');
    });

    // User Profile
    Route::name('user.')->group(function () {
        Route::name('bookmarks.')->prefix('bookmarks')->group(function () {
            Route::get('/', [BookmarkController::class, 'stories'])->name('stories');
            Route::get('comments', [BookmarkController::class, 'comments'])->name('comments');
        });
        Route::get('/drafts', [UserController::class, 'drafts'])->name('draft');
        Route::name('upload.')->group(function () {
            Route::post('upload/avatar', [UserController::class, 'uploadAvatar'])->name('avatar');
            Route::post('upload/cover', [UserController::class, 'uploadCoverImage'])->name('cover');
        });
        Route::name('settings.')->group(function () {
            Route::get('/u/{user:username}/settings', [UserSettingsController::class, 'showUserSettings'])->name('show');
            Route::get('/u/{user:username}/settings/account', [UserSettingsController::class, 'showAccountSettings'])->name('account');
            Route::patch('/u/{user:username}/settings/account', [UserSettingsController::class, 'updateAccountSettings'])->name('account');
            Route::get('/u/{user:username}/settings/password', [UserSettingsController::class, 'showPasswordSettings'])->name('password');
            Route::get('/u/{user:username}/settings/profile', [UserSettingsController::class, 'showProfileSettings'])->name('profile');
            Route::patch('/u/{user:username}/settings/profile', [UserSettingsController::class, 'updateProfileSettings'])->name('profile');
            Route::get('/u/{user:username}/settings/blocks', [UserSettingsController::class, 'showBlockedUsers'])->name('blocks');
            Route::get('/u/{user:username}/settings/badges', [UserSettingsController::class, 'showBadges'])->name('badges');
            Route::post('/u/{user:username}/settings/badges/sortable', [UserSettingsController::class, 'badgesSortable'])->name('badges.sortable');
            Route::get('u/{user:username}/settings/tfa', [UserSettingsController::class, 'showTFA'])->name('tfa');
            Route::post('u/{user:username}/settings/tfa/activate', [UserSettingsController::class, 'activateTFA'])->name('tfa.activate');
            Route::post('u/{user:username}/settings/tfa/deactivate', [UserSettingsController::class, 'deactivateTFA'])->name('tfa.deactivate');

            Route::get('u/{user:username}/settings/notifications', [UserSettingsController::class, 'showNotificationsSettings'])->name('notifications');
            Route::post('u/{user:username}/settings/notifications', [UserSettingsController::class, 'updateNotificationsSettings'])->name('notifications');

            Route::get('u/{user:username}/settings/preferences', [UserSettingsController::class, 'showPreferenceSettings'])->name('preference');
            Route::post('u/{user:username}/settings/preferences', [UserSettingsController::class, 'updatePreferenceSettings'])->name('preference');

            Route::get('/u/{user:username}/settings/destroy', [UserSettingsController::class, 'showDestroySettings'])->name('destroy');
            Route::delete('/u/{user:username}/settings/destroy', [UserSettingsController::class, 'destroy'])->name('destroy');
        });
        Route::name('utils.')->group(function () {
            Route::post('user/follow', [FollowController::class, 'toggleFollowUser'])->name('follow');
            Route::post('user/block', [BlockController::class, 'toggleBlock'])->name('block');
            Route::post('user/unblock', [BlockController::class, 'unblock'])->name('unblock');
            Route::post('user/suspend', [SuspendUserController::class, 'suspend'])->name('suspend');
            Route::post('user/unsuspend', [SuspendUserController::class, 'unsuspend'])->name('unsuspend');
        });
    });

    Route::prefix('c')->name('community.')->group(function () {
        Route::get('create', [CommunityController::class, 'create'])->name('create');
        Route::post('store', [CommunityController::class, 'store'])->name('store');
        Route::get('{community:slug}/settings', [CommunityController::class, 'settings'])->name('settings');
        Route::patch('{community:slug}/settings', [CommunityController::class, 'updateSettings'])->name('settings.update');
        Route::name('upload.')->group(function () {
            Route::post('upload/avatar', [CommunityController::class, 'uploadAvatar'])->name('avatar');
            Route::post('upload/cover', [CommunityController::class, 'uploadCoverImage'])->name('cover');
        });
        Route::name('utils.')->group(function () {
            Route::post('community/follow', [FollowController::class, 'toggleFollowCommunity'])->name('follow');
        });
    });
});

// Story show page
Route::get('/story/{story:slug}', [StoryController::class, 'show'])->name('story.show');

// Comments
Route::get('/story/{story:slug}/comments', [CommentController::class, 'index'])->name('story.comment.index');

// User Profile
Route::name('user.')->group(function () {
    Route::get('/u/{user:username}', [UserController::class, 'show'])->name('show')->withTrashed();
    Route::get('/u/{user:username}/pinned', [UserController::class, 'pinnedStories'])->name('pinned');
    Route::get('/u/{user:username}/comments', [UserController::class, 'comments'])->name('comments');
    Route::get('/u/{user:username}/followers', [UserController::class, 'followers'])->name('followers');
    Route::get('/u/{user:username}/followings', [UserController::class, 'followings'])->name('followings');
    Route::get('/u/{user:username}/notifications', [UserController::class, 'notifications'])->name('notifications');
});

// Pages
Route::get('/p/{page:slug}', [PageController::class, 'show'])->name('page.show');

// Communities
Route::get('/c/{community:slug}', [CommunityController::class, 'show'])->name('community.show');
Route::get('/c/{community:slug}/top', [CommunityController::class, 'top'])->name('community.top');
Route::get('/c/{community:slug}/about', [CommunityController::class, 'about'])->name('community.about');
