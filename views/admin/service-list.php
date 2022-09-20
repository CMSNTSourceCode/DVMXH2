<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Danh sách dịch vụ',
    'desc'   => '',
    'keyword' => ''
];
$body['header'] = '
    <!-- ckeditor -->
    <script src="'.BASE_URL('public/ckeditor/ckeditor.js').'"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
    <!-- bs-custom-file-input -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- Page specific script -->
    <script>
    $(function () {
    bsCustomFileInput.init();
    });
    </script> 
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
require_once(__DIR__.'/../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['AddService'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if ($CMSNT->get_row("SELECT * FROM `services` WHERE `name` = '".check_string($_POST['name'])."' ")) {
        die('<script type="text/javascript">if(!alert("Dịch vụ này đã tồn tại trong hệ thống.")){window.history.back().location.reload();}</script>');
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
    $isInsert = $CMSNT->insert("services", [
        'icon'          => $url_icon,
        'name'          => check_string($_POST['name']),
        'category_id'   => check_string($_POST['category_id']),
        'slug'          => create_slug(check_string($_POST['name'])),
        'content'       => base64_encode($_POST['content']),
        'notification'   => check_string($_POST['notification']),
        'text_input'            => check_string($_POST['text_input']),
        'text_placeholder'      => check_string($_POST['text_placeholder']),
        'display'       => check_string($_POST['display']),
        'create_date'   => gettime()
    ]);
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Thêm dịch vụ (".check_string($_POST['name']).") vào hệ thống."
        ]);
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "";}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm thất bại !")){window.history.back().location.reload();}</script>');
    }
}
?>



<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Danh sách dịch vụ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Danh sách dịch vụ</li>
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
                            data-target="#modal-AddService" type="button"><i class="fas fa-plus-circle mr-1"></i>Thêm
                            dịch vụ mới</button>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-th-list mr-1"></i>
                                DANH SÁCH DỊCH VỤ
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
                            <table id="listService" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5px;">Stt</th>
                                        <th>Icon</th>
                                        <th>Tên dịch vụ</th>
                                        <th>Chuyên mục</th>
                                        <th>Trạng thái</th>
                                        <th style="width: 30%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `services` ORDER BY category_id ASC ") as $row) {?>
                                    <tr>
                                        <td><textarea id="stt<?=$row['id'];?>" onchange="updateForm(`<?=$row['id'];?>`)"
                                                class="form-control" rows="1"><?=$row['stt'];?></textarea></td>
                                        <td><img src="<?=base_url($row['icon']);?>" width="50px"></td>
                                        <td><b><?=$row['name'];?></b></td>
                                        <td><?=getRowRealtime('categories', $row['category_id'], 'name');?> <a
                                                target="_blank"
                                                href="<?=base_url_admin('category-edit/'.$row['category_id']);?>"><i
                                                    class="fas fa-edit"></i></a></td>
                                        <td><?=display_status_product($row['display']);?></td>
                                        <td>
                                            <a aria-label="" href="<?=base_url('admin/service-edit/'.$row['id']);?>"
                                                style="color:white;" class="btn btn-info btn-sm btn-icon-left m-b-10"
                                                type="button">
                                                <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                            </a>
                                            <button style="color:white;" onclick="RemoveRow('<?=$row['id'];?>')"
                                                class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
                                                <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php
require_once(__DIR__.'/footer.php');
?>
<script>
$(function() {
    $('#listService').DataTable({
        order:[[4,"desc"]],
        pageLength: 10000
    });
});
</script>
<script type="text/javascript">
function updateForm(id) {
    $.ajax({
        url: "<?=BASE_URL("ajaxs/admin/update.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'changeService',
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

function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa Dịch Vụ",
        message: "Bạn có chắc chắn muốn xóa dịch vụ ID " + id + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/remove.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id,
                    action: 'removeService'
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
</script>
 

<div class="modal fade" id="modal-AddService">
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
                        <label for="exampleInputEmail1">Tên dịch vụ</label>
                        <input type="text" class="form-control" name="name" placeholder="Nhập tên dịch vụ" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Icon</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="icon">
                                <label class="custom-file-label" for="exampleInputFile">Choose
                                    file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Chuyên mục</label>
                        <select class="form-control" name="category_id" required>
                            <option value="">* Chọn chuyên mục</option>
                            <?php foreach($CMSNT->get_list("SELECT * FROM `categories` WHERE `display` = 1 ") as $category):?>
                            <option value="<?=$category['id'];?>"><?=$category['name'];?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Lưu ý</label>
                        <textarea id="content" name="content" placeholder="Nhập ghi chú cho dịch vụ nếu có"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Thông báo</label>
                        <input class="form-control" type="text" placeholder="Nhập thông báo nổi nếu có" name="notification">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Text Input</label>
                        <input type="text" class="form-control" name="text_input" placeholder="Nhập Link hoặc ID cần tăng" value="Nhập Link hoặc ID cần tăng" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Text Placeholder</label>
                        <input type="text" class="form-control" name="text_placeholder" placeholder="Vui lòng nhập Link hoặc ID cần tăng" value="Vui lòng nhập Link hoặc ID cần tăng" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Trạng thái</label>
                        <select class="form-control" name="display" required>
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button name="AddService" class="btn btn-primary btn-block" type="submit">THÊM NGAY</button>
                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">HUỶ</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
CKEDITOR.replace("content");
</script>