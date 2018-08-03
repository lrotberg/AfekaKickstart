// $(document).ready(function(){
// 	$.ajax({
// 		url: "actions/test.php", 
// 		type: "POST",
// 	  	data: {username: "exolite", password: "1234"},
// 	  	success: function(data){
// 	  		var json = JSON.parse(data);
// 	  		for(var k in json) {
// 	  			var html = '<div class="card" style="width: 18rem;">';
// 					html += '<div class="card-body">';
// 					html +=  '<h5 class="card-title">' + json[k].USERNAME + '</h5>';
//     				html +=	   '<p class="card-text">' + json[k].PASSWORD + '</p>';
//   					html +=  '</div>';
// 					html += '</div>';
// 				$('#users').append(html);
// 	  		}
// 	  	}
// 	});
// });

$(document).ready(function(){
	$("#signup").on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url: "actions/signup.php", 
			type: "POST",
			data: {action: 'signup', username: $("input[name = 'signUpUsername']").val(), password: $("input[name = 'signUpUserPassword']").val()},
			success: function(data){
				console.log(data);
				var json = JSON.parse(data);
				if (json.status === 'ok') {
					window.location.href = 'index.php';
				}
			}
		});
	});

	$("#login-form").on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url: "actions/signup.php", 
			type: "POST",
			data: {action: 'login', username: $("input[name = 'loginUserName']").val(), password: $("input[name = 'loginPassword']").val()},
			success: function(data){
				console.log(data);
				var json = JSON.parse(data);
				if (json.status === 'ok') {
					window.location.href = 'index.php';
				}
			}
		});
	});

	$("#logout").on('click', function(e){
		$.ajax({
			url: "actions/signup.php", 
			type: "POST",
			data: {action: 'logout'},
			success: function(data){
				window.location.href = 'index.php';
			}
		});
	});

	$('.proj').each(function(index){
		$(this).on('click',function(){
			$('.modal-body').html('<h2>You are about to donate to ' +
									$(this).attr('data-name') +
									'</h2><div><form class="donation"><input type="hidden" name="pid" value="' +
									$(this).attr('data-id') +
									'"><input type="number" name="pamount" min="1"><input type="submit" class="btn btn-secondary" value="Donate now!">' +
									'</form></div>'
									);
			$('.donation').on('submit',function(e){
				e.preventDefault();
				$.ajax({
					url: "actions/projects.php", 
					type: "POST",
					data: {action: 'donate', pid: $("input[name = 'pid']").val(), pamount: $("input[name = 'pamount']").val()},
					success: function(data){
						console.log(data);
						var json = JSON.parse(data);
						if (json.status === 'ok') {
							$('.modal-body').html('<h3>Thank you for your donation!</h3>');
							$('#donateModal').on('hidden.bs.modal',function(){
								window.location.reload();
							})
							window.location.href = 'index.php';
						}
					}
				});
			});
			$('#donateModal').modal('show');
		});
	});
});