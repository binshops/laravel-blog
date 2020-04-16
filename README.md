# August 2019 -

I am currently rewriting a lot of the code base (better quality, better coding standards, etc). Laravel 5.8 is supported on the old version (3.x) - please see packagist. I will release v4 soon.

# WebDevEtc BlogEtc
## Easy to install Laravel Package for adding a full blog (with admin backend) to your Laravel app
### 5 minutes to install! Quick and easy!

## Introduction

This is [WebDevEtc's](https://webdevetc.com/) BlogEtc package. It has everything you need to quickly and easily add a blog to your laravel app.


## FOR 5 MINUTE INSTALLATION GUIDE (with video guide), PLEASE VISIT [THE INSTALL GUIDE HERE](https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#install_guide)

[Install guide](https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#install_guide) • [Packagist](https://packagist.org/packages/webdevetc/blogetc) << MAKE SURE YOU FOLLOW THE INSTURCTIONS. They're simple, but must be followed.

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

## TODO

This is a list of features or things that I want to eventually get round to adding

- Better UI for uploading images/viewing uploaded images
- Link uploaded images to blog post. At the moment they are not related.
- Allow users to remove a featured image from a blog post.
- Option to use HTMLPurifier to sanatise output.
- Better options for assigning post authors (currently it just assigns the currently logged in user). However, if site has 10,000+ users do we really want an UI interface for this? The alternative is to add something like a a is_admin field to the `users` table and only show admin users.
- Possibly add tags (we already have categories) but I am not sure how useful they really are, given that we already have categories.
- Pagination for comments on view single post? At the moment we limit it to a high number (default in config is 5000).
- RSS feed: shows from full (stripped tags) ->html of blog post (although has a setTextLimit() on it) - need to trim this, and if it uses custom view files then it should render that (without html).
- Email notification to admin when new comment is added
- RSS to use generate_introduction() for its contents.


## Recent changes:

1) Added full text search and search views. You have to enable it in the config file (see latest config file)
2) Need more than the 3 default image sizes? Add more in the config/blogetc.php file, add the database column for it and it'll work!

## Having problems, something is not working?

*Image upload errors?*

Try adding this to config/app.php:

    'Image' => Intervention\Image\Facades\Image::class

- Also make sure that /tmp is writable. If you have open_basedir enabled, be sure to add :/tmp to its value.
- Ensure that /public/blog_images (or whatever directory you set it to in the config) is writable by the server
- You might need to set a higher memory limit, or upload smaller image files. This will depend on your server. I've used it to upload huge (10mb+) jpg images without problem, once the server was set up correctly to handle larger file uploads.




## Version History



- 3.1                   - minor fixes
- 3.0.3                 - fixed RSS feed cache issue
- 3.0.2                 - fixed default medium image size (changed to 600x400)
- 3.0.1                 - replaced all short tags (<?) with full opening ones (<?php)
- 3.0                   - Added separate functionality for uploading images (and save some meta data in db)
- 2.1                   - added 'short_description' to db + form, and BlogEtcPost::generate_introduction() method will try and use this to generate intro text.
- 2.0                   - added full text search (enable it via the config file - it is disabled by default).
- 1.2                   - added WYSIWYG, few smaller changes
- 1.1.1                 - added basic captcha
- 1.0.5                 - composer.json changes.
- 1.0                   - First release
- 0.3                   - Small changes, packagist settings.
- 0.1                   - Initial release


## Issues, support, bug reports, security issues

Please contact me on the contact from on [WebDev Etc](https://webdevetc.com/) or on [twitter](https://twitter.com/web_dev_etc/) and I'll get back to you asap.




