<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Max-Age: 86400'); // 24 hours
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1
header('Pragma: no-cache'); // HTTP 1.0
header('Expires: 0'); // Proxies
header('Access-Control-Allow-Credentials: true');

function WorkingProjectsQuery($AcceptedCompanyID) {
    try {
        require_once '../../../DBMySql/DBConn.php';

        $stmt = $pdo->prepare("
            SELECT 
                bs.UserID,
                bs.ServiceID,
                bs.NameOfService,
                bs.Area,
                bs.ServiceType,
                bs.City,
                bs.Block,
                bs.Road,
                bs.PropertyType,
                bs.Details,
                bs.AcceptedTenderAmount,
                u.Name AS UserName,
                u.PhoneNumber AS UserPhone,
                c.Name AS CompanyName,
                c.PhoneNumber AS CompanyPhone
            FROM 
                bookingservice bs
            LEFT JOIN 
                user u ON bs.UserID = u.ID
            LEFT JOIN 
                company c ON bs.AcceptedCompanyID = c.ID
            WHERE 
                bs.AcceptedCompanyID = :ID 
                AND bs.AcceptedCompanyID IS NOT NULL
                AND bs.Status IS NULL
        ");
        
        $stmt->bindParam(':ID', $AcceptedCompanyID);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) {
            echo json_encode(['message' => 'No working projects found for this company']);
        } else {
            echo json_encode($results);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Failed to fetch working projects: ' . $e->getMessage()]);
    }
}

// Check for company_id parameter first, then fall back to session
if (isset($_GET['company_id'])) {
    $AcceptedCompanyID = $_GET['company_id'];
    WorkingProjectsQuery($AcceptedCompanyID);
} elseif (isset($_SESSION['AcceptedCompanyID'])) {
    $AcceptedCompanyID = $_SESSION['AcceptedCompanyID'];
    WorkingProjectsQuery($AcceptedCompanyID);
} else {
    // Set example company ID for testing - replace with actual authentication logic
    $_SESSION['AcceptedCompanyID'] = 207;
    $AcceptedCompanyID = $_SESSION['AcceptedCompanyID'];
    WorkingProjectsQuery($AcceptedCompanyID);
}

?>