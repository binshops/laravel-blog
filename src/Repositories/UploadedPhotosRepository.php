<?php

namespace WebDevEtc\BlogEtc\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use WebDevEtc\BlogEtc\Exceptions\PostNotFoundException;
use WebDevEtc\BlogEtc\Models\Post;
use WebDevEtc\BlogEtc\Models\UploadedPhoto;

class UploadedPhotosRepository
{
    /**
     * @var Post
     */
    private $model;

    /**
     * Constructor.
     *
     * @param UploadedPhoto $model
     */
    public function __construct(UploadedPhoto $model)
    {
        $this->model = $model;
    }

    /**
     * Return new instance of the Query Builder for this model.
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Find a blog etc uploaded photo by ID.
     *
     * If cannot find, throw exception.
     *
     * @param int $uploadedPhotoID
     *
     * @return UploadedPhoto
     */
    public function find(int $uploadedPhotoID): UploadedPhoto
    {
        try {
            return $this->query()
                ->findOrFail($uploadedPhotoID);
        } catch (ModelNotFoundException $e) {
            throw new PostNotFoundException('Unable to find Uploaded Photo with ID: '.$uploadedPhotoID);
        }
    }

    /**
     * Create a new Uploaded Photo row in the database.
     *
     * @param array $attributes
     *
     * @return UploadedPhoto
     */
    public function create(array $attributes): UploadedPhoto
    {
        return $this->query()->create($attributes);
    }

    /**
     * Delete a uploaded photo from the database.
     *
     * @param int $uploadedPhotoID
     * @return bool
     * @throws Exception
     */
    public function delete(int $uploadedPhotoID): bool
    {
        $post = $this->find($uploadedPhotoID);

        return $post->delete();
    }
}
