<!DOCTYPE html>
<html lang="en">
<head>
    <title>Day Of Service Registration</title>
    <meta charset="utf-8">
    <header name = "Access-Control-Allow-Origin" value = "*" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="admin.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="./admin.css">
</head>
<body>
    <div class="overlay">
    </div>
    <div class="page-header container"><h1 style="text-align: center;">ADMIN PAGE</h1></div>
    
    <div class="container">
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Filter</div>
                <div class="panel-body">
                    <form id="filterForm" method="post">
                        <input type='hidden' name='submitted' id='submitted' value='1'/>
                        <div class="row">
                            <div class="form-group form-inline col-lg-4" id="citySection">
                                <label for="cityDrpDwn">City :</label>
                                <select name="cityDrpDwn" id="cityDrpDwn" class="form-control">
                                    <option value="" selected>---Select---</option>
                                    <?php
                                        $servername = "";
                                        $username = "";
                                        $password = "";
                                        $dbname = "";

                                        $conn = new mysqli($servername, $username, $password, $dbname);

                                        $sql = mysqli_query($conn, "select city_id,city_name from city");

                                        while ($row = $sql->fetch_assoc()) {
                                            $id = $row['city_id'];
                                            $name = $row['city_name'];
                                            echo '<option value="' . $id . '">' . $name . '</option>';
                                        }
                                        $conn->close();
                                        ?>                        
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group form-inline col-lg-4" id="regSection">
                            </div>
                            <div class="form-group form-inline col-lg-4" id="locSection">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="btnSearch">Search</button>
                        </div>
                        <div class="row" style="margin-top:2%">
                            <div class="form-group form-inline col-lg-6">
                                <label for="emailBody">Email Msg:</label>
                                <textarea name="emailBody" id="emailBody" cols="5" rows="5" class="form-control"></textarea>
                                <div class="text-center" style="margin-top:2%">
                                    <button type="submit" class="btn btn-success" id="btnEmail" disabled>Mail</button>
                                </div>
                            </div>
                            <div class="form-group form-inline col-lg-6">
                                <label for="smsBody">Sms Msg:</label>
                                <textarea name="smsBody" id="smsBody" cols="5" rows="5" class="form-control"></textarea>
                                <div class="text-center" style="margin-top:2%">
                                    <button type="submit" class="btn btn-warning" id="btnSms" disabled>Sms</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="page-header"><h2 style="text-align: center;">User Table</h2></div>
            <div id="tableSection">
                <?php
                    $servername = "";
                    $username = "";
                    $password = "";
                    $dbname = "";

                        // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM users u 
                        left join city c on u.city_id=c.city_id 
                        left join region r on u.region_id = r.region_id
                        left join location l on u.location_id = l.location_id";
                        
                    if ($countResult = mysqli_query($conn, $sql)) {
                        // Return the number of rows in result set
                        echo '<h3 style="text-align: center;">Total Count: ' . mysqli_num_rows($countResult) . '</h3>';
                    }
                    
                    $result = $conn->query($sql);

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
                    } else {
                        echo "0 results";
                    }

                    $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>
