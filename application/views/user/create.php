<link rel="stylesheet" href="/uploadify/uploadify.css">
<h2><?=$title?></h2>
<form id="add">
	<label for="name">Name</label>
	<input type="text" name="name" /><br>
	<label for="age">Age</label>
	<input type="number" name="age" /><br>
	<label for="introduction">Introduction</label>
	<input type="text" name="introduction" /><br>
	<input type="file" name="file" id="file_upload" /><br>
	<img src="/default.jpg" alt="图片" id="photo_upload" width="50px" height="50px" /><br>
	<button id="submitAdd" type="button">提交</button>
</form>
<div id="error">
	
</div>
<script src='/js/jquery3.1.1.min.js'></script>
<script src='/uploadify/jquery.uploadify.min.js'></script>
<script>
$(document).ready(function () {
	var baseUrl = "/user/";
	var addUrl = baseUrl + 'add';
	var successUrl = baseUrl + 'success';
    $.ajaxSetup({
        processData: false,
        contentType: false
    });
	$("#file_upload").uploadify({
		height		: 30,	
		swf			: '/uploadify/uploadify.swf',	
		uploader	: '/user/upload',	//处理图片路径
		fileObjName	: 'file',	//设置上传图片名
		width		: 100,
		queueID		: 'fileQueue', //不显示进度条
		buttonText	: '上传文件',	// 按钮文字
	    'onUploadSuccess' : function(file, data, response) {  
	        // alert(data); 
	        $("#photo_upload").attr('src', '/uploads/'+data);
        },  

	    'onUploadError' : function(file, errorCode, errorMsg, errorString) {  
	        alert(errorString);  
        }  		
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