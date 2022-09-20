<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Quản lý cấp bậc',
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
    if (isset($_POST['AddItem'])) {
        if ($CMSNT->site('status_demo') != 0) {
            die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
        }
        $isInsert = $CMSNT->insert('ranks', [
            'name'      => !empty($_POST['name']) ? check_string($_POST['name']) : NULL,
            'discount'  => !empty($_POST['discount']) ? check_string($_POST['discount']) : NULL,
            'target'    => !empty($_POST['target']) ? check_string($_POST['target']) : NULL,
            'detail'    => !empty($_POST['detail']) ? base64_encode($_POST['detail']) : NULL
        ]);
        if($isInsert){
            die('<script type="text/javascript">if(!alert("Thêm thành công !")){location.href = "'.BASE_URL('admin/rank-list').'";}</script>');
        }
        die('<script type="text/javascript">if(!alert("Thêm thất bại !")){window.history.back().location.reload();}</script>');
    } ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý cấp bậc</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=base_url_admin();?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Quản lý cấp bậc</li>
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

                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-plus mr-1"></i>
                                THÊM CẤP BẬC MỚI
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
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label>Tên cấp bậc</label>
                                    <input type="text" class="form-control" placeholder="Vui lòng nhập tên cấp bậc" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Chiết khấu giảm giá</label>
                                    <input type="text" class="form-control" placeholder="Vui lòng nhập chiết khấu giảm giá" name="discount">
                                </div>
                                <div class="form-group">
                                    <label>Mốc tổng nạp</label>
                                    <input type="number" class="form-control" placeholder="Vui lòng nhập mốc tổng nạp" name="target">
                                    <i>Khi user đạt đến tổng nạp bằng mốc, user đó sẽ được set chiết khấu giảm giá.</i>
                                </div>
                                <div class="form-group">
                                    <label>Chi tiết</label>
                                    <textarea name="detail" id="detailadd" rows="3" placeholder="Nhập nội dung chi tiết về cấp bậc"
                                        class="form-control"><ul class="list-unstyled vstack gap-3">

<!-- BẮT ĐẦU ROW DẤU TÍCH-->
<li>
  <div class="d-flex">
    <div class="flex-shrink-0 text-success me-1">
      <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
    </div>
    <div class="flex-grow-1">
      <b>Giảm giá:</b> 1%
    </div>
  </div>
</li>
<!-- KẾT THÚC ROW DẤU TÍCH-->

<!-- BẮT ĐẦU ROW DẤU TÍCH-->
<li>
  <div class="d-flex">
    <div class="flex-shrink-0 text-success me-1">
      <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
    </div>
    <div class="flex-grow-1">
      <b>Support:</b> Có
    </div>
  </div>
</li>
<!-- KẾT THÚC ROW DẤU TÍCH-->

<!-- BẮT ĐẦU ROW DẤU X-->
<li>
  <div class="d-flex">
    <div class="flex-shrink-0 text-danger me-1">
      <i class="ri-close-circle-fill fs-15 align-middle"></i>
    </div>
    <div class="flex-grow-1">
     <b>Website riêng:</b> Không
    </div>
  </div>
</li>
<!-- KẾT THÚC ROW DẤU X-->

</ul></textarea>
                                </div>
                                <button name="AddItem" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                        class="fas fa-save mr-1"></i>Lưu Ngay</button>
                            </form>
                        </div>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bars mr-1"></i>
                                DANH SÁCH CẤP BẬC
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
                                            <th width="5px">#</th>
                                            <th>TÊN CẤP BẬC</th>
                                            <th>CHIẾT KHẤU</th>
                                            <th>MỐC TỔNG NẠP</th>
                                            <th>CHI TIẾT</th>
                                            <th>THAO TÁC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $i = 0;
                                    foreach ($CMSNT->get_list(" SELECT * FROM `ranks` ORDER BY id DESC  ") as $row) {
                                        ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$row['name']; ?></td>
                                            <td><?=$row['discount']; ?>%</td>
                                            <td><?=format_currency($row['target']); ?></td>
                                            <td><textarea class="form-control"
                                                    readonly><?=base64_decode($row['detail']); ?></textarea></td>
                                            <td>
                                                <button class="edit-charging-btn btn btn-sm btn-info"
                                                    data-id="<?=$row['id'];?>" type="button">
                                                    <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                                </button>
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
function postRemove(id) {
    $.ajax({
        url: "<?=BASE_URL('ajaxs/admin/remove.php');?>",
        type: 'POST',
        dataType: "JSON",
        data: {
            id: id,
            action: 'removeRank'
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
        title: "Xác nhận xoá item",
        message: "Bạn có chắc chắn muốn xóa item này không ?",
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

<div class="modal fade" id="AjaxModal" tabindex="-1" role="dialog" aria-labelledby="AjaxModal"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div id="ModalAjaxContent"></div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $(".edit-charging-btn").click(function() {
        var id = $(this).attr('data-id');
        $("#ModalAjaxContent").html('');
        $.get("<?=BASE_URL('ajaxs/admin/rank-edit.php?id=');?>" + id, function(data) {
            $("#ModalAjaxContent").html(data);
        });
        $("#AjaxModal").modal();
    });
});
</script>

<script>
$(function() {
    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("detailadd"), {
        mode: "htmlmixed",
        theme: "monokai"
    });
})
</script>

<?php
require_once(__DIR__.'/footer.php');
?>