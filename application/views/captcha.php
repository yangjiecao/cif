<h2>Captcha</h2>
<div id="showCaptcha">
<?=$image['image']?>
</div>
<form >
	<input type="hidden" name="cookie_key" value="<?=$cookie_key?>" />
	<input type="text" name="captcha" />
	<button id="check" type="button">提交</button>
</form>
<script src='/js/jquery3.1.1.min.js'></script>
<script>
	$(document).ready(function () {
	    $.ajaxSetup({
	        processData: false,
	        contentType: false
	    });
	    var checkUrl = "/user/captcha_check";
		$("#check").on('click',function(){
			var myData = new FormData(this.form);
			myData.append("<?=$csrf_name?>","<?=$csrf_hash?>");
			$.post(checkUrl,myData,function(xhr){
				if(xhr.errCode == 1){
					alert('操作失败');
					window.location.reload();
				}else{
					console.log('success');
				}
				// window.location.reload();
			});
		});
		$("#showCaptcha").on('click', function(){
			window.location.reload();
		});	    
	})
</script>