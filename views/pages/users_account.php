<script src="services/users_account.js" defer></script>

<div class="options">
    <div></div>
    <!-- <div class="search_box">
        <input type="text" name="" id="search_text" placeholder="Search user by">
    </div> -->
    <div class="btns">
        <div class="add_new_btn">
            Add New User
        </div>
    </div>
</div>
<div class="table">
    <table>
    </table>
</div>
<div class="user_modal">
    <form action="">
        <h2>Register New User</h2>
        <input type="text" id="user_id">
        <div>
            <label for="">Complete Name</label>
            <input type="text" name="" id="complete_name" required>
        </div>
        <div>
            <label for="">Username <span class="username_exist_notif">Already taken, try another username.</span></label>
            <input type="text" name="" id="username" required>
        </div>
        <div>
            <label for="">Password</label>
            <input type="text" name="" id="password" required>
        </div>
        <div>
            <label for="">Email</label>
            <input type="email" name="" id="email" required>
        </div>
        <div>
            <label for="">Contact Number</label>
            <input type="email" name="" id="contact_number" required>
        </div>
        <br>
        <label for="">User Access</label>
        <div class="user_access">
            <div>
                <input type="checkbox" name="" id="crimes">Crimes
            </div>
            <div>
                <input type="checkbox" value="1" id="lost_items">Lost Items
            </div>
            <div>
                <input type="checkbox" name="" id="surrendered_items">Surrendered Items
            </div>
            <div>
                <input type="checkbox" name="" id="missing_persons">Missing Persons
            </div>
            <div>
                <input type="checkbox" name="" id="users_account">User's Account
            </div>
        </div>
        <br>
        
        <span>By checking the options bellow, you are granting the user to have an access to the features that you selected. The user can add, update and delete the records.</span>
        <div class="btns">
            <div class="cancel_btn">Cancel</div>
            <div class="save_btn">Save</div>
        </div>
    </form>
</div>
<div class="delete_modal">
    <div class="delete_form">
        <p>Continue to delete selected row?</p>
        <div class="btns">
            <div class="cancel">Cancel</div>
            <div class="delete">Delete</div>
        </div>
    </div>
</div>