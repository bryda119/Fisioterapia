<?php
include('config/dbconn.php');
if(isset($_POST['search']))
    {
        $date1 = date("Y-m-d", strtotime($_POST['scheddate1']));
        $date2 = date("Y-m-d", strtotime($_POST['scheddate2']));
        $sql = "SELECT * FROM tblappointment WHERE created_at BETWEEN '$date1' AND '$date2' ";
        $query_run = mysqli_query($conn,$sql);

        if(mysqli_num_rows($query_run) > 0)
        {
            while($row = mysqli_fetch_array($query_run))
            {
                ?>
                    <tr>                              
                    <td style="width:10px; text-align:center;"><?php echo $i++; ?></td>
                    <td><?php echo $row['pname'];?></td>
                    <td><?php echo date('F j, Y',strtotime($row['schedule'])); ?></td>
                    <td><?php
                    if($row['starttime'] == ''){
                    echo '';
                    }
                    else
                    {
                    echo date('h:i A',strtotime($row['starttime']));
                    }?>
                    </td>
                    <td><?php
                    if($row['endtime'] == ''){
                    echo '';
                    }
                    else
                    {
                    echo date('h:i A',strtotime($row['endtime']));
                    }?></td>
                    <td><?php echo $row['schedtype'];?></td>
                    <td><?php
                    if($row['status'] == 'Confirmed')
                    {
                    echo $row['status'] = '<span class="badge badge-success">Confirmed</span>';
                    }
                    else if($row['status'] == 'Pending')
                    {
                    echo $row['status'] = '<span class="badge badge-warning">Pending</span>';
                    }
                    else if($row['status'] == 'Treated')
                    {
                    echo $row['status'] = '<span class="badge badge-primary">Treated</span>';
                    }
                    else if($row['status'] == 'No Show')
                    {
                    echo $row['status'] = '<span class="badge badge-secondary">No Show</span>';
                    }
                    else
                    {
                    echo $row['status'] = '<span class="badge badge-danger">Cancelled</span>';
                    }
                    ?>
                    </td>
                    </td>
                    <td>
                    <button type="button" data-id="<?php echo $row['id']; ?>" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>
                    <button type="button" data-id="<?php echo $row['id']; ?>" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>
                    </td>
                    </tr>
                <?php
            }
        }
        else
        {
            echo'
			<tr>
				<td colspan = "4"><center>Record Not Found</center></td>
			</tr>';
        }
    }
    ?>