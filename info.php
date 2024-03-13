<?php
$my_array = array(
    'name' => 'GFG',
    'subject' => 'CS',
    'contact_info' => array(
        'city' => 'Noida',
        'state' => 'UP',
        'email' => 'feedback@geeksforgeeks.org'
    ),
    'name' => 'GFG',
    'subject' => 'CS',
    'contact_info' => array(
        'city' => 'Noida',
        'state' => 'UP',
        'email' => 'feedback@geeksforgeeks.org'
    ),
);

header("Content-type: text/xml; charset=utf-8");
$xmlstr = arrayToXml($my_array);
echo $xmlstr;

function arrayToXml($array, $rootElement = null, $xml = null)
{
    $_xml = $xml;
    // If there is no Root Element then insert root
    if ($_xml === null) {
        $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>');
    }
    // Visit all key value pair
    foreach ($array as $k => $v) {
        // If there is nested array then
        if (is_array($v)) {

            // Call function for nested array
            arrayToXml($v, $k, $_xml->addChild($k));
        } else {

            // Simply add child element. 
            $_xml->addChild($k, $v);
        }
    }

    return $_xml->asXML();
}
