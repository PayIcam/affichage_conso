<?php

session_start(); 

$datetime = $_SESSION['datetime'];

header("Content-Type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

echo "<root>";

include('data/config.php');

$connexion = mysqli_connect($bdd_url, $bdd_login, $bdd_password, $bdd_database);

$requete = "SELECT t_object_obj.obj_name, SUM(t_purchase_pur.pur_price) AS total_price FROM t_object_obj JOIN t_price_pri, t_purchase_pur, t_transaction_tra WHERE t_object_obj.obj_id = t_price_pri.obj_id AND t_object_obj.obj_id = t_purchase_pur.obj_id AND t_transaction_tra.tra_id = t_purchase_pur.tra_id AND obj_removed=0 AND t_object_obj.fun_id=2 AND tra_date > '$datetime' GROUP BY t_object_obj.obj_id ORDER BY total_price DESC";

$resultat = mysqli_query($connexion, $requete);

$lines = 0;

while ($row = $resultat->fetch_assoc()) {
	$name = utf8_encode($row['obj_name']);
	$price = $row['total_price'];

	echo "<row name='$name' price='$price' />";

	$lines ++;
}

if($lines < 5){
	for($l = 0; $l < 4 - $lines; $l++){
		echo "<row name='---' price='0' />";
	}
}


echo "</root>";

?>