var total_page = 0;


$(document).ready(function() {
	$.get('session.php',{'action':'check'},function(data){
		if(data){
			$('#login').html(data);
			$('#login').attr('title','logout');
		}
	});
	//loadData();
   $("#load").click(function () {
		loadData();
		$("#load").css('display','none');
    });
	
	// handle previous & next page 
	$('#prev').click(function(){
		var now_page = parseInt($('#now_page').html(),10);
		if(now_page == 1){
			alert('No previous page!');
		}
		else{
			var prev = now_page - 1;
			$('#page_'+now_page.toString()).css('display','none');
			$('#page_'+prev.toString()).css('display','block');
		}
	});
	$('#next').click(function(){
		var now_page = parseInt($('#now_page').html(),10);
		if(now_page == total_page){
			alert('No next page!');
		}
		else{
			var next = now_page + 1;
			$('#page_'+now_page.toString()).css('display','none');
			$('#page_'+next.toString()).css('display','block');
			if(next == total_page)//最後一頁顯示整體文章標誌
				$('#overall').css('display','block');
		}
		
	});
	
	// handle previous & next page
	$('#login').click(function(){
		var type = $(this).attr('title');
		if(type=='login'){
			var input = "<input type='text' id='email' autocomplete = 'off' autofocus='autofocus'/>"
			$('#login').html(input);
			
			$("input").bind("keyup",function(e){
				if(e.keyCode==13){
					$('#login').html(this.value);
					$('#login').attr('title','logout');
					$.get('session.php',{'email':this.value,'action':'set'});
				}
			});
		}
		else{
			$.get('session.php',{'action':'delete'},function(data){
				window.location.reload();
			});
		}
	});
	
	
	// Neo added
	hideLoading();
	$("#submit_btn").click(function(){
		
		login();
		
	});

	
	
	
	
	
 });
 
 function login(){
	$.ajax({
		url:"login.php",
		method:"GET",
		dataType: 'json',
		error:function(xhr){
			alert("ajax error");
		},
		data:{ 'username':$("#username").val() , "passwd":$("#passwd").val() },
		success: function(response) {
			console.log( response );
			if(response==1){
				$.ajax({
					url:"post.php",
					method:"GET",
					error:function(xhr){
						alert("ajax error");
					},
					success:function(xhr){
						$("#page").html( xhr );
						hideLoading();
						
					}
				});
			}
			else{
				alert("錯誤的使用者名稱或密碼");
			}
		}
	});
 
 
 
 }
 
function addAnnotation( commsn , anno , anno_type ){
	$.ajax({
		url:"handler.php",
		method:"GET",
		dataType: 'json',
		error:function(xhr){
			alert("ajax error");
		},
		data:{ 'Annotation':anno , "Type":anno_type , "CommentSn":commsn , 'method':'insert' },
		success: function(response) {
			hideLoading();
			
		}
	});

}
 
function markAsDone( CSn ){
	$.ajax({
		url:"handler.php",
		method:"GET",
		dataType: 'json',
		error:function(xhr){
			alert("The page will refresh!");
		},
		data:{ 'CommentSn':CSn , 'method':'markAsDone' },
		success: function(response) {
			hideLoading();
			if($("#total").val()==0){
				window.location.reload();
			}
		}
	});


}
 
function updateDB(obj){
	showLoading();
	console.log( obj );
	var type = $(obj).parent().attr('class');// comment or product
	var sentiment = $(obj).attr('class'); //ok error equal
	var content = $(obj).parent().parent().siblings().children().html();//content
	$(obj).parent().children().each(function(){
		$(this).removeClass("pressed");
	});
	$(obj).addClass("pressed");
	
	//$(obj).parent().append("<img src='img/done.gif' title='Done!'/>");
	$(obj).parent().attr("pressed",1);

	var objarr = $(obj).parent().parent().children();

	if( objarr[0].getAttribute("pressed")==1 && objarr[1].getAttribute("pressed")==1 ){
		$("#total").val( $("#total").val()-1 );
		$(obj).parent().parent().css('background','grey');
		markAsDone( $(obj).attr('CommentSn') );
	}
	
	// alert($(obj).attr('CommentSn')+":"+$(obj).attr('value')+":"+$(obj).attr('Type'));
	addAnnotation( $(obj).attr('CommentSn') , $(obj).attr('value') , $(obj).attr('Type') );
	//$(obj).parent().children().each(function(){
	//	$(this).attr('onclick','').unbind('click');
	//});
}
function loadData(){
	$.getJSON('getdata.php',function(data){
		var i =1;
		var append = true;
		var total_count = 0;
		var all_content = '<div id="page_1" style = "display:block">';
		$.each(data, function(key, val) {
			var div;
			if(key == 'count'){
				$('#count').css('display','block');
				$('#total').html(val);
				total_count = parseInt(val,10);
				total_page = Math.ceil(total_count/10);
				append = false;
			}
			if(key=='title'){
				$('#article_title').html("Title:<font color='red'>"+val+"</font>");
				append = false;
			}
			if(append){
				if(i % 2 ==0){
					div = "<div class = 'odd_col' id = 'count_"+i.toString()+"'>";
				}else{
					div = "<div class = 'even_col' id = 'count_"+i.toString()+"'>";
				}
				
				var correct = "<img value=0 sent_sn="+key+" anno_type=0 title = 'Mark as positive.' onclick = 'updateDB(this)' class = 'ok' src = 'img/ok.jpg' />";
				var error = "<img value=1 sent_sn="+key+" anno_type=0 title = 'Mark as negative.' onclick = 'updateDB(this)' class = 'error' src = 'img/error.gif' />";
				var equal = "<img value=2 sent_sn="+key+" anno_type=0 title = 'Mark as neutral.' onclick = 'updateDB(this)' class = 'equal' src = 'img/equal.png' />";
				
				var correct2 = "<img value=0 sent_sn="+key+" anno_type=1 title = 'Mark as positive.' onclick = 'updateDB(this)' class = 'ok' src = 'img/ok.jpg' />";
				var error2 = "<img value=1 sent_sn="+key+" anno_type=1 title = 'Mark as negative.' onclick = 'updateDB(this)' class = 'error' src = 'img/error.gif' />";
				var equal2 = "<img value=2 sent_sn="+key+" anno_type=1 title = 'Mark as neutral.' onclick = 'updateDB(this)' class = 'equal' src = 'img/equal.png' />";
				var content = "<span class='data_to_tagged' >"+val+"</span>";
				div+="<div class = 'text'>"+content+"</div>";
				div+="<div class = 'tag'>\
				<div class='Product'>Product:"+correct+error+equal+"</div>\
				<div class='Comment'>Comment:"+correct2+error2+equal2+"</div>\
				</div>";
				all_content+=div+'</div>';
				i+=1;
			}
			append = true;
			if(i%10==0 || i == total_count){
				all_content+="</div>";
				var next_page = (i/10)+1;
				all_content = '<div id="page_'+next_page+'" style = "display:none">';
			}
		});
		$("#content").html(all_content);
		$('#now_page').html(1);
		$('#hidden').css('display','block');
		
		if((total_count/10)<=1)
			$('#overall').css('display','block');
		$('.text').each(function(idx){
			var height = $(this).height();
			if(height< 59){
				$(this).height("60px");
			}
		});
		hideLoading();
	});
}

// Neo added
function showLoading(){
	$("#loadingPic").show();
}

function hideLoading(){
	$("#loadingPic").hide();
}


