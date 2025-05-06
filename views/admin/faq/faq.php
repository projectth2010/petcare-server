<?php

include_once('./views/admin/_part/header_meta.php'); ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php
        include_once('./views/admin/_part/navbar_admin_lte.php');
        include_once('./views/admin/_part/aside_bar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Faqs</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                                <li class="breadcrumb-item active">Faqs</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Faqs</h3>
                                    <div class="card-tools">
                                        <!-- <a href="#" class="btn btn-tool btn-sm">
                      <i class="fas fa-download"></i>
                    </a>
                    <a href="#" class="btn btn-tool btn-sm">
                      <i class="fas fa-bars"></i>
                    </a> -->
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <!-- Add button for popup -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFaqModal">Add New</button>

                                    <table id="petsTable" class="table table-striped table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Accessstatus</th>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                    <div id="paginationContainer" class="d-flex justify-content-center mt-3"></div>

                                </div>
                            </div>
                            <!-- /.card -->

                            <!-- Add the modal for adding a new member -->
                            <div class="modal fade" id="addFaqModal" tabindex="-1" role="dialog" aria-labelledby="addFaqModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addMemberModalLabel">Add New Faq</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Add form to input data -->
                                            <!-- Add form to input Faq data -->
                                            <form id="FaqForm">
                                                <input type="text" name="FaqID" id="FaqID" value="">
                                                <div class="form-group">
                                                    <label for="FaqName">Faq Name:</label>
                                                    <input type="text" class="form-control" id="FaqName" name="FaqName" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Description">Description:</label>
                                                    <input type="text" class="form-control" id="Description" name="Description" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="AccessStatus">Access Status:</label>
                                                    <input type="text" class="form-control" id="AccessStatus" name="AccessStatus" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.popup modal -->
                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <?php include_once('./views/admin/_part/software_version.php'); ?>
    </div>
    <!-- ./wrapper -->

</body>
<?php include_once('./views/admin/_part/footer_admin_lte_script.php'); ?>
<?php include_once('./views/admin/faq/_js.php'); ?>
<?php include_once('./views/admin/_part/footer.php'); ?>