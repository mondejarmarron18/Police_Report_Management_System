_ = (el) => document.querySelector(el);
_evt = (el, evt, fn) => el.addEventListener(evt, fn);

_('.nav .crimes_btn').classList.add('active');

//Load Crimes to Crime Table
_evt(window, 'load', () => loadCrimeTable())

//Load Barangays of Quezon, Nueva Ecija to Crime Modal
_evt(window, 'load', () => loadBarangay())

//Save or Update Crime Record
_evt(_('.crime_modal .save_btn'), 'click', () => {
    const crime_id = _('.crime_modal #crime_id').value
    const crime_type_id = _('.crime_modal #crime_type').value
    const barangay = _('.crime_modal #barangay').value
    const date_occurred = _('.crime_modal #date_occurred').value
    const time_occurred = _('.crime_modal #time_occurred').value

    if (_('.crime_modal .save_btn').innerText == "SAVE")
        saveCrimeRecord(crime_type_id, barangay, date_occurred, time_occurred);
    else
        updateCrimeRecord(crime_id, crime_type_id, barangay, date_occurred, time_occurred);
})

//Search Crime based on keyword
_evt(_('.options #search_text'), 'input', () => {
    const search_text = _('.options #search_text').value;
    
    if (search_text == "")
        loadCrimeTable();
    else
        searchCrime(search_text);
})

_evt(_('.crime_modal .cancel_btn'), 'click', () => {
    _('.crime_modal').style.display = 'none';
})

_evt(_('.options .add_new_btn'), 'click', () => {
    _('.crime_modal').style.display = 'flex';
    _('.crime_modal h2').innerText = 'Add New Crime Record';
    _('.crime_modal .save_btn').innerText = "Save"
    resetCrimeModal()
})

_evt(_('.delete_modal .btns .cancel'), 'click', () => {
    _('.delete_modal').style.display = "none";
})

_evt(window, 'load', ()=> {
    fetch('API/Crimes/getCrimeRecordsByDatesOfMonth')
    .then(res => res.json())
    .then(data => {

        _('.print_report #report_dates').innerHTML = '<option hidden>Export Reports</option>'

        data.forEach(element => {
            const option = document.createElement('option');

            option.setAttribute('value', element.date_occurred);
            option.innerText = 'Report for '+ element.date_occurred;

            _('.print_report #report_dates').append(option);
        })
    })
    
})

_evt(_('.print_report #report_dates'), 'change', ()=> {
    const report_date = _('.print_report #report_dates').value;
    //Report Section must be similar to Table name from database
    const report_section = 'Crimes';

    window.location = 'views/pages/report.php?report_date='+ report_date +'&report_section='+ report_section
})

//Edit Crime Record
function editCrime(crime_id){
    _('.crime_modal').style.display = 'flex';
    _('.crime_modal #crime_id').value = crime_id; 
    _('.crime_modal #crime_type').value = _(`.table .crime_row_${crime_id} .crime_type`).innerText;
    _('.crime_modal #barangay').value = _(`.table .crime_row_${crime_id} .crime_barangay`).innerText;
    _('.crime_modal #date_occurred').value = _(`.table .crime_row_${crime_id} .crime_date`).innerText;
    _('.crime_modal #time_occurred').value = _(`.table .crime_row_${crime_id} .crime_time`).innerText;
    _('.crime_modal h2').innerText = "Update Crime Record";
    _('.crime_modal .save_btn').innerText = 'Update';
}

function deleteCrime(crime_id) {
    _('.delete_modal .delete_form .delete').setAttribute('onclick', `deleteCrimeRecord(${crime_id})`);
    _('.delete_modal').style.display = "flex";
}

function searchCrime(search_text){
    const formData = new FormData();

    formData.append('search_text', search_text);

    fetch('API/Crimes/getCrimeRecord', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        emptyCrimeTable();

        if (data.length == 0) {
            const crime_table = _('.table table');
            const tr = document.createElement('tr');

            tr.setAttribute('rowSpan', 5);
            tr.innerHTML = '<td></td><td></td><td> No Data Found </td><td></td><td></td>';
            crime_table.append(tr);
        }
        else {
            data.forEach(element => {
                const crime_table = _('.table table');
                const tr = document.createElement('tr');
    
                tr.classList.add(`crime_row_${element.id}`)
                tr.innerHTML = `<tr>
                <td class="crime_type">${element.name}</td>
                <td class="crime_barangay">${element.barangay}</td>
                <td class="crime_date">${element.date_occurred}</td>
                <td class="crime_time">${element.time_occurred}</td>
                <td class="action_btns">
                    <div class="edit_btn" onclick="editCrime(${element.id}, ${element.crime_type_id})"></div>
                    <div class="delete_btn" onclick="deleteCrime(${element.id})"></div>
                </td>
                `;
    
                crime_table.append(tr)
            });
        }
    })
    .catch(e => console.log(e))
}

