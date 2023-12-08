<?= $this->extend('templates/admin_template'); ?>

<?= $this->section('contentarea'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Role Management</h1>
               
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
       
        <div class="row">
            <div class="col-md-12">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>USER ID</th>
                            <th>USERNAME</th>
                            <th>ACTIVE</th>
                            <th>ROLE</th>
                            <th>CREATED AT</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
      
        <div class="modal fade" id="modalID">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">TICKET Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" novalidate>
                            <div class="card-body">
                                <input type="hidden" id="id" name="id">
                                <div class="form-group">
                                    <label for="group">Role</label>
                                    <input type="text" class="form-control" id="group" name="group" placeholder="Enter a role" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a Role.
                                    </div>
                                </div>



                            
                            
                                
                           
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('pagescript'); ?>
<script>
    $(function() {

        $('form').submit(function(e) {
            e.preventDefault();

            let formdata = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            let jsondata = JSON.stringify(formdata);

            if (this.checkValidity()) {

                if (!formdata.id) {
                    $.ajax({
                        url: "<?= base_url('roles'); ?>",
                        type: "POST",
                        data: jsondata,
                        success: function(response) {
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                title: 'Success',
                                body: JSON.stringify(response.message),
                                autohide: true,
                                delay: 3000
                            });
                            $('#modalID').modal('hide');
                            table.ajax.reload();
                        },
                        error: function(response) {
                            let parsedresponse = JSON.parse(response.responseText);

                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Error',
                                body: JSON.stringify(parsedresponse.message),
                                autohide: true,
                                delay: 3000
                            });
                        }

                    });
                } else {
                    $.ajax({
                        url: "<?= base_url('roles'); ?>/" + formdata.id,
                        type: "PUT",
                        data: jsondata,
                        success: function(response) {
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                title: 'Success',
                                body: JSON.stringify(response.message),
                                autohide: true,
                                delay: 3000
                            });
                            $('#modalID').modal('hide');
                            table.ajax.reload();
                        },
                        error: function(response) {
                            let parsedresponse = JSON.parse(response.responseText);

                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Error',
                                body: JSON.stringify(parsedresponse.message),
                                autohide: true,
                                delay: 3000
                            });
                        }

                    });
                }


            }

        });

    });


    let table = $('#dataTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        paging: true,
        lengthChange: true,
        lengthMenu: [5, 10, 20, 50],
        searching: true,
        ordering: true,
        ajax: {
            url: "<?= base_url('roles/list'); ?>",
            type: "POST"
        },
        columns: [{
                data: "id"
            },
            {
                data: "username"
            },
            {
                data: "active"
            },
            {
                data: "role"
            },
            {
                data: "created_at"
            },
            {
                data: "",
                defaultContent: `
            <td>
            <button type="button" class="btn btn-primary btn-sm btn-edit" id="editBtn"> Edit </button>
          
            </td>
            `
            }
        ]
    });

    $(document).on('click', '#editBtn', function() {
        let row = $(this).parents("tr")[0];
        let id = table.row(row).data().id;

        $.ajax({
            url: "<?= base_url('roles'); ?>/" + id,
            type: "GET",
            success: function(response) {
                $('#modalID').modal('show');
                $("#id").val(response.id);
                $("#group").val(response.role);
              
            },
            error: function(response) {
                let parsedresponse = JSON.parse(response.responseText);

                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Error',
                    body: JSON.stringify(parsedresponse.message),
                    autohide: true,
                    delay: 3000
                });
            }

        });
    });



    // $(document).on('click', '#deleteBtn', function() {
    //     let row = $(this).parents("tr")[0];
    //     let id = table.row(row).data().id;

    //     if (confirm("Are you sure you want to delete this office?")) {
    //         $.ajax({
    //             url: "<?= base_url('roles'); ?>/" + id,
    //             type: "DELETE",
    //             success: function(response) {
    //                 $(document).Toasts('create', {
    //                     class: 'bg-success',
    //                     title: 'Success',
    //                     body: JSON.stringify(response.message),
    //                     autohide: true,
    //                     delay: 3000
    //                 });
    //                 table.ajax.reload();
    //             },
    //             error: function(response) {

    //                 $(document).Toasts('create', {
    //                     class: 'bg-danger',
    //                     title: 'Error',
    //                     body: JSON.stringify(response.message),
    //                     autohide: true,
    //                     delay: 3000
    //                 });
    //             }
    //         });
    //     }

    // });

    $(document).ready(function() {
        'user strict';
        let form = $(".needs-validation");
        form.each(function() {
            $(this).on("submit", function(e) {
                if (this.checkValidity() === false) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                $(this).addClass("was-validated");
            });
        });
    });

    function clearform() {
        $("#id").val("");
        $("#first_name").val("");
        $("#last_name").val("");
        $("#email").val("");
        $("#office_id").val("");
        $("#severity").val("");
        $("#description").val("");
        $("#state").val("");
        $("#remarks").val("");
    }
</script>
<?= $this->endSection(); ?>