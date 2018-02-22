<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>

<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> -->

<main class="main-content bgc-grey-100">
	<div id="mainContent">
        <div class="container-fluid">
            <h4 class="c-grey-900 mT-10 mB-30"><i class="ti-credit-card"></i> Card Management</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>UID</th>
                                    <th>Nomor Kartu</th>
                                    <th>Tipe Kartu</th>
                                    <th>Pemilik</th>
                                    <th>Masa Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($data as $d) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $d->uid ?></td>
                                        <td><?= $d->c_card ?></td>
                                        <td><?= $d->n_card_type ?></td>
                                        <td><?= $d->c_people ?></td>
                                        <td><?= $d->d_active_card ?></td>
                                    </tr>
                                    <?php
                                }  
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>

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

