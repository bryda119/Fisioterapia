<?php
include('admin/config/dbconn.php');
include('main/header.php');
include('main/topbar.php');
?>
    <main id="main">
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <?php 
                    if(isset($_GET['title']))
                    {
                        $user_id = $_GET['title'];
                        $user = "SELECT * FROM services WHERE title='$user_id'";
                        $users_run = mysqli_query($conn,$user);

                        if(mysqli_num_rows($users_run) > 0)
                        {
                            foreach($users_run as $row)
                            {    
                    ?>
                    <h2><?=$row['title']?></h2>
                    <ol>
                        <li><a href="index.php">Home</a></li>
                        <li><?=$row['title']?></li>
                    </ol>
                </div>       
            </div>
        </section>
        <section class="inner-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card border-0">
                            <h4 class="mb-4 text-primary"><?=$row['article_title']?></h4>
                            <img src="upload/service/<?=$row['image']?>" class="card-img-top img-fluid"  alt="">
                            <div class="card-body">
                                <p class="description"><?=$row['description']?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php include('main/side-contact.php');?>
                    </div>
                </div>
            </div>
        </section>
        <?php 
                }
            }
        }
        ?>
    </main>
<?php 
include('main/footer.php');
include('main/scripts.php');
?>