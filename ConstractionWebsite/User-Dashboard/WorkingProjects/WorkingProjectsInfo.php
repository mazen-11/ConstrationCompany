<?php
session_start();
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
                        <i class="fas fa-building -alt info-icon"></i>
                        <span class="info-label">أسم المقاول:</span>
                        <span id="user-name"></span>
                    </div>

                    <div class="info-row">
                        <i class="fas fa-phone info-icon"></i>
                        <span class="info-label">رقم هاتف المقاول:</span>
                        <span class="info-value" id="Agent-number"></span>
                    </div>
                    
                    <button class="btn btn-primary-custom" onclick="window.location.href='DiscoverWorkingProjects.html'" id="view-all-projects">عرض مشاريعي ←</button>
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
    <script src="ApiJsPhp/FetchProjectWorking-Info.js"></script>
</body>
</html>



