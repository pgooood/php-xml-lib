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

//get PHP DOMDocument
$dd = $xml->dd();

//get root element
$documentElement = $xml->de();

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