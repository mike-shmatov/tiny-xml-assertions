<?php
namespace Tests\AssertXmlElementChilds;

use PHPUnit_Framework_TestCase;
use Tiny\Testing\Assertions\Xml\XmlAssertionsTrait;

class AssertXmlElementChildsTest extends PHPUnit_Framework_TestCase
{
    use XmlAssertionsTrait;
    
    private $dom;
    private $xpath;
    
    public function setUp() {
        $xml =    '<?xml version="1.0" encoding="UTF-8"?>'
                . '<root>'
                . '    <element>'
                . '        <one>'
                . '            <element/>'
                . '        </one>'
                . '        <two/>'
                . '    </element>'
                . '</root>';
        $this->dom = new \DOMDocument();
        $this->dom->loadXML($xml);
        $this->xpath = new \DOMXPath($this->dom);
    }
    
    public function testHasChilds() {
        $el = $this->xpath->query('/root/element')[0];
        $this->assertXmlElementChildren('one', $el);
    }
}
