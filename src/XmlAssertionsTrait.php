<?php
namespace Tiny\Testing\Assertions\Xml;

trait XmlAssertionsTrait
{
    /**
     * Assert that xpath exists.
     * @param string $xpath Xpath to search
     * @param mixed $domNode DOMDocument or DOMElement instance as a start for search
     * @param integer $count How many times xpath is expected to be found. Null if any.
     * @param string $message Message to be displayed by PHPUnit on failure.
     */
    public static function assertXpathExists($xpath, $domNode, $count = null, $message = '') {
        $constraint = new XpathExistsConstraint($xpath, $count);
        static::assertThat($domNode, $constraint, $message);
    }
    
    public static function assertValueOnXpath($xpath, $value, $domNode, $message = '') {
        $constraint = new ValueOnXpathConstraint($xpath, $value);
        static::assertThat($domNode, $constraint, $message);
    }
}
