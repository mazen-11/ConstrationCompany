document.addEventListener('DOMContentLoaded', function() {
    // Get project ID from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');
    const serviceid = urlParams.get('serviceid');
    const area = urlParams.get('area');
    const city = urlParams.get('city');
    const block = urlParams.get('block');
    
    if (id && serviceid && area && city && block) {
        // Auto-fill hidden form fields and simulate submit via fetch
        const form = document.getElementById('FormDisplay');
        if (form) {
            document.getElementById('id').value = id;
            document.getElementById('serviceid').value = serviceid;
            document.getElementById('area').value = area;
            document.getElementById('city').value = city;
            document.getElementById('block').value = block;
        }
        loadProjectDetails(id, serviceid, area, city, block);
    } else {
        console.error('No project ID provided');
        document.body.innerHTML = '<div class="alert alert-danger">Project ID is required</div>';
    }
});

function loadProjectDetails(id, serviceid, area, city, block) {
    // Call the details endpoint with the same params the form would submit
    const params = new URLSearchParams({ id, serviceid, area, city, block });
    fetch(`ApiJsPhp/FetchProjectInfoQuery.php?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error, data.missing || '');
                return;
            } else {
                console.log('Received data:', data); // Debug log
                
                data.forEach(project => {
                    // Fixed comparison - use proper field names from your database
                    if(project.UserID == id && project.ServiceID == serviceid && 
                       project.Area == area && project.City == city && project.Block == block) {
                        
                        // FIX 1: Use querySelector or getElementsByClassName[0]
                        const BidFrom = document.querySelector('.price-card');
                        
                        if (BidFrom) {
                            BidFrom.innerHTML = `
                                <div class="price-amount" id="project-price">
                                    ${project.Budget}
                                    <img src="https://www.sama.gov.sa/ar-sa/Currency/SRS/PublishingImages/Saudi_Riyal_Symbol-1.png" alt="ر.س" class="riyal-icon">
                                </div>
                                <form class="bidding-form" id="bidding-form" method="POST" action="">
                                    <label for="bid-amount" class="form-label">اكتب عرضك:</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name='tender' id="tender-amount" placeholder="أدخل المبلغ" min="1" required="">
                                    </div>
                                        <input type="text" class='FormDisplay' name='ID' value='${project.UserID}' required="">
                                        <input type="text" class='FormDisplay' name='ServiceID' value='${project.ServiceID}' required="">
                                        <input type="text" class='FormDisplay' name='NameOfService' value='${project.NameOfService}' required="">
                                        <input type="text" class='FormDisplay' name='Budget' value='${project.Budget}' required="">

                                        <button type="submit" class="btn btn-primary-custom" name='TenderBtn' id="submit-bid-btn">
                                        <i class="fas fa-paper-plane"></i> إرسال العرض
                                    </button>
                                </form>
                            `;
                            const title = document.getElementById('project-title').textContent = project.NameOfService || 'مشروع بدون عنوان'
                            const dateEl = document.getElementById('post-date');
                            if (project.BookingDate) {
                                const date = project.BookingDate;
                                dateEl.textContent = date.split(' ')[0];
                            } else {
                                dateEl.textContent = 'غير محدد';
                            }                            const propertyType = document.getElementById('property-type').textContent = project.PropertyType || 'غير محدد';
                            const includesBathroomKitchen = document.getElementById('includes-bathroom-kitchen');
                            if (includesBathroomKitchen) {
                                includesBathroomKitchen.textContent = project.IncludesBathroomKitchen ? 'نعم' : 'لا';
                            }
                            const wantsDesignSamples = document.getElementById('wants-design-samples');
                            if (wantsDesignSamples) {
                                wantsDesignSamples.textContent = project.WantsDesignSamples ? 'نعم' : 'لا';
                            }
                            const currentFlooring = document.getElementById('current-flooring').textContent = project.CurrentFlooring || 'غير محدد';
                            const ReferenceExamples = document.getElementById('reference-examples');
                            if (ReferenceExamples) {
                                ReferenceExamples.textContent = project.ReferenceExamples ? 'نعم' : 'لا';
                            }
                            const ExpectedStart = document.getElementById('expected-start').textContent = project.ExpectedStart || 'غير محدد';
                            const SitePhotosAvailable = document.getElementById('site-photos-available');
                            if (SitePhotosAvailable) {
                                SitePhotosAvailable.textContent = project.SitePhotosAvailable ? 'نعم' : 'لا';
                            }
                            const EstimatedBudget = document.getElementById('estimated-budget').textContent = project.Budget ? `${project.Budget} ر.س                               ` : 'غير محدد';
                            const EngineeringPlansAvailable = document.getElementById('engineering-plans-available');
                            if (EngineeringPlansAvailable) {
                                EngineeringPlansAvailable.textContent = project.EngineeringPlansAvailable ? 'نعم' : 'لا';
                            }
                            const ProjectDuration = document.getElementById('project-duration').textContent = project.ProjectDuration || 'غير محدد';
                            const UserName = document.getElementById('user-name').textContent = project.UserName || 'غير معروف';   
                            const UserLocation = document.getElementById('user-location').textContent = project.UserLocation || 'غير معروف';      
                            const ProjectCity = document.getElementById('project-city').textContent = project.City || 'غير محدد';  
                            const ProjectNeighborhood = document.getElementById('project-neighborhood').textContent = project.Area || 'غير محدد';     
                            const ProjectStreet = document.getElementById('project-street').textContent = project.Block || 'غير محدد';                                               
                            const biddingForm = document.getElementById('bidding-form');
                            if (biddingForm) {
                                biddingForm.addEventListener('submit', function(e) {
                                    const bidAmount = document.getElementById('bid-amount').value;
                                    
                                    if (!bidAmount || bidAmount <= 0) {
                                        e.preventDefault(); // Only prevent if validation fails
                                        alert('يرجى إدخال مبلغ صحيح للعرض');
                                        return false;
                                    }
                                                                        
                                    return true;
                                });
                            }
                        }
                        
                        // Also populate other project data
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error fetching project details:', error);
        });
}
