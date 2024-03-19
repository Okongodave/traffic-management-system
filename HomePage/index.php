<!--
  - File Name: HomePage/index.php
  - Program Description: home page
  -->
  <?php
$root = "../"; // root folder
$pageTitle = "Home";
$currentMenu = "homepage";

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
    exit; // Terminating script execution after redirecting
}

include "../RegistrationManager.php";
$rm = new RegistrationManager();
?>

<html>
<?php include $root . "head.php"; ?>

<body id='searchProfile'>
<div id='centerArea'>
    <?php include $root . "menu.php"; // display menu options ?>

    <div id="content">
        <form name="disp" method="post" action="RegistrationManager.php">
            <?php
            echo "<div style=''>";
            switch ($_SESSION['profileType']) {
                case "APPLICANT":
                    $rm->showProfile($_SESSION['username']);
                    $vehicles = $rm->retrieveVehicle($_SESSION['profileID']);
                    if (isset($_SESSION['driverID']) && $_SESSION['driverID'] != "") {
                        $violations = $rm->retrieveViolations("driverID=" . $_SESSION['driverID']);
                        $drivers = $rm->retrieveDrivers($_SESSION['profileID']);
                    }

                    /* print the vehicles */
                    if ($vehicles !== false && mysqli_num_rows($vehicles) > 0) {
                        echo "Vehicle/s Information:";

                        echo "<table id='result'>";
                        echo "
                            <tr>
                                <th>Plate Number</th>
                                <th>Sticker Number</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        ";

                        while ($row = mysqli_fetch_assoc($vehicles)) {
                            echo "
                                <tr>
                                    <td>" . $row['plateNumber'] . "</td>
                                    <td>" . $row['stickerNumber'] . "</td>
                                    <td align='center'>";
                            if ($row['status'] == "released") {
                                echo $row['status'];
                            } elseif ($row['paid'] != "0000-00-00") {
                                echo "paid";
                            } else {
                                echo $row['status'] . ($row['status'] == "disapproved" ? ("<br>-<br>" . $row['condition']) : "");
                            }
                            echo "</td>";
                            if ($row['paid'] == '0000-00-00') {
                                echo "<td><a title='Edit Vehicle' href='../Vehicle/Update/?pn=" . $row['plateNumber'] . "'><img src='" . $root . "assets/images/icons/edit24.png'></a></td>";
                                echo "<td><a title='Delete Vehicle' href='../Vehicle/DeleteVehicle.php/?pn=" . $row['plateNumber'] . "'><img src='" . $root . "assets/images/icons/delete24.png'></a></td>";
                            } else {
                                echo "<td><img title='Cannot Edit Vehicle' src='" . $root . "assets/images/icons/edit24_x.png'></td>";
                                echo "<td><img title='Cannot Delete Vehicle' src='" . $root . "assets/images/icons/delete24_x.png'></td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                    }

                    /* print violations */
                    if (isset($_SESSION['driverID']) && $_SESSION['driverID'] != "") {
                        if ($violations !== false && mysqli_num_rows($violations) > 0) {
                            echo "<br>";
                            echo "User Violation/s:";
                            echo "<table id='result'>";
                            echo "
                                <tr>
                                    <th>Plate Number</th>
                                    <th>Violation</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Location</th>
                                    <th>Penalty</th>
                                </tr>
                            ";
                            while ($row = mysqli_fetch_assoc($violations)) {
                                if ($row['approve'] == 1) {
                                    echo "<tr>";
                                    echo "<td>" . $row['plateNumber'] . "</td>";
                                    echo "<td>" . $row['violation'] . "</td>";
                                    echo "<td>" . $row['violationDate'] . "</td>";
                                    echo "<td>" . $row['violationTime'] . "</td>";
                                    echo "<td>" . $row['violationLocation'] . "</td>";
                                    echo "<td>" . $row['penalty'] . "</td>";
                                    echo "</tr>";
                                }
                            }
                            echo "</table>";
                        }
                    }

                    /* print the drivers */
                    if (isset($drivers) && $drivers !== false && mysqli_num_rows($drivers) > 0) {
                        echo "<br>";
                        echo "Driver/s:";
                        echo "<table id='result'>";
                        echo "
                            <tr>
                                <th>Driver ID</th>
                                <th>Name</th>
                                <th>License Number</th>
                            </tr>
                        ";
                        while ($row = mysqli_fetch_assoc($drivers)) {
                            echo "<tr>";
                            echo "<td>" . $row['driverID'] . "</td>";
                            echo "<td>" . $row['lastName'] . ", " . $row['givenName'] . " " . $row['middleName'] . "</td>";
                            echo "<td>" . $row['licenseNumber'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }

                    break;
                case "ADMIN":
                    // Your ADMIN content here
                    break;
                case "OVCCA":
                    // Your OVCCA content here
                    break;
                case "CASHIER":
                    // Your CASHIER content here
                    break;
                case "OPERATIONS":
                    // Your OPERATIONS content here
                    break;
                case "INVESTIGATION":
                    // Your INVESTIGATION content here
                    break;
            }
            echo "</div>";
            ?>
        </form>
    </div>
</div>
</body>
</html>

<?php
if (isset($_SESSION['searchnull'])) {
    unset($_SESSION['searchnull']);
}
?>
