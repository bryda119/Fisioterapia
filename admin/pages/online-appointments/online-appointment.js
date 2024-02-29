$(document).ready(function () {
  var table1 = $("#onlinetbl").DataTable({
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    processing: true,
    searching: true,
    paging: true,
    responsive: true,
    pagingType: "simple",
    buttons: [
      {
        extend: "copyHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-clipboard"></i>  Copy',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "csvHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-csv"></i>  CSV',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "excel",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-excel"></i>  Excel',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "pdfHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-pdf"></i>  PDF',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "print",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-print"></i>  Print',
        exportOptions: {
          columns: ".export",
        },
      },
    ],
    order: [[1, "desc"]],
    language: {
      search: "",
      searchPlaceholder: "Search...",
      emptyTable: "No results found",
    },
    ajax: {
      url: "online_rq_table1.php",
    },
    columns: [
      { data: "patient_name" },
      {
        data: "created_at",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      {
        data: "schedule",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      { data: "starttime" },
      { data: "endtime" },
      { data: "payment_option"},
      {
        data: "status",
        render: function (data, type, row) {
          if (data == "Confirmed") {
            return '<span class="badge badge-success">Confirmed</span>';
          } else if (data == "Pending") {
            return '<span class="badge badge-warning">Pending</span>';
          } else if (data == "Treated") {
            return '<span class="badge badge-primary">Treated</span>';
          } else if (data == "Reschedule") {
            return '<span class="badge badge-secondary">Reschedule</span>';
          } else {
            return '<span class="badge badge-danger">Cancelled</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          return (
            '<button type="button" data-id="' +
            row.patient_id +
            '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>'
          );
        },
      },
    ],
  });
  $("#onlinetbl tfoot th.search").each(function () {
    var title = $(this).text();
    $(this).html(
      '<input type="text" placeholder="Search ' +
        title +
        '" class="search-input form-control form-control-sm"/>'
    );
  });
});

$(document).ready(function () {
  var table2 = $("#pendingtbl").DataTable({
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    processing: true,
    searching: true,
    paging: true,
    responsive: true,
    pagingType: "simple",
    buttons: [
      {
        extend: "copyHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-clipboard"></i>  Copy',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "csvHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-csv"></i>  CSV',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "excel",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-excel"></i>  Excel',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "pdfHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-pdf"></i>  PDF',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "print",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-print"></i>  Print',
        exportOptions: {
          columns: ".export",
        },
      },
    ],
    order: [[1, "desc"]],
    language: {
      search: "",
      searchPlaceholder: "Search...",
      emptyTable: "No results found",
    },
    ajax: {
      url: "online_rq_table.php",
      type: "POST",
      data: {
        status: "Pending",
      },
    },
    columns: [
      { data: "patient_name" },
      {
        data: "created_at",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      {
        data: "schedule",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      { data: "starttime" },
      { data: "endtime" },
      { data: "payment_option" },
      {
        data: "status",
        render: function (data, type, row) {
          if (data == "Pending") {
            return '<span class="badge badge-warning">Pending</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          return (
            '<button type="button" data-id="' +
            row.patient_id +
            '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>'
          );
        },
      },
    ],
  });

  var table3 = $("#oconfirmedtbl").DataTable({
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    processing: true,
    searching: true,
    paging: true,
    responsive: true,
    pagingType: "simple",
    buttons: [
      {
        extend: "copyHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-clipboard"></i>  Copy',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "csvHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-csv"></i>  CSV',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "excel",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-excel"></i>  Excel',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "pdfHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-pdf"></i>  PDF',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "print",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-print"></i>  Print',
        exportOptions: {
          columns: ".export",
        },
      },
    ],
    order: [[1, "desc"]],
    language: {
      search: "",
      searchPlaceholder: "Search...",
      emptyTable: "No results found",
    },
    ajax: {
      url: "online_rq_table.php",
      type: "POST",
      data: {
        status: "Confirmed",
      },
    },
    columns: [
      { data: "patient_name" },
      {
        data: "created_at",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      {
        data: "schedule",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      { data: "starttime" },
      { data: "endtime" },
      { data: "payment_option" },
      {
        data: "status",
        render: function (data, type, row) {
          if (data == "Confirmed") {
            return '<span class="badge badge-success">Confirmed</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          return (
            '<button type="button" data-id="' +
            row.patient_id +
            '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>'
          );
        },
      },
    ],
  });
  var table4 = $("#otreatedtbl").DataTable({
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    processing: true,
    searching: true,
    paging: true,
    responsive: true,
    pagingType: "simple",
    buttons: [
      {
        extend: "copyHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-clipboard"></i>  Copy',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "csvHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-csv"></i>  CSV',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "excel",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-excel"></i>  Excel',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "pdfHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-pdf"></i>  PDF',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "print",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-print"></i>  Print',
        exportOptions: {
          columns: ".export",
        },
      },
    ],
    order: [[1, "desc"]],
    language: {
      search: "",
      searchPlaceholder: "Search...",
      emptyTable: "No results found",
    },
    ajax: {
      url: "online_rq_table.php",
      type: "POST",
      data: {
        status: "Treated",
      },
    },
    columns: [
      { data: "patient_name" },
      {
        data: "created_at",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      {
        data: "schedule",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      { data: "starttime" },
      { data: "endtime" },
      { data: "payment_option" },
      {
        data: "status",
        render: function (data, type, row) {
          if (data == "Treated") {
            return '<span class="badge badge-primary">Treated</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          return (
            '<button type="button" data-id="' +
            row.patient_id +
            '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>'
          );
        },
      },
    ],
  });
  var table5 = $("#ocancelledtbl").DataTable({
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    processing: true,
    searching: true,
    paging: true,
    responsive: true,
    pagingType: "simple",
    buttons: [
      {
        extend: "copyHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-clipboard"></i>  Copy',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "csvHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-csv"></i>  CSV',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "excel",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-excel"></i>  Excel',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "pdfHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-pdf"></i>  PDF',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "print",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-print"></i>  Print',
        exportOptions: {
          columns: ".export",
        },
      },
    ],
    order: [[1, "desc"]],
    language: {
      search: "",
      searchPlaceholder: "Search...",
      emptyTable: "No results found",
    },
    ajax: {
      url: "online_rq_table.php",
      type: "POST",
      data: {
        status: "Cancelled",
      },
    },
    columns: [
      { data: "patient_name" },
      {
        data: "created_at",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      {
        data: "schedule",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      { data: "starttime" },
      { data: "endtime" },
      { data: "payment_option" },
      {
        data: "status",
        render: function (data, type, row) {
          if (data == "Cancelled") {
            return '<span class="badge badge-danger">Cancelled</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          return (
            '<button type="button" data-id="' +
            row.patient_id +
            '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>'
          );
        },
      },
    ],
  });
  var table6 = $("#orescheduletbl").DataTable({
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    processing: true,
    searching: true,
    paging: true,
    responsive: true,
    pagingType: "simple",
    buttons: [
      {
        extend: "copyHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-clipboard"></i>  Copy',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "csvHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-csv"></i>  CSV',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "excel",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-excel"></i>  Excel',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "pdfHtml5",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="far fa-file-pdf"></i>  PDF',
        exportOptions: {
          columns: ".export",
        },
      },
      {
        extend: "print",
        className: "btn btn-outline-secondary btn-sm",
        text: '<i class="fas fa-print"></i>  Print',
        exportOptions: {
          columns: ".export",
        },
      },
    ],
    order: [[1, "desc"]],
    language: {
      search: "",
      searchPlaceholder: "Search...",
      emptyTable: "No results found",
    },
    ajax: {
      url: "online_rq_table.php",
      type: "POST",
      data: {
        status: "Reschedule",
      },
    },
    columns: [
      { data: "patient_name" },
      {
        data: "created_at",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      {
        data: "schedule",
        render: function (data, type, row) {
          return moment(data).format("DD-MMMM-YYYY");
        },
      },
      { data: "starttime" },
      { data: "endtime" },
      { data: "payment_option" },
      {
        data: "status",
        render: function (data, type, row) {
          if (data == "Reschedule") {
            return '<span class="badge badge-secondary">Reschedule</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          return (
            '<button type="button" data-id="' +
            row.patient_id +
            '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' +
            data +
            '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>'
          );
        },
      },
    ],
  });

  $(".nav-tabs a").on("shown.bs.tab", function (event) {
    var tabID = $(event.target).attr("data-target");
    if (tabID === "#all") {
      table1.columns.adjust().responsive.recalc();
    }
    if (tabID === "#pending") {
      table2.columns.adjust().responsive.recalc();
    }
    if (tabID === "#confirmed") {
      table3.columns.adjust().responsive.recalc();
    }
    if (tabID === "#treated") {
      table4.columns.adjust().responsive.recalc();
    }
    if (tabID === "#cancelled") {
      table5.columns.adjust().responsive.recalc();
    }
    if (tabID === "#reschedule") {
      table6.columns.adjust().responsive.recalc();
    }
  });

  $("#scheddate1").datepicker({});
  $("#scheddate2").datepicker({});

  $(".select2").select2();

  $("#selectedPatient").on("change", function () {
    var patientID = $("#selectedPatient").val();
    $("#preferredDentist").val("");
    $("#preferredDate").val("");
    $("#preferredDentist").select2({
      allowClear: true,
      placeholder: "Select Dentist",
      ajax: {
        url: "appointment_action.php",
        type: "GET",
        dataType: "json",
        delay: 250,
        data: function (params) {
          return {
            getDoctors: patientID,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
    });
    $("#preferredDate").select2({
      allowClear: true,
      placeholder: "Available Date",
      ajax: {
        url: "appointment_action.php",
        type: "GET",
        dataType: "json",
        delay: 250,
        data: function (params) {
          return {
            doctorIdDate: selectedDentistId,
            patientId: patientID,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
    });
  });

  $("#preferredDentist").on("change", function () {
    var selectedDentistId = $("#preferredDentist").val();
    var patientID = $("#selectedPatient").val();
    $("#preferredDate").val("");
    $("#preferredDate").select2({
      allowClear: true,
      placeholder: "Available Date",
      ajax: {
        url: "appointment_action.php",
        type: "GET",
        dataType: "json",
        delay: 250,
        data: function (params) {
          return {
            doctorIdDate: selectedDentistId,
            patientId: patientID,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
    });
  });

  $("#edit_dentist").on("change", function () {
    var selectedDentistId = $("#edit_dentist").val();
    var patientID = $("#edit_patient").val();
    $("#edit_sched").empty().trigger("change");
    $("#edit_schedTime").empty().trigger("change");
    $("#edit_sched").select2({
      allowClear: true,
      placeholder: "Available Date",
      ajax: {
        url: "online_action.php",
        type: "GET",
        dataType: "json",
        delay: 250,
        data: function (params) {
          return {
            doctorIdDate: selectedDentistId,
            patientId: patientID,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
    }).on('change', function(e) {
         var data = $(this).select2('data')[0]?? '';
         var infoValue = data.info ?? '';
      console.log(infoValue);
  
      var select2Config = {
        allowClear: true,
        placeholder: "Select Service"
      };
      
      if (infoValue == 30) {
        select2Config.minimumResultsForSearch = Infinity;
        select2Config.maximumSelectionLength = 1;
      } else if (infoValue == 60) {
        select2Config.minimumResultsForSearch = Infinity;
        select2Config.maximumSelectionLength = 2;
      } else if (infoValue == 120) {
        select2Config.minimumResultsForSearch = Infinity;
        select2Config.maximumSelectionLength = 4;
      } else if (infoValue == 180) {
        select2Config.minimumResultsForSearch = Infinity;
        select2Config.maximumSelectionLength = 6;
      }
      // // Update select2 configuration options for service select box
      $('#edit_reason').select2('destroy').select2(select2Config);
     });
  });
  $("#edit_sched").on("change", function () {
    var selectedSchedId = $("#edit_sched").val();
    var patientID = $("#edit_patient").val();
    $("#edit_schedTime").empty().trigger("change");
    $("#edit_schedTime").select2({
      allowClear: true,
      placeholder: "Available Timeslot",
      ajax: {
        url: "online_action.php",
        type: "POST",
        dataType: "json",
        delay: 250,
        data: function (params) {
          return {
            selectedDateId: selectedSchedId,
            patientId: patientID,
          };
        },
        processResults: function (response) {
          return {
            results: response,
          };
        },
        cache: true,
      },
    });
  });
  $(".select2").select2();
  $(".select2").on("select2:open", function () {
    $(".select2-selection__choice__remove").addClass("select2-remove-right");
  });
  $(".patient").select2({
    placeholder: "Select Patient",
    allowClear: true,
  });
  $(".treatment").select2({
    placeholder: "Select Treatment",
    allowClear: true,
  });

  $(".dentist").select2({
    placeholder: "Select Dentist",
    allowClear: true,
  });

  $("#preferredDate").select2({
    placeholder: "Available Date",
    allowClear: true,
  });
  $("#edit_reason").select2({
    placeholder: "Select Service",
    allowClear: true,
  });

  $("#edit_sched").select2({
    placeholder: "Select Date",
    allowClear: true,
  });
  $("#edit_schedTime").select2({
    placeholder: "Select Time",
    allowClear: true,
  });

  const colorBox = document.getElementById("edit_color");

  colorBox.addEventListener(
    "change",
    (event) => {
      const color = event.target.value;
      event.target.style.color = color;
    },
    false
  );

  $("#edit_status").on("change", function () {
    var val = $(this).val();
    if (this.value == "Confirmed") {
      $(".ck").prop("disabled", false);
    } else {
      $(".ck").prop("disabled", true);
      $("#customCheckbox3").prop("checked", false);
    }
  });

  $(document).on("click", ".viewbtn", function () {
    var userid = $(this).data("id");
    $.ajax({
      type: "GET",
      url: "online_action.php",
      data: {
        health_dec: true,
        user_id: userid,
      },
      success: function (response) {
        console.log(response);
        $(".view_form").html(response);
        $("#ViewModal").modal("show");
      },
    });
  });

  $(document).on("click", ".editbtn", function () {
    var schedid = $(this).data("id");
    $("#edit_sched").empty().trigger("change");
    $("#edit_schedTime").empty().trigger("change");

    $.ajax({
      type: "post",
      url: "online_action.php",
      data: {
        checking_editbtn: true,
        app_id: schedid,
      },
      success: function (response) {
        $("#edit_id").val(response["id"]);
        $("#edit_patient_id").val(response["patient_id"]);
        $("#edit_patient").val(response["patient_id"]);
        $("#edit_patient").select2().trigger("change");
        $("#edit_dentist").val(response["doc_id"]);
        $("#edit_dentist").select2().trigger("change");
        var services = response["reason"].split(",");
        $("#edit_reason").val(services);
        $("#edit_reason").trigger("change");
        $("#edit_status").val(response["status"]);
        $("#edit_color").val(response["bgcolor"]);
        $("#edit_schedule").val(response["schedule"]);
        var newOption = new Option(
          response["schedule"],
          response["sched_id"],
          true,
          false
        );
        $("#edit_sched").append(newOption).trigger("change");
        var newOpt = new Option(
          response["time"],
          response["time"],
          true,
          false
        );
        $("#edit_schedTime").append(newOpt).trigger("change");

        $("#EditOnlineAppModal").modal("show");
      },
    });
  });

  $(document).on("click", ".deletebtn", function () {
    var user_id = $(this).data("id");
    $("#delete_id").val(user_id);
    $("#deletemodal").modal("show");
  });

  $("#edit_status").on("change", function () {
    var treated = $(this).val();
    var schedDate = $("#edit_schedule").val();
    var appDate = Date.parse(schedDate);
    var todayDate = new Date().getTime();
    if (treated == "Treated") {
      if (todayDate < appDate) {
        if (
          confirm(
            "The appointment date is not today, are you sure you want to set it to Treated?"
          )
        ) {
        } else {
          this.selectedIndex = 0;
        }
      }
      return false;
    }
  });
});
