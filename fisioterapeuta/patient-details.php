<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="modal fade" id="AddDentalModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Historia Dental</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $user = "SELECT * FROM tblpatient WHERE id='$user_id'";
                        $users_run = mysqli_query($conn, $user);

                        if (mysqli_num_rows($users_run) > 0) {
                            foreach ($users_run as $user) {
                    ?>
                                <form action="medical_action.php" method="POST">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Dentista Anterior</label>
                                                    <input type="hidden" name="patient" value="<?= $user['id'] ?>">
                                                    <input type="text" name="dentist" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Última Visita al Dentista</label>
                                                    <input type="text" name="visit" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" name="dental_record" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="EditDentalModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Historia Dental</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="medical_action.php" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" name="edit_id" id="edit_id">
                                    <input type="hidden" name="userid" id="patient_id">
                                    <div class="form-group">
                                        <label for="">Dentista Anterior</label>
                                        <input type="text" id="edit_dentist" name="dentist" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Última Visita al Dentista</label>
                                        <input type="text" id="edit_visit" name="visit" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" name="update_dental" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="AddMedicalModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Historial Médico</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $user = "SELECT * FROM tblpatient WHERE id='$user_id'";
                        $users_run = mysqli_query($conn, $user);

                        if (mysqli_num_rows($users_run) > 0) {
                            foreach ($users_run as $user) {
                    ?>
                                <form action="medical_action.php" method="POST">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <input type="hidden" name="patient" value="<?= $user['id'] ?>">
                                                <label for="">¿Está en buena salud?</label>
                                                <input type="text" name="q1" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">¿Está bajo tratamiento médico actualmente? En caso afirmativo, ¿cuál es la condición que se está tratando?</label>
                                                <input type="text" name="q2" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">¿Ha tenido alguna enfermedad grave o operación quirúrgica? En caso afirmativo, ¿qué enfermedad u operación?</label>
                                                <input type="text" name="q3" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">¿Ha sido hospitalizado alguna vez? En caso afirmativo, ¿cuándo y por qué?</label>
                                                <input type="text" name="q4" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">¿Está tomando algún medicamento recetado/no recetado? En caso afirmativo, especifique por favor</label>
                                                <input type="text" name="q5" class="form-control" required>
                                            </div>
                                        </div>
                                        <label for="">¿El paciente tiene alergia a alguno de los siguientes? En caso afirmativo, por favor especifique (Látex, Antibióticos de Penicilina, Aspirina, Medicamentos Sulfa, Anestésicos Locales)</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" name="allergy" class="form-control" required>
                                            </div>
                                        </div>
                                        <label for="">¿El paciente ha tenido alguno de los siguientes?</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Presión arterial alta" <?php echo isset($row['med']) && in_array("Presión arterial alta", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Presión arterial alta</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Presión arterial baja" <?php echo isset($row['med']) && in_array("Presión arterial baja", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Presión arterial baja</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Epilepsia" <?php echo isset($row['med']) && in_array("Epilepsia", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Epilepsia</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Infección por VIH o SIDA" <?php echo isset($row['med']) && in_array("Infección por VIH o SIDA", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Infección por VIH o SIDA</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Ataque de desmayo" <?php echo isset($row['med']) && in_array("Ataque de desmayo", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Ataque de desmayo</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Pérdida de peso rápida" <?php echo isset($row['med']) && in_array("Pérdida de peso rápida", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Pérdida de peso rápida</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Asma" <?php echo isset($row['med']) && in_array("Asma", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Asma</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Cáncer/Tumores" <?php echo isset($row['med']) && in_array("Cáncer/Tumores", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Cáncer/Tumores</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Ninguna" <?php echo isset($row['med']) && in_array("Ninguna", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Ninguna</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Ataque al corazón" <?php echo isset($row['med']) && in_array("Ataque al corazón", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Ataque al corazón</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Enfermedad cardíaca" <?php echo isset($row['med']) && in_array("Enfermedad cardíaca", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Enfermedad cardíaca</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Hepatitis" <?php echo isset($row['med']) && in_array("Hepatitis", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Hepatitis</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Tuberculosis" <?php echo isset($row['med']) && in_array("Tuberculosis", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Tuberculosis</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Enfermedad renal" <?php echo isset($row['med']) && in_array("Enfermedad renal", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Enfermedad renal</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Diabetes" <?php echo isset($row['med']) && in_array("Diabetes", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Diabetes</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Accidente cerebrovascular" <?php echo isset($row['med']) && in_array("Accidente cerebrovascular", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Accidente cerebrovascular</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Anemia" <?php echo isset($row['med']) && in_array("Anemia", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Anemia</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Enfisema" <?php echo isset($row['med']) && in_array("Enfisema", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Enfisema</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" id="checkBtn" name="medical_record" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="modal fade" id="EditMedicalModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Medical History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $user = "SELECT * FROM medical_record WHERE patient_id='$user_id'";
                        $users_run = mysqli_query($conn, $user);

                        if (mysqli_num_rows($users_run) > 0) {
                            foreach ($users_run as $row) {
                    ?>
                                <form action="medical_action.php" method="POST">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <input type="hidden" name="patient" value="<?= $row['patient_id'] ?>">
                                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                                <label for="">Are you in good health?</label>
                                                <input type="text" name="q1" value="<?= $row['q1'] ?>" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Are you under medical treatment now? If so, what is the condition being treated?</label>
                                                <input type="text" name="q2" value="<?= $row['q2'] ?>" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Have you ever had serious illness or surgical operation? If so, what illness or operation</label>
                                                <input type="text" name="q3" value="<?= $row['q3'] ?>" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Have you ever been hospitalized? If so, when and why?</label>
                                                <input type="text" name="q4" value="<?= $row['q4'] ?>" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Are you taking any prescription/non-prescription medication? I so, please specify</label>
                                                <input type="text" name="q5" value="<?= $row['q5'] ?>" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Do patient have allergy to any of the following? If so, please specify (Latex, Penicilin Antibiotics, Aspirin, Sulfa Drugs, Local Anesthetic)</label>
                                                <input type="text" class="form-control" name="allergy" value="<?= $row['allergy'] ?>" required>
                                            </div>
                                        </div>
                                        <label for="">Do patient have allergy to any of the following?</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="High Blood Pressure" <?php echo isset($row['med']) && in_array("High Blood Pressure", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">High Blood Pressure</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Low Blood Pressure" <?php echo isset($row['med']) && in_array("Low Blood Pressure", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Low Blood Pressure</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Epilepsy" <?php echo isset($row['med']) && in_array("Epilepsy", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Epilepsy</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input " name="med[]" type="checkbox" value="AIDS or HIV Infection" <?php echo isset($row['med']) && in_array("AIDS or HIV Infection", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">AIDS or HIV Infection</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Fainting Seizure" <?php echo isset($row['med']) && in_array("Fainting Seizure", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Fainting Seizure</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input " name="med[]" type="checkbox" value="Rapid Weight Loss" <?php echo isset($row['med']) && in_array("Rapid Weight Loss", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Rapid Weight Loss</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Asthma" <?php echo isset($row['med']) && in_array("Asthma", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Asthma</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Cancer/Tumors" <?php echo isset($row['med']) && in_array("Cancer/Tumors", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Cancer/Tumors</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="None" <?php echo isset($row['med']) && in_array("None", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">None</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Heart Attack" <?php echo isset($row['med']) && in_array("Heart Attack", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Heart Attack</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Heart Attack" <?php echo isset($row['med']) && in_array("Heart Attack", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Heart Disease</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Hepatitis" <?php echo isset($row['med']) && in_array("Hepatitis", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Hepatitis</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Tuberculosis" <?php echo isset($row['med']) && in_array("Tuberculosis", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Tuberulosis</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Kidney Disease" <?php echo isset($row['med']) && in_array("Kidney Disease", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Kidney Disease</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Kidney Disease" <?php echo isset($row['med']) && in_array("Diabetes", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Diabetes</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input " name="med[]" type="checkbox" value="Stroke" <?php echo isset($row['med']) && in_array("Stroke", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Stroke</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Anemia" <?php echo isset($row['med']) && in_array("Anemia", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Anemia</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="med[]" type="checkbox" value="Emphysema" <?php echo isset($row['med']) && in_array("Emphysema", explode(",", $row['med'])) ? "checked" : ''  ?>>
                                                        <label class="form-check-label">Emphysema</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" id="checkBtn2" name="update_medical_record" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    include('message.php');
                    ?>
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="overview-tab" data-toggle="tab" data-target="#overview" role="tab" aria-controls="overview" aria-selected="true">Resumen</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="history-tab" data-toggle="tab" data-target="#history" role="tab" aria-controls="history" aria-selected="false">Historia Médica</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="treatment-tab" data-toggle="tab" data-target="#treatment" role="tab" aria-controls="treatment" aria-selected="false">Tratamientos</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="card card-primary card-outline">
                                                <?php
                                                if (isset($_GET['id'])) {
                                                    $id_usuario = $_GET['id'];
                                                    $usuario = "SELECT * FROM tblpatient WHERE id='$id_usuario'";
                                                    $usuarios_ejecutados = mysqli_query($conn, $usuario);

                                                    if (mysqli_num_rows($usuarios_ejecutados) > 0) {
                                                        foreach ($usuarios_ejecutados as $usuario) {
                                                ?>
                                                            <div class="card-body box-profile">
                                                                <div class="text-center">
                                                                    <img class="profile-user-img img-fluid img-circle" src="../upload/patients/<?= $usuario['image'] ?>" alt="Foto de perfil del usuario">
                                                                </div>
                                                                <h4 class="profile-username text-center"><?= $usuario['fname'] . ' ' . $usuario['lname'] ?></h4>
                                                                <p class="text-muted text-center"><?= $usuario['email'] ?></p>
                                                                <ul class="list-group list-group-unbordered mb-3">
                                                                    <li class="list-group-item">
                                                                        <b>Género</b>
                                                                        <p class="float-right text-muted m-0"><?= $usuario['gender'] ?></p>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <b>Fecha de Nacimiento</b>
                                                                        <p class="float-right text-muted m-0"><?= $usuario['dob'] ?></p>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <b>Teléfono</b>
                                                                        <p class="float-right text-muted m-0"><?= $usuario['phone'] ?></p>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <b>Dirección</b>
                                                                        <p class="float-right text-muted m-0"><?= $usuario['address'] ?></p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card">
                                                <div class="card-header p-2">
                                                    <ul class="nav nav-pills" id="custom-tabs-three-tab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" href="appointment-tab" data-toggle="tab" data-target="#appointment" role="tab" aria-controls="appointment" aria-selected="true">Cita</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="payment-tab" data-toggle="tab" data-target="#payment" role="tab" aria-controls="payment" aria-selected="false">Pago</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="prescription-tab" data-toggle="tab" data-target="#prescription" role="tab" aria-controls="prescription" aria-selected="false">Receta</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="card-body">
                                                    <div class="tab-content" id="custom-tabs-three-tabContent">
                                                        <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="appointment-tab">
                                                            <!-- Cita-->
                                                            <table id="appointmenttable" class="table table-hover table-borderless" style="width:100%;">
                                                                <thead class="bg-light">
                                                                    <tr>
                                                                        <th>Fecha</th>
                                                                        <th>Hora</th>
                                                                        <th>Doctor</th>
                                                                        <th>Estado</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    if (isset($_GET['id'])) {
                                                                        $id_usuario = $_GET['id'];
                                                                        $usuario = "SELECT a.schedule,a.id,a.starttime,a.status,a.endtime,d.name as dname FROM tbldoctor d INNER JOIN tblappointment a WHERE a.doc_id = d.id AND a.patient_id ='$id_usuario' ORDER BY a.schedule";
                                                                        $usuarios_ejecutados = mysqli_query($conn, $usuario);

                                                                        if (mysqli_num_rows($usuarios_ejecutados) > 0) {
                                                                            foreach ($usuarios_ejecutados as $usuario) {
                                                                    ?>

                                                                                <tr>
                                                                                    <td>
                                                                                        <?= date('d-M-Y', strtotime($usuario['schedule'])) ?></td>
                                                                                    <td><?= $usuario['starttime'] . ' - ' . $usuario['endtime'] ?></td>
                                                                                    <td><?= $usuario['dname'] ?></td>
                                                                                    <td>
                                                                                        <?php
                                                                                        if ($usuario['status'] == 'Treated') {
                                                                                            echo $usuario['status'] = '<span class="badge badge-primary">Tratada</span>';
                                                                                        } else if ($usuario['status'] == 'Confirmed') {
                                                                                            echo $usuario['status'] = '<span class="badge badge-success">Confirmada</span>';
                                                                                        } else if ($usuario['status'] == 'Pending') {
                                                                                            echo $usuario['status'] = '<span class="badge badge-warning">Pendiente</span>';
                                                                                        } else if ($usuario['status'] == 'Cancelled') {
                                                                                            echo $usuario['status'] = '<span class="badge badge-danger">Cancelada</span>';
                                                                                        } else {
                                                                                            echo $usuario['status'] = '<span class="badge badge-secondary">Reprogramada</span>';
                                                                                        }

                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                                            <table id="paymenttable" class="table table-hover table-borderless" style="width:100%;">
                                                                <thead class="bg-light">
                                                                    <tr>
                                                                        <th class="bg-light">Fecha y Hora</th>
                                                                        <th class="bg-light">Número de Referencia</th>
                                                                        <th class="bg-light">Cantidad</th>
                                                                        <th class="bg-light">Estado</th>
                                                                        <th class="bg-light">Método</th>
                                                                        <th class="bg-light">ID de Transacción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $user_payments_query = "SELECT p.created_at, p.ref_id, p.amount, p.payment_status, p.method, p.txn_id 
                            FROM payments p 
                            INNER JOIN tblappointment a ON a.id = p.patient_id 
                            WHERE a.patient_id = '$user_id' 
                            ORDER BY p.id DESC";
    $user_payments_result = mysqli_query($conn, $user_payments_query);

    if (mysqli_num_rows($user_payments_result) > 0) {
        while ($row = mysqli_fetch_array($user_payments_result)) {
?>
            <tr>
                <td><?= date('Y-m-d h:i A', strtotime($row['created_at'])); ?></td>
                <td><?= $row['ref_id'] ?></td>
                <td>$ <?= $row['amount'] ?></td>
                <td><?= $row['payment_status'] ?></td>
                <td><span class="badge badge-warning"><?= $row['method'] ?></span></td>
                <td><?= $row['txn_id'] ?></td>
            </tr>
<?php
        }
    } else {
        echo "<tr><td colspan='6'>No se encontraron pagos para este usuario.</td></tr>";
    }
}
?>

                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="tab-pane fade" id="prescription" role="tabpanel" aria-labelledby="prescription-tab">
                                                                    <table id="prescriptiontable" class="table table-hover table-borderless" style="width:100%;">
                                                                        <thead class="bg-light">
                                                                            <tr>
                                                                            <th class="bg-light">Fecha</th>
                                                                            <th class="bg-light">Medicina</th>
                                                                            <th class="bg-light">Dosis</th>
                                                                            <th class="bg-light">Duración</th>
                                                                            <th class="bg-light">Consejo</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                if (isset($_GET['id'])) {
                                                                                    $i = 1;
                                                                                    $user_id = $_GET['id'];
                                                                                    $user = "SELECT * FROM prescription WHERE patient_id='$user_id'";

                                                                                    $users_run = mysqli_query($conn, $user);

                                                                                    if (mysqli_num_rows($users_run) > 0) {
                                                                                        foreach ($users_run as $user) {
                                                                                ?>

                                                                                            <tr>
                                                                                                <td><?= date('d-M-Y', strtotime($user['date'])) ?></td>
                                                                                                <td><?= $user['medicine'] ?></td>
                                                                                                <td><?= $user['dose'] ?></td>
                                                                                                <td><?= $user['duration'] ?></td>
                                                                                                <td><?= $user['advice'] ?></td>
                                                                                            </tr>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-header border-bottom-0">
                                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#AddDentalModal">
                                                                <i class="fa fa-plus"></i> &nbsp;&nbsp;Agregar Historial Dental</button>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover table-borderless" style="width:100%;">
                                                                    <thead class="bg-light">
                                                                        <tr>
                                                                            <th style="width:1%;">#</th>
                                                                            <th>Dentista Anterior</th>
                                                                            <th>Última Visita Dental</th>
                                                                            <th>Acción</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        if (isset($_GET['id'])) {
                                                                            $i = 1;
                                                                            $user_id = $_GET['id'];
                                                                            $user = "SELECT * FROM dental_history WHERE patient_id='$user_id'";
                                                                            $users_run = mysqli_query($conn, $user);

                                                                            while ($user = mysqli_fetch_array($users_run)) {
                                                                        ?>
                                                                                <tr>
                                                                                    <td><?php echo $i++; ?></td>
                                                                                    <td><?= $user['dentist'] ?></td>
                                                                                    <td><?= $user['visit'] ?></td>
                                                                                    <td>
                                                                                        <button data-id="<?= $user['id'] ?>" class="btn btn-sm btn-info editDentalbtn"><i class="fas fa-edit"></i></button>
                                                                                        <button data-id="<?= $user['id'] ?>" class="btn btn-danger btn-sm deleteDentalbtn"><i class="far fa-trash-alt"></i></button>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-header border-bottom-0">
                                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#AddMedicalModal">
                                                                <i class="fa fa-plus"></i> &nbsp;&nbsp;Agregar Historial Médico</button>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover table-borderless" style="width:100%;">
                                                                    <thead class="bg-light">
                                                                        <tr>
                                                                            <th style="width:1%;">#</th>
                                                                            <th>Alergias</th>
                                                                            <th>Enfermedades</th>
                                                                            <th>Acción</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        if (isset($_GET['id'])) {
                                                                            $i = 1;
                                                                            $user_id = $_GET['id'];
                                                                            $user = "SELECT * FROM medical_record WHERE patient_id='$user_id'";
                                                                            $users_run = mysqli_query($conn, $user);

                                                                            while ($user = mysqli_fetch_array($users_run)) {
                                                                        ?>
                                                                                <tr>
                                                                                    <td><?php echo $i++; ?></td>
                                                                                    <td><?= $user['allergy'] ?></td>
                                                                                    <td><?= $user['med'] ?></td>
                                                                                    <td>
                                                                                        <button data-id="<?= $user['id'] ?>" class="btn btn-sm btn-info editMedicalbtn"><i class="fas fa-edit"></i></button>
                                                                                        <button data-id="<?= $user['id'] ?>" class="btn btn-danger btn-sm deleteMedicalbtn"><i class="far fa-trash-alt"></i></button>
                                                                                    </td>
                                                                                </tr>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="treatment" role="tabpanel" aria-labelledby="treatment-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="treatmenttable" class="table table-hover table-borderless" style="width:100%;">
                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th class="text-center">#</th>
                                                                <th>Fecha de Visita</th>
                                                                <th>Tratamiento</th>
                                                                <th>N° de Fisioterapeuta</th>
                                                                <th>Descripción</th>
                                                                <th>Honorarios</th>
                                                                <th>Observaciones</th>
                                                                <th class="bg-light">Adjunto</th>
                                                                <th class="bg-light">Descargar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($_GET['id'])) {
                                                                $i = 1;
                                                                $user_id = $_GET['id'];
                                                                $sql = "SELECT CONCAT(p.fname,'',p.lname) as pname,t.id,t.teeth,t.complaint,t.treatment,t.fees,t.file_name,t.remarks,s.day FROM treatment t INNER JOIN tblpatient p ON t.patient_id = p.id INNER JOIN schedule s ON s.id=t.visit WHERE t.patient_id='$user_id'";
                                                                $users_run = mysqli_query($conn, $sql);

                                                                if (mysqli_num_rows($users_run) > 0) {
                                                                    foreach ($users_run as $row) {
                                                            ?>
                                                                        <tr>
                                                                            <td style="width:10px; text-align:center;"><?php echo $i++; ?></td>
                                                                            <td><?= date('d-M-Y', strtotime($row['day'])); ?></td>
                                                                            <td><?= $row['treatment'] ?></td>
                                                                            <td><?= $row['teeth'] ?></td>
                                                                            <td><?= $row['complaint'] ?></td>
                                                                            <td><?= $row['fees'] ?></td>
                                                                            <td><?= $row['remarks'] ?></td>
                                                                            <?php
                                                                            if (empty($row['file_name'])) {
                                                                                echo '<td>N/A</td><td>N/A</td>';
                                                                            } else {
                                                                                echo '<td><a href="../upload/documents/' . $row['file_name'] . '" target="_blank">Ver</a></td>
                                        <td><a href="../upload/documents/' . $row['file_name'] . '" download>Descargar</a></td>';
                                                                            }
                                                                            ?>
                                                                        </tr>
                                                            <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/scripts.php'); ?>
    <script>
        $(document).ready(function() {

            $('#checkBtn').click(function() {
                checked = $("input[type=checkbox]:checked").length;

                if (!checked) {
                    alert("Please, check None option if the patient does not have illness ");
                    return false;
                }
            });

            $('#checkBtn2').click(function() {
                checked = $("input[type=checkbox]:checked").length;

                if (!checked) {
                    alert("Please, check None option if the patient does not have illness ");
                    return false;
                }
            });

            var table1 = $('#appointmenttable').DataTable({
                responsive: true,
                searching: true,
                paging: true,
                info: true,
            });
            var table2 = $('#prescriptiontable').DataTable({
                responsive: true,
                searching: true,
                paging: true,
                info: true,
            });
            var table3 = $('#treatmenttable').DataTable({
                responsive: true,
            });
            var table4 = $('#paymenttable').DataTable({
                responsive: true,
                searching: true,
                paging: true,
                info: true,
            });

            $('.nav-pills a').on('shown.bs.tab', function(event) {
                var tabID = $(event.target).attr('data-target');
                if (tabID === '#appointment') {
                    table1.columns.adjust().responsive.recalc();
                }
                if (tabID === '#prescription') {
                    table2.columns.adjust().responsive.recalc();
                }
                if (tabID === '#payment') {
                    table4.columns.adjust().responsive.recalc();
                }
            });


            $('.nav-tabs a').on('shown.bs.tab', function(event) {
                var tabID = $(event.target).attr('data-target');
                if (tabID === '#treatment') {
                    table3.columns.adjust().responsive.recalc();
                }
            });

            $(document).on('click', '.deleteDentalbtn', function() {
                var userid = $(this).data('id');

                if (confirm("Are you sure you want to delete this data?")) {
                    $.ajax({
                        type: "post",
                        url: "medical_action.php",
                        data: {
                            'delete_dental': true,
                            'user_id': userid,
                        },
                        success: function(response) {
                            location.reload();
                        }
                    });
                }
            });
            $(document).on('click', '.editDentalbtn', function() {
                var userid = $(this).data('id');

                $.ajax({
                    type: "post",
                    url: "medical_action.php",
                    data: {
                        'dental_editbtn': true,
                        'user_id': userid,
                    },
                    success: function(response) {
                        $.each(response, function(key, value) {
                            $('#edit_id').val(value['id']);
                            $('#patient_id').val(value['patient_id']);
                            $('#edit_dentist').val(value['dentist']);
                            $('#edit_visit').val(value['visit']);
                            $('#EditDentalModal').modal('show');
                        });
                    }
                });

            });
            $(document).on('click', '.deleteMedicalbtn', function() {
                var userid = $(this).data('id');

                if (confirm("Are you sure you want to delete this data?")) {
                    $.ajax({
                        type: "post",
                        url: "medical_action.php",
                        data: {
                            'delete_medical': true,
                            'user_id': userid,
                        },
                        success: function(response) {
                            location.reload();
                        }
                    });
                }
            });

            $(document).on('click', '.editMedicalbtn', function() {
                var userid = $(this).data('id');
                $('#EditMedicalModal').modal('show');

            });
        });
    </script>
    <?php include('includes/footer.php'); ?>