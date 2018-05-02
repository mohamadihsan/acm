<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span><?= $menu ?></span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <!-- END PAGE TITLE-->

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box dark">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i> <?= $table_title ?> </div>
                        <div class="actions">
                            <?php
                            if ($view == 't') {
                                ?>
                                <button type="button" class="btn btn-default btn-sm btn-circle" data-target="#modalexport" data-toggle="modal">
                                    <i class="fa fa-download"></i> 
                                    Export  
                                </button>
                                <?php
                            }else{
                                ?>
                                <script>
                                    alert('akun anda tidak diperkenankan untuk mengakses data ini!');
                                </script>
                                <?php
                                
                                redirect('','refresh');
                                
                            }
                            ?>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover table-header-fixed dt-responsive" id="posts">
                            <thead>
                                <tr>
                                    <th class="all"> No </th>
                                    <th class="all"> Card Number </th>
                                    <th class="min-tablet"> Card Type </th>
                                    <th class="min-tablet"> Card Owner </th>
                                    <th class="min-tablet"> Active </th>
                                    <th class="all"> Status </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> No </th>
                                    <th> Card Number </th>
                                    <th> Card Type </th>
                                    <th> Card Owner </th>
                                    <th> Active </th>
                                    <th> Status </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->

<!-- MODAL EXPORT -->
<div id="modalexport" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
    <!-- <form id="exportExcel"> -->
    <form action="<?= base_url().'card/export' ?>" method="POST">
        <div class="modal-body">
            <i class="fa fa-download"></i> EXPORT
        </div>
        <div class="modal-body">
            <p> Export Data by Card Type: </p>
            <select name="i_card_type" id="i_card_type" class="form-control">
                <option value="all">All</option>
            <?php
                foreach ($card_type as $c) {
                    ?>
                    <option value="<?= $c->i_card_type ?>"><?= $c->n_card_type ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button>
            <button type="submit" class="btn blue">Export</button>
            <!-- <a href="<?= base_url().'card/export' ?>" class="btn blue" target="_blank">Export</a> -->
        </div>
    </form>
</div>
<!-- END MODAL EXPORT -->

<script>
    var save_method; //for save method string
    var table;

    $( document ).ready(function() {
        table =  $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "order":[],
            "language": {
                "lengthMenu": "Show _MENU_ records per page",
                "zeroRecords": "No matching records found",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": ""
            },
            "ajax":{
                "url": "<?php echo base_url() . 'card/all'; ?>",
                "type": "POST"
            },
            "columnDefs":[
                {
                    "width": "5%",
                    'orderable': false,
                    "searchable": false,
                    'targets': [0]
                },
                {
                    "width": "15%",
                    'targets': [1,3]
                },
                {
                    "width": "10%",
                    'targets': [2,4]
                },
                {
                    "width": "10%",
                    'targets': [5]
                },
                {
                    "className": "text-center", "targets":[0,2,4,5]
                }
            ]

	    });

        //set input/textarea/select event when change value, remove class error and remove text help block 
        $("input").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("textarea").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

        // Variable to hold request
        var request;

        // Bind to the submit event of our form
        $("#exportExcel").submit(function(event){

            // Prevent default posting of form - put here to work in case of errors
            event.preventDefault();

            // Abort any pending request
            if (request) {
                request.abort();
            }
            // setup some local variables
            var $form = $(this);

            // Let's select and cache all the fields
            var $inputs = $form.find("input, select, button, textarea");

            // Serialize the data in the form
            var serializedData = $form.serialize();

            // Let's disable the inputs for the duration of the Ajax request.
            // Note: we disable elements AFTER the form data has been serialized.
            // Disabled form elements will not be serialized.
            $inputs.prop("disabled", true);

            // Fire off the request to /form.php
            request = $.ajax({
                url: "<?= base_url().'card/export' ?>",
                type: "GET",
                data: serializedData
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR){
                // Log a message to the console
                console.log("Link Download, normal!");
                //if success reload ajax table
                $('#modalexport').modal('hide');
            });

            // Callback handler that will be called on failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                // Log the error to the console
                console.error(
                    "The following error occurred: "+
                    textStatus, errorThrown
                );
            });

            // Callback handler that will be called regardless
            // if the request failed or succeeded
            request.always(function () {
                // Reenable the inputs
                $inputs.prop("disabled", false);
            });

        });

    });

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }
     
</script>