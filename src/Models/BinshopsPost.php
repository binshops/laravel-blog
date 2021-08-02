<?php

namespace BinshopsBlog\Models;

use Illuminate\Database\Eloquent\Model;
use BinshopsBlog\Scopes\BinshopsBlogPublishedScope;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class BinshopsPost
 * @package BinshopsBlog\Models
 */
class BinshopsPost extends Model
{
    public $fields;

    /**
     * @var array
     */
    public $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * @var array
     */
    public $dates = [
        'posted_at'
    ];

    /**
     * @var array
     */
    public $fillable = [
        'is_published',
        'posted_at',
    ];

    /**
     * The associated post translations
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function postTranslations()
    {
        return $this->hasMany(BinshopsPostTranslation::class, "post_id");
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        /* If user is logged in and \Auth::user()->canManageBinshopsBlogPosts() == true, show any/all posts.
           otherwise (which will be for most users) it should only show published posts that have a posted_at
           time <= Carbon::now(). This sets it up: */
        static::addGlobalScope(new BinshopsBlogPublishedScope());

        static::deleting(function ($post) { // before delete() method call this
            $post->postTranslations()->delete();
        });
    }

    /**
     * The associated author (if user_id) is set
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(config("binshopsblog.user_model"), 'user_id');
    }

    /**
     * Return author string (either from the User (via ->user_id), or the submitted author_name value
     * @return string
     */
    public function author_string()
    {
        if ($this->author) {
            return optional($this->author)->name;
        } else {
            return 'Unknown Author';
        }
    }

    /**
     * The associated categories for this blog post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(BinshopsCategory::class, 'binshops_post_categories', 'post_id', 'category_id');
    }

    /**
     * Comments for this post
     *
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(BinshopsComment::class, 'post_id');
    }

    /**
     * @return HasMany
     */
    public function fieldValues()
    {
        return $this->hasMany(BinshopsFieldValue::class, 'post_id');
    }

    /**
     * @param $fieldId
     * @return HasMany
     */
    public function fieldValue($fieldId)
    {
        $value = $this->fieldValues()
            ->where('field_id', $fieldId);

        if ($value->exists()) {
            return $value->first()->value;
        }
        return;
    }

    public function loadFields()
    {
        $this->fields = $this->fieldsAvailable();
    }

    /**
     * @return mixed
     */
    public function fieldsAvailable()
    {
        // First get all the fields that doesn't have any categories.
        $fieldsNocategorie = BinshopsField::doesntHave('categories')->get();
        // Get all the categories which are attached to this post
        $categories = $this->categories()->pluck('category_id')->toArray();
        // Get the fields which have the same categories selected as current post
        $fieldsOverlappingCategories = BinshopsField::whereHas('categories', function ($querry) use ($categories) {
            $querry->whereIn('binshops_categories.id', $categories);
        })->get();

        return $fieldsNocategorie->merge($fieldsOverlappingCategories);
    }

    /**
     * @param $fieldsValues
     */
    public function updateFieldValues($fieldsValues)
    {
        foreach ($this->fields as $field) {
            if (!in_array($field->name, $fieldsValues)) {
                BinshopsFieldValue::updateOrCreate(
                    [
                    'field_id' => $field->id,
                    'post_id' => $this->id],
                    ['value' => $fieldsValues[$field->name]]
                );
            }

            $field->values()->where('post_id', $this->id)->first();
        }
    }
}
