<?php 
if(isset($donnees['usernameAdmin'])){
   
    $donnees['orders']=getOrders();
    
}
else{
    header('Location: index.php?page=accueil');
}