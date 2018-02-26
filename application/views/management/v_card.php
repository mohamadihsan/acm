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
                    <span>Cards</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> Card Management
            <small>Pages</small>
        </h1>
        <!-- END PAGE TITLE-->

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-credit-card"></i>Card List </div>
                        <div class="actions">
                            <a href="javascript:;" class="btn btn-default btn-sm btn-circle">
                                <i class="fa fa-plus"></i> Block the Card</a>
                            <a href="javascript:;" class="btn btn-default btn-sm btn-circle">
                                <i class="fa fa-file-text-o"></i> Export </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover table-header-fixed" id="sample_2">
                            <thead>
                                <tr>
                                    <th> Rendering engine </th>
                                    <th> Browser </th>
                                    <th> Platform(s) </th>
                                    <th> Engine version </th>
                                    <th> CSS grade </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th> Rendering engine </th>
                                    <th> Browser </th>
                                    <th> Platform(s) </th>
                                    <th> Engine version </th>
                                    <th> CSS grade </th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <td> Trident </td>
                                    <td> Internet Explorer 4.0 </td>
                                    <td> Win 95+ </td>
                                    <td> 4 </td>
                                    <td> X </td>
                                </tr>
                                <tr>
                                    <td> Trident </td>
                                    <td> Internet Explorer 5.0 </td>
                                    <td> Win 95+ </td>
                                    <td> 5 </td>
                                    <td> C </td>
                                </tr>
                                <tr>
                                    <td> Trident </td>
                                    <td> Internet Explorer 5.5 </td>
                                    <td> Win 95+ </td>
                                    <td> 5.5 </td>
                                    <td> A </td>
                                </tr>
                                <tr>
                                    <td> Trident </td>
                                    <td> Internet Explorer 6 </td>
                                    <td> Win 98+ </td>
                                    <td> 6 </td>
                                    <td> A </td>
                                </tr>
                                <tr>
                                    <td> Trident </td>
                                    <td> Internet Explorer 7 </td>
                                    <td> Win XP SP2+ </td>
                                    <td> 7 </td>
                                    <td> A </td>
                                </tr>
                                <tr>
                                    <td> Trident </td>
                                    <td> AOL browser (AOL desktop) </td>
                                    <td> Win XP </td>
                                    <td> 6 </td>
                                    <td> A </td>
                                </tr>
                                <tr>
                                    <td> Gecko </td>
                                    <td> Firefox 1.0 </td>
                                    <td> Win 98+ / OSX.2+ </td>
                                    <td> 1.7 </td>
                                    <td> A </td>
                                </tr>
                                <tr>
                                    <td> Gecko </td>
                                    <td> Firefox 1.5 </td>
                                    <td> Win 98+ / OSX.2+ </td>
                                    <td> 1.8 </td>
                                    <td> A </td>
                                </tr>
                                <tr>
                                    <td> Gecko </td>
                                    <td> Firefox 2.0 </td>
                                    <td> Win 98+ / OSX.2+ </td>
                                    <td> 1.8 </td>
                                    <td> A </td>
                                </tr>
                                <tr>
                                    <td> Gecko </td>
                                    <td> Firefox 3.0 </td>
                                    <td> Win 2k+ / OSX.3+ </td>
                                    <td> 1.9 </td>
                                    <td> A </td>
                                </tr>
                                <tr>
                                    <td> Gecko </td>
                                    <td> Camino 1.0 </td>
                                    <td> OSX.2+ </td>
                                    <td> 1.8 </td>
                                    <td> A </td>
                                </tr>
                                <tr>
                                    <td> Gecko </td>
                                    <td> Camino 1.5 </td>
                                    <td> OSX.3+ </td>
                                    <td> 1.8 </td>
                                    <td> A </td>
                                </tr>
                                <tr>
                                    <td> Gecko </td>
                                    <td> Netscape 7.2 </td>
                                    <td> Win 95+ / Mac OS 8.6-9.2 </td>
                                    <td> 1.7 </td>
                                    <td> A </td>
                                </tr>
                            </tbody>
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




<?php
// $no = 1;
// foreach ($data as $d) {
    
//     $no++ 
//     $d->uid 
//     $d->c_card 
//     $d->n_card_type 
//     $d->c_people 
//     $d->d_active_card 

// }  
?>

<!-- <script>
    $(document).ready(function() {
        $('#example').DataTable( {
            
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('api/show_card'); ?>",
                "type": "GET",
                'beforeSend': function (request) {
                    request.setRequestHeader("Authorization", 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpX3VzZXIiOiIxIiwiaV9ncm91cF9hY2Nlc3MiOiIxIiwiZF9pbnNlcnQiOiIyMDE4LTAyLTE1IDA5OjQ4OjM3IiwiZXhwaXJlZCI6IjIwMTgtMDItMTYgMDk6NDg6MzciLCJ0ZXJtaW5hbF9pZCI6IkIwMSIsImNfbG9naW4iOiIyMDE4MDIxNTA5NDgzNyJ9.Lv7eulc46QM5bUmeJVsvXwtJXBaWCdUBZ5lmLhjQGu4');
                },
                error: function(){  // error handling
                    console.log('HAHAHHA');
                    alert('Token invalid / sudah kadaluarsa, Silahkan logout terlebih dahulu');
                    
                }
            },
            "columns": [
                { "data": "i_card" },
                { "data": "uid" },
                { "data": "c_card" },
                { "data": "n_card_type" },
                { "data": "c_people" },
                { "data": "d_active_card" }
            ]
        } );
    } );
    
</script> -->

