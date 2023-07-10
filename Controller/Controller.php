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
                    $todayMilk = parent::getTotalMilkByDay($today, 'amount');
                    $todayExpense = parent::getTotalMilkByDay($today, 'expense');
                    $todayProfit = parent::getTotalMilkByDay($today, 'saleprice');
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
                    $lowYieldCowsCount = parent::getGroupCounts($start, $end, 0, 10);
                    $sickCount = parent::getSickCount();

                    $breedsAndCounts = parent::getBreedsAndCounts();
                    $breeds = array();
                    $Counts = array();
                    foreach ($breedsAndCounts as $breed => $count) {
                        $breeds[] = $breed;
                        $Counts[] = $count;
                    }

                    $counts = array($groupACount, $groupBCount, $groupCCount);

                    for ($i = 0; $i < 7; $i++) {
                        $date = strtotime("+$i day", strtotime($sevenDaysBack));
                        $labels[] = date('M d', $date);
                        $chartData[] = parent::getTotalMilkByDay(date('Y-m-d', $date), 'amount');
                        $expense = parent::getTotalMilkByDay(date('Y-m-d', $date), 'expense');
                        $earned = parent::getTotalMilkByDay(date('Y-m-d', $date), 'saleprice');
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

                        if ($pregnant == "Yes") {
                            parent::addPregnant($data['id'], $startDate);
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
                        $result = parent::addAnimal($data['id'], $data['breed'], $data['gender'], $color, $dob, $price, $insemination, $insdate, $bullid, $pregnant, $startDate);
                        $_SESSION['msg'] = $result['Message'];
                        $_SESSION['code'] = $result['Code'];

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

                case '/lowYieldCows':
                    $lowYieldCows = array();
                    $start = date('Y-m-d', strtotime('-7 day'));
                    $end = date('Y-m-d', strtotime('-1 day'));
                    $lowYieldCows = parent::getGroupCows($start, $end, 0, 10);
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/lowYieldCows.php';
                    include './View/rightbar.php';
                    include './View/footer.php';
                    break;

                case '/animalProfile':
                    if (isset($_POST["updatebtn"])) {
                        //   $array = $_POST;
                        //     print_r($array);
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
                        //$gender = $_POST["gender"];
                        $insemination = "";
                        if ($_POST['insemination'])
                            $insemination = $_POST['insemination'];
                        $insdate = date('0001-01-01');
                        $bullid = '';
                        if ($_POST['date'])
                            $insdate = $_POST['date'];
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

                        $result = parent::updateAnimalInfo($id, $breed, $color, $dob, $price, $insemination, $insdate, $bullid, $pregnant, $startdate, $abortiondate, $deliverydate);
                        if ($result)
                            $_SESSION['msg'] = "Updation Successfull!";
                        else
                            $_SESSION['msg'] = "Updation Failed!";


                        ?>
                        <script>
                            window.location.href = <?php echo "animalProfle?cowid=" . $id ?>;
                        </script>
                        <?php
                    }

                    $breeds = parent::getBreeds();

                    $cid = $_GET['cowid'];

                    $start = date('Y-m-d', strtotime('-7 day'));
                    $end = date('Y-m-d', strtotime('-1 day'));
                    $animalInfo = parent::getAnimalData($cid);

                    $response = parent::getCowRecordsByDuration($cid, $start, $end);
                    for ($i = 0; $i < 7; $i++) {
                        $date = strtotime("+$i day", strtotime($start));
                        $labels[] = date('M d', $date);
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
                        $expense = 0;
                        $getExpense = $data['expense'];
                        if ($getExpense > $expense)
                            $expense = $getExpense;
                        $times = parent::recordValid($date);
                        if ($times == 2) {
                            $_SESSION['msg'] = "Milk records of " . $date . " are already added!";
                        } else {
                            foreach ($data as $key => $value) {
                                if (
                                    $key == 'addRecord' || $key == 'milkDate' ||
                                    $key == 'milkPrice' || $key == 'expense'
                                ) {
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
                                $profit = $price * $totalmilk;


                                parent::addTotalMilk($date, $totalmilk, $profit, $expense);

                                parent::addTotalProfit($date, $profit);
                            }
                            if ($times == 1) {
                                $profit = $price * $totalmilk;
                                parent::updateTotalMilk($date, $totalmilk, $profit, $expense);

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
                            $_SESSION['type'] = "success";
                        } else {
                            $_SESSION['Msg'] = "Something went wrong!";
                            $_SESSION['type'] = "invalid";
                        }
                        ?>
                        <script>
                            window.location.href = "breeds";
                        </script>
                        <?php
                    }

                    if ($_GET["sickid"]) {
                        $id = $_GET["sickid"];
                        $result = parent::deleteSick($id);
                        if ($result) {
                            $_SESSION['Msg'] = $id . " removed successfully!";
                            $_SESSION['type'] = "success";
                        } else {
                            $_SESSION['Msg'] = "Something went wrong!";
                            $_SESSION['type'] = "invalid";
                        }
                        ?>
                        <script>
                            window.location.href = "health";
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
                    //$gender = $_POST["gender"];
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

                    $result = parent::updateAnimalInfo($id, $breed, $color, $dob, $price, $insemination, $insdate, $bullid, $pregnant, $startDate, $abortiondate, $deliverydate);
                    if ($result)
                        $_SESSION['msg'] = "Updation Successfull!";
                    else
                        $_SESSION['msg'] = "Updation Failed!";

                    break;

                case '/reports':
                    $cowRecords = parent::cowRecordsPerDay();
                    $breeds = parent::getBreeds();
                    $cows = parent::getAllCows();
                    $dailyMilkRecords = parent::allMilkRecords();
                    $profit = parent::allProfitRecords();
                    //$expense = parent::allExpenseRecords();
                    $cows = parent::getAllCows();
                    $monthlyRecords = parent::getMonthlyData();
                    $monthlyMilk = array();
                    $monthlyExpense = array();
                    $monthlyProfit = array();
                    for ($i = 0; $i < 12; $i++) {
                        $monthlyMilk[] = parent::getMonthlyTotalMilk($i + 1, 'amount');
                        $expense = parent::getMonthlyTotalMilk($i + 1, 'expense');
                        $earned = parent::getMonthlyTotalMilk($i + 1, 'saleprice');
                        $monthlyExpense[] = $expense;
                        $monthlyProfit[] = $earned - $expense;
                    }

                    $days = array();
                    $milkAmount = array();
                    if ($dailyMilkRecords["code"] == true) {
                        $Data = $dailyMilkRecords['data'];
                        $Size = sizeof($Data);
                        for ($i = 0; $i < $Size; $i++) {
                            $days[] = $Data[$i]["date"];
                            $milkAmount[] = $Data[$i]["amount"];
                        }
                    } else
                        $size = 0;



                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/reports.php';
                    include './View/rightbar.php';
                    include './View/footer.php';
                    break;

                case '/fetchReports':
                    $id = $_GET["cowid"];
                    $records = parent::getCowRecords($id);
                    if ($records["code"] == true) {
                        $data = $records["data"];
                        http_response_code(200);
                        echo json_encode(["data" => $data]);
                    } else {
                        http_response_code(400);
                    }

                    break;

                case '/addExamination':
                    $id = $_POST["id"];
                    $dis = $_POST["disease"];
                    $med = $_POST["med"];
                    $temp = $_POST["temp"];
                    $date = $_POST["date"];
                    $result = parent::addSick($id, $dis, $med, $temp, $date);
                    if ($result == "updated")
                    {
                        $_SESSION["msg"] = "Record updated!";
                    }
                    if ($result == "added")
                    {
                        $_SESSION["msg"] = "Record added!";
                    }  ?>
                        <script>
                            window.location.href = "health";
                        </script>  <?php

                    break;

                case '/search':
                    $what = $_GET['what'];
                    $isAnimal = parent::searchAnimalTable($what);
                    if ($isAnimal['what'] == 'id') { ?>
                        <script>
                            window.location.href = './animalProfile?cowid=<?= $what; ?>';
                        </script>
                    <?php } else if ($isAnimal['what'] == 'breed') { ?>
                            <script>
                                window.location.href = './breeds#<?= $what ?>';
                            </script>
                        <?php } else if ($isAnimal['what'] == 'gender' || $what == 'cow') {
                        include './View/header2.php';
                        include './View/sidebar.php';
                        include './View/searchResults.php';
                        include './View/rightbar.php';
                        include './View/footer.php';
                    } else if ($what == "pregnant" || $what == "Pregnant") {
                        ?>
                                    <script>
                                        window.location.href = './pregnantCows';
                                    </script>
                                    <?php
                    }
                    break;

                case '/notifications':
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/footer.php';
                    break;

                case '/health':
                    $sickAnimals = parent::getSickAnimals();
                    if ($sickAnimals["code"] == true)
                    {
                        $data = $sickAnimals["data"];
                        $sickSize = sizeof($data);
                    }
                    else $sickSize = 0;
                    $totalanimals = parent::allAnimals();
                    $totalSize = sizeof($totalanimals);
                    $labels = array("Sick", "Healthy");
                    $chartData = array($sickSize, $totalSize);
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/health.php';
                    include './View/rightbar.php';
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