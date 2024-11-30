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

// Simuler un utilisateur statique pour cette version simplifiée
$user = 'example_user';

// Vérification si l'utilisateur a déjà voté
$query = "SELECT vote FROM cotisants WHERE username = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('s', $user);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

// Redirection si l'utilisateur a déjà voté
if ($user_data && $user_data['vote'] == 0) {
    header('Location: /already/');
    exit;
}

// Fermeture de la connexion
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anonymous Voting System</title>
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background: linear-gradient(135deg, #1cc88a, #4e73df);
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
            margin: 0;
        }

        header p {
            font-size: 1rem;
            margin-top: 10px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .vote-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .vote-container img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 12px;
        }

        h1 {
            color: #4e73df;
            margin-top: 20px;
            font-size: 2rem;
        }

        p.description {
            font-size: 1.1rem;
            color: #6c757d;
            margin: 15px 0;
        }

        .vote-options {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
        }

        .vote-option {
            flex: 1;
            text-align: center;
            padding: 20px;
            border: 2px solid transparent;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .vote-option:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .vote-option h2 {
            font-size: 1.5rem;
            margin: 10px 0;
        }

        .vote-option p {
            font-size: 1rem;
            color: #6c757d;
        }

        .vote-option input[type="radio"] {
            display: none;
        }

        .vote-option.selected {
            border-color: #4e73df;
        }

        button {
            display: block;
            margin: 0 auto;
            background-color: #1cc88a;
            color: #ffffff;
            font-size: 1.2rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #17a673;
            transform: scale(1.05);
        }

        .footer-note {
            margin-top: 20px;
            padding-top: 20px;
            font-size: 0.9rem;
            color: #6c757d;
            border-top: 1px solid #e3e6f0;
            text-align: center;
        }

        .footer-note a {
            color: #4e73df;
            text-decoration: none;
            font-weight: bold;
        }

        .footer-note a:hover {
            text-decoration: underline;
        }

        /* Popup Styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .popup-content h2 {
            color: #4e73df;
            margin-bottom: 10px;
        }

        .popup-content p {
            color: #6c757d;
            font-size: 1rem;
            margin: 15px 0;
        }

        .popup-buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .popup-buttons button {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .popup-buttons .confirm {
            background-color: #1cc88a;
            color: white;
        }

        .popup-buttons .confirm:hover {
            background-color: #17a673;
        }

        .popup-buttons .cancel {
            background-color: #e74a3b;
            color: white;
        }

        .popup-buttons .cancel:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <h1>Your Vote Shapes the Future</h1>
        <p>Join others in making a meaningful decision.</p>
    </header>

    <!-- Main Container -->
    <div class="container">
        <div class="vote-container">
            <!-- Image -->
            <img src="/images/vote_banner.jpg" alt="Vote Banner">

            <!-- Description -->
            <h1>Make Your Voice Heard</h1>
            <p class="description">
                Please choose between the two options below. Your vote is anonymous and contributes to shaping the future.
            </p>

            <!-- Form -->
            <form id="vote-form" method="post" action="/process_vote.php">
                <div class="vote-options">
                    <label class="vote-option">
                        <input type="radio" name="vote_value" value="0" required>
                        <h2>Option 1</h2>
                        <p>Description for option 1</p>
                    </label>
                    <label class="vote-option">
                        <input type="radio" name="vote_value" value="1" required>
                        <h2>Option 2</h2>
                        <p>Description for option 2</p>
                    </label>
                </div>
                <button type="button" id="submit-button">Submit Your Vote</button>
            </form>

            <!-- Note -->
            <div class="footer-note">
                <p>Your vote is completely anonymous. <a href="/anonymity-policy/">Learn more</a>.</p>
            </div>
        </div>
    </div>

    <!-- Confirmation Popup -->
    <div class="popup-overlay" id="confirmation-popup">
        <div class="popup-content">
            <h2>Confirm Your Vote</h2>
            <p>Are you sure you want to submit your vote? This action cannot be undone.</p>
            <div class="popup-buttons">
                <button class="confirm" id="confirm-submit">Yes, Submit</button>
                <button class="cancel" id="cancel-submit">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        // Highlight selected option
        document.querySelectorAll('.vote-option').forEach(option => {
            option.addEventListener('click', () => {
                document.querySelectorAll('.vote-option').forEach(opt => opt.classList.remove('selected'));
                option.classList.add('selected');
                option.querySelector('input[type="radio"]').checked = true;
            });
        });

        // Popup logic
        const submitButton = document.getElementById('submit-button');
        const popup = document.getElementById('confirmation-popup');
        const confirmSubmit = document.getElementById('confirm-submit');
        const cancelSubmit = document.getElementById('cancel-submit');
        const form = document.getElementById('vote-form');

        submitButton.addEventListener('click', () => {
            const selectedOption = document.querySelector('.vote-option input[type="radio"]:checked');
            if (!selectedOption) {
                alert('Please select an option before submitting.');
            } else {
                popup.style.display = 'flex';
            }
        });

        cancelSubmit.addEventListener('click', () => {
            popup.style.display = 'none';
        });

        confirmSubmit.addEventListener('click', () => {
            form.submit();
        });
    </script>
</body>

</html>
