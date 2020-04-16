<?php

// BlogEtc routes - public facing ones (reading blog posts/commenting) and admin backend (add/edit posts).

Route::group(
    ['middleware' => ['web'], 'namespace' => '\WebDevEtc\BlogEtc\Controllers'],
    static function () {

        // The main public facing blog routes - show all posts, view a category, rss feed, view a single post, also the
        // add comment route.
        Route::group(
            ['prefix' => config('blogetc.blog_prefix', 'blog')],
            static function () {
                // Public blog index:
                Route::get('/', 'PostsController@index')
                    ->name('blogetc.index');

                // Public search results:
                Route::get('/search', 'PostsController@search')
                    ->name('blogetc.search');

                // Public RSS feed:
                Route::get('/feed', 'FeedController@index')
                    ->name('blogetc.feed'); //RSS feed

                // Public show category:
                Route::get(
                    '/category/{categorySlug}',
                    'PostsController@showCategory'
                )
                    ->name('blogetc.view_category');

                // Public show single blog post:
                Route::get(
                    '/{blogPostSlug}',
                    'PostsController@show'
                )
                    ->name('blogetc.show');

                // Public save new blog comment (throttle to a max of 10 attempts in 3 minutes):
                Route::group(['middleware' => ['throttle:10,3', 'can:blog-etc-add-comment']], static function () {
                    Route::post(
                        'save_comment/{blogPostSlug}',
                        'CommentsController@store'
                    )->name('blogetc.comments.add_new_comment');
                });
            }
        );

        // Admin backend routes - CRUD for posts, categories, and approving/deleting submitted comments.
        Route::group(
            [
                'middleware' => ['can:blog-etc-admin', 'auth'],
                'prefix'     => config('blogetc.admin_prefix', 'blog_admin'),
                'namespace'  => 'Admin',
            ],
            static function () {
                // Manage blog posts (admin panel):
                Route::group(['prefix' => 'posts'], static function () {
                    // Show all blog posts:
                    Route::get(
                        '/',
                        'ManagePostsController@index'
                    )->name('blogetc.admin.index');

                    // Create a new blog post (form):
                    Route::get(
                        '/add_post',
                        'ManagePostsController@create'
                    )->name('blogetc.admin.create_post');

                    // Store a new blog post entry:
                    Route::post(
                        '/add_post',
                        'ManagePostsController@store'
                    )->name('blogetc.admin.store_post');

                    // Show the edit form:
                    Route::get(
                        '/edit_post/{blogPostId}',
                        'ManagePostsController@edit'
                    )->name('blogetc.admin.edit_post');

                    // Store the changes to a blog post in DB:
                    Route::patch(
                        '/edit_post/{blogPostID}',
                        'ManagePostsController@update'
                    )->name('blogetc.admin.update_post');

                    // Delete a blog post:
                    Route::delete(
                        '/delete_post/{blogPostId}',
                        'ManagePostsController@destroy'
                    )->name('blogetc.admin.destroy_post');
                });

                // Manage Image Uploads (Admin panel):
                Route::group(
                    ['prefix' => 'image_uploads'],
                    static function () {
                        // show all uploaded images:
                        Route::get(
                            '/',
                            'ManageUploadsController@index'
                        )->name('blogetc.admin.images.all');

                        // upload new image (form):
                        Route::get(
                            '/upload',
                            'ManageUploadsController@create'
                        )->name('blogetc.admin.images.upload');

                        // store a new uploaded image:
                        Route::post(
                            '/upload',
                            'ManageUploadsController@store'
                        )->name('blogetc.admin.images.store');
                    }
                );

                // Manage comments (Admin Panel):
                Route::group(
                    ['prefix' => 'comments'],
                    static function () {
                        // show all comments:
                        Route::get(
                            '/',
                            'ManageCommentsController@index'
                        )->name('blogetc.admin.comments.index');

                        // approve a comment:
                        Route::patch(
                            '/{commentId}',
                            'ManageCommentsController@approve'
                        )->name('blogetc.admin.comments.approve')
                            ->middleware('can:blog-etc-approve-comments');

                        // delete a comment:
                        Route::delete(
                            '/{commentId}',
                            'ManageCommentsController@destroy'
                        )->name('blogetc.admin.comments.delete')
                            ->middleware('can:blog-etc-approve-comments');
                    }
                );

                // Category Admin panel - manage categories:
                Route::group(
                    ['prefix' => 'categories'],
                    static function () {
                        // show all categories:
                        Route::get(
                            '/',
                            'ManageCategoriesController@index'
                        )->name('blogetc.admin.categories.index');

                        // create a new category (form):
                        Route::get(
                            '/add_category',
                            'ManageCategoriesController@create'
                        )->name('blogetc.admin.categories.create_category');

                        // store a new category in DB:
                        Route::post(
                            '/add_category',
                            'ManageCategoriesController@store'
                        )->name('blogetc.admin.categories.store_category');

                        // edit a category (form):
                        Route::get(
                            '/edit_category/{categoryId}',
                            'ManageCategoriesController@edit'
                        )->name('blogetc.admin.categories.edit_category');

                        // update a category:
                        Route::patch(
                            '/edit_category/{categoryId}',
                            'ManageCategoriesController@update'
                        )->name('blogetc.admin.categories.update_category');

                        // delete a category:
                        Route::delete(
                            '/delete_category/{categoryId}',
                            'ManageCategoriesController@destroy'
                        )->name('blogetc.admin.categories.destroy_category');
                    }
                );
            }
        );
    }
);
