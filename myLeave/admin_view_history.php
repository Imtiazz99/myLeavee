<?php
	include("db_connect.php");
	if(!isset($_SESSION))
	{
		session_start();
	}

	if($_SESSION['sid'] == session_id() && $_SESSION['user_type'] == "Admin")
	{	
		$admin_id = $_SESSION['user_id'];
		$admin_dept = $_SESSION['user_dept'];
		$admin_firstName = $_SESSION['user_firstName'];
		$admin_lastName= $_SESSION['user_lastName'];
	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<link rel="stylesheet" href="css/main.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<title>Online Leave Management</title>
<style>
html, body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
}

a {
  text-decoration: none;
}
	
.row {
  display: flex;
}
.row--align-v-center {
  align-items: center;
}
.row--align-h-center {
  justify-content: center;
}

.grid {
  position: relative;
  display: grid;
  grid-template-columns: 100%;
  grid-template-rows: 50px 1fr 50px;
  grid-template-areas: 'header' 'main' 'footer';
  height: 100vh;
  overflow-x: hidden;
}
.grid--noscroll {
  overflow-y: hidden;
}

.header {
  grid-area: header;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: #F9FAFC;
}
.header__menu {
  position: fixed;
  padding: 13px;
  left: 12px;
  background-color: #DADAE3;
  border-radius: 50%;
  z-index: 1;
}
.header__menu:hover {
  cursor: pointer;
}
.header__title {
  margin-left: 20px;
  font-size: 20px;
  color: #777;
}
.header__avatar {
  background-image: url(avatar2.png);
  background-size: cover;
  background-repeat: no-repeat;
  border-radius: 50%;
  border: 2px solid rgba(255, 255, 255, 0.2);
  position: relative;
  margin: 0 26px;
  width: 35px;
  height: 35px;
  cursor: pointer;
}
.header__avatar:after {
  position: absolute;
  content: "";
  width: 6px;
  height: 6px;
  background: none;
  border-left: 2px solid #777;
  border-bottom: 2px solid #777;
  transform: rotate(-45deg) translateY(-50%);
  top: 50%;
  right: -18px;
}
	
.dropbtn {
  background: transparent;
  border-radius: 50%;
  padding: 25px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}
.dropbtn:focus {
  outline: none;
}
.dropdown {
  float: right;
  position: relative;
  display: inline-block;
}
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 200px;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  right: 0;
  z-index: 1;
}
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}
.dropdown a:hover {
  background-color: #ddd;
}
.show {
  display: block;
}
	
.sidenav {
  position: fixed;
  grid-area: sidenav;
  height: 100%;
  overflow-y: auto;
  background-color: #1F1F1F;
  color: #FFF;
  width: 240px;
  transform: translateX(-245px);
  transition: all .6s ease-in-out;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16), 0 0 0 1px rgba(0, 0, 0, 0.08);
  z-index: 2;
}
.sidenav__brand {
  position: relative;
  display: flex;
  align-items: center;
  padding: 10px 16px;
  height: 50px;
  background-color: rgba(0, 0, 0, 0.15);
}
.sidenav__brand-close {
  position: absolute;
  right: 8px;
  top: 8px;
  visibility: visible;
  color: rgba(255, 255, 255, 0.5);
  cursor: pointer;
}
.sidenav__profile {
  display: flex;
  align-items: center;
  min-height: 90px;
  background-color: rgba(255, 255, 255, 0.1);

}
.sidenav__profile-avatar {
  background-image: url(avatar2.png);
  background-size: cover;
  background-repeat: no-repeat;
  border-radius: 50%;
  height: 64px;
  width: 64px;
  margin: 0 15px;
}
.sidenav__profile-title {
  letter-spacing: 1px;
}
.sidenav__arrow {
  position: absolute;
  content: "";
  width: 6px;
  height: 6px;
  top: 50%;
  right: 20px;
  border-left: 2px solid rgba(255, 255, 255, 0.5);
  border-bottom: 2px solid rgba(255, 255, 255, 0.5);
  transform: translateY(-50%) rotate(225deg);
}
.sidenav__sublist {
  list-style-type: none;
  margin: 0;
  padding: 10px 0 0;
}
.sidenav--active {
  transform: translateX(0);
}

