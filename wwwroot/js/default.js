_ = (el) => document.querySelector(el);
_evt = (el, evt, fn) => el.addEventListener(evt, fn);


//ADD LINKS TO EACH NAV BTN
_evt(_('.nav .dashboard_btn'), 'click', ()=> window.location = "dashboard.php")
_evt(_('.nav .crimes_btn'), 'click', ()=> window.location = "crimes.php")
_evt(_('.nav .lost_items_btn'), 'click', ()=> window.location = "lost_items.php")
// _evt(_('.nav .surrendered_items_btn'), 'click', ()=> window.location = "surrendered_items.php")
_evt(_('.nav .missing_persons_btn'), 'click', ()=> window.location = "missing_persons.php")
_evt(_('.nav .users_account_btn'), 'click', ()=> window.location = "users_account.php")

_evt(_('.notif'), 'click', () => {
    _('.notif').style.right = "-100%";
})

_evt(_('.logout_btn'), 'click', ()=> window.location = "logout.php");

