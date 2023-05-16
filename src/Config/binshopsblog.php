<?php

//config for binshops/laravel-blogger

return [
    //Your custom User model
    //Change it to \App\User::class for previous laravel versions
    'user_model'=>\App\Models\User::class,

    // reading progress bar is the bar which shows on top of your post when you are scrolling down the page. You can disable this feature if you want
    'reading_progress_bar' => true,

    'include_default_routes' => true, // set to false to not include routes.php for BinshopsReaderController and admin related routes. Default: true. If you disable this, you will have to manually copy over the data from routes.php and add it to your web.php.

    'blog_prefix' => "blog", // used in routes.php. If you want to your http://yoursite.com/latest-news (or anything else), then enter that here. Default: blog
    'admin_prefix' => "blog_admin", // similar to above, but used for the admin panel for the blog. Default: blog_admin

    'use_custom_view_files' => false, // set to false to disable the use of being able to make blog posts include a view from resources/views/custom_blog_posts/*.blade.php. Default: false. Set to true to use this feature. Default: false

    'per_page' => 10, // how many posts to show per page on the blog index page. Default: 10


    'image_upload_enabled' => true, // true or false, if image uploading is allowed.
    'blog_upload_dir' => "blog_images", // this should be in public_path() (i.e. /public/blog_images), and should be writable


    'memory_limit' => '2048M', // This is used when uploading images :
    //                              @ini_set('memory_limit', config("binshopsblog.memory_limit"));
    //                            See PHP.net for detailso
    //                            Set to false to not set any value.


    //if true it will echo out  (with {!! !!}) the blog post with NO escaping! This is not safe if you don't trust your blog post writers! Understand the risks by leaving this to true
    // (you should disable this (set to false) if you don't trust your blog writers).
    // This will apply to all posts (past and future).
    // Do not set to true if you don't trust your blog post writers. They could put in any HTML or JS code.
    'echo_html' => true, // default true

    // If strip_html is true, it'll run strip_tags() before escaping and echoing.
    // It doesn't add any security advantage, but avoids any html tags appearing if you have disabled echoing plain html.
    //  Only works if echo_html is false.
    'strip_html' => false, // Default: false.

    //  Only works if echo_html if false. If auto_nl2br is true, the output will be run through nl2br after escaping.
    'auto_nl2br' => true, // Default: true.

    // use the ckeditor WYWIWYG (rich text editor) for formatting your HTML blog posts.
    // This will load scripts from https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js
    // echo_html must be set to true for this to have an effect.
    'use_wysiwyg' => true, // Default: true


    'image_quality' => 80, // what image quality to use when saving images. higher = better + bigger sizes. Around 80 is normal.


    'image_sizes' => [

        // if you set 'enabled' to false, it will clear any data for that field the next time any row is updated. However it will NOT delete the .jpg file on your file server.
        // I recommend that you only change the enabled field before any images have been uploaded!

        // Also, if you change the w/h (which are obviously in pixels :) ), it won't change any previously uploaded images.

        // There must be only three sizes - image_large, image_medium, image_thumbnail.


        'image_large' => [ // this key must start with 'image_'. This is what the DB column must be named
            'w' => 1000, // width in pixels
            'h' => 700, //height
            'basic_key' => "large", // same as the main key, but WITHOUT 'image_'.
            'name' => "Large", // description, used in the admin panel
            'enabled' => true, // see note above
            'crop' => true, // if true then we will crop and resize to exactly w/h. If false then it will maintain proportions, with a max width of 'w' and max height of 'h'
        ],
        'image_medium' => [ // this key must start with 'image_'. This is what the DB column must be named
            'w' => 600, // width in pixels
            'h' => 400, //height
            'basic_key' => "medium",// same as the main key, but WITHOUT 'image_'.
            'name' => "Medium",// description, used in the admin panel
            'enabled' => true, // see note above
            'crop' => true, // if true then we will crop and resize to exactly w/h. If false then it will maintain proportions, with a max width of 'w' and max height of 'h'. If you use these images as part of your website template then you should probably have this to true.
        ],
        'image_thumbnail' => [ // this key must start with 'image_'. This is what the DB column must be named
            'w' => 150, // width in pixels
            'h' => 150, //height
            'basic_key' => "thumbnail",// same as the main key, but WITHOUT 'image_'.
            'name' => "Thumbnail",// description, used in the admin panel
            'enabled' => true, // see note above
        ],

        // you can add more fields here, but make sure that you create the relevant database columns too!
        // They must be in the same format as the default ones - image_xxxxx (and this db column must exist on the binshops_posts table)

        /*
        'image_custom_example_size' => [ // << MAKE A DB COLUM WITH THIS NAME.
                                         //   You can name it whatever you want, but it must start with image_
            'w' => 123,                  // << DEFINE YOUR CUSTOM WIDTH/HEIGHT
            'h' => 456,
            'basic_key' =>
                  "custom_example_size", // << THIS SHOULD BE THE SAME AS THE KEY, BUT WITHOUT THE image_
            'name' => "Test",            // A HUMAN READABLE NAME
            'enabled' => true,           // see note above about enabled/disabled
            ],
        */
        // Create the custom db table by doing
        //  php artisan make:migration --table=binshops_posts AddCustomBlogImageSize
        //   then adding in the up() method:
        //       $table->string("image_custom_example_size")->nullable();
        //    and in the down() method:
        //        $table->dropColumn("image_custom_example_size"); for the down()
        // then run
        //   php artisan migrate
    ],


    'captcha' => [
        'captcha_enabled' => true, // true = we should use a captcha, false = turn it off. If comments are disabled this makes no difference.
        'captcha_type' => \BinshopsBlog\Captcha\Basic::class, // this should be a class that implements the \BinshopsBlog\Interfaces\CaptchaInterface interface
        'basic_question' => "What is the opposite of white?", // a simple captcha question to always ask (if captcha_type is set to 'basic'
        'basic_answers' => "black,dark", // comma separated list of possible answers. Don't worry about case.
    ],

    ////////// comments:

    'comments' => [


        // What type (if any) of comments/comment form to show.
        // options:
        //      'built_in' (default, uses own database for comments),
        //      'disqus' (uses https://disqus.com/, please enter further config options below),
        //      'custom' (will load binshopsblog::partials.custom_comments, which you can copy to your vendor view dir to customise
        //      'disabled' (turn comments off)
        'type_of_comments_to_show' => 'built_in', // default: built_in

        'max_num_of_comments_to_show' => 1000, // max num of comments to show on a single blog post. Set to a lower number for smaller page sizes. No comment pagination is built in yet.

        // should we save the IP address in the database?
        'save_ip_address' => true, // Default: true


        //should comments appear straight away on the site (set this to true)? or wait for approval (set to false)
        'auto_approve_comments' => false, // default: false


        'save_user_id_if_logged_in' => true, // if user is logged in, should we save that user id? (if false it will always ask for an author name, which the commenter can provide

        'user_field_for_author_name' => "name", // what field on your User model should we use when echoing out the author name? By default this should be 'name', but maybe you have it set up to use 'username' etc.

        'ask_for_author_email' => true, // show 'author email' on the form ?
        'require_author_email' => false, // require an email (make sure ask_for_author_email is true if you want to use this)
        'ask_for_author_website' => true, // show 'author website' on the form, show the link when viewing the comment

        'disqus' => [

            // only applies if comments.type_of_comments_to_show is set to 'disqus'
//              The following config option can be found by looking for the following line on the embed code of your disqus code:
//                          s.src = 'https://yourusername_or_sitename.disqus.com/embed.js';
//
//             You must enter the whole url (but not the "s.src = '" part!)
            'src_url' => "https://GET_THIS_FROM_YOUR_EMBED_CODE.disqus.com/embed.js", // enter the url here, from the html snippet disqus provides

        ],
    ],

    'search' => [
        'search_enabled' => true, //you can easily turn off search functionality

        'limit-results'=> 50,
        'enable_wildcards' => true,
        'weight' => [
            'title' => 1.5,
            'content' => 1,
        ],
    ],

    //Shows full text of post in listing pages like search result page or category page. Now it shows a preview
    'show_full_text_at_list' => true,
];
