<?php
// ====================================================================================REGISTER==================================================================
// securityController: register
    // - filtre champs du form 
    // - si les filtres sont valides, on verifie que le mail nexiste pas déja en bdd (clés rouges: unique)
    // - on verifie que le pseudo nexiste pas (clés rouges: unique)
    // - on verifie que les 2 mdp du formulaire sont les memes
    // - on hache le mdp
    // - on ajoute l'utilisateur en bdd



$password= "monMotdePasse1234";
$password2= "monMotdePasse1234";

//fonction php hash avec 2 arguments (algorithme utilisé, variable)

// --------------------------------------algorithmie de hachage faible-----------------

// --------------------md5-------------

$md5 = hash('md5', $password);
$md5_2 = hash('md5', $password2);

echo $md5;
echo "<br>";
echo $md5_2;
echo "<br>";

// ------------------sha256--------------
$sha256= hash('sha256', $password);
$sha256_2= hash('sha256', $password2);
echo $sha256;
echo "<br>";
echo $sha256_2;
echo "<br>";
//la version hachée avec md5 et sha256 ne changent pas au refresh
//avec exactement la meme chaine de caractere le hachage renvoit exactement la meme chose

// ----------------------------------------algorithmie de hachage fort-----------------------------

//https://www.php.net/manual/fr/faq.passwords.php voir schema

//en base de données on stoque une EMPREINTE NUMERIQUE (prevoir un champ de 255caracteres):
    // - algorithm : prefixe qui symbolise la version de l'algorithme
    // - cost (cout) : variable qui détermine le cout algorithmique qui doit etre utilisé
    // - salt (sel) : string rajouté pour constituer une chaine de caractere plus longue 
    // - mdp haché

//cette fonction attend en premier parametre le mdp puis l'algorithme
// --> il est recommandé d'utiliser password_default qui correspond automatiquement au dernier algorithme reconnu le plus puissant
//crée un nouveau hachage en utilisant un algorithme fort et irréversible (impossible de le décoder)

$hash = password_hash($password, PASSWORD_DEFAULT);
$hash2 = password_hash($password2, PASSWORD_ARGON2I);
echo $hash;
echo "<br>";
echo $hash2;
echo "<br>";
echo "<br>";
echo "<br>";

// saisie dans le formulaire de login
$saisie = "monMotdePasse1234";

//cette fonction attend la saisie puis le hachage créé SEULEMENT à travers la fonction password_hash()
// compare les empreintes numériques: renvoie un booleen
$check = password_verify($saisie, $hash);
$user ="Laure"; //en realite un objet

//la connexion se passe a travers $_SESSION

if($check){
    echo "Mot de passe correspondant";
    // $_SESSION['user'] = $user; 
} else {
    echo "Mot de passe incorrect !";
}


// ====================================================================================LOGIN==================================================================
    // - filtre les champs du formulaire
    // - s'ils passent on retrouve le password correspondant au mail
    // - si on le trouve, on récupère le hash de la bdd
    // - on retrouve l'utilisateur
    // - on verifie le mdp (password_verify)
    // - si on arrive à se connecter on fait passer le user en session
    // - si aucune des conditions ne passent -> msg d'erreur