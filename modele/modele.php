<?php 
include_once('dbconnect.php');

/**
 * @return array de tous les produits
 */
function getOffre($id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM products WHERE cat_id =' . $id);
    $query->execute();
    return $query->fetchAll();
}

/**
 * @return bool true si le nom d'utilisateur existe, false sinon
 */
function usernameExists($username){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM logins WHERE username = ?');
    $query->execute([$username]);
    if($query->rowCount() > 0){
        return true;
    }else{
        return false;
    }
}

/**
 * @return bool true si le nom d'administrateur existe, false sinon
 */
function usernameExistsAdmin($username){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM admin WHERE username = ?');
    $query->execute([$username]);
    if($query->rowCount() > 0){
        return true;
    }else{
        return false;
    }
}

/**
 * @return array le hash du mot de passe de l'utilisateur dont le pseudo est passé en paramètre
 * @param string $username le nom d'utilisateur
 */
function getPassHash($username){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT password FROM logins WHERE username = ?');
    $query->execute([$username]);
    return $query->fetch();
}

/**
 * @return array le hash du mot de passe de l'administrateur dont le pseudo est passé en paramètre
 * @param string $username le nom d'administrateur
 */
function getPassHashAdmin($username){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT password FROM admin WHERE username = ?');
    $query->execute([$username]);
    return $query->fetch();
}

/**
 * crée un utilisateur dans 'logins'
 * @param string $username le nom d'utilisateur
 * @param string $password le mot de passe
 * @param int $customer_id l'id du client
 */
function createUser($username, $password, $customer_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('INSERT INTO logins (username, password, customer_id) VALUES (?, ?, ?)');
    $query->execute([$username, $password, $customer_id]);
}

/**
 *  crée un client dans 'customers'
 * @param string $forname le prénom
 * @param string $surname le nom
 * @param string $phone le numéro de téléphone
 * @param string $email l'adresse mail
 * @return int l'id du client
 */
function createRegisteredCustomerReturnId($forname, $surname, $phone, $email){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('INSERT INTO customers (forname, surname, phone, email, registered) VALUES (?, ?, ?, ?, ?)');
    $query->execute([$forname, $surname,  $phone, $email, 1]);
    return $mysqlConnection->lastInsertId();
}

/**
 * crée un client non enregistré dans 'customers'
 * @return int l'id du client
 */
function createUnregisteredCustomerReturnId(){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('INSERT INTO customers (registered) VALUES (?)');
    $query->execute([0]);
    return $mysqlConnection->lastInsertId();
}

/**
 * retourne l'id du client dont le nom d'utilisateur est passé en paramètre
 * @param string $username le nom d'utilisateur
 * @return int l'id du client
 */
function getCustomerId($username){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT customer_id FROM logins WHERE username = ?');
    $query->execute([$username]);
    return $query->fetch()['customer_id'];
}

/**
 * teste si un panier existe pour un client
 * @param int $customer_id l'id du client
 * @return bool true si un panier existe, false sinon
 */
function panierExists($customer_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM orders WHERE customer_id = ? AND status >= 0 and status <= 1');
    $query->execute([$customer_id]);
    return $query->rowCount() > 0;
}

/**
 * crée un panier pour un client
 * @param int $customer_id l'id du client
 */
function createPanier($customer_id){
    global $mysqlConnection;
    if(isset($_SESSION['username'])){
        $registered = 1;
    } else {
        $registered = 0;
    }
    $query = $mysqlConnection->prepare('INSERT INTO orders (customer_id, registered, status, session) VALUES (?, ?, 0, ?)');
    $query->execute([$customer_id, $registered, session_id()]);
}

/**
 * @return array le panier du client
 * @param int $customer_id l'id du client
 */
function getPanierId($customer_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT id FROM orders WHERE customer_id = ? AND status >= 0 and status <= 1');
    $query->execute([$customer_id]);
    $data =$query->fetch();
    if($data !=null){
        return $data['id'];
    }else{
        return null;
    }
}

/**
 * ajoute un produit au panier
 * @param int $panier_id l'id du panier
 * @param int $ajouter_id l'id du produit à ajouter
 * @param int $quantite la quantité à ajouter
 */