.navList {
  width: 240px;
  padding: 0;
  margin: 0;
  background-color: #1F1F1F;
  list-style-type: none;
  top: 0;
  left: 0;
  overflow-x: hidden;
}
.navList__heading {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 16px 3px;
  color: rgba(255, 255, 255, 0.5);
  text-transform: uppercase;
  font-size: 15px;
}
.navList__subheading {
  position: relative;
  padding: 10px 0px;
  color: #FFFFFF;
  font-size: 16px;
  text-transform: capitalize;
}
.navList__subheading:after {
  position: absolute;
  content: "";
  height: 6px;
  width: 6px;
  top: 17px;
  right: 25px;
  border-left: 1px solid rgba(255, 255, 255, 0.5);
  border-bottom: 1px solid rgba(255, 255, 255, 0.5);
  transform: rotate(225deg);
  transition: all .2s;
}
.navList__subheading:hover {
  color: #9F9F9F;
}
.navList a, .dropdown-navList {
  padding: 10px 30px;
  text-decoration: none;
  font-size: 16px;
  color: #FFFFFF;
  display: block;
  border: none;
  background: none;
  width: 100%;
  position: relative;
  text-align: left;
  cursor: pointer;
  outline: none;
}
.dropdown-navList:after {
  position: absolute;
  content: "";
  height: 6px;
  width: 6px;
  top: 17px;
  right: 25px;
  border-left: 1px solid rgba(255, 255, 255, 0.5);
  border-bottom: 1px solid rgba(255, 255, 255, 0.5);
  transform: rotate(225deg);
  transition: all .2s;
}
.navList a:hover, .dropdown-navList:hover {
  color: #9F9F9F;
}
.active {
  background-color: #353535;
  color: white;
}
.dropdown-container {
  display: none;
  background-color: #262626;
  padding-left: 8px;
}

	
.main {
  grid-area: main;
  background-color: #EAEDF1;
  color: #394263;
}
.main__cards {
  display: block;
  column-count: 1;
  column-gap: 20px;
  margin: 20px;
}
.main-header {
  position: relative;
  display: flex;
  justify-content: space-between;
  height: 250px;
  color: #FFF;
  background-size: cover;
  background-image: url(coffee.jpg);
  margin-bottom: 20px;
}
.main-header__intro-wrapper {
  display: flex;
  flex: 1;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  height: 160px;
  padding: 12px 30px;
  background: rgba(255, 255, 255, 0.12);
  font-size: 26px;
  letter-spacing: 1px;
}
.main-header__welcome {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.main-header__welcome-title {
  margin-bottom: 8px;
  font-size: 26px;
}
.main-header__welcome-subtitle {
  font-size: 18px;
}

.quickview {
  display: grid;
  grid-auto-flow: column;
  grid-gap: 60px;
}
.quickview__item {
  display: flex;
  align-items: center;
  flex-direction: column;
}
.quickview__item-total {
  margin-bottom: 2px;
  font-size: 32px;
}
.quickview__item-description {
  font-size: 16px;
  text-align: center;
}
	
.card{
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  width: 20%;
  margin: auto;
  margin-bottom: 20px;
  border-radius: 10px;
}
.card__header{
  display: flex;
  align-items: center;
  height: 40px;
  background-color: #AA0407;
  color: #FFF;
  border-radius: 10px;
}
.card__header-title {
  margin: 0 20px;
  font-size: 20px;
  letter-spacing: 1.2px;
}
.card__main{
  background-color: #FFF;
  border-radius: 10px;
}
.card__row {
  display: flex;
}
.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}
	
.footer {
  grid-area: footer;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 16px;
  color: #777;
  background-color: #FFF;
}
.footer__copyright {
  color: #AA0407;
}
.footer__icon {
  color: #e74c3c;
}
.footer__signature {
  color: #AA0407;
  cursor: pointer;
  font-weight: bold;
}

table {
  border: 1px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}
table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}
table tr {
  background-color: #f8f8f8;
  border: 1px solid #ddd;
  padding: .35em;
}
table th, table td {
  padding: .625em;
  text-align: center;
}
table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
}
@media screen and (max-width: 600px) {
  table {
    border: 0;
  }
  table caption {
    font-size: 1.3em;
  }
  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }
  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }
  table td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  table td:last-child {
    border-bottom: 0;
  }
}

