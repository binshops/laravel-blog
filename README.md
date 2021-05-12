# Laravel Blog
Single language version of Binshops Laravel Blog 

### Contact us for any customization:
contact@binshops.com

### Lightweight and Comprehensive

Incredible features with a lightweight laravel blog package. I highly recommend it because:
- Quick installation (<3 minutes)
- It's very easy to extend
- Included great features out-of-box
- Its simplicity allows to be easily made compatible with latest laravel
- No additional concept except laravel knowledge
- Compatible with other Laravel platforms like Bagisto

## Outstanding Features
- Fulltext Search - search throughout all blog posts
- Multi Level Category - nested sets using Baum
- Multi Language Support

### Quick and easy installation
1- Install via composer

`composer require binshops/laravel-blog:v8.1.1`

For a fresh Laravel installation run the following too:

```
composer require laravel/ui
php artisan ui vue --auth
```

2- Run the following two commands to copy config file, migration files, and view files

`php artisan vendor:publish --provider="BinshopsBlog\BinshopsBlogServiceProvider"`

3- Execute migrations to create tables

`php artisan migrate;`

4- You must add one method to your \App\User (in laravel 8 \App\Models\User) model. As the name of this method shows it determines which user can manage posts. Place your logic there

```
 /**
     * Enter your own logic (e.g. if ($this->id === 1) to
     *   enable this user to be able to add/edit blog posts
     *
     * @return bool - true = they can edit / manage blog posts,
     *        false = they have no access to the blog admin panel
     */
    public function canManageBinshopsBlogPosts()
    {
        // Enter the logic needed for your app.
        // Maybe you can just hardcode in a user id that you
        //   know is always an admin ID?

        if (       $this->id === 1
             && $this->email === "your_admin_user@your_site.com"
           ){

           // return true so this user CAN edit/post/delete
           // blog posts (and post any HTML/JS)

           return true;
        }

        // otherwise return false, so they have no access
        // to the admin panel (but can still view posts)

        return false;
    }
```

5- Create a directory in `public/` named `blog_images`

Congrats! Your blog is ready to use. (URLs are customizable in the config file)

Admin panel URI: `/blog_admin`
Front URI: `/blog`

To see package on Packagist click this [Link](https://packagist.org/packages/binshops/laravel-blog)

### Bagisto version
To see the Bagisto version of this package go to `bagisto-compatible` branch

## Important Notes
- For laravel 8.x's default auth User model, change user model in `binshopsblog.php` to: `\App\Models\User::class`

## Features
- Compatible with latest laravel version (laravel 8.x)
- Backward-compatibility with previous laravel versions
- Full text search - searching throughout the blog posts
- Multi-level category support
- fully configurable via its `config/binshopsblog.php` config file
- Ready to use admin panel
- Full customizability of admin views and front views
- Paginated views
- Ability to upload images
- Managing posts, categories
- Managing comments and comment approval
- Other options include using Disqus comments or disabling comments

## Recent Changes
- **9.1.x** Multi language support
- 8.0.x Compatibility with Laravel 8.x

## What/who this package is for:

- For websites running Laravel
- Who wants to have a site blog. This laravel blog gives an easy to use interface to write blog posts/assign categories/manage existing posts
- Where only admin users can edit/manage the blog (this is not suitable for every user on your site to be able to manage posts)
- For anyone who likes to add a wordpress-like laravel blog to laravel website

## How to customise the blog views/templates

After doing the correct `vendor:publish`, all of the default template files will be found in /resources/views/vendor/binshopsblog/ and are easy to edit to match your needs.

### Customizing admin views
If you need to customize the admin view, just copy the files from
`vendor/binshopsblog/src/Views/binshopsblog_admin`
to
`resources/views/vendor/binshopsblog_admin`
Then you can modify them just like any other view file.

## Routes

It will auto set all required routes (both public facing, and admin backend). There are some config options (such as changing the /blog/ url to something else), which can be done in the binshopsblog.php file.

## Config options
All config options have comments which describe what they do. Please just refer to the `binshopsblog.php` file in your /config/ dir.

### Custom User Model
You can change the default user model through the config file.

## Events

You can find all the events that are fired by looking in the `/src/Events` directory.

Add these (and an Event Listener) to your `EventServiceProvider.php` file to make use of these events when they fire.

## Built in CAPTCHA / anti spam

There is a built in captcha (anti spam comment) system built in, which will be easy for you to replace with your own implementation.

Please see [this Captcha docs](https://binshops.binshops.com/laravel-blog-package#captcha) for  more details.

## Image upload errors

Try adding this to config/app.php:

    'Image' => Intervention\Image\Facades\Image::class

- Also make sure that /tmp is writable. If you have open_basedir enabled, be sure to add :/tmp to its value.
- Ensure that /public/blog_images (or whatever directory you set it to in the config) is writable by the server
- You might need to set a higher memory limit, or upload smaller image files. This will depend on your server. I've used it to upload huge (10mb+) jpg images without problem, once the server was set up correctly to handle larger file uploads.

## Version History
- **9.2.x** Stable version of package
- 9.0.x Multi-language support beta release
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
- 2.1                   - added 'short_description' to db + form, and BinshopsBlogPost::generate_introduction() method will try and use this to generate intro text.
- 2.0                   - added full text search (enable it via the config file - it is disabled by default).
- 1.2                   - added WYSIWYG, few smaller changes
- 1.1.1                 - added basic captcha
- 1.0.5                 - composer.json changes.
- 1.0                   - First release
- 0.3                   - Small changes, packagist settings.
- 0.1                   - Initial release

Contact: contact@binshops.com




