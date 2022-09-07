<?php
include("db.php");

date_default_timezone_set("Asia/Jakarta");
$tanggalhariini = date("Y/m/d");
$jamhariini = date("H:i:sa");
$saatini = $tanggalhariini. " ".$jamhariini;
$saatini_tanpaampm = str_replace("am", "", $saatini);
$saatini_tanpaampm = str_replace("pm", "", $saatini_tanpaampm);
$saatini = $saatini_tanpaampm;


$checktotaldata=checktotaldata($link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword);
echo "<h3>Total Data Encription Key : ".$checktotaldata."</h3>";

// maximum is 15,000 encryption key, but you can increase the number by
// modify value below this.
$maximum=15000;
echo "<h3>Maximum Data Encription Key : ".$maximum."</h3>";
	
for ($i=0;$i<10;$i++) {
	$id2 = rand('11111111','99999999');
	$string_key = randomPassword();
	if ($checktotaldata>=1 && $checktotaldata<=$maximum) {
		insert_data($id2,$string_key,$saatini,$link) ;
	}

	
}

function insert_data($id2,$string_key,$create_date,$link) {

$sql = " insert `encrypt_key` (`id2`,`string_key`,`create_date`) 
values 
('$id2','$string_key','$create_date') ";

$query = mysqli_query($link,$sql)or die ('gagal update data'.mysqli_error($link));
	$query=null;

}

function checktotaldata($link,$mySQLserver,$mySQLdefaultdb,$mySQLuser,$mySQLpassword) {

$sql = "select count(`id`) as `total` from `encrypt_key` ";
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

function randomPassword() {
$data = 'abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
$random_pass = array();
$string_variable = strlen($data) - 1;
$complete_password="";
for($i=0; $i<12; $i++){
	$n = rand(0,$string_variable);
	//echo "<br>n = ".$n;
	$random_pass[] = $data[$n];
	$complete_password .=$data[$n];
	//echo "<br>random_pass[] = ".$data[$n];
	//echo "<br>complete_password = ".$complete_password;
}

echo "<h3>Encryption Key Generated = ".$complete_password."</h3>" ;

	return $complete_password;
}


?>