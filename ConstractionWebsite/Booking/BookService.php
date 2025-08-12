<?php
if (!defined('UPLOAD_SQL_INCLUDED')) {
    define('UPLOAD_SQL_INCLUDED', true);

    function BookService($UserInputArray) {
        try {
            require_once("../php/DBConn.php");
            require_once '../php/Security.php';

            // Sanitize the input data
            $rules = [
                'UserID' => 'default',
                'ServiceID' => 'default',
                'ServiceType' => 'default',
                'NameOfService' => 'default',
                'Area' => 'default',
                'City' => 'default',
                'Block' => 'default',
                'Road' => 'default',
                'PropertyType' => 'default',
                'Details' => 'default',
                'Budget' => 'number',
                'Date' => 'default'
            ];
            
            $cleanData = sanitizeFormData($UserInputArray, $rules);
            
            if ($cleanData && !empty($cleanData['UserID']) && !empty($cleanData['ServiceID'])) {
                $UserID = $cleanData['UserID'];
                $ServiceID = $cleanData['ServiceID'];
                $ServiceType = $cleanData['ServiceType'];
                $NameOfService = $cleanData['NameOfService'];
                $Area = $cleanData['Area'];
                $City = $cleanData['City'];
                $Block = $cleanData['Block'];
                $Road = $cleanData['Road'];
                $PropertyType = $cleanData['PropertyType'];
                $Details = $cleanData['Details'];
                $Budget = $cleanData['Budget'];
                $Date = $cleanData['Date'];
               
                // Fixed SQL query with proper placeholders
                $sql = "INSERT INTO `bookingservice` 
                    (UserID, ServiceID, ServiceType, NameOfService, Area, City, Block, Road, PropertyType, Details, Budget, BookingDate)
                    VALUES (:UserID, :ServiceID, :ServiceType, :NameOfService, :Area, :City, :Block, :Road, :PropertyType, :Details, :Budget, :Date)";

                $rs = $GLOBALS['pdo']->prepare($sql);
                $params = [
                    ':UserID' => $UserID,
                    ':ServiceID' => $ServiceID,
                    ':ServiceType' => $ServiceType,
                    ':NameOfService' => $NameOfService,
                    ':Area' => $Area,
                    ':City' => $City,
                    ':Block' => $Block,
                    ':Road' => $Road,
                    ':PropertyType' => $PropertyType,
                    ':Details' => $Details,
                    ':Budget' => $Budget,
                    ':Date' => $Date
                ];
                
                if ($rs->execute($params)) {
                    return true;
                } else {
                    error_log('SQL execution failed: ' . print_r($rs->errorInfo(), true));
                    return false;
                }
            } else {
                error_log('Data validation failed or missing required fields');
                return false;
            }
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
            return false;
        }
    }
}
?>