<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Notifications</h1>
            </div>
            <div class="col-sm-6">
            </div>
        </div> 
    </div>
</div>
      
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php include('message.php');?>
                <div class="card card-primary card-outline">
                    <!-- /.cards-header -->
                    <div class="card-body">
                        <form action="fetch_notification.php" method="post">
                        <table id="example1" class="table table-borderless table-hover" style="width:100%;">
                        <thead class="bg-light">
                            <tr>
                            <th><button type="submit" id="del_button" name="delete_multiple_btn" class="btn btn-danger" disabled>Delete</button></th>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Sent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT CONCAT(p.fname,' ',p.lname) as pname,n.id,n.subject,n.created_at FROM notification n INNER JOIN tblpatient p ON n.patient_id = p.id WHERE n.type='0' ORDER BY id DESC";
                            $query_run = mysqli_query($conn, $sql);
                            
                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $row){
                            ?>
                            <tr>     
                            <td style="width:10px; text-align: center;">
                                <input type="checkbox" name="delete_id[]" value="<?=$row['id']?>">
                            </td>                  
                            <td><?=$row['pname']?></td>
                            <td><?=$row['subject']?></td>
                            <td><?=date('F j, Y',strtotime($row['created_at']))?><br><small><?=date('g:i a',strtotime($row['created_at']))?></small></td>     
                            </tr>
                            <?php
                                }
                            }
                            else
                            {
                                
                            }
                            ?>
                        </tbody>
                        </table>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
                <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
<!-- /.container-fluid -->
</div> <!-- /.container -->
</div> <!-- /.content-wrapper -->
</div>

<?php include('includes/scripts.php');?>
<script>
    $(document).ready(function () {

        
        var table = $('#notif').dataTable({
        'columnDefs': [{ 'orderable': false, 'targets': 0 }], // hide sort icon on header of first column
        'aaSorting': [[1, 'asc']], // start to sort data in second column
        'searching': false
        });

        $("input[type='checkbox']").click(function() {
            $('#del_button').attr("disabled", !$("input[type='checkbox']").is(":checked"));
        });

 
        

    });
</script>
<?php include('includes/footer.php');?>