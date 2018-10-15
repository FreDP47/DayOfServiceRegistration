<?php 
if (isset($_POST['submitted']) && !empty($_POST['submitted'])) {
    $servername = "";
                                        $username = "";
                                        $password = "";
                                        $dbname = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $sendMailSql = "SELECT phone FROM users";

    $message = "";
    if (isset($_POST['emailBody']) && !empty($_POST['emailBody'])) {
        $message = mysqli_real_escape_string($conn, $_POST['emailBody']);
    }

    if (isset($_POST['cityDrpDwn']) && !empty($_POST['cityDrpDwn'])) {
        $sendMailSql .= " where city_id=" . $_POST['cityDrpDwn'];
    }

    if (isset($_POST['regDrpDwn']) && !empty($_POST['regDrpDwn'])) {
        $sendMailSql .= " and region_id=" . $_POST['regDrpDwn'];
    }

    $location = "";
    if (isset($_POST['locDrpDwn']) && !empty($_POST['locDrpDwn'])) {
        $sendMailSql .= " and location_id=" . $_POST['locDrpDwn'];
    }

    $result = $conn->query($sendMailSql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sid = "";
                $token = "";
            $twilio = new Client($sid, $token);

            $smsContent = $message;

            $Message = $twilio->messages
                ->create(
                    $row["phone"],
                    array(
                        "from" => "+18508096823",
                        "body" => $smsContent
                    )
                );
            //echo $row["phone"]. "\n";
        }
    } else {
        die(header("HTTP/1.0 404 Not Found"));
    }
}
?>