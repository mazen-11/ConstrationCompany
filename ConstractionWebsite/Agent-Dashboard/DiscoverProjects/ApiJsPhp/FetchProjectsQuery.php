<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Max-Age: 86400'); // 24 hours
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1
header('Pragma: no-cache'); // HTTP 1.0
header('Expires: 0'); // Proxies
header('Access-Control-Allow-Credentials: true');

try {
    require_once '../../../DBMySql/DBConn.php';

    $stmt = $pdo->query("SELECT * FROM bookingservice ORDER BY BookingDate DESC;");
    $Project = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($Project);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Failed to fetch products']);
}
?>