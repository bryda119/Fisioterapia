
$('#country-dropdown').on('change', function() {
    var country_id = this.value;
    $.ajax({
    url: "clinic_action.php",
    type: "POST",
    data: {
        'states_by_country': true,
    'country_id': country_id
    },
    cache: false,
    success: function(result){
    $("#state-dropdown").html(result);
    $('#city-dropdown').html('<option value="">Select State First</option>'); 
    }
    });
    });    

    $('#state-dropdown').on('change', function() {
    var state_id = this.value;
    $.ajax({
    url: "clinic_action.php",
    type: "POST",
    data: {
        'cities_by_state': true,
    'state_id': state_id
    },
    cache: false,
    success: function(result){
    $("#city-dropdown").html(result);
    }
    });
    });