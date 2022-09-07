<?php
include("db.php");
include("function.php");

date_default_timezone_set("Asia/Jakarta");
$tanggalhariini = date("Y/m/d");
$jamhariini = date("H:i:sa");
$saatini = $tanggalhariini. " ".$jamhariini;
$saatini_tanpaampm = str_replace("am", "", $saatini);
$saatini_tanpaampm = str_replace("pm", "", $saatini_tanpaampm);
$saatini = $saatini_tanpaampm;
$content = file_get_contents("php://input");

$json = json_decode($content, true);

$AppsID= $json["AppsID"];
$Apps_TOKEN= $json["Apps_TOKEN"];
$Organization= $json["Organization"];

$data= $json["data"];
$jumlah_data = count($json["data"]);


$id_1= $json["id_1"];
$id_2= $json["id_2"];



$headers = getallheaders();
$header_Client_ID = $headers["Client-ID"];
$header_Pass_Key = $headers["Pass-Key"];

$check_headers = check_headers($header_Client_ID,$header_Pass_Key,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


if ($check_headers==0) {
	$returnData1 = array(
		 'status' => '400',
		 'result' => 'Header Client-ID and header_Pass_Key NOT matched!',
	);
	echo sendMessage($returnData1);
	exit;
}


$check_apps_exists = check_appsid_appstoken($AppsID,$Apps_TOKEN,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

if ($check_apps_exists==0) {
	$returnData1 = array(
		 'status' => '400',
		 'result' => 'AppsID and Apps_TOKEN not matched!',
	);
	echo sendMessage($returnData1);
	exit;
}

$string_key = check_string_key($id_1,$id_2,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

//echo "<br>string_key=".$string_key;

for ($i=0;$i<$jumlah_data;$i++) {
	//echo "<br>i=".$i;
	//echo "<br>jumlah_data=".$jumlah_data;
	$data_field=$json["data"][$i]["data_field"];
	$data_raw=$json["data"][$i]["data_raw"];
	
	//echo "<br>data_field=".$data_field;
	//echo "<br>data_raw=".$data_raw;

	$result_decrypt = decrypt($data_raw,$string_key);
	//echo "<br>result_decrypt=".$result_decrypt;
	$returnData2[] = array(
		 'data_field' => $data_field,
		 'data_result' => $result_decrypt,
	);

	//echo "<br>returnData2[] = ".$returnData2[];
	
}

	$returnData1 = array(
	  'ID_1' => $id_1,
	  'ID_2' => $id_2,
	  'data' => $returnData2,
	  'AppsID' => $AppsID,
	  'status' => '200',
	  );

	echo sendMessage($returnData1);


?>