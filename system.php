<?php
/*  LILCASOFT CMS VERSION 2.0
    COPYRIGHT 2018
    LILCASOFT.INFO
*/
class LILCA_CMS{

    /* START YOUR DB CONFIG HERE */
    public $conn; //CONNECTION STRING
    private $host = "localhost"; //SERVER HOST
    private $username = "root"; //USER NAME
    private $password = ""; //SERVER PASSWORD
    public $db = "lilca"; //DATABASE NAME
    public $domain = ""; // Blank as default
    public $tbl_user = "users"; /* Define TABLE USERS to use authentication method for LOGIN.
    METHOD Authentication use column email and password in table users to validate.
    IF your users table uses different column name then search for authentication function below to modify the func. */

    public $img_folders = ["images",
                           "portfolio_images",
                           "recipes_images"
                         ]; //Define List of folder images to use UPLOAD FEATURE. DON'T FORGET TO SET CMOD 777 TO YOUR IMAGES FOLDER

    /* END YOUR DB CONFIG HERE */

    public function connectDB(){ //make connection to DB
        $this->conn = mysqli_connect($this->host,
                                    $this->username,
                                    $this->password,
                                    $this->db) or die("Connection failed!");
    }

    public function closeDB(){ //close connection to DB
        mysqli_close($this->conn);
    }

    public function protectField($value){ //return value with full protection from SQL INJECTION
      $this->connectDB();
      $protectedVal = mysqli_real_escape_string($this->conn, $value);
      $this->closeDB();
      return $protectedVal;
    }

    public function exeQuery($query){ //perform insert, delete, update command
        $this->connectDB();
        mysqli_query($this->conn,"SET NAMES utf8");
        mysqli_query($this->conn, $query);
        $this->closeDB();
    }

    public function terminal($query){ //perform insert, delete, update command
        $result;
        $this->connectDB();
        mysqli_query($this->conn,"SET NAMES utf8");
        $result = mysqli_query($this->conn, $query);
        $this->closeDB();
        return $result;
    }

    public function getRows($query){ //return set of result in array ["name"]
        $this->connectDB();
        $result;
        mysqli_query($this->conn,"SET NAMES utf8");
        $execution = mysqli_query($this->conn, $query);
        if($execution){
            $result = mysqli_fetch_array($execution,MYSQLI_BOTH); //MYSQLI_NUM || MYSQLI_ASSOC
            mysqli_free_result($execution);
        }else{
            $result = "";
        }

        $this->closeDB();
        return $result;
    }

    public function authentication($user_email, $user_pass, $table_name){ //return true or false
        $status;
        $this->connectDB();
        $adm_query = mysqli_query($this->conn, "SELECT * FROM ".$table_name." WHERE email = '".$user_email."' AND password = '".$user_pass."'");
        $status = mysqli_num_rows($adm_query) != 0 ? true: false;
        $this->closeDB();
        return $status;
    }

    public function getColumns($table_name){
        $this->connectDB();
        $query = mysqli_query($this->conn, "SELECT column_name FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name='".$table_name."' ORDER BY ordinal_position;");
        if(!$query){
            echo "No rows return<br>".mysqli_error();
            exit;
        }
        $columns = array();
        while($column = mysqli_fetch_array($query,MYSQLI_BOTH)){
            $columns[] = $column[0];
        }
        $this->closeDB();
        return $columns;
    }

    public function getTables(){ //retrieve all tables from DB
        $this->connectDB();
        $query = mysqli_query($this->conn, "SHOW TABLES FROM ".$this->db);
        if(!$query){
            echo "No rows return<br>".mysqli_error();
            exit;
        }
        $tables = array();
        while($table = mysqli_fetch_array($query,MYSQLI_BOTH)){
            $tables[] = $table[0];
        }
        $this->closeDB();
        return $tables;
    }

    public function getDataTypeOfCol($table_name, $col_name){ //return an array, default value = $data_type[0]
        $this->connectDB();
        $query = mysqli_query($this->conn, "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$table_name."' AND COLUMN_NAME = '".$col_name."'");
        if(!$query){
            echo "No columns and table found!<br>".mysqli_error();
            exit;
        }
        $data_type = mysqli_fetch_array($query,MYSQLI_BOTH);
        $this->closeDB();
        return $data_type;
    }
}
?>
