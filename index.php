<?php
include('admin/config/dbconn.php');
include('main/header.php');
include('main/topbar.php');
?>
<!-- ======= Hero Section ======= -->
<section id="hero"class="d-flex align-items-center">
  <div class="container">
    <h1 style="color: white;">Bienvenidos A <?= $system_name ?> </h1>
    <h2 style="color: white;">Transformando Cuerpos, Restaurando Confianza: Tu Destino hacia una Movilidad sin Límites</h2>
    <a href="#about" class="btn-get-started scrollto">comencemos</a>
  </div>
</section><!-- End Hero -->




<main id="main">

  <!-- ======= Why Us Section ======= -->
  <section id="why-us" class="why-us">
    <div class="container">

      <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
          <div class="content">
            <h3>¿Por qué elegir? <?= $system_name ?>?</h3>
            <p>
            Optar por Rehabilitación con A.M.P te ofrece una experiencia excepcional con atención personalizada y tecnología avanzada. Nuestro enfoque holístico garantiza una recuperación completa, en un ambiente acogedor. Tus avances son medibles, y te acompañamos en cada paso hacia una movilidad sin límites. ¡Confía en nosotros para ser tu socio en el camino hacia un bienestar duradero!
            </p>
          </div>
        </div>
        <div class="col-lg-8 d-flex align-items-stretch">
          <div class="icon-boxes d-flex flex-column justify-content-center">
            <div class="row">
              <div class="col-xl-4 d-flex align-items-stretch">
                <div class="icon-box mt-4 mt-xl-0">
                  <i class="bi bi-emoji-smile"></i>
                  <h4>A - Actitud</h4>
                  <p>Enfocamos cada tratamiento con una Actitud proactiva hacia tu bienestar. Creemos que una actitud positiva es esencial para enfrentar los desafíos de la rehabilitación y lograr resultados efectivos.</p>
                </div>
              </div>
              <div class="col-xl-4 d-flex align-items-stretch">
                <div class="icon-box mt-4 mt-xl-0">
                <i class="bi bi-lightbulb"></i>

                  <h4>M - Mente</h4>
                  <p>Tener una mente sana y equilibrada es un requisito fundamental para poder llevar un buen tratamiento físico. Por ello no solo nos centramos en el tratamiento físico, sino que también promovemos un entorno que nutre tu salud mental, reconociendo la conexión esencial entre cuerpo y mente.</p>
                </div>
              </div>
              <div class="col-xl-4 d-flex align-items-stretch">
                <div class="icon-box mt-4 mt-xl-0">
                  <i class="bi bi-heart-fill"></i>

                  <h4>P - Positiva</h4>
                  <p>Refleja nuestro enfoque optimista hacia las posibilidades de recuperación. En Rehabilitación A.M.P, creemos en la capacidad de mejorar y superar limitaciones, trabajando juntos hacia un futuro más saludable y activo.</p>
                </div>
              </div>
            </div>
          </div><!-- End .content-->
        </div>
      </div>

    </div>
  </section><!-- End Why Us Section -->

  <!-- ======= About Section ======= -->
  <section id="about" class="about">
    <div class="container-fluid">
      <div class="row">
        <?php
        $sql = "SELECT * FROM header";
        $query_run = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($query_run)) { ?>
          <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch position-relative" style="background:url('upload/<?= $row['image'] ?>') center center no-repeat;background-size: cover;min-height: 600px;">
          </div>

          <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
            <h3><?= $row['title'] ?></h3>
            <p style="font-size:22px;"><?= $row['content'] ?></p>
          <?php } ?>

          </div>
      </div>

    </div>
  </section><!-- End About Section -->

  <!-- ======= Services Section ======= -->
  <section id="services" class="services">
    <div class="container">

      <div class="section-title">
        <h2>Servicio</h2>
        <p>En Rehabilitación A.M.P, nuestro servicio se distingue por ofrecer cuidados fisioterapéuticos personalizados de la más alta calidad. Nos dedicamos a brindar una experiencia única, donde cada paciente es tratado con atención individualizada y reciben servicios que van más allá de la convencionalidad</p>
      </div>

      <div class="row">

        <?php
        $sql = "SELECT * FROM services";
        $query_run = mysqli_query($conn, $sql);
        $check_services = mysqli_num_rows($query_run) > 0;

        if ($check_services) {
          while ($row = mysqli_fetch_array($query_run)) {
        ?>
            <div class="col-lg-4 col-md-6 align-items-stretch mt-4 ">
              <div class="card border-0">
                <div class="card-body icon-box">
                  <div class="icon"><a href="our-services.php?title=<?= $row['title'] ?>"><img src="upload/service/<?= $row['image'] ?>" class="img-fluid"></a></div>
                  <h4><a href="our-services.php?title=<?= $row['title'] ?>"><?= $row['title'] ?></a></h4>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<h5> No Record Found</h5>";
        } ?>

      </div>

    </div>
  </section><!-- End Services Section -->


  <!-- ======= Appointment Section ======= -->
  <section id="appointment" class="appointment section-bg">
    <div class="container">

      <div class="section-title">
        <h2>Misión</h2>
        <p> Nuestra Misión es ayudar a todas las personas que necesitan aliviar sus dolencias o mejorar sus carencias físicas sin importar su etnia, estatus social, raza o sexo.</p>
      </div>

      <form action="forms/appointment.php" method="post" role="form" class="php-email-form">
        <div class="mb-3">
          <div class="loading">Loading</div>
          <div class="error-message"></div>
          <div class="sent-message">Your appointment request has been sent successfully. Thank you!</div>
        </div>
        <?php
        if (isset($_SESSION['auth'])) {
          if ($_SESSION['auth_role'] == "patient") {
        ?>
            <div class="text-center"><a href="patient/request-appointment.php" class="appointment-btn" style="font-size:23px;"><span class="d-none d-md-inline"></span>Make an Appointment</a></div>
          <?php
          }
        } else {
          ?>
          <div class="text-center"><a href="patient/request-appointment.php" class="appointment-btn" style="font-size:23px;"><span class="d-none d-md-inline"></span>Make an Appointment</a></div>
        <?php
        }

        ?>

      </form>

    </div>
  </section><!-- End Appointment Section -->

  <section id="doctors" class="doctors">
    <div class="container">

      <div class="section-title">
        <h2>Visión</h2>
        <p>Con R.A.M.P (Rehabilitación con de Actitud de Mente Positiva), alcanzar a ser uno de las mejores Centros de Rehabilitación Física del País no es solamente una meta, si no, una forma de poder mostrarle a las personas que la rehabilitación física con un profesional entrenado es mucho más eficiente para mejorar sus dolencias y padecimientos físicos. </p>
      </div>

      <div class="row">
        <?php
        $count = 1;
        $sql = "SELECT f.description,f.image,d.name,d.specialty FROM featured f INNER JOIN tbldoctor d ON f.dentist_id = d.id";
        $query_run = mysqli_query($conn, $sql);
        $doctors = mysqli_num_rows($query_run) > 0;

        if ($doctors) {
          while ($row = mysqli_fetch_array($query_run)) {
        ?>

            <div class="col-lg-6 <?php if ($count > '1') {
                                    echo 'mt-4 mt-lg-0';
                                  } ?>">
              <div class="member d-flex align-items-start">
                <div class="pic"><img src="admin/assets/dist/img/featured-dentist/<?= $row['image'] ?>" class="img-fluid" alt=""></div>
                <div class="member-info">
                  <h4><?= $row['name'] ?></h4>
                  <span><?= $row['specialty'] ?></span>
                  <p><?= $row['description'] ?></p>
                </div>
              </div>
              <?php $count++; ?>
            </div>
        <?php
          }
        }
        ?>

      </div>

    </div>
  </section>
  <section id="testimonials" class="testimonials">
    <div class="container">
      <div class="section-title">
        <h2>Opinión de nuestros Paciendes <?= $system_name ?></h2>
        <p>Nuestros clientes satisfechos comparten su experiencia en <?= $system_name ?>.</p>
      </div>

      <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper-wrapper">
          <?php
          $sql = "SELECT * FROM reviews WHERE status='Active'";
          $query_run = mysqli_query($conn, $sql);
          $check_services = mysqli_num_rows($query_run) > 0;

          if ($check_services) {
            while ($row = mysqli_fetch_array($query_run)) { ?>
              <div class="swiper-slide">
                <div class="testimonial-wrap">
                  <div class="testimonial-item">
                    <img src="admin/assets/dist/img/testimonials/<?= $row['image'] ?>" class="testimonial-img" alt="">
                    <h3><?= $row['name'] ?></h3>
                    <h4><?= $row['designation'] ?></h4>
                    <p>
                      <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                      <?= $row['review'] ?>
                      <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                    </p>
                  </div>
                </div>
              </div>
          <?php }
          } ?>

        </div>
        <div class="swiper-pagination"></div>
      </div>

    </div>
  </section>
  <section id="gallery" class="gallery">
    <div class="container">

      <div class="section-title">
        <h2>Gallery</h2>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row no-gutters">
        <?php
        $sql = "SELECT * FROM gallery where status='Active'";
        $query_run = mysqli_query($conn, $sql);
        $check_services = mysqli_num_rows($query_run) > 0;

        if ($check_services) {
          while ($row = mysqli_fetch_array($query_run)) { ?>
            <div class="col-lg-3 col-md-4">
              <div class="gallery-item">
                <a href="admin/assets/dist/img/gallery/<?= $row['image'] ?>" class="galelry-lightbox">
                  <img src="admin/assets/dist/img/gallery/<?= $row['image'] ?>" alt="" class="img-fluid">
                </a>
              </div>
            </div>
        <?php }
        } ?>

      </div>

    </div>
  </section><!-- End Gallery Section -->
 <!-- Messenger Chat Plugin Code -->
  <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "102712495430970");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v15.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>


    <!-- Agrega la biblioteca Draggable (puedes cambiar la versión según tus necesidades) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/draggable/1.0.0-beta.11/draggable.bundle.legacy.min.js"></script>

