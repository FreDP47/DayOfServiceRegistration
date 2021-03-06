<?php  
if (isset($_POST['submitted']) && !empty($_POST['submitted'])) {
    $servername = "";
                                        $username = "";
                                        $password = "";
                                        $dbname = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $userTblSql = "SELECT * FROM users u 
    left join city c on u.city_id=c.city_id 
    left join region r on u.region_id = r.region_id
    left join location l on u.location_id = l.location_id";

    if (isset($_POST['cityDrpDwn']) && !empty($_POST['cityDrpDwn'])) {
        $userTblSql .= " where c.city_id=" . $_POST['cityDrpDwn'];
    }

    if (isset($_POST['regDrpDwn']) && !empty($_POST['regDrpDwn'])) {
        $userTblSql .= " and r.region_id=" . $_POST['regDrpDwn'];
    }

    $location="";
    if (isset($_POST['locDrpDwn']) && !empty($_POST['locDrpDwn'])) {
        $userTblSql .= " and l.location_id=" . $_POST['locDrpDwn'];
    }
	
	if ($countResult = mysqli_query($conn, $userTblSql)) {
        // Return the number of rows in result set
        echo '<h3 style="text-align: center;">Total Count: ' . mysqli_num_rows($countResult) . '</h3>';
    }

    $result = $conn->query($userTblSql);

    if ($result->num_rows > 0) {
        // output data of each row
        if ($result->num_rows > 0) {
            echo '<div class="table-responsive">
                    <table id="userTbl" class="table table-bordered table-striped table-hover"><tr>
                    <th>#</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>VOLUNTEER AT BAKUL REGULARLY?</th>
                    <th>VOLUNTEERED BEFORE AT DOS?</th>
                    <th>FEEDBACK</th>
                    <th>IDEAS</th>
                    <th>LOCATION</th>
                    <th>REGION</th>
                    <th>CITY</th>
                    <th>PHONE</th>
                    <th>INSTITUTION</th>
                    <th>AGE</th>
                    <th>COMFORT LEVEL IN LOCAL LANG</th>
                    <th>GROUP NAME<i>(auto generated by us)</i></th>
                    <th>GROUP LEADER</th>
                    <th>PHOTOGRAPHY</th>
                    <th>FILM MAKING</th>
                    <th>STORYTELLING</th>
                    <th>CRAFT</th>
                    <th>GENERAL QUESTIONS</th>
                </tr>';

            $count = 0;
            while ($row = $result->fetch_assoc()) {
                $count = $count + 1;
                echo "<tr><td>" . $count .
                    "</td><td>" . $row["name"] .
                    "</td><td>" . $row["email"] .
                    "</td><td>" . ($row["vol_bakul"] == '1' ? "Yes" : 'No') .
                    "</td><td>" . ($row["vol_dos"] == '1' ? "Yes" : "No") .
                    "</td><td>" . $row["feedback"] .
                    "</td><td>" . $row["ideas"] .
                    "</td><td>" . $row["time_slot"] .
                    "</td><td>" . $row["region_name"] .
                    "</td><td>" . $row["city_name"] .
                    "</td><td>" . $row["phone"] .
                    "</td><td>" . $row["institution"] .
                    "</td><td>" . $row["age"] .
                    "</td><td>" . $row["local_language_comfort"] .
                    "</td><td>" . $row["group_id"] .
                    "</td><td>" . $row["group_leader"] .
                    "</td><td>" . ($row["photography"] == '1' ? "Yes" : "No") .
                    "</td><td>" . ($row["film_making"] == '1' ? "Yes" : "No") .
                    "</td><td>" . ($row["storytelling"] == '1' ? "Yes" : "No") .
                    "</td><td>" . ($row["craft"] == '1' ? "Yes" : "No") .
                    "</td><td>" . $row["general_queries"] .
                    "</td></tr>";
            }
            echo "</table></div>";
        }
    } else{
        echo "0 results";
    }
}
?>