select {
	outline: none;
	font-family: inherit;
	font-size: 100%;
  	background: #ededed no-repeat 9px center;
	border: solid 1px #ccc;
	padding: 9px 10px 9px 32px;
	width: 190px;
	border-radius: 10em;
	transition: all .5s;
}
select:focus {
	background-color: #fff;
	border-color: #DB0003;
	box-shadow: 0 0 5px rgba(0,0,0,0.4);	
}	
	
input {
	outline: none;
}
input[type=submit] {
    border: solid 1px #ccc;
    outline: none;
    height: 40px;
    background: #ededed;
    color: #000000;
    font-size: 16px;
    border-radius: 20px;
	width: 40%;
	margin-bottom: 10px;	
}
input[type=submit]:hover{
    cursor: pointer;
    background: #AA0407;
    color: #FFFFFF;
	box-shadow: 0 0 5px rgba(0,0,0,0.4);
}
input[type=text], [type=password] {
	font-family: inherit;
	font-size: 100%;
  	background: #ededed no-repeat 9px center;
	border: solid 1px #ccc;
	padding: 9px 10px 9px 32px;
	width: 150px;
	border-radius: 10em;
	transition: all .5s;
}
input[type=text]:hover, [type=password]:hover {
	background-color: #fff;
	border-color: #DB0003;
	box-shadow: 0 0 5px rgba(0,0,0,0.4);	
}
	
@media only screen and (min-width: 46.875em) {
  .grid {
    display: grid;
    grid-template-columns: 240px calc(100% - 240px);
    grid-template-rows: 50px 1fr 50px;
    grid-template-areas: 'sidenav header' 'sidenav main' 'sidenav footer';
    height: 100vh;
  }

  .sidenav {
    position: relative;
    transform: translateX(0);
  }
  .sidenav__brand-close {
    visibility: hidden;
  }

  .main-header__intro-wrapper {
    padding: 0 30px;
  }

  .header__menu {
    display: none;
  }
  .header__search {
    margin-left: 20px;
  }
  .header__avatar {
    width: 40px;
    height: 40px;
  }
}
@media only screen and (min-width: 65.625em) {
  .main__cards {
    column-count: 2;
  }

  .main-header__intro-wrapper {
    flex-direction: row;
  }
  .main-header__welcome {
    align-items: flex-start;
  }
}
</style>
</head>

