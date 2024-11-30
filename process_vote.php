<?php
// Connexion à la base de données
$DATABASE_HOST = 'localhost'; // À remplacer par votre hôte
$DATABASE_USER = 'root'; // À remplacer par votre utilisateur
$DATABASE_PASS = ''; // À remplacer par votre mot de passe
$DATABASE_NAME = 'voting_system'; // Nom de la base de données

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Fonction pour générer un UUID unique
function uuidv4() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Version 4
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Variant
    return bin2hex($data);
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['vote_value'])) {
    $vote_value = intval($_POST['vote_value']);

    // Générer un UUID pour le vote
    $uuid = uuidv4();

    // Insérer le vote dans la table "vote"
    $insert_vote = $con->prepare("INSERT INTO vote (UUID, vote_value) VALUES (?, ?)");
    $insert_vote->bind_param('si', $uuid, $vote_value);
    $insert_vote->execute();

    // Fermer la connexion à la base de données
    $insert_vote->close();
    mysqli_close($con);

    // Redirection vers une page de remerciement
    header('Location: /thankyou/');
    exit;
} else {
    // Rediriger vers la page de vote si la requête est incorrecte
    header('Location: /vote/');
    exit;
}
?>
