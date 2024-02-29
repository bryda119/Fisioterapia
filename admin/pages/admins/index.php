<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <div class="modal fade" id="AddAdminModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Agregar Administrador</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="admin_action.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Nombres y Apellidos</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="fname" class="form-control" pattern="[a-zA-Z'-'\s]*" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Direccion</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="address" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Numero Celular</label>
                    <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="phone" id="phone" value="+593" onkeydown="preventDeletion(event)" onkeypress="preventDeletion(event)" oninput="limitNumbers(event)" pattern="^\+593\d{9}$" required>

                          <script>
                          function preventDeletion(event) {
                              var phoneInput = document.getElementById("phone");

                              // Obtener el valor actual del campo
                              var currentValue = phoneInput.value;

                              // Obtener la posición del cursor
                              var cursorPosition = phoneInput.selectionStart;

                              // Verificar si el usuario intenta borrar el "+593"
                              if (event.key === "Backspace" && cursorPosition <= 4) {
                                  event.preventDefault();
                              }
                          }

                          function limitNumbers(event) {
                              var phoneInput = document.getElementById("phone");

                              // Obtener el valor actual del campo
                              var currentValue = phoneInput.value;

                              // Asegurarse de que el valor comienza con "+593"
                              if (!currentValue.startsWith("+593")) {
                                  phoneInput.value = "+593";
                              }

                              // Limitar la longitud total a 13 caracteres (incluido el "+593")
                              if (currentValue.length >= 13) {
                                  event.preventDefault();
                              }
                          }
                          </script>

                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Email</label>
                    <span class="text-danger">*</span>
                    <input id="email" type="email" name="email" pattern="^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$" class="form-control" required />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Password</label>
                    <span class="text-danger">*</span>
                    <input type="password" id="password" name="password" class="form-control" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters and one special character" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Confirmar Password</label>
                    <span class="text-danger">*</span>
                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="doc_image">Subir Image</label>
                    <input type="file" name="doc_image" id="doc_image">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" id="submit_button" name="insertadmin" class="btn btn-primary">Registar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="ViewAdminModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Informacion del Administrador</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="admin_viewing_data">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="EditAdminModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Editar Admin</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="admin_action.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <input type="hidden" name="edit_id" id="edit_id">
                  <div class="form-group">
                    <label>Nombres y Apellidos</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="fname" id="edit_fname" class="form-control" pattern="[a-zA-Z'-'\s]*" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Direccion</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="address" id="edit_address" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Numero Celular</label>
                    <span class="text-danger">*</span>
                    <input type="text" id="edit_phone" name="phone" class="form-control" value="+593" onkeydown="preventDeletion(event)" onkeypress="preventDeletion(event)" oninput="limitNumbers(event)" pattern="^\+593\d{9}$" required>

                        <script>
                        function preventDeletion(event) {
                            var phoneInput = document.getElementById("edit_phone");

                            // Obtener el valor actual del campo
                            var currentValue = phoneInput.value;

                            // Obtener la posición del cursor
                            var cursorPosition = phoneInput.selectionStart;

                            // Verificar si el usuario intenta borrar el "+593"
                            if (event.key === "Backspace" && cursorPosition <= 4) {
                                event.preventDefault();
                            }
                        }

                        function limitNumbers(event) {
                            var phoneInput = document.getElementById("edit_phone");

                            // Obtener el valor actual del campo
                            var currentValue = phoneInput.value;

                            // Asegurarse de que el valor comienza con "+593"
                            if (!currentValue.startsWith("+593")) {
                                phoneInput.value = "+593";
                            }

                            // Limitar la longitud total a 13 caracteres (incluido el "+593")
                            if (currentValue.length >= 13) {
                                event.preventDefault();
                            }
                        }
                        </script>
                  </div>
                </div>
                <div class="col-sm-6 auto">
                  <div class="form-group">
                    <label>Email</label>
                    <span class="text-danger">*</span>
                    <input type="email" name="email" id="edit_email" class="form-control email_id" pattern="^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$" class="form-control" required>
                    <span class="email_error text-danger"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <input type="hidden" id="edit_password" name="edit_password" class="form-control" required>
                <input type="hidden" id="edit_confirmPassword" name="edit_confirmPassword" class="form-control" required>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="doc_image">Subir Imagen</label>
                    <input type="file" id="edit_docimage" name="edit_docimage" />
                    <input type="hidden" name="old_image" id="old_image" />
                    <div id="uploaded_image"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" name="updateadmin" class="btn btn-primary">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="DeleteAdminModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Eliminar Admin</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="admin_action.php" method="POST">
            <div class="modal-body">
              <input type="hidden" name="delete_id" id="delete_id">
              <p> ¿Desea eliminar estos datos?</p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" name="deletedata" class="btn btn-primary ">Eliminar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Administrador</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard/">Inicio</a></li>
                <li class="breadcrumb-item active">Administrador</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <?php include('../../message.php'); ?>
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Lista de Administradores</h3>
                  <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddAdminModal">
                    <i class="fa fa-plus"></i> &nbsp;&nbsp;Agregar Administrador</button>
                </div>
                <div class="card-body">
                  <table id="admin_table" class="table table-borderless table-hover" style="width:100%;">
                    <thead class="bg-light">
                      <tr>
                        <th class="text-center">Foto</th>
                        <th class="export">Nombres</th>
                        <th class="export" width="10%">Direccion</th>
                        <th class="export">Contacto</th>
                        <th class="export">Email</th>
                        <th class="export" width="5%">Status</th>
                        <th>Boton de Acciones</th>
                      </tr>
                    </thead>
                    <tbody><?php
                            $i = 1;
                            $user = $_SESSION['auth_user']['user_id'];
                            $sql = "SELECT * FROM tbladmin";
                            $query_run = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_array($query_run)) { ?>
                        <tr>
                          <td style="text-align: center;" width="10%"><img src="../../../upload/admin/<?= $row['image'] ?>" class="img-thumbnail img-circle" width="50" alt=""></td>
                          <td><?php echo $row['name']; ?></td>
                          <td><?php echo $row['address']; ?></td>
                          <td><?php echo $row['phone']; ?></td>
                          <td><?php echo $row['email']; ?></td>
                          <td><?php
                              if ($row['id'] == $user) {
                              } else {
                                if ($row['status'] == 1) {
                                  echo '<button data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" class="btn btn-sm btn-primary activatebtn">Active</button>';
                                } else {
                                  echo '<button data-id="' . $row['id'] . '" data-status="' . $row['status'] . '" class="btn btn-sm btn-danger activatebtn">Inactive</button>';
                                }
                              }
                              ?>
                          </td>
                          <td>
                            <button data-id="<?php echo $row['id']; ?>" class="btn btn-sm btn-info editAdminbtn"><i class="fas fa-edit"></i></button>
                            <input type="hidden" name="del_image" value="<?php echo $row['image']; ?>">
                            <button data-id="<?php echo $row['id']; ?>" class="btn btn-danger btn-sm deleteAdminbtn"><i class="far fa-trash-alt"></i></button>
                          </td>
                        </tr>
                      <?php
                            }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th class="search">Nombres</th>
                        <th class="search">Direccion</th>
                        <th class="search">Contacto</th>
                        <th class="search">Email</th>
                        <th class="search">Status</th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('../../includes/scripts.php'); ?>
  <script>
    $(document).ready(function() {
      $('#admin_table tfoot th.search').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" class="search-input form-control form-control-sm"/>');
      });
      var table = $('#admin_table').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "responsive": true,
        "searching": true,
        "paging": true,
        "buttons": [{
            extend: 'copyHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-clipboard"></i>  Copy',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'csvHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-csv"></i>  CSV',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'excel',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-excel"></i>  Excel',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'pdfHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-pdf"></i>  PDF',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'print',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-print"></i>  Print',
            exportOptions: {
              columns: '.export'
            }
          }
        ],
        initComplete: function() {
          // Apply the search
          this.api().columns().every(function() {
            var that = this;

            $('input', this.footer()).on('keyup change clear', function() {
              if (that.search() !== this.value) {
                that
                  .search(this.value)
                  .draw();
              }
            });
          });
        }
      });

      $(document).on('click', '.viewAdminbtn', function() {
        var userid = $(this).data('id');

        $.ajax({
          url: 'admin_action.php',
          type: 'post',
          data: {
            'checking_viewAdmintbtn': true,
            'user_id': userid,
          },
          success: function(response) {

            $('.admin_viewing_data').html(response);
            $('#ViewAdminModal').modal('show');
          }
        });
      });

      //Admin Edit Modal
      $(document).on('click', '.editAdminbtn', function() {
        var userid = $(this).data('id');

        $.ajax({
          type: "POST",
          url: "admin_action.php",
          data: {
            'checking_editAdminbtn': true,
            'user_id': userid,
          },
          success: function(response) {
            $.each(response, function(key, value) {
              $('#edit_id').val(value['id']);
              $('#edit_fname').val(value['name']);
              $('#edit_address').val(value['address']);
              $('#edit_phone').val(value['phone'].substring(3));
              $('#edit_email').val(value['email']);
              $('#uploaded_image').html('<img src="../../../upload/admin/' + value['image'] + '" class="img-fluid img-thumbnail" width="120" />');
              $('#old_image').val(value['image']);
              $('#edit_password').val(value['password']);
              $('#edit_confirmPassword').val(value['password']);
            });

            $('#EditAdminModal').modal('show');
          }
        });
      });
      //Admin Delete Modal
      $(document).on('click', '.deleteAdminbtn', function() {

        var user_id = $(this).data('id');
        $('#delete_id').val(user_id);
        $('#DeleteAdminModal').modal('show');
      });

      $(document).on('click', '.activatebtn', function() {
        var userid = $(this).data('id');
        var status = $(this).data('status');
        var next_status = 'Active';
        if (status == 1) {
          next_status = 'Inactive';
        }

        if (confirm("Are you sure you want to " + next_status + " it?")) {
          $.ajax({
            type: "post",
            url: "admin_action.php",
            data: {
              'change_status': true,
              'user_id': userid,
              'status': status,
              'next_status': next_status
            },
            success: function(response) {
              location.reload();
            }
          });
        }
      });


    });
  </script>


  <?php include('../../includes/footer.php'); ?>