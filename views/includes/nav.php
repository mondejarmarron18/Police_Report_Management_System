<div class="nav">
    <div class="logo">
        <p>PRMS</p>
        <p>Police Report Management System</p>
    </div>
    <div class="user">
        <img class="user__img" src="wwwroot/vectors/male_avatar.svg" alt="User Image">
        <p class="user__name"><?php echo $_SESSION['username']; ?></p>
    </div>
    <div class="nav__btn dashboard_btn">Dashboard</div>
    <div class="nav__btn crimes_btn">Crimes</div>
    <div class="nav__btn lost_items_btn">Lost Items</div>
    <!-- <div class="nav__btn surrendered_items_btn">Surrendered Items</div> -->
    <div class="nav__btn missing_persons_btn">Missing Persons</div>
    <div class="nav__btn users_account_btn">User's Account</div>
</div>