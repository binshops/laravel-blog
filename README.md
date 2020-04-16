Package is in a rewrite (should be done by xmas 2019). Proper tests coming, unfortunately work has taken up a lot of my time since I first added this package, and I don't have time to get back to it and maintain it properly. The rewrite (which is just on the master branch...) has much better coding standards, proper unit/integration tests are intended to be added soon. The current versions on Packagist are on a different branch. I thought the rewrite would be a bit quicker! 

Some older features will be stripped out. The next version will be a breaking change, but the code will be more maintainable. This package was originally (back in version 1) not really expecting to get any public use. The new version will handle more use cases easier.

# WebDevEtc BlogEtc
## Easy to install Laravel Package for adding a full blog (with admin backend) to your Laravel app

#### 5 minutes to install! Quick and easy!

[![StyleCI](https://github.styleci.io/repos/144829997/shield?branch=master)](https://github.styleci.io/repos/144829997)
[![Build Status](https://travis-ci.org/WebDevEtc/BlogEtc.svg?branch=master)](https://travis-ci.org/WebDevEtc/BlogEtc)

## Introduction

This is [WebDevEtc's](https://webdevetc.com/) BlogEtc package. It has everything you need to quickly and easily add a blog to your laravel app.

#### For the full installation guide please visit [the Laravel Blog Etc install guide here](https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#install_guide)

## Features

- Includes all views, routes, models, controllers, events, etc
  - Public facing pages:
    - View all posts (paginated)
    - View all posts in category (paginated)
    - View single post
    - Add comment views / confirmation views
    - Search (full text search), search form, search results page.
  - Admin pages:
    - Posts **(CRUD Blog Posts, Upload Featured Images (auto resizes)**
      - View all posts,
      - Create new post,
      - Edit post,
      - Delete post
    - Categories **(CRUD Post Categories)**
      - View all categories,
      - Create new category,
      - Edit post,
      - Delete post
    - Comments **(including comment approvals)**
      - View all comments,
      - Approve/Moderate comment,
      - Delete comment
    - Upload images
      - as well as uploading featured images for each blog post (and auto resizing to multiple defined sizes), you can upload images separately.
      - view all uploaded images (in multiple sizes)
- **Includes admin panel**
  - Create / edit posts
  - Create / edit post categories
  - Manage (approve/delete) submitted comments
- Allows each blog post to have featured images uploaded (you can define the actual dimensions) - in large, medium, thumbnail sizes
- fully configurable via its `config/blogetc.php` config file.
- **Includes all required view files, works straight away with no additional setup.** All view files (Blade files) use Bootstrap 4, and very clean HTML (easy to get your head around). You can easily override any view file by putting files in your `/resources/views/vendor/blogetc/` directory
- **Built in comments (using the database)**, can auto approve or require admin approval (comment moderation).
  - Other options include using [Disqus](http://disqus.com/) comments or disabling comments.
- Includes unit tests.
- Fires events for any database changes, so you can easily add Event Listeners if you need to add additional logic.
- **< 5 minute install time** and your blog is up and working, ready for you to go to the admin panel and write a blog post - see full details below, but this is a summary of the required steps:
   - install with composer,
   - do the database migration, copy the config file over (done with `php artisan vendor:publish`)
   - chmod/chown the `public/blog_images/` directory so featured images can be uploaded for each blog post
   - and then add 1 method to your `\App\User` file (`canManageBlogEtcPosts()`
   - __but please see the install instructions to get everything up and working__


## What/who this package is for:

 - For websites running Laravel (5.6)
 - Who want to have a site blog, and have an easy to use interface to write blog posts/assign categories/manage existing posts
 - Where only admin users can edit/manage the blog (this is not suitable for every user on your site to be able to manage posts)
 - Where you understand that posts can (potentially) contain JS or any other code, so you should only allow trusted admin users to add/edit/delete/manage the blog posts

## What this package is NOT for:

 - Sites where you want your (normal, non-admin) users to write blog posts. You must set `canManageBlogEtcPosts()` on your user model to ONLY allow trusted users.

## Important notes

1) Anyone who can manage blog posts (defined by the `canManageBlogEtcPosts()` method you add to your User model) can submit any HTML which is echoed out. This is a security issue. If you don't trust the content you should add a custom view and escape the blog content before echoing it, and set `use_custom_view_files` in the config to false.

2) if `use_custom_view_files` is enabled in the config (which it is by default), it means that any post with a custom view file set (details in the docs) can include any file within `/resources/views/custom_blog_posts`, which blade will execute. This package gives no method to edit any file within that directory though.

## How to install BlogEtc to your laravel app

Please see our [BlogEtc Laravel Blog Package Documentation/install guide](https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#install_guide) for install instructions. (It is very simple - done via composer/artisan commands, plus adding one method to your \App\User model (`canManageBlogEtcPosts()` which should return `true` if this user can manage the blog).


## How to customise the blog views/templates

This is easy to do, and further detail can be found in our  [BlogEtc Laravel Blog Package Documentation](https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#guide_to_views).

After doing the correct `vendor:publish`, all of the default template files will be found in /resources/views/vendor/blogetc/ and are easy to edit to match your needs.

## Routes

It will auto set all required routes (both public facing, and admin backend). There are some config options (such as changing the /blog/ url to something else), which can be done in the blogetc.php file.

## Config options

Please see the [BlogEtc config option documentation here](https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#config_options) for details.

All config options have comments which describe what they do. Please just refer to the `blogetc.php` file in your /config/ dir.

## Events

You can find all the events that are fired by looking in the `/src/Events` directory.

Add these (and an Event Listener) to your `EventServiceProvider.php` file to make use of these events when they fire.

## Built in CAPTCHA / anti spam

There is a built in captcha (anti spam comment) system built in, which will be easy for you to replace with your own implementation.

  Please see [our Captcha docs](https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#captcha) for  more details.

## Having problems, something is not working?

*Image upload errors?*

Try adding this to config/app.php:

    'Image' => Intervention\Image\Facades\Image::class

- Also make sure that /tmp is writable. If you have open_basedir enabled, be sure to add :/tmp to its value.
- Ensure that /public/blog_images (or whatever directory you set it to in the config) is writable by the server
- You might need to set a higher memory limit, or upload smaller image files. This will depend on your server. I've used it to upload huge (10mb+) jpg images without problem, once the server was set up correctly to handle larger file uploads.
- New version of BlogEtc uses the Laravel filesystem to store images. You will probably need to run `php artisan storage:link` to use the images locally. If you are using something such as S3 then you will probably need to change the urls in blade.

## Version History

- 4.x - Currently work in progress. Will be released end of 2019. For Laravel 6 onwards.
- 3.1                   - minor fixes
- 3.0.3                 - fixed RSS feed cache issue
- 3.0.2                 - fixed default medium image size (changed to 600x400)
- 3.0.1                 - replaced all short tags (<?) with full opening ones (<?php)
- 3.0                   - Added separate functionality for uploading images (and save some meta data in db)
- 2.1                   - added 'short_description' to db + form, and BlogEtcPost::generate_introduction() method will try and use this to generate intro text.
- 2.0                   - added full text search (enable it via the config file - it is disabled by default). (removed in future version, will be added again via a different package)
- 1.2                   - added WYSIWYG, few smaller changes
- 1.1.1                 - added basic captcha
- 1.0.5                 - composer.json changes.
- 1.0                   - First release
- 0.3                   - Small changes, packagist settings.
- 0.1                   - Initial release


## Issues, support, bug reports, security issues

Please contact me on the contact from on [WebDev Etc](https://webdevetc.com/) or on [twitter](https://twitter.com/web_dev_etc/) and I'll get back to you asap.

## Upgrading to v6

A lot of the code base was changed for the next version of BlogEtc. I highly recommend you test locally.

Here is what you need to know:

1) Image uploads are now handled by the Laravel filesystem disks. You can use this to upload to services such as S3. By default it will use the 'public' disk, which will require you to run `php artisan storage:link` to create a symblink. Existing images will need to be moved to /storage/app/public/blog_images, and urls will need to be updated (to http://yoursite.com/storage/blog_images/*.jpg). You could also create a symblink to just link /storage/app/public/blog_images to http://yoursite/blog_images.
2) Many of the internal files have been changed. Most files follow a proper coding style. This should not affect you.
3) The search feature has been removed (it will get added again in the future).

