<?php
namespace dbconnecting;

class connection
{
  private $env = null;
  public $conn = null;

  public function connectionAttempt()
  {
    $this->env = parse_ini_file(".env", true);
    $this->conn = new \mysqli(
      $this->env["host"],
      $this->env["user"],
      $this->env["pass"]
    );

    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
    echo "Connected successfully";
    $createNewDB = file_get_contents(dirname(__FILE__) . "/db_setup.sql");
    $this->conn->multi_query("{$createNewDB}");
  }

  public function closeConnection()
  {
    $this->conn->close();
    echo "<p>Connection Closed</p>";
  }

  public function initiateQueries()
  {
    $this->env = parse_ini_file(".env", true);
    $this->conn = new \mysqli(
      $this->env["host"],
      $this->env["user"],
      $this->env["pass"],
      $this->env["database"],
      $this->env["port"]
    );
    return $this->conn;
  }
}

?>
