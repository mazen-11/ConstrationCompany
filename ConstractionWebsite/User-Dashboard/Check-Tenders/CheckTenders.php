<?php
session_start();
$_SESSION['UserID'] = 1005;
$UserID = $_SESSION['UserID']; 
require_once 'ApiPhpJs/AcceptedTender.php';

if(isset($_POST['AcceptBTN'])){
    $tenderData = [
        'UserID' => $UserID,      
        'ServiceID' => $_POST['ServiceID'],
        'NameOfService' => $_POST['NameOfService'],
        'CompanyID' => $_POST['CompanyID'],
        'tender' => $_POST['tender'],
        'AcceptingDate' => date('Y-m-d')  // Include time for datetime field
    ];
    updateBookingService($tenderData);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Centered Cards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../MainJsCss/style.css"  rel="stylesheet">
</head>
<body>
<main class="services-section container">
    <!-- Centered cards container -->
    <div class="d-flex flex-column align-items-center" id="Tenders-list"></div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="ApiPhpJs/Fetch_TenderApi.js"></script>
</body>
</html>
