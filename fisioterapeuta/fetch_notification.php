<?php
    include('authentication.php');
    include('../admin/config/dbconn.php');

    date_default_timezone_set("Asia/Manila");
    function timeago($time,$tense='ago')
    {
        static $periods = array('year','month','day','hour','minute','second');
        if(!(strtotime($time) > 0))
        {
        return trigger_error("Wrong time format: '$time'", E_USER_ERROR);
        }
        $now = new DateTime('now');
        $time = new DateTime($time);
        $diff = $now->diff($time)->format('%y %m %d %h %i %s');
        $diff = explode(' ',$diff);
        $diff = array_combine($periods,$diff);
        $diff = array_filter($diff);

        $period = key($diff);

        $value = current($diff);
        if(!$value)
        {
        $period = '';
        $tense = '';
        $value = 'Just now';
        }
        else
        {
        if($period == 'day' && $value  >= 7)
        {
            $period = 'week';
            $value = floor($value/7);
        }
        if($value > 1)
        {
            $period .='s';
        }
        }
        return "$value $period $tense";
    }

    if(isset($_POST["view"])){
        
	    $id = $_POST['user_id'];
        if($_POST["view"] != ''){
            mysqli_query($conn,"update notification set seen_status='1' where seen_status='0'");
        }
        
        $query=mysqli_query($conn,"SELECT CONCAT(p.fname,' ',p.lname) AS pname,p.image,n.subject,n.created_at FROM notification n INNER JOIN tblpatient p ON n.patient_id = p.id WHERE n.type='0'AND n.doc_id='$id' ORDER BY n.id desc limit 5");
        $output = '';
        $count = mysqli_num_rows($query);
     
        if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_array($query)){
        $output .= '
        
            <a href="online-request.php" class="dropdown-item">
            <div class="media">
              <img src="../upload/patients/'.$row['image'].'" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
              <h3 class="dropdown-item-title">
              '.$row['pname'].'
            </h3>
            <p class="text-sm">'.$row['subject'].'</p>
            <p class="text-sm text-muted">'.timeago($row['created_at']).'</p>
            </div>
            </div>
          </a>
        
        ';
        }
        }
        else{
        $output .= '<div class="dropdown-divider"></div>
        <a class="dropdown-item dropdown-footer">You have no notifications</a>';
        }
        $output .= '<div class="dropdown-divider"></div>
            <a href="see-all-notifications.php" class="dropdown-item dropdown-footer">See All Notifications</a>';
        
        $query1=mysqli_query($conn,"select * from notification where seen_status='0'AND type='0' AND doc_id='$id'");
        $count = mysqli_num_rows($query1);
        $data = array(
            'notification'   => $output,
            'unseen_notification' => $count
        );
        echo json_encode($data);
        
    }

    if(isset($_POST['delete_multiple_btn']))
    {
        $all_id = $_POST['delete_id'];
        $extract_id = implode(',', $all_id);

        $sql = "DELETE FROM notification WHERE id IN($extract_id)";
        $query_run = mysqli_query($conn,$sql);

        if($query_run)
        {
            $_SESSION['success'] = "Notification Deleted Successfully";
            header('Location:see-all-notifications.php');
        }
        else
        {
            $_SESSION['error'] = "Notification Failed to Delete";
            header('Location:see-all-notifications.php');
        }
    }

?>
