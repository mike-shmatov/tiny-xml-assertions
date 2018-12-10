<?php
namespace Tests\AssertXmlElementChilds;

use DOMDocument;
use DOMXPath;
use PHPUnit_Framework_TestCase;
use Tiny\Testing\Assertions\Xml\XmlElementHasChildrenConstraint;

class XmlElementHasChildrenConstraintTest extends PHPUnit_Framework_TestCase
{
    private $dom;
    private $xpath;
    
    public function setUp() {
        $xml =    '<?xml version="1.0" encoding="UTF-8"?>'
                . '<root>'
                . '    <one/>'
                . '    <two/>'
                . '</root>';
        $this->dom = new DOMDocument();
        $this->dom->loadXML($xml);
        $this->xpath = new DOMXPath($this->dom);
    }
    
    
    /**
     * @dataProvider elementUseCasesDataProvider
     */
    public function testDomElementCases($elXpath, $names, $shouldPass, $message, $additionals) {
        $el = $this->xpath->query($elXpath)[0];
        $constraint = new XmlElementHasChildrenConstraint($names);
        $passed = $constraint->evaluate($el, 'description', true);
        $this->assertSame($shouldPass, $passed);
        if ( ! $shouldPass ) {
            $this->assertEquals($message, $constraint->failureDescription($el));
            foreach ($additionals as $action => $parts) {
                $assert = 'assertContains';
                if ($action !== 'contains') {
                    $assert = 'assertNotContains';
                }
                foreach ($parts as $needle) {
                    $this->{$assert}($needle, $constraint->additionalFailureDescription($el));
                }
            }
        }
    }
    
    public function elementUseCasesDataProvider() {
        return [
            [
                '/root',
                'element',
                false,
                'DOMElement \'/root\' has expected child elements',
                [
                    'contains' => ['--- Missing elements', 'element']
                ]
            ]
        ];
    }
}
