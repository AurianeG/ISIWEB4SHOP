<?php
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'modele/modele.php';
require 'lib/fpdf.php';

session_start();
$donnees = [];
if (isset($_SESSION['username'])) {
    $donnees['username'] = $_SESSION['username'];
}
if (isset($_SESSION['usernameAdmin'])) {
    $donnees['usernameAdmin'] = $_SESSION['usernameAdmin'];
}
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['customer_id'] = createUnregisteredCustomerReturnId();
}

require_once 'vendor/autoload.php';
$loader = new FilesystemLoader('vue');
$options_prod = array('cache' => 'cache', 'autoescape' => true);
$options_dev = array('cache' => false, 'autoescape' => true);
$twig = new Environment($loader, ['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

if (isset($_GET['page'])) {
    $cont = $_GET['page'] . "_controleur.php";
    if (file_exists("controleur/" . $cont)) {
        require "controleur/" . $cont;
        $page = $_GET['page'];
    } else {
        $page = 'accueil';
    }
} else {
    $page = 'accueil';
}
echo $twig->render($page . ".twig", $donnees);
