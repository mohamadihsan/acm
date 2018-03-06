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
                    <span>Employee</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> Employee Management
            <small>Pages</small>
        </h1>
        <!-- END PAGE TITLE-->

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i>Employee List </div>
                        <div class="actions">
                            <a href="javascript:;" class="btn btn-default btn-sm btn-circle">
                                <i class="fa fa-plus"></i> 
                                Add Employee
                            </a>
                            <a href="javascript:;" class="btn btn-default btn-sm btn-circle">
                                <i class="fa fa-upload"></i> 
                                Import Data 
                            </a>
                            <a href="javascript:;" class="btn btn-default btn-sm btn-circle">
                                <i class="fa fa-download"></i> 
                                Export 
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover table-header-fixed dt-responsive" id="posts">
                            <thead>
                                <tr>
                                    <th> No </th>
                                    <th> Identity Number </th>
                                    <th> Name </th>
                                    <th> Company </th>
                                    <th> Status </th>
                                    <th> Card Active </th>
                                    <th> Action </th>
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

<script>
    $( document ).ready(function() {
        var dataTable =  $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "order":[],
            "language": {
                "lengthMenu": "Show _MENU_ records per page",
                "zeroRecords": "Data Not Found...",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)"
            },
            "ajax":{
                "url": "<?php echo base_url() . 'people/employee/all'; ?>",
                "type": "POST"
            },
            "scrollY": false,
            "columnDefs":[
                {
                    "target":[0],
                    "orderable":false
                },
                {
                    "target":[2],
                    "width": "40%"
                }
            ]

	    });
    });
</script>
