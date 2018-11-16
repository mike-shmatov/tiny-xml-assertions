<?php
class XpathExistsConstraintTest extends PHPUnit_Framework_TestCase
{
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
    
    
    /**
     * @dataProvider domUseCasesDataProvider
     */
    public function testDomCases($xpath, $count, $shouldPass, $message) {
        $constraint = new Tiny\Testing\Assertions\Xml\XpathExistsConstraint($xpath, $count);
        $passed = $constraint->evaluate($this->dom, 'description', true);
        $this->assertSame($shouldPass, $passed);
        if ( ! $shouldPass ) {
            $this->assertEquals($message, $constraint->failureDescription($this->dom));
        }
    }
    
    /**
     * @dataProvider elementUseCasesDataProvider
     */
    public function testElementCases($elXpath, $xpath, $count, $shouldPass, $message) {
        $el = $this->xpath->query($elXpath)[0];
        $constraint = new Tiny\Testing\Assertions\Xml\XpathExistsConstraint($xpath, $count);
        $passed = $constraint->evaluate($el, '', true);
        $this->assertSame($shouldPass, $passed);
        if ( ! $shouldPass ) {
            $this->assertEquals($message, $constraint->failureDescription($el));
        }
    }
    
    public function domUseCasesDataProvider() {
        return [
            [
                '/root/element', 
                2, 
                false, 
                "DOMDocument has existing xpath '/root/element' exactly 2 time(s)\n"
              . "Actually xpath found 1 time(s)"
            ],
            [
                '/root/none', 
                null, 
                false,
                'DOMDocument has existing xpath \'/root/none\' at least once'
            ],
            [
                'element', 
                null, 
                true,
                ''
            ]
        ];
    }
    
    public function elementUseCasesDataProvider() {
        return [
            [
                '/root', 
                'element', 
                null, 
                true, 
                ""
            ],
            [
                '/root', 
                'element', 
                2, 
                false, 
                "DOMElement '/root' has existing xpath 'element' exactly 2 time(s)\n"
              . "Actually xpath found 1 time(s)"
            ],
        ];
    }
}
