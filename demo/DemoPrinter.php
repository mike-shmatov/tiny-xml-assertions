<?php
namespace Tiny\Testing\Assertions\Xml\Demo;

use PHPUnit_Framework_TestFailure;
use PHPUnit_Framework_TestResult;
use PHPUnit_TextUI_ResultPrinter;

class DemoPrinter extends PHPUnit_TextUI_ResultPrinter
{
    private $unexpectedFailuresCount = 0;
    
    public function __construct($out = null, $verbose = false, $colors = self::COLOR_DEFAULT, $debug = false, $numberOfColumns = 80, $reverse = false) {
        parent::__construct($out, $verbose, $colors, $debug, $numberOfColumns, $reverse);
        $xml = BaseDemoTestCase::getXmlSample();
        $message = "This is demo test suite for tiny/xml-assertions library.\n"
                . "Following tests were run against this XML sample:\n";
        $this->write($message);
        $this->writeNewLine();
        $this->write($xml);
        $this->writeNewLine();
        $this->writeNewLine();
    }
    
    protected function printDefectTrace(PHPUnit_Framework_TestFailure $defect)
    {
        $e = $defect->thrownException();
        $message = rtrim($e->getMessage(), "\n");
        if (preg_match('/^Expected failure\.$/m', $message) !== 1) $this->unexpectedFailuresCount++;
        $this->write($message);
        $this->writeNewLine();
        $this->writeNewLine();
        
        while ($e = $e->getPrevious()) {
            $this->write("\nCaused by\n" . $e);
        }
    }
    
    protected function printFooter(PHPUnit_Framework_TestResult $result) {
        parent::printFooter($result);
        if ($this->unexpectedFailuresCount) {
            $this->writeNewLine();
            $this->writeWithColor('fg-white, bg-red', 'TEST SUITE HAS UNEXPECTED FAILURES!');
            $this->writeNewLine();
        }
    }
}