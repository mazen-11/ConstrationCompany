document.addEventListener('DOMContentLoaded', () => {
    fetch('ApiJsPhp/FetchWorkingProjectsQuery.php')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
         
                const projectsList = document.getElementById('Projects-list');

               
                        data.forEach(Project => {
                 const card = document.createElement('div');
                        // Responsive classes for different screen sizes
                card.className = `col-md-4`; 
                        
                        card.innerHTML = `
                        <div class="row mt-4 justify-content-center flex-row-reverse">
                          <div class="col-12 col-md-10">
                            <div class="card mt-3">
                              <div class="card-body text-end">
                                <h3 class="card-title" id='title'>${Project.NameOfService}</h3>
                                <h5 class="card-text">${Project.ServiceType}</h5>
                                <h5 class="card-text mb-2 text-muted">${Project.UserName} :اسم العميل</h5>
                                <h5 class="card-text mb-2 text-muted">الميزانية المقدرة: ${Project.AcceptedTenderAmount}</h5>
                                <a href="WorkingProjectsInfo.php?nameofservice=${Project.NameOfService}" class="btn btn-primary">Go somewhere</a>
                              </div>
                            </div>
                          </div>
                        </div>


                        `;
                        console.log('card created for project:', Project.NameOfService);
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


