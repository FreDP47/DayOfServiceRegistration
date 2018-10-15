<?php 
require __DIR__ . '/PHPMailer_5.2.0/class.phpmailer.php';
if (isset($_POST['submitted']) && !empty($_POST['submitted'])) {
    $servername = "";
                                        $username = "";
                                        $password = "";
                                        $dbname = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $sendMailSql = "SELECT email FROM users";

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
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->Username = "";
                $mail->Password = "";
                $mail->Host = "smtp.gmail.com";
                $mail->Mailer = "smtp";
                $mail->SetFrom("", "");
                $mail->AddReplyTo("", "");
            $mail->AddAddress($row["email"]);
            $mail->Subject = "Confirmation mail for Day Of Service Registration";
            $mail->WordWrap = 80;
            $emailContent = $message;

            $mail->MsgHTML($emailContent);
            $mail->IsHTML(true);
            $mail->Send();
            //echo $row["email"]. "\n";
        }
    } else {
        die(header("HTTP/1.0 404 Not Found"));
    }
}
?>