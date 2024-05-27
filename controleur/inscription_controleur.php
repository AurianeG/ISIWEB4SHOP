<?php
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!(strlen($username) > 0 && strlen($password) > 0)) {
        $donnees['error'] = 'Veuillez remplir tous les champs';
        return;
    }
    if (usernameExists($username)) {
        $donnees['error'] = 'Ce nom d\'utilisateur existe déjà';
        return;
    }
    $customer_id = createRegisteredCustomerReturnId($_POST['forname'], $_POST['surname'], $_POST['phone'], $_POST['email']);
    $password = password_hash($password, PASSWORD_DEFAULT);
    createUser($username, $password, $customer_id);
    $_SESSION['username'] = $username;
    $_SESSION['customer_id'] = $customer_id;
    header('Location: index.php?page=accueil');
}
?>