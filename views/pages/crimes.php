<script src="services/crimes.js" defer></script>
<div class="options">
    <div class="search_box">
        <input type="text" name="" id="search_text" placeholder="Search crime by crime type, barangay, date, time">
    </div>
    <div class="btns">
        <div class="print_report">
            <select name="" id="report_dates">
            </select>
        </div>
        <div class="add_new_btn">
            Add New Crime
        </div>
    </div>
</div>
<div class="table">
    <table>
    </table>
</div>
<div class="crime_modal">
    <form action="">
        <h2>Register new crime record</h2>
        <input type="text" id="crime_id">
        <label for="">Crime Type</label>
        <input type="text" name="" id="crime_type">
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