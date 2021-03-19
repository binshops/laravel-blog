<?php

namespace BinshopsBlog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BinshopsBlog\Events\CommentApproved;
use BinshopsBlog\Events\CommentWillBeDeleted;
use BinshopsBlog\Helpers;
use BinshopsBlog\Middleware\LoadLanguage;
use BinshopsBlog\Middleware\UserCanManageBlogPosts;
use BinshopsBlog\Models\BinshopsComment;

/**
 * Class BinshopsCommentsAdminController
 * @package BinshopsBlog\Controllers
 */
class BinshopsCommentsAdminController extends Controller
{
    /**
     * BinshopsCommentsAdminController constructor.
     */
    public function __construct()
    {
        $this->middleware(UserCanManageBlogPosts::class);
        $this->middleware(LoadLanguage::class);

    }

    /**
     * Show all comments (and show buttons with approve/delete)
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $comments = BinshopsComment::withoutGlobalScopes()->orderBy("created_at", "desc")
            ->with("post");

        if ($request->get("waiting_for_approval")) {
            $comments->where("approved", false);
        }

        $comments = $comments->paginate(100);
        return view("binshopsblog_admin::comments.index")
            ->withComments($comments
            );
    }


    /**
     * Approve a comment
     *
     * @param $blogCommentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($blogCommentId)
    {
        $comment = BinshopsComment::withoutGlobalScopes()->findOrFail($blogCommentId);
        $comment->approved = true;
        $comment->save();

        Helpers::flash_message("Approved!");
        event(new CommentApproved($comment));

        return back();

    }

    /**
     * Delete a submitted comment
     *
     * @param $blogCommentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($blogCommentId)
    {
        $comment = BinshopsComment::withoutGlobalScopes()->findOrFail($blogCommentId);
        event(new CommentWillBeDeleted($comment));

        $comment->delete();

        Helpers::flash_message("Deleted!");
        return back();
    }


}
