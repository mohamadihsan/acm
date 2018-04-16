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
        <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="fa fa-reorder font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase"> Filter</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form role="form">
                            <div class="form-body">
                                <div class="col-md-3">
                                    <div class="form-group form-md-line-input has-info">
                                        <label for="form_control_1">Group</label>
                                        <select class="form-control" name="i_group" id="i_group">
                                            <?php
                                            foreach ($groups as $group) {
                                                ?>
                                                <option value="<?= $group->i_group ?>"><?= $group->n_group ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="col-md-1"> 
                                    <button type="button" id="filter" class="btn btn-sm blue">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>

            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box dark">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i> <?= $table_title ?> 
                        </div>
                        <div class="actions">
                            <button type="button" class="btn btn-default btn-sm btn-circle" onclick="add_data()">
                                <i class="fa fa-plus"></i> 
                                Add User Role
                            </button>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover table-header-fixed dt-responsive" id="posts">
                            <thead>
                                <tr>
                                    <th class="all"> No </th>
                                    <th class="all"> Menu </th>
                                    <th class="all"> Parent </th>
                                    <th class="min-tablet"> Group </th>
                                    <th class="all"> View </th>
                                    <th class="all"> Insert </th>
                                    <th class="all"> Update </th>
                                    <th class="all"> Delete </th>
                                    <th class="all"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> No </th>
                                    <th> Menu </th>
                                    <th> Parent </th>
                                    <th> Group </th>
                                    <th> View </th>
                                    <th> Insert </th>
                                    <th> Update </th>
                                    <th> Delete </th>
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

                    <input type="hidden" class="form-control" name="i_group_access" id="i_group_access" required>
                            
                    <div class="form-body">

                        <div id="select_disabled">
                            <div class="form-group form-md-line-input">
                                <select class="form-control" name="i_group_disabled" id="i_group_disabled">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($groups as $group) {
                                        ?>
                                        <option value="<?= $group->i_group ?>"><?= $group->n_group ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <label for="form_control_1">Group User 
                                    <span class="required">*</span>
                                </label>
                                <span class="help-block">Please Choice Group User...</span>
                            </div>
                            <div class="form-group form-md-line-input">
                                <select class="form-control" name="i_menu_disabled" id="i_menu_disabled">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($menus as $menu) {
                                        ?>
                                        <option value="<?= $menu->i_menu ?>"><?= $menu->n_menu ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <label for="form_control_1">Menu 
                                    <span class="required">*</span>
                                </label>
                                <span class="help-block">Please Choice Menu...</span>
                            </div>
                        </div>

                        
                        <div class="form-group form-md-line-input" id="select_i_group">
                            <select class="form-control" name="i_group" id="i_group">
                                <option value="">Select</option>
                                <?php
                                foreach ($groups as $group) {
                                    ?>
                                    <option value="<?= $group->i_group ?>"><?= $group->n_group ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <label for="form_control_1">Group User 
                                <span class="required">*</span>
                            </label>
                            <span class="help-block">Please Choice Group User...</span>
                        </div>
                        <div class="form-group form-md-line-input" id="select_i_menu">
                            <select class="form-control" name="i_menu" id="i_menu">
                                <option value="">Select</option>
                                <?php
                                foreach ($menus as $menu) {
                                    ?>
                                    <option value="<?= $menu->i_menu ?>"><?= $menu->n_menu ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <label for="form_control_1">Menu 
                                <span class="required">*</span>
                            </label>
                            <span class="help-block">Please Choice Menu...</span>
                        </div>
                        <!-- <div class="form-group">
                            <label class="mt-checkbox">View
                                <input type="checkbox" name="b_view"/>
                                <span></span>
                            </label>
                        </div>  
                        <div class="form-group">  
                            <label class="mt-checkbox">Insert
                                <input type="checkbox" name="b_insert"/>
                                <span></span>
                            </label>
                        </div>    
                        <div class="form-group">
                            <label class="mt-checkbox">Update
                                <input type="checkbox" name="b_update"/>
                                <span></span>
                            </label>
                        </div>    
                        <div class="form-group">
                            <label class="mt-checkbox">Delete
                                <input type="checkbox" name="b_delete"/>
                                <span></span>
                            </label>
                        </div>    
                    </div> -->
                    <div id="role"></div>
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

<script type="text/javascript">
    var TableDatatablesManaged = function () {

        var initTable1 = function () {

            var table = $('#posts');

            table.dataTable({
                "ajax": {
                    "url": "<?php echo base_url() . 'user_role/filter'; ?>",
                    "type": "POST",
                    "data": function (d) {
                        d.i_group = $('#i_group').val();
                        // console.log(d.i_group);
                    },
                },
                "serverSide": true,
                // "processing": true,
                "fnPreDrawCallback": function () {
                    $('#posts').addClass('loading')
                },
                "fnDrawCallback": function () {
                    setTimeout(function(){
                        $('#posts').removeClass('loading')
                    }, 1000);
                },
                "bStateSave": true,
                "pageLength": 10,
                "pagingType": "bootstrap_full_number",
                "columnDefs": [
                    {
                        "width": "5%",
                        'orderable': false,
                        "searchable": false,
                        'targets': [0]
                    },
                    {
                        "width": "15%",
                        'targets': [2]
                    },
                    {
                        "className": "text-center", "targets":[0,2,3,4,5,6,7]
                    },
                    {
                        'width': '10%',
                        'orderable': false, 
                        'targets': [3,4,5,6,7]
                    },
                    {
                        "width": "17%",
                        'orderable': false,
                        "searchable": false,
                        "className": "text-center",
                        'targets': [8]
                    }
                ],
                "order": [
                    [1, "asc"]
                ]
            });

            $('#filter').on("click", function () {
                var data_tables = $('#posts').DataTable();
                data_tables.draw();
            });
        }

        return {

            init: function () {
                if (!jQuery().dataTable) {
                    return;
                }

                initTable1();
            }

        };

    }();

    jQuery(document).ready(function () {
        TableDatatablesManaged.init();

        var data_tables = $('#posts').DataTable();

        data_tables.column(0).visible(true);

        // Fungsi chekbox
        $('#select_all').change(function(){
            var cells = data_tables.cells().nodes();
            $( cells ).find(':checkbox').prop('checked', $(this).is(':checked'));
        });
    });

    function add_data()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#add_edit').modal('show'); // show bootstrap modal
        $('.modal-title').text('ADD USER ROLE'); // Set title to Bootstrap modal title
        
        // $('#select_i_group').removeAttr('disabled');
        // $('#select_i_menu').removeAttr('disabled');
        $('#select_i_group').show();
        $('#select_i_menu').show();
        $('#select_disabled').hide();

        $('#role').html('<div class="form-group">'+
                        '<label class="mt-checkbox">View'+
                            '<input type="checkbox" name="b_view" value="t"/>'+
                            '<span></span>'+
                        '</label>'+
                    '</div>'+  
                    '<div class="form-group">'+  
                        '<label class="mt-checkbox">Insert'+
                            '<input type="checkbox" name="b_insert" value="t"/>'+
                            '<span></span>'+
                        '</label>'+
                    '</div> '+   
                    '<div class="form-group">'+
                        '<label class="mt-checkbox">Update'+
                            '<input type="checkbox" name="b_update" value="t"/>'+
                            '<span></span>'+
                        '</label>'+
                    '</div> '+   
                    '<div class="form-group">'+
                        '<label class="mt-checkbox">Delete'+
                            '<input type="checkbox" name="b_delete" value="t"/>'+
                            '<span></span>'+
                        '</label>'+
                    '</div> '+   
                '</div>');
    }
    
    function edit_data(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
    
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('user_role/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                if (data.b_view == 't') {
                    var b_view = 'checked';
                }
                if (data.b_insert == 't') {
                    var b_insert = 'checked';
                }
                if (data.b_update == 't') {
                    var b_update = 'checked';
                }
                if (data.b_delete == 't') {
                    var b_delete = 'checked';
                }
                
                $('#select_i_group').hide();
                $('#select_i_menu').hide();
                $('#select_disabled').show();
                $('[name="i_group_disabled"]').attr('disabled', 'disabled');
                $('[name="i_menu_disabled"]').attr('disabled', 'disabled');

                $('[name="i_group_access"]').val(data.i_group_access);
                $('[name="i_group_disabled"]').val(data.i_group);
                $('[name="i_menu_disabled"]').val(data.i_menu);
                $('[name="i_group"]').val(data.i_group);
                $('[name="i_menu"]').val(data.i_menu);
                $('#role').html('<div class="form-group">'+
                        '<label class="mt-checkbox">View'+
                            '<input type="checkbox" name="b_view" '+ b_view +'  value="t" />'+
                            '<span></span>'+
                        '</label>'+
                    '</div>'+  
                    '<div class="form-group">'+  
                        '<label class="mt-checkbox">Insert'+
                            '<input type="checkbox" name="b_insert" '+ b_insert +'  value="t" />'+
                            '<span></span>'+
                        '</label>'+
                    '</div> '+   
                    '<div class="form-group">'+
                        '<label class="mt-checkbox">Update'+
                            '<input type="checkbox" name="b_update" '+ b_update +'  value="t" />'+
                            '<span></span>'+
                        '</label>'+
                    '</div> '+   
                    '<div class="form-group">'+
                        '<label class="mt-checkbox">Delete'+
                            '<input type="checkbox" name="b_delete" '+ b_delete +'  value="t" />'+
                            '<span></span>'+
                        '</label>'+
                    '</div> '+   
                '</div>');
                
                $('#add_edit').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('EDIT USER ROLE'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    
    function reload_table()
    {
        // table.ajax.reload(); //reload datatable ajax 
        var data_tables = $('#posts').DataTable();
        data_tables.draw();
    }
    
    function save()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var url;
        var message;

        if(save_method == 'add') {
            url = "<?php echo site_url('user_role/add')?>";
            message = 'Data successfully added';
        } else {
            url = "<?php echo site_url('user_role/update')?>";
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
                url : "<?php echo site_url('user_role/delete')?>/"+id,
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