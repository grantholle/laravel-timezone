# Laravel Timezone

[![Latest Version on Packagist](https://img.shields.io/packagist/v/grantholle/laravel-timezone.svg?style=flat-square)](https://packagist.org/packages/grantholle/laravel-timezone)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/grantholle/laravel-timezone/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/grantholle/laravel-timezone/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/grantholle/laravel-timezone/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/grantholle/laravel-timezone/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/grantholle/laravel-timezone.svg?style=flat-square)](https://packagist.org/packages/grantholle/laravel-timezone)

This package detects and sets a user's timezone and provides some helpers to convert dates into a user's timezone.

## Installation

You can install the package via composer:

```bash
composer require grantholle/laravel-timezone
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="timezone-migrations"
php artisan migrate
```

> **Note** 
> If you use multiple models that authenticate, you will want to add a column to each of them.

You can publish the config file with:

```bash
php artisan vendor:publish --tag="timezone-config"
```

## Usage

The package will automatically set a `timezone` property to the user logging in to the app. If the `overwite` option is set in the `timezone` config, it will check each time the user logs in. Under the hood, this package relies on the [stevebauman/location](https://github.com/stevebauman/location) package to detect where the user is based on IP address and the appropriate timezone. Under its hood, it's relying on Laravel's `request()->ip()` function, which relies on Symfony's `Request` object to detect IP addresses. If you're experiencing issues of detecting the wrong timezones and therefore wrong IP address, it's likely due to [trusted proxy](https://laravel.com/docs/10.x/requests#configuring-trusted-proxies) configuration issues. Check out that documentation for more details.

You can change which events the timezone is set or opt out of this feature by changing the config's `events` option.

```php
'events' => [
    // By default, the Login event
    \Illuminate\Auth\Events\Login::class,
    // Another event which deals with a user
    \App\Events\MyEvent::class,
],
```

To ignore this feature, set `events` to be [empty](https://www.php.net/manual/en/function.empty.php).

Aside from timezone detection, you can use several helpers around dates for the authenticated user.

### Suggested configuration

The functions that return date objects return CarbonImmutable objects. To save yourself a lot of headaches, you should use them in your application, too.

In your `AppServiceProvider`'s boot function,

```php
\Illuminate\Support\Facades\Date::use(\Carbon\CarbonImmutable::class);
```

### Cheatsheet

Below is a set of examples using the facade and available helper functions.

```php
use GrantHolle\Timezone\Facades\Timezone;

// Get the user's or app default timezone
$string = Timezone::getCurrentTimezone();
$string = timezone();

// Get a collection of timezones and a labeled version of them.
// The key is the timezone and the value is a formatted label.
Timezone::timezones();
timezones();

// Convert a date to the user's timezone
// This will return a CarbonImmutable instance
$carbonImmutable = Timezone::toLocal($utcDate);

// Optionally you can pass in a format or use
// the toLocalFormatted function
$string = Timezone::toLocal($utcDate, 'Y-m-d');
$string = to_local_timezone($utcDate, 'Y-m-d');

// Leaving out the last parameter will use the config's `format` value
$string = Timezone::toLocalFormatted($utcDate);
$carbonImmutable = to_local_timezone($utcDate);

// Convert user's dates to your app's timezone.
// It relies on Carbon's `parse` function, so you
// can pass many things to it to parse.
$carbonImmutable = Timezone::fromLocal($usersDate);
$carbonImmutable = from_local_timezone($usersDate);

// Helpers to get the user's "today" and "now" values
$carbonImmutable = Timezone::today();
$carbonImmutable = local_today();
$carbonImmutable = Timezone::now();
$carbonImmutable = local_now();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Grant Holle](https://github.com/grantholle)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
