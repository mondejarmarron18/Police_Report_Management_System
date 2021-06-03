<script src="services/surrendered_items.js" defer></script>
<div class="options">
    <div class="search_box">
        <input type="text" name="" id="search_text" placeholder="Search lost item by item type, date lost, time lost">
    </div>
    <div class="btns">
        <div class="add_new_btn">
            Add New Lost Item
        </div>
    </div>
</div>
<div class="table">
    <table>
    </table>
</div>
<div class="lost_item_modal">
    <form action="">
        <h2>Register new lost item record</h2>
        <input type="text" id="lost_item_id">
        <div class="forms">
            <div class="lost_item_form">
                <h3>Lost Item Infomation</h3>
                <div class="rows_2">
                    <div>
                        <label for="">Image</label>
                        <input type="file" name="" id="lost_item_img" accept="image/jpeg, image/png, image/jpg">
                    </div>
                    <div>
                        <label for="">Type</label>
                        <input type="text" name="" id="lost_item_type">
                    </div>
                </div>
                <label for="">Description</label>
                <textarea name="" rows="3" id="lost_item_description"></textarea>
                <label for="">Location Lost</label>
                <textarea name="" rows="2" id="lost_item_location_lost"></textarea>
                <div class="rows_2">
                    <div>
                        <label for="">Date Lost</label>
                        <input type="date" name="" id="lost_item_date_lost">
                    </div>
                    <div>
                        <label for="">Time Lost</label>
                        <input type="time" name="" id="lost_item_time_lost">
                    </div>
                </div>
                <div class="btns">
                    <div class="cancel_btn">Cancel</div>
                    <div class="next_btn">Next</div>
                </div>
            </div>
            <div class="person_to_contact_form">
                <h3>Person to Contact Information</h3>
                <input type="text" id="person_to_contact_id">
                <div class="search_person_box">
                    <label for="">Search Person</label> 
                    <input type="text" id="search_person_text">
                    <div class="searched_person">
                        <!-- <div>Marvin Ronquillo</div>
                        <div>Maricar Vanez</div> -->
                    </div>
                </div>
                <div class="rows_2">
                    <div>
                        <label for="">First Name</label>
                        <input type="text" id="person_to_contact_first_name">
                    </div>
                    <div>
                        <label for="">Middle Name</label>
                        <input type="text" id="person_to_contact_middle_name">
                    </div>
                </div>
                <div class="rows_2">
                    <div>
                        <label for="">Last Name</label>
                        <input type="text" id="person_to_contact_last_name">
                    </div>
                    <div>
                        <label for="">Name Extention</label>
                        <input type="text" id="person_to_contact_name_extention">
                    </div>
                </div>
                <label for="">Date of Birth</label>
                <input type="date" name="" id="person_to_contact_birth_date">
                <label for="">Email</label>
                <input type="email" name="" id="person_to_contact_email">
                <label for="">Contact Number</label>
                <input type="text" name="" id="person_to_contact_contact_number">
                <label for="">Address</label>
                <textarea name="" id="person_to_contact_address" rows="2"></textarea>
                <div class="btns">
                    <div class="back_btn">Back</div>
                    <div class="save_btn">Save</div>
                </div>
            </div>
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