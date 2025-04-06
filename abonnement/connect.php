
<?php

//neue Instanz der Klasse PDO; dient zum Erstellen einer Verbindung
try {
$pdo = new PDO('mysql:host=localhost;dbname=podcast', 'root', '');
}

catch (PDOException $e) {
    echo "Keine Verbindung zur Datenbank";
    die();
}
