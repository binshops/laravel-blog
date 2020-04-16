<?php

namespace WebDevEtc\BlogEtc\Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use WebDevEtc\BlogEtc\Models\Post;
use WebDevEtc\BlogEtc\Services\CommentsService;
use WebDevEtc\BlogEtc\Tests\TestCase;

/**
 * Class PostsControllerTest.
 *
 * Test the comments controller.
 *
 * @todo: Add more tests (different comment providers, captcha, logged in/logged out users, config options).
 */
class CommentsControllerTest extends TestCase
{
    use WithFaker;

    /**
     * Setup the feature test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->featureSetUp();

        // Built in (database) comments by default):
        config(['blogetc.comments.type_of_comments_to_show' => CommentsService::COMMENT_TYPE_BUILT_IN]);
        // Auto approve comments by default:
        config(['blogetc.comments.auto_approve_comments' => true]);
        // Disable captcha by default:
        config(['blogetc.captcha.captcha_enabled' => false]);
    }

    /**
     * Test the store method for saving a new comment.
     */
    public function testStore(): void
    {
        $post = factory(Post::class)->create();

        $url = route('blogetc.comments.add_new_comment', $post->slug);

        $params = [
            'comment' => $this->faker->sentence,
            'author_name' => $this->faker->name,
            'author_email' => $this->faker->safeEmail,
            'author_website' => 'http://'.$this->faker->safeEmailDomain,
        ];

        $response = $this->postJson($url, $params);

        $response->assertCreated();

        // Test can see the comment on the post page and therefore saved in the database.
        $this->withoutExceptionHandling();
        $postResponse = $this->get(route('blogetc.show', $post->slug));
        $postResponse->assertSee($params['comment']);
    }

    /**
     * Test the store method for saving a new comment.
     */
    public function testDisabledCommentsStore(): void
    {
        // Disable comments:
        config(['blogetc.comments.type_of_comments_to_show' => CommentsService::COMMENT_TYPE_DISABLED]);

        $post = factory(Post::class)->create();

        $url = route('blogetc.comments.add_new_comment', $post->slug);

        $params = [
            'comment' => $this->faker->sentence,
            'author_name' => $this->faker->name,
            'author_email' => $this->faker->safeEmail,
            'author_website' => 'http://'.$this->faker->safeEmailDomain,
        ];

        $response = $this->postJson($url, $params);

        $response->assertForbidden();

        // Assert was not written to db:
        $this->assertDatabaseMissing('blog_etc_comments', ['comment' => $params['comment']]);
    }
}
