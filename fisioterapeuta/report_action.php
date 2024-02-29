<?php
function getDateTextBox($label, $dateId) {

$d = '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
            <div class="form-group">
              <label>'.$label.'</label>
              <div class="input-group rounded-0 date" 
              id="" 
              data-target-input="nearest">
              <input type="text" class="form-control form-control-sm rounded-0 datetimepicker-input" data-toggle="datetimepicker" 
data-target="#'.$dateId.'" name="'.$dateId.'" id="'.$dateId.'" required="required" autocomplete="off"/>
              <div class="input-group-append rounded-0" 
              data-target="#'.$dateId.'" 
              data-toggle="datetimepicker">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
          </div>
        </div>
      </div>';

      return $d;
}

?>