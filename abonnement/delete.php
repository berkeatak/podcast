
<?php

require (__DIR__) . '/connect.php';

if(isset($_GET['deleteId'])) {
    $id = $_GET['deleteId'];
    
    $stmt = $pdo->prepare('DELETE FROM `abonnement` WHERE `id`=:id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    header('location:index.php');
} else {
    echo "keine Datensatz-ID zum Löschen übertragen";
}
