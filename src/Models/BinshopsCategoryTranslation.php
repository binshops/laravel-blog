<?php


namespace BinshopsBlog\Models;

use Illuminate\Database\Eloquent\Model;

class BinshopsCategoryTranslation extends Model
{

    public $fillable = [
        'category_id',
        'category_name',
        'slug',
        'category_description',
        'lang_id'
    ];

    /**
     * Get the category that owns the phone.
     */
    public function category()
    {
        return $this->belongsTo(BinshopsCategory::class, 'category_id');
    }

    /**
     * The associated Language
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function language()
    {
        return $this->hasOne(BinshopsLanguage::class,"id");
    }

    /**
     * Returns the public facing URL of showing blog posts in this category
     * @return string
     */
    public function url()
    {
        $theChainString = "";
        $cat = $this->category()->get();
        $chain = $cat[0]->getAncestorsAndSelf();
        foreach ($chain as $category){
            $theChainString .=  "/" . $category->categoryTranslations()->where('lang_id' , $this->lang_id)->first()->slug;
        }
        return route("binshopsblog.view_category",[$theChainString]);
    }

    /**
     * Returns the URL for an admin user to edit this category
     * @return string
     */
    public function edit_url()
    {
        return route("binshopsblog.admin.categories.edit_category", $this->category_id);
    }
}
