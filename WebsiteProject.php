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

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <link rel="icon" type="image/icon" href="favicon.ico" sizes="32x32" /> -->
    <link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Outfit|Quicksand">
    <title>TravelMate</title>
</head>
<body>
    <video loop muted autoplay class="banner">
        <source src="images/bg/bg.mp4" type="video/mp4" />
    </video>
    <div class="home_container">
        <header>
            <article id="home-logo">
                <!-- logo -->
                <h1>TRAVELMATE</h1>
            </article>
            <nav>
                <a href="#" class="nav-menu home">Home</a>
                <a href="index2.html" class="nav-menu places_to_go">Places to go</a>
                <a href="things_to_do.html" class="nav-menu things_to_do">Things to do</a>
                <a href="blogs.php" class="nav-menu tips-article">Tips & Articles</a>
				<a href="About_us.html" class="nav-menu about-us">About Us</a>
                <?php

                if($login_button!='')
                {
                    echo '<h4>'.$login_button.'</h4>';
                    // echo $username;
                }
                else{

                    echo '<a href="logout.php" class="nav-menu"><h4>Logout</h4></a>';
                    // echo $_SESSION['user_first_name'];
                    // echo $_SESSION['user_last_name'];
                    // echo $_SESSION['user_email_address'];
                    $email = $_SESSION['user_email_address'];
                    // echo $email;
                    $username = $_SESSION['user_first_name']." ".$_SESSION['user_last_name'];
                    // echo $username;
                    $connection = mysqli_connect("localhost","root","") or die("Error At Your End");
                    $query = "CREATE DATABASE IF NOT EXISTS travelmatedb";
                    $result = mysqli_query($connection,$query) or die("Could not connect to database");
                    $db = mysqli_select_db($connection,"travelmatedb") or die("Connection Error");
                    $query = "CREATE TABLE IF NOT EXISTS users (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, username VARCHAR(30) NOT NULL, email VARCHAR(50),isBlogger VARCHAR(20))";
                    $result = mysqli_query($connection,$query) or die("Cannot Create Table, I Dont know why");
                    $query = "SELECT * FROM users WHERE email='$email'";
                    $exists = mysqli_query($connection, $query);
                    if($exists)
                    {
                    if(mysqli_num_rows($exists) ==  0)
                    {
                        $query = "INSERT INTO users (username,email,isBlogger) VALUES ('$username','$email','false')";
                        $result = mysqli_query($connection,$query) or die("Nhin ho rha Connect kya kr lega bta?");
                    }
                }
                    
                } 
                ?>
                <!-- <a href="signin.html" class="nav-menu">Login</a> -->
            </nav>
        </header>
        <br /><hr />
        <main>
            <div class="content">
                <article>
                    <h3>Explore our <br /> Incredible India!</h3>
                    <p>Destinations for your next vacation</p>
                    <br />
                    <footer>
                        <a href="#" class="btn">Start Exploring!</a>
                    </footer>
                </article>
            </div>
        </main>
    </div>

    <div class="heading">
        <h1>Featured Articles</h1>
    </div>
    <center>
        <div class="article_space">
            <ul class="article_list">
                <li class="article_box">
                    <article>
                        <a href="things_to_do.html">
                            <img src="images/misc/train.jpg" class="article_img">
                            <p class="article_desc">7 most scenic train journeys to experience in India</p>
                        </a>
                    </article>
                </li>
                <li class="article_box">
                    <article>
                        <a href="things_to_do.html">
                            <img src="images/misc/paragliding.jpg" class="article_img">
                            <p class="article_desc">Paragliding in Bir Billing: Live the fantasy of flying</p>
                        </a>
                    </article>
                </li>
                <li class="article_box">
                    <article>
                        <a href="things_to_do.html">
                            <img src="images/misc/biking.jpg" class="article_img">
                            <p class="article_desc">A bike trip from Leh to Ladakh is a must-try</p>
                        </a>
                    </article>
                </li>
				<li class="article_box">
                    <article>
                        <a href="things_to_do.html">
                            <img src="images/misc/desertsafari.jpg" class="article_img">
                            <p class="article_desc">Experience a Desert Safari in Rajasthan and drive through the sand dunes</p>
                        </a>
                    </article>
                </li>
            </ul>
        </div>
		<div class="article_space">
            <ul class="article_list">
                <li class="article_box">
                    <article>
                        <a href="things_to_do.html">
                            <img src="images/misc/mysore_palace.jpg" class="article_img">
                            <p class="article_desc">Visit the Mysore Palace: Modest by day, illuminated majestically at sunset</p>
                        </a>
                    </article>
                </li>
                <li class="article_box">
                    <article>
                        <a href="things_to_do.html">
                            <img src="images/misc/scubadiving.jpg" class="article_img">
                            <p class="article_desc">Dive deeper into the serenity while Scuba Diving in the Andamans</p>
                        </a>
                    </article>
                </li>
                <li class="article_box">
                    <article>
                        <a href="things_to_do.html">
                            <img src="images/misc/ellora_caves.jpg" class="article_img">
                            <p class="article_desc">Appreciate the Beauty of the Monolithic temples on your visit to Ellora Caves</p>
                        </a>
                    </article>
                </li>
				<li class="article_box">
                    <article>
                        <a href="things_to_do.html">
                            <img src="images/misc/boating.jpg" class="article_img">
                            <p class="article_desc">Enjoy the Shikara Ride in Kashmir's Dal Lake</p>
                        </a>
                    </article>
                </li>
            </ul>
        </div>
    </center>
	
	<div class="heading">
        <h1>Gems of India</h1>
    </div>
    <div class="slider">
        <div class="myslide fade">
            <div class="txt">
				<h1>SEVEN SISTERS</h1>
                <p>The Eastern States</p>
            </div>
            <img src="images/slideshow/sevenSisters.jpg" class="slideshow_img">
        </div>

        <div class="myslide fade">
            <div class="txt">
                <h1>GOA</h1>
                <p>The Party Capital</p>
            </div>
            <img src="images/slideshow/Goa.jpg" class="slideshow_img">
        </div>

        <div class="myslide fade">
            <div class="txt">
                <h1>SRINAGAR</h1>
                <p>Switzerland of India</p>
            </div>
            <img src="images/slideshow/Srinagar.jpg" class="slideshow_img">
        </div>

        <div class="myslide fade">
            <div class="txt">
                <h1>Assam</h1>
                <p>Land of One Horned Rhinos</p>
            </div>
            <img src="images/slideshow/assam.jpg" class="slideshow_img">
        </div>

        <div class="myslide fade">
            <div class="txt">
            <h1>UDAIPUR</h1>
            <p>City of Lakes</p>
            </div>
            <img src="images/slideshow/Udaipur.jpg" class="slideshow_img">   
        </div>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

        <div class="dotsbox" style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
            <span class="dot" onclick="currentSlide(5)"></span>
        </div>
    </div>
    <br /><br /><br /><br /><br /><br /><br /><br /><br />
    <div class="heading">
        <h1>Travel Stories</h1>
    </div>
    <p class="blog_head">Written Expriences of our fellow Travellers</p>
    <div class="blog_space">
        <center>
            <div class="article_space">
                <ul class="article_list">
                    <li class="blog_box">
                        <article>
                            <img src="images/blogs/goa.jpg" class="blog_img">
							<a href="blogs.php">	
								<div class="article_box_header_link">
									<p class="blog_desc ">Busy beach & recreation area with water sports, eateries & a festive atmosphere.</p>
								</div>
								<div class="article_box_meta">
									<p class="article_author">By Alok Solanky  </p>
									<p  class="article_date"> Nov 26, 2021 </p>		
								</div>
							</a>
                        </article>
                    </li>
                    <li class="blog_box">
                        <article>
                            <img src="images/blogs/lavasna.jpg" class="blog_img">
							<a href="blogs.php">	
								<div class="article_box_header_link">
									<p class="blog_desc ">Lavasa, Maharashtra:  India's newest hill station!</p>
								</div>
								<div class="article_box_meta">
									<p class="article_author">By Dev Bharadwaj  </p>
									<p  class="article_date"> Dec 19, 2021 </p>		
								</div>
							</a>
                        </article>
                    </li><li class="blog_box">
                        <article>
                            <img src="images/blogs/ooty.jpg" class="blog_img">
							<a href="blogs.php">	
								<div class="article_box_header_link">
									<p class="blog_desc ">Ooty: The Queen of the hills is a picturesque getaway</p>
								</div>
								<div class="article_box_meta">
									<p class="article_author">By Piyush Dwivedi  </p>
									<p  class="article_date"> Nov 26, 2021 </p>		
								</div>
							</a>
                        </article>
                    </li><li class="blog_box">
                        <article>
                            <img src="images/blogs/ponmudi.jpeg" class="blog_img">
							<a href="blogs.php">	
								<div class="article_box_header_link">
									<p class="blog_desc ">Ponmudi, Kerala: A Pleasant Surprise!</p>
								</div>
								<div class="article_box_meta">
									<p class="article_author">By Trilok Solanky  </p>
									<p  class="article_date"> Nov 29, 2021 </p>		
								</div>
							</a>
                        </article>
                    </li><li class="blog_box">
                        <article>
                            <img src="images/blogs/orchha.jpg" class="blog_img">
							<a href="blogs.php">	
								<div class="article_box_header_link">
									<p class="blog_desc ">Orchha, Madhya Pradesh: The City of Palaces</p>
								</div>
								<div class="article_box_meta">
									<p class="article_author">By Guy Pierce  </p>
									<p  class="article_date"> Jan 26, 2020 </p>		
								</div>
							</a>
                        </article>
                    </li>
                </ul>
            </div>
        </center>
    </div>

    <div class="newsletter_wrapper">
        <div class="newsletter_space">
            <div class="newsletter_heading">
                <h1>Subscribe to our Newsletter</h1>
            </div>
            <p class="newsletter_desc">
                Join our newsletter and discover new destinations to inspire your next journey.<br />
                Every month you'll receive expert advice, tips, the latest updates in travel news and much more.<br /> 
            </p>

            <div class="newsletter_email">
                <form method="POST" onsubmit="return sendmail(this)">
                    <input type="email" id="email" name="email" placeholder="Email address" required>
                    <input type="submit" name="newsletter" value="SIGN UP">
                </form>
                <p style="position: relative; left:-30px;">
                    <?php
                     if (isset($_POST['newsletter'])){
                         $link = "https://www.canva.com/design/DAExFWq6pbU/rubQP8l9o1dCGbwyCKHyTA/view?utm_content=DAExFWq6pbU&utm_campaign=designshare&utm_medium=link&utm_source=publishsharelink";
                         $mail = $_POST['email'];
                         $to = $mail;
                         $from = "From : pbadgly@gmail.com";
                         $body = "We are glad to have you on board. Thank you for subscribing to our Newsletter. Every month you will receive a well-curated newsletter, a compilation of the trending locations in the past month and blogs, and much much more. Stay tuned! & Download from here! $link";
                         $subject = "Travel Mate";

                         if(mail($to,$subject,$body,$from))
                         {
                            echo "Thank you for subscribing to our Newsletter";
                         }
                         else
                         {
                             echo "Something Went Wrong Try again letter";
                         }
                         
                    }
                    ?>
                </p>
            </div>
        </div>
        <div class="newsletter_img">
            <img src="images/newsletter/newsletter.png">
        </div>
    </div>

	<footer class="foot">
		<p class="footer_text" style="text-align: center;">Developed by Travel Enthusiast</p>
		<br><br>
		<a href="#" class="return">Return to top</a>
	</footer>
		
	<script src="javascript/slideshow.js"></script>
    <script
  src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://smtpjs.com/v3/smtp.js"></script>
    <script>
       function sendmail(form)
       {
           console.log("inside the send mail function");
           var fail = validate(form.email.value);
           if(fail == "")
           {
               console.log("all requirement fullfilled");
               return true;
           }
           else
           {
               alert(fail);
               return false
           }
       }
       function validate(field)
       {    console.log("inside the Vaildation part")
             var re=/[\a-zA-Z0-9]+[@]+[\a-zA-Z0-9]+[\.][\a-z]+/; 
             if(field == "")
             {
                 console.log("Empty Field");
                 return "Enter your email\n";
             }  
             else if(re.test(field)&& field == field.toLowerCase())
             {
                 alert("Check your mailbox");
                 return "";
             }
             else
             {
                 return "Enter your mail in correct format (Ex : pbadgly@gmail.com)\n";
             }
       }
    </script>
</body>
</html>
