<?php 
if(isset($donnees['usernameAdmin'])){
    
    if (isset($_GET['order_id'])) {
        $donnees['order'] = getDetailOrder($_GET['order_id'])[0];
        $donnees['orderItems'] = getDetailOrderItems($_GET['order_id']);
        $donnees['customer'] = getCustomerById($donnees['order']['customer_id']);
        $add=getAdresse($donnees['order']['delivery_add_id']);
        $donnees['adresse']=$add;
        
        if(isset($_GET['status'])){
            updateStatus($_GET['order_id'],$_GET['status']);
            header('Location: index.php?page=detailCommande&order_id='.$_GET['order_id']);
        }
    }
    else {
        header('Location: index.php?page=accueil');
    }
}
else{
    header('Location: index.php?page=accueil');
}