function loadCrimeTable(){
    fetch('API/Crimes/getCrimeRecords')
    .then(res => res.json())
    .then(data => {
        emptyCrimeTable();
        data.forEach(element => {
            const crime_table = _('.table table');
            const tr = document.createElement('tr')
            
            tr.classList.add(`crime_row_${element.id}`)
            tr.innerHTML = `<tr>
            <td class="crime_type">${element.crime_type}</td>
            <td class="crime_barangay">${element.barangay}</td>
            <td class="crime_date">${element.date_occurred}</td>
            <td class="crime_time">${element.time_occurred}</td>
            <td class="action_btns">
                <div class="edit_btn" onclick="editCrime(${element.id})"></div>
                <div class="delete_btn" onclick="deleteCrime(${element.id})"></div>
            </td>
            `;

            crime_table.append(tr)
        });
    })
    .catch(e => console.log(e))
}

function emptyCrimeTable(){
    _('.table table').innerHTML = `
        <tr>
            <th>Crime Type</th>
            <th>Barangay</th>
            <th>Date Occured</th>
            <th>Time Occured</th>
            <th>Action</th>
        </tr>
    `;
}

function loadBarangay(){
    fetch('data/address.json')
    .then(res => res.json())
    .then(data => {
        const barangays = data['03'].province_list['NUEVA ECIJA'].municipality_list['SANTO DOMINGO'].barangay_list;

        for(let i =0; i < barangays.length; i++) {
            const barangay = document.querySelector('.crime_modal #barangay');

            const option = document.createElement('option');
            option.setAttribute('value', barangays[i]);
            option.innerText = barangays[i];
            barangay.append(option) 
        }
            
    })
    .catch(e => console.log(e))
}

function resetCrimeModal(){
    _('.crime_modal #crime_type').value = "";
    _('.crime_modal #barangay').selectedIndex = 0;
    _('.crime_modal #date_occurred').value = "";
    _('.crime_modal #time_occurred').value = "";
}

function saveCrimeRecord(crime_type, barangay, date_occurred, time_occurred){
    const formData = new FormData();

    formData.append('crime_type', crime_type)
    formData.append('barangay', barangay)
    formData.append('date_occurred', date_occurred)
    formData.append('time_occurred', time_occurred)

    fetch('API/Crimes/addCrimeRecord',{
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        emptyCrimeTable();
        loadCrimeTable();
        resetCrimeModal();

        if ( data > 0) {
            showNotif("Record Succesfully Added!");
        }
        else {
            showNotif("Adding Record Failed");
        } 

        console.log(data)
    })
    .catch(e => {
        showNotif('Error: '+ e);
    })
}

function updateCrimeRecord(crime_id, crime_type, barangay, date_occurred, time_occurred){
    const formData = new FormData();

    formData.append('crime_id', crime_id)
    formData.append('crime_type', crime_type)
    formData.append('barangay', barangay)
    formData.append('date_occurred', date_occurred)
    formData.append('time_occurred', time_occurred)

    fetch('API/Crimes/updateCrimeRecord',{
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        emptyCrimeTable();
        loadCrimeTable();
        resetCrimeModal();
        if ( data > 0) {
            showNotif("Record Succesfully Updated!");
        }
        else {
            showNotif("Updating Record Failed");
        }
    })
    .catch(e => {
        console.log("Error: " + e);
    })
}

function deleteCrimeRecord(crime_id) {
    const formData = new FormData();

    formData.append('crime_id', crime_id)

    fetch('API/Crimes/deleteCrimeRecord',{
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        _('.delete_modal').style.display = "none";
        _(`.table .crime_row_${crime_id}`).style.display = "none";

        if ( data > 0) {
            showNotif("Record Succesfully Deleted!");
        }
        else {
            showNotif("Deleting Record Failed");
        }
    })
    .catch(e => {
        showNotif("Error: " + e)
    })
}

function showNotif(message){
    _('.crime_modal').style.display = "none";
    _('.notif').innerHTML = message;
    _('.notif').style.right = "10px";
    _('.notif').style.transform = "rotateZ(0deg)";

    setTimeout( () =>{
        _('.notif').style.right = "-100%";
    },5000)
}