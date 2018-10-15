<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_POST) {
    $city = $_POST['city'];
    if ($city != '') {
        $sql = mysqli_query($conn, "select region_id, region_name from region where city_id=" . $city);
        echo '<label for="regDrpDwn">Region :</label>';
        echo '<select name="regDrpDwn" id="regDrpDwn" class="form-control">';
        echo '<option value="">---Select---</option>';
        while ($row = $sql->fetch_assoc()) {
            $id = $row['region_id'];
            $name = $row['region_name'];
            echo '<option value="' . $id . '">' . $name . '</option>';
        }
        echo '</select>';
        $conn->close();
    } else {
        echo '';
    }
}
?>