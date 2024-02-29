<?php
    if(isset($_SESSION['error']))
    {
        ?>
        <div class="alert alert-warning alert-dismissible fade show">
        <i class="icon fas fa-exclamation-triangle"></i>
        <?php echo $_SESSION['error'];?>
    
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
        unset($_SESSION['error']);      
    }

    if(isset($_SESSION['success']))
    {
        ?>
        <div class="alert alert-success alert-dismissible fade show">
        <i class="icon icon fas fa-check"></i>
        <?php echo $_SESSION['success'];?>
    
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
        unset($_SESSION['success']);      
    }

    if(isset($_SESSION['info']))
    {
        ?>
        <div class="alert alert-info alert-dismissible fade show">
        <i class="fas fa-info-circle"></i>
        <?php echo $_SESSION['info'];?>
    
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
        unset($_SESSION['info']);      
    }

    if(isset($_SESSION['danger']))
    {
        ?>
        <div class="alert alert-danger alert-dismissible fade show">
        <?php echo $_SESSION['danger'];?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
        unset($_SESSION['danger']);      
    }
?>