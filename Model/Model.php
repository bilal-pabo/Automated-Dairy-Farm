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
            $response['color'] = 'warning';
        } else {
            $query2 = "insert into animalinfo (id, breed, gender, color, dob, price) values('$id', '$breed', '$gender', '$color', '$dob', '$price')";
            if (mysqli_query($this->connection, $query2)) {
                $response['Code'] = true;
                $response['Message'] = "Animal added successfully!";
                $response['color'] = 'success';
            } else {
                $response['Code'] = false;
                $response['Message'] = "Oops! Animal don't want to get in";
                $response['color'] = 'danger';
            }
        }
        return $response;
    }

    function allAnimals()
    {
        try {
            $animals = array();
            $query = "select * from animalinfo";
            $result = mysqli_query($this->connection, $query);
            $recordsFound = mysqli_num_rows($result);
            while ($row = mysqli_fetch_object($result)) {
                $animals[] = $row;
            }
            return $animals;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getBreeds()
    {
        try {
            $query = "select * from breeds";
            $result = mysqli_query($this->connection, $query);
            $breeds = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $breeds[] = $row['breedName'];
            }
            return $breeds;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function addPregnant($cowid, $startdate)
    {
        try {
            $query = "insert into pregnantcows (cowid, startdate) values('$cowid', '$startdate')";
            mysqli_query($this->connection, $query);
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getPregnantCows()
    {
        try {
            $query = "select * from pregnantcows";
            $data = array();
            $result = mysqli_query($this->connection, $query);
            while ($row = mysqli_fetch_object($result)) {
                $data[] = $row;
            }
            return $data;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function addSeminationRecord($cowid, $type, $date, $bullid)
    {
        try {
            $query = "insert into insemination (cowid, type, date, bullid) values('$cowid', '$type', '$date', '$bullid')";
            mysqli_query($this->connection, $query);
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getAnimalData($id)
    {
        try {
            $query = "select * from animalinfo where id='$id'";
            $result = mysqli_query($this->connection, $query);
            $data = mysqli_fetch_object($result);
            return $data;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getSeminationRecord($id)
    {
        try {
            $query = "select * from insemination where cowid='$id'";
            $result = mysqli_query($this->connection, $query);
            if (mysqli_num_rows($result) > 0) {
                $response['data'] = mysqli_fetch_object($result);
                $response['code'] = true;
                return $response;
            } else {
                $response['code'] = false;
                return $response;
            }
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getPregnancyInfo($id)
    {
        try {
            $query = "select * from pregnantcows where cowid='$id'";
            $result = mysqli_query($this->connection, $query);
            if (mysqli_num_rows($result) > 0) {
                $response['data'] = mysqli_fetch_object($result);
                $response['code'] = true;
                return $response;
            } else {
                $response['code'] = false;
                return $response;
            }
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getAllCows()
    {
        try {
            $query = "select id from animalinfo where gender='Cow'";
            $cows = array();
            $result = mysqli_query($this->connection, $query);
            while ($row = mysqli_fetch_assoc($result))
            {
                $cows[] = $row['id'];
            }
            return $cows;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function addMilkRecord($id, $date, $amount, $times)
    {
        try {
            $query = "insert into milkrecords (cowid, date, milkamount, times) values('$id', '$date', '$amount', '$times')";
            mysqli_query($this->connection, $query);
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    // function totalMilkByDay()
    // {
    //     try {
    //         $query = "select milkamount, date from milkrecords where date = (select max(date) from milkrecords)";
    //         $result = mysqli_query($this->connection, $query);
    //         while ($row = mysqli_fetch_assoc($result))
    //         {
    //             $response['milk'] += $row['milkamount'];
    //             $response['date'] = $row['date'];
    //         }
    //         return $response;

    //     } catch (Exception $e) {
    //         echo "Database error : " . $e->getMessage();
    //     }
    // }

    function recordValid($date) {
        try {
            $query = "select times from milkrecords where date='$date'";
            $result = mysqli_query($this->connection, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $times = $row['times'];
                return $times;
            }
            else {
                $times = 0;
                return $times;
            }


        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    
    }

    function updateMilkRecord($key, $date, $quantity, $count)
    {
        try {
            $query = "update milkrecords set milkamount = milkamount + $quantity, times = $count where cowid = '$key' and date = '$date'";
            $result = mysqli_query($this->connection, $query);
            
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function addTotalMilk($date, $amount)
    {
        try {
            $query = "insert into milkperday (date, amount) values('$date', '$amount')";
            $result = mysqli_query($this->connection, $query);
            
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function updateTotalMilk($date, $amount)
    {
        try {
            $query = "update milkperday set amount = amount + $amount where date = '$date'";
            $result = mysqli_query($this->connection, $query);
            
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getTotalMilkByDay($date)
    {
        try {
            $query = "select amount from milkperday where date = '$date'";
            $result = mysqli_query($this->connection, $query);
            if ($row = mysqli_fetch_array($result))
            {
                return $row['amount'];
            }
            else return 0;
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

    function getWeeklyRecord($start, $end)
    {
        try {
            $query = "select * from milkperday where date between '$start' and '$end'";
            $result = mysqli_query($this->connection, $query);
            $records = array();
            while ($row = mysqli_fetch_array($result))
            {
                $records[] = $row;
            }
        } catch (Exception $e) {
            echo "Database error : " . $e->getMessage();
        }
    }

}
?>