<?php

include("include.php");
global $display_block;
if(($_POST) && $_POST["action"] == "sub")
{  // trying to Subscribe. First Validate the Address
    if ($_POST["email"] == "") {
        header("Location:manage.php");
        exit;
    }
    else
    {
        doDB();
        // Check that email in the Mailing list
        emailChecker($_POST["email"]);

        // get the number of results and do action

        if (mysqli_num_rows($check_res) < 1) {
            mysqli_free_result($check_res);

            // add a record

            $add_sql = "insert into subscribers (email) values('".$_POST["email"]."');";
            $add_res = mysqli_query($mysqli, $add_sql) or die(mysqli_error($mysqli));

            $display_block = "<p> Thanks for Signing Up </p>";
            mysqli_close($mysqli);
        } else {

            // Print Failure Message
            $display_block = "<p>You are already subscribed.</p>";
        }


    }
}
elseif (($_POST) && $_POST["action"] == "unsub") {
// trying to Unsubscribe. First Validate the Address
    if ($_POST["email"] == "") {
        header("Location:manage.php");
        exit;
    } else {
        doDB();
        // Check that email in the Mailing list
        emailChecker($_POST["email"]);

        // get the number of results and do action

        if (mysqli_num_rows($check_res) < 1) {
            mysqli_free_result($check_res);

            // print failure message

            $display_block = "<p> Could not find your email Address! </p><p>No Action was taken. </p>";

        } else {
            // get values of ID from result

            while ($row = mysqli_fetch_array($check_res)) {
                $id = $row["id"];
            }

            // unsubscribe the Address

            $del_sql = "delete from subscribers where id = '" . $id . "'";
            $del_res = mysqli_query($mysqli, $del_sql) or die(mysqli_error($mysqli));

            $display_block = "<p>You are Unsubscribed.</p>";
        }
        mysqli_close($mysqli);

    }

}

?>

<html>
<head>
    <title>
        Subscribe/Unsubscribe to the Mailing List
    </title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>
<h2>
    Subscribe/Unsubscribe to the Mailing List
</h2>

<form method="post" action="manage.php" role="form">
    <div class="form-group">
        <p>
            <div class="col-lg-4">
            <input type="text" name="email" class="form-control" placeholder="Enter email">
            </div>
        </p>
        <br>
        <p>
            <div class="col-lg-4">
            <input type="radio" name="action" value="sub" checked> Subscribe
            <input type="radio" name="action" value="unsub"> Unsubscribe
            </div>
        </p>
        <div class="col-lg-4">
        <input type="submit" name="submit" value="Submit Form" class="btn btn-success">
        </div>
    </div>
</form>
<div>
    <label for="inputlg"><?php echo "$display_block" ?></label>

</div>
</body>
</html>