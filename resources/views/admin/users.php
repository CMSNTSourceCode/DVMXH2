<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Users',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
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
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
$users = $CMSNT->get_list("SELECT * FROM `users` ORDER BY id DESC  ");
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">T???ng th??nh vi??n</span>
                            <span class="info-box-number"><?=format_cash($CMSNT->num_rows("SELECT * FROM `users` "));?>
                                th??nh vi??n</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">S??? d?? th??nh vi??n</span>
                            <span
                                class="info-box-number"><?=format_currency($CMSNT->get_row("SELECT SUM(`money`) FROM `users` ")['SUM(`money`)']);?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Staff</span>
                            <span
                                class="info-box-number">Admin: <?=format_cash($CMSNT->num_rows("SELECT * FROM `users` WHERE `admin` = 1 "));?> / CTV: <?=format_cash($CMSNT->num_rows("SELECT * FROM `users` WHERE `ctv` = 1 "));?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-lock"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">T??i kho???n b??? v?? hi???u ho??</span>
                            <span
                                class="info-box-number"><?=format_cash($CMSNT->num_rows("SELECT * FROM `users` WHERE `banned` = 1 "));?>
                                t??i kho???n</span>
                        </div>
                    </div>
                </div>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-users mr-1"></i>
                                DANH S??CH TH??NH VI??N
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" id="form" method="post">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <a onclick="exportExcel()" href="javascript:;" type="button" class="btn btn-success btn-sm"><i class="fas fa-file-csv mr-1"></i>XU???T EXCEL</a>
                                        <a onclick="resetTopNap()" href="javascript:;" type="button" class="btn btn-info btn-sm"><i class="fas fa-funnel-dollar mr-1"></i>RESET TOP N???P</a>
                                    </div>
                                    <div class="col-sm-6">
                                        <button class="float-right btn btn-danger btn-sm" type="button"
                                            onclick="deleteConfirm()" name="btn_delete"><i
                                                class="fas fa-trash mr-1"></i>Delete</button>
                                    </div>
                                </div>
                                <div class="table-responsive p-0">
                                    <table id="datatable1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5px;"><input type="checkbox" name="check_all" id="check_all"
                                                        value="option1"></th>
                                                <th>T??i kho???n</th>
                                                <th>V??</th>
                                                <th>B???o m???t</th>
                                                <th>Admin</th>
                                                <th>CTV</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `users` ORDER BY id DESC  ") as $row) { ?>
                                            <tr>
                                                <td><input type="checkbox" data-id="<?=$row['id'];?>" name="checkbox"
                                                        class="checkbox" value="<?=$row['id'];?>" /></td>
                                                <td>
                                                    <ul>
                                                        <li>T??n ????ng nh???p: <b><?=$row['username'];?></b>
                                                            [<b><?=$row['id'];?></b>]</li>
                                                        <li>?????a ch??? Email: <b
                                                                style="color:green"><?=$row['email'];?></b></li>
                                                        <li>S??? ??i???n tho???i: <b style="color:blue"><?=$row['phone'];?></b>
                                                        </li>
                                                        <li>T??nh tr???ng: <?=display_banned($row['banned']);?></li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>S??? d?? kh??? d???ng: <b
                                                                style="color:blue"><?=format_currency($row['money']);?></b>
                                                        </li>
                                                        <li>T???ng s??? ti???n n???p: <b
                                                                style="color:red"><?=format_currency($row['total_money']);?></b>
                                                        </li>
                                                        <li>Chi???t kh???u gi???m gi??: <b><?=$row['chietkhau'];?>%</b></li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>IP: <b><?=$row['ip'];?></b></li>
                                                        <li>Status: <b><?=display_online($row['time_session']);?></b>
                                                        </li>
                                                        <li>Ng??y tham gia: <b><?=$row['create_date'];?></b></li>
                                                        <li>Ho???t ?????ng g???n ????y: <b><?=$row['update_date'];?></b></li>
                                                    </ul>
                                                </td>
                                                <td><?=display_mark($row['admin']);?></td>
                                                <td><?=display_mark($row['ctv']);?></td>
                                                <td>
                                                    <a aria-label=""
                                                        href="<?=base_url('admin/user-edit/'.$row['id']);?>"
                                                        style="color:white;"
                                                        class="btn btn-info btn-sm btn-icon-left m-b-10" type="button">
                                                        <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                    </a>
                                                    <button style="color:white;" onclick="RemoveRow(<?=$row['id'];?>)"
                                                        class="btn btn-danger btn-sm btn-icon-left m-b-10"
                                                        type="button">
                                                        <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                                    </button>
                                                    <a aria-label=""
                                                        href="<?=base_url('admin/login-user/'.$row['id']);?>"
                                                        style="color:white;" target="_blank"
                                                        class="btn btn-primary btn-sm btn-icon-left m-b-10" type="button">
                                                        <i class="fas fa-sign-in mr-1"></i><span class="">Login</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>



