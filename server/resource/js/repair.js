$(document).ready(function() {
	$("#phone-brand").change(function() {
		$("#phone-model").empty();
		var phoneBrand=$(this).val();
		$.ajax({
			  type:"post",
			  data:"phoneBrand="+phoneBrand,
			  url:"https://879515873.jkshuma.com/index.php/AdminRepair/get_model",
			  //url:"https://qcy6umy7.qcloud.la/index.php/AdminRepair/get_model",
			  success:function(msg){
				 var msg=JSON.parse(msg);
				 var str="<option selected='selected' value='"+msg[0]+"'>"+msg[0]+"</option>";
				 
				 for(var i=1;i<msg.length;i++){
					 str+="<option value='"+msg[i]+"'>"+msg[i]+"</option>";
				 }
				 $("#phone-model").append(str);
				 
			  },
			  error:function(){
				  alert("error");
			  }
		  })
	})
	$("#retail-btn").click(function(){
		$("#repair-retail").show();
		$("#repair-cost").hide();
	});
	$("#cost-btn").click(function(){
		$("#repair-retail").hide();
		$("#repair-cost").show();
	});
	$("#add-submit").click(function(){
		var brand=$("#phone-brand").val();
		var model=$("#phone-model").val();
		if(brand=="选择品牌"||model=="选择型号"){
			alert("录入数据不完整，重新录入！");
			return false;
		}else{
			$("#add-submit").submit();
		}
	})

});
