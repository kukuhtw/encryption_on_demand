<?php


function check_headers($header_client_id,$header_pass_key,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {
	$sql = "select count(`id`) as `total` from `msapps` where `header_client_id`='$header_client_id' 
	and `header_pass_key`='$header_pass_key' ";
	$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);
			$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$total=0;
			foreach($conn->query($sql) as $row) {
					$total=$row['total'];
			}
			$conn=null;
	return $total;

}
function check_appsid_appstoken($AppsID,$Apps_TOKEN,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql = "select count(`id`) as `total` from `msapps` where `appsid`='$AppsID' 
	and `appstoken`='$Apps_TOKEN' ";
	$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);
			$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$total=0;
			foreach($conn->query($sql) as $row) {
					$total=$row['total'];
			}
			$conn=null;
	return $total;	
}

function check_string_key($id1,$id2,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {
	$sql = "select `string_key` from `encrypt_key` where `id`='$id1' and `id2`='$id2' ";
	$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);
			$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$string_key="";
			foreach($conn->query($sql) as $row) {
					$string_key=$row['string_key'];
			}
			$conn=null;
	return $string_key;	
}

function set_string_key_random($link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql = "select * from `encrypt_key` order by rand() limit 0,1 ";
	$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);
			$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$id="";
			$id2="";
			$string_key="";
			foreach($conn->query($sql) as $row) {
					$id=$row['id'];
					$id2=$row['id2'];
					$string_key=$row['string_key'];

			}
			$conn=null;
	$return_data = $id."||".$id2."||".$string_key;		

	 return $return_data;	

}



function set_string_key_specific($id_1,$id_2,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

	$sql = "select * from `encrypt_key` where `id`='$id_1' and `id2`='$id_2' limit 0,1 ";
	$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);
			$conn = new PDO("mysql:host=$mySQLserver;dbname=$mySQLdefaultdb", $mySQLuser, $mySQLpassword);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$id="";
			$id2="";
			$string_key="";
			foreach($conn->query($sql) as $row) {
					$id=$row['id'];
					$id2=$row['id2'];
					$string_key=$row['string_key'];

			}
			$conn=null;
	$return_data = $id."||".$id2."||".$string_key;		

	 return $return_data;	

}

function sendMessage($parameters) {
	$jsonencodeparameters=json_encode($parameters);
	 return $jsonencodeparameters;
}


function encrypt($simple_string,$string_key) {
	
	$ciphering = "AES-128-CTR";

	$iv_length = openssl_cipher_iv_length($ciphering);
	$options   = 0;
	$encryption_iv = '1234567891011121';
	$complete_key = $string_key;
	$encryption_key = $complete_key;
	$encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);

	return $encryption;

}

function decrypt($simple_string,$string_key) {


	$ciphering = "AES-128-CTR";
	$iv_length = openssl_cipher_iv_length($ciphering);
	$options   = 0;
	$decryption_iv = '1234567891011121';
	$decryption_key = $string_key;
	$decryption = openssl_decrypt($simple_string, $ciphering, $decryption_key, $options, $decryption_iv);
	return $decryption;

}

?>