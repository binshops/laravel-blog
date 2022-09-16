# Laravel Blog
Have you worked with Wordpress? Developers call this package wordpress-like laravel blog.

## [Installation Video - Less than 5 Minutes](https://youtu.be/N9NpFUqbftA)
[![Laravel Blog Package](http://img.youtube.com/vi/N9NpFUqbftA/0.jpg)](https://youtu.be/N9NpFUqbftA)

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

### Quick and easy installation (Multi-lang version)
1- Install via composer

`composer require binshops/laravel-blog`

For a fresh Laravel installation run the following too:

```
composer require laravel/ui
php artisan ui vue --auth
```

2- Scaffold

```
npm install && npm run build
```

3- Run the following two commands to copy config file, migration files, and view files

`php artisan vendor:publish --provider="BinshopsBlog\BinshopsBlogServiceProvider"`

4- Execute migrations to create tables

`php artisan migrate;`

5- You must add one method to your \App\User (in laravel 8 \App\Models\User) model. As the name of this method shows it determines which user can manage posts. Place your logic there

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

6- Create a directory in `public/` named `blog_images`

7- Start the server

```
php artisan serve
```

8- Login as admin and setup your package: `/blog_admin/setup`

Congrats! Your blog is ready to use. (URLs are customizable in the config file)

  Admin panel URI: `/blog_admin`
  Front URI: `/en/blog`

To see package on Packagist click this [Link](https://packagist.org/packages/binshops/laravel-blog)

### Single Language Version
To install the single language version of the package use version v8.1x:

1- `composer require binshops/laravel-blog:v8.1.2`

2- `php artisan vendor:publish --provider="BinshopsBlog\BinshopsBlogServiceProvider"`

3- `php artisan vendor:publish --tag=laravel-fulltext`

4- `php artisan migrate;`

You can see the single version in "single-lang" branch.

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

There is a built-in captcha (anti-spam comment) system built in, which will be easy for you to replace with your own implementation.

There is a basic anti-spam captcha function built-in.

See the config/binshops.php captcha section. There is a built in system (basic!) that will prevent most automated spam attempts.
Writing your own captcha system:

I wrote the captcha system simple on purpose, so you can add your own captcha options. It should be easy to add any other captcha system to this.

If you want to write your own implementation then create your own class that implements \BinshopsBlog\Interfaces\CaptchaInterface, then update the config/binshopsblog.php file (change the captcha_type option).

There are three methods you need to implement:
public function captcha_field_name() : string

Return a string such as "captcha". It is used for the form validation and <input name=???>.
public function view() : string

What view file should the binshops::partials.add_comment_form view include? You can set this to whatever you need, and then create your own view file. The default included basic captcha class will return "binshops::captcha.basic".
public function rules() : array

Return an array for the rules (which are just the standard Laravel validation rules. This is where you can check if the captcha was successful or not.
Optional:
public function runCaptchaBeforeShowingPosts() : null

This isn't part of the interface, it isn't required. By default it does nothing. But you can put some code in this method and it'll be run in the BinshopsReaderController::viewSinglePost method.

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
- 7.3.0 New Admin UI
- 3.0.1                 - replaced all short tags (<?) with full opening ones (<?php)
- 2.0                   - added full text search (enable it via the config file - it is disabled by default).
- 1.1.1                 - added basic captcha
- 1.0.5                 - composer.json changes.
- 1.0                   - First release
- 0.1                   - Initial release

## Contributors ✨
<table>
  <tr>
    <td align="center"><a href="https://github.com/samberrry"><img src="https://avatars.githubusercontent.com/u/20775532?v=4" width="80px;" alt=""/><br /><sub><b>Sam Berry</b></sub></a><br /></td>
<td align="center"><a href="https://github.com/dasscheman"><img src="https://avatars.githubusercontent.com/u/6064248?v=4" width="80px;" alt=""/><br /><sub><b>Alef Barbeli</b></sub></a><br /> </td>

  </tr>
</table>
