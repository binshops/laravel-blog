<?php

namespace WebDevEtc\BlogEtc\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use WebDevEtc\BlogEtc\Exceptions\PostNotFoundException;
use WebDevEtc\BlogEtc\Models\Post;

/**
 * Class BlogEtcPostsRepository.
 */
class PostsRepository
{
    /**
     * @var Post
     */
    private $model;

    /**
     * BlogEtcPostsRepository constructor.
     *
     * @param Post $model
     */
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    /**
     * Return blog posts ordered by posted_at, paginated.
     *
     * @param int $perPage
     * @param int $categoryID
     *
     * @return LengthAwarePaginator
     */
    public function indexPaginated(int $perPage = 10, int $categoryID = null): LengthAwarePaginator
    {
        $query = $this->query(true)
            ->orderBy('posted_at', 'desc');

        if ($categoryID) {
            $query->whereHas('categories', function (Builder $query) use ($categoryID) {
                $query->where('blog_etc_post_categories.blog_etc_category_id', $categoryID);
            })->get();
        }

        return $query->paginate($perPage);
    }

    /**
     * Return posts for RSS feed.
     *
     * @return Builder[]|Collection
     */
    public function rssItems(): Collection
    {
        return $this->query(false)
            ->orderBy('posted_at', 'desc')
            ->limit(config('blogetc.rssfeed.posts_to_show_in_rss_feed'))
            ->with('author')
            ->get();
    }

    /**
     * Return new instance of the Query Builder for this model.
     *
     * @param bool $eagerLoad
     *
     * @return Builder
     */
    public function query(bool $eagerLoad = false): Builder
    {
        $queryBuilder = $this->model->newQuery();

        if ($eagerLoad === true) {
            // eager load the categories relationship.
            // Comments probably don't need to be loaded for most queries.
            $queryBuilder->with(['categories']);
        }

        return $queryBuilder;
    }

    /**
     * Find a blog etc post by ID
     * If cannot find, throw exception.
     *
     * @param int $blogEtcPostID
     *
     * @return Post
     */
    public function find(int $blogEtcPostID): Post
    {
        try {
            return $this->query(true)->findOrFail($blogEtcPostID);
        } catch (ModelNotFoundException $e) {
            throw new PostNotFoundException('Unable to find blog post with ID: '.$blogEtcPostID);
        }
    }

    /**
     * Find a blog etc post by ID
     * If cannot find, throw exception.
     *
     * @param string $slug
     *
     * @return Post
     */
    public function findBySlug(string $slug): Post
    {
        try {
            // the published_at + is_published are handled by BlogEtcPublishedScope, and don't take effect if the
            // logged in user can manage log posts
            return $this->query(true)
                ->where('slug', $slug)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new PostNotFoundException('Unable to find blog post with slug: '.$slug);
        }
    }

    /**
     * Create a new BlogEtcPost post.
     *
     * @param array $attributes
     *
     * @return Post
     */
    public function create(array $attributes): Post
    {
        return $this->query()->create($attributes);
    }

    /**
     * Delete a post.
     *
     * @param int $postID
     * @return bool
     * @throws Exception
     */
    public function delete(int $postID): bool
    {
        $post = $this->find($postID);

        return $post->delete();
    }

    /**
     * Update image sizes (or in theory any attribute) on a blog etc post.
     *
     * @param Post $post
     * @param array $uploadedImages
     *
     * @return Post
     */
    public function updateImageSizes(Post $post, ?array $uploadedImages): Post
    {
        if ($uploadedImages && count($uploadedImages)) {
            // does not use update() here as it would require fillable for each field - and in theory someone
            // might want to add more image sizes.
            foreach ($uploadedImages as $size => $imageName) {
                $post->$size = $imageName;
            }
            $post->save();
        }

        return $post;
    }

    /**
     * Search for posts.
     *
     * This is a rough implementation - proper full text search has been removed in current version.
     *
     * @param string $query
     * @param int $max
     * @return Collection
     */
    public function search(string $query, int $max = 25): Collection
    {
        return $this->query(true)
            ->where('title', 'like', '%'.$query)
            ->limit($max)
            ->get();
    }
}
