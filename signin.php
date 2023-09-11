<?php

$username = $_POST['username'];
$email =  $_POST['email'];
$startdate = $_POST['startdate'];
$comment = $_POST['comment'];

if(!empty($username) || !empty($email) || !empty($startdate) || !empty($comment))
{
    //Essential Variables

    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "webProject";

    //Connection Creation
    $conn = new mysqli($host,$dbUsername, $dbPassword, $dbname);

    if(mysqli_connect_error())
    {
        die('Connection Error('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else
    {
        $SELECT = "SELECT email from register Where email = ? Limit 1"; // register is the name of the table inside the webProject database
        $INSERT = "INSERT Into register (username,email,startdate,comment) values(?,?,?,?)";

        //Preparing Statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum == 0)
        {
            $stmt->close();

            $stmt =  $conn->prepare($INSERT);
            $stmt->bind_param("ssss", $username,$email,$startdate,$comment);
            $stmt->execute();

            echo "Dear $username We Will Be Reaching you Soon !";
        }
        else
        {
            echo "User Already Found With this Email";
        }
        $stmt->close();
        $conn->close();
    }
}
else
{
    echo "Professor Already knew that";
    die();
}

?>