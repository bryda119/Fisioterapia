<?php
include('admin/config/dbconn.php');
include('main/header.php');
include('main/topbar.php');
?>
    <main id="main">
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Nosotros</h2>
                    <ol>
                        <li><a href="index.php">Inicio</a></li>
                        <li>Nosotros</li>
                    </ol>
                </div>
            </div>
        </section>
        <section class="inner-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                    <?php
                        $sql = "SELECT * FROM about";
                        $query_run = mysqli_query($conn,$sql);
                        while($row = mysqli_fetch_array($query_run))
                        {
                    ?>
                        <div class="card border-0">
                            <h4 class="mb-4 text-primary"><?=$row['title']?></h4>
                            <img src="upload/<?=$row['image']?>" class="card-img-top img-fluid"  alt="">
                            <div class="card-body">
                                <p class="description"><?=$row['content']?></p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4">
                        <?php include('main/side-contact.php');?>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php 
include('main/footer.php');
include('main/scripts.php');
?>