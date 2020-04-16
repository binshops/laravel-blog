<?php

namespace WebDevEtc\BlogEtc\Tests\Feature\Admin;

use Illuminate\Foundation\Testing\WithFaker;
use WebDevEtc\BlogEtc\Models\Category;
use WebDevEtc\BlogEtc\Tests\TestCase;

class ManageCategoriesControllerTest extends TestCase
{
    use WithFaker;

    /**
     * Setup the feature test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->featureSetUp();
    }

    /**
     * Test that users passing the admin gate can access the admin index.
     *
     * These authentication tests are only done on the single index route as they should all be caught by
     * the 'can:blog-etc-admin' middleware on the admin group.
     *
     * (Via gate)
     */
    public function testAdminUsersCanAccess(): void
    {
        $this->beAdminUser();

        $response = $this->get(route('blogetc.admin.categories.index'));

        $response->assertOk();
    }

    /**
     * Assert that the index admin page is not accessible for guests.
     * (Via gate).
     */
    public function testForbiddenToNonAdminUsers(): void
    {
        $this->beNonAdminUser();

        $response = $this->get(route('blogetc.admin.categories.index'));

        $response->assertForbidden();
    }

    /**
     * Assert that the index admin page is not accessible for guests.
     * (Via auth middleware).
     */
    public function testForbiddenToGuests(): void
    {
        $response = $this->get(route('blogetc.admin.categories.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test admin index page lists categories.
     */
    public function testIndexIncludesRecentCategory(): void
    {
        $category = factory(Category::class)->create();

        $this->beAdminUser();

        $response = $this->get(route('blogetc.admin.categories.index'));

        $response->assertSee($category->title);
        $response->assertViewHas('categories');
    }

    /**
     * Test the create form is displayed.
     */
    public function testCreateForm(): void
    {
        $this->beAdminUser();
        $response = $this->get(route('blogetc.admin.categories.create_category'));
        $response->assertOk();
    }

    /**
     * Test that new blog categories can be stored.
     */
    public function testStore(): void
    {
        $this->beAdminUser();

        $params = [
            'category_name' => $this->faker->sentence,
            'slug' => $this->faker->lexify('???????'),
            'category_description' => $this->faker->sentence,
        ];

        $response = $this->post(route('blogetc.admin.categories.store_category'), $params);

        $response->assertRedirect()->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('blog_etc_categories', $params);
    }

    /**
     * Test the edit form.
     */
    public function testEdit(): void
    {
        $this->beAdminUser();

        $category = factory(Category::class)->create();

        $response = $this->get(route('blogetc.admin.categories.edit_category', $category));

        $response->assertOk()->assertSee($category->title);
    }

    /**
     * Test that trying to edit an invalid Category does not work.
     */
    public function testEditInvalidCategory(): void
    {
        $this->beAdminUser();

        $invalidID = 9999;

        $response = $this->get(route('blogetc.admin.categories.edit_category', $invalidID));

        $response->assertNotFound();
    }

    /**
     * Test can delete a category.
     */
    public function testDestroy(): void
    {
        $this->beAdminUser();

        $category = factory(Category::class)->create();

        $response = $this->delete(route('blogetc.admin.categories.destroy_category', $category));

        $response->assertOk()->assertViewIs('blogetc_admin::categories.deleted_category');

        $this->assertDatabaseMissing('blog_etc_categories', ['id' => $category->id]);
    }

    /**
     * Test 404 response when deleting invalid category ID.
     */
    public function testDestroyInvalidCategoryID(): void
    {
        $this->beAdminUser();

        $invalidCategoryID = 999;
        $response = $this->delete(route('blogetc.admin.categories.destroy_category', $invalidCategoryID));

        $response->assertNotFound();
    }

    /**
     * Test can update a category.
     */
    public function testUpdate(): void
    {
        $this->beAdminUser();

        $category = factory(Category::class)->create();

        $params = $category->toArray();

        // Update category name.
        $params['category_name'] = $this->faker->sentence;

        $response = $this->patch(route('blogetc.admin.categories.update_category', $category), $params);

        $response->assertSessionHasNoErrors()->assertRedirect();

        $this->assertDatabaseHas('blog_etc_categories', ['category_name' => $params['category_name']]);
    }

    /**
     * Test trying to update a category which does not exist gives a 404 response.
     */
    public function testUpdateInvalidCategoryID(): void
    {
        $invalidCategoryID = 10000;
        $this->beAdminUser();

        $params = factory(Category::class)->make()->toArray();

        $response = $this->patch(route('blogetc.admin.categories.update_category', $invalidCategoryID), $params);

        $response->assertNotFound();
    }
}