<?php
require_once(__DIR__.'/footer.php');
?>


<script type="text/javascript">
function resetTopNap() {
    cuteAlert({
        type: "question",
        title: "C???NH B??O",
        message: "H??? th???ng s??? reset l???i top n???p ti???n c???a to??n b??? user n???u b???n nh???n ?????ng ??",
        confirmText: "<?=__('?????ng ??');?>",
        cancelText: "<?=__('H???y');?>"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/reset.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    type: "resetTopNap"
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        location.reload();
                    } else {
                        cuteAlert({
                            type: "error",
                            title: "Error",
                            message: respone.msg,
                            buttonText: "Okay"
                        });
                    }
                },
                error: function() {
                    alert(html(response));
                    location.reload();
                }
            });
        }
    })
}
function exportExcel() {
    cuteAlert({
        type: "question",
        title: "C???NH B??O",
        message: "H??? th???ng s??? t???i v??? d??? li???u users n???u b???n x??c nh???n ?????ng ??",
        confirmText: "<?=__('?????ng ??');?>",
        cancelText: "<?=__('H???y');?>"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/exportExcel.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    type: "users"
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        downloadCSV(respone.filename, respone.accounts);
                    } else {
                        cuteAlert({
                            type: "error",
                            title: "Error",
                            message: respone.msg,
                            buttonText: "Okay"
                        });
                    }
                },
                error: function() {
                    alert(html(response));
                    location.reload();
                }
            });
        }
    })
}
function downloadCSV(filename, text) {
  var element = document.createElement('a');
  element.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(text));
  element.setAttribute('download', filename);
  element.style.display = 'none';
  document.body.appendChild(element);
  element.click();
  document.body.removeChild(element);
}

function postRemove(id) {
    $.ajax({
        url: "<?=BASE_URL('ajaxs/admin/removeUser.php');?>",
        type: 'POST',
        dataType: "JSON",
        data: {
            id: id
        },
        success: function(response) {
            if (response.status == 'success') {
                cuteToast({
                    type: "success",
                    message: "???? x??a th??nh c??ng item " + id,
                    timer: 3000
                });
            } else {
                cuteToast({
                    type: "error",
                    message: "???? x???y ra l???i khi xo?? item " + id,
                    timer: 5000
                });
            }
        }
    });
}

function deleteConfirm() {
    var result = confirm("B???n c?? th???c s??? mu???n x??a c??c b???n ghi ???? ch???n?");
    if (result) {
        var checkbox = document.getElementsByName('checkbox');
        for (var i = 0; i < checkbox.length; i++) {
            if (checkbox[i].checked === true) {
                postRemove(checkbox[i].value);
            }
        }
        location.reload();
    }
}
$(document).ready(function() {
    $('#check_all').on('click', function() {
        if (this.checked) {
            $('.checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $('.checkbox').each(function() {
                this.checked = false;
            });
        }
    });
    $('.checkbox').on('click', function() {
        if ($('.checkbox:checked').length == $('.checkbox').length) {
            $('#check_all').prop('checked', true);
        } else {
            $('#check_all').prop('checked', false);
        }
    });
});
</script>
<script type="text/javascript">
function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "C???NH B??O",
        message: "B???n c?? ch???c ch???n mu???n x??a th??nh vi??n ID " + id + " kh??ng ?",
        confirmText: "?????ng ??",
        cancelText: "H???y"
    }).then((e) => {
        if (e) {
            postRemove(id);
            location.reload();
        }
    })
}
</script>

<script>
$(function() {
    $('#datatable1').DataTable();
});
</script>