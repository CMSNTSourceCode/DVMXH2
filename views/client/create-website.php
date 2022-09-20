<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Tạo Website Riêng').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
<!-- CodeMirror -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/codemirror.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/theme/monokai.css">
';
$body['footer'] = '
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
<!-- CodeMirror -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/codemirror.js"></script>
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/mode/css/css.js"></script>
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/mode/xml/xml.js"></script>
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
';

require_once(__DIR__.'/../../models/is_user.php');

if($CMSNT->site('status_create_website') != 1){
    redirect(base_url());
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
                        <h4 class="mb-sm-0"><?=__('Tạo website riêng');?></h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?=base_url();?>"><?=__('Trang chủ');?></a></li>
                                <li class="breadcrumb-item active"><?=__('Tạo website riêng');?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card ribbon-box">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="ribbon ribbon-primary ribbon-shape "><?=__('TẠO WEBSITE RIÊNG');?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div>
                                        <label for="basiInput" class="form-label">Token API</label>
                                        <div class="input-group mb-2">
                                            <input type="text" id="copyToken" class="form-control" readonly
                                                value="<?=$getUser['token'];?>">
                                            <button onclick="copy()" data-clipboard-target="#copyToken"
                                                class="btn btn-primary copy" type="button"><?=__('COPY');?></button>
                                        </div>
                                        <div class="alert alert-primary alert-dismissible alert-outline fade show"
                                            role="alert">
                                            <?=__('Vui lòng bảo mật thông tin Token trên, nếu lộ Token vui lòng thay đổi mật khẩu để reset lại Token.');?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group mb-4">
                                        <label>HƯỚNG DẪN TẠO WEBSITE</label>
                                        <?=$CMSNT->site('text_create_website');?>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group mb-4">
                                        <label><?=__('THÊM TÊN MIỀN');?></label>
                                        <div class="input-group">
                                            <input type="hidden" id="token" class="form-control"
                                                value="<?=isset($getUser) ? $getUser['token'] : '';?>" />
                                            <input type="text" class="form-control" id="domain"
                                                placeholder="<?=__('Nhập tên miền của bạn VD: cmslike.com');?>">
                                            <button class="btn btn-success" id="btnSubmit"
                                                type="button"><?=__('Thêm Ngay');?></button>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label><?=__('DANH SÁCH TÊN MIỀN');?></label>
                                        <div class="table-responsive">
                                            <table class="table caption-top table-nowrap">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th scope="col"><?=__('TÊN MIỀN');?></th>
                                                        <th scope="col"><?=__('TRẠNG THÁI');?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($CMSNT->get_list(" SELECT * FROM `domains` WHERE `user_id` = '".$getUser['id']."' ") as $row):?>
                                                    <tr>
                                                        <td><?=$row['domain'];?></td>
                                                        <td><?=display_domains($row['status']);?></td>
                                                    </tr>
                                                    <?php endforeach?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <?php require_once(__DIR__.'/footer.php');?>

    <script type="text/javascript">
    $("#btnSubmit").on("click", function() {
        $('#btnSubmit').html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled',
            true);
        $.ajax({
            url: "<?=BASE_URL('ajaxs/client/create.php');?>",
            method: "POST",
            dataType: "JSON",
            data: {
                action: 'add-create-website',
                token: $('#token').val(),
                domain: $('#domain').val()
            },
            success: function(respone) {
                if (respone.status == 'success') {
                    Swal.fire({
                        title: '<?=__('Thành công !');?>',
                        text: respone.msg,
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire('<?=__('Thất bại !');?>', respone.msg, 'error');
                }
                $('#btnSubmit').html('<?=__('Thêm Ngay');?>').prop('disabled', false);
            }
        })
    });
    </script>
    <script type="text/javascript">
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
    });
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo1"), {
        mode: "htmlmixed",
        theme: "monokai"
    });

    new ClipboardJS(".copy");

    function copy() {
        cuteToast({
            type: "success",
            message: "<?=__('Đã sao chép vào bộ nhớ tạm');?>",
            timer: 5000
        });
    }
    </script>