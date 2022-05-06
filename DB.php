<?php

class Database {
    private $conn;
    public function __construct()
    {
        $this->conn = mysqli_connect('localhost','root','','user_registration');
        if($this->conn->connect_error){
            die('Connection failed : '.$this->conn->connect_error);
        }
    }

    public function insertData($tableName, $data = []) {
        $sql = "INSERT INTO ". $tableName. "(";
        $arr_keys = array_keys($data);
        $len = sizeof($arr_keys);
        for($i = 0;$i<$len;$i++) {
            $sql .=  $arr_keys[$i];

            if($i != $len-1) {
                $sql.=",";
            } else {
                $sql.=")values(";
            }
        }
        for($i = 0;$i<$len;$i++) {
            $sql .=  $data[$arr_keys[$i]];

            if($i != $len-1) {
                $sql.=",";
            } else {
                $sql.=")";
            }
        }
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute()) {
            return 1;
        } else {
             return 0;
        }
    }
}