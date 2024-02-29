$(document).ready(function() {
    $("#datepicker,#edit_dob").on("change", function() {
      var today = new Date();
      var selectedDate = new Date($(this).val());
      var age = today.getFullYear() - selectedDate.getFullYear();
  
      if (age < 7) {
        alert("You must be at least 7 years old to use this service.");
        $(this).val("");
      }
    });
  });
  