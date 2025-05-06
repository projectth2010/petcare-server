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
            uploadMemberFile();
        });

        // call data for ref key.

        //.end call data for ref key.

        $('#dataTable').DataTable({
            "ajax": "/api/customer",
            "columns": [{
                'data': 'MemberID'
            }, {
                'data': 'Username'
            }, {
                'data': 'Password'
            }, {
                'data': 'Name'
            }, {
                'data': 'Email'
            }, {
                'data': 'Phone'
            }, {
                'data': 'ApproveStatus'
            }]
        });
        // Handle form submission for creating a new group
        $('#MemberForm').submit(function(event) {
            event.preventDefault();

            const MemberID = $('#MemberID').val()
            const Username = $('#Username').val()
            const Password = $('#Password').val()
            const Name = $('#Name').val()
            const Email = $('#Email').val()
            const Phone = $('#Phone').val()
            const ApproveStatus = $('#ApproveStatus').val()

            const data = {
                MemberID,
                Username,
                Password,
                Name,
                Email,
                Phone,
                ApproveStatus,
            };

            $.ajax({
                url: '/api/v1/customer',
                method: 'POST',
                data: data,
                success: function(response) {
                    showSuccessMessage("Member created successfully");
                    $('#addMemberModal').modal('hide');
                    // Refresh the table after successful deletion
                    fetchMembers();
                    clearMemberForm();
                },
                error: function() {
                    alert('Failed to create a new customer');
                }
            });
        });

        const apiUrl = '/api/v1/customer';

        function fetchMembers(page = 1, limit = 10) {
            const url = `${apiUrl}?page=${page}&limit=${limit}`;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    const res = response;
                    const totalPages = 1; //  data doesn't have pagination, so totalPages is always 1.
                    const currentPage = 1; //  data doesn't have pagination, so currentPage is always 1.

                    // Clear table body
                    $('#customersTable tbody').empty();

                    // Populate table with group data
                    res.forEach(function(itm) {
                        const row = `<tr>
                            <td>${itm.MemberID}</td><td>${itm.Username}</td><td>${itm.Password}</td><td>${itm.Name}</td><td>${itm.Email}</td><td>${itm.Phone}</td><td>${itm.ApproveStatus}</td>
                            
                            

                            <td><a href="#" class="btn-warning btn btn-warning btn-sm" data-customer-id="${itm.MemberID}">Edit</a> <a href="#" class="btn-delete btn btn-danger btn-sm" data-customer-id="${itm.MemberID}">Delete</a></td>
                        </tr>`;
                        $('#customersTable tbody').append(row);
                    });

                    // Render pagination buttons
                    renderPaginationButtons(currentPage, totalPages);
                },
                error: function() {
                    console.error('Failed to fetch customers data');
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

        fetchMembers();

        // Handle pagination button clicks
        $(document).on('click', '.btn-pagination', function() {
            const page = $(this).data('page');
            fetchMembers(page);
        });

        function deleteMember(id) {
            $.ajax({
                url: `/api/v1/customer/${id}`,
                method: 'DELETE',
                success: function() {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The customer has been deleted successfully.',
                        icon: 'success',
                        timer: 1500
                    }).then(() => {
                        // Refresh the table after successful deletion
                        fetchMembers();
                    });
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete the customer.',
                        icon: 'error'
                    });
                }
            });
        }

        // Event listener for the "Delete" button click
        $(document).on('click', '.btn-delete', function() {
            const dataId = $(this).data('customer-id');
            Swal.fire({
                title: 'Confirm Delete',
                text: 'Are you sure you want to delete this customer?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteMember(dataId);
                }
            });
        });



    });



    function clearMemberForm() {
        const form = $(`#MemberForm`);
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

                const url = `/api/v1/customer/activestatus/${fac_id}`;
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