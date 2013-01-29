function load_popular_query(){
	$.get('load_popular_query.cgi',function(data){
		var popular_word = $('#hot_query').html();
		$('#hot_query').html(popular_word+data);
	});
	
}
function query(keyword){
	//var query = $('#query_input').val();
	$.get("query.cgi",{'query':keyword},function(data){
		//alert(data);
		$('#display_query_input').val(keyword);
	});
}