function ajouterProduit($panier_id, $ajouter_id, $quantite){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM orderitems WHERE order_id = ? AND product_id = ?');
    $query->execute([$panier_id, $ajouter_id]);
    if($query->rowCount() > 0){
        echo "test";
        $query = $mysqlConnection->prepare('UPDATE orderitems SET quantity = quantity + ? WHERE order_id = ? AND product_id = ?');
        $query->execute([$quantite, $panier_id, $ajouter_id]);
        $query = $mysqlConnection->prepare('SELECT total FROM orders WHERE id = ?');
        $query->execute([$panier_id]);
        $total = $query->fetch()['total'];
        $total += getProduct($ajouter_id)['price'] * $quantite;
        $query = $mysqlConnection->prepare('UPDATE orders SET total = ? WHERE id = ?');
        $query->execute([$total, $panier_id]);
        return;
    }
    $query = $mysqlConnection->prepare('SELECT total FROM orders WHERE id = ?');
    $query->execute([$panier_id]);
    $total = $query->fetch()['total'];
    $total += getProduct($ajouter_id)['price']* $quantite;
    $query = $mysqlConnection->prepare('UPDATE orders SET total = ? WHERE id = ?');
    $query->execute([$total, $panier_id]);

    $query = $mysqlConnection->prepare('INSERT INTO orderitems (order_id, product_id, quantity) VALUES (?, ?, ?)');
    $query->execute([$panier_id, $ajouter_id, $quantite]);
    if ($query->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

/**
 * @return array les produits du panier
 * @param int $customer_id l'id du client
 */
function getPanier($customer_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM orderitems WHERE order_id = ?');
    $query->execute([getPanierId($customer_id)]);
    return $query->fetchAll();
}

/**
 * @return array des informations d'un produit
 * @param int $product_id l'id du produit
 */
function getProduct($product_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM products WHERE id = ?');
    $query->execute([$product_id]);
    return $query->fetch();
}

/**
 * supprime un produit du panier
 * @param int $supprimer_id l'id du produit à supprimer
 */
function supprimerProduitPanier($supprimer_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM orderitems WHERE id = ?');
    $query->execute([$supprimer_id]);
    $data = $query->fetch();
    $query = $mysqlConnection->prepare('SELECT total FROM orders WHERE id = ?');
    $query->execute([$data['order_id']]);
    $total = $query->fetch()['total'];
    $total -= getProduct($data['product_id'])['price'] * $data['quantity'];
    $query = $mysqlConnection->prepare('UPDATE orders SET total = ? WHERE id = ?');
    $query->execute([$total, $data['order_id']]);
    $query = $mysqlConnection->prepare('DELETE FROM orderitems WHERE id = ?');
    $query->execute([$supprimer_id]);
}

/**
 * @return int l'identifiant d'un client ayant dans son panier le produit passé en paramètre
 * @param int $product_id l'id du produit de la commande(orderitem)
 */
function getOrderItemCustomerId($id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT customer_id FROM orderitems INNER JOIN orders ON orderitems.order_id = orders.id WHERE orderitems.id = ?');
    $query->execute([$id]);
    return $query->fetch()['customer_id'];
}

/**
 * @return array les informations de toutes les commandes
 */
function getOrders(){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM orders');
    $query->execute();
    return $query->fetchAll();
}

/**
 * @return string l'adresse d'une commande
 * @param int $addr_id l'id de l'adresse
 */
function getAdresse($addr_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM delivery_addresses WHERE id = ?');
    $query->execute([$addr_id]);
    $data = $query->fetch();
    if($data != NULL){
        $str=$data['firstname']. ' '.$data['lastname']. ' '.$data['add1'] . ' ' . $data['add2'] . ' ' . $data['city']. ' ' . $data['postcode'];
        return $str;
    }
    return "adresse non renseignée";
}

/**
 * @return array les informations d'une commande
 * @param int $order_id l'id de la commande
 */
function getDetailOrder($order_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM orders  WHERE id = ?');
    $query->execute([$order_id]);
    return $query->fetchAll();
}

/**
 * @return array les informations des produits d'une commande
 * @param int $customer_id l'id du client
 */
function getDetailOrderItems($order_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM orderitems o JOIN products p ON o.product_id = p.id WHERE o.order_id = ?');
    $query->execute([$order_id]);
    return $query->fetchAll();
}

/**
 * @return array les informations d'un client
 * @param int $customer_id l'id du client
 */
function getCustomerById($customer_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM customers WHERE id = ?');
    $query->execute([$customer_id]);
    return $query->fetch();
}

/**
 * modifie le statut d'une commande
 * @param int $order_id l'id de la commande
 * @param int $status le nouveau statut
 */
function updateStatus($order_id,$status){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('UPDATE orders SET status = ? WHERE id = ?');
    $query->execute([$status,$order_id]);
}

/**
 * @return array les informations necessaires a l'etablissement d'une facture
 * @param int $order_id l'id de la commande
 */
function getDetailsFactures($order_id){
    $details['produits'] = getDetailOrderItems($order_id);
    $details['order'] = getDetailOrder($order_id);
    $details['customer'] = getCustomerById($details['order'][0]['customer_id']);
    $details['adresse'] = getAdresse($details['order'][0]['delivery_add_id']);
    return $details;
}

/**
 * @return array toute les notes et commentaires d'un produit
 * @param int $id l'id du produit
 */
function getItemAndReviews($id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT * FROM products WHERE id = ?');
    $query->execute([$id]);
    $data = $query->fetch();
    $query = $mysqlConnection->prepare('SELECT * FROM reviews WHERE id_product = ?');
    $query->execute([$id]);
    $data['reviews'] = $query->fetchAll();
    return $data;
}

/**
 * @return array la moyenne des notes et le nombre de notes d'un produit
 * @param int $id l'id du produit
 */
function getMoyenne($id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT AVG(stars) AS moyenne, count(stars) AS nbReviews FROM reviews WHERE id_product = ?');
    $query->execute([$id]);
    return $query->fetch();
}

/**
 * @return array le nom d'utilisateur d'un client
 * @param int $id l'id du client
 */
function getNom($id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('SELECT username FROM logins WHERE customer_id = ?');
    $query->execute([$id]);
    return $query->fetch();
}

/**
 * ajoute un commentaire et une note à un produit
 * @param int $note la note
 * @param string $title le titre du commentaire
 * @param string $commentaire le commentaire
 * @param int $id_customer l'id du client
 * @param int $item_id l'id du produit
 */
function addReview($note, $title, $commentaire, $id_customer, $item_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('INSERT INTO reviews (stars, title, description, name_user, id_product) VALUES (?, ?, ?, ?, ?)');
    $query->execute([$note, $title, $commentaire, $id_customer, $item_id]);
}

/**
 * ajoute une adresse à un client
 * @param string $nom le nom
 * @param string $prenom le prénom
 * @param string $numNomRue le numéro et le nom de la rue
 * @param string $complement le complément d'adresse
 * @param string $ville la ville
 * @param string $code_postal le code postal
 * @param string $pays le pays
 * @param int $order_id l'id de la commande
 * @param int $customer_id l'id du client
 */
function setAdresse($nom,$prenom,$numNomRue,$complement,$ville,$code_postal,$pays,$order_id, $customer_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('INSERT INTO delivery_addresses (lastname, firstname, add1, add2, city, postcode, pays ) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $query->execute([$nom,$prenom,$numNomRue,$complement,$ville,$code_postal,$pays]);
    $query = $mysqlConnection->prepare('SELECT id FROM delivery_addresses WHERE lastname = ? AND firstname = ? AND add1 = ? AND add2 = ? AND city = ? AND postcode = ? AND pays = ?');
    $query->execute([$nom,$prenom,$numNomRue,$complement,$ville,$code_postal,$pays]);
    $data = $query->fetch();
    setAdresseId($data['id'],$order_id);
    $customer =getCustomerById($customer_id);
    if($customer['add1'] == NULL){
        $query = $mysqlConnection->prepare('UPDATE customers SET add1 = ? WHERE id = ?');
        $query->execute([$data['id'],$customer_id]);
    }
    else if($customer['add2'] == NULL){
        $query = $mysqlConnection->prepare('UPDATE customers SET add2 = ? WHERE id = ?');
        $query->execute([$data['id'],$customer_id]);
    }
    else if($customer['add3'] == NULL){
        $query = $mysqlConnection->prepare('UPDATE customers SET add3 = ? WHERE id = ?');
        $query->execute([$data['id'],$customer_id]);
    }
    else{$query = $mysqlConnection->prepare('UPDATE customers SET add1 = ? WHERE id = ?');
        $query->execute([$data['id'],$customer_id]); }
}

/**
 * ajoute une adresse à une commande et modifie son statut
 * @param int $adresse l'id de l'adresse
 * @param int $order_id l'id de la commande
 */
function setAdresseId($adresse,$order_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('UPDATE orders SET delivery_add_id = ? WHERE id = ?');
    $query->execute([$adresse,$order_id]);
    $query = $mysqlConnection->prepare('UPDATE orders SET status = 1 WHERE id = ?');
    $query->execute([$order_id]);
}

/**
 * ajoute un mode de paiement et la date du paiement à une commande et modifie son statut
 * @param string $paiement le mode de paiement
 * @param int $order_id l'id de la commande
 */
function setPayment($paiement,$order_id){
    global $mysqlConnection;
    $query = $mysqlConnection->prepare('UPDATE orders SET payment_type = ? WHERE id = ?');
    $query->execute([$paiement,$order_id]);
    $date= date("Y-m-d");
    $query = $mysqlConnection->prepare('UPDATE orders SET date = ? WHERE id = ?');
    $query->execute([$date,$order_id]);
    $query = $mysqlConnection->prepare('UPDATE orders SET status = 2 WHERE id = ?');
    $query->execute([$order_id]);
}