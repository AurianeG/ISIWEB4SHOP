<?php
$order_id= $_GET['order_id'];
$order =getDetailOrder($order_id);
$customer_id = $order[0]['customer_id'];
$donnees['order'] = $order;

if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['numNomRue']) && isset($_POST['ville']) && isset($_POST['cp']) && isset($_POST['pays']) ){

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $numNomRue = $_POST['numNomRue'];
    if (isset($_POST['compl'])){
        $complement = $_POST['compl'];
    }
    else{
        $complement = "";
    }
    $ville = $_POST['ville'];
    $code_postal = (int)$_POST['cp'];
    $pays = $_POST['pays'];

   setAdresse($nom,$prenom,$numNomRue,$complement,$ville,$code_postal,$pays,$order_id, $customer_id);   
} 
if (isset($_POST['adresse'])) {
    $adresse = $_POST['adresse'];
    setAdresseId($adresse,$order_id,$customer_id);
}
