<?php

namespace WebDevEtc\BlogEtc\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use WebDevEtc\BlogEtc\Exceptions\CommentNotFoundException;
use WebDevEtc\BlogEtc\Models\Comment;
use WebDevEtc\BlogEtc\Models\Post;

class CommentsRepository
{
    /**
     * @var Comment
     */
    private $model;

    /**
     * BlogEtcCommentsRepository constructor.
     *
     * @param Comment $model
     */
    public function __construct(Comment $model)
    {
        $this->model = $model;
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
            $queryBuilder->with('post');
        }

        return $queryBuilder;
    }

    /**
     * Find and return a comment by ID.
     *
     * If $onlyApproved is true, then it will only return an approved comment
     * If it is false then it can return it even if not yet approved
     *
     * @param int $blogEtcCommentID
     * @param bool $onlyApproved
     *
     * @return Comment
     */
    public function find(int $blogEtcCommentID, bool $onlyApproved = true): Comment
    {
        try {
            $queryBuilder = $this->query(true);

            if (!$onlyApproved) {
                $queryBuilder->withoutGlobalScopes();
            }

            return $queryBuilder->findOrFail($blogEtcCommentID);
        } catch (ModelNotFoundException $e) {
            throw new CommentNotFoundException('Unable to find blog post comment with ID: '.$blogEtcCommentID);
        }
    }

    /**
     * Approve a blog comment.
     *
     * @param int $blogCommentID
     *
     * @return Comment
     */
    public function approve(int $blogCommentID): Comment
    {
        // get comment
        $comment = $this->find($blogCommentID, false);

        // mark as approved
        $comment->approved = true;

        // save changes
        $comment->save();

        // return comment
        return $comment;
    }

    /**
     * Create a comment.
     *
     * @param Post $post
     * @param array $attributes
     * @param string|null $ip
     * @param string|null $authorWebsite
     * @param string|null $authorEmail
     * @param int|null $userID
     * @param bool $autoApproved
     * @return Comment
     */
    public function create(
        Post $post,
        array $attributes,
        string $ip = null,
        string $authorWebsite = null,
        string $authorEmail = null,
        int $userID = null,
        bool $autoApproved = false
    ): Comment {
        // TODO - inject the model object, put into repo, generate $attributes
        // fill it with fillable attributes
        $newComment = new Comment($attributes);

        // Set non fillable attributes from method params.
        $newComment->ip = $ip;
        $newComment->author_website = $authorWebsite;
        $newComment->author_email = $authorEmail;
        $newComment->user_id = $userID;
        $newComment->approved = $autoApproved;

        // Store and associate to the post.
        $post->comments()->save($newComment);

        return $newComment;
    }
}
