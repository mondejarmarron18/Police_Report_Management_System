_ = (el) => document.querySelector(el);
_evt = (el, evt, fn) => el.addEventListener(evt, fn);

_('.nav .users_account_btn').classList.add('active');

//MODAL
const modal = _('.user_modal');
const modal_cancel_btn = _('.user_modal .cancel_btn');
const modal_save_btn = _('.user_modal .save_btn');
const modal_user_id = _('.user_modal #user_id');
const modal_complete_name = _('.user_modal #complete_name');
const modal_username = _('.user_modal #username');
const modal_password = _('.user_modal #password');
const modal_email = _('.user_modal #email');
const modal_contact_number= _('.user_modal #contact_number');
const modal_crimes= _('.user_modal #crimes');
const modal_lost_items = _('.user_modal #lost_items');
const modal_surrendered_items = _('.user_modal #surrendered_items');
const modal_missing_persons = _('.user_modal #missing_persons');
const modal_users_account = _('.user_modal #users_account');
//TABLE
const add_new_btn = _('.options .add_new_btn');
//CLAIM MODAL

_evt(window, 'load', () =>{
    
})

_evt(add_new_btn, 'click', () => {
    modal.style.display = "flex";
})

_evt(modal_cancel_btn, 'click', () => {
    modal.style.display = "none";
})

_evt(modal_save_btn, 'click', () => {
    emptyUserModal();
    addUserRecord();
})

_evt(modal_username , 'input', () => {
    const formData = new FormData();

    formData.append('username', modal_username.value);

    fetch('API/UsersAccount/getUserRecordByUsername', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (modal_username.value == data.username){
            _('.username_exist_notif').style.display = "inline-block";
        }
        else {
            _('.username_exist_notif').style.display = "none";
        }
    })
    .catch(e => console.log(e))
})

//Load Crimes to Crime Table
_evt(window, 'load', () => loadUsersTable())

function loadUsersTable(){
    fetch('API/UsersAccount/getUserRecords')
    .then(res => res.json())
    .then(data => {
        emptyUsersTable();
        data.forEach(element => {
            const users_table = _('.table table');
            const tr = document.createElement('tr')

            tr.classList.add(`user_row_${element.id}`)
            tr.innerHTML = `<tr>
            <td class="user_username">${element.username}</td>
            <td class="user_complete_name">${element.complete_name}</td>
            <td class="user_email">${element.email}</td>
            <td class="user_contact_number">${element.contact_number}</td>
            <td class="action_btns">
                <div class="edit_btn" onclick="editUser(${element.id})"></div>
                <div class="delete_btn" onclick="deleteUser(${element.id})"></div>
            </td>
            `;

            users_table.append(tr)
        });
    })
    .catch(e => console.log(e))
}

function emptyUsersTable(){
    _('.table table').innerHTML = `
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Complete Name</th>
            <th>Contact Number</th>
            <th>Action</th>
        </tr>
    `;
}

function addUserRecord(){
    const formData = new FormData();

    formData.append('complete_name', modal_complete_name.value)
    formData.append('username', modal_username.value)
    formData.append('password', password.value)
    formData.append('email', modal_email.value)
    formData.append('contact_number', modal_contact_number.value)
    formData.append('crimes_access', modal_crimes.checked)
    formData.append('lost_items_access', modal_lost_items.checked)
    formData.append('surrendered_items_access', modal_surrendered_items.checked)
    formData.append('missing_persons_access', modal_missing_persons.checked)
    formData.append('users_account_access', modal_users_account.checked)

    fetch('API/UsersAccount/addUserRecord', {
        method: 'POST',
        body: formData
    })
    .then(res => console.log(res.json()))
    .then(data => {
        if (data > 0) {
            emptyUsersTable();
            loadUsersTable();
            showNotif('Record Added Successfully');
        }
        else {
            showNotif('Adding Record Failes');
        }
    })
    .catch(e => console.log(e))
}

function showNotif(message){
    _('.notif').innerHTML = message;
    _('.notif').style.right = "10px";
    _('.notif').style.transform = "rotateZ(0deg)";
    modal.style.display = "none";

    setTimeout( () =>{
        _('.notif').style.right = "-100%";
    },5000)

    _evt(_('.notif'), 'transitionEnd', ()=> {
        _('.notif').style.transform = "rotateZ(45deg)"
    })
}

function editUser(user_id){
    modal.style.display = "flex";
    modal_user_id.value = user_id;
}

function emptyUserModal(){
    modal_user_id.value = "";
    modal_complete_name.value = "";
    modal_username.value = "";
    modal_password.value = "";
    modal_email.value = "";
    modal_contact_number.value = "";
    modal_crimes.click
    modal_lost_items.checked = true;
    modal_surrendered_items.checked = false;
    modal_missing_persons.checked = false;
    modal_users_account.checked = false;
}
