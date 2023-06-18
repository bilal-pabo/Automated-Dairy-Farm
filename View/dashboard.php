<main>
            <h1>Dashboard</h1>
            <div class="warning msg"> <?php if(isset($_SESSION['msg'])) { echo $_SESSION['msg']; unset($_SESSION['msg']); } ?> </div>

</main>