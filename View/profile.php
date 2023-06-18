<main>
    <h1>Profile</h1>
    <div class="col-md-7">
    <form method="post">
        <div class="card">
            <div class="card-header">
                <h4 class="color">Profile</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5>Name: <?= $_SESSION['user']->fullname ?></h5>
                        <h5>Email: <?= $_SESSION['user']->email ?></h5>
                        <h5>Gender: <?= $_SESSION['user']->gender ?></h5>
                        <h5>State: <?= $_SESSION['user']->state ?></h5>
                        <h5>Adress: <?= $_SESSION['user']->address ?></h5>
                        <h5>Contact: <?= $_SESSION['user']->contact ?></h5>
                    </div>
                    <div class="col-md-4 text-center">
                        <img class="profile image-fluid rounded-circle" src="../components/profiles/admin.jpg" alt="Image">
                        <button class="editprofile">Change Profile</button>
                    </div>

                </div>

            </div>
            <div class="card-footer text-right">
                <input class="btn custom-bg text-white" type="submit" name="edit" id="edit" value="Edit Profile">
            </div>
        </div>
    </form>
</div>
</main>

