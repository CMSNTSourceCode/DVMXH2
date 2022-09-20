<?php

define("IN_SITE", true);

require_once(__DIR__ . "/../../libs/db.php");
require_once(__DIR__ . "/../../libs/helper.php");
require_once(__DIR__ . '/../../models/is_admin.php');
require_once(__DIR__ . "/../../libs/database/users.php");

if (!$row = $CMSNT->get_row(" SELECT * FROM `ranks` WHERE `id` = '" . check_string($_GET['id']) . "' ")) {
    die('<script type="text/javascript">if(!alert("Item không tồn tại trong hệ thống")){location.reload();}</script>');
}
if (isset($_POST['SaveItem'])) {
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){location.href=`' . base_url_admin('withdraw-list') . '`;}</script>');
    }
    $isUpdate = $CMSNT->update('ranks', [
        'name'      => !empty($_POST['name']) ? check_string($_POST['name']) : NULL,
        'discount'  => !empty($_POST['discount']) ? check_string($_POST['discount']) : NULL,
        'target'    => !empty($_POST['target']) ? check_string($_POST['target']) : NULL,
        'detail'    => !empty($_POST['detail']) ? base64_encode($_POST['detail']) : NULL
    ], " `id` = '" . $row['id'] . "' ");
    if ($isUpdate) {
        die('<script type="text/javascript">if(!alert("Lưu thành công!")){location.href=`' . base_url_admin('rank-list') . '`;}</script>');
    }
    die('<script type="text/javascript">if(!alert("Lưu thất bại!")){location.href=`' . base_url_admin('rank-list') . '`;}</script>');
}
?>


<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<div class="modal-header">
    <h5 class="modal-title" id="CharginModalTitle">Chỉnh sửa item ID <?= $row['id']; ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div id="modalContent" class="modal-body">
    <form method="POST" action="<?= BASE_URL('ajaxs/admin/rank-edit.php?id=' . $row['id']); ?>" accept-charset="UTF-8">
        <div class="form-group">
            <label>Tên cấp bậc</label>
            <input type="text" class="form-control" value="<?=$row['name'];?>" placeholder="Vui lòng nhập tên cấp bậc" name="name">
        </div>
        <div class="form-group">
            <label>Chiết khấu giảm giá</label>
            <input type="text" class="form-control" value="<?=$row['discount'];?>" placeholder="Vui lòng nhập chiết khấu giảm giá" name="discount">
        </div>
        <div class="form-group">
            <label>Mốc tổng nạp</label>
            <input type="number" class="form-control" value="<?=$row['target'];?>" placeholder="Vui lòng nhập mốc tổng nạp" name="target">
        </div>
        <div class="form-group">
            <label>Chi tiết</label>
            <textarea name="detail" id="detailedit" rows="6" placeholder="Nhập nội dung chi tiết về cấp bậc"  ><?=base64_decode($row['detail']);?></textarea>
        </div>
        <div class="form-group">
            <button type="submit" name="SaveItem" class="btn btn-primary btn-block">LƯU THAY ĐỔI</button>
            <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-block">HUỶ
                THAY ĐỔI</button>
        </div>
    </form>
</div>

<script>
$(function() {
    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("detailedit"), {
        mode: "htmlmixed",
        theme: "monokai"
    });
})
</script>