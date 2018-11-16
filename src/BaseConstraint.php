<?php
namespace Tiny\Testing\Assertions\Xml;

abstract class BaseConstraint extends \PHPUnit_Framework_Constraint
{
    public function failureDescription($other) {
        $object = get_class($other);
        if ( $other instanceof \DOMElement) {
            $object .= " '" . $other->getNodePath() . "'";
        }
        return  $object . ' ' . $this->toString();
    }
    
    protected function resolveElementsOnXpath($other, $xpathQuery) {
        if ($other instanceof \DOMElement) {
            $dom = $other->ownerDocument;
        } else {
            $dom = $other;
            $other = null;
        }
        $xpath = new \DOMXPath($dom);
        return $xpath->query($xpathQuery, $other);
    }
}
