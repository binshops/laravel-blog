<?php

namespace WebDevEtc\BlogEtc\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use WebDevEtc\BlogEtc\Models\Category;

/**
 * Class PostRequest.
 */
class PostRequest extends FormRequest
{
    /**
     * If $_GET['category'] slugs were submitted, then it should return an array of the IDs.
     *
     * @return array
     */
    public function categories(): array
    {
        // check if categories were submitted, it not return an empty array
        if (!$this->get('category') || !is_array($this->get('category'))) {
            return [];
        }

        // check they are valid, return the IDs
        // limit to 1000 ... just in case someone submits with too many for the web server.
        // No error is given if they submit more than 1k.
        // TODO move to repo calls
        return Category::whereIn('id', array_keys($this->get('category')))
            ->select('id')
            ->limit(1000)
            ->get()
            ->pluck('id')
            ->toArray();
    }

    /**
     * Get the image size $size.
     *
     * If it does not exist, try and find an alternative uploaded image in a different size.
     *
     * @param $size
     *
     * @return UploadedFile|null
     */
    public function getImageSize($size): ?UploadedFile
    {
        if ($this->file($size)) {
            return $this->file($size);
        }

        // not found? lets cycle through all the images and see if anything was submitted, and use that instead
        foreach (config('blogetc.image_sizes') as $image_size_name => $image_size_info) {
            if ($this->file($image_size_name)) {
                return $this->file($image_size_name);
            }
        }

        return null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        if ($this->method() === Request::METHOD_DELETE) {
            // No rules are required for deleting.
            return [];
        }

        $rules = $this->sharedRules();

        if ($this->method() === Request::METHOD_POST) {
            $rules['slug'][] = Rule::unique('blog_etc_posts', 'slug');
        }

        if (in_array($this->method(), [Request::METHOD_PATCH, Request::METHOD_PUT], true)) {
            $rules['slug'][] = Rule::unique('blog_etc_posts', 'slug')
                ->ignore($this->route()->parameter('blogPostID'));
        }

        return $rules;
    }

    /**
     * Shared rules for blog posts.
     *
     * @return array
     *
     * @todo - Refactor! This is a mess.
     */
    protected function sharedRules(): array
    {
        // setup some anon functions for some of the validation rules:
        $checkValidPostedAt = static function ($attribute, $value, $fail) {
            // just the 'date' validation can cause errors ("2018-01-01 a" passes
            // the validation, but causes a carbon error).
            try {
                Carbon::createFromFormat('Y-m-d H:i:s', $value);
            } catch (Exception $e) {
                // return $fail if Carbon could not successfully create a date from $value
                return $fail('Posted at is not a valid date');
            }
        };

        $showErrorIfHasValue = static function ($attribute, $value, $fail) {
            if ($value) {
                // return $fail if this had a value...
                return $fail($attribute.' must be empty');
            }
        };

        $disabledUseViewFile = static function ($attribute, $value, $fail) {
            if ($value) {
                // return $fail if this had a value
                return $fail('The use of custom view files is not enabled for this site, so you cannot submit a value for it');
            }
        };

        // generate the main set of rules:
        $return = [
            'posted_at' => ['nullable', $checkValidPostedAt],
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'subtitle' => ['nullable', 'string', 'min:1', 'max:255'],
            'post_body' => ['required_without:use_view_file', 'max:2000000'], //medium text
            'meta_desc' => ['nullable', 'string', 'min:1', 'max:1000'],
            'short_description' => ['nullable', 'string', 'max:30000'],
            'slug' => [
                'nullable',
                'string',
                'min:1',
                'max:150',
                'alpha_dash', // this field should have some additional rules, which is done in the subclasses.
            ],
            'category' => [
                'nullable',
                'array',
                static function ($attribute, $value, $fail) {
                    foreach (array_keys((array) $value) as $categoryID) {
                        if (Category::where('id', $categoryID)->exists() === false) {
                            $fail($attribute.' is not a valid category id');
                        }
                    }
                },
            ],
        ];

        // is use_custom_view_files true?
        if (config('blogetc.use_custom_view_files')) {
            $return['use_view_file'] = ['nullable', 'string', 'alpha_num', 'min:1', 'max:75'];
        } else {
            // use_view_file is disabled, so give an empty if anything is submitted via this function:
            $return['use_view_file'] = ['string', $disabledUseViewFile];
        }

        // some additional rules for uploaded images
        foreach ((array) config('blogetc.image_sizes') as $size => $image_detail) {
            if ($image_detail['enabled'] && config('blogetc.image_upload_enabled')) {
                $return[$size] = ['nullable', 'image'];
            } else {
                // was not enabled (or all images are disabled), so show an error if it was submitted:
                $return[$size] = $showErrorIfHasValue;
            }
        }

        return $return;
    }

    /**
     * @param $size
     *
     * @return UploadedFile|null
     *
     * @deprecated - use getImageSize() instead
     */
    public function get_image_file($size): ?UploadedFile
    {
        return $this->getImageFile($size);
    }
}
