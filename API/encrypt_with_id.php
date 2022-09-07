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


$id_1= $json["id_1"];
$id_2= $json["id_2"];


$data= $json["data"];
$jumlah_data = count($json["data"]);

//echo "<br>mySQLdefaultdb=".$mySQLdefaultdb;
//echo "<br>mySQLpassword=".$mySQLpassword;
//echo "<br>jumlah_data=".$jumlah_data;
//echo "<br>json=".json_encode($json,true);
//echo "<br>data=".json_encode($data,true);


$headers = getallheaders();
$header_Client_ID = $headers["Client-ID"];
$header_Pass_Key = $headers["Pass-Key"];


$check_headers = check_headers($header_Client_ID,$header_Pass_Key,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

$check_apps_exists = check_appsid_appstoken($AppsID,$Apps_TOKEN,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);


if ($check_headers==0) {
	$returnData1 = array(
		 'status' => '400',
		 'result' => 'Header Client-ID and header_Pass_Key NOT matched!',
	);
	echo sendMessage($returnData1);
	exit;
}

if ($check_apps_exists==0) {
	$returnData1 = array(
		 'status' => '400',
		 'result' => 'AppsID and Apps_TOKEN not matched!',
	);
	echo sendMessage($returnData1);
	exit;
}

$string_key_random_data = set_string_key_specific($id_1,$id_2,$link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);

list($id1,$id2,$string_key)= explode("||",$string_key_random_data);

//echo "<br>id1=".$id1;
//echo "<br>id2=".$id2;
//echo "<br>string_key=".$string_key;

if ($id1=="" || $id2=="" || $string_key==""  ) {
	$returnData1 = array(
		 'status' => '400',
		 'result' => 'no password encryption key for this ID!',
	);
	echo sendMessage($returnData1);
	exit;	
}

for ($i=0;$i<$jumlah_data;$i++) {
	//echo "<br>i=".$i;
	//echo "<br>jumlah_data=".$jumlah_data;
	$data_field=$json["data"][$i]["data_field"];
	$data_raw=$json["data"][$i]["data_raw"];
	
	//echo "<br>data_field=".$data_field;
	//echo "<br>data_raw=".$data_raw;


	$result_encrypt = encrypt($data_raw,$string_key);
	//echo "<br>result_encrypt=".$result_encrypt;
	$returnData2[] = array(
		 'data_field' => $data_field,
		 'data_result' => $result_encrypt,
	);

	//echo "<br>returnData2[] = ".$returnData2[];

}

	 $returnData1 = array(
	  'ID_1' => $id1,
	  'ID_2' => $id2,
	  'data' => $returnData2,
	  'AppsID' => $AppsID,
	  'status' => '200',
	  );

	echo sendMessage($returnData1);


?>