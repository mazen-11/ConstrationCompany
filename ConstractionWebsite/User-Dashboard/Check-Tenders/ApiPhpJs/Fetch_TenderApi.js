document.addEventListener('DOMContentLoaded', () => {
    fetch('ApiPhpJs/FetchTendersQuery.php')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const TenderssList = document.getElementById('Tenders-list');

            data.forEach(Tender => {
                const card = document.createElement('div');
                card.className = `card w-75 mb-3`; 
                        
                card.innerHTML = `
                    <div class="card-body text-end">
                        <h5 class="card-title">${Tender.NameOfService}</h5>
                        <p class="card-text">the id of the service ${Tender.ServiceType}</p>
                        <p class="card-text">the id of the service ${Tender.ServiceID}</p>
                        <p class="card-text">the bid from the company is: ${Tender.TenderAmount}</p>
                        <p class="card-text">${Tender.CompanyName} :الشركة الموفرة للعرض</p>

                        <form method="POST" enctype="multipart/form-data">
                            <input type="text" class='FormDisplay' name="ServiceID" value="${Tender.ServiceID}" required>
                            <input type="text" class='FormDisplay' name="NameOfService" value="${Tender.NameOfService}" required>
                            <input type="text" class='FormDisplay' name="CompanyID" value="${Tender.CompanyID}" required>
                            <input type="text" class='FormDisplay' name="tender" value="${Tender.TenderAmount}" required>
                            <button type="submit" name="AcceptBTN" class="btn btn-primary mt-3">Submit</button>
                        </form>
                    </div>
                `;
                
                console.log('card created for project:', Tender.NameOfService);
                TenderssList.appendChild(card);
                console.log('card appended');
            });
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('Tenders-list').innerHTML = `
                <div class="alert alert-danger">Error loading tenders</div>
            `;
        });
});
