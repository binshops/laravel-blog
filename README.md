<p align="center">
   <a href="https://packagist.org/packages/hessam/laravel-blogger">
      <img src="https://poser.pugx.org/hessam/laravel-blogger/v/stable.png" alt="Latest Stable Version">
  </a>

  <a href="https://packagist.org/packages/hessam/laravel-blogger">
    <img src="https://poser.pugx.org/hessam/laravel-blogger/license.png" alt="License">
  </a>
</p>

# Complete Laravel Blog Package

### Lightweight and Comprehensive

Incredible features with a lightweight laravel blog package. I highly recommend it because:
- Quick installation (<3 minutes)
- It's very easy to extend
- Included great features out-of-box
- Its simplicity allows to be easily made compatible with latest laravel
- No additional concept except laravel knowledge

## Outstanding Features
- Fulltext Search - search throughout all blog posts
- Multi Level Category - nested sets using Baum
- Multi Language Support 

### Quick and easy installation

Install with following command and follow the instructions. 

    composer require hessam/laravel-blogger

### For Complete Setup Instructions (with video guide), please Visit [The Install Guide](https://hessam.binshops.com/laravel-blog-package#setup)

To see package on Packagist click this [Link](https://packagist.org/packages/hessam/laravel-blogger)

## Important Notes
- For laravel 8.x's default auth User model, change user model in `hessamcms.php` to: `\App\Models\User::class`

## Features
- Compatible with latest laravel version (laravel 8.x)
- Backward-compatibility with previous laravel versions
- Full text search - searching throughout the blog posts
- Multi-level category support
- fully configurable via its `config/hessamcms.php` config file
- Ready to use admin panel
- Full customizability of admin views and front views
- Paginated views
- Ability to upload images
- Managing posts, categories
- Managing comments and comment approval
- Other options include using Disqus comments or disabling comments

## Recent Changes  
- **8.0.x** Compatibility with Laravel 8.x

## Screen Shots

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

 - For websites running Laravel
 - Who wants to have a site blog, and have an easy to use interface to write blog posts/assign categories/manage existing posts
 - Where only admin users can edit/manage the blog (this is not suitable for every user on your site to be able to manage posts)
 - For anyone who likes to add a wordpress-like CMS to her/his web app

## How to customise the blog views/templates

After doing the correct `vendor:publish`, all of the default template files will be found in /resources/views/vendor/hessamcms/ and are easy to edit to match your needs.

### Customizing admin views
If you need to customize the admin view, just copy the files from
`vendor/hessamcms/src/Views/hessamcms_admin`
to
`resources/views/vendor/hessamcms_admin`
Then you can modify them just like any other view file.

## Routes

It will auto set all required routes (both public facing, and admin backend). There are some config options (such as changing the /blog/ url to something else), which can be done in the hessamcms.php file.

## Config options
All config options have comments which describe what they do. Please just refer to the `hessamcms.php` file in your /config/ dir.

### Custom User Model
You can change the default user model through the config file.

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
- **9.0.x** Multi-language support beta release
- 8.0.x Compatibility with Laravel 8
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
- 2.1                   - added 'short_description' to db + form, and HessamCMSPost::generate_introduction() method will try and use this to generate intro text.
- 2.0                   - added full text search (enable it via the config file - it is disabled by default).
- 1.2                   - added WYSIWYG, few smaller changes
- 1.1.1                 - added basic captcha
- 1.0.5                 - composer.json changes.
- 1.0                   - First release
- 0.3                   - Small changes, packagist settings.
- 0.1                   - Initial release

Contact: hessam.modaberi@gmail.com




