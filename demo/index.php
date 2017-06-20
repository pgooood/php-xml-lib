<?php
spl_autoload_register(function($class){
	if(is_file($path = '../classes/'.str_replace('\\','/',$class).'.php'))
		include($path);
});

$xml = new \pgood\xml\xml('demo.xml');

//get string value (xpath)
$title = $xml->evaluate('string(/catalog/book[@id="bk103"]/title)');

//get dom element (xpath)
$element = $xml->query('//book[2]')->item(0);

//get subelement value (xpath)
$price = $xml->evaluate('number(price)',$element);

//get attribute
$oldId = $element->id;

//remove attribute
$element->id = null;

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

//remove element
$newElem->remove();

//save changes
$xml->save();

//get PHP DOMDocument
$dd = $xml->dd();

//get root element
$documentElement = $xml->de();

/*
 * XSLT Transformation
 */
$tpl = new \pgood\xml\template('tpl.xsl');
echo $tpl->transform($xml);

/*
 * XML from scratch
 */
$xml = new \pgood\xml\xml();
$xml->de('root-element-name');

//using the xml::create method for element creation
$newElement1 = $xml->de()->append($xml->create(
		'child-element-tag-name'
		,array(
			'attr-name-1' => 'value for first attribute'
			,'attr-name-2' => 'value for second attribute'
		)
		,'element text content'
	));

//lazy element creation
$newElement2 = $xml->de()->append('child-element-tag-name');
$newElement2->{'element-id'} = 'id value';

//catch up an existed DOMDocument
$xml2 = new \pgood\xml\xml($newElement2);

//new XML from inline code
$xml = new \pgood\xml\xml('<?xml version="1.0" encoding="utf-8"?><data>content</data>');

//save
$xml->save('new-file-name.xml');

/*
 * XPath and namespace
 * Let's count media:content elements in Yahoo RSS feed
 */
$xml = new \pgood\xml\xml('https://www.yahoo.com/news/rss/');
$xml->registerNameSpace('media','http://search.yahoo.com/mrss/');
$numElemets = $xml->evaluate('count(//media:content)');
