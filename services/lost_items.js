_ = (el) => document.querySelector(el);
_evt = (el, evt, fn) => el.addEventListener(evt, fn);

//LOST ITEM MODAL
const lost_item_modal = _('.lost_item_modal');
const lost_item_title = _('.lost_item_modal h2');
const lost_item_forms = _('.lost_item_modal .forms');
const lost_item_form = _('.lost_item_modal form');
const modal_cancel_btn = _('.lost_item_modal .lost_item_form .cancel_btn');
const modal_next_btn = _('.lost_item_modal .lost_item_form .next_btn');
const modal_back_btn = _('.lost_item_modal .person_to_contact_form .back_btn');
const modal_save_btn = _('.lost_item_modal .person_to_contact_form .save_btn');
const modal_claim_btn = _('.lost_item_modal .claim_btn');
//LOST ITEM MODAL INPUTS
const lost_item_id = _('.lost_item_form #lost_item_id');
const lost_item_image = _('.lost_item_form #lost_item_img');
const lost_item_display_img = _('.lost_item_form .lost_item_display_img');
const lost_item_type = _('.lost_item_form #lost_item_type');
const lost_item_description = _('.lost_item_form #lost_item_description');
const lost_item_location_lost = _('.lost_item_form #lost_item_location_lost');
const lost_item_date_lost = _('.lost_item_form #lost_item_date_lost');
const lost_item_time_lost = _('.lost_item_form #lost_item_time_lost');
//PERSON TO CONTACT MODAL INPUTS
const person_to_contact_id = _('.person_to_contact_form #person_to_contact_id');
const person_to_contact_search_text = _('.person_to_contact_form #search_person_text');
const person_to_contact_searched_person = _('.person_to_contact_form .searched_person');
const person_to_contact_first_name = _('.person_to_contact_form #person_to_contact_first_name');
const person_to_contact_middle_name = _('.person_to_contact_form #person_to_contact_middle_name');
const person_to_contact_last_name = _('.person_to_contact_form #person_to_contact_last_name');
const person_to_contact_name_extention = _('.person_to_contact_form #person_to_contact_name_extention');
const person_to_contact_birth_date = _('.person_to_contact_form #person_to_contact_birth_date');
const person_to_contact_email = _('.person_to_contact_form #person_to_contact_email');
const person_to_contact_contact_number = _('.person_to_contact_form #person_to_contact_contact_number');
const person_to_contact_note = _('.person_to_contact_form .note');
const person_to_contact_address = _('.person_to_contact_form #person_to_contact_address');
//BTN TO OPEN ADD NEW RECORD MODAL
const add_new_record_btn = _('.options .btns .add_new_btn');
//DELETE MODAL
const delete_modal = _('.delete_modal');
const delete_modal_cancel_btn = _('.delete_modal .btns .cancel');
const delete_modal_delete_btn = _('.delete_modal .btns .delete');
//CURRENT PERSON ID
let current_person_id;
//CLAIM MODAL
const claim_modal = _('.claim_modal');
const claim_item_id= _('.claim_modal #item_id');
const claim_cancel_btn = _('.claim_modal .cancel_btn');
const claim_btn = _('.claim_modal .claim_btn');

//MANK LOST AND FOUND ITEM BUTTON AS ACTIVE
_('.nav .lost_items_btn').classList.add('active');

//Load Crimes to Crime Table
_evt(window, 'load', () => loadLostItemTableRecord())

_evt(add_new_record_btn, 'click', () => {
    lost_item_modal.style.display = "flex";
    lost_item_title.innerHTML = "Register New Lost Item Record";
    modal_save_btn.innerHTML = "Save";
    person_to_contact_id.value = '';
    lost_item_display_img.style.display = "none"
    emptyLostItem();
    emptyPersonToContact();
    enablePersonToContact();
})

_evt(claim_btn, 'click', () => {
    claimItemRecord(claim_item_id.value);
})

_evt(claim_cancel_btn, 'click', () => {
    claim_modal.style.display = "none";
})

_evt(modal_cancel_btn, 'click', () => {
    lost_item_modal.style.display = "none";
})

