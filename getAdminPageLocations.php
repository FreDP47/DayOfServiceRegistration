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
        $html .= '<label for="locDrpDwn">Time Slot :</label>';
        $html .= '<select name="locDrpDwn" id="locDrpDwn" class="form-control">';
        $html .= '<option value="">---Select---</option>';
        $locSql = mysqli_query($conn, "select * from location where region_id=" . $region);
        while ($locRow = $locSql->fetch_assoc()) {
            $id = $locRow['location_id'];
            $name = $locRow['location_name'];
            $link = $locRow['location_link'];
            $timeSlot = $locRow['time_slot'];
            $limit = $locRow['limit'];

            $html .= '<option value="' . $id . '">';
            if ($name != null && $name != "") {
                $html .= $name;
            }

            if ($link != null && $link != "") {
                $html .= '(' . $link . '), ';
            }

            $html .= $timeSlot . '</option>';
        }

        $html .= '</select>';

        $conn->close();
        echo $html;
    } else {
        echo '';
    }
}
?>