<body>
	<div class="grid">
  <header class="header"><em class="fas fa-bars header__menu"></em>
    <div class="header__title">
    </div>
    <div class="header__avatar">
		<div class="dropdown">
			<button onclick="myFunction()" class="dropbtn"></button>
  			<div id="myDropdown" class="dropdown-content">
   	 			<a href="admin_change_password.php">Change Password</a>
				<a href="logout.php" onClick="return logout()">Logout</a>
  			</div>
		</div>
    </div>
  </header>
  <aside class="sidenav">
	  <div class="sidenav__brand">
		  <i class="fas fa-times sidenav__brand-close"></i>
		  <a href="admin_homepage.php"><img src="logo.png" style="max-width: 100%; height: auto"></a>
	  </div>
    <div class="sidenav__profile">
      <div class="sidenav__profile-avatar"></div>
      <div class="sidenav__profile-title"><?php echo $admin_firstName . " " . $admin_lastName ?></div>
    </div>
    <div class="row row--align-v-center row--align-h-center">
	  <ul class="navList">
		  <li class="navList__heading">HOME</li>
		   <li>
			   <div class="navList__subheading row row--align-v-center">
				   <a href="admin_homepage.php" style="color: #FFFFFF"><span class="navList__subheading-title">Dashboard</span></a>
          	   </div>
           </li>
		  <li class="navList__heading">MANAGE</li>
		   <li>
			   <button class="dropdown-navList">Staff 
  		  	   </button>
			   <div class="dropdown-container">
				   <a href="admin_register_staff.php">Register</a>
			  	   <a href="admin_update_staff.php">Update</a>
			  	   <a href="admin_delete_staff.php">Delete</a>
		       </div>
		   </li>
		   <li>
			   <button class="dropdown-navList">Leave 
  		  	   </button>
			   <div class="dropdown-container">
				   <a href="admin_add_leave.php">Add</a>
			  	   <a href="admin_delete_leave.php">Delete</a>
		       </div>
		   </li>
		  <li class="navList__heading">APPLICATION</li>
		   <li>
			   <div class="navList__subheading row row--align-v-center">
				   <a href="admin_view_request.php" style="color: #FFFFFF"><span class="navList__subheading-title">Leave Request</span></a>
          	   </div>
           </li>
		  <li class="navList__heading">HISTORY</li>
		   <li>
			   <div class="navList__subheading row row--align-v-center">
				   <a href="admin_view_history.php" style="color: #FFFFFF"><span class="navList__subheading-title">Leave History</span></a>
          	   </div>
           </li>
      </ul>
    </div>
  </aside>
  <main class="main">
    <div class="main-header">
      <div class="main-header__intro-wrapper">
        <div class="main-header__welcome">
          <div class="main-header__welcome-title"><i></i>Welcome, <strong><i><?php echo $admin_firstName ?></i></strong></div>
          <div class="main-header__welcome-subtitle">How are you today?</div>
        </div>
        <div class="quickview">
          <div class="quickview__item">
            <div class="quickview__item-total">ID</div>
            <div class="quickview__item-description">
              <span class="text-light"><?php echo $admin_id ?></span>
            </div>
          </div>
          <div class="quickview__item">
            <div class="quickview__item-total">Department</div>
            <div class="quickview__item-description">
              <span class="text-light"><?php echo $admin_dept ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
		<div class="card__header">
			<div class="card__header-title">
				<p>Staff History</p>
			</div>
	 	</div>
		<div class="card__main">
			<div class="card__row">
				<table>
					<thead>
						<tr>
							<th colspan="2">
								Search by:
								<br>
								<select name="search">
									<option value="staff_id">Staff ID</option>
                					<option value="staff_name">Staff Name</option>
          						</select>
								<div class="staff_id" style="margin-top: 10px;">
									<form action="admin_view_history_id.php" method="get">
										Staff ID:
										<input type="text" name="id" placeholder="ID" pattern=".{10}" title="Maximum 10 characters" required>
										<br><br>
										<input type="submit" name="search" value="Search"/>
									</form>
								</div>
								<div class="staff_name" style="margin-top: 10px;">
									<form action="admin_view_history_name.php" method="post">
										Staff Name:
										<input type="text" name="name" placeholder="Name" required>
										<br><br>
										<input type="submit" name="search" value="Search"/>
									</form>
								</div>
							</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
  </main>
  <footer class="footer">
    <p><span class="footer__copyright">&copy;</span> 2019 Online Leave Management</p>
    <p>Crafted by <b class="footer__signature">MyLeave</b></p>
	<p>
		<span id="date"></span>
		<script>
			n =  new Date();
			y = n.getFullYear();
			m = n.getMonth() + 1;
			d = n.getDate();
			document.getElementById("date").innerHTML = y + "/" + m + "/" + d;
		</script>
		<span>-</span>
		<span id="time"></span>
		<script>
			function setTime() 
			{
				var d = new Date(),
				el = document.getElementById("time");
				el.innerHTML = formatAMPM(d);
				setTimeout(setTime, 1000);
			}

			function formatAMPM(date) 
			{
			  	var hours = date.getHours(),
				minutes = date.getMinutes(),
				seconds = date.getSeconds(),
				ampm = hours >= 12 ? 'pm' : 'am';
				hours = hours % 12;
				hours = hours ? hours : 12; // the hour '0' should be '12'
				minutes = minutes < 10 ? '0'+minutes : minutes;
				var strTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
				return strTime;
			}
			setTime();
		</script></p>
  </footer>
</div>
<script>
var dropdown = document.getElementsByClassName("dropdown-navList");
var i;
for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
  });
}

function showPassword() 
{
	var x = document.getElementById("myPassword");
	if (x.type === "password") 
	{
		x.type = "text";
	} 	
	else 
	{
    	x.type = "password";
  	}	
}

function logout() 
{
	var msg = confirm("Logout From Account ?");
	if(msg == true)
		return true;
	else
		return false;
}
	
$(document).ready(function(){
	$("select").change(function(){
		$( "select option:selected").each(function(){
			if($(this).attr("value")=="staff_id"){
				$(".staff_name").hide();
                $(".staff_id").show();
			}
            if($(this).attr("value")=="staff_name"){
                $(".staff_id").hide();
                $(".staff_name").show();
            }
            if($(this).attr("value")=="select"){
	            $(".staff_id").hide();
               	$(".staff_name").hide();
            }
		});
	}).change();
});


