<?php

namespace Helick\CacheHelpers;

/**
 * Get a value from the object cache, if one doesn't exist, run the given callback to generate
 * and cache the value.
 *
 * @param string   $key
 * @param callable $callback
 * @param string   $group
 * @param int      $expire
 *
 * @return mixed
 */
function cache_remember(string $key, callable $callback, string $group = '', int $expire = 0)
{
    $cached = wp_cache_get($key, $group);

    if (false !== $cached) {
        return $cached;
    }

    $value = $callback();

    if (!is_wp_error($value)) {
        wp_cache_set($key, $value, $group, $expire);
    }

    return $value;
}

/**
 * Get and subsequently delete a value from the object cache.
 *
 * @param string $key
 * @param string $group
 * @param mixed  $default
 *
 * @return mixed
 */
function cache_forget(string $key, string $group = '', $default = null)
{
    $cached = wp_cache_get($key, $group);

    if (false !== $cached) {
        wp_cache_delete($key, $group);

        return $cached;
    }

    return $default;
}

/**
 * Get a value from the transients, if one doesn't exist, run the given callback to generate
 * and cache the value.
 *
 * @param string   $key
 * @param callable $callback
 * @param int      $expire
 *
 * @return mixed
 */
function transient_remember(string $key, callable $callback, int $expire = 0)
{
    $cached = get_transient($key);

    if (false !== $cached) {
        return $cached;
    }

    $value = $callback();

    if (!is_wp_error($value)) {
        set_transient($key, $value, $expire);
    }

    return $value;
}

/**
 * Get and subsequently delete a value from the transients.
 *
 * @param string $key
 * @param mixed  $default
 *
 * @return mixed
 */
function transient_forget(string $key, $default = null)
{
    $cached = get_transient($key);

    if (false !== $cached) {
        delete_transient($key);

        return $cached;
    }

    return $default;
}

/**
 * Get a value from the transients, if one doesn't exist, run the given callback to generate
 * and cache the value.
 *
 * @param string   $key
 * @param callable $callback
 * @param int      $expire
 *
 * @return mixed
 */
function site_transient_remember(string $key, callable $callback, int $expire = 0)
{
    $cached = get_site_transient($key);

    if (false !== $cached) {
        return $cached;
    }

    $value = $callback();

    if (!is_wp_error($value)) {
        set_site_transient($key, $value, $expire);
    }

    return $value;
}

/**
 * Get and subsequently delete a value from the site transients.
 *
 * @param string $key
 * @param mixed  $default
 *
 * @return mixed
 */
function site_transient_forget(string $key, $default = null)
{
    $cached = get_site_transient($key);

    if (false !== $cached) {
        delete_site_transient($key);

        return $cached;
    }

    return $default;
}
