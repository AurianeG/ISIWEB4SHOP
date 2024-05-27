<?php
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(strlen($username) > 0 && strlen($password) > 0){
            if(usernameExists($username)){
                $correctHash = getPassHash($username);
                if(password_verify($password, $correctHash['password'])){
                    $_SESSION['username'] = $username;
                    $_SESSION['customer_id'] = getCustomerId($username);
                    header('Location: index.php?page=accueil');
                }else{
                    $donnees['error'] = "Mot de passe incorrect";
                }
            }else{
                if(usernameExistsAdmin($username)){
                    $correctHash = getPassHashAdmin($username);
                    if(password_verify($password, $correctHash['password'])){
                        $_SESSION['usernameAdmin'] = $username;

                        header('Location: index.php?page=accueil');
                    }else{
                        $donnees['error'] = "Mot de passe incorrect";
                    } 
                }else{
                $donnees['error'] = "Nom d'utilisateur incorrect";
            }   
        }
        }else {
            $donnees['error'] = "Veuillez remplir tous les champs";
        
        }
    }
?>