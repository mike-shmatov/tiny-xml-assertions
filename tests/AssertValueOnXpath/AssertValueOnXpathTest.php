<?php
class AssertValueOnXpathTest extends PHPUnit_Framework_TestCase
{
    use \Tiny\Testing\Assertions\Xml\XmlAssertionsTrait;
    
    private $dom;
    private $xpath;
    
    public function setUp() {
        $xml =    '<?xml version="1.0" encoding="UTF-8"?>'
                . '<root>'
                . '    <element attr="attribute">test</element>'
                . '</root>';
        $this->dom = new DOMDocument();
        $this->dom->loadXML($xml);
        $this->xpath = new DOMXPath($this->dom);
    }
    
    public function testValueOnXpathForDom() {
        $this->assertValueOnXpath('/root/element/@attr', 'attribute', $this->dom);
    }
    
    public function testXpathExistsForElement() {
        $el = $this->xpath->evaluate('/root')[0];
        $this->assertValueOnXpath('element', 'test', $el);
    }
}
