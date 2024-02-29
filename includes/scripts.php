<script src="admin/assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="admin/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	$.widget.bridge('uibutton', $.ui.button)
</script>
<script>
</script>
<!-- Bootstrap 4 -->
<script src="admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="admin/assets/plugins/chart.js/Chart.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="admin/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="admin/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="admin/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="admin/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="admin/assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="admin/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="admin/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="admin/assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="admin/assets/plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="admin/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="admin/assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="admin/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- SweetAlert2 -->
<script src="admin/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="admin/assets/plugins/toastr/toastr.min.js"></script>
<!-- Datetimepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="admin/assets/plugins/moment/moment.min.js"></script>
<script src="admin/assets/plugins/fullcalendar/main.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<!-- AdminLTE App -->
<script src="admin/assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="admin/assets/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="admin/assets/dist/js/pages/dashboard.js"></script>
<script src="admin/assets/plugins/inputmask/jquery.inputmask.bundle.min.js"></script>
<!--Custom JS -->
<script src="admin/assets/dist/js/custom.js"></script>
<script>
	$(document).ready(function() {

		function load_unseen_notification(view = '') {
			var user_id = $('#session_id').val();
			$.ajax({
				url: "fetch_user_notification.php",
				method: "POST",
				data: {
					view: view,
					'user_id': user_id
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
			load_unseen_notification();
		}, 5000);


	});
</script>