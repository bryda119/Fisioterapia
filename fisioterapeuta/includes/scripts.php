<script src="../admin/assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<!-- Bootstrap 4 -->
<script src="../admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../admin/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- ChartJS -->
<script src="../admin/assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<!-- DataTables  & Plugins -->
<script src="../admin/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../admin/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../admin/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../admin/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../admin/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../admin/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../admin/assets/plugins/jszip/jszip.min.js"></script>
<script src="../admin/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../admin/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../admin/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../admin/assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../admin/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../admin/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../admin/assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../admin/assets/plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../admin/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../admin/assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../admin/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- SweetAlert2 -->
<script src="../admin/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../admin/assets/plugins/toastr/toastr.min.js"></script>
<!-- Datetimepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="../admin/assets/plugins/moment/moment.min.js"></script>
<script src="../admin/assets/plugins/fullcalendar/main.js"></script>
<!-- AdminLTE App -->
<script src="../admin/assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../admin/assets/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../admin/assets/dist/js/pages/dashboard.js"></script>
<!-- Summernote -->
<script src="../admin/assets/plugins/summernote/summernote-bs4.min.js"></script>
<script src="../admin/assets/plugins/inputmask/jquery.inputmask.bundle.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(600, 0).slideUp(600, function() {
            $(this).remove();
        });
    }, 4000);
</script>

<script>
    $(document).ready(function() {
        $('#password').keyup(function() {

            if ($(this).val().length == 0) {
                $('.show_hide').hide();
            } else {
                $('.show_hide').show();
            }
        }).keyup();

        $('#password').keyup(function() {
            var password = $('#password').val();
            if (checkStrength(password) == false) {
                password.setCustomValidity('');

            }
        });

        function checkStrength(password) {
            var strength = 0;

            //If password contains both lower and uppercase characters, increase strength value.
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
                strength += 1;
                $('.low-upper-case').addClass('text-success');
                $('.low-upper-case i').removeClass('fa-exclamation-triangle').addClass('fa-check');
                $('#popover-password-top').addClass('hide');

            } else {
                $('.low-upper-case').removeClass('text-success');
                $('.low-upper-case i').addClass('fa-exclamation-triangle').removeClass('fa-check');
                $('#popover-password-top').removeClass('hide');
            }

            //If it has numbers and characters, increase strength value.
            if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
                strength += 1;
                $('.one-number').addClass('text-success');
                $('.one-number i').removeClass('fa-exclamation-triangle').addClass('fa-check');
                $('#popover-password-top').addClass('hide');

            } else {
                $('.one-number').removeClass('text-success');
                $('.one-number i').addClass('fa-exclamation-triangle').removeClass('fa-check');
                $('#popover-password-top').removeClass('hide');
            }

            //If it has one special character, increase strength value.
            if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
                strength += 1;
                $('.one-special-char').addClass('text-success');
                $('.one-special-char i').removeClass('fa-exclamation-triangle').addClass('fa-check');
                $('#popover-password-top').addClass('hide');

            } else {
                $('.one-special-char').removeClass('text-success');
                $('.one-special-char i').addClass('fa-exclamation-triangle').removeClass('fa-check');
                $('#popover-password-top').removeClass('hide');
            }

            if (password.length > 7) {
                strength += 1;
                $('.eight-character').addClass('text-success');
                $('.eight-character i').removeClass('fa-exclamation-triangle').addClass('fa-check');
                $('#popover-password-top').addClass('hide');

            } else {
                $('.eight-character').removeClass('text-success');
                $('.eight-character i').addClass('fa-exclamation-triangle').removeClass('fa-check');
                $('#popover-password-top').removeClass('hide');
            }

            // If value is less than 2

            if (strength < 2) {
                $('#result').removeClass()
                $('#password-strength').addClass('bg-danger');

                $('#result').addClass('text-danger').text('Very Weak');
                $('#password-strength').css('width', '10%');
            } else if (strength == 2) {
                $('#result').addClass('good');
                $('#password-strength').removeClass('bg-danger');
                $('#password-strength').addClass('bg-warning');
                $('#result').addClass('text-warning').text('Weak')
                $('#password-strength').css('width', '60%');
                return 'Weak'
            } else if (strength == 4) {
                $('#result').removeClass()
                $('#result').addClass('strong');
                $('#password-strength').removeClass('bg-success');
                $('#password-strength').addClass('bg-success');
                $('#result').addClass('text-success').text('Very Strong');
                $('#password-strength').css('width', '100%');

                return 'Strong'
            }
        }

        function load_unseen_notification(view = '') {
            var userid = $('#session_id').val();

            $.ajax({
                url: "fetch_notification.php",
                method: "POST",
                data: {
                    view: view,
                    'user_id': userid
                },
                dataType: "json",
                success: function(data) {
                    $('.dropdown-notif').html(data.notification);
                    if (data.unseen_notification > 0) {
                        $('.count').html(data.unseen_notification);
                    }
                }
            });
        }

        load_unseen_notification();

        $(document).on('click', '.notification', function() {
            $('.count').html('');
            load_unseen_notification('yes');
        });

        setInterval(function() {
            load_unseen_notification();;
        }, 5000);

    });
</script>
<script>
    $(document).ready(function() {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $(document).on('click', '.logoutbtn', function() {
            $('#logoutModal').modal('show');
        });
        $('#datepicker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: new Date(),
        })
        $('#edit_dob').datepicker({
            clearBtn: true,
            autoclose: true,
            endDate: new Date()
        })
    });
</script>

<script>
    function validatePassword() {
        var password = document.getElementById("password");
        var confirmPassword = document.getElementById("confirmPassword");
        if (password.value != confirmPassword.value) {
            confirmPassword.setCustomValidity("Password does not match");
        } else {
            confirmPassword.setCustomValidity('');
        }
        password.onchange = validatePassword();
        confirmPassword.onkeyup = validatePassword();
    }
</script>


<script>
    $(document).ready(function() {
        $('#example1').dataTable({
            "dom": 'Bfrtip',
            "buttons": [{
                extend: 'print',
                exportOptions: {
                    columns: '.export'
                },
            }, ],
            "paging": true,
            "blengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "initComplete": function() {
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
            },
        });
        $('#example1 tfoot th.search').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" class="search-input form-control form-control-sm"/>');
        });
        // $(".buttons-print").addClass( "btn btn-gradient-success btn-sm" );
        // $(".buttons-print").css("float", "left");
        $("#example1 > thead > tr > th:not(:last-child)").addClass("export");
        // $('#example').DataTable({
        //   "paging": true,
        //   "lengthChange": false,
        //   "searching": false,
        //   "ordering": true,
        //   "info": true,
        //   "autoWidth": false,
        //   "responsive": true,
        // });
    });
</script>