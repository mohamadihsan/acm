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
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i> <?= $table_title ?> </div>
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
                                    <th> No </th>
                                    <th> Card Number </th>
                                    <th> Card Type </th>
                                    <th> Card Owner </th>
                                    <th> Active </th>
                                    <th> Status </th>
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
                "url": "<?php echo base_url() . 'card/all'; ?>",
                "type": "POST"
            },
            "columnDefs":[
                {
                    "target":[-1],
                    "orderable":false,
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

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }
     
</script>