_evt(modal_next_btn, 'click', ()=> {
    lost_item_forms.classList.add('show_second_form');
})

_evt(modal_back_btn, 'click', ()=> {
    lost_item_forms.classList.remove('show_second_form');
})

_evt(window, 'load', ()=> {
    fetch('API/LostItems/getLostItemRecordByDatesOfMonth')
    .then(res => res.json())
    .then(data => {
        _('.print_report #report_dates').innerHTML = '<option hidden>Export Reports</option>'
        
        data.forEach(element => {
            const option = document.createElement('option');

            option.setAttribute('value', element.date_lost);
            option.innerText = 'Report for '+ element.date_lost;

            _('.print_report #report_dates').append(option);
        })
    })
    
})

_evt(_('.print_report #report_dates'), 'change', ()=> {
    const report_date = _('.print_report #report_dates').value;
    //Report Section must be similar to Table name from database
    const report_section = 'Lost Items';

    window.location = 'views/pages/report.php?report_date='+ report_date +'&report_section='+ report_section
})

//SAVE OR INSERT OR UPDATE RECORD
_evt(modal_save_btn, 'click', () => {
    if (modal_save_btn.innerHTML.toUpperCase() == 'SAVE')
        addLostItemRecord();
    else 
        updateLostItemRecord();
})

//SEARCH LOST ITEM RECORD BASED ON KEYWORD
_evt(_('.options #search_text'), 'input', () => {
    const search_text = _('.options #search_text').value;
    
    if (search_text == "")
        loadLostItemTableRecord();
    else
        searchLostItemRecord(search_text);
})

//MODAL TO DELETE RECORD
_evt(delete_modal_cancel_btn, 'click', () =>{
    delete_modal.style.display = "none";
})

//SEARCH BOX TO SEARCH EXISTING PERSON RECORD
_evt(person_to_contact_search_text, 'input', () =>{
    if (person_to_contact_search_text.value == '') {
        if (modal_save_btn.innerHTML.toUpperCase() == 'SAVE'){
            person_to_contact_id.value = '';
            enablePersonToContact();
        }
        else {
            person_to_contact_id.value = current_person_id;
            loadCurrentPerson(current_person_id);
        }   
        person_to_contact_searched_person.innerHTML = '';
    }
    else {
        loadExistingPerson();
    }
    
})

function loadExistingPerson(){
    const formData = new FormData();

    formData.append('person_name', person_to_contact_search_text.value)

    fetch('API/Persons/getPersonRecordByName', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        person_to_contact_searched_person.innerHTML = '';

        for(let i = 0; i < data.length ; i++) {
            const div = document.createElement('div');
            const full_name = `${data[i].first_name} ${data[i].middle_name} ${data[i].last_name}  ${data[i].name_extention}`;
        
            div.innerHTML = full_name;
            div.setAttribute(
                'onclick',
                `fillPersonToContact(
                    ${data[i].id}, 
                    \"${full_name}\",
                    \"${data[i].first_name}\", 
                    \"${data[i].middle_name}\", 
                    \"${data[i].last_name}\", 
                    \"${data[i].name_extention}\", 
                    \"${data[i].birth_date}\", 
                    \"${data[i].email}\", 
                    \"${data[i].contact_number}\", 
                    \"${data[i].address}\"
                )`
            );
            person_to_contact_searched_person.append(div)
        }
    })
    .catch(e => console.log(e))
}

function loadCurrentPerson(person_id){
    const formData = new FormData();

    formData.append('person_id', person_id);

    fetch('API/Persons/getPersonRecordById', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        person_to_contact_first_name.value = data.first_name;
        person_to_contact_middle_name.value = data.middle_name;
        person_to_contact_last_name.value = data.last_name;
        person_to_contact_name_extention.value = data.name_extention;
        person_to_contact_birth_date.value = data.birth_date;
        person_to_contact_email.value = data.email;
        person_to_contact_contact_number.value = data.contact_number;
        person_to_contact_address.value = data.address;
        person_to_contact_searched_person.innerHTML = '';
        person_to_contact_note.innerHTML = "You are using last saved person's record, use the search box to change the person to contact record.";
    })
    .catch(e => console.log(e))
}

