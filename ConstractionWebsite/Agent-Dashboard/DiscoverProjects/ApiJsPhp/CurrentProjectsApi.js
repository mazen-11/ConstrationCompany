document.addEventListener('DOMContentLoaded', () => {
    fetch('ApiJsPhp/FetchProjectsQuery.php')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
         
                const projectsList = document.getElementById('Projects-list');

               
                        data.forEach(Projects => {
                 const card = document.createElement('div');
                        // Responsive classes for different screen sizes
                card.className = `col-md-4`; 
                        
                        card.innerHTML = `
                       <div class="row mt-4 justify-content-center flex-row-reverse">
                          <div class="col-12 col-md-10">
                            <div class="card mt-3">
                              <div class="card-body text-end">
                                <h3 class="card-title" id='title'>${Projects.NameOfService}</h3>
                                <h6 class="card-subtitle mb-2 text-muted">${Projects.BookingDate.split(' ')[0]}</h6>
                                <h5 class="card-text">${Projects.ServiceType}</h5>
                                <h4 class="card-text">${Projects.Budget}</h4>
                                <h5 class="card-text mb-2 text-muted">${Projects.City}</h5>
                                <a href="DiscoverProjectsInfo.php?id=${Projects.UserID}&serviceid=${Projects.ServiceID}&area=${Projects.Area}&city=${Projects.City}&block=${Projects.Block}" class="btn btn-primary">Go somewhere</a>
                              </div>
                            </div>
                          </div>
                        </div>


                        `;
                        console.log('card created for project:', Projects.NameOfService);
                        projectsList.appendChild(card);
                        console.log('card appended');
                
            });
        })
        .catch(error => {
            console.log("before error");

            console.error('Error:', error);
            document.getElementById('Projects-list').innerHTML = `
                <div class="alert alert-danger">Error loading products</div>
            `;
        });
});


