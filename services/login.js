_ = (el) => document.querySelector(el);
_evt = (el, evt, fn) => el.addEventListener(evt, fn);

const sign_in_btn = _('.sign_in_btn');
const username = _('#username');
const password = _('#password');
const invalid_notif = _('.invalid_notif');

_evt(sign_in_btn, 'click', () => {
    const formData = new FormData();

    formData.append('username', username.value);
    formData.append('password', password.value);

    fetch('API/UsersAccount/verifyUserRecord', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data == 0 || data == null)
            invalid_notif.style.display = "flex";
        else
            window.location = "LoginSuccess/"+data.username;
    })
})