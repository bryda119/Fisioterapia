<?php
include('../../authentication.php');
include('../../config/dbconn.php');
include('../../superglobal.php');
date_default_timezone_set("America/Guayaquil");
use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Twilio\Exceptions\TwilioException;

require '../../../vendor/autoload.php';
function sendTextMessage($patient_name, $patient_phone, $text)
{
  include('../../config/dbconn.php');
  $sql = "SELECT * FROM sms_settings WHERE id='1'";
  $query_run = mysqli_query($conn, $sql);
  if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
      $sid = $row['sid'];
      $token = $row['token'];
      $sender = $row['sender'];
    }
  }
  $client = new Client($sid, $token);

  try {
    $client->messages->create(
      $patient_phone,
      [
        'from' => $sender,
        'body' => 'Dear ' . $patient_name . ', ' . $text . ''
      ]
    );
  } catch (TwilioException $e) {
    echo $e->getCode();
  }
}
function sendEmail($pdf, $patient_name, $patient_lname, $patient_email, $patient_date, $patient_time, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name)
{
  $mail = new PHPMailer(true);
  // $mail->SMTPDebug=3;
  $mail->isSMTP();
  $mail->Host       = $mail_host;
  $mail->SMTPAuth   = true;
  $mail->Username   = $mail_username;
  $mail->Password   = $mail_password;

  $mail->SMTPSecure = 'tls';
  $mail->Port       = 587;

  $mail->setFrom($mail_username, $system_name);
  $mail->addAddress($patient_email);

  //Recipients
  $mail->addStringAttachment($pdf, " $system_name-$patient_lname.pdf");
  // Content
  $mail->isHTML(true);
  $mail->Subject = 'Set an Appointment | ' . $system_name;
  $email_template =
    '<p>Appointment Submitted on ' . $date_submission . '</p>
                    <p>Appointment Details<br>
                    Name: ' . $patient_name . '<br>
                    Contact Number: ' . $patient_phone . '<br>
                    Email: ' . $patient_email . '<br>
                    Preferred Date: ' . $patient_date . '<br>
                    Time: ' . $patient_time . '</p>
                    <p>Treatment: ' . $treatment . '</p>
                    <p>Print, sign and bring the attached PDF on the date of your appointment. This<br>
                    will serve also as proof of appointment.</p>
                    <p>Thank you!<br>
                    ' . $system_name . ' Team</p>';
  $mail->Body = $email_template;
  try {
    $mail->send();
    echo "Message has been sent";
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
function cancelledEmail($patient_name, $patient_email, $patient_date, $patient_time, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name, $mobile)
{
  $mail = new PHPMailer(true);
  $mail->isSMTP();
  $mail->Host       = $mail_host;
  $mail->SMTPAuth   = true;
  $mail->Username   =  $mail_username;
  $mail->Password   =  $mail_password;

  $mail->SMTPSecure = 'tls';
  $mail->Port       = 587;
  //$mail->SMTPDebug = 2;

  $mail->setFrom($mail_username, $system_name);
  $mail->addAddress($patient_email);

  $mail->isHTML(true);
  $mail->Subject = 'Appointment Cancellation Notice | ' . $system_name;
  $email_template =
    '<p> Dear ' . $patient_name . ',</p>
        <p>We regret to inform you that your scheduled appointment on ' . $patient_date . ' at ' . $patient_time . '<br>
            has been cancelled. We apologize for any inconvenience this may cause. <br>
            If you have any question regarding the cancellation, please don\'t hesitate to contact us.</p> 
            <p>If you would like to reschedule your appointment, please reply to this email or call us at <br>
            ' . $mobile . ' to arrange a new date and time that works for you.</p>
            <p>Thank you for your understanding.</p>
            <p>Best regards,<br>
            ' . $system_name . '</p>';
  $mail->Body = $email_template;

  try {
    $mail->send();
    echo "Message has been sent";
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

if (isset($_POST['checking_editbtn'])) {
  $s_id = $_POST['app_id'];

  $sql = "SELECT * FROM tblappointment WHERE id='$s_id' ";
  $query_run = mysqli_query($conn, $sql);

  if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
      $sched =  date('F d, Y', strtotime($row['schedule']));
      $time = date('h:i A', strtotime($row['starttime'])) . "-" . date('h:i A', strtotime($row['endtime']));
      $result_array = array(
        'id' => $row['id'],
        'patient_id' => $row['patient_id'],
        'patient_name' => $row['patient_name'],
        'doc_id' => $row['doc_id'],
        'schedule' => $sched,
        'time' => $time,
        'sched_id' => $row['sched_id'],
        'reason' => $row['reason'],
        'status' => $row['status'],
        'bgcolor' => $row['bgcolor']
      );
    }
    header('Content-type: application/json');
    echo json_encode($result_array);
  } else {
    echo mysqli_error($conn);
  }
}

if (isset($_POST['update_appointment'])) {
  $services = '';
  $id = $_POST['edit_id'];
  $patient_id = $_POST['select_patient'];
  $doctor_id = $_POST['select_dentist'];
  $schedule_id = $_POST['scheddate'];
  $selectedTime = $_POST['schedTime'];
  $preferredTime = explode("-", $selectedTime);
  $s_time = $preferredTime[0];
  $e_time = $preferredTime[1];
  foreach ($_POST['service'] as $selectedService) {
    $services .= $selectedService . ",";
  }
  $treatment = rtrim($services, ", ");

  $sql = "SELECT * FROM schedule WHERE id='$schedule_id'";
  $query_run = mysqli_query($conn, $sql);
  if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
      $schedule = $row['day'];
    }
  }

  $status = $_POST['status'];
  $bgcolor = $_POST['color'];
  $subject = 'Confirmed your Appointment';
  $type = '1';
  $cancelled = 'Cancelled your Appointment';
  $send_email = $_POST['send-email'];
  $date_submitted = date('Y-m-d H:i:s');

  $sql = "UPDATE tblappointment set doc_id='$doctor_id',schedule='$schedule',starttime='$s_time',endtime='$e_time', reason='$treatment',status='$status',bgcolor='$bgcolor' WHERE id='$id' ";
  $query_run = mysqli_query($conn, $sql);

  if ($status == 'Treated') {
    $check_app = mysqli_query($conn, "SELECT appointment_id FROM treatment where appointment_id = '$id' ");
    if (mysqli_num_rows($check_app) > 0) {
    } else {
      $sql = "INSERT INTO treatment (appointment_id,patient_id,doc_id,visit,treatment,created_at) VALUES ('$id','$patient_id','$doctor_id','$schedule_id','$treatment','$date_submitted')";
      $query_run = mysqli_query($conn, $sql);
    }
  } else {
    $check_app = mysqli_query($conn, "SELECT appointment_id FROM treatment where appointment_id = '$id' ");
    if (mysqli_num_rows($check_app) > 0) {
      $sql = "DELETE FROM treatment WHERE appointment_id = '$id'";
      $query_run = mysqli_query($conn, $sql);
    }
  }


  $sql = "SELECT * from system_details";
  $query_run = mysqli_query($conn, $sql);
  if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
      $system_logo = $row['brand'];
      $system_contact = $row['mobile'];
      $system_email = $row['email'];
    }
  }

  $sql = "SELECT a.*, CONCAT(p.fname,' ',p.lname) AS pname,p.lname,p.phone,p.email,a.created_at FROM tblappointment a INNER JOIN tblpatient p ON p.id ='$patient_id' WHERE a.id='$id'";
  $query_run = mysqli_query($conn, $sql);
  if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
      $patient_name = $row['pname'];
      $patient_lname = $row['lname'];
      $date_submission = date('l, F j, Y', strtotime($row['created_at']));
      $patient_email = $row['email'];
      $patient_date = date('l, F j, Y', strtotime($row['schedule']));
      $patient_phone = $row['phone'];
      $patient_time = $s_time;
    }
  }

  if ($query_run) {
    if ($status == 'Confirmed') {
      $text = 'Your appointment has been confirmed. Please try to arrive 10-15 minutes early and don\'t forget to wear your face mask. If you have any queries, or need to reschedule, please call our office at ' . $system_contact . ' or drop us a mail ' . $system_email . '. We look forward to seeing you on ' . $patient_date . ' ' . $patient_time . '. ';
      sendTextMessage($patient_name, $patient_phone, $text);
    } else if ($status == 'Cancelled') {
      $text = 'Your appointment has been cancelled.';
      sendTextMessage($patient_name, $patient_phone, $text);
      cancelledEmail($patient_name, $patient_email, $patient_date, $patient_time, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name, $mobile);
    }

    if (!empty($_POST['send-email'])) {
      $mpdf = new \Mpdf\Mpdf();
      $answer = array();
      $qanda = "SELECT h.answer,h.question_id,q.questions from health_declaration h INNER JOIN questionnaires q ON h.question_id = q.id WHERE h.patient_id = '$patient_id'";
      $query_run = mysqli_query($conn, $qanda);
      $data = '
            <html>

            <head>
              <style>
                body {
                  font-size: 12px;
                }
            
                .clearfix {
                  clear: both;
                }
            
                .img {
                  float: left;
                }
              </style>
            </head>
            
            <body>
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-8">
                    <div class="invoice p-3 mb-3" id="prescription">
                        <img src="../../../upload/' . $system_logo . '" height="100" alt="Logo">
                      <br>
                      <table class="table" style="width:100%;">
                        <tr>
                          <td>Name: <b>' . $patient_name . '</b></td>
                          <td>Date Submitted: <b>' . $date_submission . '</b></td>
                        </tr>
                        <tr>
                          <td>Email: <b>' . $patient_email . '</b></td>
                          <td>Contact Number:<b>' . $patient_phone . '</b></td>
                        </tr>
                        <tr>
                          <td>Date of Visit: <b>' . $patient_date . '</b></td>
                          <td>Time of Visit: <b>' . $patient_time . '</b></td>
                        </tr>
                      </table>
                      <p>Treatment: ' . $treatment . '</p>
                      Health Declaration';
      while ($row = mysqli_fetch_array($query_run)) {
        $data .= '<ul>
                        <li>' . $row['questions'] . ' <b>' . $row['answer'] . '</b>
                        <li>
                      </ul>';
      }
      $data .= '
                      <br>
                      <table class="table" style="width:100%;">
                        <tr>
                          <td>Patient\'s or Guardian\'s Full Name:</td>
                          <td>Signature:</td>
                        </tr>
                        <tr>
                          <td>Relationship to Patient:</td>
                          <td>Date Signed:</td>
                        </tr>
                        <tr>
                          <td>Confirmed Date & Time of Visit:</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              </div>
            </body>
            
            </html>                              
            ';

      $mpdf->WriteHtml($data);
      $pdf = $mpdf->output("", "S");
      sendEmail($pdf, $patient_name, $patient_lname, $patient_email, $patient_date, $patient_time, $patient_phone, $treatment, $date_submission, $mail_username, $mail_host, $mail_password, $system_name);
    }
    $_SESSION['success'] = "Online Appointment Request Updated Successfully";
    header('Location:index.php');
  } else {
    $_SESSION['error'] = "Online Appointment Request Failed to Scheduled";
    header('Location:index.php');
  }
}

