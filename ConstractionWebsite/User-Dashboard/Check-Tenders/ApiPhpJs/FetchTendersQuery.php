<?php
session_start();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Max-Age: 86400');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
header('Access-Control-Allow-Credentials: true');

require_once '../../../DBMySql/DBConn.php';

function checkOffers($UserID) {
    global $pdo;

    if (!isset($_SESSION['UserID'])) {
        return ['error' => 'Session not set'];
    }

    try {
        $sql = "
            SELECT 
                    bt.UserID,
                    bt.ServiceID,
                    bt.NameOfService,
                    bt.CompanyID,
                    bt.TenderAmount,
                    c.Name AS CompanyName,
                    c.PhoneNumber AS CompanyPhone
                FROM 
                    booking_tenders bt
                JOIN 
                    company c ON bt.CompanyID = c.ID
                WHERE 
                    bt.UserID = :UserID
                    AND EXISTS (
                        SELECT 1 
                        FROM bookingservice bs 
                        WHERE bs.UserID = bt.UserID
                            AND bs.ServiceID = bt.ServiceID
                            AND bs.NameOfService = bt.NameOfService
                            AND bs.AcceptedCompanyID IS NULL
                    )
                ORDER BY 
                    bt.ServiceID ASC;
";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT); // Fixed parameter name
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    } catch (PDOException $e) {
        return [
            'error' => 'Failed to fetch data',
            'message' => $e->getMessage()
        ];
    }
}

$_SESSION['UserID'] = 1005; 
$UserID = $_SESSION['UserID'];

$result = checkOffers($UserID);
echo json_encode($result);
?>
