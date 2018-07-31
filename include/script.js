$(document).ready(function(){
	$.ajax({
		url: "actions/test.php", 
		type: "POST",
	  	data: {username: "exolite", password: "1234"},
	  	success: function(data){
	  		var json = JSON.parse(data);
	  		for(var k in json) {
	  			var html = '<div class="card" style="width: 18rem;">';
					html += '<div class="card-body">';
					html +=  '<h5 class="card-title">' + json[k].USERNAME + '</h5>';
    				html +=	   '<p class="card-text">' + json[k].PASSWORD + '</p>';
  					html +=  '</div>';
					html += '</div>';
				$('#users').append(html);
	  		}
	  	}
	});
});