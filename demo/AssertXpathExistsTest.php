<?php
namespace Tiny\Testing\Assertions\Xml\Demo;

class AssertXpathExistsTest extends BaseDemoTestCase
{
    public function testInvalidXpathDom() {
        $message = $this->formatDemoCaseDescription(
            "assertXpathExists()", 
            "invalid xpath at DOMDocument without specifying expected count"
        );
        $this->assertXpathExists('root/element/missing', $this->dom, null, $message);
    }
    
    public function testValidXpathInvalidCountDom() {
        $message = $this->formatDemoCaseDescription(
            "assertXpathExists()", 
            "valid xpath at DOMDocument specifying invalid expected count"
        );
        $this->assertXpathExists('/root/element', $this->dom, 2, $message);
    }
    
    public function testInvalidPathElement() {
        $message = $this->formatDemoCaseDescription(
            "assertXpathExists()", 
            "invalid xpath at DOMElement without specifying expected count"
        );
        $el = $this->xpath->query('/root')[0];
        $this->assertXpathExists('missing', $el, null, $message);
    }
    
    public function testValidXpathInvalidCountElement() {
        $message = $this->formatDemoCaseDescription(
            "assertXpathExists()", 
            "valid xpath at DOMElement specifying invalid expected count"
        );
        $el = $this->xpath->query('/root')[0];
        $this->assertXpathExists('//@attr', $el, 2, $message);
    }
}
