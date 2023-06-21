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
                    if (isset($_POST['add']))
                    {
                        $data = $_POST;
                        if ($data['pregnant'] == 'yes') 
                        {
                            $startDate = date('0001-01-01'); 
                            if ($data['startDate']) $startDate = $data['startDate'];
                            parent::addPregnant($data['id'], $startDate);
                        }
                        if ($data['insemination'])
                        {
                            $insdate = date('0001-01-01'); $bullid = '';
                            if ($data['semDate']) $insdate = $data['semDate'];
                            if ($data['bullId']) $bullid = $data['bullId'];
                            parent::addSeminationRecord($data['id'], $data['insemination'], $insdate, $bullid);
                        }
                        $color = ''; $dob = date('0001-01-01'); $price = -1;
                        if ($data['color']) $color = $data['color'];
                        if ($data['dob']) $dob = $data['dob'];
                        if ($data['price']) $price = $data['price'];
                        $result = parent::addAnimal($data['id'], $data['breed'], $data['gender'], $color, $dob, $price);
                        $_SESSION['msg'] = $result['Message'];
                        $_SESSION['color'] = $result['color'];
                        
                            ?> <script> window.location.href = 'addAnimal'; </script> <?php
                       
                    }
                    else 
                    {
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

                case '/groups':
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/footer.php';
                    break;

                case '/breeds':
                    include './View/header2.php';
                    include './View/sidebar.php';
                    include './View/footer.php';
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