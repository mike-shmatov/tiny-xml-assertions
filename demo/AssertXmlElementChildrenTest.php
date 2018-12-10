<?php
namespace Tiny\Testing\Assertions\Xml\Demo;

class AssertXmlElementChildrenTest extends BaseDemoTestCase
{
    public function testInvalidChildrenOfDomElement() {
        $message = $this->formatDemoCaseDescription(
            "assertXmlElementChildren()", 
            "invalid children of DOMElement"
        );
        $el = $this->xpath->query('/root')[0];
        $this->assertXmlElementChildren('missing', $el, $message);
    }
}
