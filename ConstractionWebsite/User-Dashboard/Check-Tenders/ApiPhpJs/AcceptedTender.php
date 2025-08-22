<?php
require_once '../../DBMySql/DBConn.php';

function updateBookingService($tenderData) {
    global $pdo;

    try {
        // Step 1: Update bookingservice with tender + company info
        $sql = "
                UPDATE bookingservice
                SET 
                    StartDate = :StartDate,
                    AcceptedCompanyID = :AcceptedCompanyID,
                    AcceptedTenderAmount = :AcceptedTenderAmount
                WHERE 
                    UserID = :UserID
                    AND ServiceID = :ServiceID
                    AND NameOfService = :NameOfService
            ";

        $stmt = $pdo->prepare($sql);

        $params = [
            'StartDate'             => $tenderData['AcceptingDate'],
            'AcceptedCompanyID'     => $tenderData['CompanyID'],
            'AcceptedTenderAmount'  => $tenderData['tender'],
            'UserID'                => $tenderData['UserID'],
            'ServiceID'             => $tenderData['ServiceID'],
            'NameOfService'         => $tenderData['NameOfService']
        ];

        if ($stmt->execute($params)) {
            echo "<script>alert('Booking updated successfully!');</script>";
            return true;
        } else {
            echo "<script>alert('Failed to update booking.');</script>";
            return false;
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Update failed: ' . $e->getMessage()]);
        return false;
    }
}

?>