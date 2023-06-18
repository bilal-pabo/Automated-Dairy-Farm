<div class="right">


            <div class="top">

                <button id="menu-btn">

                    <span class="material-icons-sharp">menu</span>

                </button>

                <div class="theme-toggler">

                    <span class="material-icons-sharp active">light_mode</span>

                    <span class="material-icons-sharp">dark_mode</span>

                </div>

                <div class="profile">

                    <div class="info">

                        <p>Hey, <b><?= $_SESSION['user']->fullname ?></b></p> <small class="text-muted">Admin</small>

                    </div>

                    <div class="profile-photo">

                        <a href="profile"><img src=<?php echo $dots.'components/profiles/admin.jpg' ?>></a>

                    </div>

                </div>

            </div>
        </div>