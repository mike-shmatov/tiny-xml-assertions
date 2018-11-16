<?php
namespace Tiny\Testing\Assertions\Xml;

class XpathExistsConstraint extends BaseConstraint
{
    private $xpathQuery;
    private $count;
    private $actuallyFoundElementsCount;
    
    public function __construct($xpath, $count) {
        parent::__construct();
        $this->xpathQuery = $xpath;
        $this->count = $count;
    }
    
    public function matches($other) {
        $elements = $this->resolveElementsOnXpath($other, $this->xpathQuery);
        $this->actuallyFoundElementsCount = $elements->length;
        if ($this->count === null) {
            return  $this->actuallyFoundElementsCount > 0;
        } else {
            return $this->actuallyFoundElementsCount === $this->count;
        }
    }
    
    
    public function toString() {
        if ( $this->count === null ) {
            $report = 'at least once';
        } else {
            $report = "exactly " . (integer) $this->count . " time(s)\n"
                    . "Actually xpath found ".$this->actuallyFoundElementsCount." time(s)";
        }
        $message = "has existing xpath '%s' $report";
        return sprintf($message, $this->xpathQuery);
    }
}
