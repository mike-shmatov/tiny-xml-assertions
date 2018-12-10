<?php
namespace Tiny\Testing\Assertions\Xml;

class XmlElementHasChildrenConstraint extends BaseConstraint
{
    private $names;
    private $missing = [];
    
    public function __construct($names) {
        parent::__construct();
        if ( ! is_array($names) ) $names = [$names];
        $this->names = $names;
    }
    
    public function matches($other) {
        $xpath = new \DOMXPath($other->ownerDocument);
        $this->missing = [];
        foreach ($this->names as $name) {
            $childList = $xpath->query($name, $other);
            if ($childList->length === 0) {
                $this->missing[] = $name;
            }
        }
        return empty($this->missing);
    }
    
    public function toString() {
        return 'has expected child elements';
    }
    
    public function additionalFailureDescription($other) {
        $differ = new \SebastianBergmann\Diff\Differ("\n--- Missing elements\n");
        return $differ->diff($this->missing, []);
    }

}
