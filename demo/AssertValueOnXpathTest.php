<?php
namespace Tiny\Testing\Assertions\Xml\Demo;

class AssertValueOnXpathTest extends BaseDemoTestCase
{
    public function testInvalidXpathOnDom() {
        $message = $this->formatDemoCaseDescription(
            "assertValueOnXpath()", 
            "invalid xpath at DOMDocument provided"
        );
        $this->assertValueOnXpath('/root/element/missing', 'any-value', $this->dom, $message);
    }
    
    public function testValueDoesNotMatchOnDom() {
        $message = $this->formatDemoCaseDescription(
            "assertValueOnXpath()", 
            "valid xpath at DOMDocument and value mismatch"
        );
        $this->assertValueOnXpath('/root/element/@attr', 'expected-value', $this->dom, $message);
    }
    
    public function testInvalidXpathOnElement() {
        $message = $this->formatDemoCaseDescription(
            "assertValueOnXpath()", 
            "invalid xpath relatively to DOMElement provided"
        );
        $el = $this->xpath->query('/root/element')[0];
        $this->assertValueOnXpath('element', 'any-value', $el, $message);
    }
    
    public function testValueDoesNotMatchOnElement() {
        $message = $this->formatDemoCaseDescription(
            "assertValueOnXpath()", 
            "valid xpath relatively to DOMElement having value mismatch"
        );
        $el = $this->xpath->query('/root/element')[0];
        $this->assertValueOnXpath('@attr', 'expected-value', $el, $message);
    }
}
