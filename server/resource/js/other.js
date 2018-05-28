var config=require('./config.js');
$(document).ready(function() {
	$("#phone-brand").change(function() {
		$("#phone-model").empty();
		var phoneBrand=$(this).val();
		$.ajax({
			  type:"post",
			  data:"phoneBrand="+phoneBrand,
			  url:"https://879515873.jkshuma.com/index.php/AdminOther/get_model",
			  //url:"https://qcy6umy7.qcloud.la/index.php/AdminOther/get_model",
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

});
