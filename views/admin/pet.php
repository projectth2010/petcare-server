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
                            <h1 class="m-0">Categories</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                                <li class="breadcrumb-item active">Categories</li>
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
                                    <h3 class="card-title">Pets</h3>
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
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPetModal">Add New</button>

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
                            <div class="modal fade" id="addPetModal" tabindex="-1" role="dialog" aria-labelledby="addPetModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addMemberModalLabel">Add New Pet</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Add form to input data -->
                                            <!-- Add form to input Pet data -->
                                            <form id="PetForm">
                                                <input type="text" name="PetID" id="PetID" value="">
                                                <div class="form-group">
                                                    <label for="PetName">Pet Name:</label>
                                                    <input type="text" class="form-control" id="PetName" name="PetName" required>
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

<script>
    // Function to show SweetAlert success message
    function showSuccessMessage(message) {
        Swal.fire({
            title: 'Success!',
            text: message,
            icon: 'success',
            timer: 1500
        });
    }


    $(document).ready(function() {


        $('#uploadBtn').on('click', function() {
            uploadPetFile();
        });

        // call data for ref key.

        //.end call data for ref key.

        $('#dataTable').DataTable({
            "ajax": "petcare/api/pet",
            "columns": [{
                'data': 'PetID'
            }, {
                'data': 'PetName'
            }, {
                'data': 'Description'
            }, {
                'data': 'AccessStatus'
            }]
        });
        // Handle form submission for creating a new group
        $('#PetForm').submit(function(event) {
            event.preventDefault();

            const PetID = $('#PetID').val()
            const PetName = $('#PetName').val()
            const Description = $('#Description').val()
            const AccessStatus = $('#AccessStatus').val()

            const data = {
                PetID,
                PetName,
                Description,
                AccessStatus,
            };

            $.ajax({
                url: '/petcare/api/v1/pet',
                method: 'POST',
                data: data,
                success: function(response) {
                    showSuccessMessage("Pet created successfully");
                    $('#addPetModal').modal('hide');
                    // Refresh the table after successful deletion
                    fetchPets();
                    clearPetForm();
                },
                error: function() {
                    alert('Failed to create a new pet');
                }
            });
        });

        const apiUrl = '/petcare/api/v1/pet';

        function fetchPets(page = 1, limit = 10) {
            const url = `${apiUrl}?page=${page}&limit=${limit}`;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    const res = response;
                    const totalPages = 1; //  data doesn't have pagination, so totalPages is always 1.
                    const currentPage = 1; //  data doesn't have pagination, so currentPage is always 1.

                    // Clear table body
                    $('#petsTable tbody').empty();

                    // Populate table with group data
                    res.forEach(function(itm) {
                        const row = `<tr>
                            <td>${itm.PetID}</td><td>${itm.PetName}</td><td>${itm.Description}</td><td>${itm.AccessStatus}</td>
                            
                            

                            <td><a href="#" class="btn-warning btn btn-warning btn-sm" data-pet-id="${itm.PetID}">Edit</a> <a href="#" class="btn-delete btn btn-danger btn-sm" data-pet-id="${itm.PetID}">Delete</a></td>
                        </tr>`;
                        $('#petsTable tbody').append(row);
                    });

                    // Render pagination buttons
                    renderPaginationButtons(currentPage, totalPages);
                },
                error: function() {
                    console.error('Failed to fetch pets data');
                }
            });
        }

        function renderPaginationButtons(currentPage, totalPages) {
            const paginationContainer = $('#paginationContainer');
            paginationContainer.empty();

            for (let i = 1; i <= totalPages; i++) {
                const button = `<button class="btn btn-link btn-pagination ${currentPage === i ? 'active' : ''}" data-page="${i}">${i}</button>`;
                paginationContainer.append(button);
            }
        }

        fetchPets();

        // Handle pagination button clicks
        $(document).on('click', '.btn-pagination', function() {
            const page = $(this).data('page');
            fetchPets(page);
        });

        function deletePet(id) {
            $.ajax({
                url: `/petcare/api/v1/pet/${id}`,
                method: 'DELETE',
                success: function() {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The pet has been deleted successfully.',
                        icon: 'success',
                        timer: 1500
                    }).then(() => {
                        // Refresh the table after successful deletion
                        fetchPets();
                    });
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete the pet.',
                        icon: 'error'
                    });
                }
            });
        }

        // Event listener for the "Delete" button click
        $(document).on('click', '.btn-delete', function() {
            const dataId = $(this).data('pet-id');
            Swal.fire({
                title: 'Confirm Delete',
                text: 'Are you sure you want to delete this pet?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    deletePet(dataId);
                }
            });
        });



    });



    function clearPetForm() {
        const form = $(`#PetForm`);
        const inputs = form.find("input, select, textarea");

        inputs.each(function() {
            const input = $(this);
            const inputType = input.attr("type");

            if (inputType === "text" || inputType === "password" || inputType === "date" || inputType === "file" || inputType === "datetime" || inputType === "number") {
                input.val("");
            } else if (inputType === "checkbox" || inputType === "radio") {
                input.prop("checked", false);
            } else if (input.is("select")) {
                input.prop("selectedIndex", 0);
            } else if (input.is("textarea")) {
                input.val("");
            }
        });
    }




    function updateActiveStatus(fac_id, active_status) {
        // Show a confirmation alert using SweetAlert
        const ActiveStatus = active_status == "No" ? 'Yes' : 'No';

        Swal.fire({
            title: 'Update Active Status?',
            text: 'Are you sure you want to update the active status?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const data = {
                    ActiveStatus,
                };

                const url = `/petcare/api/v1/pet/activestatus/${fac_id}`;
                const method = 'PUT';

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function(response) {
                        showSuccessMessage("Facility updated successfully");
                        window.location.reload();
                    },
                    error: function() {
                        alert('Failed to update active status');
                    }
                });
            }
        });
    }
</script>

<?php
include_once('./views/admin/_part/footer.php'); ?>