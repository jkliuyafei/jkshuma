$(document).ready(function() {
	$("#btn-submit-brand").click(function(){
		var brand=$("input[name='brand']").val();
		var brandId=$("input[name='brandId']").val();
		if(brand.length==0||brandId.length==0){
			alert("录入数据不完整，重新录入！");
			return false;
		}else{
			$("form[name='add_brand']").submit();
		}
		
	});

});
