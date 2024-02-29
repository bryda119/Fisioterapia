<footer id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row">

        <div class="col-md-4 footer-contact">
          <h3><?= $system_name ?></h3>
          <p><?= $address ?> <br><br>
            <strong>Phone:</strong> <?= $mobile ?><br>
            <strong>Email:</strong> <?= $email ?><br>
          </p>
        </div>

        <div class="col-md-3 footer-links">
          <h4>Enlaces de interés</h4>
          <ul>
            <li> <a href="index.php">Inicio</a></li>
            <li> <a href="about-us.php">Nosotros</a></li>
            <li> <a href="patient/request-appointment.php">Hacer una Cita</a></li>
            <li> <a href="services-rates.php">Fees</a></li>
            <li> <a href="contact-us.php">Contacto</a></li>
          </ul>
        </div>


        <div class="col-md-3 footer-links">
          <h4>Servicios</h4>
          <ul>
            <?php
            $sql2 = "SELECT * FROM services";
            $query_run = mysqli_query($conn, $sql2);
            $check_services = mysqli_num_rows($query_run) > 0;

            if ($check_services) {
              while ($row2 = mysqli_fetch_array($query_run)) { ?>
                <li> <a href="our-services.php?title=<?= $row2['title'] ?>"><?= $row2['title'] ?></a></li>
            <?php }
            } else {
              echo "<h5> No Record Found</h5>";
            } ?>
          </ul>
        </div>

        <div class="col-md-1 footer-links">
          <h4>Social</h4>
          <ul>
            <a href="<?= $facebook ?>" class="facebook"><i class="bx bxl-facebook"></i></a>
          </ul>
        </div>

      </div>
    </div>
  </div>
</footer>

<!-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> -->