function emptyLostItemTable(){
    _('.table table').innerHTML = `
        <tr>
            <th>Item Type</th>
            <th>Date Lost</th>
            <th>Time Lost</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    `;
}

function fillPersonToContact(id, full_name, first_name, middle_name, last_name, name_extention, birth_date, email, contact_number, address) {
    person_to_contact_id.value = id;
    person_to_contact_first_name.value = first_name;
    person_to_contact_middle_name.value = middle_name;
    person_to_contact_last_name.value = last_name;
    person_to_contact_name_extention.value = name_extention;
    person_to_contact_birth_date.value = birth_date;
    person_to_contact_email.value = email;
    person_to_contact_contact_number.value = contact_number;
    person_to_contact_address.value = address;
    person_to_contact_search_text.value = full_name;
    person_to_contact_searched_person.innerHTML = '';
    person_to_contact_search_text.value = full_name;

    if (modal_save_btn.innerHTML.toUpperCase() == "SAVE")
        person_to_contact_note.innerHTML = `You are using <b>${full_name}'s</b> record. Leave the search box empty to be able to add new record.`;
    else
        person_to_contact_note.innerHTML = `You are using <b>${full_name}'s</b> record. Leave the search box empty to restore the current person's record.`;

    disablePersonTocontact();
}

function emptyLostItem(){
    lost_item_id.value = '';
    lost_item_image.value = '';
    lost_item_type.value = '';
    lost_item_description.value = '';
    lost_item_location_lost.value = '';
    lost_item_date_lost.value = '';
    lost_item_time_lost.value = '';
}

function emptyPersonToContact() {
    person_to_contact_id.value = '';
    person_to_contact_search_text.value = '';
    person_to_contact_first_name.value = '';
    person_to_contact_middle_name.value = '';
    person_to_contact_last_name.value = '';
    person_to_contact_name_extention.value = '';
    person_to_contact_birth_date.value = '';
    person_to_contact_email.value = '';
    person_to_contact_contact_number.value = '';
    person_to_contact_address.value = '';
    person_to_contact_search_text.value = '';
}

function disablePersonTocontact() {
    person_to_contact_first_name.classList.add('disabled');
    person_to_contact_middle_name.classList.add('disabled');
    person_to_contact_last_name.classList.add('disabled');
    person_to_contact_name_extention.classList.add('disabled');
    person_to_contact_birth_date.classList.add('disabled');
    person_to_contact_email.classList.add('disabled');
    person_to_contact_contact_number.classList.add('disabled');
    person_to_contact_address.classList.add('disabled');
}

function enablePersonToContact(){
    person_to_contact_note.innerHTML = "Use the seach box to use a person's existing record."
    person_to_contact_searched_person.innerHTML = '';
    person_to_contact_first_name.classList.remove('disabled');
    person_to_contact_middle_name.classList.remove('disabled');
    person_to_contact_last_name.classList.remove('disabled');
    person_to_contact_name_extention.classList.remove('disabled');
    person_to_contact_birth_date.classList.remove('disabled');
    person_to_contact_email.classList.remove('disabled');
    person_to_contact_contact_number.classList.remove('disabled');
    person_to_contact_address.classList.remove('disabled');
}

function editLostItem(item_id, person_id) {
    lost_item_modal.style.display = "flex";
    lost_item_title.innerHTML = "Update Lost Item Record";
    modal_save_btn.innerHTML = "Update";
    person_to_contact_search_text.value = '';
    current_person_id = person_id;
    disablePersonTocontact();

    const formData = new FormData();

    formData.append('item_id', item_id)
    formData.append('person_id', person_id)

    fetch('API/LostItems/getLostItemRecordById', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        lost_item_id.value = data.id;
        lost_item_type.value = data.type;
        lost_item_display_img.style.display = "flex"
        lost_item_display_img.setAttribute('src', 'wwwroot/img/lost_items/' + data.image)
        lost_item_description.value = data.description;
        lost_item_location_lost.value = data.location_lost;
        lost_item_date_lost.value = data.date_lost;
        lost_item_time_lost.value = data.time_lost;
    })

    fetch('API/Persons/getPersonRecordById', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        person_to_contact_id.value = data.id
        person_to_contact_first_name.value = data.first_name
        person_to_contact_middle_name.value = data.middle_name
        person_to_contact_last_name.value = data.last_name
        person_to_contact_name_extention.value = data.name_extention
        person_to_contact_birth_date.value = data.birth_date
        person_to_contact_email.value = data.email
        person_to_contact_contact_number.value = data.contact_number
        person_to_contact_address.value = data.address
    })
}

