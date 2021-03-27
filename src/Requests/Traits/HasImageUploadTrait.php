<?php namespace BinshopsBlog\Requests\Traits;



trait HasImageUploadTrait
{
    /**
     * @param $size
     * @return \Illuminate\Http\UploadedFile|null
     */
    public function get_image_file($size)
    {

        if ($this->file($size)) {
            return $this->file($size);
        }

        // not found? lets cycle through all the images and see if anything was submitted, and use that instead
        foreach (config("binshopsblog.image_sizes") as $image_size_name => $image_size_info) {
            if ($this->file($image_size_name)) {
                return $this->file($image_size_name);
            }
        }

        return null;


    }

}