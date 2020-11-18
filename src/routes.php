<?php

Route::group(['middleware' => ['web'], 'namespace' => '\HessamCMS\Controllers'], function () {

    /** The main public facing blog routes - show all posts, view a category, rss feed, view a single post, also the add comment route */
    Route::group(['prefix' => "/{locale}/".config('hessamcms.blog_prefix', 'blog')], function () {

        Route::get('/', 'HessamReaderController@index')
            ->name('hessamcms.index');

        Route::get('/search', 'HessamReaderController@search')
            ->name('hessamcms.search');

        Route::get('/feed', 'HessamRssFeedController@feed')
            ->name('hessamcms.feed'); //RSS feed

        Route::get('/category{subcategories}', 'HessamReaderController@view_category')->where('subcategories', '^[a-zA-Z0-9-_\/]+$')->name('hessamcms.view_category');

//        Route::get('/category/{categorySlug}',
//            'HessamReaderController@view_category')
//            ->name('hessamcms.view_category');

        Route::get('/{blogPostSlug}',
            'HessamReaderController@viewSinglePost')
            ->name('hessamcms.single');


        // throttle to a max of 10 attempts in 3 minutes:
        Route::group(['middleware' => 'throttle:10,3'], function () {

            Route::post('save_comment/{blogPostSlug}',
                'HessamCommentWriterController@addNewComment')
                ->name('hessamcms.comments.add_new_comment');


        });

    });


    /* Admin backend routes - CRUD for posts, categories, and approving/deleting submitted comments */
    Route::group(['prefix' => config('hessamcms.admin_prefix', 'blog_admin')], function () {

        Route::get('/setup', 'HessamAdminSetupController@setup')
            ->name('hessamcms.admin.setup');

        Route::post('/setup-submit', 'HessamAdminSetupController@setup_submit')
            ->name('hessamcms.admin.setup_submit');

        Route::get('/', 'HessamAdminController@index')
            ->name('hessamcms.admin.index');

        Route::get('/add_post',
            'HessamAdminController@create_post')
            ->name('hessamcms.admin.create_post');


        Route::post('/add_post',
            'HessamAdminController@store_post')
            ->name('hessamcms.admin.store_post');

        Route::post('/add_post_toggle',
            'HessamAdminController@store_post_toggle')
            ->name('hessamcms.admin.store_post_toggle');

        Route::get('/edit_post/{blogPostId}',
            'HessamAdminController@edit_post')
            ->name('hessamcms.admin.edit_post');

        Route::get('/edit_post_toggle/{blogPostId}',
            'HessamAdminController@edit_post_toggle')
            ->name('hessamcms.admin.edit_post_toggle');

        Route::patch('/edit_post/{blogPostId}',
            'HessamAdminController@update_post')
            ->name('hessamcms.admin.update_post');

        //Removes post's photo
        Route::get('/remove_photo/{slug}/{lang_id}',
            'HessamAdminController@remove_photo')
            ->name('hessamcms.admin.remove_photo');

        Route::group(['prefix' => "image_uploads",], function () {

            Route::get("/", "HessamImageUploadController@index")->name("hessamcms.admin.images.all");

            Route::get("/upload", "HessamImageUploadController@create")->name("hessamcms.admin.images.upload");
            Route::post("/upload", "HessamImageUploadController@store")->name("hessamcms.admin.images.store");

        });


        Route::delete('/delete_post/{blogPostId}',
            'HessamAdminController@destroy_post')
            ->name('hessamcms.admin.destroy_post');

        Route::group(['prefix' => 'comments',], function () {

            Route::get('/',
                'HessamCommentsAdminController@index')
                ->name('hessamcms.admin.comments.index');

            Route::patch('/{commentId}',
                'HessamCommentsAdminController@approve')
                ->name('hessamcms.admin.comments.approve');
            Route::delete('/{commentId}',
                'HessamCommentsAdminController@destroy')
                ->name('hessamcms.admin.comments.delete');
        });

        Route::group(['prefix' => 'categories'], function () {

            Route::get('/',
                'HessamCategoryAdminController@index')
                ->name('hessamcms.admin.categories.index');

            Route::get('/add_category',
                'HessamCategoryAdminController@create_category')
                ->name('hessamcms.admin.categories.create_category');
            Route::post('/store_category',
                'HessamCategoryAdminController@store_category')
                ->name('hessamcms.admin.categories.store_category');

            Route::get('/edit_category/{categoryId}',
                'HessamCategoryAdminController@edit_category')
                ->name('hessamcms.admin.categories.edit_category');

            Route::patch('/edit_category/{categoryId}',
                'HessamCategoryAdminController@update_category')
                ->name('hessamcms.admin.categories.update_category');

            Route::delete('/delete_category/{categoryId}',
                'HessamCategoryAdminController@destroy_category')
                ->name('hessamcms.admin.categories.destroy_category');

        });


        Route::group(['prefix' => 'languages'], function () {

            Route::get('/',
                'HessamLanguageAdminController@index')
                ->name('hessamcms.admin.languages.index');

            Route::get('/add_language',
                'HessamLanguageAdminController@create_language')
                ->name('hessamcms.admin.languages.create_language');
            Route::post('/add_language',
                'HessamLanguageAdminController@store_language')
                ->name('hessamcms.admin.languages.store_language');

            Route::delete('/delete_language/{languageId}',
                'HessamLanguageAdminController@destroy_language')
                ->name('hessamcms.admin.languages.destroy_language');

            Route::post('/toggle_language/{languageId}',
                'HessamLanguageAdminController@toggle_language')
                ->name('hessamcms.admin.languages.toggle_language');

        });
    });
});

