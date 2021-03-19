<?php
namespace BinshopsBlog;

use \Session;

/**
 * Class Helpers
 * @package BinshopsBlog
 */
class Helpers
{
    /**
     * What key to use for the session::flash / pull / has
     */
    const FLASH_MESSAGE_SESSION_KEY = "BINSHOPSBLOG_FLASH";

    /**
     * Set a new message
     *
     * @param string $message
     */
    public static function flash_message(string $message)
    {
        Session::flash(Helpers::FLASH_MESSAGE_SESSION_KEY, $message);
    }

    /**
     * Is there a flashed message?
     *
     * @return bool
     */
    public static function has_flashed_message()
    {
        return Session::has(self::FLASH_MESSAGE_SESSION_KEY);
    }

    /**
     * return the flashed message. Use with ::has_flashed_message() if you need to check if it has a value...
     * @return string
     */
    public static function pull_flashed_message()
    {
        return Session::pull(self::FLASH_MESSAGE_SESSION_KEY);
    }

    /**
     * Use this (Helpers::rss_html_tag()) in your blade/template files, within <head>
     * to auto insert the links to rss feed
     * @return string
     */
    public static function rss_html_tag()
    {


        return '<link rel="alternate" type="application/atom+xml" title="Atom RSS Feed" href="' . e(route("binshopsblog.feed")) . '?type=atom" />
  <link rel="alternate" type="application/rss+xml" title="XML RSS Feed" href="' . e(route("binshopsblog.feed")) . '?type=rss" />
  ';


    }

    /**
     * This method is depreciated. Just use the config() directly.
     * @return array
     * @deprecated
     */
    public static function image_sizes(){
        return config("binshopsblog.image_sizes");
    }

}
