<?php 
if (!defined('UPLOAD_SQL_INCLUDED')) {
    define('UPLOAD_SQL_INCLUDED', true);
    try {
        require_once '../../DBMySql/DBConn.php';
        require_once '../../DBMySql/Security.php';

        function PostTender($tenderData) {
            // Use values as-is
            $UserID = $tenderData['ID'];
            $ServiceID = $tenderData['ServiceID'];
            $CompanyID = $tenderData['CompanyID'];
            $NameOfService = trim($tenderData['NameOfService']);
            $TenderAmount = $tenderData['TenderAmount'];
            $Budget = $tenderData['Budget'];

            // 1️⃣ Check if this exact tender already exists
            $sqlCheck = "SELECT * FROM booking_tenders 
                         WHERE ServiceID = :ServiceID 
                           AND CompanyID = :CompanyID 
                           AND TRIM(NameOfService) = :NameOfService";
            $stmtCheck = $GLOBALS['pdo']->prepare($sqlCheck);
            $stmtCheck->bindParam(':ServiceID', $ServiceID);
            $stmtCheck->bindParam(':CompanyID', $CompanyID);
            $stmtCheck->bindParam(':NameOfService', $NameOfService);
            $stmtCheck->execute();
            $existingTender = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($existingTender) {
                error_log( "<script>alert('You have already submitted a tender for this service.');</script>");
                header("Location: ../DiscoverProjects/DiscoverProjects.html");
                

                return;
            }

            // 2 Validate tender amount
            if (!sanitizeNumber($TenderAmount) || $TenderAmount <= 0 || $TenderAmount == $Budget) {
                error_log( "<script>alert('Please enter a valid bid amount greater than 0 and not equal to the project budget.');</script>");
                return;
            }

            // 3 Insert the new tender
            $sqlInsert = "INSERT INTO booking_tenders (UserID, ServiceID, NameOfService, CompanyID, TenderAmount)
                          VALUES (:UserID, :ServiceID, :NameOfService, :CompanyID, :TenderAmount)";
            $stmtInsert = $GLOBALS['pdo']->prepare($sqlInsert);
            $params = [
                ':UserID' => $UserID,
                ':ServiceID' => $ServiceID,
                ':NameOfService' => $NameOfService,
                ':CompanyID' => $CompanyID,
                ':TenderAmount' => $TenderAmount
            ];

            if ($stmtInsert->execute($params)) {
                echo "<script>alert('Bid submitted successfully.');</script>";
                 header("Location: ../DiscoverProjects/DiscoverProjects.html");
            } else {
                echo "<script>alert('Failed to submit tender. Please try again.');</script>";
            }
        }

    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
