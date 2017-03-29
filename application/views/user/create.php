<h2><?=$title?></h2>
<form id="add">
	<label for="name">Name</label>
	<input type="text" name="name" /><br>
	<label for="age">Age</label>
	<input type="number" name="age" /><br>
	<label for="introduction">Introduction</label>
	<input type="text" name="introduction" /><br>
	<button id="submitAdd" type="button">提交</button>
</form>
<div id="error">
	
</div>
<script src='/js/jquery3.1.1.min.js'></script>
<script>
$(document).ready(function () {
	var baseUrl = "/user/";
	var addUrl = baseUrl + 'add';
	var successUrl = baseUrl + 'success';
    $.ajaxSetup({
        processData: false,
        contentType: false
    });
	$("#submitAdd").on('click',function(){
		var myData = new FormData(this.form);
		myData.append("<?=$csrf_name?>","<?=$csrf_hash?>");
		$.post(addUrl,myData,function(xhr){
			console.log(xhr.errCode);
			if(xhr.errCode == 1){
				$("#error").html(xhr.msg);
				alert('操作失败');
				window.location.reload();
			}else{
				window.location.href = successUrl;
			}
			// window.location.reload();
		});
	});
});
</script>