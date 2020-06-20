<?php

Route::group(['middleware' => ['web'], 'namespace' => '\WebDevEtc\BlogEtc\Controllers'], function () {


    /** The main public facing blog routes - show all posts, view a category, rss feed, view a single post, also the add comment route */
    Route::group(['prefix' => config('blogetc.blog_prefix', 'blog')], function () {

        Route::get('/', 'BlogEtcReaderController@index')
            ->name('blogetc.index');

        Route::get('/search', 'BlogEtcReaderController@search')
            ->name('blogetc.search');

        Route::get('/feed', 'BlogEtcRssFeedController@feed')
            ->name('blogetc.feed'); //RSS feed

        Route::get('/category/{categorySlug}',
            'BlogEtcReaderController@view_category')
            ->name('blogetc.view_category');

        Route::get('/{blogPostSlug}',
            'BlogEtcReaderController@viewSinglePost')
            ->name('blogetc.single');


        // throttle to a max of 10 attempts in 3 minutes:
        Route::group(['middleware' => 'throttle:10,3'], function () {

            Route::post('save_comment/{blogPostSlug}',
                'BlogEtcCommentWriterController@addNewComment')
                ->name('blogetc.comments.add_new_comment');


        });

    });


    /* Admin backend routes - CRUD for posts, categories, and approving/deleting submitted comments */
    Route::group(['prefix' => config('blogetc.admin_prefix', 'blog_admin')], function () {

        Route::get('/', 'BlogEtcAdminController@index')
            ->name('blogetc.admin.index');

        Route::get('/add_post',
            'BlogEtcAdminController@create_post')
            ->name('blogetc.admin.create_post');


        Route::post('/add_post',
            'BlogEtcAdminController@store_post')
            ->name('blogetc.admin.store_post');


        Route::get('/edit_post/{blogPostId}',
            'BlogEtcAdminController@edit_post')
            ->name('blogetc.admin.edit_post');

        Route::patch('/edit_post/{blogPostId}',
            'BlogEtcAdminController@update_post')
            ->name('blogetc.admin.update_post');

        //Removes post's photo
        Route::get('/remove_photo/{slug}',
            'BlogEtcAdminController@remove_photo')
            ->name('blogetc.admin.remove_photo');

        Route::group(['prefix' => "image_uploads",], function () {

            Route::get("/", "BlogEtcImageUploadController@index")->name("blogetc.admin.images.all");

            Route::get("/upload", "BlogEtcImageUploadController@create")->name("blogetc.admin.images.upload");
            Route::post("/upload", "BlogEtcImageUploadController@store")->name("blogetc.admin.images.store");

        });


        Route::delete('/delete_post/{blogPostId}',
            'BlogEtcAdminController@destroy_post')
            ->name('blogetc.admin.destroy_post');

        Route::group(['prefix' => 'comments',], function () {

            Route::get('/',
                'BlogEtcCommentsAdminController@index')
                ->name('blogetc.admin.comments.index');

            Route::patch('/{commentId}',
                'BlogEtcCommentsAdminController@approve')
                ->name('blogetc.admin.comments.approve');
            Route::delete('/{commentId}',
                'BlogEtcCommentsAdminController@destroy')
                ->name('blogetc.admin.comments.delete');
        });

        Route::group(['prefix' => 'categories'], function () {

            Route::get('/',
                'BlogEtcCategoryAdminController@index')
                ->name('blogetc.admin.categories.index');

            Route::get('/add_category',
                'BlogEtcCategoryAdminController@create_category')
                ->name('blogetc.admin.categories.create_category');
            Route::post('/add_category',
                'BlogEtcCategoryAdminController@store_category')
                ->name('blogetc.admin.categories.store_category');

            Route::get('/edit_category/{categoryId}',
                'BlogEtcCategoryAdminController@edit_category')
                ->name('blogetc.admin.categories.edit_category');

            Route::patch('/edit_category/{categoryId}',
                'BlogEtcCategoryAdminController@update_category')
                ->name('blogetc.admin.categories.update_category');

            Route::delete('/delete_category/{categoryId}',
                'BlogEtcCategoryAdminController@destroy_category')
                ->name('blogetc.admin.categories.destroy_category');

        });

    });
});

