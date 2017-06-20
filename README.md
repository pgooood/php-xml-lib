# pgood xml lib
Handy wrapper for DOM

Manual is under construction.

Examples
-------
```php
$xml = new \pgood\xml\xml('demo.xml');

//get string value (xpath)
$title = $xml->evaluate('string(/catalog/book[@id="bk103"]/title)');

//get element (xpath)
$element = $xml->query('//book[2]')->item(0);

//get subelement value (xpath)
$price = $xml->evaluate('number(price)',$element);

//get attribute
$oldId = $element->id;

//set attribute
$element->id = 'newId';

//set text content
$element->text('new text content');

//get text content
$element->text();

//append new element
$newElem = $element->append('new-element');

//move queryed element before new one
$newElem->before($xml->query('//book[3]')->item(0));

//get root element
$documentElement = $xml->de();

//get DOMDocument
$dd = $xml->dd();

//save
$xml->save('temp.xml');

//XSLT Transformation
$tpl = new \pgood\xml\template('tpl.xsl');
echo $tpl->transform($xml);

//XPath and namespace
//Lets's count media:content elements in Yahoo RSS feed
$xml = new \pgood\xml\xml('https://www.yahoo.com/news/rss/');
$xml->registerNameSpace('media','http://search.yahoo.com/mrss/');
$numElemets = $xml->evaluate('count(//media:content)');
```

demo.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<catalog>
	<book id="bk101">
		<author>Gambardella, Matthew</author>
		<title>XML Developer's Guide</title>
		<genre>Computer</genre>
		<price>44.95</price>
		<publish_date>2000-10-01</publish_date>
		<description>An in-depth look at creating applications with XML.</description>
	</book>
	<book id="bk102">
		<author>Ralls, Kim</author>
		<title>Midnight Rain</title>
		<genre>Fantasy</genre>
		<price>5.95</price>
		<publish_date>2000-12-16</publish_date>
		<description>A former architect battles corporate zombies, an evil sorceress, and her own childhood to become queen of the world.</description>
	</book>
	<!-- ... -->
</catalog>
```