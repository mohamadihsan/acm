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
                        <table class="table table-striped table-bordered table-hover table-header-fixed" id="sample_2">
                            <thead>
                                <tr>
                                    <th> No </th>
                                    <th> Nomor Induk </th>
                                    <th> Nama Lengkap </th>
                                    <th> Perusahaan </th>
                                    <th> Email </th>
                                    <th> Status </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $no = 1;
                                foreach ($data as $d) {
                                    $c_people = $d->c_people; 
                                    $n_people = $d->n_people; 
                                    $n_company = $d->n_company; 
                                    $email = $d->email;
                                    $b_active = $d->b_active; 
                                    ?>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-left"><?= $c_people ?></td>
                                    <td class="text-left"><?= $n_people ?></td>
                                    <td class="text-left"><?= $n_company ?></td>
                                    <td class="text-left"><?= $email ?></td>
                                    <td class="text-center">
                                        <?php 
                                            if($b_active == 't'){
                                                ?>
                                                <span class="label label-success"> active </span>
                                                <?php
                                            }else{
                                                ?>
                                                <span class="label label-danger"> non active </span>
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> edit</a>
                                        <a href="" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> delete</a>    
                                    </td>
                                    <?php
                                }  
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> No </th>
                                    <th> Nomor Induk </th>
                                    <th> Nama Lengkap </th>
                                    <th> Perusahaan </th>
                                    <th> Email </th>
                                    <th> Status </th>
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