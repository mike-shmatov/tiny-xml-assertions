<?php
namespace Tiny\Testing\Assertions\Xml\Demo;

use DOMDocument;
use DOMXPath;
use PHPUnit_Framework_TestCase;
use Tiny\Testing\Assertions\Xml\XmlAssertionsTrait;

class BaseDemoTestCase extends PHPUnit_Framework_TestCase
{
    use XmlAssertionsTrait;
    
    protected $dom;
    protected $xpath;
    private static $xmlSample = <<< XML
<?xml version="1.0" encoding="UTF-8"?>
<root>
    <element attr="attribute">test</element>
</root>
XML;
    
    public static function getXmlSample() {
        return self::$xmlSample;
    }
    
    public function setUp() {
        $this->dom = new DOMDocument();
        $this->dom->loadXML(self::$xmlSample);
        $this->xpath = new DOMXPath($this->dom);
    }
    
    protected function formatDemoCaseDescription($assertion, $conditions) {
        $message = "--\n"
                . "Expected failure.\n"
                . "Assertion:  %s\n"
                . "Conditions: %s\n"
                . "--\n";
        return sprintf($message, $assertion, $conditions);
    }
}