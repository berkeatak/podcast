<?php

require (__DIR__) . '/connect.php'; // Verbindung zur Datenbank herstellen

// Abfrage der Abonnenten-Namen aus der Tabelle "abonnent"
$stmt_abonnenten = $pdo->query("SELECT id, name FROM abonnent"); // SQL-Abfrage, um alle Abonnenten-IDs und -Namen zu holen
$abonnenten = $stmt_abonnenten->fetchAll(PDO::FETCH_ASSOC); // Ergebnisse als assoziatives Array speichern

// Abfrage der Podcast-Titel aus der Tabelle "podcast"
$stmt_podcasts = $pdo->query("SELECT id, titel FROM podcast"); // SQL-Abfrage, um alle Podcast-IDs und -Titel zu holen
$podcasts = $stmt_podcasts->fetchAll(PDO::FETCH_ASSOC); // Ergebnisse als assoziatives Array speichern

if($_SERVER['REQUEST_METHOD'] == 'POST') { // Überprüfen, ob das Formular per POST gesendet wurde
    $id = $_POST['id']; // ID aus dem Formular holen
    $abonnent_id = $_POST['abonnent_id']; // Abonnenten-ID aus dem Formular holen
    $podcast_id = $_POST['podcast_id']; // Podcast-ID aus dem Formular holen
    $abonniert_am = $_POST['abonniert_am']; // Datum des Abonnements aus dem Formular holen
    $bewertung = $_POST['bewertung']; // Bewertung aus dem Formular holen

    // SQL-Anweisung vorbereiten, um einen neuen Datensatz in die Tabelle "abonnement" einzufügen
    $stmt = $pdo->prepare("INSERT INTO `abonnement` (`id`, `abonnent_id`, `podcast_id`, `abonniert_am`, `bewertung`) VALUES (:id, :abonnent_id, :podcast_id, :abonniert_am, :bewertung)");
    $stmt->bindValue(':id', $id); // Platzhalter ":id" durch den Wert von $id ersetzen
    $stmt->bindValue(':abonnent_id', $abonnent_id); // Platzhalter ":abonnent_id" durch den Wert von $abonnent_id ersetzen
    $stmt->bindValue(':podcast_id', $podcast_id); // Platzhalter ":podcast_id" durch den Wert von $podcast_id ersetzen
    $stmt->bindValue(':abonniert_am', $abonniert_am); // Platzhalter ":abonniert_am" durch den Wert von $abonniert_am ersetzen
    $stmt->bindValue(':bewertung', $bewertung); // Platzhalter ":bewertung" durch den Wert von $bewertung ersetzen
    $stmt->execute(); // SQL-Anweisung ausführen

    header('location:index.php'); // Benutzer zur "index.php"-Seite weiterleiten
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonnement anlegen</title>

    <!-- Styling für das Formular und Layout -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .button-container button {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button-container button.create {
            background: #007bff;
            color: white;
            margin-right: 5px;
        }

        .button-container button.create:hover {
            background: #0056b3;
        }

        .button-container button.cancel {
            background: #dc3545;
            color: white;
            margin-left: 5px;
        }

        .button-container button.cancel:hover {
            background: #c82333;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Überschrift des Formulars -->
        <h3>Abonnement anlegen</h3>

        <!-- Formular zum Anlegen eines Abonnements -->
        <form action="" method="POST">
            
            <!-- Eingabe: ID des Abonnements -->
            <label for="id">ID</label>
            <input type="number" id="id" name="id" required>

            <!-- Dropdown: Auswahl eines Abonnenten -->
            <label for="abonnent_id">Abonnent</label>
            <select id="abonnent_id" name="abonnent_id" required>
                <option value="">Bitte wählen</option>
                <?php foreach($abonnenten as $abonnent): ?>
                    <option value="<?php echo $abonnent['id']; ?>">
                        <?php echo $abonnent['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Dropdown: Auswahl eines Podcasts -->
            <label for="podcast_id">Podcast</label>
            <select id="podcast_id" name="podcast_id" required>
                <option value="">Bitte wählen</option>
                <?php foreach($podcasts as $podcast): ?>
                    <option value="<?php echo $podcast['id']; ?>">
                        <?php echo $podcast['titel']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Eingabe: Datum und Uhrzeit der Abonnementserstellung -->
            <label for="abonniert_am">Abonniert am</label>
            <input type="datetime-local" id="abonniert_am" name="abonniert_am" required>

            <!-- Eingabe: Bewertung (1 bis 5) -->
            <label for="bewertung">Bewertung</label>
            <input type="number" min="1" max="5" step="1" id="bewertung" name="bewertung" required>

            <!-- Buttons: Formular absenden oder abbrechen -->
            <div class="button-container">
                <!-- Button zum Absenden des Formulars -->
                <button type="submit" class="create">ANLEGEN</button>
                
                <!-- Button zum Abbrechen (leitet zurück zur Startseite) -->
                <button type="button" class="cancel" onclick="window.location.href='index.php'">ABBRECHEN</button>
            </div>
        </form>
    </div>
</body>

</html>




