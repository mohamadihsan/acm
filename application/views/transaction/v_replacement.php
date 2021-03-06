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
                                        <label>Status Replacement</label>
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
                            <i class="fa fa-exchange"></i> <?= $table_title ?> </div>
                        <div class="actions">
                            <?php
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
                                    <th class="all"> New Card</th>
                                    <th class="all"> Old Card</th>
                                    <th> Card Type </th>
                                    <th class="min-tablet"> Card Owner </th>
                                    <th class="none"> Card Condition </th>
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
                                    <th> New Card</th>
                                    <th> Old Card</th>
                                    <th> Card Type </th>
                                    <th> Card Owner </th>
                                    <th> Card Condition </th>
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
                    "url": "<?php echo base_url() . 'trans/replacement/filter'; ?>",
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