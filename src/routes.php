<?php

Route::group(['middleware' => ['web'], 'namespace' => '\BinshopsBlog\Controllers'], function () {

    /** The main public facing blog routes - show all posts, view a category, rss feed, view a single post, also the add comment route */
    Route::group(['prefix' => "/{locale}/".config('binshopsblog.blog_prefix', 'blog')], function () {

        Route::get('/', 'BinshopsReaderController@index')
            ->name('binshopsblog.index');

        Route::get('/search', 'BinshopsReaderController@search')
            ->name('binshopsblog.search');

        Route::get('/feed', 'BinshopsRssFeedController@feed')
            ->name('binshopsblog.feed'); //RSS feed

        Route::get('/category{subcategories}', 'BinshopsReaderController@view_category')->where('subcategories', '^[a-zA-Z0-9-_\/]+$')->name('binshopsblog.view_category');

//        Route::get('/category/{categorySlug}',
//            'BinshopsReaderController@view_category')
//            ->name('binshopsblog.view_category');

        Route::get('/{blogPostSlug}',
            'BinshopsReaderController@viewSinglePost')
            ->name('binshopsblog.single');


        // throttle to a max of 10 attempts in 3 minutes:
        Route::group(['middleware' => 'throttle:10,3'], function () {

            Route::post('save_comment/{blogPostSlug}',
                'BinshopsCommentWriterController@addNewComment')
                ->name('binshopsblog.comments.add_new_comment');


        });

    });


    /* Admin backend routes - CRUD for posts, categories, and approving/deleting submitted comments */
    Route::group(['prefix' => config('binshopsblog.admin_prefix', 'blog_admin')], function () {

        Route::get('/setup', 'BinshopsAdminSetupController@setup')
            ->name('binshopsblog.admin.setup');

        Route::post('/setup-submit', 'BinshopsAdminSetupController@setup_submit')
            ->name('binshopsblog.admin.setup_submit');

        Route::get('/', 'BinshopsAdminController@index')
            ->name('binshopsblog.admin.index');

        Route::get('/add_post',
            'BinshopsAdminController@create_post')
            ->name('binshopsblog.admin.create_post');


        Route::post('/add_post',
            'BinshopsAdminController@store_post')
            ->name('binshopsblog.admin.store_post');

        Route::post('/add_post_toggle',
            'BinshopsAdminController@store_post_toggle')
            ->name('binshopsblog.admin.store_post_toggle');

        Route::get('/edit_post/{blogPostId}',
            'BinshopsAdminController@edit_post')
            ->name('binshopsblog.admin.edit_post');

        Route::get('/edit_post_toggle/{blogPostId}',
            'BinshopsAdminController@edit_post_toggle')
            ->name('binshopsblog.admin.edit_post_toggle');

        Route::patch('/edit_post/{blogPostId}',
            'BinshopsAdminController@update_post')
            ->name('binshopsblog.admin.update_post');

        //Removes post's photo
        Route::get('/remove_photo/{slug}/{lang_id}',
            'BinshopsAdminController@remove_photo')
            ->name('binshopsblog.admin.remove_photo');

        Route::group(['prefix' => "image_uploads",], function () {

            Route::get("/", "BinshopsImageUploadController@index")->name("binshopsblog.admin.images.all");

            Route::get("/upload", "BinshopsImageUploadController@create")->name("binshopsblog.admin.images.upload");
            Route::post("/upload", "BinshopsImageUploadController@store")->name("binshopsblog.admin.images.store");

        });


        Route::delete('/delete_post/{blogPostId}',
            'BinshopsAdminController@destroy_post')
            ->name('binshopsblog.admin.destroy_post');

        Route::group(['prefix' => 'comments',], function () {

            Route::get('/',
                'BinshopsCommentsAdminController@index')
                ->name('binshopsblog.admin.comments.index');

            Route::patch('/{commentId}',
                'BinshopsCommentsAdminController@approve')
                ->name('binshopsblog.admin.comments.approve');
            Route::delete('/{commentId}',
                'BinshopsCommentsAdminController@destroy')
                ->name('binshopsblog.admin.comments.delete');
        });

        Route::group(['prefix' => 'categories'], function () {

            Route::get('/',
                'BinshopsCategoryAdminController@index')
                ->name('binshopsblog.admin.categories.index');

            Route::get('/add_category',
                'BinshopsCategoryAdminController@create_category')
                ->name('binshopsblog.admin.categories.create_category');
            Route::post('/store_category',
                'BinshopsCategoryAdminController@store_category')
                ->name('binshopsblog.admin.categories.store_category');

            Route::get('/edit_category/{categoryId}',
                'BinshopsCategoryAdminController@edit_category')
                ->name('binshopsblog.admin.categories.edit_category');

            Route::patch('/edit_category/{categoryId}',
                'BinshopsCategoryAdminController@update_category')
                ->name('binshopsblog.admin.categories.update_category');

            Route::delete('/delete_category/{categoryId}',
                'BinshopsCategoryAdminController@destroy_category')
                ->name('binshopsblog.admin.categories.destroy_category');

        });


        Route::group(['prefix' => 'languages'], function () {

            Route::get('/',
                'BinshopsLanguageAdminController@index')
                ->name('binshopsblog.admin.languages.index');

            Route::get('/add_language',
                'BinshopsLanguageAdminController@create_language')
                ->name('binshopsblog.admin.languages.create_language');
            Route::post('/add_language',
                'BinshopsLanguageAdminController@store_language')
                ->name('binshopsblog.admin.languages.store_language');

            Route::delete('/delete_language/{languageId}',
                'BinshopsLanguageAdminController@destroy_language')
                ->name('binshopsblog.admin.languages.destroy_language');

            Route::post('/toggle_language/{languageId}',
                'BinshopsLanguageAdminController@toggle_language')
                ->name('binshopsblog.admin.languages.toggle_language');

        });
    });
});

