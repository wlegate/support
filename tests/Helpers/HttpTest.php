<?php

namespace Tests\Helpers;

use Helldar\Support\Helpers\Http;
use Tests\TestCase;

class HttpTest extends TestCase
{
    public function testGetSubdomain()
    {
        $this->assertEquals('foo', Http::getSubdomain('https://foo.bar.example.com/foo/bar'));
        $this->assertEquals('foo', Http::getSubdomain('https://foo.example.com/foo/bar'));
        $this->assertEquals('', Http::getSubdomain('https://example.com/foo/bar'));
    }

    public function testExists()
    {
        $this->assertFalse(Http::exists('http://foo.bar'));
        $this->assertTrue(Http::exists('https://www.google.com'));
    }

    public function testIsUrl()
    {
        $this->assertTrue(Http::isUrl('http://example.com'));
        $this->assertFalse(Http::isUrl('example.com'));
    }

    public function testBuildUrl()
    {
        $url = 'https://example.com:username@password/foo/bar/baz?qwe=rty';

        $parsed = \parse_url($url);

        $this->assertEquals($url, Http::buildUrl($parsed));
    }

    public function testBaseUrl()
    {
        $this->assertEquals('example.com', Http::baseUrl('http://example.com'));
        $this->assertEquals('foo.example.com', Http::baseUrl('http://foo.example.com'));
    }

    public function testImageOrDefault()
    {
        $url_1 = 'http://example.com/foo/bar';
        $url_2 = 'http://example.com/foo/bar';

        $default = 'http://example.com/foo';

        $this->assertEquals($default, Images::imageOrDefault($url_1, $default));
        $this->assertEquals($default, Images::imageOrDefault($url_2, $default));
        $this->assertEquals(null, Images::imageOrDefault($url_2));
    }
}
