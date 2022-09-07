<?php
$mySQLserver = "localhost";
	$mySQLuser = "root";
	$mySQLpassword = "";
	$mySQLdefaultdb = "saas_encrypt";
	$host = "localhost/saas_encrypt/";
	$folderweb="";
	$webhook = $host."webhook/";

$link = mysqli_connect($mySQLserver, $mySQLuser, $mySQLpassword,$mySQLdefaultdb) or die ("Could not connect to MySQL");

?>