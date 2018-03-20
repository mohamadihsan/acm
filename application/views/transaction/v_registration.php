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
                                        <label>Status Registration</label>
                                        <select class="form-control input-sm" id="c_status">
                                            <option value="">-- All --</option>
                                            <option value="t">Success</option>
                                            <option value="f">Failed</option>
                                        </select>
                                    </div>
                                </div>
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
                            <i class="fa fa-file-text-o"></i> <?= $table_title ?> </div>
                        <div class="actions">
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
                                    <th> Registration Code </th>
                                    <th class="all"> Card</th>
                                    <th> Card Type </th>
                                    <th class="all"> Card Owner </th>
                                    <th class="none"> Card Owner Name </th>
                                    <th class="none"> Company </th>
                                    <th> Status </th>
                                    <th class="none"> Description </th>
                                    <th class="all"> Date </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> No </th>
                                    <th> Registration Code </th>
                                    <th> Card</th>
                                    <th> Card Type </th>
                                    <th> Card Owner </th>
                                    <th> Card Owner Name </th>
                                    <th> Company </th>
                                    <th> Status </th>
                                    <th> Description </th>
                                    <th> Date </th>
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
        <h4 class="modal-title"><i class="fa fa-user"></i> EMPLOYEE</h4>
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
                            <input type="text" class="form-control" id="form_control_1" name="type_people" placeholder="Type" value="employee" readonly>
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
            <input type="hidden" name="type_people" id="type_people" value="employee" readonly>
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

<script type="text/javascript">
    var TableDatatablesManaged = function () {

        var initTable1 = function () {

            var table = $('#posts');

            table.dataTable({
                "ajax": {
                    "url": "<?php echo base_url() . 'trans/registration/filter'; ?>",
                    "type": "POST",
                    "data": function (d) {
                        d.c_status = $('#c_status').val();
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
                        "width": "10%",
                        'targets': [3]
                    },
                    {
                        "width": "15%",
                        'targets': [9]
                    },
                    {
                        "className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8,9]
                    }
                ],
                "order": [
                    [1, "asc"]
                ]
            });

            $('#filter').on("click", function () {
                var data_tables = $('#posts').DataTable();
                // var c_status = $("#c_status").val();
                // var start_date = $("#start_date").val();
                // var end_date = $("#end_date").val();
    
                // if (c_status == 't') {
                //     btnapproval.addClass("hidden");
                //     data_tables.column(0).visible(false);
                // }
                // else {
                //     btnapproval.removeClass("hidden");
                //     data_tables.column(0).visible(true);
                // }

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
</script>            