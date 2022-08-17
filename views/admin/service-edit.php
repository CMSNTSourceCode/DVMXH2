<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Chỉnh sửa dịch vụ',
    'desc'   => '',
    'keyword' => ''
];
$body['header'] = '
<!-- ckeditor -->
<script src="'.BASE_URL('public/ckeditor/ckeditor.js').'"></script>
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
';
require_once(__DIR__.'/../../models/is_admin.php');
if (isset($_GET['id'])) {
    $id = check_string($_GET['id']);
    if (!$row = $CMSNT->get_row("SELECT * FROM `services` WHERE `id` = '$id' ")) {
        redirect(base_url_admin('service-list'));
    }
} else {
    redirect(base_url_admin('service-list'));
}
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>
<?php
if (isset($_POST['SaveService'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if ($CMSNT->get_row("SELECT * FROM `services` WHERE `name` = '".check_string($_POST['name'])."' AND `id` != ".$row['id']." ")) {
        die('<script type="text/javascript">if(!alert("Tên chuyên mục đã tồn tại trong hệ thống.")){window.history.back().location.reload();}</script>');
    }
    if (check_img('icon') == true) {
        unlink($row['icon']);
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 4);
        $uploads_dir = 'assets/storage/images/service'.$rand.'.png';
        $tmp_name = $_FILES['icon']['tmp_name'];
        $addlogo = move_uploaded_file($tmp_name, $uploads_dir);
        if ($addlogo) {
            $CMSNT->update("services", [
                'icon' => $uploads_dir
            ], " `id` = '".$row['id']."' ");
        }
    }
    $isInsert = $CMSNT->update("services", [
        'name'          => check_string($_POST['name']),
        'slug'          => create_slug(check_string($_POST['name'])),
        'content'       => base64_encode($_POST['content']),
        'category_id'   => check_string($_POST['category_id']),
        'text_input'            => check_string($_POST['text_input']),
        'text_placeholder'      => check_string($_POST['text_placeholder']),
        'display'       => check_string($_POST['display'])
    ], " `id` = '".$row['id']."' ");
    if ($isInsert) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Chỉnh sửa chuyên mục (".$row['name']." ID ".$row['id'].")."
        ]);
        die('<script type="text/javascript">if(!alert("Lưu thành công!")){window.history.back().location.reload();}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Lưu thất bại!")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chỉnh sửa chuyên mục</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa bài viết</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                    <div class="mb-3">
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url_admin('service-list');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit mr-1"></i>
                                CHỈNH SỬA NHÓM DỊCH VỤ
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
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên chuyên mục</label>
                                    <input type="text" class="form-control" value="<?=$row['name'];?>" name="name"
                                        placeholder="Nhập tên chuyên mục" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Icon menu</label>
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
                                    <img src="<?=base_url($row['icon']);?>" width="50px">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chuyên mục</label>
                                    <select class="form-control" name="category_id" required>
                                        <option value="">* Chọn chuyên mục</option>
                                        <?php foreach($CMSNT->get_list("SELECT * FROM `categories` WHERE `display` = 1 ") as $category):?>
                                        <option <?=$row['category_id'] == $category['id'] ? 'selected' : '';?> value="<?=$category['id'];?>"><?=$category['name'];?></option>
                                        <?php endforeach?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả</label>
                                    <textarea id="content"
                                        name="content"><?=base64_decode($row['content']);?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Trạng thái</label>
                                    <select class="form-control" name="display" required>
                                        <option <?=$row['display'] == 1 ? 'selected' : '';?> value="1">Hiển thị</option>
                                        <option <?=$row['display'] == 0 ? 'selected' : '';?> value="0">Ẩn</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Text Input</label>
                                    <input type="text" class="form-control" name="text_input" placeholder="Nhập Link hoặc ID cần tăng" value="<?=$row['text_input'];?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Text Placeholder</label>
                                    <input type="text" class="form-control" name="text_placeholder" placeholder="Vui lòng nhập Link hoặc ID cần tăng" value="<?=$row['text_placeholder'];?>" required>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button name="SaveService" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script>
CKEDITOR.replace("content");
</script>
<?php
require_once(__DIR__.'/footer.php');
?>