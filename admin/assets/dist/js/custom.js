$(document).ready(function () {
  jQuery(function ($) {
    $(".js-phone").inputmask({
      mask: ["+639999999999"],
      jitMasking: 3,
      showMaskOnHover: false,
      autoUnmask: true,
    });
  });
  $("#scheddate").datepicker({
    startDate: new Date(),
  });
  $("#datepicker").datepicker({
    todayHighlight: true,
    clearBtn: true,
    autoclose: true,
    endDate: new Date(),
  });

  $(document).on("click", ".logoutbtn", function () {
    $("#logoutModal").modal("show");
  });

  $(document).on("click", ".viewbtn", function () {
    var userid = $(this).data("id");

    $.ajax({
      url: "code.php",
      type: "post",
      data: { userid: userid },
      success: function (response) {
        $(".patient_viewing_data").html(response);
        $("#ViewPatientModal").modal("show");
      },
    });
  });

  $(document).on("click", ".editbtn", function () {
    var user_id = $(this).data("id");

    $.ajax({
      type: "POST",
      url: "code.php",
      data: {
        checking_editbtn: true,
        user_id: user_id,
      },
      success: function (response) {
        $.each(response, function (key, value) {
          $("#edit_id").val(value["id"]);
          $("#edit_fname").val(value["fname"]);
          $("#edit_address").val(value["address"]);
          $("#edit_dob").val(value["dob"]);
          $("#edit_gender").val(value["gender"]);
          $("#edit_phone").val(value["phone"]);
          $("#edit_email").val(value["email"]);
          $("#edit_password").val(value["password"]);
          $("#edit_cpassword").val(value["password"]);
        });

        $("#EditPatientModal").modal("show");
      },
    });
  });

  var password = document.getElementById("password"),
    confirmPassword = document.getElementById("confirmPassword");

  function validatePassword() {
    if (password.value != confirmPassword.value) {
      confirmPassword.setCustomValidity("Password does not match");
    } else {
      confirmPassword.setCustomValidity("");
    }
  }
  password.onchange = validatePassword;
  confirmPassword.onkeyup = validatePassword;

  $("#example1")
    .DataTable({
      responsive: true,
      autoWidth: false,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
    })
    .buttons()
    .container()
    .appendTo("#example1_wrapper .col-md-6:eq(0)");
  $("#example").DataTable({
    paging: true,
    lengthChange: false,
    searching: false,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
  });
});

const passwordInput = document.querySelector("#password")
const eye = document.querySelector("#eye")
eye.addEventListener("click", function(){
  this.classList.toggle("fa-eye-slash")
  const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
  passwordInput.setAttribute("type", type)
})

$(document).ready(function() {
  $("#datepicker").on("change", function() {
    var today = new Date();
    var selectedDate = new Date($(this).val());
    var age = today.getFullYear() - selectedDate.getFullYear();

    if (age < 7) {
      alert("You must be at least 7 years old to use this service.");
      $(this).val("");
    }
  });
});
