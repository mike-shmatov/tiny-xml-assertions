<?php
class ValueOnXpathConstraintTest extends PHPUnit_Framework_TestCase
{
    private $dom;
    private $xpath;
    
    public function setUp() {
        $xml =    '<?xml version="1.0" encoding="UTF-8"?>'
                . '<root>'
                . '    <child>'
                . '        <element>another</element>'
                . '    </child>'
                . '    <element attr="attribute">test</element>'
                . '</root>';
        $this->dom = new DOMDocument();
        $this->dom->loadXML($xml);
        $this->xpath = new DOMXPath($this->dom);
    }
    
    
    /**
     * @dataProvider domUseCasesDataProvider
     */
    public function testDomCases($xpath, $value, $shouldPass, $message, $additionals) {
        $constraint = new Tiny\Testing\Assertions\Xml\ValueOnXpathConstraint($xpath, $value);
        $passed = $constraint->evaluate($this->dom, 'description', true);
        $this->assertSame($shouldPass, $passed);
        if ( ! $shouldPass ) {
            $this->assertEquals($message, $constraint->failureDescription($this->dom));
            foreach ($additionals as $action => $parts) {
                $assert = 'assertContains';
                if ($action !== 'contains') {
                    $assert = 'assertNotContains';
                }
                foreach ($parts as $needle) {
                    $this->{$assert}($needle, $constraint->additionalFailureDescription($this->dom));
                }
            }
        }
    }
    
    /**
     * @dataProvider elementUseCasesDataProvider
     */
    public function testElementCases($elXpath, $xpath, $value, $shouldPass, $message, $additionals) {
        $el = $this->xpath->query($elXpath)[0];
        $constraint = new Tiny\Testing\Assertions\Xml\ValueOnXpathConstraint($xpath, $value);
        $passed = $constraint->evaluate($el, '', true);
        $this->assertSame($shouldPass, $passed);
        if ( ! $shouldPass ) {
            $this->assertEquals($message, $constraint->failureDescription($el));
            foreach ($additionals as $needle) {
                $this->assertContains($needle, $constraint->additionalFailureDescription($this->dom));
            }
        }
    }
    
    public function domUseCasesDataProvider() {
        // $xpath, $value, $shouldPass, $message, $additionals
        return [
            [
                '/root/element', 
                'test', 
                true, 
                "",
                []
            ],
            [
                '/root/element', 
                'not exists', 
                false, 
                "DOMDocument has expected value on xpath '/root/element'",
                [
                    'contains' => ['--- Expected scalar value', '+++ Actual scalar value', '-not exists', '+test']
                ]
            ],
            [
                '/root/no-such-element', 
                '', 
                false, 
                "DOMDocument has expected value on xpath '/root/no-such-element'.\n"
              . "Such xpath does not exist",
                [
                    'contains-not' => ['--- ', '+++ ']
                ]
            ],
        ];
    }
    
    public function elementUseCasesDataProvider() {
        return [
            [
                '/root', 
                'element', 
                'test', 
                true, 
                "",
                []
            ],
            [
                '/root', 
                'element', 
                2, 
                false, 
                "DOMElement '/root' has expected value on xpath 'element'",
                ['--- Expected scalar value', '+++ Actual scalar value', '-2', '+test']
            ],
            [   // data set for making sure xpath 'element' is resolved relatively to '/root/child'
                '/root/child', 
                'element', 
                'another', 
                true, 
                "",
                []
            ],
        ];
    }
}
