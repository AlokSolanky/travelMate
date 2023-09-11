<?php

include('config.php');

$login_button = '';


if(isset($_GET["code"]))
{

 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);


 if(!isset($token['error']))
 {
 
  $google_client->setAccessToken($token['access_token']);

 
  $_SESSION['access_token'] = $token['access_token'];


  $google_service = new Google_Service_Oauth2($google_client);

 
  $data = $google_service->userinfo->get();

 
  if(!empty($data['given_name']))
  {
   $_SESSION['user_first_name'] = $data['given_name'];
  }

  if(!empty($data['family_name']))
  {
   $_SESSION['user_last_name'] = $data['family_name'];
  }

  if(!empty($data['email']))
  {
   $_SESSION['user_email_address'] = $data['email'];
  
  }

  if(!empty($data['gender']))
  {
   $_SESSION['user_gender'] = $data['gender'];
  }

  if(!empty($data['picture']))
  {
   $_SESSION['user_image'] = $data['picture'];
  }
 }
}


if(!isset($_SESSION['access_token']))
{

 $login_button = '<a class="nav-menu" href="'.$google_client->createAuthUrl().'">Login</a>';
}


$connection = mysqli_connect("localhost", "root", "", "travelmatedb") or die("Cannot connect to the database");
$query = "SELECT * FROM travelmatetb";
$result = mysqli_query($connection, $query) or die("Query Failed");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/blog.css" />
    <script src="javascript/blogs.js"></script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Outfit|Quicksand">
    <title>Tips and Articles</title>
</head>
<body>
    <source src="images/bg/bg.jpg"/>
	<div class="home_container">
        <header>
            <article id="home-logo">
                <!-- logo -->
                <h1>TRAVELMATE</h1>
            </article>
            <nav>
               <a href="WebsiteProject.php" class="nav-menu home">Home</a>
                <a href="index2.html" class="nav-menu places_to_go">Places to go</a>
                <a href="things_to_do.html" class="nav-menu things_to_do">Things to do</a>
                <a href="blogs.php" class="nav-menu tips-article">Tips & Articles</a>
				<a href="About_us.html" class="nav-menu about-us">About Us</a>
                <!-- <a href="signin.html" class="nav-menu">Login</a> -->
            
                <?php

                if($login_button!='')
                {
                    echo '<h4>'.$login_button.'</h4>';
                    // echo $username;
                }
                else{
                    echo '<a href="logout.php" class="nav-menu"><h4>Logout</h4></a>';  
                } 
                ?>
            </nav>
        </header>
				<br /><hr />
				<div class="heading">
					<h1 style="text-align: center;margin-bottom:30px;">Tips and Articles</h1>
				</div>
                <div class="search-box">
                    <form method="POST" name="search" class="search-form">
                        <input type="text" name="content" id="search-box" placeholder="Search" required>
                        <input type="submit" value="Search" name="search" id="search-button">
                    </form>
                </div>
        <main>
            <div class="blog-container">
               <?php
               if(isset($_POST['search'])){
                    $search = $_POST["content"];
                    $query = "SELECT * FROM travelmatetb where Location='$search'";
                    $result = mysqli_query($connection, $query) or die("Query Failed");
                    if(mysqli_num_rows($result)>0)
                    {
                    while($row = mysqli_fetch_assoc($result))
                    {  
                    ?>
                       <article class='blog-cursor' onclick="openBlog(<?=$row['ID']?>)">
                       <?php
                        echo "<div id='blog-card'>";
                            echo "<h1>",$row['Location'],"</h1>";
                            echo "<div>";
                            ?>
                                <img id= "blog-image" src= "<?= $row['Image'] ?>" alt="test">
                            <?php
                            echo "</div>";
                            echo "<div id='blog-content'>";
                            echo $row['Blog'];
                            echo "</div>";
                        echo "</div>";
                        echo "<hr>";
                        echo "</article>";
                   }
               }
            }
                if(mysqli_num_rows($result)>0)
               {
                   while($row = mysqli_fetch_assoc($result))
                   {  
                       ?>
                       <article class='blog-cursor' onclick="openBlog(<?=$row['ID']?>)">
                       <?php
                        echo "<div id='blog-card'>";
                            echo "<h1>",$row['Location'],"</h1>";
                            echo "<div>";
                            ?>
                                <img id= "blog-image" src= "<?= $row['Image'] ?>" alt="test">
                            <?php
                            echo "</div>";
                            echo "<div id='blog-content'>";
                            echo $row['Blog'];
                            echo "</div>";
                        echo "</div>";
                        echo "<hr>";
                        echo "</article>";
                   }
               }
               ?>
            </div>
            <div class="blogs-enter">
                <form name="enter" method="post">
                    <table>
                        <tr>
                            <td>
                                <input type="text" name="location" placeholder="Location" required style="width: 250px;">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="blog" id="form-blog" placeholder="Write your Blog" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="file" name="image" placeholder="Upload photo here">
                            </td>
                        </tr>
                        <tr>                           
                             <td style="text-align: center;"><input type="submit" name="submit" value="submit"></td>
                        </tr>
                    </table>
                </form>
                <p>
                <?php
                if($login_button == '')
                {
                    if (isset($_POST['submit'])){
                    echo "Thank You, We Will be reaching you soon";
                    }
                    
                }
                    else
                    {
                        echo "Please Sign in first";
                    }
                ?>
                </p>
            </div>
        </main>
    </div>
</body>

</html>