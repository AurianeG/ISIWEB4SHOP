<?php
if(isset($_GET['supprimer'])){
    $supprimer_id = $_GET['supprimer'];
    if($_SESSION['customer_id'] == getOrderItemCustomerId($supprimer_id)){
        supprimerProduitPanier($supprimer_id);
    }
    header('Location: index.php?page=panier');
}

$donnees["total"] = 0;
$donnees["panier"] = getPanier($_SESSION['customer_id']);
if($donnees['panier']!=null){
    foreach ($donnees["panier"] as $key => $value) {
        $produit = getProduct($value["product_id"]);
        $donnees["panier"][$key]["name"] = $produit["name"];
        $donnees["panier"][$key]["price"] = $produit["price"];
        $donnees["panier"][$key]["image"] = $produit["image"];
        $donnees["total"] += $donnees["panier"][$key]["price"] * $donnees["panier"][$key]["quantity"];
    }
}
?>