if (isset($_POST['deletedata'])) {
  $id = $_POST['delete_id'];

  $sql = "DELETE FROM tblappointment WHERE id='$id' ";
  $query_run = mysqli_query($conn, $sql);

  if ($query_run) {
    $_SESSION['success'] = "Online Appointment Request Successfully";
    header('Location:index.php');
  } else {
    $_SESSION['error'] = "Online Appointment Request Failed to Delete";
    header('Location:index.php');
  }
}

if (isset($_GET['health_dec'])) {
  $id = $_GET['user_id'];

  $sql = "SELECT q.questions,h.patient_id,h.question_id,h.answer FROM questionnaires q INNER JOIN health_declaration h ON h.question_id = q.id WHERE h.patient_id='$id' ";
  $query_run = mysqli_query($conn, $sql);

  if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_array($query_run)) {
      echo '
                    <ul>
                        <li>' . $row['questions'] . ' <b> ' . $row['answer'] . '</b></li>
                    </ul>
                ';
    }
  } else {
    echo $id;
  }
}

if (isset($_GET['doctorIdDate'])) {
  $doc_id = $_GET['doctorIdDate'];
  $pat_id = $_GET['patientId'];
  $today = date("Y-m-d");

  $data = array();

  $sql = "SELECT * FROM schedule WHERE doc_id='$doc_id' AND day > CURDATE()";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $id = $row['id'];
      $day = date('F d, Y', strtotime($row['day']));
      $startTime = strtotime($row['starttime']);
      $endTime = strtotime($row['endtime']);
      $duration = $row['duration'];

      $minuteDiff = round(abs($endTime - $startTime) / 60, 2);

      $getApptSql = "SELECT count(*) as numberOfappt FROM tblappointment WHERE doc_id='$doc_id' AND schedule='$day'";
      $getApptRes = mysqli_query($conn, $getApptSql);
      $getApptRow = mysqli_fetch_assoc($getApptRes);
      $numberOfAppt =  $getApptRow['numberOfappt'];

      if ($duration <= ($minuteDiff - ($numberOfAppt * 60))) {
        $chkApptSql = "SELECT count(*) as appt FROM tblappointment WHERE patient_id='$pat_id' AND schedule='$day' AND status!='Cancelled'";
        $chkApptRes = mysqli_query($conn, $chkApptSql);
        $chkApptRow = mysqli_fetch_assoc($chkApptRes);
        $appt =  $chkApptRow['appt'];
        if ($appt == 0) {
          $data[] = array('id' => $id, 'text' => $day, 'info' => $duration);
        }
      }
    }
  } else {
    $data[] = array('id' => 0, 'text' => 'No dates found', 'disabled' => true);
  }

  echo json_encode($data);
}

