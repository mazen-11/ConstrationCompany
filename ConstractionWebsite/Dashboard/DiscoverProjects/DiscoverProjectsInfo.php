<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Project Details</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- Invisible Header with Back Arrow -->
<header class="invisible-header">
    <div class="back-arrow" onclick="goBack()">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
</header>

<div class="container">
    <!-- Main Content -->
    <div class="main-content">
        <h1 class="project-title">Interior Painting & Stone Installation</h1>
        <div class="project-meta">
            <span>📅 Posted 2 weeks ago</span>
        </div>
        
        <div class="section-title">Project Details</div>
        <div class="detail-row">
            <span class="detail-label">City:</span>
            <span class="detail-value">Riyadh</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Neighborhood:</span>
            <span class="detail-value">King Abdullah</span>
        </div>
        
        <div class="section-title">Interior Finishing Details</div>
        <div class="detail-row">
            <span class="detail-label">Property Type:</span>
            <span class="detail-value">Villa</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Includes Bathroom / Kitchen:</span>
            <span class="detail-value">No</span>
        </div>
        
        <div class="section-title">Additional Information</div>
        <div class="detail-row">
            <span class="detail-label">Estimated Budget:</span>
            <span class="detail-value">SAR 50,000</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Expected Start:</span>
            <span class="detail-value">Later</span>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="card pricing-card">
            <div class="price">SAR 50,000</div>
            <div class="price-subtitle">Project Budget</div>
            <a href="#" class="btn btn-primary">Apply for this Project</a>
            <a href="#" class="btn btn-secondary">Save to Favorites</a>
            
            <div class="bid-form">
                <div class="form-group">
                    <label class="form-label" for="bid-amount">Your Bid Amount (SAR)</label>
                    <input type="number" id="bid-amount" class="form-input" placeholder="Enter your bid..." min="1" step="100">
                </div>
                <button type="submit" class="btn btn-submit">Submit Bid</button>
            </div>
        </div>
        
        <div class="card">
            <h4>🎯 Project Requirements</h4>
            <p><strong>Hiring Capacity:</strong> 1 Contractor</p>
            <p><strong>Project Duration:</strong> Less than 1 month</p>
            <p><strong>Skills Needed:</strong> Interior Painting, Wallpaper Installation, Stone Work</p>
        </div>
        
        <div class="card">
            <h4>👤 Client Information</h4>
            <p><strong>Name:</strong> Majed J</p>
            <p><strong>Location:</strong> Saudi Arabia</p>
            <p><strong>Total Projects:</strong> 1 project</p>
            <p><strong>Member Since:</strong> 2024</p>
        </div>
    </div>
</div>

<script>
// Simple form interaction
document.querySelector('.btn-submit').addEventListener('click', function(e) {
    e.preventDefault();
    const bidAmount = document.getElementById('bid-amount').value;
    if (bidAmount) {
        alert(`Bid submitted: SAR ${bidAmount}`);
    } else {
        alert('Please enter a bid amount');
    }
});

// Smooth hover effects
document.querySelectorAll('.detail-row').forEach(row => {
    row.addEventListener('mouseenter', function() {
        this.style.transform = 'translateX(4px)';
    });
    row.addEventListener('mouseleave', function() {
        this.style.transform = 'translateX(0)';
    });
});
</script>
</body>
</html>