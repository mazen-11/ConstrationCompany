document.addEventListener('DOMContentLoaded', function() {
    // Get project ID from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const nameofservice = urlParams.get('nameofservice');
    
    
    if (nameofservice) {
        
        loadProjectDetails(nameofservice);
    } else {
        console.error('No project name provided in URL');
        document.body.innerHTML = '<div class="alert alert-danger">Project ID is required</div>';
    }
});

function loadProjectDetails(nameofservice) {
    // Call the details endpoint with the same params the form would submit
    const NameOfService = new URLSearchParams({ nameofservice});
    fetch('ApiJsPhp/FetchWorkingProjectsQuery.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error, data.missing || '');
                return;
            } else {
                console.log('Received data:', data); // Debug log
                
                data.forEach(project => {
                    // Fixed comparison - use proper field names from your database
                    if( project.NameOfService === nameofservice) {
                        
                        // FIX 1: Use querySelector or getElementsByClassName[0]
                        const CheckCard = document.querySelector('.price-card');
                        
                            CheckCard.innerHTML = `
                                <div class="price-amount" id="project-price">
                                    ${project.AcceptedTenderAmount}
                                    <img src="https://www.sama.gov.sa/ar-sa/Currency/SRS/PublishingImages/Saudi_Riyal_Symbol-1.png" alt="ر.س" class="riyal-icon">
                                </div>
                                <form class="bidding-form" id="bidding-form" method="POST" action="">
                                    <label for="bid-amount" class="form-label">:تأكيد أكتمال المشروع</label>
                                    <input type="text" class='FormDisplay' name='ID' value='${project.ServiceID}' required="">
                                    <button type="submit" class="btn btn-primary-custom" name='CheckBtn' id="submit-bid-btn">
                                        <i class="fas fa-check"></i> تأكيد
                                    </button>
                                </form>

                            `;
                            const title = document.getElementById('project-title').textContent = project.NameOfService || 'مشروع بدون عنوان'
                            const propertyType = document.getElementById('property-type').textContent = project.PropertyType || 'غير محدد';
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
                            const EstimatedBudget = document.getElementById('estimated-budget').textContent = project.AcceptedTenderAmount ? `${project.AcceptedTenderAmount} ر.س                               ` : 'غير محدد';
                            const EngineeringPlansAvailable = document.getElementById('engineering-plans-available');
                            if (EngineeringPlansAvailable) {
                                EngineeringPlansAvailable.textContent = project.EngineeringPlansAvailable ? 'نعم' : 'لا';
                            }
                            const ProjectDuration = document.getElementById('project-duration').textContent = project.ProjectDuration || 'غير محدد';
                            const UserName = document.getElementById('user-name').textContent = project.UserName || 'غير معروف';   
                            const UserNumber = document.getElementById('Agent-number').textContent = project.UserPhone || 'غير محدد';                                               
                            const UserLocation = document.getElementById('user-location').textContent = project.UserLocation || 'غير معروف';      
                            const ProjectCity = document.getElementById('project-city').textContent = project.City || 'غير محدد';  
                            const ProjectNeighborhood = document.getElementById('project-neighborhood').textContent = project.Area || 'غير محدد';     
                            const ProjectStreet = document.getElementById('project-street').textContent = project.Block || 'غير محدد';                                               
                            
                        
                        
                        // Also populate other project data
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error fetching project details:', error);
        });
}
