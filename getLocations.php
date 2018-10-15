<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_POST) {
    $region = $_POST['region'];
    $groupNo = (int)$_POST['groupNo'];
    if ($region != '') {
        $html = '';
        $noOfLoc = 0;
        $html .= '<label for="locDrpDwn">In which time slot in the region selected above would you like to volunteer?* :</label>';
        $html .= '<select name="locDrpDwn" id="locDrpDwn" class="form-control" required>';
        $html .= '<option value="">---Select---</option>';
        $locSql = mysqli_query($conn, "select * from location where region_id=" . $region);
        while ($locRow = $locSql->fetch_assoc()) {
            $id = $locRow['location_id'];
            $name = $locRow['location_name'];
            $link = $locRow['location_link'];
            $timeSlot = $locRow['time_slot'];
            $limit = $locRow['limit'];

            $rowcount = 0;
            $userCountSql = "select * from users where region_id=" . $region . " and location_id=" . $id;
            if ($result = mysqli_query($conn, $userCountSql)) {
                    // Return the number of rows in result set
                $rowcount = mysqli_num_rows($result);
            }
            if ($groupNo != 0) {
                if ((int)$rowcount + $groupNo <= (int)$limit) {
                    $noOfLoc = $noOfLoc + 1;
                    $html .= '<option value="' . $id . '">';
                    if($name != null && $name != ""){
                        $html .=  $name;
                    }

                    if($link != null && $link != ""){
                        $html .=  '(' . $link . '), ';
                    }

                    $html .=  $timeSlot . '</option>';
                }
            } else {
                if ((int)$rowcount + 1 <= (int)$limit) {
                    $noOfLoc = $noOfLoc + 1;
                    $html .= '<option value="' . $id . '">';
                    if($name != null && $name != ""){
                        $html .=  $name;
                    }

                    if($link != null && $link != ""){
                        $html .=  '(' . $link . '), ';
                    }

                    $html .=  $timeSlot . '</option>';
                }
            }
            
        }

        $html .= '</select>';
        if ($noOfLoc == 0) {
            $html = '<label style="font-style:italic;color:red">
                Registrations for this city are closed.</label>';
        }

        $conn->close();
        echo $html;
    } else {
        echo '';
    }
}
?>