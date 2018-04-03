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
        $('.modal-title').text('DELETION CARD'); // Set title to Bootstrap modal title
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
            url = "<?php echo site_url('user_role/delete')?>";
            message = 'The card successfully deleted';
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
                    toastr.error('The card failed to delete', 'Error')
                }); 

                alert('Error to delete cards');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
    
            }
        });
    }
</script>            

<!-- <script>
    var save_method; //for save method string
    var table;

    $( document ).ready(function() {
        table =  $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "order":[],
            "language": {
                "lengthMenu": "Show _MENU_ records per page",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": ""
            },
            "ajax":{
                "url": "<?php echo base_url() . 'user_role/all'; ?>",
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
                    "className": "text-center", "targets":[0,2,3,4,5,6,7]
                },
                {
                    'width': '10%',
                    'orderable': false, 
                    'targets': [3,4,5,6,7]
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
        $('.modal-title').text('ADD USER ROLE'); // Set title to Bootstrap modal title
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
    
                $('[name="i_group_access"]').val(data.i_group_access);
                $('[name="c_company"]').val(data.c_company);
                $('[name="n_company"]').val(data.n_company);
                $('[name="address"]').val(data.address);
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
        table.ajax.reload(null,false); //reload datatable ajax 
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
</script> -->