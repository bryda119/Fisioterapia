<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Resaltar Contenido</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Resaltar Contenido</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            include('../../message.php');
                            ?>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Resaltar Contenido</h3>
                                </div>
                                <form action="../about/about_action.php" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php
                                                $sql = "SELECT * FROM header WHERE id='1' LIMIT 1";
                                                $query_run = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_array($query_run)) {
                                                ?>
                                                    <div class="form-group">
                                                        <label for="">Título</label><span class="text-danger">*</span>
                                                        <input type="text" name="title" value="<?= $row['title'] ?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Contenido</label>
                                                        <textarea rows="6" class="form-control" name="content" required><?= $row['content'] ?></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Subir Imagen</label>
                                                        <span class="text-danger">*</span><br>
                                                        <input type="file" name="files"><br>
                                                        <span class="direct-chat-timestamp text-sm">Tamaño Recomendado: 1000x600</span>
                                                        <input type="hidden" name="old_image" value="<?= $row['image'] ?>" id="old_image" />
                                                        <div class="col-sm-6">
                                                            <img src="../../../upload/<?= $row['image'] ?>" class="img-thumbnail img-fluid" width="140" alt="Image">
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <button type="submit" name="update_header" class="btn btn-primary">Actualizar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('../../includes/scripts.php'); ?>
        <?php include('../../includes/footer.php'); ?>