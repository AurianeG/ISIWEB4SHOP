<?php
if (isset($_GET['ajouter_id'])) {
    $ajouter_id = $_GET['ajouter_id'];
    $quantite = $_POST['quantite'];
    if (!panierExists($_SESSION['customer_id'])) {
        createPanier($_SESSION['customer_id']);
    }
    $panier_id = getPanierId($_SESSION['customer_id']);
    ajouterProduit($panier_id, $ajouter_id, $quantite);
}

if(isset($_GET['id'])){
    $item_id = $_GET['id'];
    $donnees['produit'] =getItemAndReviews($item_id);
    foreach ($donnees['produit']['reviews'] as $key => $value) {
        $nom=getNom($value['id_user']);
        if($nom==null){
            $donnees['produit']['reviews'][$key]['nom'] = 'anonyme';
        }
        else{
            $donnees['produit']['reviews'][$key]['nom'] = $nom['username'];
        }
    }
        $donnees['moyNote'] = getMoyenne($item_id);
    if ( strpos((float)$donnees['moyNote']['moyenne'], '.') !== false) {
        $donnees['moyNote']['demi'] = true;
    } else {
        $donnees['moyNote']['demi'] = false;
    }

    if(isset($_GET['note'])){
        $note = $_GET['note'];
        $title = $_GET['title'];
        $commentaire = $_GET['description'];
        $customer_id = $_SESSION['customer_id'];
        $item_id = $_GET['id'];
        echo $nom;
        addReview($note, $title, $commentaire, $customer_id, $item_id);
        header('Location: index.php?module=produit&action=ficheProduit&id='.$item_id);
    }


}
else{
    header('Location: index.php');
}