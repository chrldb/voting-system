# Anonymous and Secure Voting System

Welcome to the official repository of the Anonymous and Secure Voting System, developed by the Pôle IT. This project aims to provide a digital voting platform that prioritizes user privacy, security, and transparency.

## 🚀 Features

	•	Anonymity: Votes are stored using UUIDs, ensuring they cannot be traced back to individual users.
	•	Security: All communications are encrypted, and the backend includes measures to prevent duplicate voting.
	•	User-Friendly: Responsive frontend with a confirmation popup to prevent accidental submissions.
	•	Open Source: Transparency is at the core of this project. The core voting logic is open for audits and improvements.

## 📂 Repository Structure

The repository is organized as follows:
```cleartext
.
├── vote.php             # Main voting page
├── process_vote.php     # Backend logic for processing votes
├── /css                 # Stylesheets for the frontend
├── /images              # Assets such as banners or icons
├── /docs                # Documentation (e.g., LaTeX white paper)
└── README.md            # Project overview and usage instructions
```

## 🛠️ How It Works

	1.	Frontend: Users interact with a responsive web interface to cast their votes.
	•	A confirmation popup ensures no accidental submissions.
	2.	Backend: Processes votes by:
	•	Generating a unique UUID for each vote.
	•	Validating the user’s session to prevent duplicate voting.
	3.	Database: Securely stores votes (UUID + vote value), ensuring separation from user data.

### Example Code Snippet
```php
function uuidv4() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant
    return bin2hex($data);
}
```
## 🔒 Security Measures

	•	UUID Anonymization: Each vote is associated with a unique identifier, ensuring no link between a voter and their vote.
	•	Session Validation: Prevents duplicate voting without storing sensitive user information.
	•	Encrypted Communication: All data exchanges are secured via HTTPS.

## 📜 Open Source Philosophy

Transparency is a cornerstone of this project. By making the core voting logic open source, we invite:
	•	Community Audits: Help us identify potential vulnerabilities.
	•	Contributions: Collaborate to enhance the system.

Repository Link

## 🛠️ Installation and Usage

### Prerequisites

	•	PHP 7.4 or higher
	•	MySQL or MariaDB
	•	A web server (e.g., Apache, Nginx)

### Installation

	1.	Clone the repository:

git clone https://github.com/bdbcentralesupelec/voting-system.git
cd voting-system


	2.	Set up the database using the provided schema (located in /docs/schema.sql).
	3.	Configure your environment variables in config.php:

$DATABASE_HOST = 'your-db-host';
$DATABASE_USER = 'your-db-user';
$DATABASE_PASS = 'your-db-password';
$DATABASE_NAME = 'your-db-name';


	4.	Deploy the application on your server.

### Running the System

	1.	Open the voting page:

https://your-domain/vote.php


	2.	Cast a vote and ensure the confirmation popup is displayed.
	3.	Check the database to verify that votes are anonymized and securely stored.

## 🤝 Contributions

We welcome contributions to improve this system! To contribute:
	1.	Fork the repository.
	2.	Create a new branch for your feature:

git checkout -b feature-name


	3.	Commit your changes and open a pull request.

## 🐞 Issues

If you encounter any issues, please open an issue on this repository, or contact us directly at it@bdbcs.fr.

## 📄 License

This project is licensed under the MIT License. See the LICENSE file for details.

## 💬 Acknowledgments

This project was developed as part of the initiatives of the Pôle IT. Special thanks to the contributors and community members who helped make this project a reality.
