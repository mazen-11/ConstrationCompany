<?php
require_once '../php/Security.php';
require_once 'BookService.php';

if (isset($_POST['BTN'])) {
    $UserInputArray = [
        "UserID" => $_POST['UserID'],
        "ServiceID" => $_POST['ServiceID'],
        "ServiceType" => $_POST['ServiceType'],
        "NameOfService" => $_POST['NameOfService'],
        "Area" => $_POST['Area'],
        "City" => $_POST['City'],
        "Block" => $_POST['Block'],
        "Road" => $_POST['Road'],
        "PropertyType" => $_POST['PropertyType'],
        "Details" => $_POST['Details'],
        "Budget" => $_POST['Budget'],
        "Date" => date("Y-m-d") 
    ];

    if (BookService($UserInputArray)) {
        echo "<script>alert('Booking successful'); window.location.href='../index.html';</script>";
        exit();
    } else {
        echo "<script>alert('Booking failed. Please try again.');</script>";
    }
} else {
    echo "<script>alert('Please fill the form');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - BuildPro Construction</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container page-container d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow" style="max-width: 500px; width: 100%;">
            <h3 class="text-center mb-4">Booking service</h3>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">User ID</label>
                    <input type="number" name="UserID" class="form-control" placeholder="ID" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Service ID</label>
                    <input type="number" name="ServiceID" class="form-control" placeholder="Service ID" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Select type of service</label>
                    <select class="form-select" name="ServiceType" required>
                        <option value="">Select service type</option>
                        <option value="build">build</option>
                        <option value="make">make</option>
                        <option value="Repair">Repair</option>
                        <option value="renovate">renovate</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Name of the service</label>
                    <input type="text" name="NameOfService" class="form-control" placeholder="Enter the name of the service" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Select the area</label>
                    <select class="form-select" name="Area" required>
                        <option value="">Select area</option>
                        <option value="north">north</option>
                        <option value="east">east</option>
                        <option value="west">west</option>
                        <option value="south">south</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="City" class="form-control" placeholder="Enter the city" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Block</label>
                    <input type="text" name="Block" class="form-control" placeholder="Enter the block" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Road</label>
                    <input type="text" name="Road" class="form-control" placeholder="Enter the road" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Property type</label>
                    <select class="form-select" name="PropertyType" required>
                        <option value="">Select property type</option>
                        <option value="flat">flat</option>
                        <option value="vila">vila</option>
                        <option value="park">park</option>
                        <option value="house">house</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="Details" class="form-label">Details</label>
                    <textarea class="form-control" name="Details" id="Details" rows="3" placeholder="Enter service details"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Enter the budget</label>
                    <input type="number" name="Budget" class="form-control" placeholder="Enter the budget" required min="0" step="0.01">
                </div>
                <button type="submit" name="BTN" class="btn btn-warning w-100">Book</button>
            </form>
        </div>
    </div>
</body>
</html>