
<?php

require (__DIR__) . '/connect.php';

// Alle Datensätze anzeigen
$stmt = $pdo->prepare('SELECT * FROM `abonnement`');
$stmt->execute();

// $results ist 2D assoc Array
$results = $stmt->fetchAll(PDO::FETCH_ASSOC); 

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonnements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h3 {
            color: #333;
        }

        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #ddd;
        }

        a {
            text-decoration: none;
            color: white;
            display: inline-block;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .btn-delete {
            background-color: red;
        }

        .btn-update {
            background-color: orange;
        }

        .btn-add {
            background-color: blue;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h3>Abonnements</h3>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Abonnent ID</th>
                    <th>Podcast ID</th>
                    <th>Abonniert am</th>
                    <th>Bewertung</th>
                    <th>Abonnement löschen</th>
                    <th>Abonnement ändern</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($results as $result): ?>
                    <tr>
                        <td><?php echo $result['id'] ?></td>
                        <td><?php echo $result['abonnent_id'] ?></td>
                        <td><?php echo $result['podcast_id'] ?></td>
                        <td><?php echo $result['abonniert_am'] ?></td>
                        <td><?php echo $result['bewertung'] ?></td>
                        <td><a href="./delete.php?deleteId=<?php echo $result['id'] ?>" class="btn-delete">Löschen</a></td>
                        <td><a href="./update.php?updateId=<?php echo $result['id'] ?>" class="btn-update">Ändern</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a class="btn-add" href="./submit.php">Abonnement hinzufügen</a>
    </div>
</body>
</html>
 
