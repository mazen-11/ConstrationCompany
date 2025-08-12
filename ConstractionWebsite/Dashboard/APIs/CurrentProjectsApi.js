document.addEventListener('DOMContentLoaded', () => {
    console.log('Starting fetch request...');
    
    fetch('PHPQuery/CurrentProjectsApi.php') 
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
                
                // Check if it's an error response
                if (data.error) {
                    throw new Error(data.error);
                }
                
                // Continue with your existing logic
                const projectstList = document.getElementById('Projects-list');
                projectstList.innerHTML = '';
                
                if (data.message) {
                    // Handle empty data case
                    projectstList.innerHTML = `<div class="col-12"><p>${data.message}</p></div>`;
                    return;
                }
                
                data.forEach(Projects => {
                    const card = document.createElement('div');
                    card.className = `col-md-4`; 
                    card.innerHTML = `
                        <div class="card mt-3">
                            <div class="card-body text-end">
                                <h5 class="card-title">${Projects.NameOfService || 'N/A'}</h5>
                                <p class="card-text">Area: ${Projects.Area || 'N/A'}</p>
                                <p class="card-text">City: ${Projects.City || 'N/A'}</p>
                                <p class="card-text">Price: ${Projects.Budget || 'N/A'}</p>
                                <h5 class="card-text">Date: ${Projects.BookingDate || 'N/A'}</h5>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    `;
                    projectstList.appendChild(card);
                });
                
            } catch (parseError) {
                console.error('JSON Parse Error:', parseError);
                console.error('Response was not valid JSON. Raw response:', text);
                throw new Error('Invalid JSON response from server');
            }
        })
        .catch(error => {
            console.error('Detailed error:', error);
            
            const projectstList = document.getElementById('Projects-list');
            projectstList.innerHTML = `
                <div class="col-12 text-center">
                    <div class="alert alert-danger" role="alert">
                        Error loading products: ${error.message}
                        <br><small>Check console for details</small>
                    </div>
                </div>
            `;
        });
});