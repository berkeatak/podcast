<?php

require (__DIR__) . '/connect.php'; // Verbindung zur Datenbank herstellen

if(isset($_GET['updateId'])) { // Überprüfen, ob die "updateId" in der URL vorhanden ist
    $id = $_GET['updateId']; // ID des zu bearbeitenden Datensatzes aus der URL holen
    
    // SQL-Anweisung vorbereiten, um den Datensatz mit der angegebenen ID aus der Tabelle "abonnement" auszuwählen
    $stmt = $pdo->prepare('SELECT * FROM `abonnement` WHERE `id`=:id');
    $stmt->bindValue(':id', $id); // Platzhalter ":id" durch den Wert von $id ersetzen
    $stmt->execute(); // SQL-Anweisung ausführen

    $result = $stmt->fetch(PDO::FETCH_ASSOC); // Datensatz als assoziatives Array speichern
    
    $abonnent_id = $result['abonnent_id']; // Abonnenten-ID aus dem Datensatz holen
    $podcast_id = $result['podcast_id']; // Podcast-ID aus dem Datensatz holen
    $abonniert_am = $result['abonniert_am']; // Datum des Abonnements aus dem Datensatz holen
    $bewertung = $result['bewertung']; // Bewertung aus dem Datensatz holen

    // Abfrage der Abonnenten-Namen aus der Tabelle "abonnent"
    $stmt_abonnenten = $pdo->query("SELECT id, name FROM abonnent"); // SQL-Abfrage, um alle Abonnenten-IDs und -Namen zu holen
    $abonnenten = $stmt_abonnenten->fetchAll(PDO::FETCH_ASSOC); // Ergebnisse als assoziatives Array speichern

    // Abfrage der Podcast-Titel aus der Tabelle "podcast"
    $stmt_podcasts = $pdo->query("SELECT id, titel FROM podcast"); // SQL-Abfrage, um alle Podcast-IDs und -Titel zu holen
    $podcasts = $stmt_podcasts->fetchAll(PDO::FETCH_ASSOC); // Ergebnisse als assoziatives Array speichern
}

if($_SERVER['REQUEST_METHOD'] === 'POST') { // Überprüfen, ob das Formular per POST gesendet wurde
    $abonnent_id = $_POST['abonnent_id']; // Abonnenten-ID aus dem Formular holen
    $podcast_id = $_POST['podcast_id']; // Podcast-ID aus dem Formular holen
    $abonniert_am = $_POST['abonniert_am']; // Datum des Abonnements aus dem Formular holen
    $bewertung = $_POST['bewertung']; // Bewertung aus dem Formular holen
    
    // SQL-Anweisung vorbereiten, um den Datensatz in der Tabelle "abonnement" zu aktualisieren
    $stmt = $pdo->prepare('UPDATE `abonnement` SET `abonnent_id`=:abonnent_id, `podcast_id`=:podcast_id, `abonniert_am`=:abonniert_am, `bewertung`=:bewertung WHERE `id`=:id');
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
    <title>Abonnement bearbeiten</title>

    <!-- CSS-Styling für Layout und Design -->
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

        .button-container button.update {
            background: #28a745;
            color: white;
            margin-right: 5px;
        }

        .button-container button.update:hover {
            background: #218838;
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
        <h3>Abonnement bearbeiten</h3>

        <!-- Formular zum Bearbeiten eines bestehenden Abonnements -->
        <form action="" method="POST">

            <!-- Dropdown zur Auswahl des Abonnenten -->
            <label for="abonnent_id">Abonnent</label>
            <select id="abonnent_id" name="abonnent_id" required>
                <?php foreach($abonnenten as $abonnent): ?>
                    <!-- Setzt das ausgewählte Element basierend auf $abonnent_id -->
                    <option value="<?php echo $abonnent['id']; ?>"
                        <?php if($abonnent['id'] == $abonnent_id) echo 'selected'; ?>>
                        <?php echo $abonnent['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Dropdown zur Auswahl des Podcasts -->
            <label for="podcast_id">Podcast</label>
            <select id="podcast_id" name="podcast_id" required>
                <?php foreach($podcasts as $podcast): ?>
                    <!-- Setzt das ausgewählte Element basierend auf $podcast_id -->
                    <option value="<?php echo $podcast['id']; ?>"
                        <?php if($podcast['id'] == $podcast_id) echo 'selected'; ?>>
                        <?php echo $podcast['titel']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Eingabefeld für das Datum, wann abonniert wurde -->
            <label for="abonniert_am">Abonniert am</label>
            <input type="datetime-local" id="abonniert_am" name="abonniert_am" required
                value="<?php echo $abonniert_am; ?>">

            <!-- Eingabefeld für die Bewertung (1 bis 5 Sterne) -->
            <label for="bewertung">Bewertung</label>
            <input type="number" min="1" max="5" step="1" id="bewertung" name="bewertung" required
                value="<?php echo $bewertung; ?>">

            <!-- Buttons zum Speichern oder Abbrechen -->
            <div class="button-container">
                <!-- Speichern-Button mit Bestätigungsabfrage -->
                <button type="submit" class="update"
                    onclick="return confirm('Möchtest du die Änderungen wirklich speichern?');">ÄNDERN</button>

                <!-- Abbrechen-Button, der zur Startseite zurückführt -->
                <button type="button" class="cancel" onclick="window.location.href='index.php'">ABBRECHEN</button>
            </div>

        </form>
    </div>
</body>

</html>
