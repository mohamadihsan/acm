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
                            <button type="button" class="btn btn-default btn-sm btn-circle" onclick="add_data()">
                                <i class="fa fa-plus"></i> 
                                Add Non Employee
                            </button>
                            <button type="button" class="btn btn-default btn-sm btn-circle" data-target="#import" data-toggle="modal">
                                <i class="fa fa-upload"></i> 
                                    Import Data 
                            </button>
                            <button type="button" class="btn btn-default btn-sm btn-circle" data-target="#export" data-toggle="modal">
                            <i class="fa fa-download"></i> 
                                Export  
                            </button>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover table-header-fixed dt-responsive" id="posts">
                            <thead>
                                <tr>
                                    <th class="all"> No </th>
                                    <th class="all"> Identity Number </th>
                                    <th> Name </th>
                                    <th> Company </th>
                                    <th class="none"> Email </th>
                                    <th class="none"> Phone </th>
                                    <th class="min-tablet"> Status </th>
                                    <th class="desktop"> Card Active </th>
                                    <th class="all"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> No </th>
                                    <th> Identity Number </th>
                                    <th> Name </th>
                                    <th> Company </th>
                                    <th> Email </th>
                                    <th> Phone </th>
                                    <th> Status </th>
                                    <th> Card Active </th>
                                    <th> Action </th>
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

