<?php
include('admin/config/dbconn.php');
include('main/header.php');
include('main/topbar.php');
?>
<main id="main">
  <section class="breadcrumbs">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <h2>Informaciòn de Contacto</h2>
        <ol>
          <li><a href="index.php">Inicio</a></li>
          <li>Contacto</li>
        </ol>
      </div>
    </div>
  </section>
  <section id="contact" class="contact">
  <div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            if (isset($success)) {
                echo 'Thanks';
            }
            ?>
            <h4 class="mb-4 text-primary">Contacto</h4>
            <p class="description">En Fisioterapia A.M.P, estamos comprometidos a brindarte diversas opciones para que nos contactes y recibas la atención que necesitas. Estamos aquí para responder a tus preguntas, proporcionar información adicional y coordinar tus citas de manera conveniente. Contáctanos de la siguiente manera:</p>

            <!-- Información de Contacto -->
            <div>
                <h5>Información de Contacto:</h5>
                <ul>
                    <li>Página Web: <a href="http://www.fisioterapiaamp.com" target="_blank">www.fisioterapiaamp.com</a></li>
                    <li>Número de Teléfono: <a href="tel:+XXXXXXXXXX">+XXXXXXXXXX</a></li>
                    <li>Correo Electrónico: <a href="mailto:info@fisioterapiaamp.com">info@fisioterapiaamp.com</a></li>
                </ul>
            </div>

            <!-- Redes Sociales -->
            <div>
                <h5>Redes Sociales:</h5>
                <ul>
                    <li>Facebook: <a href="https://www.facebook.com/fisioterapiaamp" target="_blank">Fisioterapia A.M.P</a></li>
                    <li>Twitter: <a href="https://twitter.com/Fisio_AMP" target="_blank">@Fisio_AMP</a></li>
                    <li>Instagram: <a href="https://www.instagram.com/fisioterapiaamp/" target="_blank">@fisioterapiaamp</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


    <div>
      <iframe style="border:0; width: 100%; height: 350px;" src="<?= $map ?>" frameborder="0" allowfullscreen></iframe>
    </div>

    <div class="container">
      <div class="row mt-5">

        <div class="col-lg-4">
          <div class="info">
            <div class="address">
              <i class="bi bi-geo-alt"></i>
              <h4>Location:</h4>
              <p><?= $address ?></p>
            </div>

            <div class="email">
              <i class="bi bi-envelope"></i>
              <h4>Email:</h4>
              <p><?= $email ?></p>
            </div>

            <div class="phone">
              <i class="bi bi-phone"></i>
              <h4>Call:</h4>
              <p><?= $mobile ?></p>
            </div>

          </div>

        </div>

        <div class="col-lg-8 mt-5 mt-lg-0">
          <form id="frmDemo" class="php-email-form" method="post">
            <div class="row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" id="name" placeholder="Your Name" class="form-control" required />
              </div>
              <div class="col-md-6 form-group mt-3 mt-md-0">
                <input type="email" name="email" id="email" placeholder="Your Email" class="form-control" required />
              </div>
            </div>
            <div class="form-group mt-3">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
            </div>
            <div class="form-group mt-3">
              <textarea class="form-control" name="message" id="message" rows="5" placeholder="Message" required></textarea>
            </div>
            <div class="my-3">
              <div class="alert alert-danger" role="alert" id="error_message" style="display:none;"></div>
              <div class="alert alert-success" role="alert" id="success_message" style="display:none;"></div>
            </div>
            <div class="text-center"><button name="btn-submit" id="btn-submit" type="submit">Send Message</button></div>
          </form>
        </div>

      </div>

    </div>
  </section>

</main>
<?php
include('main/footer.php');
include('main/scripts.php');
?>