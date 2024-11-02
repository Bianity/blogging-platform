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

namespace DragonCode\Contracts\Http;

use DragonCode\Contracts\Support\Arrayable;
use Psr\Http\Message\UriInterface;

interface Builder extends UriInterface, Arrayable
{
    public const PHP_URL_ALL = -1;

    /**
     * Parse a URL.
     *
     * @param \Psr\Http\Message\UriInterface|string $url
     * @param int $component
     *
     * @return $this
     */
    public function parse($url, int $component = self::PHP_URL_ALL): self;

    /**
     * Populate an object with parsed data.
     *
     * @param array $parsed
     *
     * @return $this
     */
    public function parsed(array $parsed): self;

    /**
     * Retrieve the domain name of the URI.
     *
     * @return string
     */
    public function getDomain(): string;

    /**
     * Retrieve the domain level name of the URI.
     *
     * @param int $level
     *
     * @return string
     */
    public function getDomainLevel(int $level = 0): string;

    /**
     * Retrieve the base domain name of the URI.
     *
     * @return string
     */
    public function getBaseDomain(): string;

    /**
     * Retrieve the subdomain name of the URI.
     *
     * @return string
     */
    public function getSubDomain(): string;

    /**
     * Retrieve the scheme and host of the URI.
     *
     * @return string
     */
    public function getBaseUrl(): string;

    /**
     * Retrieve the user name component of the URI.
     *
     * @return string
     */
    public function getUser(): string;

    /**
     * Retrieve the user password component of the URI.
     *
     * @return string
     */
    public function getPassword(): string;

    /**
     * Remove the fragment component from the URI.
     *
     * @return \DragonCode\Contracts\Http\Builder
     */
    public function removeFragment(): self;

    /**
     * Retrieve the query array of the URI.
     *
     * @return array
     */
    public function getQueryArray(): array;

    /**
     * Return an instance with the specified query object.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return \DragonCode\Contracts\Http\Builder
     */
    public function putQuery(string $key, $value): self;

    /**
     * Return an instance with the specified query object.
     *
     * @param string $key
     *
     * @return \DragonCode\Contracts\Http\Builder
     */
    public function removeQuery(string $key): self;

    /**
     * Return an instance with the specified `UriInterface`.
     *
     * @param \Psr\Http\Message\UriInterface $uri
     *
     * @return \DragonCode\Contracts\Http\Builder
     */
    public function fromPsr(UriInterface $uri): self;

    /**
     * Return the string representation as a URI reference.
     *
     * @return \Psr\Http\Message\UriInterface
     */
    public function toPsr(): UriInterface;

    /**
     * Return the string representation as a URI reference.
     *
     * @return string
     */
    public function toUrl(): string;
}
