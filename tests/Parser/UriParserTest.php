<?php
namespace Gungnir\HTTP\Tests\Parser;

use Gungnir\HTTP\Parser\UriParser;
use \PHPUnit\Framework\TestCase;

class UriParserTest extends TestCase
{
    /**
     * @test
     */
    public function itParsesUriCorrectly()
    {
        define('BASE_DIR', 'testBaseDir');

        $inputs = [
            '/testBaseDir/controller/action',
            '/testBaseDir/index.php/controller/action',
            '/index.php/controller/action',
            '/controller/action'
        ];

        $expectedOutput = 'controller/action';

        $parser = new UriParser();

        foreach ($inputs AS $input) {
            $this->assertEquals($expectedOutput, $parser->parse($input));
        }
    }
}