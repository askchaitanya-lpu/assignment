<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>Movie Ratings</title>

    <style media="screen">
    .container
    {
      max-width:400px;
      width:100%;
      margin:0 auto;
      position:relative;
      border:1px solid black;
      border-radius: 5px;
      background-color: #f2f2f2;
      padding: 20px;
    }

    .output_container
    {
      max-width:400px;
      width:100%;
      margin:0 auto;
      position:relative;
      border:1px solid black;
      border-radius: 5px;
      background-color: pink;
      padding: 20px;
    }

    input[type=text]
    {
      width: 75%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      resize: vertical;
    }


    button[type=submit], button[type=fetch]
    {
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    h3
    {
      color: #F96;
      display: block;
      font-size: 30px;
      font-weight: 400;
    }

    h4
    {
      margin:5px 0 15px;
      display:block;
      font-size:13px;
    }

    </style>
  </head>

  <body>

    <div class="container">

      <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <h3>Movies Rating Form</h3>
        <h4>Please rate the following movies</h4>

        <tr>
          <td><br><label for="">Movie1 :</label></td>
          <td>
            <input type="text" name="m1" value="<?php echo isset($_POST['m1']) ? $_POST['m1'] : '' ?>" placeholder="Rating from 1 to 5">
          </td>
        </tr>

        <tr>
          <td><br><br><label for="">Movie2 :</label></td>
          <td>
            <input type="text" name="m2" value="<?php echo isset($_POST['m2']) ? $_POST['m2'] : '' ?>" placeholder="Rating from 1 to 5">
          </td>
        </tr>

        <tr>
          <td><br><br><label for="">Movie3 :</label></td>
          <td>
            <input type="text" name="m3" value="<?php echo isset($_POST['m3']) ? $_POST['m3'] : '' ?>" placeholder="Rating from 1 to 5">
          </td>
        </tr>

        <tr>
          <td><br><br><label for="">Movie4 :</label></td>
          <td>
            <input type="text" name="m4" value="<?php echo isset($_POST['m4']) ? $_POST['m4'] : '' ?>" placeholder="Rating from 1 to 5">
          </td>
        </tr>

        <tr>
          <td><br><br><label for="">Movie5 :</label></td>
          <td>
            <input type="text" name="m5" value="<?php echo isset($_POST['m5']) ? $_POST['m5'] : '' ?>" placeholder="Rating from 1 to 5">
          </td>
        </tr>

        <tr>
          <td colspan="2">
            <br><br>
            <center>
              <button type="fetch" name="fetch">Fetch</button>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
              <button type="submit" name="submit">Submit</button>
            </center>
          </td>
        </tr>

      </form>
    </div>
    <div class="output_container">
      <p>
        Output here :
        <?php

        $link = mysqli_connect("localhost", "admin", "adminspassword", "movies");

        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        if (isset($_POST['submit']))
        {
          $m1 = $m2 = $m3 = $m4 = $m5 = "";

          $m1 = $_POST["m1"];
          $m2 = $_POST["m2"];
          $m3 = $_POST["m3"];
          $m4 = $_POST["m4"];
          $m5 = $_POST["m5"];

          $error = "";

          if(empty($m1) || empty($m2) || empty($m3) || empty($m4) || empty($m5))
          {
            $error = "All fields are required";
          }
          else if(is_numeric($m1) != 1 || is_numeric($m2) != 1 || is_numeric($m3) != 1 || is_numeric($m4) != 1 || is_numeric($m5) != 1)
          {
            $error = "Rating value should be an integer only";
          }
          else if($m1 < 1 || $m1 > 5 || $m2 < 1 || $m2 > 5 || $m3 < 1 || $m3 > 5 || $m4 < 1 || $m4 > 5 ||$m5 < 1 || $m5 > 5)
          {
            $error = "Rating value should be between 1 and 5 only";
          }


          if($error == "")
          {

            $sql = "INSERT INTO reviewtable (m1,m2,m3,m4,m5) VALUES ($m1,$m2,$m3,$m4,$m5)";

            if(mysqli_query($link, $sql))
            {
                echo "Thank You. Your ratings are recorded successfully.";
            }
            else
            {
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            }

          }
          else
          {
            echo $error;
          }

        }

        if(isset($_POST['fetch']))
        {
          $result= mysqli_query($link,"SELECT SUM(m1)/COUNT(m1) AS rating FROM reviewtable");

          $row = mysqli_fetch_assoc($result);

          $avg = $row['rating'];

          echo nl2br("\n\n\n Average Rating of Movie1 is : {$avg} \n\n\n");


          $result= mysqli_query($link,"SELECT SUM(m2)/COUNT(m2) AS rating FROM reviewtable");

          $row = mysqli_fetch_assoc($result);

          $avg = $row['rating'];

          echo nl2br("Average Rating of Movie2 is : {$avg} \n\n\n");

          $result= mysqli_query($link,"SELECT SUM(m3)/COUNT(m3) AS rating FROM reviewtable");

          $row = mysqli_fetch_assoc($result);

          $avg = $row['rating'];

          echo nl2br("Average Rating of Movie3 is : {$avg} \n\n\n");

          $result= mysqli_query($link,"SELECT SUM(m4)/COUNT(m4) AS rating FROM reviewtable");

          $row = mysqli_fetch_assoc($result);

          $avg = $row['rating'];

          echo nl2br("Average Rating of Movie4 is : {$avg} \n\n\n");

          $result= mysqli_query($link,"SELECT SUM(m5)/COUNT(m5) AS rating FROM reviewtable");

          $row = mysqli_fetch_assoc($result);

          $avg = $row['rating'];

          echo ("Average Rating of Movie5 is : {$avg}");

        }


        // Close connection
        mysqli_close($link);
        ?>

      </p>
    </div>
  </body>
</html>
