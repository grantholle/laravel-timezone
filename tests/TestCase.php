<?php

namespace GrantHolle\Timezone\Tests;

use GrantHolle\Timezone\Tests\Drivers\LocalTestDriver;
use GrantHolle\Timezone\Tests\Models\User;
use GrantHolle\Timezone\TimezoneServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchestra\Testbench\TestCase as Orchestra;
use Stevebauman\Location\LocationServiceProvider;

class TestCase extends Orchestra
{
    public User $user;

    protected function getPackageProviders($app): array
    {
        return [
            TimezoneServiceProvider::class,
            LocationServiceProvider::class,
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
        config()->set('location.driver', LocalTestDriver::class);
    }

    public function defineRoutes($router)
    {
        // This mocks a login to trigger the event
        $router->post('/login', function (Request $request) {
            $user = User::findOrFail($request->input('id'));
            Auth::login($user);

            return response()->json();
        });
    }
}
