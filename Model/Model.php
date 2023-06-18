<?php
class Model
{
    protected $connection;
    protected $database = 'dairy_farm';
    protected $server = 'localhost';
    protected $username = 'root';
    protected $password = 'root';

    function __construct()
    {
        mysqli_report(MYSQLI_REPORT_STRICT);
        try {
            $this->connection = mysqli_connect($this->server, $this->username, $this->password, $this->database);
        } catch (Exception $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function verifyUser($email, $password)
    {
        $query = "select * from userinfo where email='$email' and pwd='$password'";
        try {
            $result = mysqli_query($this->connection, $query);
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_object($result);
                $response['Data'] = $user;
                $response['Code'] = true;
                $response['Message'] = "User authenticated!";
            } else {
                $response['Data'] = null;
                $response['Code'] = false;
                $response['Message'] = "Wrong email or password";
            }
            return $response;
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    function addAnimal($id, $breed, $gender, $color, $dob, $price)
    {
        $query = "select * from animalinfo where id='$id'";
        $result = mysqli_query($this->connection, $query);
        $recordsFound = mysqli_num_rows($result);
        if ($recordsFound > 0) {
            $response['Code'] = false;
            $response['Message'] = "Animal id already exist!";
            $response['add'] = 0;
        } else {
            $query2 = "insert into animalinfo (id, breed, gender, color, dob, price) values('$id', '$breed', '$gender', '$color', '$dob', '$price')";
            if (mysqli_query($this->connection, $query2)) {
                $response['Code'] = true;
                $response['Message'] = "Animal added successfully!";
                $response['add'] = 1;
            } else {
                $response['Code'] = false;
                $response['Message'] = "Something went wrong!";
                $response['add'] = 2;
            }
        }
        return $response;
    }

}
?>