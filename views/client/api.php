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
                                </div><hr>
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
                                    <p>Form-data</p>
                                    <ul>
                                        <li><b style="color: red;">token</b>: token API của bạn.</li>
                                    </ul>
                                    <p>Response</p>
                                    <textarea id="codeMirrorDemo4">
                                    {
    "status": "success",
    "msg": "Lấy danh sách dịch vụ thành công!",
    "category": [
        {
            "id": "1",
            "name": "Facebook",
            "icon": "<?=base_url();?>assets/storage/images/iconG9NM.png",
            "content": "",
            "service": [
                {
                    "id": "3",
                    "name": "Tăng Like Bài Viết",
                    "icon": "<?=base_url();?>assets/storage/images/service9L8K.png",
                    "content": "PHVsPg0KCTxsaT4NCgk8aDQ+PHNwYW4gc3R5bGU9ImZvbnQtc2l6ZToxNHB4Ij5OZ2hpJmVjaXJjO20gY+G6pW0gYnVmZiBjJmFhY3V0ZTtjIMSRxqFuIGMmb2FjdXRlOyBu4buZaSBkdW5nIHZpIHBo4bqhbSBwaCZhYWN1dGU7cCBsdeG6rXQsIGNoJmlhY3V0ZTtuaCB0cuG7iywgxJHhu5MgdHLhu6V5Li4uIE7hur91IGPhu5EgdCZpZ3JhdmU7bmggYnVmZiBi4bqhbiBz4bq9IGLhu4sgdHLhu6sgaOG6v3QgdGnhu4FuIHYmYWdyYXZlOyBiYW4ga2jhu49pIGjhu4cgdGjhu5FuZyB2xKluaCB2aeG7hW4sIHYmYWdyYXZlOyBwaOG6o2kgY2jhu4t1IGhvJmFncmF2ZTtuIHRvJmFncmF2ZTtuIHRyJmFhY3V0ZTtjaCBuaGnhu4dtIHRyxrDhu5tjIHBoJmFhY3V0ZTtwIGx14bqtdC48L3NwYW4+PC9oND4NCgk8L2xpPg0KCTxsaT4NCgk8aDQ+PHNwYW4gc3R5bGU9ImZvbnQtc2l6ZToxNHB4Ij5O4bq/dSDEkcahbiDEkWFuZyBjaOG6oXkgdHImZWNpcmM7biBo4buHIHRo4buRbmcgbSZhZ3JhdmU7IGLhuqFuIHbhuqtuIG11YSDhu58gYyZhYWN1dGU7YyBo4buHIHRo4buRbmcgYiZlY2lyYztuIGtoJmFhY3V0ZTtjLCBu4bq/dSBjJm9hY3V0ZTsgdCZpZ3JhdmU7bmggdHLhuqFuZyBo4buldCwgdGhp4bq/dSBz4buRIGzGsOG7o25nIGdp4buvYSAyIGImZWNpcmM7biB0aCZpZ3JhdmU7IHPhur0ga2gmb2NpcmM7bmcgxJHGsOG7o2MgeOG7rSBsJmlhY3V0ZTsuPC9zcGFuPjwvaDQ+DQoJPC9saT4NCgk8bGk+DQoJPGg0PjxzcGFuIHN0eWxlPSJmb250LXNpemU6MTRweCI+xJDGoW4gYyZhZ3JhdmU7aSBzYWkgdGgmb2NpcmM7bmcgdGluIGhv4bq3YyBs4buXaSB0cm9uZyBxdSZhYWN1dGU7IHRyJmlncmF2ZTtuaCB0xINuZyBo4buHIHRo4buRbmcgc+G6vSBraCZvY2lyYztuZyBobyZhZ3JhdmU7biBs4bqhaSB0aeG7gW4uPC9zcGFuPjwvaDQ+DQoJPC9saT4NCgk8bGk+DQoJPGg0PjxzcGFuIHN0eWxlPSJmb250LXNpemU6MTRweCI+TuG6v3UgZ+G6t3AgbOG7l2kgaCZhdGlsZGU7eSBuaOG6r24gdGluIGjhu5cgdHLhu6MgcGgmaWFjdXRlO2EgYiZlY2lyYztuIHBo4bqjaSBnJm9hY3V0ZTtjIG0mYWdyYXZlO24gaCZpZ3JhdmU7bmggaG/hurdjIHYmYWdyYXZlO28gbeG7pWMgbGkmZWNpcmM7biBo4buHIGjhu5cgdHLhu6MgxJHhu4MgxJHGsOG7o2MgaOG7lyB0cuG7oyB04buRdCBuaOG6pXQuPC9zcGFuPjwvaDQ+DQoJPC9saT4NCjwvdWw+DQo=",
                    "text_input": "Nhập Link hoặc ID cần tăng",
                    "text_placeholder": "Vui lòng nhập Link hoặc ID cần tăng",
                    "pack": [
                        {
                            "id": "1",
                            "name": "Tăng like tốc độ nhanh",
                            "price": "3.5",
                            "min_order": "1",
                            "max_order": "100000000",
                            "content": "Tốc độ ổn 2k -&gt; 20k/ngày, không hỗ trợ bài viết chia sẻ video, bài viết trong nhóm, bài viết hoặc video đang chạy ads.",
                            "show_comment": "0",
                            "show_camxuc": "1"
                        },
                        {
                            "id": "4",
                            "name": "Like thật tốc độ chậm",
                            "price": "20",
                            "min_order": "10",
                            "max_order": "100000000",
                            "content": "Tốc độ ổn 2k -&gt; 20k/ngày, không hỗ trợ bài viết chia sẻ video, bài viết trong nhóm, bài viết hoặc video đang chạy ads.",
                            "show_comment": "0",
                            "show_camxuc": "0"
                        }
                    ]
                },
                {
                    "id": "4",
                    "name": "Tăng Theo Dõi Cá Nhân",
                    "icon": "<?=base_url();?>assets/storage/images/serviceS28M.png",
                    "content": "",
                    "text_input": "Nhập Link hoặc ID cần tăng",
                    "text_placeholder": "Vui lòng nhập Link hoặc ID cần tăng",
                    "pack": [
                        {
                            "id": "2",
                            "name": "Server 1: Tốc độ nhanh",
                            "price": "10",
                            "min_order": "100",
                            "max_order": "100000000",
                            "content": "Tốc độ ổn 2k -&gt; 20k/ngày, không hỗ trợ bài viết chia sẻ video, bài viết trong nhóm, bài viết hoặc video đang chạy ads.",
                            "show_comment": "0",
                            "show_camxuc": "0"
                        },
                        {
                            "id": "3",
                            "name": "Server 2: Tốc độ chậm",
                            "price": "5",
                            "min_order": "100",
                            "max_order": "100000000",
                            "content": "Tốc độ ổn 2k -&gt; 20k/ngày, không hỗ trợ bài viết chia sẻ video, bài viết trong nhóm, bài viết hoặc video đang chạy ads.",
                            "show_comment": "0",
                            "show_camxuc": "0"
                        },
                        {
                            "id": "5",
                            "name": "Server 3: Người thật click",
                            "price": "20",
                            "min_order": "10",
                            "max_order": "100000000",
                            "content": "Tốc độ ổn 2k -&gt; 20k/ngày, không hỗ trợ bài viết chia sẻ video, bài viết trong nhóm, bài viết hoặc video đang chạy ads.",
                            "show_comment": "0",
                            "show_camxuc": "0"
                        }
                    ]
                },
                {
                    "id": "9",
                    "name": "Tăng Like Fanpage",
                    "icon": "<?=base_url();?>assets/storage/images/iconGA74.png",
                    "content": "",
                    "text_input": "Nhập Link hoặc ID cần tăng",
                    "text_placeholder": "Vui lòng nhập Link hoặc ID cần tăng",
                    "pack": []
                },
                {
                    "id": "13",
                    "name": "Tăng Comemnt - Bình luận Facebook",
                    "icon": "<?=base_url();?>DVMXH2/assets/storage/images/iconYBU6.png",
                    "content": "",
                    "text_input": "Nhập Link hoặc ID cần tăng",
                    "text_placeholder": "Vui lòng nhập Link hoặc ID cần tăng",
                    "pack": [
                        {
                            "id": "13",
                            "name": "Tốc độ comment chậm",
                            "price": "100",
                            "min_order": "1",
                            "max_order": "100000000",
                            "content": "Tốc độ comment chậm",
                            "show_comment": "1",
                            "show_camxuc": "0"
                        }
                    ]
                }
            ]
        }
    ]
}

                                    </textarea>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label>Example PHP</label>
                                        <textarea id="codeMirrorDemo">$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => '<?=base_url();?>api/listService.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('token' => '<?=$getUser['token'];?>'),
));
$response = curl_exec($curl);
curl_close($curl);
echo $response;

                                        </textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group mb-3">
                                        <label>API Mua Dịch Vụ</label>
                                        <div class="input-group">
                                            <span class="input-group-text">POST</span>
                                            <input type="text" class="form-control"
                                                value="<?=base_url('api/orderService.php');?>" id="copyOrderService"
                                                readonly>
                                            <button onclick="copy()" data-clipboard-target="#copyOrderService"
                                                class="btn btn-primary copy" type="button"><?=__('COPY');?></button>
                                        </div>
                                    </div>
                                    <p>Form-data</p>
                                    <ul>
                                        <li><b style="color: red;">token</b>: token API của bạn.</li>
                                        <li><b style="color: red;">url</b>: id cần tăng.</li>
                                        <li><b style="color: red;">service_pack</b>: id server cần tăng.</li>
                                        <li><b style="color: red;">note</b>: ghi chú đơn hàng nếu có.</li>
                                        <li><b style="color: red;">comment</b>: nội dung comment nếu có.</li>
                                        <li><b style="color: red;">amount</b>: số lượng cần tăng.</li>
                                        <li><b style="color: red;">camxuc</b>: Cảm xúc nếu có.</li>
                                    </ul>
                                    <p>Response</p>
                                    <textarea id="codeMirrorDemo5">
{
    "status": "success", // trạng thái success hoặc error
    "msg": "Tạo đơn hàng thành công" // thông báo trạng thái
}

                                    </textarea>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label>Example PHP</label>
                                        <textarea id="codeMirrorDemo1">$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => '<?=base_url();?>api/orderService.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('token' => '<?=$getUser['token'];?>','url' => '100038641389494','service_pack' => '4','note' => '','comment' => '','amount' => '1000','camxuc' => ''),
));
$response = curl_exec($curl);
curl_close($curl);
echo $response;

                                        </textarea>
                                    </div>
                                </div><hr>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group mb-3">
                                        <label>API Lấy Lịch Sử Order</label>
                                        <div class="input-group">
                                            <span class="input-group-text">POST</span>
                                            <input type="text" class="form-control"
                                                value="<?=base_url('api/historyOrder.php');?>" id="copyhistoryOrder"
                                                readonly>
                                            <button onclick="copy()" data-clipboard-target="#copyhistoryOrder"
                                                class="btn btn-primary copy" type="button"><?=__('COPY');?></button>
                                        </div>
                                    </div>
                                    <p>Form-data</p>
                                    <ul>
                                        <li><b style="color: red;">token</b>: token API của bạn.</li>
                                        <li><b style="color: red;">limit</b>: số lượng lịch sử cần lấy.</li>
                                    </ul>
                                    <p>Response</p>
                                    <textarea id="codeMirrorDemo3">
{
    "status": "success",
    "msg": "Lấy 1 lịch sử order thành công",
    "order": [
        {
            "trans_id": "4N3E59",                       // mã đơn hàng
            "service": "Tăng Like Bài Viết",            // tên dịch vụ
            "pack": "Tăng like tốc độ nhanh",           // tên gói dịch vụ
            "url": "232323",                            // link hoặc uid cần tăng
            "price": "3500",                            // tổng tiền thanh toán
            "note": "",                                 // ghi chú bạn đưa lên
            "amount": "1000",                           // số lượng bạn mua
            "start": "0",                               // số lượng like/follow lúc bắt đầu mua
            "success": "0",                             // số lượng tăng thành công
            "status": "0",                              // trạng thái đơn hàng: 0 = xử lý, 1 = hoàn tất, 2 = huỷ hoàn tiền
            "create_gettime": "2022-06-08 09:08:41",    // thời gian tạo đơn
            "update_gettime": "2022-06-08 09:08:41"     // thời gian cập nhật đơn
        }
    ]
}

                                    </textarea>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label>Example PHP</label>
                                        <textarea id="codeMirrorDemo2">$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => '<?=base_url();?>api/historyOrder.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('token' => '<?=$getUser['token'];?>','limit' => '100'),
));
$response = curl_exec($curl);
curl_close($curl);
echo $response;

                                        </textarea>
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


<?php require_once(__DIR__.'/footer.php');?>

<script type="text/javascript">
CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
    mode: "htmlmixed",
    theme: "monokai"
});
CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo1"), {
    mode: "htmlmixed",
    theme: "monokai"
});
CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo2"), {
    mode: "htmlmixed",
    theme: "monokai"
});
CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo3"), {
    mode: "htmlmixed",
    theme: "monokai"
});
CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo4"), {
    mode: "htmlmixed",
    theme: "monokai"
});
CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo5"), {
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