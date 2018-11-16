# tiny/xml-assertions

This package provides XML assertions.

## Install

```bash
$ composer require --dev tiny/xml-assertions
```

## Usage

Use `\Tiny\Testing\Assertions\Xml\XmlAssertionsTrait` in test case.

Available assertions:

```php
/**
 * Assert that xpath exists.
 * @param string $xpath Xpath to search
 * @param mixed $domNode DOMDocument or DOMElement instance as a start for search
 * @param integer $count How many times xpath is expected to be found. Null if any.
 * @param string $message Message to be displayed by PHPUnit on failure.
 */
public static function assertXpathExists($xpath, $domNode, $count = null, $message = '');

/**
 * 
 * @param string $xpath Xpath where value is expected to be found
 * @param mixed $value Expected value
 * @param mixed $domNode DOMDocument or DOMElement instance as a start for search
 * @param string $message Message to be displayed by PHPUnit on failure.
 */
public static function assertValueOnXpath($xpath, $value, $domNode, $message = '');
````

## Demo

Sample output for failures can be seen [in the sample file](demo/results.txt). The file contains output for demo test suite. If needed, the suite can be run via:

```bash
$ composer run-script demo
```
