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
            <button type="button" class="btn btn-danger btn-sm btn-delete" id="deleteBtn"> Delete </button>
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
                $("#first_name").val(response.first_name);
                $("#last_name").val(response.last_name);
                $("#email").val(response.email);
                $("#office_id").val(response.office_id);
                $("#severity").val(response.severity);
                $("#description").val(response.description);
                $("#state").val(response.state);
                $("#remarks").val(response.remarks);
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

    $(document).on('click', '#deleteBtn', function() {
        let row = $(this).parents("tr")[0];
        let id = table.row(row).data().id;

        if (confirm("Are you sure you want to delete this office?")) {
            $.ajax({
                url: "<?= base_url('roles'); ?>/" + id,
                type: "DELETE",
                success: function(response) {
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Success',
                        body: JSON.stringify(response.message),
                        autohide: true,
                        delay: 3000
                    });
                    table.ajax.reload();
                },
                error: function(response) {

                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Error',
                        body: JSON.stringify(response.message),
                        autohide: true,
                        delay: 3000
                    });
                }
            });
        }

    });

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