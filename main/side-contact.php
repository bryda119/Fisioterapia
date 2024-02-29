    <div class="card">
        <div class="card-header bg-light text-center">
            <h3 class="p-2">Clinic Info</h3>
        </div>
        <div class="card-body">
            <img src="upload/<?= $system_logo ?>" class="img-fluid mx-auto d-block" width="150" alt="">
            <ul class="ml-4 mb-0 fa-ul text-muted">
                <li><span class="fa-li"><i class="fas fa-lg fa-calendar-week"></i></span> <?php include('admin/range-days.php') ?> <?= $row['openhr'] . ' - ' . $row['closehr'] ?> </li>
                <li><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> <?= $address ?></li>
                <li><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> <?= $mobile ?></li>
                <li><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> <?= $email ?></li>

            </ul>
        </div>
    </div>