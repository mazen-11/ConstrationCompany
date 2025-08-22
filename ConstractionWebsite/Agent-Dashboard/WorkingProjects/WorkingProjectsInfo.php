<?php
session_start();
require_once 'ApiJsPhp/UpdateStatusQuery.php';

// The session will be changed when we use the login system
// For now we will use a static value for ComID
$_SESSION['ComID'] = 207;

if(isset($_POST['CheckBtn'])){
    
    // Check if session ComID exists and POST data exists
    if(isset($_SESSION['ComID']) && isset($_POST['ID'])) {
        $ComID = $_SESSION['ComID'];
        $ServiceID = $_POST['ID'];
        
        // Debug: Log the values
        error_log("Form submitted - ComID: $ComID, ServiceID: $ServiceID");
        
        // Create your StatusData array exactly as you want it
        $StatusData = [
            'comID' => $ComID,          // Company ID from session (207)
            'serviceID' => $ServiceID,   // Service ID from form
            'status' => 1               // Mark as completed (1 = completed)
        ];
        
        // Call the UpdateStatus function with your array
        $result = UpdateStatus($StatusData);
        
        if($result) {
            echo "<script>
                alert('تم تحديث حالة المشروع بنجاح! تم تأكيد اكتمال المشروع.');
                setTimeout(function(){ 
                    window.location.href = 'DiscoverWorkingProjects.html'; 
                }, 2000);
            </script>";
        } else {
            echo "<script>
                alert('فشل في تحديث حالة المشروع. يرجى التحقق من البيانات والمحاولة مرة أخرى.');
                console.log('Update failed for ServiceID: $ServiceID, CompanyID: $ComID');
            </script>";
        }
    } else {
        $missing = [];
        if (!isset($_SESSION['ComID'])) $missing[] = 'ComID in session';
        if (!isset($_POST['ID'])) $missing[] = 'ServiceID in POST data';
        
        $missingStr = implode(', ', $missing);
        error_log("Form submission failed - Missing: $missingStr");
        
        echo "<script>
            alert('خطأ في البيانات المطلوبة: $missingStr');
            console.log('Missing data: $missingStr');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المشروع</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Style/StyleCode.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="project-container">
        <div class="clearfix">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Price and Bidding Form Card -->
                <div class="card price-card">
                    <!-- This will be populated by JavaScript -->
                </div>

                <!-- Project Requirements Card -->
                <div class="card">
                    <h5 class="section-title"><i class="fas fa-calendar info-icon"></i>مدة المشروع</h5>
                    <div class="info-row">
                        <span class="info-value" id="project-duration"></span>
                    </div>
                </div>

                <!-- User Profile Card -->
                <div class="card">
                    <div class="info-row">
                        <i class="fas fa-building-alt info-icon"></i>
                        <span class="info-label">أسم العميل:</span>
                        <span id="user-name"></span>
                    </div>

                    <div class="info-row">
                        <i class="fas fa-phone info-icon"></i>
                        <span class="info-label">رقم هاتف العميل:</span>
                        <span class="info-value" id="Agent-number"></span>
                    </div>

                    <div class="info-row">
                        <i class="fas fa-map-marker-alt info-icon"></i>
                        <span class="info-label">يقيم في:</span>
                        <span class="info-value" id="user-location"></span>
                    </div>
                    
                    <div class="info-row">
                        <i class="fas fa-map-marker-alt info-icon"></i>
                        <span class="info-label">المدينة:</span>
                        <span class="info-value" id="project-city"></span>
                    </div>
                    
                    <div class="info-row">
                        <i class="fas fa-building info-icon"></i>
                        <span class="info-label">الحي:</span>
                        <span class="info-value" id="project-neighborhood"></span>
                    </div>
                    
                    <div class="info-row">
                        <i class="fas fa-road info-icon"></i>
                        <span class="info-label">الشارع:</span>
                        <span class="info-value" id="project-street"></span>
                    </div>
                    
                    <button class="btn btn-primary-custom" onclick="window.location.href='DiscoverWorkingProjects.html'" id="view-all-projects">عرض مشاريعنا ←</button>
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-column">
                <!-- Project Title and Date -->
                <div class="card">
                    <h1 class="section-title" id="project-title"></h1>
                </div>

                <!-- Project Details -->
                <div class="card">
                    <h2 class="section-title">تفاصيل المشروع</h2>
                    
                    <h3 class="sub-section-title" id="Service-Type"></h3>
                    <div class="info-row">
                        <span class="info-label">نوع العقار:</span>
                        <span class="info-value" id="property-type"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">يشمل حمام / مطبخ:</span>
                        <span class="info-value" id="includes-bathroom-kitchen"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">تريد نماذج تصميم:</span>
                        <span class="info-value" id="wants-design-samples"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">الأرضيات الحالية:</span>
                        <span class="info-value" id="current-flooring"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">أمثلة مرجعية:</span>
                        <span class="info-value" id="reference-examples"></span>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="card">
                    <h3 class="sub-section-title">معلومات إضافية</h3>
                    <div class="info-row">
                        <span class="info-label">البدء المتوقع:</span>
                        <span class="info-value" id="expected-start"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">يوجد صور للموقع:</span>
                        <span class="info-value" id="site-photos-available"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">الميزانية المقدرة:</span>
                        <span class="info-value" id="estimated-budget"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">يوجد مخططات هندسية:</span>
                        <span class="info-value" id="engineering-plans-available"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="ApiJsPhp/FetchProjectWorkingInfo.js"></script>
</body>
</html>