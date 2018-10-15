<?php
header('Access-Control-Allow-Origin: *'); 
require __DIR__ . '/phpMailerAPI/twilio-php-master/twilio-php-master/Twilio/autoload.php';
use Twilio\Rest\Client;
require __DIR__ . '/PHPMailer_5.2.0/class.phpmailer.php';

if (isset($_POST['submitted']) && !empty($_POST['submitted'])) {
    $servername = "";
                                        $username = "";
                                        $password = "";
                                        $dbname = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = $_POST['phone'];
    $usertype = $_POST['groupUserRadio'];

    $groupNo = "";
    if (isset($_POST['groupNo']) && !empty($_POST['groupNo'])) {
        $groupNo = $_POST['groupNo'];
    }

    $cityDrpDwn = $_POST['cityDrpDwn'];

    $regDrpDwn = "";
    if (isset($_POST['regDrpDwn']) && !empty($_POST['regDrpDwn'])) {
        $regDrpDwn = $_POST['regDrpDwn'];
    }

    $regDrpDwn = !empty($regDrpDwn) ? "'$regDrpDwn'" : "NULL";

    $regionName = "";
    if (isset($_POST['regionName']) && !empty($_POST['regionName'])) {
        $regionName = $_POST['regionName'];
    }

    $cityName = "";
    if (isset($_POST['cityName']) && !empty($_POST['cityName'])) {
        $cityName = $_POST['cityName'];
    }

    $volBakulOptionRadio = $_POST['volBakulOptionRadio'] == 'y' ? '1' : '0';
    $volDosOptionRadio = $_POST['volDosOptionRadio'] == 'y' ? '1' : '0';

    $feedback = "";
    if (isset($_POST['feedback']) && !empty($_POST['feedback'])) {
        $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
    }

    $feedback = !empty($feedback) ? "'$feedback'" : "NULL";

    $ideas = "";
    if (isset($_POST['ideas']) && !empty($_POST['ideas'])) {
        $ideas = mysqli_real_escape_string($conn, $_POST['ideas']);
    }

    $ideas = !empty($ideas) ? "'$ideas'" : "NULL";

    $gen = "";
    if (isset($_POST['gen']) && !empty($_POST['gen'])) {
        $gen = mysqli_real_escape_string($conn, $_POST['gen']);
    }

    $gen = !empty($gen) ? "'$gen'" : "NULL";

    $institution = mysqli_real_escape_string($conn, $_POST['institution']);
    $age = $_POST['age'];
    $localLangDrpDwn = $_POST['localLangDrpDwn'];

    if($cityDrpDwn == 12 && $regDrpDwn == "NULL"){
        die(header("HTTP/1.0 404 Not Found"));
    } else {
        if ($usertype == 's') { //save single user

            //singleUserSkills
            $singleUserPhotography = "";
            if (isset($_POST['singleUserPhotography']) && !empty($_POST['singleUserPhotography'])) {
                $singleUserPhotography = $_POST['singleUserPhotography'];
            }
    
            $singleUserPhotography = !empty($singleUserPhotography) ? "'$singleUserPhotography'" : "NULL";
    
            $singleUserFilmMaking = "";
            if (isset($_POST['singleUserFilmMaking']) && !empty($_POST['singleUserFilmMaking'])) {
                $singleUserFilmMaking = $_POST['singleUserFilmMaking'];
            }
    
            $singleUserFilmMaking = !empty($singleUserFilmMaking) ? "'$singleUserFilmMaking'" : "NULL";
    
            $singleUserStorytelling = "";
            if (isset($_POST['singleUserStorytelling']) && !empty($_POST['singleUserStorytelling'])) {
                $singleUserStorytelling = $_POST['singleUserStorytelling'];
            }
    
            $singleUserStorytelling = !empty($singleUserStorytelling) ? "'$singleUserStorytelling'" : "NULL";
    
            $singleUserCraft = "";
            if (isset($_POST['singleUserCraft']) && !empty($_POST['singleUserCraft'])) {
                $singleUserCraft = $_POST['singleUserCraft'];
            }
    
            $singleUserCraft = !empty($singleUserCraft) ? "'$singleUserCraft'" : "NULL";
    
            $singleUserQueueSql = "INSERT INTO queue
                (name,email,vol_bakul,vol_dos,feedback,ideas,timeStamp,region_id,city_id,phone,
                institution,age,local_language_comfort,photography,film_making,storytelling,craft,general_queries)
                VALUES
                (
                    '$name','$email','$volBakulOptionRadio','$volDosOptionRadio',$feedback,
                    $ideas,now(),$regDrpDwn,'$cityDrpDwn','$phone','$institution','$age','$localLangDrpDwn',
                    $singleUserPhotography,$singleUserFilmMaking,$singleUserStorytelling,$singleUserCraft,$gen
                )";
    
            if (mysqli_query($conn, $singleUserQueueSql)) {
                            
                    //storing data
                $receiverEmailAddress = $email;
                $receiverTextMsgNo = '+91' . $phone;
        
                    //email part
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
                $mail->AddAddress($receiverEmailAddress);
                $mail->Subject = "n";
                $mail->WordWrap = 80;
                
                $emailContent = 'Hi,<br /><br />Greetings from Bakul Foundation. 
                    Thank you for registering for the <strong>Day of Service</strong> as part of Daan Utsav 
                    (Joy of Giving Week) on 2nd October. We are sorry that you could not be accommodated 
                    in your chosen region. Hence, we have put you in the queue and 
                    we are in the process of creating other opportunities for you in your chosen region. 
                    Once, you are mapped, you will get a confirmation email and message.
                    <br /><br />Please email us at contactbakul@gmail.com if you would like to deregister 
                    or change your registration details or if you have any queries.<br /><br />
                    You can see pictures of earlier Day of Service celebrations <a href="https://goo.gl/photos/47eTJdC7AiXBtwQ4A">here</a>. 
                    You can know more about Bakul Foundation by watching a film on Bakul 
                    <a href="https://youtu.be/YiiaarY26zY">here</a> or a <strong>TEDx Talk</strong> 
                    on the idea of Bakul <a href="https://youtu.be/dvdclvxzE6o">here</a>. 
                    You can also check out http://www.bakul.org for more details and 
                    join Bakul Foundation on social media for regular updates - 
                    <a href="https://www.facebook.com/BakulFoundation/?ref=br_rs">Facebook Page</a>, 
                    <a href="https://www.facebook.com/groups/bakulfoundation/?ref=br_rs">Facebook Group</a>,
                    <a href="https://www.instagram.com/bakul_foundation/">Instagram</a>, 
                    <a href="https://twitter.com/BakulFoundation">Twitter</a>.<br /><br />
                    Please ask your friends and contacts to join you in celebrating the Day of Service. 
                    <strong> Note that they can participate from any city they are in</strong>. 
                    Please share the registration link (http://registerfordos.bakul.org) with them.';
    
                $mail->MsgHTML($emailContent);
                $mail->IsHTML(true);
                $mail->Send();
        
                    //message part
                $sid = "";
                $token = "";
                $twilio = new Client($sid, $token);
    
                $Message = $twilio->messages
                    ->create(
                        $receiverTextMsgNo,
                        array(
                            "from" => "+18508096823",
                            "body" => 'Greetings from Bakul Foundation. Thank you for registering for the Day of Service as part of Daan Utsav (Joy of Giving Week) on 2nd October. We are sorry that you could not be accommodated in your chosen region. We are in the process of mapping you in your choice of region and have put you in queue. You have been sent a more detailed email on ' . $receiverEmailAddress
                        )
                    );
            } else {
                die(header("HTTP/1.0 404 Not Found"));
            }
        } else { //save group user
    
            //groupUserSkills
            $groupUserPhotography = "";
            if (isset($_POST['groupUserPhotography']) && !empty($_POST['groupUserPhotography'])) {
                $groupUserPhotography = $_POST['groupUserPhotography'];
            }
    
            $groupUserPhotography = !empty($groupUserPhotography) ? "'$groupUserPhotography'" : "NULL";
    
            $groupUserFilmMaking = "";
            if (isset($_POST['groupUserFilmMaking']) && !empty($_POST['groupUserFilmMaking'])) {
                $groupUserFilmMaking = $_POST['groupUserFilmMaking'];
            }
    
            $groupUserFilmMaking = !empty($groupUserFilmMaking) ? "'$groupUserFilmMaking'" : "NULL";
    
            $groupUserStorytelling = "";
            if (isset($_POST['groupUserStorytelling']) && !empty($_POST['groupUserStorytelling'])) {
                $groupUserStorytelling = $_POST['groupUserStorytelling'];
            }
    
            $groupUserStorytelling = !empty($groupUserStorytelling) ? "'$groupUserStorytelling'" : "NULL";
    
            $groupUserCraft = "";
            if (isset($_POST['groupUserCraft']) && !empty($_POST['groupUserCraft'])) {
                $groupUserCraft = $_POST['groupUserCraft'];
            }
    
            $groupUserCraft = !empty($groupUserCraft) ? "'$groupUserCraft'" : "NULL";
    
            $groupId = "";
            $isRowThere = false;
            $lastQueueIdSql = mysqli_query($conn, "SELECT queue_id FROM queue ORDER BY queue_id DESC LIMIT 1");
            while ($row = $lastQueueIdSql->fetch_assoc()) {
                $newId = (int)$row['queue_id'] + 1;
                $groupId = "GQ" . $newId;
                $isRowThere = true;
            }
            
            if(!$isRowThere){
                $groupId = "GQ1";
            }
    
            $mailMsgArray = array($email => $phone);
    
            $groupUserAddSql = "INSERT INTO queue
                (name,email,vol_bakul,vol_dos,feedback,ideas,timeStamp,region_id,city_id,phone,
                institution,age,local_language_comfort,group_id,group_leader,photography,
                film_making,storytelling,craft,general_queries)
                VALUES
                (
                    '$name','$email','$volBakulOptionRadio','$volDosOptionRadio',$feedback,
                    $ideas,now(),$regDrpDwn,'$cityDrpDwn','$phone','$institution','$age','$localLangDrpDwn',
                    '$groupId','1',$groupUserPhotography,$groupUserFilmMaking,$groupUserStorytelling,
                    $groupUserCraft,$gen
                );";
    
            for ($index = 0; $index < (int)$groupNo-1; $index++) {
                $nameId = "groupUserName" . $index;
                $emailId = "groupEmailId" . $index;
                $phoneId = "groupUserPhone" . $index;
                $institutionId = "groupUserInstitution" . $index;
                $ageId = "groupUserAge" . $index;
                $localLangComfortId = "groupUserlocalLangComfort" . $index;
    
                $groupUserName = mysqli_real_escape_string($conn, $_POST[$nameId]);
                $groupUserEmail = mysqli_real_escape_string($conn, $_POST[$emailId]);
                $groupUserPhone = $_POST[$phoneId];
                $groupUserInstitutionId = mysqli_real_escape_string($conn, $_POST[$institutionId]);
                $groupUserAgeId = $_POST[$ageId];
                $groupUserlocalLangComfortId = $_POST[$localLangComfortId];
    
                $mailMsgArray[$groupUserEmail] = $groupUserPhone;
    
                $groupUserAddSql .= "INSERT INTO queue
                    (name,email,timeStamp,region_id,city_id,phone,institution,age,local_language_comfort)
                    VALUES
                    (
                        '$groupUserName','$groupUserEmail',now(),$regDrpDwn,'$cityDrpDwn',
                        '$groupUserPhone','$groupUserInstitutionId','$groupUserAgeId','$groupUserlocalLangComfortId'
                    );";
            }
    
            mysqli_autocommit($conn, false);
            $valid_entry = 1;

            if (mysqli_multi_query($conn, $groupUserAddSql)) {
                while(mysqli_next_result($conn)){
                }
            } else {
                $valid_entry = 0;
            }

            if(mysqli_errno($conn)){
                $valid_entry = 0;
            }

            if($valid_entry){
                mysqli_commit($conn);
                foreach ($mailMsgArray as $key => $value) {
        
                        //storing data
                    $receiverEmailAddress = $key;
                    $receiverTextMsgNo = '+91' . $value;
        
                        //email part
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
                    $mail->AddAddress($receiverEmailAddress);
                    $mail->Subject = "Confirmation mail for Day Of Service Registration";
                    $mail->WordWrap = 80;
                    
                    $emailContent = 'Hi,<br /><br />Greetings from Bakul Foundation. 
                    Thank you for registering for the <strong>Day of Service</strong> as part of Daan Utsav 
                    (Joy of Giving Week) on 2nd October. We are sorry that the entire group could not be accommodated 
                    in your chosen region. Hence, we have put you in the queue and 
                    we are in the process of creating other opportunities for you in your chosen region. 
                    Once, you are mapped, you will get a confirmation email and message.
                    <br /><br />Please email us at contactbakul@gmail.com if you would like to deregister 
                    or change your registration details or if you have any queries.<br /><br />
                    You can see pictures of earlier Day of Service celebrations <a href="https://goo.gl/photos/47eTJdC7AiXBtwQ4A">here</a>. 
                    You can know more about Bakul Foundation by watching a film on Bakul 
                    <a href="https://youtu.be/YiiaarY26zY">here</a> or a <strong>TEDx Talk</strong> 
                    on the idea of Bakul <a href="https://youtu.be/dvdclvxzE6o">here</a>. 
                    You can also check out http://www.bakul.org for more details and 
                    join Bakul Foundation on social media for regular updates - 
                    <a href="https://www.facebook.com/BakulFoundation/?ref=br_rs">Facebook Page</a>, 
                    <a href="https://www.facebook.com/groups/bakulfoundation/?ref=br_rs">Facebook Group</a>,
                    <a href="https://www.instagram.com/bakul_foundation/">Instagram</a>, 
                    <a href="https://twitter.com/BakulFoundation">Twitter</a>.<br /><br />
                    Please ask your friends and contacts to join you in celebrating the Day of Service. 
                    <strong> Note that they can participate from any city they are in</strong>. 
                    Please share the registration link (http://registerfordos.bakul.org) with them.';
    
                    $mail->MsgHTML($emailContent);
                    $mail->IsHTML(true);
                    $mail->Send();
        
                        //message part
                        $sid = "";
                        $token = "";
                    $twilio = new Client($sid, $token);
    
                    $Message = $twilio->messages
                        ->create(
                            $receiverTextMsgNo,
                            array(
                                "from" => "+18508096823",
                                "body" => 'Greetings from Bakul Foundation. Thank you for registering for the Day of Service as part of Daan Utsav (Joy of Giving Week) on 2nd October. We are sorry that the entire group could not be accommodated in your chosen region. We are in the process of mapping you in your choice of region and have put you in queue. You have been sent a more detailed email on ' . $receiverEmailAddress
                            )
                        );
                }
            } else {
                mysqli_rollback($conn);
                die(header("HTTP/1.0 404 Not Found"));
            }
        }
    }

    mysqli_close($conn);
}
?>