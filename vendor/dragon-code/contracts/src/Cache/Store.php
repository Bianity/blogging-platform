<?php

/*
 * This file is part of the "dragon-code/contracts" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/contracts
 */

declare(strict_types=1);

namespace DragonCode\Contracts\Cache;

interface Store
{
    /**
     * Retrieve an item from the cache by key.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Store an item in the cache for a given number of seconds.
     *
     * @param string $key
     * @param mixed $callback
     * @param int $seconds
     * @param mixed $value
     *
     * @return mixed
     */
    public function put(string $key, $value, int $seconds);

    /**
     * Store an item in the cache for a given number of seconds.
     *
     * The `put` method alias to improve usability.
     *
     * @param string $key
     * @param mixed $callback
     * @param int $seconds
     * @param mixed $value
     *
     * @return mixed
     */
    public function remember(string $key, $value, int $seconds);

    /**
     * Remove an item from the cache.
     *
     * @param string $key
     */
    public function forget(string $key): void;

    /**
     * Checks for the existence of a key.
     *
     * @param string $key
     */
    public function has(string $key): bool;

    /**
     * Checks the key for its absence.
     *
     * @param string $key
     */
    public function doesntHave(string $key): bool;
}
