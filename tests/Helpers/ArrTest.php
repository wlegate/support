<?php

namespace Tests\Helpers;

use Helldar\Support\Facades\Arr;
use Tests\TestCase;

class ArrTest extends TestCase
{
    public function testAddUnique()
    {
        $array   = ['foo'];
        $values1 = ['foo', 'bar', 'baz'];
        $values2 = 'foobar';

        $expected = ['foo', 'bar', 'baz', 'foobar'];

        $array = Arr::addUnique($array, $values1);
        $array = Arr::addUnique($array, $values2);

        $this->assertEquals($expected, $array);
    }

    public function testStoreAsArray()
    {
        $array = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];
        $path  = './build/arr.php';

        Arr::store($array, $path);

        $loaded = require $path;

        $this->assertIsArray($loaded);
        $this->assertEquals($array, $loaded);
    }

    public function testStoreAsJson()
    {
        $array = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];
        $path  = './build/arr.json';

        Arr::store($array, $path, true);

        $this->assertJsonStringEqualsJsonFile($path, \json_encode($array));
    }

    public function testStoreAsSortedArray()
    {
        $array = ['w' => 123, 'q' => 1, 's' => 5, 'r' => 2];
        $path  = './build/arr_sorted.php';

        Arr::storeAsArray($array, $path, true);

        $loaded = require $path;

        $this->assertIsArray($loaded);
        $this->assertEquals($array, $loaded);
    }

    public function testStoreAsSortedJson()
    {
        $array = ['w' => 123, 'q' => 1, 's' => 5, 'r' => 2];
        $path  = './build/arr_sorted.json';

        Arr::storeAsJson($array, $path, true);

        $this->assertJsonStringEqualsJsonFile($path, \json_encode($array));
    }

    public function testSizeOfMaxValue()
    {
        $array = ['foo', 'bar', 'foobar', 'baz'];

        $result = Arr::sizeOfMaxValue($array);

        $this->assertEquals(6, $result);
    }

    public function testSortByKeysArray()
    {
        $source = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];
        $sorter = ['q', 'w', 'e'];

        $expected = ['q' => 1, 'w' => 123, 'r' => 2, 's' => 5];

        $actual = Arr::sortByKeysArray($source, $sorter);

        $this->assertEquals($expected, $actual);
    }

    public function testRenameKeys()
    {
        $source = [
            'foo' => 123,
            'BaR' => 456,
            'BAZ' => 789,
        ];

        $expected = [
            'FOO' => 123,
            'BAR' => 456,
            'BAZ' => 789,
        ];

        $renamed = Arr::renameKeys($source, 'mb_strtoupper');

        $this->assertEquals($expected, $renamed);
    }

    public function testMerge()
    {
        $arr1 = [
            'foo' => 'Bar',
            '0'   => 'Foo',
            '2'   => 'Bar',
            '400' => 'Baz',
            600   => ['foo' => 'Foo', 'bar' => 'Bar'],
        ];

        $arr2 = [
            '2'   => 'Bar bar',
            '500' => 'Foo bar',
            '600' => ['baz' => 'Baz'],
            '700' => ['aaa' => 'AAA'],
        ];

        $expected = [
            'foo' => 'Bar',
            0     => 'Foo',
            2     => 'Bar bar',
            400   => 'Baz',
            500   => 'Foo bar',
            600   => ['foo' => 'Foo', 'bar' => 'Bar', 'baz' => 'Baz'],
            700   => ['aaa' => 'AAA'],
        ];

        $result = Arr::merge($arr1, $arr2);

        $this->assertEquals($expected, $result);
    }
}
