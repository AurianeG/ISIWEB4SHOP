<?php
$order_id=$_GET['order_id'];
$order=getDetailOrder($order_id);
$customer=getCustomerById($order[0]['customer_id']);
if($customer['add1']!=null){
    $adresses[0]['id']=$customer['add1'];
    $adresses[0]['add']=getAdresse($customer['add1']);
}
else{
    $adresses=null;
}
if($customer['add2']!=null){
    $adresses[1]['id']=$customer['add2'];
    $adresses[1]['add']=getAdresse($customer['add2']);
}
if($customer['add3']!=null){
    $adresses[2]['id']=$customer['add2'];
    $adresses[2]['add']=getAdresse($customer['add3']);
}

$donnees['adresses']=$adresses;
$donnees['customer']=$customer;
$donnees['order']=$order[0];
