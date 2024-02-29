<?php
include('admin/config/dbconn.php');
include('main/header.php');
include('main/topbar.php');
?>
    <main id="main">
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Informacion</h2>
                    <ol>
                        <li><a href="index.php">Inicio</a></li>
                        <li>Informacion</li>
                    </ol>
                </div>
            </div>
        </section>
        <section class="inner-page departments">
            <div class="container">  
                <div class="row mb-3">
                    <div class="col-md-8">
                    <h4 class="mb-4 text-primary">Servicios de Fisioterapia A.M.P</h4>
                    <p class="description">
                        En Fisioterapia A.M.P, nos enorgullece ofrecer una gama completa de servicios de fisioterapia diseñados cuidadosamente para mejorar tu bienestar físico y emocional. Nuestro equipo altamente capacitado está comprometido a brindar atención personalizada y de calidad, utilizando enfoques innovadores y terapéuticos para abordar una variedad de condiciones y necesidades. Ya sea que busques rehabilitación después de una lesión, alivio del dolor, o simplemente mejorar tu movilidad y calidad de vida, estamos aquí para ayudarte en cada paso del camino.
                    </p>
                    </div>
                </div>          
                <div class="row">
                    <div class="col-lg-3">
                        <ul class="nav nav-tabs flex-column">
                        <?php
                        $count = 1;
                        $sql = "SELECT DISTINCT p.service_id,s.id,s.title FROM services as s INNER JOIN procedures as p ON s.id = p.service_id;";
                        $query_run = mysqli_query($conn,$sql);
                        $service_tab = mysqli_num_rows($query_run) > 0;

                        if($service_tab)
                        {
                        while($row = mysqli_fetch_array($query_run))
                        {
                            ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($count == '1') { echo 'active show';}?>" data-bs-toggle="tab" href="#tab-<?=$row['service_id']?>"><?=$row['title']?></a>
                        </li>
                        <?php $count++; ?>
                        <?php
                            }
                        }
                        ?>
                        </ul>
                    </div>
                    <div class="col-lg-9 mt-4 mt-lg-0">
                        <div class="tab-content">
                        <?php
                        $count = 1;
                        $sql = "SELECT s.id,s.title,s.image,p.service_id,p.procedures,p.price FROM services as s INNER JOIN procedures as p ON s.id = p.service_id;";
                        $query_run = mysqli_query($conn,$sql);

                        while($row = mysqli_fetch_array($query_run))
                        {
                            ?>
                        <div class="tab-pane <?php if($count == '1') { echo 'active show';}?>" id="tab-<?=$row['service_id']?>">
                            <div class="row">
                            <div class="col-lg-8 details order-2 order-lg-1">
                                <h3><?=$row['title']?></h3>
                                <table class="table table-borderless" style="width:100%;">
                                <thead>
                                    <tr>
                                    <th>Particular</th>
                                    <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $prod = $row['service_id'];
                                    $sql2 = "SELECT * FROM procedures WHERE service_id = '$prod'";
                                    $query_run2 = mysqli_query($conn, $sql2);
                                    
                                    while($data = mysqli_fetch_array($query_run2)){?>
                                    <tr>
                                    <td><?=$data['procedures']?></td>
                                    <td>$ <?=$data['price']?> </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                </table>
                            </div>
                            <div class="col-lg-4 text-center order-1 order-lg-2">
                                <img src="upload/service/<?=$row['image']?>" alt="" class="img-fluid">
                            </div>
                            </div>
                            <?php $count++; ?>
                        </div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php 
include('main/footer.php');
include('main/scripts.php');
?>