if (isset($_POST['selectedDateId'])) {
  $schedId = $_POST['selectedDateId'];
  $today = date("Y-m-d");
  $conflict = 0;
  $previousEndTime = '';
  $lunchbreak = false;

  $data = array();

  $sql = "SELECT * FROM schedule WHERE id='$schedId'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
      $id = $row['id'];
      $day = date('F d, Y', strtotime($row['day']));
      $startTime = $row['starttime'];
      $endTime = $row['endtime'];
      $duration = $row['duration'];

      $totalNoOfMins = round(abs(strtotime($endTime) - strtotime($startTime)) / 60, 2);

      $noOfAppt = ($totalNoOfMins - 60) / $duration;

      $currentStartTime = date('h:i A', strtotime($startTime));
      $currentEndTime = date('h:i A', strtotime($startTime . " " . $duration . " minutes"));

      do {
        $timeSched = $currentStartTime . "-" . $currentEndTime;
        if (date('H', strtotime($currentStartTime)) != 12) {
          $data[] = array('id' => $timeSched, 'text' => $timeSched);
        }

        if (date('H', strtotime($currentEndTime)) == 12 && $lunchbreak == false) {
          $currentStartTime = date('h:i A', strtotime($currentEndTime));
          $currentEndTime = date('h:i A', strtotime($currentEndTime . " +60 minutes"));

          $lunchbreak = true;
        } else {
          $currentStartTime = date('h:i A', strtotime($currentEndTime));
          $currentEndTime = date('h:i A', strtotime($currentEndTime . " +" . $duration . " minutes"));
        }

        $noOfAppt--;
      } while ($noOfAppt >= 1);
    }
  } else {
    $data[] = array('id' => 0, 'text' => 'No dates found', 'disabled' => true);
  }

  echo json_encode($data);
}
