<?php
session_start(); 

include('data/config.php');

try
{
  $bdd = new PDO('mysql:host='.$bdd_url.';dbname='.$bdd_database.';charset=utf8', $bdd_login, $bdd_password);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$resultat = $bdd->query('SELECT t_object_obj.obj_name,t_price_pri.pri_credit  FROM t_object_obj INNER JOIN t_price_pri ON t_object_obj.obj_id=t_price_pri.obj_id WHERE t_object_obj.fun_id=2 AND t_object_obj.obj_type!=\'category\' AND t_price_pri.pri_removed!=1');


$lines = 0;
global $liste_objets;
while ($row = $resultat->fetch())
{
  $name = utf8_encode($row['obj_name']);
  $price = $row['pri_credit'];
  $liste_objets['objet_'.$lines]=array('name' => $name,'price' => $price);
  $lines ++;
}
$resultat->closeCursor();

if(!empty($_GET))
{
  var_dump($_GET);
  $resultat_biere = $bdd->prepare(' SELECT t_object_obj.obj_id FROM t_object_obj WHERE t_object_obj.obj_name=?');
  $resultat_biere -> execute(array($_GET['biere']));
  $id_biere_liste = $resultat_biere-> fetch();
  $id_biere=$id_biere_liste['obj_id'];

  var_dump($id_biere);

  $ajout_transaction= $bdd -> prepare('INSERT INTO t_transaction_tra (tra_id,tra_date,tra_validated,usr_id_buyer,usr_id_seller,tra_email,app_id,fun_id,tra_status,tra_callback_url,tra_return_url,tra_token,tra_ip,tra_removed) VALUES ( DEFAULT,?,?,0,2,null,2,2,\'V\',null,null,null,"10.42.10.02",null)');
  $ajout_transaction-> execute(array(date("Y-m-d H:i:s"),date("Y-m-d H:i:s")));

  $dernier_id= $bdd ->lastInsertId();

  $ajout_purchase= $bdd -> prepare('INSERT INTO t_purchase_pur (pur_id,tra_id,obj_id,pur_qte,pur_unit_price,pur_reduction,pur_price,pur_tva,pur_amount_tva,pur_removed) VALUES ( DEFAULT,?,?,1,?,null,?,0.00,0,0)');
  $ajout_purchase-> execute(array($dernier_id,$id_biere,$_GET['prix'],$_GET['prix']));
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>traider</title>
    <meta name="description" content="essai de l'algo trader"/>
  </head>
  <body>

    <p>choisisez nb_de_bière</p>
    <table>
      <tr>
        <td>article</td>
        <td>prix de vente</td>
        <td>prix de reviens</td>
        <td>nombre de biere dispo</td>
      </tr>
      <?php 

      foreach ($liste_objets as $num_objet => $tableau) 
      {
        echo ( "
                <input name=\"".$tableau['name']."\" value=\"".$tableau['name']."\" type=\"hidden\">
                <tr>
                  <td>".$tableau['name']."</td>
                  <td>".$tableau['price']."</td>

                  <td><a href=\"simulation_bar.php?biere=".$tableau['name']."&amp;prix=".$tableau['price']."\" ><input type=\"button\" style=\"width:100px;height:30px;\" name=\"".$tableau['name']."_prix_reviens\"></a></td>
                </tr>");
      }; ?>
    </table>
  </body>
</html>