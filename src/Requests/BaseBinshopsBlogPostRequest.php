<?php

namespace BinshopsBlog\Requests;

use Carbon\Carbon;

abstract class BaseBinshopsBlogPostRequest extends BaseRequest
{

    /**
     * Shared rules for blog posts
     *
     * @return array
     * @todo tidy this up! It is a bit of a mess!
     */
    protected function baseBlogPostRules()
    {
        // setup some anon functions for some of the validation rules:
        $check_valid_posted_at = function ($attribute, $value, $fail) {
            // just the 'date' validation can cause errors ("2018-01-01 a" passes the validation, but causes a carbon error).
            try {
                Carbon::createFromFormat('Y-m-d H:i:s', $value);
            } catch (\Exception $e) {
                // return $fail if Carbon could not successfully create a date from $value
                return $fail('Posted at is not a valid date');
            }
        };

        $show_error_if_has_value = function ($attribute, $value, $fail) {
            if ($value) {
                // return $fail if this had a value...
                return $fail($attribute . ' must be empty');
            }
        };

        $disabled_use_view_file = function ($attribute, $value, $fail) {
            if ($value) {
                // return $fail if this had a value
                return $fail("The use of custom view files is not enabled for this site, so you cannot submit a value for it");
            }
        };


        // generate the main set of rules:
        $return = [
            'posted_at' => ['nullable', $check_valid_posted_at],
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'subtitle' => ['nullable', 'string', 'min:1', 'max:255'],
            'post_body' => ['required_without:use_view_file', 'max:2000000'], //medium text
            'meta_desc' => ['nullable', 'string', 'min:1', 'max:1000'],
            'short_description' => ['nullable', 'string', 'max:30000'],
            'slug' => [
                'nullable', 'string', 'min:1', 'max:150', 'alpha_dash', // this field should have some additional rules, which is done in the subclasses.
            ],
            'categories' => ['nullable', 'array'],
        ];


        // is use_custom_view_files true?
        if (config('binshopsblog.use_custom_view_files')) {
            $return['use_view_file'] = ['nullable', 'string', 'alpha_num', 'min:1', 'max:75',];
        } else {
            // use_view_file is disabled, so give an empty if anything is submitted via this function:
            $return['use_view_file'] = ['string', $disabled_use_view_file];
        }

        // some additional rules for uploaded images
        foreach ((array)config('binshopsblog.image_sizes') as $size => $image_detail) {
            if ($image_detail['enabled'] && config("binshopsblog.image_upload_enabled")) {
                $return[$size] = ['nullable', 'image',];
            } else {
                // was not enabled (or all images are disabled), so show an error if it was submitted:
                $return[$size] = $show_error_if_has_value;
            }
        }
        return $return;
    }


}
