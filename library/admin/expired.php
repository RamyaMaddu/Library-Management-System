<?php
  include "connection.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Book Request</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		.search
		{
			padding-left: 800px;
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
  height: 800px;
  background-color: black;
  opacity: .8;
  color: white;
  margin-top: -60px;
}
.Approve
{
  margin-left: 420px;
}
.scroll
{
  width: 100%;
  height: 500px;
  overflow: auto;
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
  padding-left:10px;
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
  <?php
    if(isset($_SESSION['login_user']))
    {
      ?>
        <div style="float: left; padding: 25px;">
          <form method="post" action="">
        <button name="submit2" type="submit" class="btn btn-default" style="background-color: green ; color: yellow;">RETURNED</button> &nbsp&nbsp
        <button name="submit3" type="submit" class="btn btn-default" style="background-color: red ; color: yellow;">EXPIRED</button></form>
        </div>
        <div class="search">
        <form method="post" action="" name="form1">
          <input type="text" name="username" class="form-control" placeholder="Username" required=""><br>
          <input type="text" name="name" class="form-control" placeholder="Book Name" required=""><br>
          <button class="btn btn-default" name="submit" type="submit">Submit</button>
          
        </form>
  
        </div>
    <?php
    if(isset($_POST['submit']))
    {
      $res=mysqli_query($db,"SELECT * FROM `issue_book` WHERE username='$_POST[username]' and name='$_POST[name]'; ");
      while($row=mysqli_fetch_assoc($res))
      {
        $d=strtotime($row['returndate']);
      $c=strtotime(date("Y-m-d"));
      $diff=$c-$d;
      
      if($diff>=0)
      {
        $day=floor($diff/(60*60*24));
        $fine=$day*2;
      }
      }
      $x=date("Y-m-d");
      

      mysqli_query($db,"INSERT INTO `fine` VALUES ('$_POST[username]', '$_POST[name]', '$x','$day','$fine','not paid');");
      $var1='<p style="color:yellow;background-color:green;">RETURNED</p>';
      mysqli_query($db,"UPDATE issue_book SET approve='$var1' where username='$_POST[username]' and name='$_POST[name]'" );
      mysqli_query($db,"UPDATE books SET quantity=quantity+1 where name='$_POST[name]' ");
    }
    }
  ?>
 <br>
  <?php
  $c=0;
      if(isset($_SESSION['login_user']))
      {
         $ret='<p style="color:yellow;background-color:green;">RETURNED</p>';
         $exp='<p style="color:yellow;background-color:red;">EXPIRED</p>';
        
        if(isset($_POST['submit2']))
        {
           $sql="SELECT student.username,roll,books.name,authors,edition,approve,issuedate,returndate FROM student inner join issue_book ON student.username=issue_book.username inner join books ON issue_book.name=books.name WHERE issue_book.approve ='$ret'  ORDER BY returndate DESC";
           $res=mysqli_query($db,$sql);
        }
        else if(isset($_POST['submit3']))
        {
           $sql="SELECT student.username,roll,books.name,authors,edition,approve,issuedate,returndate FROM student inner join issue_book ON student.username=issue_book.username inner join books ON issue_book.name=books.name WHERE issue_book.approve ='$exp'  ORDER BY returndate DESC";
           $res=mysqli_query($db,$sql);
        }
        else
        {
           $sql="SELECT student.username,roll,books.name,authors,edition,approve,issuedate,returndate FROM student inner join issue_book ON student.username=issue_book.username inner join books ON issue_book.name=books.name WHERE issue_book.approve !='' and issue_book.approve!='Yes' ORDER BY returndate DESC";
           $res=mysqli_query($db,$sql);
        }
        
        echo "<div class='scroll'>";
        echo "<table class='table table-bordered table-hover'>";
        echo "<tr style='background-color:#6db6b9e6;'>";
    //Table Header
     
      echo"<th>"; echo "Student Username"; echo "</th>";
      echo"<th>"; echo "Roll No"; echo "</th>";
      echo"<th>"; echo "Book Name"; echo "</th>";
      echo"<th>"; echo "Author Name"; echo "</th>";
      echo"<th>"; echo "Edition"; echo "</th>";
      echo"<th>"; echo "Status"; echo "</th>";
      echo"<th>"; echo "Issue Date"; echo "</th>";
      echo"<th>"; echo "Return Date"; echo "</th>";
    
  echo "</tr>";
  while($row=mysqli_fetch_assoc($res))
  {
    
     
      
    
    echo "<tr>";
    
    echo "<td>"; echo $row['username']; echo "</td>";
    echo "<td>"; echo $row['roll']; echo "</td>";
    echo "<td>"; echo $row['name']; echo "</td>";
    echo "<td>"; echo $row['authors']; echo "</td>";
    echo "<td>"; echo $row['edition']; echo "</td>";
    echo "<td>"; echo $row['approve']; echo "</td>";
    echo "<td>"; echo $row['issuedate']; echo "</td>";
    echo "<td>"; echo $row['returndate']; echo "</td>";
    
    
    echo "</tr>";
  }
 
  echo "</table>";
  echo "</div>";
      }
      else
      {
        ?>
          <h2 style="text-align: center;">Login to see the Information Of Borrowed Books</h2>
        <?php
      }
    
  ?>
</div>
</div>
</body>
</html>