/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}
// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
/* Scripts for css grid dashboard */
$(document).ready(function () {
  addResizeListeners();
  setSidenavListeners();
  setUserDropdownListener();
  renderChart();
  setMenuClickListener();
  setSidenavCloseListener();
});
// Set constants and grab needed elements
var sidenavEl = $('.sidenav');
var gridEl = $('.grid');
var SIDENAV_ACTIVE_CLASS = 'sidenav--active';
var GRID_NO_SCROLL_CLASS = 'grid--noscroll';
function toggleClass(el, className) {
  if (el.hasClass(className)) {
    el.removeClass(className);
  } else
  {
    el.addClass(className);
  }
}
// User avatar dropdown functionality
function setUserDropdownListener() {
  var userAvatar = $('.header__avatar');
  userAvatar.on('click', function (e) {
    var dropdown = $(this).children('.dropdown');
    toggleClass(dropdown, 'dropdown--active');
  });

}
// Sidenav list sliding functionality
function setSidenavListeners() {
  var subHeadings = $('.navList__subheading');
  console.log('subHeadings: ', subHeadings);
  var SUBHEADING_OPEN_CLASS = 'navList__subheading--open';
  var SUBLIST_HIDDEN_CLASS = 'subList--hidden';
  subHeadings.each(function (i, subHeadingEl) {
    $(subHeadingEl).on('click', function (e) {
      var subListEl = $(subHeadingEl).siblings();
      // Add/remove selected styles to list category heading
      if (subHeadingEl) {
        toggleClass($(subHeadingEl), SUBHEADING_OPEN_CLASS);
      }
      // Reveal/hide the sublist
      if (subListEl && subListEl.length === 1) {
        toggleClass($(subListEl), SUBLIST_HIDDEN_CLASS);
      }
    });
  });
}
// Draw the chart
function renderChart() {
  var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "light",
    "dataProvider": [{
      "month": "Jan",
      "visits": 2025 },
    {
      "month": "Feb",
      "visits": 1882 },
    {
      "month": "Mar",
      "visits": 1809 },
    {
      "month": "Apr",
      "visits": 1322 },
    {
      "month": "May",
      "visits": 1122 },
    {
      "month": "Jun",
      "visits": 1114 },
    {
      "month": "Jul",
      "visits": 984 },
    {
      "month": "Aug",
      "visits": 711 },
    {
      "month": "Sept",
      "visits": 665 },
    {
      "month": "Oct",
      "visits": 580 }],

    "valueAxes": [{
      "gridColor": "#FFFFFF",
      "gridAlpha": 0.2,
      "dashLength": 0 }],

    "gridAboveGraphs": true,
    "startDuration": 1,
    "graphs": [{
      "balloonText": "[[category]]: <b>[[value]]</b>",
      "fillAlphas": 0.8,
      "lineAlpha": 0.2,
      "type": "column",
      "valueField": "visits" }],

    "chartCursor": {
      "categoryBalloonEnabled": false,
      "cursorAlpha": 0,
      "zoomable": false },

    "categoryField": "month",
    "categoryAxis": {
      "gridPosition": "start",
      "gridAlpha": 0,
      "tickPosition": "start",
      "tickLength": 20 },

    "export": {
      "enabled": false } });
}
function toggleClass(el, className) {
  if (el.hasClass(className)) {
    el.removeClass(className);
  } else
  {
    el.addClass(className);
  }
}
// If user opens the menu and then expands the viewport from mobile size without closing the menu,
// make sure scrolling is enabled again and that sidenav active class is removed
function addResizeListeners() {
  $(window).resize(function (e) {
    var width = window.innerWidth;
    console.log('width: ', width);
    if (width > 750) {
      sidenavEl.removeClass(SIDENAV_ACTIVE_CLASS);
      gridEl.removeClass(GRID_NO_SCROLL_CLASS);
    }
  });
}
// Menu open sidenav icon, shown only on mobile
function setMenuClickListener() {
  $('.header__menu').on('click', function (e) {
    console.log('clicked menu icon');
    toggleClass(sidenavEl, SIDENAV_ACTIVE_CLASS);
    toggleClass(gridEl, GRID_NO_SCROLL_CLASS);
  });
}
// Sidenav close icon
function setSidenavCloseListener() {
  $('.sidenav__brand-close').on('click', function (e) {
    toggleClass(sidenavEl, SIDENAV_ACTIVE_CLASS);
    toggleClass(gridEl, GRID_NO_SCROLL_CLASS);
  });
}
</script>
</body>
</html>