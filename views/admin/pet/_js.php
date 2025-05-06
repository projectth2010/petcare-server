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
            "ajax": "api/v1/pet",
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
            console.info(data);

            $.ajax({
                url: '/api/v1/pets',
                method: 'POST',
                contentType: "application/json", // Sending as JSON
                data: JSON.stringify(data), // Convert the JS object to a JSON string

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

        const apiUrl = '/api/v1/pets';

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
                url: `/api/v1/pet/${id}`,
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

                const url = `/api/v1/pet/activestatus/${fac_id}`;
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