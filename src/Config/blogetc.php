<?php

use App\User;
use WebDevEtc\BlogEtc\Captcha\Basic;
use WebDevEtc\BlogEtc\Services\CommentsService;

// config for webdevetc/blogetc
// There are lots of options here, but all have comments. For further documentation please see webdevetc.com/blogetc

return [
    // Default title for blog index page
    // Default: Our blog
    'blog_index_title' => 'Our Blog',

    // Set to false to not include routes.php for BlogEtcReaderController and admin related routes.
    // If you disable this, you will have to manually copy over the data from routes.php and add it to your web.php.
    // Default: true
    'include_default_routes' => true,

    // The blog prefix used in routes.php. If you want to your http://yoursite.com/latest-news (or anything else),
    // then enter that here.
    // Default: blog
    'blog_prefix' => 'blog',

    // Similar to above, but used for the admin panel for the blog.
    // Default: blog_admin
    'admin_prefix' => 'blog_admin',

    // set to false to disable the use of being able to make blog posts include a view from
    // resources/views/custom_blog_posts/*.blade.php. Default: false. Set to true to use this feature.
    // Default: false
    'use_custom_view_files' => false,

    // how many posts to show per page on the blog index page.
    // Default: 10
    'per_page' => 10,

    // Are image uploads enabled?
    // Default: true
    'image_upload_enabled' => true,

    // This should be in public_path() (i.e. /public/blog_images), and should be writable
    // (be sure this directory is writable!)
    // Default: blog_images
    'blog_upload_dir' => 'blog_images',

    // What disk (in config/filesystems.php) to use?
    // Default is 'public'.
    'image_upload_disk' => 'public',

    // Store full size image when uploading a single photo (not part of featured image)?
    'image_store_full_size' => true,

    // The user model - this is often moved to \App\Models namespace
    'user_model' => User::class,

    // Memory limit - used when uploading images. Set to a high value to avoid out of memory issues
    // Set to false to not set any value
    // Default: 512M
    'memory_limit' => '512M',

    // Should it echo out raw HTML post body (with {!! ... !!})? This is not safe if you do not trust your writers!
    // Do not set to true if you don't trust your blog post writers. They could put in any HTML or JS code.
    // This will apply to all posts (past and future).
    // (you should disable this (set to false) if you don't trust your blog writers).
    // Default: true
    'echo_html' => true,

    // If echo_html is false, before running the post body in e(), it can run strip_tags
    // Default: false
    'strip_html' => false,

    // If echo_html is false, should it wrap post body in nl2br()?
    // Default: true
    'auto_nl2br' => true,

    // Use a WYSIWYG editor for posts (rich text editor)?
    // This will load scripts from https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js
    // echo_html must be set to true for this to have an effect.
    // Default: true
    'use_wysiwyg' => true,

    // what image quality to use when saving images. higher = better + bigger sizes. Around 80 is normal.
    // Default: 80
    'image_quality' => 80,

    // Array of image sizes.
    'image_sizes' => [

        // if you set 'enabled' to false, it will clear any data for that field the next time any row is updated.
        // However it will NOT delete the .jpg file on your file server.
        // I recommend that you only change the enabled field before any images have been uploaded!

        'image_large' => [ // this key must start with 'image_'. This is what the DB column must be named
            // width in pixels
            'w' => 1000,

            // height in pixels
            'h' => 700,

            // same as the main key, but WITHOUT 'image_'.
            'basic_key' => 'large',

            // description, used in the admin panel
            'name' => 'Large',

            // is this size enabled?
            'enabled' => true,

            // if true then we will crop and resize to exactly w/h.
            // If false then it will maintain proportions, with a max width of 'w' and max height of 'h'
            'crop' => true,
        ],
        // for comments please see image_large above
        'image_medium' => [
            'w'         => 600,
            'h'         => 400,
            'basic_key' => 'medium',
            'name'      => 'Medium',
            'enabled'   => true,
            'crop'      => true,
        ],
        'image_thumbnail' => [
            'w'         => 150,
            'h'         => 150,
            'basic_key' => 'thumbnail',
            'name'      => 'Thumbnail',
            'enabled'   => true,
        ],

        /*
         You can add more fields here, but make sure that you create the relevant database columns too!
         They must be in the same format as the default ones - image_xxxxx (and this db column must exist on
         the blog_etc_posts table)
        'image_custom_example_size' => [ // << MAKE A DB COLUMN WITH THIS NAME.
                                         //   You can name it whatever you want, but it must start with image_
            'w' => 1000,                  // << DEFINE YOUR CUSTOM WIDTH/HEIGHT
            'h' => 200,
            'basic_key' => "custom_example_size", // << THIS SHOULD BE THE SAME AS THE KEY, BUT WITHOUT THE image_
            'name' => "Test",            // A HUMAN READABLE NAME
            'enabled' => true,           // see note above about enabled/disabled
            ],

         Create the custom db table by running:
               php artisan make:migration --table=blog_etc_posts AddCustomBlogImageSize

         Then adding in the up() method in the generated file:
               $table->string("image_custom_example_size")->nullable();

         and in the down() method:
                $table->dropColumn("image_custom_example_size"); for the down()

         then run
           php artisan migrate
        */
    ],

    // Captcha config:
    'captcha' => [
        // Is captcha enabled? If comments are disabled the captcha won't be shown
        // Default: true
        'captcha_enabled' => true,

        // What captcha class to use?
        // this should be a class that implements the \WebDevEtc\BlogEtc\Interfaces\CaptchaInterface interface
        // Default: WebDevEtc\BlogEtc\Captcha\Basic::class
        'captcha_type' => Basic::class,

        // a simple captcha question to always ask (if captcha_type is set to 'basic')
        // Default: What is the opposite of white?
        'basic_question' => 'What is the opposite of white?',

        // comma separated list of possible answers. Don't worry about case.
        // Default: black,dark
        'basic_answers' => 'black,dark',
    ],

    // RSS Feed Settings:
    'rssfeed' => [
        // Should we shorten the text in rss feed?
        // Default: true
        'should_shorten_text' => true,

        // Max length of description text in the rss feed
        // Default: 100
        'text_limit' => 100,

        // How many posts to show in the RSS feed
        // Default: 10
        'posts_to_show_in_rss_feed' => 10,

        // How long (in minutes) to cache the RSS blog feed for.
        // Default: 60
        'cache_in_minutes' => 60,

        // Description for the RSS feed
        // Default: Our blog post RSS feed
        'description' => 'Our blog post RSS feed',

        // Title for the RSS Feed
        // Default: BlogEtc Blog Feed
        'title' => 'BlogEtc Blog Feed',

        // What language to use in the feed
        // see https://www.w3.org/TR/REC-html40/struct/dirlang.html#langcodes
        // Default: en
        'language' => 'en',
    ],

    // Comments settings:
    'comments' => [
        // What type (if any) of comments/comment form to show.
        // options:
        //      \WebDevEtc\BlogEtc\Services\BlogEtcCommentsService::COMMENT_TYPE_BUILT_IN
        //           (default, uses own database for comments),

        //      \WebDevEtc\BlogEtc\Services\BlogEtcCommentsService::COMMENT_TYPE_DISQUS
        //           (uses https://disqus.com/, please enter further config options below),

        //      \WebDevEtc\BlogEtc\Services\BlogEtcCommentsService::COMMENT_TYPE_CUSTOM
        //           (will load blogetc::partials.custom_comments, which you can copy to your vendor view
        //                  dir to customise

        //      \WebDevEtc\BlogEtc\Services\BlogEtcCommentsService::COMMENT_TYPE_DISABLED
        //           (turn comments off)
        // Default: built_in
        'type_of_comments_to_show' => CommentsService::COMMENT_TYPE_BUILT_IN,

        // Max num of comments to show on a single blog post.
        // Set to a lower number for smaller page sizes.
        // Comment pagination is not yet implemented
        // Default: 1000
        'max_num_of_comments_to_show' => 1000,

        // Save comment writer's IP address?
        // Default: true
        'save_ip_address' => true,

        // Do comments get auto approved (no moderation)?
        // If set to true you may get spam comments appearing
        // If set to false you have to manually approve all comments in the admin panel
        // Default: false
        'auto_approve_comments' => false,

        // If user is logged in, should we save that user id?
        // If false it will always ask for an author name, which the commenter can provide
        // Default: true
        'save_user_id_if_logged_in' => true,

        // What field on your User model should we use when echoing out the author name?
        // By default this should be 'name', but maybe you have it set up to use 'username' etc.
        // Default: name
        'user_field_for_author_name' => 'name',

        // Show 'author email' on the form?
        // Default: true
        'ask_for_author_email' => true,

        // Require an email (make sure ask_for_author_email is true if you want to use this)
        // Default: false
        'require_author_email' => false,

        // Show 'author website' on the form, show the link when viewing the comment?
        // Default: true
        'ask_for_author_website' => true,

        // Disqus options:
        'disqus' => [
            // This only applies if comments.type_of_comments_to_show is set to 'disqus'. The following config option
            // can be found by looking for the following line on the embed code of your Disqus code:
            //     s.src = 'https://yourusername_or_sitename.disqus.com/embed.js';
            // You must enter the whole url
            'src_url' => 'https://GET_THIS_FROM_YOUR_EMBED_CODE.disqus.com/embed.js',
        ],
    ],

    // Search config:
    'search' => [
        // Is search enabled? By default this is disabled, but you can easily turn it on.
        // Default: false
        // [Search is temporarily completely disabled - will return in a future version soon. Sorry!]
        'search_enabled' => false,
    ],
];
