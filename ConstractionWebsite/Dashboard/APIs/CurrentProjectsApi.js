document.addEventListener('DOMContentLoaded', () => {
    console.log('Starting fetch request...');
    
    const projectsList = document.getElementById('Projects-list');
    
    // Clear existing content first
    projectsList.innerHTML = `
        <div class="col-12 text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading projects...</p>
        </div>
    `;
    
    fetch('APIs/PHPQuery/CurrentProjectsApi.php') 
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            console.log('Response type:', response.type);
            
            // Get the response as text first to see what we're actually getting
            return response.text();
        })
        .then(text => {
            console.log('Raw response:', text);
            
            // Try to parse it as JSON
            try {
                const data = JSON.parse(text);
                console.log('Parsed data:', data);
                console.log('Data type:', typeof data);
                console.log('Is array:', Array.isArray(data));
                
                // Clear loading message
                projectsList.innerHTML = '';
                
                // Check if it's an error response
                if (data.error) {
                    throw new Error(`Server Error: ${data.error}`);
                }
                
                // Handle message (no data found)
                if (data.message) {
                    projectsList.innerHTML = `
                        <div class="col-12 text-center">
                            <div class="alert alert-info" role="alert">
                                ${data.message}
                            </div>
                        </div>
                    `;
                    return;
                }
                
                // Handle empty array
                if (Array.isArray(data) && data.length === 0) {
                    projectsList.innerHTML = `
                        <div class="col-12 text-center">
                            <div class="alert alert-info" role="alert">
                                No projects found in the database.
                            </div>
                        </div>
                    `;
                    return;
                }
                
                // Process the projects data
                if (Array.isArray(data)) {
                    data.forEach(Projects => {
                        const card = document.createElement('div');
                        // Responsive classes for different screen sizes
                        card.className = `col-12 col-sm-6 col-md-4 col-lg-3`; 
                        
                        // Create the project URL with parameters
                        const projectUrl = `../DiscoverProjects/DiscoverProjectsInfo.php?UserID=${encodeURIComponent(Projects.UserID || '')}&ServiceID=${encodeURIComponent(Projects.ServiceID || '')}&Location=${encodeURIComponent(Projects.City || Projects.Location || '')}`;
                        
                        card.innerHTML = `
                            <div class="card mt-3 h-100">
                                <div class="card-body text-end d-flex flex-column">
                                    <h5 class="card-title">${Projects.NameOfService || 'Service Name'}</h5>
                                    <div class="card-details flex-grow-1">
                                        <p class="card-text mb-2">
                                            <strong>Area:</strong> ${Projects.Area || 'N/A'}
                                        </p>
                                        <p class="card-text mb-2">
                                            <strong>City:</strong> ${Projects.City || 'N/A'}
                                        </p>
                                        <p class="card-text mb-2">
                                            <strong>Budget:</strong> ${formatPrice(Projects.Budget)}
                                        </p>
                                        <p class="card-text mb-3">
                                            <strong>Date:</strong> ${formatDate(Projects.BookingDate)}
                                        </p>
                                    </div>
                                    <div class="card-actions mt-auto">
                                        <a href="${projectUrl}" 
                                           class="btn btn-primary w-100 btn-responsive"
                                           onclick="trackProjectView('${Projects.UserID}', '${Projects.ServiceID}')">
                                            View Project Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                        console.log('card created for project:', Projects.NameOfService);
                        projectsList.appendChild(card);
                        console.log('card appended');
                    });
                    
                    console.log(`Successfully loaded ${data.length} projects`);
                } else {
                    throw new Error('Unexpected data format received from server');
                }
                
            } catch (parseError) {
                console.error('JSON Parse Error:', parseError);
                console.error('Response was not valid JSON. Raw response:', text);
                
                // Show the raw response for debugging
                projectsList.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <h5>JSON Parse Error</h5>
                            <p><strong>Error:</strong> ${parseError.message}</p>
                            <details>
                                <summary>Raw Response (click to expand)</summary>
                                <pre class="mt-2">${text}</pre>
                            </details>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            
            projectsList.innerHTML = `
                <div class="col-12 text-center">
                    <div class="alert alert-danger" role="alert">
                        <h5>Error Loading Projects</h5>
                        <p>${error.message}</p>
                        <small class="text-muted">Check the browser console for more details</small>
                    </div>
                </div>
            `;
        });
});

// Helper function to format date
function formatDate(dateString) {
    if (!dateString) return 'N/A';
    
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    } catch (e) {
        return dateString; // Return original if can't format
    }
}

// Helper function to format price
function formatPrice(price) {
    if (!price) return 'N/A';
    
    // If it's already formatted with currency, return as is
    if (typeof price === 'string' && (price.includes('$') || price.includes('SAR') || price.includes('USD'))) {
        return price;
    }
    
    // If it's a number, format it
    if (typeof price === 'number' || !isNaN(price)) {
        return `SAR ${parseFloat(price).toLocaleString()}`;
    }
    
    return price;
}

// Helper function to track project views (for analytics)
function trackProjectView(userId, serviceId) {
    console.log('Tracking project view:', { userId, serviceId });
    
    // You can add analytics tracking here
    // Example: Google Analytics, custom analytics, etc.
    if (typeof gtag !== 'undefined') {
        gtag('event', 'project_view', {
            'custom_parameter_1': userId,
            'custom_parameter_2': serviceId
        });
    }
}

// Add responsive button styles
const style = document.createElement('style');
style.textContent = `
    .btn-responsive {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
        border-radius: 0.375rem;
    }
    
    .btn-responsive:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .card-details p {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .card-title {
        color: #0d6efd;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    /* Mobile responsiveness */
    @media (max-width: 576px) {
        .btn-responsive {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
        
        .card-details p {
            font-size: 0.8rem;
        }
        
        .card-title {
            font-size: 1.1rem;
        }
    }
    
    /* Tablet responsiveness */
    @media (min-width: 577px) and (max-width: 768px) {
        .btn-responsive {
            font-size: 0.85rem;
        }
    }
    
    /* Desktop responsiveness */
    @media (min-width: 769px) {
        .btn-responsive {
            font-size: 0.9rem;
        }
    }
`;
document.head.appendChild(style);