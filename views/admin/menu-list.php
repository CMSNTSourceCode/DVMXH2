<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Danh sách menu',
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
    <!-- bs-custom-file-input -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- Page specific script -->
    <script>
    $(function () {
    bsCustomFileInput.init();
    });
    </script> 
';
require_once(__DIR__.'/../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['create'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    $url_icon = null;
    if (check_img('icon') == true) {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 4);
        $uploads_dir = 'assets/storage/images/icon'.$rand.'.png';
        $tmp_name = $_FILES['icon']['tmp_name'];
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
        if ($addlogo) {
            $url_icon = $uploads_dir;
        }
    }
    $isCreate = $CMSNT->insert("menu", [
        'menu_id'       => !empty($_POST['menu_id']) ? check_string($_POST['menu_id']) : 0,
        'name'          => check_string($_POST['name']),
        'href'          => check_string($_POST['href']),
        'icon'          => $url_icon,
        'target'        => isset($_POST['target']) ? check_string($_POST['target']) : '',
        'status'        => check_string($_POST['status'])
    ]);
    if ($isCreate) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Thêm menu (".check_string($_POST['name']).") vào hệ thống."
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "'.BASE_URL('admin/menu-list').'";}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm menu thất bại, vui lòng thử lại!")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Danh sách menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=base_url_admin();?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Danh sách menu</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                </section>
                <section class="col-lg-6 text-right">
                    <div class="mb-3">
                        <button class="btn btn-primary btn-icon-left m-b-10" data-toggle="modal"
                            data-target="#modal-AddMenu" type="button"><i class="fas fa-plus-circle mr-1"></i>Thêm
                            menu mới</button>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bars mr-1"></i>
                                DANH SÁCH MENU
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
                            <div class="table-responsive">
                                <table id="datatable1" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5px">Stt</th>
                                            <th>Icon</th>
                                            <th>Tên menu</th>
                                            <th>Liên kết</th>
                                            <th>Target</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach ($CMSNT->get_list(" SELECT * FROM `menu` ORDER BY id DESC  ") as $row) {
                                        ?>
                                        <tr>
                                        <td><textarea id="stt<?=$row['id'];?>" onchange="updateForm(`<?=$row['id'];?>`)"
                                                class="form-control" rows="1"><?=$row['stt'];?></textarea></td>
                                            <td><img src="<?=base_url($row['icon']);?>" width="50px"></td>
                                            <td><?=$row['name']; ?></td>
                                            <td><a href="<?=$row['href']; ?>" target="_blank"><?=$row['href']; ?></a>
                                            </td>
                                            <td><?=$row['target']; ?></td>
                                            <td><?=display_show_hide($row['status']); ?></td>
                                            <td>
                                                <a aria-label="" href="<?=base_url('admin/menu-edit/'.$row['id']); ?>"
                                                    style="color:white;"
                                                    class="btn btn-info btn-sm btn-icon-left m-b-10" type="button">
                                                    <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                </a>
                                                <button style="color:white;" onclick="RemoveRow('<?=$row['id']; ?>')"
                                                    class="btn btn-danger btn-sm" type="button">
                                                    <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function updateForm(id) {
    $.ajax({
        url: "<?=BASE_URL("ajaxs/admin/update.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'changeMenu',
            id: id,
            stt: $("#stt" + id).val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
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
function postRemove(id) {
    $.ajax({
        url: "<?=BASE_URL('ajaxs/admin/remove.php');?>",
        type: 'POST',
        dataType: "JSON",
        data: {
            id: id,
            action: 'removeMenu'
        },
        success: function(response) {
            if (response.status == 'success') {
                cuteToast({
                    type: "success",
                    message: "Đã xóa thành công item " + id,
                    timer: 3000
                });
            } else {
                cuteToast({
                    type: "error",
                    message: "Đã xảy ra lỗi khi xoá item " + id,
                    timer: 5000
                });
            }
        }
    });
}

function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác nhận xoá menu",
        message: "Bạn có chắc chắn muốn xóa menu ID (" + id + ") không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            postRemove(id);
            location.reload();
        }
    })
}
</script>
 

<div class="modal fade" id="modal-AddMenu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">THÊM DỊCH VỤ</h4>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên menu</label>
                        <input type="text" class="form-control" placeholder="Nhập tên menu cần tạo" name="name"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Menu cha</label>
                        <select class="form-control" name="menu_id" required>
                            <option value="0">Menu cha</option>
                            <?php foreach ($CMSNT->get_list("SELECT * FROM `menu` WHERE `status` = 1  AND `menu_id` = 0 ORDER BY `stt` ASC ") as $menu) {?>
                            <option value="<?=$menu['id'];?>"><?=$menu['name'];?></option>
                            <?php foreach ($CMSNT->get_list("SELECT * FROM `menu` WHERE `status` = 1  AND `menu_id` = '".$menu['id']."' ORDER BY `stt` ASC ") as $menu1) {?>
                            <option value="<?=$menu1['id'];?>">__<?=$menu1['name'];?></option>
                            <?php foreach ($CMSNT->get_list("SELECT * FROM `menu` WHERE `status` = 1  AND `menu_id` = '".$menu1['id']."' ORDER BY `stt` ASC ") as $menu2) {?>
                            <option value="<?=$menu2['id'];?>">____<?=$menu2['name'];?></option>
                            <?php }?>
                            <?php }?>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Liên kết</label>
                        <input type="text" class="form-control"
                            placeholder="Nhập địa chỉ liên kết cần tới khi click vào menu này" name="href" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Icon menu</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="icon" required>
                                <label class="custom-file-label" for="exampleInputFile">Choose
                                    file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Trạng thái</label>
                        <select class="form-control" name="status" required>
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="target" value="_blank"
                            id="customCheckbox2">
                        <label for="customCheckbox2" class="custom-control-label">Mở tab mới khi
                            click</label>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" name="create" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>THÊM
                        NGAY</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php
require_once(__DIR__.'/footer.php');
?>