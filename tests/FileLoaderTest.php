<?php

namespace OrnoTest;

use Orno\Config\File\ArrayFileLoader;
use Orno\Config\File\YamlFileLoader;

class FileLoaderTest extends \PHPUnit_Framework_Testcase
{
    public function testParsesArrayFileWithoutKey()
    {
        $loader = new ArrayFileLoader(__DIR__ . '/assets/array-file.php');
        $array = $loader->parse();

        $this->assertInternalType('array', $array);
        $this->assertSame(
            $array,
            [
                'key1' => 'value1',
                'key2' => 'value2'
            ]
        );
    }

    public function testParsesArrayFileWithKey()
    {
        $loader = new ArrayFileLoader(__DIR__ . '/assets/array-file.php', 'some-parent-key');
        $array = $loader->parse();

        $this->assertInternalType('array', $array);
        $this->assertSame(
            $array,
            [
                'some-parent-key' => [
                    'key1' => 'value1',
                    'key2' => 'value2'
                ]
            ]
        );
    }

    public function testArrayFileLoaderThrowsExceptionWhenFileNotReadable()
    {
        $this->setExpectedException('Orno\Config\File\Exception\FileNotReadableException');

        $loader = new ArrayFileLoader(__DIR__ . '/assets/unreadable-array-file.php');
    }

    public function testArrayFileLoaderThrowsExceptionWhenProvidedMalformedFile()
    {
        $this->setExpectedException('Orno\Config\File\Exception\ParseException');

        $loader = new ArrayFileLoader(__DIR__ . '/assets/array-file-malformed.php');
        $array = $loader->parse();
    }

    public function testParsesYamlFileWithoutKey()
    {
        $loader = new YamlFileLoader(__DIR__ . '/assets/yaml-file.yml');
        $array = $loader->parse();

        $this->assertInternalType('array', $array);
        $this->assertSame(
            $array,
            [
                'SomeKey' => [
                    'SomeChildKey' => [
                        'key1' => 'value1',
                        'key2' => 'value2'
                    ]
                ]
            ]
        );
    }

    public function testParsesYamlFileWithKey()
    {
        $loader = new YamlFileLoader(__DIR__ . '/assets/yaml-file.yml', 'some-parent-key');
        $array = $loader->parse();

        $this->assertInternalType('array', $array);
        $this->assertSame(
            $array,
            [
                'some-parent-key' => [
                    'SomeKey' => [
                        'SomeChildKey' => [
                            'key1' => 'value1',
                            'key2' => 'value2'
                        ]
                    ]
                ]
            ]
        );
    }
}