<?php

namespace WebDevEtc\BlogEtc\Tests\Unit;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use WebDevEtc\BlogEtc\Events\BlogPostEdited;
use WebDevEtc\BlogEtc\Events\BlogPostWillBeDeleted;
use WebDevEtc\BlogEtc\Models\Post;
use WebDevEtc\BlogEtc\Repositories\PostsRepository;
use WebDevEtc\BlogEtc\Requests\PostRequest;
use WebDevEtc\BlogEtc\Services\PostsService;
use WebDevEtc\BlogEtc\Services\UploadsService;
use WebDevEtc\BlogEtc\Tests\TestCase;

/**
 * Class PostsServiceTest.
 *
 * Unit test for PostsService.
 *
 * Should be quick to run, mock any DB calls.
 */
class PostsServiceTest extends TestCase
{
    use WithFaker;

    /**
     * Set up for all tests.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Disable image uploads for these tests.
        config(['blogetc' => ['image_upload_enabled' => false]]);
    }

    /**
     * Test that the repository() method will return an instance of PostsRepository.
     */
    public function testRepository(): void
    {
        $mock = $this->mock(PostsRepository::class);

        $service = resolve(PostsService::class);

        $repository = $service->repository();

        $this->assertSame($mock, $repository);
    }

    /**
     * Test that calling create will call the correct method on the PostsRepository.
     * We can assume the repo creates the database entry.
     */
    public function testCreate(): void
    {
        // Mock the repository:
        $this->mock(PostsRepository::class, static function ($mock) {
            // Test that it is called exactly once:
            $mock->shouldReceive('create')->once();
        });

        // Instanciate service, the mocked repo will be injected:
        $service = resolve(PostsService::class);

        // Not testing the request, just mock it and what it returns.
        $request = $this->createRequest($this->createParams());

        // Call the service method (assets are done above).
        $service->create($request, null);
    }

    /**
     * Test that indexPaginated calls the correct repository method.
     */
    public function testIndexPaginated(): void
    {
        $this->mock(PostsRepository::class, static function ($mock) {
            // test that is calls repo correctly:
            $mock->shouldReceive('indexPaginated')->once();
        });

        $service = resolve(PostsService::class);

        $service->indexPaginated();
    }

    /**
     * Test that findBySlug calls the correct repository method.
     */
    public function testFindBySlug(): void
    {
        $this->mock(PostsRepository::class, static function ($mock) {
            // test that is calls repo correctly:
            $mock->shouldReceive('findBySlug')->once();
        });

        $service = resolve(PostsService::class);

        $service->findBySlug('test');
    }

    /**
     * Test that rssItems calls the correct repository method.
     */
    public function testRssItems(): void
    {
        $this->mock(PostsRepository::class, static function ($mock) {
            // test that is calls repo correctly:
            $mock->shouldReceive('rssItems')->once();
        });

        $service = resolve(PostsService::class);

        $service->rssItems();
    }

    /**
     * Test that the update method calls the correct repo calls.
     *
     * The update() method works directly on the Eloquent model - this should be refactored.
     */
    public function testUpdate(): void
    {
        $belongsToMany = $this->mock(BelongsToMany::class, static function ($mock) {
            $mock->shouldReceive('sync');
        });

        $mockedModel = $this->mock(Post::class, static function ($mock) use ($belongsToMany) {
            $mock->shouldReceive('fill')->once();
            $mock->shouldReceive('save')->once();
            $mock->shouldReceive('categories')->andReturn($belongsToMany);
        });

        // Mock the repository:
        $this->mock(PostsRepository::class, static function ($mock) use ($mockedModel) {
            // Test that it is called exactly once:
            $mock->shouldReceive('find')->once()->andReturn($mockedModel);
        });

        $this->mock(UploadsService::class, static function ($mock) {
            $mock->shouldReceive('processFeaturedUpload')->once();
        });

        // Instanciate service, the mocked repo will be injected:
        $service = resolve(PostsService::class);

        $request = $this->createRequest($this->createParams());

        $this->expectsEvents(BlogPostEdited::class);

        // Call the service method (assets are done above).
        $service->update(1, $request);
    }

    /**
     * Test the delete() service call.
     *
     * @throws Exception
     */
    public function testDelete(): void
    {
        $this->mock(PostsRepository::class, static function ($mock) {
            $mock->shouldReceive('find')->with(123)->andReturn(new Post());
            $mock->shouldReceive('delete')->with(123)->andReturn(true);
        });

        $service = resolve(PostsService::class);

        $this->expectsEvents(BlogPostWillBeDeleted::class);

        $response = $service->delete(123);

        $this->assertIsArray($response);
    }

    /**
     * Helper method to set up the params for editing/creating.
     *
     * @return array
     */
    private function createParams(): array
    {
        return [
            'posted_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'title' => $this->faker->sentence,
            'subtitle' => $this->faker->sentence,
            'post_body' => $this->faker->paragraph,
            'meta_desc' => $this->faker->paragraph,
            'short_description' => $this->faker->paragraph,
            'slug' => $this->faker->asciify('*********'),
            'categories' => null,
        ];
    }

    /**
     * @param array $params
     * @return PostRequest
     */
    public function createRequest(array $params): PostRequest
    {
        // Not testing the request, just mock it and what it returns.
        $mockedValidator = $this->mock(Validator::class, static function ($mock) use ($params) {
            $mock->shouldReceive('validated')->andReturn($params);
        });

        $request = PostRequest::create('/posts/add', Request::METHOD_POST, $params);

        return tap($request)->setValidator($mockedValidator);
    }
}
