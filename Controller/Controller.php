<?php
require_once('Model/Model.php');
session_start();
class Controller extends Model
{
    function __construct()
    {
        parent::__construct();
        if (isset($_SERVER['PATH_INFO'])) {
            switch ($_SERVER['PATH_INFO']) {
                case '/login':
                    if (isset($_POST['login'])) {
                        $result = $this->verifyUser($_POST['email'], $_POST['password']);
                        if ($result['Code']) {
                            $_SESSION['user'] = $result['Data'];
                            ?>
                            <script>
                                window.location.href = 'dashboard';
                            </script>
                            <?php
                        } else {
                            $_SESSION['msg'] = $result['Message'];
                            ?>
                            <script>
                                window.location.href = 'login';
                            </script>
                            <?php
                        }
                    } else {
                        include 'View/header.php';
                        include 'View/login.php';
                    }

                    break;

                case '/dashboard':
                    if (isset($_POST['addExpense'])) {
                        $expenseDate = $_POST['expenseDate'];
                        $dailyExpense = $_POST['dailyExpense'];
                        parent::addDailyExpense($expenseDate, $dailyExpense);

                    }
                    $today = date('Y-m-d');
                    $todayMilk = parent::getTotalMilkByDay($today);
                    $todayExpense = parent::getExpenseByDay($today);
                    $todayProfit = parent::getProfitByDay($today);
                    $_SESSION['todayMilk'] = $todayMilk;
                    $_SESSION['todayExpense'] = $todayExpense;
                    $_SESSION['todayProfit'] = $todayProfit;
                    $sevenDaysBack = date('Y-m-d', strtotime('-7 day'));
                    $labels = array();
                    $chartData = array();
                    $expenseReport = array();
                    $profit = array();
                    for ($i = 0; $i < 7; $i++) {
                        $date = strtotime("+$i day", strtotime($sevenDaysBack));
                        $labels[] = date('M d', $date);
                        $chartData[] = parent::getTotalMilkByDay(date('Y-m-d', $date));
                        $expense = parent::getExpenseByDay(date('Y-m-d', $date));
                        $earned = parent::getProfitByDay(date('Y-m-d', $date));
                        $expenseReport[] = $expense;
                        $profit[] = $earned - $expense;
                    }

                    $pregnantCows = parent::getPregnantCows();
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/dashboard.php';
                    include './View/rightbar.php';
                    include './View/footer.php';
                    break;

                case '/profile':
                    if (isset($_POST['edit'])) {
                        echo "edit mode";
                    } else {
                        include './View/header2.php';
                        include './View/sidebar.php';
                        include './View/profile.php';
                        include './View/rightbar.php';
                        include './View/footer.php';
                    }
                    break;

                case '/addAnimal':
                    $breeds = parent::getBreeds();
                    if (isset($_POST['add'])) {
                        $data = $_POST;
                        if ($data['pregnant'] == 'yes') {
                            $startDate = date('0001-01-01');
                            if ($data['startDate'])
                                $startDate = $data['startDate'];
                            parent::addPregnant($data['id'], $startDate);
                        }
                        if ($data['insemination']) {
                            $insdate = date('0001-01-01');
                            $bullid = '';
                            if ($data['semDate'])
                                $insdate = $data['semDate'];
                            if ($data['bullId'])
                                $bullid = $data['bullId'];
                            parent::addSeminationRecord($data['id'], $data['insemination'], $insdate, $bullid);
                        }
                        $color = '';
                        $dob = date('0001-01-01');
                        $price = -1;
                        if ($data['color'])
                            $color = $data['color'];
                        if ($data['dob'])
                            $dob = $data['dob'];
                        if ($data['price'])
                            $price = $data['price'];
                        $result = parent::addAnimal($data['id'], $data['breed'], $data['gender'], $color, $dob, $price);
                        $_SESSION['msg'] = $result['Message'];
                        $_SESSION['color'] = $result['color'];

                        ?>
                        <script> window.location.href = 'addAnimal'; </script> <?php

                    } else {
                        include './View/header2.php';
                        include './View/sidebar.php';
                        include './View/addAnimal.php';
                        include './View/rightbar.php';
                        include './View/footer.php';
                    }

                    break;

                case '/allAnimals':
                    $records = parent::allAnimals();
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/allAnimals.php';
                    include './View/rightbar.php';
                    include './View/footer.php';
                    break;

                case '/pregnantCows':
                    $pregnantCows = parent::getPregnantCows();
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/pregnantCows.php';
                    include './View/rightbar.php';
                    include './View/footer.php';
                    break;

                case '/animalProfile':
                    $breeds = parent::getBreeds();
                    $id = $_GET['cowid'];
                    $start = date('Y-m-d', strtotime('-7 day'));
                    $end = date('Y-m-d', strtotime('-1 day'));
                    $animalInfo = parent::getAnimalData($id);
                    if ($animalInfo->gender == 'Cow') {
                        $semInfo = parent::getSeminationRecord($id);
                        $pregInfo = parent::getPregnancyInfo($id);
                        $response = parent::getCowRecordsByDuration($id, $start, $end);
                        for ($i = 0; $i < 7; $i++) {
                            $date = strtotime("+$i day", strtotime($start));
                            $labels[] = date('M d', $date);
                        }
                    }
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/animalProfile.php';
                    include './View/rightbar.php';
                    include './View/footer.php';
                    break;

                case '/addMilkRecord':
                    $cows = parent::getAllCows();
                    if (isset($_POST['addRecord'])) {
                        $totalmilk = 0;
                        $data = $_POST;
                        $date = $data['milkDate'];
                        $price = $data['milkPrice'];
                        $times = parent::recordValid($date);
                        if ($times == 2) {
                            $_SESSION['msg'] = "Milk records of " . $date . " are already added!";
                        } else {
                            foreach ($data as $key => $value) {
                                if ($key == 'addRecord' || $key == 'milkDate' || $key == 'milkPrice') {
                                    continue;
                                }

                                $quantity = 0;
                                $getQuantity = $value;
                                if ($getQuantity > $quantity)
                                    $quantity = $getQuantity;
                                $totalmilk += $quantity;
                                if ($times == 0) {
                                    parent::addMilkRecord($key, $date, $quantity, 1);
                                    $_SESSION['msg'] = "Morning milk records of " . $date . " are added successfully!";
                                } else if ($times == 1) {
                                    parent::updateMilkRecord($key, $date, $quantity, 2);
                                    $_SESSION['msg'] = "Evening milk records of " . $date . " are added successfully!";
                                } else {
                                    $_SESSION['msg'] = "Invalid Milk Record!";
                                }
                            }
                            if ($times == 0) {
                                parent::addTotalMilk($date, $totalmilk);
                                $profit = $price * $totalmilk;
                                parent::addTotalProfit($date, $profit);
                            }
                            if ($times == 1) {
                                parent::updateTotalMilk($date, $totalmilk);
                                $profit = $price * $totalmilk;
                                parent::updateProfit($date, $profit);
                            }
                        }
                        ?>
                        <script> window.location.href = 'addMilkRecord'; </script> <?php


                    } else {

                        include './View/header2.php';
                        include './View/sidebar.php';
                        include './View/addMilk.php';
                        include './View/rightbar.php';
                        include './View/footer.php';
                    }
                    break;

                case '/groups':
                    $groupA = array();
                    $groupB = array();
                    $groupC = array();
                    $start = date('Y-m-d', strtotime('-7 day'));
                    $end = date('Y-m-d', strtotime('-1 day'));

                    $groupA = parent::getGroupCows($start, $end, 10, 25);
                    $groupB = parent::getGroupCows($start, $end, 25, 35);
                    $groupC = parent::getGroupCows($start, $end, 35, 45);

                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/groups.php';
                    include './View/rightbar.php';
                    include './View/footer.php';
                    break;

                case '/breeds':
                    if (isset($_POST["addbreedbtn"])) {
                        $breed = $_POST["newbreed"];

                        $result = parent::addBreed($breed);
                        if ($result) {
                            $_SESSION["msg"] = "Breed added successfully!";
                        } else {
                            $_SESSION["msg"] = "Breed already exist!";
                        }
                    }
                    $breeds = parent::getBreeds();
                    $records = parent::allAnimals();
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/breeds.php';
                    include './View/rightbar.php';
                    include './View/footer.php';
                    break;

                case '/delete':
                    if ($_GET["breedName"]) {
                        $breed = $_GET["breedName"];
                        $result = parent::deleteBreed($breed);
                        if ($result) {
                            $_SESSION['Msg'] = $breed . " deleted successfully!";
                        } else {
                            $_SESSION['Msg'] = "Something went wrong!";
                        }
                        ?>
                        <script>
                            window.location.href = "breeds";
                        </script>
                        <?php
                    }
                    break;

                case '/update':
                    if ($_GET["record"] == "general") {
                        $id = $_POST["id"];
                        $color = '';
                        $dob = date('0001-01-01');
                        $price = -1;
                        if ($_POST['color'])
                            $color = $_POST['color'];
                        if ($_POST['dob'])
                            $dob = $_POST['dob'];
                        if ($_POST['price'])
                            $price = $_POST['price'];
                        $breed = $_POST["breed"];
                        $gender = $_POST["gender"];
                        //$ddd =  $id . $breed . $gender . $color . $dob . $price;
                        //$_SESSION['msg'] = $ddd;
                        $result = parent::updateAnimalInfo($id, $breed, $gender, $color, $dob, $price);
                        if ($result)
                            $_SESSION['msg'] = "Updation Successfull!";
                        else
                            $_SESSION['msg'] = "Updation Failed!";
                    } else if ($_GET["record"] == "insemination") {
                        //$insType = $_POST["insemination"];
                        $id = $_SESSION['animalid'];
                        // $insdate = date('0001-01-01');
                        // $bullid = '';
                        // if ($_POST['date'])
                        //     $insdate = $_POST['date'];
                        // if ($_POST['bid'])
                        //     $bullid = $_POST['bid'];
                        // $result = parent::updateInsRecord($id, $insType, $bullid, $insdate);
                        // if ($result)
                        //     $_SESSION['msg'] = "Updation Successfull!";
                        // else
                        //     $_SESSION['msg'] = "Updation Failed!";

                    } else if ($_GET["record"] == "pregnancy") {
                        
                    } ?>
                    <script>
                        window.location.href = "animalProfile";
                    </script>
<?php
                                        break;

                case '/reports':
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/footer.php';
                    break;

                case '/health':
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/footer.php';
                    break;

                case '/notifications':
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/footer.php';
                    break;

                case '/logout':
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/footer.php';
                    break;



            }
        }

    }
}
$obj = new Controller;
?>