<!-- Widget de chat de WhatsApp -->
<div id="whatsapp-widget" class="draggable">
  <a href="https://api.whatsapp.com/send?phone=+593969950554&text=Hola%20<?= $system_name ?>" target="_blank" rel="noopener">
    <img src="whatsapp.png" alt="WhatsApp">
  </a>
</div>

<!-- Script para inicializar la funcionalidad de arrastrar con Draggable -->
<script>
  // Espera a que el DOM esté listo
  document.addEventListener('DOMContentLoaded', function () {
    // Inicializa Draggable en el elemento con ID 'whatsapp-widget'
    new Draggable(document.getElementById('whatsapp-widget'), {
      allowNativeTouchScrolling: false, // Deshabilita el desplazamiento táctil nativo durante el arrastre
      bounds: 'html', // Limita el área de arrastre al área del documento HTML
    });
  });
  
</script>
<!-- Agrega los estilos CSS para el widget de chat de WhatsApp -->
<style>
  #whatsapp-widget {
  position: fixed;
  bottom: 20px;
  right: 20px;
  width: 60px;
  height: 60px;
  background-color: #25d366;
  border-radius: 50%;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  cursor: grab; /* Cambia el cursor a 'agarre' para indicar que el elemento es arrastrable */
}

  #whatsapp-widget a {
    display: block;
    width: 100%;
    height: 100%;
  }

  #whatsapp-widget img {
    width: 100%;
    height: auto;
  }
  #whatsapp-widget:active {
  cursor: grabbing; /* Cambia el cursor a 'agarrando' durante el arrastre */
}
</style>

  <?php
  include('main/footer.php');
  include('main/scripts.php');
  ?>