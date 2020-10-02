# Complete Laravel Blog Package
## With Multi-level Categories and Full Text Search
It has everything you need to quickly and easily add a blog to your laravel app.

## [Online Demo](https://cms.binshops.com/login)
You can check Hessam CMS online: [https://cms.binshops.com](https://cms.binshops.com/login)

### Quick and easy installation

Install with following command and follow the instructions. 

    composer require hessam/laravel-blogger

### For Complete Setup Instructions (with video guide), please Visit [The Install Guide](https://hessam.binshops.com/laravel-blog-package#setup)

To see package on Packagist click this [Link](https://packagist.org/packages/hessam/laravel-blogger)

## Recent Changes  
- **8.0.0** Compatibility with Laravel 8

### Screen Shots

  <p align="center">
    <img src="https://hessam.binshops.com/wp-content/uploads/2020/08/Screen-Shot-2020-08-08-at-6.23.35-PM-1024x560.png" width="500px" title="Add post">
  </p>
  <p align="center">
  Add post
  </p>

  <p align="center">
    <img src="https://hessam.binshops.com/wp-content/uploads/2020/08/Screen-Shot-2020-08-08-at-6.19.42-PM-1024x558.png" width="500px" title="All posts">
  </p>
   <p align="center">
    All posts
    </p>
  
  <p align="center">
    <img src="https://hessam.binshops.com/wp-content/uploads/2020/08/Screen-Shot-2020-08-08-at-6.03.39-PM-1-1024x560.png" width="500px" title="Add category">
  </p>
  <p align="center">
      Add category
   </p>
  
## What/who this package is for:

 - For websites running Laravel (6.x and higher)
 - Who want to have a site blog, and have an easy to use interface to write blog posts/assign categories/manage existing posts
 - Where only admin users can edit/manage the blog (this is not suitable for every user on your site to be able to manage posts)
 - Where you understand that posts can (potentially) contain JS or any other code, so you should only allow trusted admin users to add/edit/delete/manage the blog posts

## What this package is NOT for:

 - Sites where you want your (normal, non-admin) users to write blog posts. You must set `canManageBlogEtcPosts()` on your user model to ONLY allow trusted users.

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

## Important notes

1) Anyone who can manage blog posts (defined by the `canManageBlogEtcPosts()` method you add to your User model) can submit any HTML which is echoed out. This is a security issue. If you don't trust the content you should add a custom view and escape the blog content before echoing it, and set `use_custom_view_files` in the config to false.

2) if `use_custom_view_files` is enabled in the config (which it is by default), it means that any post with a custom view file set (details in the docs) can include any file within `/resources/views/custom_blog_posts`, which blade will execute. This package gives no method to edit any file within that directory though.


## How to customise the blog views/templates

After doing the correct `vendor:publish`, all of the default template files will be found in /resources/views/vendor/blogetc/ and are easy to edit to match your needs.

### Customizing admin views
If you need to customize the admin view, just copy the files from
`vendor/webdevetc/blogetc/src/Views/blogetc_admin`
to
`resources/views/vendor/blogetc_admin`
Then you can modify them just like any other view file.

## Routes

It will auto set all required routes (both public facing, and admin backend). There are some config options (such as changing the /blog/ url to something else), which can be done in the blogetc.php file.

## Config options
All config options have comments which describe what they do. Please just refer to the `blogetc.php` file in your /config/ dir.

### Custom User Model
You can change the default user model through the config file

## Events

You can find all the events that are fired by looking in the `/src/Events` directory.

Add these (and an Event Listener) to your `EventServiceProvider.php` file to make use of these events when they fire.

## Built in CAPTCHA / anti spam

There is a built in captcha (anti spam comment) system built in, which will be easy for you to replace with your own implementation.

  Please see [this Captcha docs](https://hessam.binshops.com/laravel-blog-package#captcha) for  more details.

## Image upload errors

Try adding this to config/app.php:

    'Image' => Intervention\Image\Facades\Image::class

- Also make sure that /tmp is writable. If you have open_basedir enabled, be sure to add :/tmp to its value.
- Ensure that /public/blog_images (or whatever directory you set it to in the config) is writable by the server
- You might need to set a higher memory limit, or upload smaller image files. This will depend on your server. I've used it to upload huge (10mb+) jpg images without problem, once the server was set up correctly to handle larger file uploads.

## Version History    
- **8.0.x** Compatibility with Laravel 8
- 7.3.2 Some bug fixes
- 7.3.0 New Admin UI
- 7.2.2                 
    - bug fix: do not show search bar when it's disabled
    - feature: configure to show full text post or preview 
- 7.2.1                 - adds logout button at admin panel
- 7.2.0                 
    - adds sub-category functionality to blog
    - adds reading progress bar feature (if you upgrade, re-publish config file and view files)
- 7.1.8                 - ability to remove images from posts (this feature does not work for old posts)
- 7.1.7                 - updates CKEditor
- 7.1.5                 - minor fix for recent posts
- 7.1.4                 - updates fulltext search package which solves the search issue
- 7.1.2                 - shows categories on blog home page - minor fix (if you upgrade try to re-publish view files)
- 7.1.1                 - minor fix and some admin panel text changes
- 7.1.0                 - Adds support for custom user model (if you upgrade, try to publish new config)
- 7.0.2                 - Bug fix for listing posts and search page
- 7.0.1                 - made compatible with Laravel 6.x & 7.x
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

Contact: hessam.modaberi@gmail.com




