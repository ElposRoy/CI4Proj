<?= $this -> extend('templates/admin_template'); ?>

<?= $this -> section('contentarea'); ?>


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Office Management</h1>
            </div><!-- /.col -->
            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
    <div class="m-4">

    <section class="content">
        <div class="container-fluid">
        <div class="row mb-4"><div class="col-sm-12 col-md-6"><div class="dt-buttons btn-group flex-wrap">
             <button class="btn btn-primary buttons-copy buttons-html5" data-toggle="modal" data-target="#modalID" tabindex="0" aria-controls="example1" type="button " onclick="clearform()"><span>Add office</span></button> 

             <!-- <button class="btn btn-secondary buttons-csv buttons-html5" tabindex="0" aria-controls="example1" type="button"><span>CSV</span></button> 

             <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="example1" type="button"><span>Excel</span></button> 

             <button class="btn btn-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="example1" type="button"><span>PDF</span></button> 

             <button class="btn btn-secondary buttons-print" tabindex="0" aria-controls="example1" type="button"><span>Print</span></button>

             
              <div class="btn-group"><button class="btn btn-secondary buttons-collection dropdown-toggle buttons-colvis" tabindex="0" aria-controls="example1" type="button" aria-haspopup="true">
                <span>Column visibility</span><span class="dt-down-arrow"></span></button></div> -->


             </div></div><div class="col-sm-12 col-md-6">
               </div></div>


            <div class="row">
                    <div class="col-md-12">
                    <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>OFFICE ID</th>
                            <th>CODE</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
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
              <h4 class="modal-title">Office Details</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form class="needs-validation" novalidate>
                            <div class="card-body">
                            <input type="hidden" id="id" name="id" >
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" class="form-control" id="code" name="code" placeholder="Enter Office Code" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid office code.
                                    </div>  
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Office Name" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid office name.
                                    </div>  
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Office Email" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a valid office email.
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


    <?= $this -> section('pagescript'); ?>
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
                        url: "<?= base_url('offices'); ?>",
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
                        url: "<?= base_url('offices'); ?>/" + formdata.id,
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
            url: "<?= base_url('offices/list'); ?>",
            type: "POST"
        },
        columns: [{
                data: "id"
            },
            {
                data: "code"
            },
            {
                data: "name"
            },
            {
                data: "email"
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
            url: "<?= base_url('offices'); ?>/" + id,
            type: "GET",
            success: function(response) {
                $('#modalID').modal('show');
                $("#id").val(response.id);
                $("#code").val(response.code);
                $("#name").val(response.name);
                $("#email").val(response.email);
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
                url: "<?= base_url('offices'); ?>/" + id,
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

    function clearform(){
        $("#id").val("");
        $("#code").val("");
        $("#name").val("");
        $("#email").val("");
    }
</script>
    <?= $this->endSection(); ?>