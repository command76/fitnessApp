<?php 
namespace dbconnecting;

class connection {
    private $pass = null;
    private $user = null;
    private $port = null;
    private $host = null;
    public $conn = null;

    public function connectionAttempt() {
        $this->user = $this->getLoginInfo("user");
        $this->pass = $this->getLoginInfo("pass");
        $this->port = $this->getLoginInfo("port");
        $this->host = $this->getLoginInfo("host");
        $this->conn = new \mysqli($this->host, $this->user, $this->pass);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
          }
          echo "Connected successfully";
    }

    private static function getLoginInfo($type) {
        if ($type === "user") {
            $getUser = file_get_contents("./login_info.txt", true);
            ob_start();
             var_dump($getUser);
             ob_get_clean();
             preg_match("/(?<=user: ).*/", $getUser, $matches );
             return $matches[0];
        } elseif ($type === "pass") {
            $getPass = file_get_contents("./login_info.txt", true);
            ob_start();
            var_dump($getPass);
            ob_get_clean();
            preg_match("/(?<=pass: ).*/", $getPass, $matches );
            return $matches[0];
        } elseif ($type === "port") {
            $getPort = file_get_contents("./login_info.txt", true);
            ob_start();
            var_dump($getPort);
            ob_get_clean();
            preg_match("/(?<=port: ).*/", $getPort, $matches );
            return $matches[0];
        } else {
            $getHost = file_get_contents("./login_info.txt", true);
            ob_start();
            var_dump($getHost);
            ob_get_clean();
            preg_match("/(?<=host: ).*/", $getHost, $matches );
            return $matches[0];
        }
    }

    public function closeConnection() {
        $this->conn->close();
        echo "<p>Connection Closed</p>";
    }
}
?>
