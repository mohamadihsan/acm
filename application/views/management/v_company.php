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
                            <!-- <div id="add_button"></div> -->
                            <?php
                            if ($insert == 't') {
                                ?>
                                <button type="button" class="btn btn-default btn-sm btn-circle add_test" onclick="add_data()">
                                    <i class="fa fa-plus"></i> 
                                    Add Company
                                </button>
                                <?php
                            }
                            
                            if ($view == 't') {
                                ?>
                                <button type="button" class="btn btn-default btn-sm btn-circle" data-target="#export" data-toggle="modal">
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
                                    <th class="all"> Company Code </th>
                                    <th class="min-tablet"> Company Name </th>
                                    <th> Address </th>
                                    <th class="all"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> No </th>
                                    <th> Company Code </th>
                                    <th> Company Name </th>
                                    <th> Address </th>
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
        <h4 class="modal-title"><i class="fa fa-building"></i> COMPANY</h4>
    </div>
    <div class="modal-body">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light portlet-fit portlet-form bordered">
            <div class="portlet-body">
                <!-- BEGIN FORM-->
                <form action="#" id="form">

                    <input type="hidden" class="form-control" name="i_company" id="i_company" required>
                            
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" name="c_company" id="c_company" placeholder="Enter Code">
                            <label for="form_control_1">Company Code
                                <span class="required">*</span>
                            </label>
                            <span class="help-block">Enter Company Code...</span>
                        </div>
                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" name="n_company" id="form_control_1" placeholder="Enter your Fullname">
                            <label for="form_control_1">Company Name
                                <span class="required">*</span>
                            </label>
                            <span class="help-block">Enter Company Name...</span>
                        </div>
                        <div class="form-group form-md-line-input">
                            <textarea name="address" id="address" cols="30" rows="10" class="form-control"></textarea>
                            <label for="form_control_1">Address</label>
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
                "url": "<?php echo base_url() . 'company/all'; ?>",
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
                    'targets': [1]
                },
                {
                    "className": "text-center", "targets":[0,1,4]
                },
                {
                    'width': '20%',
                    'orderable': false, 
                    'targets': [4]
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
        $('.modal-title').text('ADD COMPANY'); // Set title to Bootstrap modal title
    }
    
    function edit_data(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
    
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('company/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
    
                $('[name="i_company"]').val(data.i_company);
                $('[name="c_company"]').val(data.c_company);
                $('[name="n_company"]').val(data.n_company);
                $('[name="address"]').val(data.address);
                $('#add_edit').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('EDIT COMPANY'); // Set title to Bootstrap modal title
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
            url = "<?php echo site_url('company/add')?>";
            message = 'Data successfully added';
        } else {
            url = "<?php echo site_url('company/update')?>";
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

    function delete_data(id)
    {
        
        if(confirm('Are you sure delete this data?'))
        {
            
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('company/delete')?>/"+id,
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