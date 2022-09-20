<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Paypal').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/jszip/jszip.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/pdfmake.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/vfs_fonts.js"></script>   
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
';

require_once(__DIR__.'/../../models/is_user.php');

if ($CMSNT->site('status_paypal') != 1) {
    redirect(base_url(''));
}

require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>

<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><?=__('PayPal');?></h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?=base_url();?>"><?=__('Trang chủ');?></a></li>
                                <li class="breadcrumb-item"><?=__('Nạp tiền');?></li>
                                <li class="breadcrumb-item active"><?=__('PayPal');?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="ribbon ribbon-primary ribbon-shape "><?=__('NẠP TIỀN TỰ ĐỘNG QUA PAYPAL');?></div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-lg-4 col-form-label required fw-bold fs-6"><?=__('Nhập số tiền cần nạp');?></label>
                                <div class="col-lg-8 fv-row">
                                    <input type="number" id="amount" class="form-control" name="amount"
                                        placeholder="<?=__('Nhập số tiền cần nạp bằng USD');?>" required />
                                    <input type="hidden" id="token" value="<?=$getUser['token'];?>" />
                                </div>
                            </div>
                           
                        </div>
                        <div class="card-footer text-center">
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card ribbon-box">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="ribbon ribbon-primary ribbon-shape "><?=__('LƯU Ý');?></div>
                            </div>
                            <?=$CMSNT->site('paypal_notice');?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card ribbon-box">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="ribbon ribbon-primary ribbon-shape "><?=__('LỊCH SỬ NẠP PAYPAL');?></div>
                            </div>
                            <div class="table-responsive p-0">
                                <table id="datatable2" class="table table-bordered table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th><?=__('Mã giao dịch');?></th>
                                            <th><?=__('Số tiền nạp');?></th>
                                            <th><?=__('Thực nhận');?></th>
                                            <th><?=__('Trạng thái');?></th>
                                            <th><?=__('Thời gian');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `payment_paypal` WHERE `user_id` = '".$getUser['id']."' ORDER BY `id` DESC ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><b><?=$row['trans_id'];?></b></td>
                                            <td><b style="color: red;">$<?=format_cash($row['amount']);?></b></td>
                                            <td><b style="color: green;"><?=format_currency($row['price']);?></b></td>
                                            <td>
                                                <p
                                                    class="mb-0 text-success font-weight-bold d-flex justify-content-start align-items-center">
                                                    <?=__('Thành công');?></p>
                                            </td>
                                            <td><?=$row['create_date'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->



    <?php require_once(__DIR__.'/footer.php');?>

    <script src="https://www.paypal.com/sdk/js?client-id=<?=$CMSNT->site('clientId_paypal');?>&currency=USD"></script>

    <script>
    (function($) {
        paypal.Buttons({

            // Sets up the transaction when a payment button is clicked
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: $('#amount')
                                .val() // Can reference variables or functions. Example: `value: document.getElementById('...').value`
                        }
                    }]
                });
            },

            // Finalize the transaction after payer approval
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    $.ajax({
                        url: '<?=BASE_URL('ajaxs/client/confirm-paypal.php');?>',
                        method: 'POST',
                        data: {
                            act: 'confirm',
                            token: '<?=$getUser['token'];?>',
                            order: orderData
                        },
                        success: function(response) {
                            const result = JSON.parse(response)
                            if (result.status == 'success') {
                                cuteToast({
                                    type: "success",
                                    message: result.msg,
                                    timer: 5000
                                });
                                setTimeout("location.href = '';", 2000);
                            } else {
                                cuteToast({
                                    type: "error",
                                    message: result.msg,
                                    timer: 5000
                                });
                            }
                        }
                    })
                });
            }
        }).render('#paypal-button-container');
    })(jQuery)
    </script>
    <script>
    $(function() {
        $('#datatable1').DataTable();
        $('#datatable2').DataTable();
    });
    </script>
    <script type="text/javascript">
    new ClipboardJS(".copy");

    function copy() {
        cuteToast({
            type: "success",
            message: "<?=__('Đã sao chép vào bộ nhớ tạm');?>",
            timer: 5000
        });
    }
    </script>