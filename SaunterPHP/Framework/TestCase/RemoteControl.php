<?php

require_once 'SaunterPHP/Framework/SeleniumConnection.php';
require_once 'SaunterPHP/Framework/SuiteIdentifier.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Log.php';

abstract class SaunterPHP_Framework_SaunterTestCase extends PHPUnit_Framework_TestCase {
  
  public function setUp() {
    $this->verificationErrors = array();
    $this->log = Log::singleton('file', $GLOBALS['settings']['logname'], $this->getName());
    $this->selenium = SaunterPHP_Framework_SeleniumConnection::getInstance()->selenium;
    $this->selenium->start();
    $this->selenium->windowMaximize();
  }

  // fired after the test run but before teardown
  public function assertPostConditions() {
    $this->assertEmpty($this->verificationErrors, implode("\n", $this->verificationErrors));
  }
  
  public function tearDown() { }
  
  public function verifyEquals($want, $got)
  {
    try {
        $this->assertEquals($want, $got);
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
  }
}
?>