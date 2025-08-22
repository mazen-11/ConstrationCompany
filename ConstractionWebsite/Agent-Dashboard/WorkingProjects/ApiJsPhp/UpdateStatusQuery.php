<?php
if (!defined('UPLOAD_SQL_INCLUDED')) {
    define('UPLOAD_SQL_INCLUDED', true);

    function UpdateStatus($StatusData) {
        try {
            require_once '../../DBMySql/DBConn.php';
            
            // Extract data from your array structure
            $ComID = $StatusData['comID'];
            $serviceID = $StatusData['serviceID'];
            $Status = $StatusData['status'];
            
            // Debug: Print the values being used
            error_log("UpdateStatus called with - ComID: $ComID, ServiceID: $serviceID, Status: " . ($Status ? 'TRUE' : 'FALSE'));
            
            // CORRECTED SQL query - use AcceptedCompanyID instead of companyID
            $sql = "UPDATE `bookingservice` SET `Status` = :status WHERE `AcceptedCompanyID` = :comID AND `ServiceID` = :serviceID";
            $rs = $pdo->prepare($sql);
            
            $params = [
                ':status' => $Status ? 1 : 0, // Convert boolean to integer (1 or 0)
                ':comID' => $ComID,
                ':serviceID' => $serviceID
            ];
            
            $result = $rs->execute($params);
            
            if ($result && $rs->rowCount() > 0) {
                // Success: Row was updated
                error_log("Status updated successfully for ServiceID: $serviceID, CompanyID: $ComID");
                return true;
                
            } elseif ($result && $rs->rowCount() == 0) {
                // Query executed but no rows affected - record doesn't exist
                error_log("No rows updated. ServiceID: $serviceID with AcceptedCompanyID: $ComID not found in database.");
                return false;
                
            } else {
                // Query execution failed
                error_log("Failed to execute update query for ServiceID: $serviceID, CompanyID: $ComID");
                return false;
            }
            
        } catch (PDOException $e) {
            // Database error
            error_log("UpdateStatus Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            // Any other error
            error_log("UpdateStatus General Error: " . $e->getMessage());
            return false;
        }
    }
}
?>