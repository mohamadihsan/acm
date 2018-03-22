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
                                <div class="col-md-2">
                                    <div class="form-group form-md-line-input has-info">
                                        <label>Start Date</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control input-sm" value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">    
                                <div class="form-group form-md-line-input has-info">
                                        <label>End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control input-sm" value="<?= date('Y-m-d') ?>">
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
                            <i class="fa fa-trash"></i> <?= $table_title ?> </div>
                        <div class="actions">
                            <button type="button" class="btn btn-danger btn-sm btn-circle" onclick="add_data()">
                                <i class="fa fa-plus"></i> 
                                Blacklist
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
                                    <th class="all"> Card</th>
                                    <th> Card Type </th>
                                    <th class="all"> Card Owner </th>
                                    <th class="none"> Company </th>
                                    <th class="all"> Date </th>
                                    <th class="none"> Description </th>
                                    <th class="all"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> No </th>
                                    <th> Card</th>
                                    <th> Card Type </th>
                                    <th> Card Owner </th>
                                    <th> Company </th>
                                    <th> Date </th>
                                    <th> Description </th>
                                    <th></th>
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
        <h4 class="modal-title"><i class="fa fa-trash"></i> BLACKLIST</h4>
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
                            <select class="form-control" name="c_card">
                                <option value="">Select</option>
                                <?php
                                foreach ($card as $c) {
                                    ?>
                                    <option value="<?= $c->c_card ?>"><?= $c->c_card ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <label for="form_control_1">Select the card to blacklist
                                <span class="required">*</span>
                            </label>
                            <span class="help-block">Please Choice the card...</span>
                        </div>
                        <div class="form-group form-md-line-input">
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                            <label for="form_control_1">Description / Reason</label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button>
                                <button type="button" id="btnSave" onclick="save()" class="btn red">Blacklist</button>
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

<script type="text/javascript">
    var TableDatatablesManaged = function () {

        var initTable1 = function () {

            var table = $('#posts');

            table.dataTable({
                "ajax": {
                    "url": "<?php echo base_url() . 'trans/blacklist/filter'; ?>",
                    "type": "POST",
                    "data": function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
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
                        "className": "text-center", "targets":[0,1,2,3,5,6,7]
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
        $('.modal-title').text('BLACKLIST'); // Set title to Bootstrap modal title
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
            url = "<?php echo site_url('trans/blacklist/delete')?>";
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
                    toastr.error('The card failed to blacklist', 'Error')
                }); 

                alert('Error to blacklist cards');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
    
            }
        });
    }

    function restore_data(id)
    {
        
        if(confirm('Are you sure to re-active this card?'))
        {
            
            // ajax restore data to database
            $.ajax({
                url : "<?php echo site_url('trans/blacklist/restore')?>/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    // notif delete failed
                    $(document).ready(function() {
                        toastr.success('The card has been reactivated')
                    });

                    //if success reload ajax table
                    $('#add_edit').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    // notif detele failed
                    $(document).ready(function() {
                        toastr.error('The card failed to reactivate')
                    });

                    alert('Error restoring data');
                }
            });
            
        }
    } 
</script>            