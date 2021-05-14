<?php
  include "connection.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Approve Request</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		.search
		{
			padding-left: 1200px;
		}
		.form-control
		{
			width: 300px;
			height: 35px;

		}
		body 
		{

			font-family: "Lato", sans-serif;
			transition: background-color .5s;
		}
.container{
  height: 600px;
  background-color: black;
  opacity: .8;
  color: white;
}
.Approve
{
  margin-left: 420px;
}
.sidenav {
  height: 100%;
  margin-top:50px; 
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #222;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

#main {
  transition: margin-left .5s;
  padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
.img-circle
{
	margin-left: 20px;
}
	</style>
</head>
<body>
	<!--___________________________________side nav_____________________________________________-->
	<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  				<div style="color: white; margin-left: 60px; font-size: 20px;">

					<?php
						echo "<img class='img-circle profile_img' height=120 width=120 src='images/".$_SESSION['pic']."'>";
						echo "</br>";
					    echo "Welcome ".$_SESSION['login_user'];

					?>
				</div>
  
  <a href="books.php">Books</a>
  <a href="request.php">Requested Books</a>
  <a href="issue_info.php">Issue Information</a>
  <a href="expired.php">Expired List</a>
</div>

<div id="main">
  
  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Open</span>


<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "300px";
  document.getElementById("main").style.marginLeft = "300px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.body.style.backgroundColor = "white";
}
</script>
<div class="container">
      <br>
      <h3 style="text-align: center;">Approve Request</h3><br>
      <form class="Approve" action="" method="post"><br>
        <input class="form-control" type="text" name="approve" placeholder="Yes or No" required=""><br>
        <input class="form-control" type="text" name="issuedate" placeholder="Issue Date yyyy-mm-dd" required=""><br>
        <input class="form-control" type="text" name="returndate" placeholder="Return Date yyyy-mm-dd" required=""><br>
        <button class="btn btn-default" type="submit" name="submit">Approve</button>
        
      </form>
</div>
</div>
<?php
  if (isset($_POST['submit']))
  {
    mysqli_query($db,"UPDATE issue_book SET approve='$_POST[approve]',issuedate='$_POST[issuedate]', returndate='$_POST[returndate]' WHERE username='$_SESSION[username]' and name='$_SESSION[name]' ;");

    mysqli_query($db,"UPDATE books SET quantity = quantity-1 where name='$_SESSION[name]';");

    $res=mysqli_query($db, "SELECT quantity from books where name='$_SESSION[name]';" );

    while($row=mysqli_fetch_assoc($res))
    {
      if($row['quantity']==0)
      {
        mysqli_query($db, "UPDATE boos SET status='not available' where name='$_SESSION[name]';");
      }
    }
    ?>
      <script type="text/javascript">
        alert("Updated Successfully");
        window.location="request.php"
      </script>
    <?php
  }
?>
</body>
</html>