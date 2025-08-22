<?php
// ApiJsPhp/FetchProjectInfoQuery.php - Keep this as separate API file
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Max-Age: 86400');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
header('Access-Control-Allow-Credentials: true');

if (!defined('UPLOAD_SQL_INCLUDED')) {
    define('UPLOAD_SQL_INCLUDED', true);

        try {
            require_once '../../../DBMySql/DBConn.php';
            $sql = "SELECT 
                b.UserID,
                b.ServiceID,
                b.ServiceType,
                b.NameOfService,
                b.Area,
                b.City,
                b.Block,
                b.Road,
                b.PropertyType,
                b.Details,
                b.Budget,
                b.BookingDate,
                u.Name AS UserName,
                u.PhoneNumber
            FROM 
                bookingservice b
            INNER JOIN 
                user u ON b.UserID = u.ID
            ORDER BY 
                b.BookingDate DESC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $Project = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($Project);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Failed to fetch products: ' . $e->getMessage()]);
        }
    }

?>