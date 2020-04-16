<?php

namespace WebDevEtc\BlogEtc\Tests;

use App\User;
use Gate;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Schema;
use Laravelium\Feed\FeedServiceProvider;
use Orchestra\Testbench\Database\MigrateProcessor;
use Orchestra\Testbench\TestCase as BaseTestCase;
use View;
use WebDevEtc\BlogEtc\BlogEtcServiceProvider;

/**
 * Class TestCase.
 */
abstract class TestCase extends BaseTestCase
{
    /**
     * As this package does not include layouts.app, it is easier to just mock the whole View part, and concentrate
     * only on the package code in the controller. Would be interested if anyone has a suggestion on better way
     * to test this.
     *
     * @param string $expectedView
     * @param array $viewArgumentTypes
     * @deprecated - not in use. todo: remove
     */
    protected function mockView(string $expectedView, array $viewArgumentTypes): void
    {
        // Mocked view to return:
        $mockedReturnedView = $this->mock(\Illuminate\View\View::class);
        $mockedReturnedView->shouldReceive('render');

        // Mock the main view() calls in controller.
        $mockedView = View::shouldReceive('share')
            ->once()
            ->shouldReceive('make')
            ->once();

        $mockedView = call_user_func_array([$mockedView, 'with'], array_merge([$expectedView], $viewArgumentTypes));

        $mockedView->andReturn($mockedReturnedView)
            ->shouldReceive('exists')
            ->shouldReceive('replaceNamespace');
    }

    /**
     * Used for Orchestra\Testbench package.
     *
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            // Main BlogEtc service provider:
            BlogEtcServiceProvider::class,

            // Feed service provider (for RSS feed)
            FeedServiceProvider::class,
        ];
    }

    /**
     * Set up for feature tests (migrations).
     */
    protected function featureSetUp(): void
    {
        $this->loadMigrations();
        $this->withFactories(__DIR__.'/../src/Factories');

        if (!\Route::has('login')) {
            // Need to define a login route for feature tests.
            \Route::get('login', function () {
            })->name('login');
        }
    }

    /**
     * Load migrations - to be used for feature tests.
     *
     * @return void
     */
    protected function loadMigrations(): void
    {
        $paths = [
            __DIR__.'/../migrations',
        ];

        foreach ($paths as $path) {
            $options = ['--path' => $path];
            $options['--realpath'] = true;

            $migrator = new MigrateProcessor($this, $options);
            $migrator->up();
        }

        // Also manually create users table so relations will work.
        if (!Schema::hasTable('users')) {
            Schema::create('users', static function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        $this->resetApplicationArtisanCommands($this->app);
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Add the custom dir for layouts.app view:
        $app['view']->addLocation(__DIR__.'/views');

        // ensure app.key is set.
        $app['config']->set('app.key', base64_decode('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'));

        // Use the default config for this package:
        $app['config']->set('blogetc', include(__DIR__.'/../src/Config/blogetc.php'));

        // Ensure has correct 'sluggable' config set up:
        $app['config']->set('sluggable', [
            'source' => null,
            'maxLength' => null,
            'maxLengthKeepWords' => true,
            'method' => null,
            'separator' => '-',
            'unique' => true,
            'uniqueSuffix' => null,
            'includeTrashed' => false,
            'reserved' => null,
            'onUpdate' => false,
        ]);
    }

    /**
     * Define the blog-etc-admin gate to allow anyone through.
     */
    protected function allowAdminGate(): void
    {
        Gate::define('blog-etc-admin', static function ($user) {
            return true;
        });
    }

    /**
     * Define the blog-etc-admin gate to deny access to any user.
     */
    protected function denyAdminGate(): void
    {
        Gate::define('blog-etc-admin', static function ($user) {
            return false;
        });
    }

    /**
     * Be an admin user, give gate permissions to user.
     */
    protected function beAdminUser(): self
    {
        $user = new User();
        $user->id = 1;

        $this->be($user);

        $this->allowAdminGate();

        return $this;
    }

    /**
     * Be an admin user, give gate permissions to user.
     */
    protected function beNonAdminUser(): void
    {
        $user = new User();
        $user->id = 1;

        $this->be($user);

        $this->denyAdminGate();
    }
}
