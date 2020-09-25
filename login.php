<?php
session_start();

if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $db = new PDO('mysql:host=localhost;dbname=loginsystem', 'root', '');

        $sql = "SELECT * FROM users where email = '$email' "; // pour savoir l'utilisateur est deja enregistre ou non
        $result = $db->prepare($sql);
        $result->execute();

        if($result->rowCount() > 0)
        {
            $data = $result->fetchAll();
            if (password_verify($pass, $data[0]["password"]))
            {
                echo "connexion effectué";
                $_SESSION['email'] = $email; // vas nous permettre de signaler aux autres pages du site que notre utilisateur est connecté
            }
        }
        else
        {
            $pass = password_hash($pass,PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (email, password) VALUES ('$email','$pass')";
            $req = $db->prepare($sql);
            $req->execute();
            echo "Enregistrement effectué";
        }
        
    }

?>