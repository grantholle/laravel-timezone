<?php

namespace GrantHolle\Timezone\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Orchestra\Testbench\TestCase as Orchestra;
use GrantHolle\Timezone\TimezoneServiceProvider;

class TestCase extends Orchestra
{
    public User $user;

    protected function getPackageProviders($app): array
    {
        return [
            TimezoneServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadLaravelMigrations();

        $migration = include __DIR__.'/../database/migrations/add_timezone_to_users_table.php.stub';
        $migration->up();
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
    }

    public function defineRoutes($router)
    {
        $router->post('/login', function (Request $request) {
            $user = User::firstOrFail($request->input('id'));
            Auth::login($user);

            return response();
        });
    }
}
