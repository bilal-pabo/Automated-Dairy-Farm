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

                    $start = date('Y-m-d', strtotime('-7 day'));
                    $end = date('Y-m-d', strtotime('-1 day'));

                    $groupACount = parent::getGroupCounts($start, $end, 10, 25);
                    $groupBCount = parent::getGroupCounts($start, $end, 25, 35);
                    $groupCCount = parent::getGroupCounts($start, $end, 35, 45);

                    $breedsAndCounts = parent::getBreedsAndCounts(); $breeds = array(); $Counts = array();
                    foreach ($breedsAndCounts as $breed=>$count)
                    {
                        $breeds[] = $breed;
                        $Counts[] = $count;
                    }

                    $counts = array($groupACount, $groupBCount, $groupCCount);

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
                        $insemination = "";
                        if ($data['insemination'])
                            $insemination = $data['insemination'];
                        $insdate = date('0001-01-01');
                        $bullid = '';
                        if ($data['semDate'])
                            $insdate = $data['semDate'];
                        if ($data['bullId'])
                            $bullid = $data['bullId'];
                        $pregnant = "";
                        if ($data['pregnant'])
                            $pregnant = $data['pregnant'];
                        $startDate = date('0001-01-01');
                        if ($data['startDate'])
                            $startDate = $data['startDate'];
                        $color = '';
                        $dob = date('0001-01-01');
                        $price = -1;
                        if ($data['color'])
                            $color = $data['color'];
                        if ($data['dob'])
                            $dob = $data['dob'];
                        if ($data['price'])
                            $price = $data['price'];
                        $result = parent::addAnimal($data['id'], $data['breed'], $data['gender'], $color, $dob, $price, $insemination, $insdate, $bullid, $pregnant, $startDate);
                        $_SESSION['msg'] = $result['Message'];

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
                    if (isset($_POST["updatebtn"]))
                    {
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
                    $insemination = "";
                    if ($_POST['insemination'])
                        $insemination = $_POST['insemination'];
                    $insdate = date('0001-01-01');
                    $bullid = '';
                    if ($_POST['insdate'])
                        $insdate = $_POST['insdate'];
                    if ($_POST['bid'])
                        $bullid = $_POST['bid'];
                    $pregnant = "";
                    if ($_POST['pregnant'])
                        $pregnant = $_POST['pregnant'];
                    $startdate = date('0001-01-01');
                    if ($_POST['startDate'])
                        $startdate = $_POST['startdate'];
                    $deliverydate = date('0001-01-01');
                    if ($_POST['deliverydate'])
                        $deliverydate = $_POST['deliverydate'];
                    $abortiondate = date('0001-01-01');
                    if ($_POST['abortiondate'])
                        $abortiondate = $_POST['abortiondate'];

                    //$result = parent::updateAnimalInfo($id, $breed, $gender, $color, $dob, $price, $insemination, $insdate, $bullid, $pregnant, $startdate, $abortiondate, $deliverydate);
                    //if ($result)
                    //    $_SESSION['msg'] = "Updation Successfull!";
                    //else
                    //    $_SESSION['msg'] = "Updation Failed!";

                    }
                    else
                    {
                        $breeds = parent::getBreeds();
                        $id = $_GET['cowid'];
                        $start = date('Y-m-d', strtotime('-7 day'));
                        $end = date('Y-m-d', strtotime('-1 day'));
                        $animalInfo = parent::getAnimalData($id);
                        
                            $response = parent::getCowRecordsByDuration($id, $start, $end);
                            for ($i = 0; $i < 7; $i++) {
                                $date = strtotime("+$i day", strtotime($start));
                                $labels[] = date('M d', $date);
                            }
                        
                        include './View/header2.php';
                        include './View/sidebar.php';
                        include './View/animalProfile.php';
                        include './View/rightbar.php';
                        include './View/footer.php';
                    }
                    
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

                    $id = $_POST["id"];
                    echo "aaaaaaaaaaaaaa";
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
                    $insemination = "";
                    if ($_POST['insemination'])
                        $insemination = $_POST['insemination'];
                    $insdate = date('0001-01-01');
                    $bullid = '';
                    if ($_POST['semDate'])
                        $insdate = $_POST['insdate'];
                    if ($_POST['bullId'])
                        $bullid = $_POST['bullid'];
                    $pregnant = "";
                    if ($_POST['pregnant'])
                        $pregnant = $_POST['pregnant'];
                    $startdate = date('0001-01-01');
                    if ($_POST['startDate'])
                        $startDate = $_POST['startdate'];
                    $deliverydate = date('0001-01-01');
                    if ($_POST['deliverydate'])
                        $deliverydate = $_POST['deliverydate'];
                    $abortiondate = date('0001-01-01');
                    if ($_POST['abortiondate'])
                        $abortiondate = $_POST['abortiondate'];

                    $result = parent::updateAnimalInfo($id, $breed, $gender, $color, $dob, $price, $insemination, $insdate, $bullid, $pregnant, $startDate, $abortiondate, $deliverydate);
                    if ($result)
                        $_SESSION['msg'] = "Updation Successfull!";
                    else
                        $_SESSION['msg'] = "Updation Failed!";

                    break;

                case '/reports':
                    $breeds = parent::getBreeds();
                    $cows = parent::getAllCows();
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/reports.php';
                    include './View/rightbar.php';
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