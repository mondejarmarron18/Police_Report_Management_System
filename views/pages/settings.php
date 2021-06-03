<script src="services/crimes.js" defer></script>
<div class="crime_options">
    <div class="crime_search_box">
        <input type="text" name="" id="crime_search_text" placeholder="Search crime by crime type, barangay, date">
    </div>
    <div class="btns">
        <div class="add_new_crime_btn">
            Add New Crime
        </div>
        <div class="manage_crime_types_btn">
            Manage Crime Types
        </div>
    </div>
</div>
<div class="crime_table">
    <table>
    </table>
</div>
<div class="crime_modal">
    <form action="">
        <h2>Register new crime record</h2>
        <input type="text" id="crime_id">
        <label for="">Crime Type</label>
        <select name="" id="crime_type" required></select>
        <label for="barangay">Barangay</label>
        <select name="" id="barangay" required></select>
        <label for="">Date Occurred</label>
        <input type="date" id="date_occurred" required>
        <label for="">Time Occurred</label>
        <input type="time" id="time_occurred" required>
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