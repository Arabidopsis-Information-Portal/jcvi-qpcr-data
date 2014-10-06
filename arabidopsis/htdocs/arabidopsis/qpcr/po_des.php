<?php
session_start();
include_once ("dbconnection.php");
$pocode=$_GET["inputvalue"];
 
$query = "SELECT name, namespace, def FROM po_code WHERE po_code='$pocode';"

  if (!mysql_select_db("town_at_reporter", $connection))
     showerror();
        
  if (!($result = @ mysql_query ($query, $connection)))
     showerror();
$row= @mysql_fetch_array($result)

$response='<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>'.
	'<name>'.
		$row["name"].
	'</name>'.
	'<namespace>'.
		$row["namespace"].
	'</namespace>'.
	'<def>'.
		$row["def"].
	'</def>';

header('Content-Type: text/xml');
echo $response;

?>   
