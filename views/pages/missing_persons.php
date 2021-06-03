<script src="services/missing_persons.js" defer></script>
<div class="options">
    <div class="search_box">
        <input type="text" name="" id="search_text" placeholder="Search lost item by item type, date lost, time lost, status - complete">
    </div>
    <div class="btns">
        <div class="print_report">
            <select name="" id="report_dates">
            </select>
        </div>
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
        <div class="forms">
            <div class="lost_item_form">
                <h3>Lost Item Infomation</h3>
                <input type="text" id="lost_item_id" placeholder="Lost Item ID">
                <label for="">Image</label>
                <img src="" class="lost_item_display_img"/>
                <input type="file" name="" id="lost_item_img" accept="image/jpeg, image/png, image/jpg">
                <label for="">Type</label>
                <input type="text" name="" id="lost_item_type" placeholder="Ex: wallet, bag, motorcycle...">
                <label for="">Description</label>
                <textarea name="" rows="3" id="lost_item_description" placeholder="Ex: Color of the item, plate number if motorcycle/car, size ..."></textarea>
                <label for="">Location Lost</label>
                <textarea name="" rows="2" id="lost_item_location_lost" placeholder="Address where the item lost"></textarea>
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
                <input type="text" id="person_to_contact_id" placeholder="Person To Contact ID">
                <div class="search_person_box">
                    <label for="" class="search_person_label">Search Person</label> 
                    <input type="text" id="search_person_text" placeholder="Search person by name" autocomplete="off">
                    <div class="searched_person">
                    </div>
                </div>
                <div class="existing_record">
                    <!-- This will show if the the existing record is using -->
                </div>
                <div class="rows_2">
                    <div>
                        <label for="">First Name</label>
                        <input type="text" id="person_to_contact_first_name" placeholder="Juan">
                    </div>
                    <div>
                        <label for="">Middle Name</label>
                        <input type="text" id="person_to_contact_middle_name" placeholder="Tamad">
                    </div>
                </div>
                <div class="rows_2">
                    <div>
                        <label for="">Last Name</label>
                        <input type="text" id="person_to_contact_last_name" placeholder="Dela Cruz">
                    </div>
                    <div>
                        <label for="">Name Extention</label>
                        <input type="text" id="person_to_contact_name_extention" placeholder="Ex: Jr, Sr, III">
                    </div>
                </div>
                <label for="">Date of Birth</label>
                <input type="date" name="" id="person_to_contact_birth_date">
                <label for="">Email</label>
                <input type="email" name="" id="person_to_contact_email" placeholder="juandelacruz@gmail.com">
                <label for="">Contact Number</label>
                <input type="text" name="" id="person_to_contact_contact_number" placeholder="09xx-xxxx-xxx">
                <label for="">Address</label>
                <textarea name="" id="person_to_contact_address" rows="2" placeholder="Ex: Zone 1, Brgy. Poblacion, Quezon, Nueva Ecija"></textarea>
                <p class="note">To create new person to contact record please leave the search box empty.</p>
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
<div class="claim_modal">
    <div class="claim_form">
        <h3>Claim Item</h3>
        <br>
        <label for="">Please check the claimer information such as ID to make sure that he/she is the real owner.</label>
        <input type="text" name="" id="item_id">
        <div class="btns">
            <div class="cancel_btn">Cancel</div>
            <div class="claim_btn">Claim</div>
        </div>
    </div>
</div>