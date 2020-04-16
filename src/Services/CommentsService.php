<?php

namespace WebDevEtc\BlogEtc\Services;

use Exception;
use WebDevEtc\BlogEtc\Events\CommentAdded;
use WebDevEtc\BlogEtc\Events\CommentApproved;
use WebDevEtc\BlogEtc\Events\CommentWillBeDeleted;
use WebDevEtc\BlogEtc\Models\Comment;
use WebDevEtc\BlogEtc\Models\Post;
use WebDevEtc\BlogEtc\Repositories\CommentsRepository;

/**
 * Class BlogEtcCategoriesService.
 *
 * Service class to handle most logic relating to Comment entries.
 */
class CommentsService
{
    // comment system types. Set these in config file
    public const COMMENT_TYPE_BUILT_IN = 'built_in';
    public const COMMENT_TYPE_DISQUS = 'disqus';
    public const COMMENT_TYPE_CUSTOM = 'custom';
    public const COMMENT_TYPE_DISABLED = 'disabled';

    /** @var CommentsRepository */
    private $repository;

    /**
     * CommentsService constructor.
     *
     * @param CommentsRepository $repository
     */
    public function __construct(CommentsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * BlogEtcCategoriesRepository repository - for query heavy method.
     *
     * I don't stick 100% to all queries belonging in the repo - some Eloquent
     * things are fine to have in the service where it makes sense.
     */
    public function repository(): CommentsRepository
    {
        return $this->repository;
    }

    /**
     * Create a new comment.
     *
     * @param Post $blogEtcPost
     * @param array $attributes
     * @param string|null $ip
     * @param int|null $userID
     *
     * @return Comment
     */
    public function create(
        Post $blogEtcPost,
        array $attributes,
        string $ip = null,
        int $userID = null
    ): Comment {
        // Store in db. Most things are fillable, but some must be explicitly set (such as storing IP etc).

        // Should IP be stored?
        $ip = config('blogetc.comments.save_ip_address')
            ? $ip : null;

        // Should website be stored?
        $authorWebsite = config('blogetc.comments.ask_for_author_website') && !empty($attributes['author_website'])
            ? $attributes['author_website']
            : null;

        // Should email be stored?
        $authorEmail = config('blogetc.comments.ask_for_author_website') && !empty($attributes['author_email'])
            ? $attributes['author_email']
            : null;

        // Should user ID be stored?
        $userID = config('blogetc.comments.save_user_id_if_logged_in')
            ? $userID
            : null;

        // Are new comments auto approved?
        $approved = $this->autoApproved();

        $newComment = $this->repository->create(
            $blogEtcPost,
            $attributes,
            $ip,
            $authorWebsite,
            $authorEmail,
            $userID,
            $approved
        );

        // Fire event:
        event(new CommentAdded($blogEtcPost, $newComment));

        // return comment:
        return $newComment;
    }

    /**
     * Are comments auto approved?
     *
     * @return bool
     */
    protected function autoApproved(): bool
    {
        return config('blogetc.comments.auto_approve_comments', true) === true;
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
        $comment = $this->repository->approve($blogCommentID);

        // fire event
        event(new CommentApproved($comment));

        // return comment
        return $comment;
    }

    /**
     * Find and return a comment by ID.
     *
     * @param int $blogEtcCommentID
     * @param bool $onlyApproved
     *
     * @return Comment
     */
    public function find(int $blogEtcCommentID, bool $onlyApproved = true): Comment
    {
        return $this->repository->find($blogEtcCommentID, $onlyApproved);
    }

    /**
     * Delete a blog comment.
     *
     * Returns the now deleted comment object
     *
     * @param int $blogCommentID
     *
     * @return Comment
     * @throws Exception
     */
    public function delete(int $blogCommentID): Comment
    {
        // find the comment
        $comment = $this->find($blogCommentID, false);

        // fire event
        event(new CommentWillBeDeleted($comment));

        // delete it
        $comment->delete();

        // return deleted comment
        return $comment;
    }
}
