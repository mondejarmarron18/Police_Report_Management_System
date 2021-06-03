const print_report_btn = document.querySelector('.print_report_btn')

window.onbeforeprint = ()=> print_report_btn.style.display = "none";
window.onafterprint = ()=> print_report_btn.style.display = "flex";

print_report_btn.addEventListener('click', ()=>{
    window.print() 
})

window.onload = () => {
    const report_section = document.querySelector('#report_section').innerHTML.replace(' ','');
    const report_date = document.querySelector('#report_date').innerHTML;

    if (report_section === 'Crimes'){
        url = `../../API/${report_section}/getCrimeRecordsByDate`; 
        crimeReports(url, report_date)
    }
    else if (report_section === 'LostItems'){
        url = `../../API/${report_section}/getLostItemRecordsByDate`; 
        lostItemReports(url, report_date)
    } 
    else if (report_section === 'MissingPersons') {
        url = `../../API/${report_section}/getMissingPersonRecordsByDate`; 
        missingPersonReports(url, report_date)
    }
}

function crimeReports(url, report_date){
    const formData = new FormData();

    formData.append('date_occurred', report_date)
    
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const report_table = document.querySelector('.table table');

        report_table.innerHTML = 
            `<tr>
                <th>Crime Type</th>
                <th>Barangay</th>
                <th>Time Occurred</th>
            </tr>`;

        data.forEach(element => {
            const tr = document.createElement('tr')
            
            tr.innerHTML = `<tr>
            <td>${element.crime_type}</td>
            <td>${element.barangay}</td>
            <td>${element.time_occurred}</td>
            </tr>`;

            report_table.append(tr)
        });
    })
    .catch(e => console.log(e))
}

function lostItemReports(url, report_date){
    const formData = new FormData();

    formData.append('date_lost', report_date)

    fetch(url,{
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const report_table = document.querySelector('.table table');
        
        report_table.innerHTML = 
            `<tr>
                <th>Item Type</th>
                <th>Location Lost</th>
                <th>Time Lost</th>
                <th>Status</th>
            </tr>`;

        data.forEach(element => {
            const tr = document.createElement('tr')
            const status = element.surrenderer_id > 0? 'Claimed': 'Missing';
            
            tr.innerHTML = `<tr>
            <td>${element.type}</td>
            <td>${element.location_lost}</td>
            <td>${element.time_lost}</td>
            <td>${status}</td>
            </tr>`;

            report_table.append(tr)
        });
    })
    .catch(e => console.log(e))
}

function missingPersonReports(url, report_date){
    const formData = new FormData();

    formData.append('date_last_seen', report_date)

    fetch(url,{
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const report_table = document.querySelector('.table table');
        
        report_table.innerHTML = 
            `<tr>
                <th>Person Name</th>
                <th>Address Last Seen</th>
                <th>Time Last Seen</th>
                <th>Status</th>
            </tr>`;

        data.forEach(element => {
            const tr = document.createElement('tr')
            const status = element.returned_person_id > 0? 'Found': 'Missing';
            const full_name = `${element.first_name} ${element.middle_name} ${element.last_name} ${element.name_extention}`
            
            tr.innerHTML = `<tr>
            <td>${full_name}</td>
            <td>${element.address_last_seen}</td>
            <td>${element.time_last_seen}</td>
            <td>${status}</td>
            </tr>`;

            report_table.append(tr)
        });
    })
    .catch(e => console.log(e))
}
