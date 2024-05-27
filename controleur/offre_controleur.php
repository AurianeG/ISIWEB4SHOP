<?php
$id = $_GET['id'];
$donnees["offre"] = getOffre($id);
$donnees["type"] = ["Boisson", "Biscuits", "Fruits secs"][$id - 1];
$donnees["id"] = $id;

if (isset($_GET['ajouter_id'])) {
    $ajouter_id = $_GET['ajouter_id'];
    $quantite = $_POST['quantite'];
    if (!panierExists($_SESSION['customer_id'])) {
        createPanier($_SESSION['customer_id']);
    }
    $panier_id = getPanierId($_SESSION['customer_id']);
    ajouterProduit($panier_id, $ajouter_id, $quantite);
}
?>