function deleteLostItem(lost_item_id){
    delete_modal_delete_btn.setAttribute('onclick', `deleteLostItemRecord(${lost_item_id})`);
    delete_modal.style.display = "flex";
}

function searchLostItemRecord(search_text){
    const formData = new FormData();

    formData.append('search_text', search_text);

    fetch('API/LostItems/getLostItemRecord', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        emptyLostItemTable();
 
        if (data.length == 0) {
            const table = _('.table table');
            const tr = document.createElement('tr');

            tr.setAttribute('rowSpan', 5);
            tr.innerHTML = '<td></td><td></td><td> No Data Found </td><td></td><td></td>';
            table.append(tr);
        }
        else {
            
            data.forEach(element => {
                const table = _('.table table');
                const tr = document.createElement('tr');
                let item_status;
    
                if (element.surrenderer_id > 0)
                    item_status = "Claimed";
                else
                    item_status = "Missing";
    
                tr.classList.add(`item_row_${element.id}`)
                tr.innerHTML = `<tr>
                <td class="item_type">${element.type}</td>
                <td class="item_date_lost">${element.date_lost}</td>
                <td class="item_time_lost">${element.time_lost}</td>
                <td class="item_time_lost">${item_status}</td>
                <td class="action_btns">
                    <div class="claim_btn" title="Update Status" onclick="claimLostItem(${element.id})"></div>
                    <div class="edit_btn" title="Edit" onclick="editLostItem(${element.id}, ${element.person_to_contact_id})"></div>
                    <div class="delete_btn" title="Delete" onclick="deleteLostItem(${element.id})"></div>
                </td>
                `;
    
                table.append(tr)
            });
        }
    })
    .catch(e => console.log(e))
}

function loadLostItemTableRecord(){
    fetch('API/LostItems/getLostItemRecords')
    .then(res => res.json())
    .then(data => {
        emptyLostItemTable();

        data.forEach(element => {
            const table = _('.table table');
            const tr = document.createElement('tr');
            let item_status;

            if (element.surrenderer_id > 0)
                item_status = "Claimed";
            else
                item_status = "Missing";

            tr.classList.add(`item_row_${element.id}`)
            tr.innerHTML = `<tr>
            <td class="item_type">${element.type}</td>
            <td class="item_date_lost">${element.date_lost}</td>
            <td class="item_time_lost">${element.time_lost}</td>
            <td class="item_time_lost">${item_status}</td>
            <td class="action_btns">
                <div class="claim_btn" title="Update Status" onclick="claimLostItem(${element.id})"></div>
                <div class="edit_btn" title="Edit" onclick="editLostItem(${element.id}, ${element.person_to_contact_id})"></div>
                <div class="delete_btn" title="Delete" onclick="deleteLostItem(${element.id})"></div>
            </td>
            `;

            table.append(tr)
        });
    })
    .catch(e => console.log(e))
}

