<!--
  - File Name: dbconnection.php
  - Program Description: class that contains database connections
  -->
  <?php
class dbconnection {

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "upfdatabase";
    private $con;

    function connectdb() {
        $this->con = mysqli_connect($this->host, $this->username, $this->password, $this->database);

        if (!$this->con) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        return $this->con;
    }

    function closeconnection() {
        mysqli_close($this->con);
    }

    function searchProfile($username) {
        $query = "SELECT * FROM table_profile WHERE userName = ?";
        $stmt = mysqli_prepare($this->con, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $result;
        } else {
            die("Error in searchProfile query: " . mysqli_error($this->con));
        }
    }
}
?>

