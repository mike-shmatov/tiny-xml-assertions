<?php
use Tiny\Testing\Assertions\Xml\XmlAssertionsTrait;

class AssertXpathExistsTest extends PHPUnit_Framework_TestCase
{
    use XmlAssertionsTrait;
    
    private $dom;
    private $xpath;
    
    public function setUp() {
        $xml =    '<?xml version="1.0" encoding="UTF-8"?>'
                . '<root>'
                . '    <element attr="attribute"/>'
                . '</root>';
        $this->dom = new DOMDocument();
        $this->dom->loadXML($xml);
        $this->xpath = new DOMXPath($this->dom);
    }
    
    public function testXpathExistsForDom() {
        $this->assertXpathExists('/root/element/@attr', $this->dom);
    }
    
    public function testXpathExistsForElement() {
        $el = $this->xpath->evaluate('/root')[0];
        $this->assertXpathExists('element', $el);
    }
}
