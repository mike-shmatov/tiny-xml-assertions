<?php
namespace Tiny\Testing\Assertions\Xml;

class ValueOnXpathConstraint extends BaseConstraint
{
    private $xpathQuery;
    private $value;
    private $xpathExists = true;
    
    public function __construct($xpath, $value) {
        parent::__construct();
        $this->xpathQuery = $xpath;
        $this->value = $value;
    }
    
    public function matches($other) {
        $value = $this->getValueOnXpath($other);
        if ( ! $this->xpathExists ) return false;
        return $value == $this->value;
    }

    public function toString() {
        $template = "has expected value on xpath '%s'";
        if ( ! $this->xpathExists ) {
            $template .= ".\nSuch xpath does not exist";
        }
        $message = sprintf($template, $this->xpathQuery);
        return $message;
    }
    
    public function additionalFailureDescription($other) {
        if ( ! $this->xpathExists ) return '';
        $differ = new \SebastianBergmann\Diff\Differ("\n--- Expected scalar value\n+++ Actual scalar value\n");
        return $differ->diff($this->value, $this->getValueOnXpath($other));
    }
    
        private function getValueOnXpath($other) {
            $elements = $this->resolveElementsOnXpath($other, $this->xpathQuery);
            if ($this->xpathExists = $elements->length > 0) {
                return $elements[0]->nodeValue;
            } else {
                return null;
            }
        }
}
