_ = (el) => document.querySelector(el);
_evt = (el, evt, fn) => el.addEventListener(evt, fn);

_('.nav .missing_persons_btn').classList.add('active');

_evt(window, 'load', ()=> {
    loadMissingPersonTable()
})

_evt(window, 'load', ()=> {
    fetch('API/MissingPersons/getMissingPersonRecordsByDatesOfMonth')
    .then(res => res.json())
    .then(data => {
        console.log(data)
        _('.print_report #report_dates').innerHTML = '<option hidden>Export Reports</option>'

        data.forEach(element => {
            const option = document.createElement('option');

            option.setAttribute('value', element.date_last_seen);
            option.innerText = 'Report for '+ element.date_last_seen;

            _('.print_report #report_dates').append(option);
        })
    })
})

_evt(_('.print_report #report_dates'), 'change', ()=> {
    const report_date = _('.print_report #report_dates').value;
    //Report Section must be similar to Table name from database
    const report_section = 'Missing Persons';

    window.location = 'views/pages/report.php?report_date='+ report_date +'&report_section='+ report_section
    //window.location = 'report/'+ report_section +'/'+ report_date
})

function loadMissingPersonTable(){
    fetch('API/MissingPersons/getMissingPersonRecords')
    .then(res => res.json())
    .then(data => {
        emptyMissingPersonTable();
        data.forEach(element => {
            
            const crime_table = _('.table table');
            const tr = document.createElement('tr')
            const full_name = `${element.first_name} ${element.middle_name} ${element.last_name} ${element.name_extention}`;
            const status = element.returned_person_id > 0? 'Found': 'Missing';
            
            tr.classList.add(`missing_person_row_${element.id}`)
            tr.innerHTML = `
            <td class="missing_person_type">${full_name}</td>
            <td class="missing_person_barangay">${element.address_last_seen}</td>
            <td class="missing_person_date">${element.date_last_seen}</td>
            <td class="missing_person_time">${element.time_last_seen}</td>
            <td class="missing_person_time">${status}</td>
            <td class="action_btns">
                <div class="edit_btn" onclick="editMissingPerson(${element.id})"></div>
                <div class="delete_btn" onclick="deleteMissingPerson(${element.id})"></div>
            </td>
            `;

            crime_table.append(tr)
        });
    })
    .catch(e => console.log(e))
}

function emptyMissingPersonTable(){
    _('.table table').innerHTML =  
    `
        <tr>    
            <th>Person Name</th>
            <th>Address Last Seen</th>
            <th>Date Last Seen</th>
            <th>Time Last Seen</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    `
}