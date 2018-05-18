var config=require(./config.js)
$(document).ready(function() {
	var okPriceBrand=false;
	$("#phone-brand").change(function() {
		$("#phone-model").empty();
		var phoneBrand=$(this).val();
		$.ajax({
			  type:"post",
			  data:"phoneBrand="+phoneBrand,
			  url:"https://879515873.jkshuma.com/index.php/AdminNewPhone/get_model",
			  //url:"https://qcy6umy7.qcloud.la/index.php/AdminNewPhone/get_model",
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
	});
	
	$("#price-handle-submit").click(function(){
		var brand=$("#price-handle-brand").val();
		var priceOffset=$("#price-handle-offset").val();
		if(brand=="选择品牌"||priceOffset.length==0){
			alert("录入数据不完整，重新录入！");
			return false;
		}else{
			$("#handle-price-form").submit();
		}
		
	});
	
	$("#add-submit").click(function(){
		var brand=$("#phone-brand").val();
		var model=$("#phone-model").val();
		var volume=$("#phone-volume").val();
		var color=document.getElementsByName("phoneColor[]");
		var colorStatus=true;
		for(var i=0;i<color.length;i++){
			if(color[i].checked){
				colorStatus=false;
				break;
			}
		}
		if(brand=="选择品牌"||model=="选择型号"||volume=="选择容量"||colorStatus){
			alert("录入数据不完整，重新录入！");
			return false;
		}else{
			$("#add-phone-form").submit();
		}
		
	});

});
