<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Tài Liệu Tích Hợp API').' | '.$CMSNT->site('title'),
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
                        <h4 class="mb-sm-0"><?=__('Tài liệu tích hợp API');?></h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?=base_url();?>"><?=__('Trang chủ');?></a></li>
                                <li class="breadcrumb-item active"><?=__('Tài liệu tích hợp API');?></li>
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
                                <div class="ribbon ribbon-primary ribbon-shape "><?=__('TÀI LIỆU TÍCH HỢP API');?></div>
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
                                    <div class="form-group mb-3">
                                        <label>API Lấy Danh Sách Dịch Vụ</label>
                                        <div class="input-group">
                                            <span class="input-group-text">POST</span>
                                            <input type="text" class="form-control"
                                                value="<?=base_url('api/listService.php');?>" id="copylistService"
                                                readonly>
                                            <button onclick="copy()" data-clipboard-target="#copylistService"
                                                class="btn btn-primary copy" type="button"><?=__('COPY');?></button>
                                        </div>
                                    </div>
                                    <p>form-data</p>
                                    <ul>
                                        <li><b style="color: red;">token</b> => <?=$getUser['token'];?> (token API của bạn).</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label>Response</label>
                                        <textarea id="codeMirrorDemo"
                                            placeholder="Chứa code live chat hoặc jquery trang trí..."
                                            name="javascript_header"> </textarea>
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
// CodeMirror
CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
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