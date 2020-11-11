<?php


namespace WebDevEtc\BlogEtc\Models;

use Illuminate\Database\Eloquent\Model;

class HessamCategoryTranslation extends Model
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
        return $this->belongsTo(HessamCategory::class, 'category_id');
    }

    /**
     * The associated Language
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function language()
    {
        return $this->hasOne(HessamLanguage::class,"lang_id");
    }

    /**
     * Returns the public facing URL of showing blog posts in this category
     * @return string
     */
    public function url($loacle)
    {
        $theChainString = "";
        $cat = $this->category()->get();
        $chain = $cat[0]->getAncestorsAndSelf();
        foreach ($chain as $category){
            $theChainString .=  "/" . $category->categoryTranslations()->where('lang_id' , $this->lang_id)->first()->slug;
        }
        return route("blogetc.view_category",[$loacle, $theChainString]);
    }

    /**
     * Returns the URL for an admin user to edit this category
     * @return string
     */
    public function edit_url()
    {
        return route("blogetc.admin.categories.edit_category", $this->category_id);
    }
}
