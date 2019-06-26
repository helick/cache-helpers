# Helick Cache Helpers

Helpers for the WordPress object cache and transients.

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![Quality Score][ico-code-quality]][link-code-quality]

## Requirements

Make sure all dependencies have been installed before moving on:

* [PHP](http://php.net/manual/en/install.php) >= 7.1
* [Composer](https://getcomposer.org/download/)

## Install

Via Composer:

``` bash
$ composer require helick/cache-helpers
```

## Usage

The package provides the following functions for WordPress:

* [`cache_remember()`](#cache_remember)
* [`cache_forget()`](#cache_forget)
* [`transient_remember()`](#transient_remember)
* [`transient_forget()`](#transient_forget)
* [`site_transient_remember()`](#site_transient_remember)
* [`site_transient_forget()`](#site_transient_forget)

Each function checks the response of the callback for a `WP_Error` object, ensuring you're not caching temporary errors for long periods of time. PHP Exceptions will also not be cached.

### cache_remember()

Get a value from the object cache, if one doesn't exist, run the given callback to generate and cache the value.

#### Parameters

<dl>
    <dt>(string) $key</dt>
    <dd>The cache key.</dd>
    <dt>(callable) $callback</dt>
    <dd>The callback used to generate and cache the value.</dd>
    <dt>(string) $group</dt>
    <dd>Optional. The cache group. Default is empty.</dd>
    <dt>(int) $expire</dt>
    <dd>Optional. The number of seconds before the cache entry should expire. Default is 0 (as long as possible).</dd>
</dl>

#### Example

```php
use function Helick\CacheHelpers\cache_remember;

function get_latest_posts()
{
    return cache_remember('latest', function () {
        return new WP_Query([
            'posts_per_page' => 5,
            'orderby'        => 'post_date',
            'order'          => 'desc',
        ]);
    }, 'posts', HOUR_IN_SECONDS);
}
```

### cache_forget()

Get and subsequently delete a value from the object cache.

#### Parameters

<dl>
    <dt>(string) $key</dt>
    <dd>The cache key.</dd>
    <dt>(string) $group</dt>
    <dd>Optional. The cache group. Default is empty.</dd>
    <dt>(mixed) $default</dt>
    <dd>Optional. The default value to return if the given key doesn't exist in the object cache. Default is null.</dd>
</dl>

#### Example

```php
use function Helick\CacheHelpers\cache_forget;

function display_error_message()
{
    $error_message = cache_forget('form_errors', 'my-cache-group', false);

    if ($error_message) {
        echo 'An error occurred: ' . $error_message;
    }
}
```

### transient_remember()

Get a value from the transients, if one doesn't exist, run the given callback to generate and cache the value.

#### Parameters

<dl>
    <dt>(string) $key</dt>
    <dd>The cache key.</dd>
    <dt>(callable) $callback</dt>
    <dd>The callback used to generate and cache the value.</dd>
    <dt>(int) $expire</dt>
    <dd>Optional. The number of seconds before the cache entry should expire. Default is 0 (as long as possible).</dd>
</dl>

#### Example

```php
use function Helick\CacheHelpers\transient_remember;

function get_tweets()
{
    $user_id = get_current_user_id();
    $key     = 'latest_tweets_' . $user_id;

    return transient_remember($key, function () use ($user_id) {
        return get_latest_tweets_for_user($user_id);
    }, 15 * MINUTE_IN_SECONDS);
}
```

### transient_forget()

Get and subsequently delete a value from the transients.

#### Parameters

<dl>
    <dt>(string) $key</dt>
    <dd>The cache key.</dd>
    <dt>(mixed) $default</dt>
    <dd>Optional. The default value to return if the given key doesn't exist in transients. Default is null.</dd>
</dl>

```php
use function Helick\CacheHelpers\transient_forget;

function display_error_message()
{
    $error_message = transient_forget('form_errors', false);

    if ($error_message) {
        echo 'An error occurred: ' . $error_message;
    }
}
```

### site_transient_remember()

Get a value from the transients, if one doesn't exist, run the given callback to generate and cache the value.

This function shares arguments and behavior with [`transient_remember()`](#transient_remember), but works network-wide when using WordPress Multisite.

#### Parameters

<dl>
    <dt>(string) $key</dt>
    <dd>The cache key.</dd>
    <dt>(mixed) $default</dt>
    <dd>Optional. The default value to return if the given key doesn't exist in transients. Default is null.</dd>
</dl>

```php
use function Helick\CacheHelpers\site_transient_remember;

function get_tweets()
{
    $user_id = get_current_user_id();
    $key     = 'latest_tweets_' . $user_id;

    return site_transient_remember($key, function () use ($user_id) {
        return get_latest_tweets_for_user($user_id);
    }, 15 * MINUTE_IN_SECONDS);
}
```

### site_transient_forget()

Get and subsequently delete a value from the site transients.

This function shares arguments and behavior with [`transient_forget()`](#transient_forget), but works network-wide when using WordPress Multisite.

#### Parameters

<dl>
    <dt>(string) $key</dt>
    <dd>The cache key.</dd>
    <dt>(mixed) $default</dt>
    <dd>Optional. The default value to return if the given key doesn't exist in transients. Default is null.</dd>
</dl>

```php
use function Helick\CacheHelpers\site_transient_forget;

function display_error_message()
{
    $error_message = site_transient_forget('form_errors', false);

    if ($error_message) {
        echo 'An error occurred: ' . $error_message;
    }
}
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email evgenii@helick.io instead of using the issue tracker.

## Credits

- [Evgenii Nasyrov][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/helick/cache-helpers.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/helick/cache-helpers.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/helick/cache-helpers.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/helick/cache-helpers
[link-code-quality]: https://scrutinizer-ci.com/g/helick/cache-helpers
[link-downloads]: https://packagist.org/packages/helick/cache-helpers
[link-author]: https://github.com/nasyrov
[link-contributors]: ../../contributors