function addLostItemRecord(){
    const formData = new FormData();
    let image;

    if (lost_item_image.files[0] == null)
        image = '';
    else
        image = lost_item_image.files[0];

    formData.append('image', image);
    formData.append('type', lost_item_type.value)
    formData.append('description', lost_item_description.value)
    formData.append('location_lost', lost_item_location_lost.value)
    formData.append('date_lost', lost_item_date_lost.value)
    formData.append('time_lost', lost_item_time_lost.value)

    if (person_to_contact_id.value == '') {
        addPersonToContactRecord()
        .then(person_to_contact_id => {
            formData.append('person_to_contact_id', person_to_contact_id)

            fetch('API/LostItems/addLostItemRecord',{
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                loadLostItemTableRecord();

                if(data > 0) {
                    showNotif('Record Added Successfully')
                }
                else {
                    showNotif('Adding Record Failed')
                }
            })
            .catch(e => {
                showNotif('Error: ' + e)
            })
        })
    }
    else {
        formData.append('person_to_contact_id', person_to_contact_id.value);

        fetch('API/LostItems/addLostItemRecord',{
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            loadLostItemTableRecord();
            if(data > 0) {
                showNotif('Record Added Successfully')
            }
            else {
                showNotif('Adding Record Failed')
            }
        })
        .catch(e => {
            showNotif('Error: ' + e)
        })
    }
}

function addPersonToContactRecord() {
    const formData = new FormData();

    formData.append('first_name', person_to_contact_first_name.value)
    formData.append('middle_name', person_to_contact_middle_name.value)
    formData.append('last_name', person_to_contact_last_name.value)
    formData.append('name_extention', person_to_contact_name_extention.value)
    formData.append('birth_date', person_to_contact_birth_date.value)
    formData.append('email', person_to_contact_email.value)
    formData.append('contact_number', person_to_contact_contact_number.value)
    formData.append('address', person_to_contact_address.value)

    return fetch('API/Persons/addPersonRecord', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        return data;
    })
    .catch(e => {
        return e;
    })
}

function updateLostItemRecord(){
    const formData = new FormData();

    let image;

    if (lost_item_image.files[0] == null)
        image = '';
    else
        image = lost_item_image.files[0];

    formData.append('lost_item_id', lost_item_id.value)
    formData.append('person_to_contact_id', person_to_contact_id.value)
    formData.append('image', image);
    formData.append('type', lost_item_type.value)
    formData.append('description', lost_item_description.value)
    formData.append('location_lost', lost_item_location_lost.value)
    formData.append('date_lost', lost_item_date_lost.value)
    formData.append('time_lost', lost_item_time_lost.value)

    fetch('API/LostItems/updateLostItemRecord',{
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data) {
            showNotif("Record Successfully Updated!");
            emptyLostItemTable();
            loadLostItemTableRecord();
            current_person_id = data;
        }
        else{
            showNotif("Updating Record Failed!");
        }
        lost_item_modal.style.display = 'none';
    })
    .catch(e => console.log(e))
}

function deleteLostItemRecord(lost_item_id){
    const formData = new FormData();

    formData.append('lost_item_id', lost_item_id);

    fetch('API/LostItems/deleteLostItemRecord', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data > 0) {
            showNotif('Record Deleted Successfully')
        }
        else {
            showNotif('Deleting Record Failed')
        }
        _(`.table .item_row_${lost_item_id}`).style.display = "none";
        delete_modal.style.display = "none";
    })
    .catch(e => {
        showNotif('Error: ' + e)
    })
}

function showNotif(message){
    _('.notif').innerHTML = message;
    _('.notif').style.right = "10px";
    _('.notif').style.transform = "rotateZ(0deg)";
    lost_item_modal.style.display = "none";
    lost_item_forms.classList.remove('show_second_form');

    setTimeout( () =>{
        _('.notif').style.right = "-100%";
    },5000)

    _evt(_('.notif'), 'transitionEnd', ()=> {
        _('.notif').style.transform = "rotateZ(45deg)"
    })
}

function claimLostItem(item_id){
    claim_modal.style.display = "flex";
    claim_item_id.value = item_id;
}

function claimItemRecord(item_id){
    const formData = new FormData();

    formData.append('lost_item_id', item_id);

    fetch('API/LostItems/claimItemRecord',{
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        claim_modal.style.display = "none"
        emptyLostItemTable();
        loadLostItemTableRecord();

        if(data){
            showNotif('Record Successfully Claimed!');
        }
        else{
            showNotif('Record Already Claimed');
        }
    })
    .catch(e => console.log(e))
}