<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Tablero de control</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Tablero de control</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <?php
            if(isset($_SESSION['status']))
            {
              ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['status'];?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"></span>
                </button>
              </div>
              <?php
                unset($_SESSION['status']);
            }
          ?>   
      <div class="row">
        <div class="col-lg-4 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?php
                $sql = "SELECT id FROM tblpatient ORDER BY id";
                $query_run = mysqli_query($conn,$sql);

                $row = mysqli_num_rows($query_run);
                echo $row;
              ?></h3>
              <p>Pacientes</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-friends"></i>
            </div>
            <a href="patients.php" class="small-box-footer">
              Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-4 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?php
                $sql = "SELECT id FROM tblappointment WHERE schedtype='Walk-in Schedule' ORDER BY id";
                $query_run = mysqli_query($conn,$sql);

                $row = mysqli_num_rows($query_run);
                echo $row;
              ?></h3>
              <p>Citas</p>
            </div>
            <div class="icon">
              <i class="fas fa-calendar-check"></i>
            </div>
            <a href="appointment.php" class="small-box-footer">
              Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-4 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?php
                $sql = "SELECT id FROM tblappointment WHERE schedtype='Online Schedule' ";
                $query_run = mysqli_query($conn,$sql);

                $row = mysqli_num_rows($query_run);
                echo $row;
              ?></h3>
              <p>Citas en línea</p>
            </div>
            <div class="icon">
            <i class="fas fa-globe"></i>
            </div>
            <a href="online-request.php" class="small-box-footer">
              Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="sticky-top mb-3">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h4 class="card-title">Próximas citas</h4>
                </div>
                <div class="card-body">
                  <div id="external-events">
                    <div class="col">
                  <div class="info-box">
                    <div class="info-box-content">
                      <h3 class="text-center">
                        <?php
                          $sql = "SELECT status FROM tblappointment WHERE status='Confirmed' ";
                          $query_run = mysqli_query($conn,$sql);

                          $row = mysqli_num_rows($query_run);
                          echo $row;
                        ?>
                      </h3>
                      <span class="info-box-text text-center">Confirmadas</span>                      
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="info-box">
                    <div class="info-box-content">
                      <h3 class="text-center">
                      <?php
                          $sql = "SELECT status FROM tblappointment WHERE status='Pending' ";
                          $query_run = mysqli_query($conn,$sql);
                          
                          $row = mysqli_num_rows($query_run);
                          echo $row;
                        ?>
                      </h3>
                      <span class="info-box-text text-center">Pendientes</span>      
                    </div>
                  </div>
                </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <div class="card-body p-0">
                            <!-- EL CALENDARIO -->
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>              
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
</div>  
<div class="wrapper">

      <div class="modal fade" id="DetallesCita">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="modalTitle" class="modal-title">Detalles de la cita</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div id="modalBody" class="modal-body">
              <div class="verdetalles">

              </div>
            </div>
            <div class="modal-footer">           
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>             
            </div>
        </div>
      </div>
    </div>
<?php include('includes/scripts.php');?> 
<?php
$query = $conn->query("SELECT a.*, CONCAT(p.fname,' ',p.lname) AS pname, CONCAT(a.schedule, ' ', a.starttime) as timestamp, CONCAT(a.schedule, ' ', a.endtime) as enddate FROM tblappointment a INNER JOIN tblpatient p WHERE p.id = a.patient_id AND status = 'Confirmed' ");
$sched_arr = json_encode($query->fetch_all(MYSQLI_ASSOC));
?>
<script>
  $(function () {

    $('.userdata').click(function (e) { 
      var clientTag = document.getElementById("client-label");
      var requiredId = clientTag.getAttribute('data-id');
      window.location.href = 'edit-appointment.php?id=' + requiredId;
      
    });

    function ini_events(ele) {
      ele.each(function () {

        var eventObject = {
          title: $.trim($(this).text()) 
        }

        $(this).data('eventObject', eventObject)

        $(this).draggable({
          zIndex        : 1070,
          revert        : true, 
          revertDuration: 0  
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    var scheds = $.parseJSON('<?php echo ($sched_arr) ?>');

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
        };
      }
    });

    var calendar = new FullCalendar.Calendar(calendarEl, {
          themeSystem: 'bootstrap',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
          },

      events:function(event,successCallback){
          var events = []
          Object.keys(scheds).map(k=>{
              events.push({
                  id             : scheds[k].id,
                  title          : scheds[k].pname,
                  start          : moment(scheds[k].timestamp).format('YYYY-MM-DD[T]HH:mm'),
                  end            : moment(scheds[k].enddate).format('hh:mm'),
                  backgroundColor: scheds[k].bgcolor, 
                  borderColor    :scheds[k].bgcolor 
                  });
          })
          successCallback(events)

      },
          eventClick:  function(info) {
            var userid =  info.event.id;        

            $.ajax({
              type: "post",
              url: "calendar_action.php",
              data: {userid:userid},
              success: function (response) {
                $('.verdetalles').html(response);
                $("#DetallesCita").modal();
              }
            });
            },


        
      navLinks: true, 
      businessHours: [
        {
          daysOfWeek: [1,2,3,4,5,6],
          startTime: '09:00',
          endTime: '18:00'
        }
      ], // display business hours
      editable: true,
      selectable: true,
      droppable : false, //
    });

    calendar.render();

    var currColor = '#3c8dbc' //Red by default
    // Color chooser button
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      // Save color
      currColor = $(this).css('color')
      // Add color effect to button
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color'    : currColor
      })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      // Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      // Create events
      var event = $('<div />');
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.text(val)
      $('#external-events').prepend(event)

      // Add draggable funtionality
      ini_events(event)

      // Remove event from text input
      $('#new-event').val('')
    })
  })
</script>
<?php include('includes/footer.php');?>
