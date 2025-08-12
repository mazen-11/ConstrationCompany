<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

    try {
        require_once '../../../php/DBConn.php'; 

        $stmt = $pdo->query("SELECT * FROM bookingservice");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($products);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Failed to fetch bookingservice']);
    }

?>