<!-- MODAL ADD & EDIT-->
<div id="add_edit" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
    <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-user"></i> NON EMPLOYEE</h4>
    </div>
    <div class="modal-body">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light portlet-fit portlet-form bordered">
            <div class="portlet-body">
                <!-- BEGIN FORM-->
                <form action="#" id="form">

                    <input type="hidden" class="form-control" name="i_people" id="i_people" required>
                            
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" name="c_people" id="c_people" placeholder="Enter ID">
                            <label for="form_control_1">Identity Number
                                <span class="required">*</span>
                            </label>
                            <span class="help-block">Enter your ID...</span>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" name="n_people" id="form_control_1" placeholder="Enter your Fullname">
                            <label for="form_control_1">Full Name
                                <span class="required">*</span>
                            </label>
                            <span class="help-block">Enter your fullname...</span>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="form_control_1" name="type_people" placeholder="Type" value="non employee" readonly>
                            <label for="form_control_1">Type</label>
                        </div>
                        <div class="form-group form-md-line-input">
                            <select class="form-control" name="c_company">
                                <option value="">Select</option>
                                <?php
                                foreach ($company as $c) {
                                    ?>
                                    <option value="<?= $c->c_company ?>"><?= $c->n_company ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <label for="form_control_1">Company
                                <span class="required">*</span>
                            </label>
                            <span class="help-block">Please Choice company...</span>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="form_control_1" name="email" placeholder="Enter your email">
                            <label for="form_control_1">Email
                                <span class="required"></span>
                            </label>
                            <span class="help-block">Please enter your email...</span>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" id="form_control_1" name="phone" placeholder="Enter phone number">
                            <label for="form_control_1">Phone Number
                                <span class="required"></span>
                            </label>
                            <span class="help-block">Please enter your phone...</span>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button>
                                <button type="button" id="btnSave" onclick="save()" class="btn blue">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>
<!-- END MODAL ADD & EDIT-->

<!-- MODAL IMPORT -->
<div id="import" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
<form action="#" id="form_import" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
            <i class="fa fa-upload"></i> IMPORT DATA
        </div>
        <div class="modal-body">
            <input type="file" name="file" id="file_excel" class="">
            <input type="hidden" name="type_people" id="type_people" value="non employee" readonly>
            <p>Select Company :</p>
            <select name="c_company" id="" class="form-control">
                <?php
                foreach ($company as $c) {
                    ?>
                    <option value="<?= $c->c_company ?>"><?= $c->n_company ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button>
            <button type="button" id="btnImport" onclick="import_data()" class="btn blue">Import</button>
        </div>
    </form>    
</div>
<!-- END MODAL IMPORT -->

<!-- <div id="import" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
<form action="<?= base_url().'excel/people/import' ?>"  method="POST" enctype="multipart/form-data">
        <div class="modal-header">
            <i class="fa fa-upload"></i> IMPORT DATA
        </div>
        <div class="modal-body">
            <input type="file" name="file" id="" class="form-control" require>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button>
            <button type="submit"  class="btn blue">Import</button>
        </div>
    </form>    
</div> -->

<!-- MODAL EXPORT -->
<div id="export" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
    <div class="modal-body">
        <i class="fa fa-download"></i> EXPORT
    </div>
    <div class="modal-body">
        <p> Export Data from date: </p>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button>
        <button type="button" class="btn blue">Export</button>
    </div>
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
                "zeroRecords": "Data Not Found...",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": ""
            },
            "ajax":{
                "url": "<?php echo base_url() . 'non_employee/all'; ?>",
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
                    "className": "text-center", "targets":[0,6,7,8]
                },
                {
                    "width": "17%",
                    'orderable': false,
                    "searchable": false,
                    'targets': [8]
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
    });

    function add_data()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#add_edit').modal('show'); // show bootstrap modal
        $('.modal-title').text('ADD NON EMPLOYEE'); // Set title to Bootstrap modal title
    }
    
    function edit_data(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
    
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('non_employee/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
    
                $('[name="i_people"]').val(data.i_people);
                $('[name="c_people"]').val(data.c_people);
                $('[name="n_people"]').val(data.n_people);
                $('[name="type_people"]').val(data.type_people);
                $('[name="c_company"]').val(data.c_company);
                $('[name="email"]').val(data.email);
                $('[name="phone"]').val(data.phone);
                $('[name="card_active"]').val(data.card_active);
                $('#add_edit').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('EDIT NON EMPLOYEE'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    
    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }
    
    function save()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var url;
        var message;

        if(save_method == 'add') {
            url = "<?php echo site_url('non_employee/add')?>";
            message = 'Data successfully added';
        } else {
            url = "<?php echo site_url('non_employee/update')?>";
            message = 'Data successfully updated';
        }

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
    
                if(data.status) //if success close modal and reload ajax table
                {
                    // notif add success
                    $(document).ready(function() {
                        toastr.success(message, 'Success')
                    });

                    $('#add_edit').modal('hide');
                    reload_table();
                }
                else
                {
                    for (var i = 0; i < data.inputerror.length; i++) 
                    {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
    
    
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                // notif add failed
                $(document).ready(function() {
                    toastr.error('Data failed to added', 'Error')
                }); 

                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
    
            }
        });
    }

    function import_data()
    {
        var form = new FormData($('#form_import')[0]);
        // var form = $(this).closest("#form_import").get(0);
        // console.log(form);
        $('#btnImport').text('importing...'); //change button text
        $('#btnImport').attr('disabled',true); //set button disable 

        var url = "<?php echo site_url('excel/people/import')?>";
        
        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: form,
            contentType: false,
            cache: false,
            dataType: "json",
            processData: false,
            success: function(data)
            {;
                if (data.status == 'success') {
                    
                    $('#btnImport').text('import'); //change button text
                    $('#btnImport').attr('disabled',false); //set button enable 

                    console.log("Import Success")

                    // notif add success
                    $(document).ready(function() {
                        toastr.success('Data successfully added', 'Success')
                    });

                    //if success reload ajax table
                    $('#import').modal('hide');
                    reload_table();  
 
                }else{
                    
                    $('#btnImport').text('import'); //change button text
                    $('#btnImport').attr('disabled',false); //set button enable

                    console.log("Import Failed");

                    // notif import failed
                    $(document).ready(function() {
                        toastr.error('Data failed to import', 'Error')
                    });

                }
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $('#btnImport').text('import'); //change button text
                $('#btnImport').attr('disabled',false); //set button enable 

                // notif import failed
                $(document).ready(function() {
                    toastr.error('File not found. Data failed to import', 'Error')
                });

                console.log(data.status);
                alert('Error import data');
    
            }
        });  
    }
    
    function delete_data(id)
    {
        
        if(confirm('Are you sure delete this data?'))
        {
            
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('non_employee/delete')?>/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    // notif delete failed
                    $(document).ready(function() {
                        toastr.success('Data successfully deleted')
                    });

                    //if success reload ajax table
                    $('#add_edit').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    // notif detele failed
                    $(document).ready(function() {
                        toastr.error('Data failed to deleted')
                    });

                    alert('Error deleting data');
                }
            });
            
        }
    } 
</script>