<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}?>
<script>
$.ajax({
    url: "<?=BASE_URL('update.php');?>",
    type: "GET",
    dateType: "text",
    data: {},
    success: function(result) {

    }
});
$(function() {
    $('#datatable1').DataTable();
    $('#datatable2').DataTable();
});
</script>
<footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
        <div id="google_translate_element"></div>
        <script type="text/javascript">
        // <![CDATA[
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'vi',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
        // ]]>
        </script>
        <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"
            type="text/javascript"></script>

    </div>
    <b>Version</b> <b style="color:red;"><?=$config['version'];?></b> - <strong>Powered By <a
            href="https://www.cmsnt.co/?domain=<?=base_url_admin('');?>" target="_blank">CMSNT.CO</a></strong>
</footer>
</div>
<!-- jQuery UI 1.11.4 -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>dist/js/pages/dashboard.js"></script>
<!-- CodeMirror -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>plugins/codemirror/codemirror.js"></script>
<script src="<?=BASE_URL('public/AdminLTE3/');?>plugins/codemirror/mode/css/css.js"></script>
<script src="<?=BASE_URL('public/AdminLTE3/');?>plugins/codemirror/mode/xml/xml.js"></script>
<script src="<?=BASE_URL('public/AdminLTE3/');?>plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<!-- ChartJS -->
<script src="<?=BASE_URL('public/AdminLTE3/');?>plugins/chart.js/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
<?=$body['footer'];?>
</body>

</html>
 
