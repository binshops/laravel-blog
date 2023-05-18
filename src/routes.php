<?php

Route::group(['middleware' => ['web'], 'namespace' => '\BinshopsBlog\Controllers'], function () {

    /** The main public facing blog routes - show all posts, view a category, rss feed, view a single post, also the add comment route */
    Route::group(['prefix' => config('binshopsblog.blog_prefix', 'blog')], function () {

        Route::get('/', 'BinshopsBlogReaderController@index')
            ->name('binshopsblog.index');

        Route::get('/search', 'BinshopsBlogReaderController@search')
            ->name('binshopsblog.search');

        Route::get('/feed', 'BinshopsBlogRssFeedController@feed')
            ->name('binshopsblog.feed'); //RSS feed

        Route::get('/category{subcategories}', 'BinshopsBlogReaderController@view_category')->where('subcategories', '^[a-zA-Z0-9-_\/]+$')->name('binshopsblog.view_category');

//        Route::get('/category/{categorySlug}',
//            'BinshopsBlogReaderController@view_category')
//            ->name('binshopsblog.view_category');

        Route::get('/{blogPostSlug}',
            'BinshopsBlogReaderController@viewSinglePost')
            ->name('binshopsblog.single');

        // throttle to a max of 10 attempts in 3 minutes:
        Route::group(['middleware' => 'throttle:10,3'], function () {

            Route::post('save_comment/{blogPostSlug}',
                'BinshopsBlogCommentWriterController@addNewComment')
                ->name('binshopsblog.comments.add_new_comment');
        });
    });

    /* Admin backend routes - CRUD for posts, categories, and approving/deleting submitted comments */
    Route::group(['prefix' => config('binshopsblog.admin_prefix', 'blog_admin')], function () {

        Route::get('/search',
            'BinshopsBlogAdminController@searchBlog')
            ->name('binshopsblog.admin.searchblog');

        Route::get('/', 'BinshopsBlogAdminController@index')
            ->name('binshopsblog.admin.index');

        Route::get('/add_post',
            'BinshopsBlogAdminController@create_post')
            ->name('binshopsblog.admin.create_post');


        Route::post('/add_post',
            'BinshopsBlogAdminController@store_post')
            ->name('binshopsblog.admin.store_post');


        Route::get('/edit_post/{blogPostId}',
            'BinshopsBlogAdminController@edit_post')
            ->name('binshopsblog.admin.edit_post');

        Route::patch('/edit_post/{blogPostId}',
            'BinshopsBlogAdminController@update_post')
            ->name('binshopsblog.admin.update_post');

        //Removes post's photo
        Route::get('/remove_photo/{slug}',
            'BinshopsBlogAdminController@remove_photo')
            ->name('binshopsblog.admin.remove_photo');

        Route::group(['prefix' => "image_uploads",], function () {

            Route::get("/", "BinshopsBlogImageUploadController@index")->name("binshopsblog.admin.images.all");

            Route::get("/upload", "BinshopsBlogImageUploadController@create")->name("binshopsblog.admin.images.upload");
            Route::post("/upload", "BinshopsBlogImageUploadController@store")->name("binshopsblog.admin.images.store");
        });

        Route::delete('/delete_post/{blogPostId}',
            'BinshopsBlogAdminController@destroy_post')
            ->name('binshopsblog.admin.destroy_post');

        Route::group(['prefix' => 'comments',], function () {

            Route::get('/',
                'BinshopsBlogCommentsAdminController@index')
                ->name('binshopsblog.admin.comments.index');

            Route::patch('/{commentId}',
                'BinshopsBlogCommentsAdminController@approve')
                ->name('binshopsblog.admin.comments.approve');
            Route::delete('/{commentId}',
                'BinshopsBlogCommentsAdminController@destroy')
                ->name('binshopsblog.admin.comments.delete');
        });

        Route::group(['prefix' => 'categories'], function () {

            Route::get('/',
                'BinshopsBlogCategoryAdminController@index')
                ->name('binshopsblog.admin.categories.index');

            Route::get('/add_category',
                'BinshopsBlogCategoryAdminController@create_category')
                ->name('binshopsblog.admin.categories.create_category');
            Route::post('/add_category',
                'BinshopsBlogCategoryAdminController@store_category')
                ->name('binshopsblog.admin.categories.store_category');

            Route::get('/edit_category/{categoryId}',
                'BinshopsBlogCategoryAdminController@edit_category')
                ->name('binshopsblog.admin.categories.edit_category');

            Route::patch('/edit_category/{categoryId}',
                'BinshopsBlogCategoryAdminController@update_category')
                ->name('binshopsblog.admin.categories.update_category');

            Route::delete('/delete_category/{categoryId}',
                'BinshopsBlogCategoryAdminController@destroy_category')
                ->name('binshopsblog.admin.categories.destroy_category');
        });
    });
});

