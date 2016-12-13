$(function(){
	$('#birthday').datetimepicker({
		format: 'YYYY-MM-DD'
	});
	
	
	$('.commentlist li').each(function(i) {
		
		$(this).find('div.commentNumber').text('#' + (i + 1));
		
	});
	
	
	
	
	$('.commentlist').on('click', ".comment-delete-link",function(e) {
		
		e.preventDefault();
		
		var li = $(this).parentsUntil('li');
		$.ajax({
			url:$(this).attr('href'),
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			type:'GET',
			datatype:'JSON',
			success: function(html) {
				console.log(html);
				if(html.success) {
					
					li.fadeOut(500);
				}
				if(html.error) {
									alert(html.error.join('<br />'));
									
								}
			}
		});
		
		return false;	
	});
	
	$('#commentform').on('click','#submit',function(e) {
		
		e.preventDefault();
		
		var comParent = $(this);
		
		$('.wrap_result').
					css('color','green').
					text('Сохранение комментария').
					fadeIn(500,function() {
						
						var data = $('#commentform').serializeArray();
						
						$.ajax({
							
							url:$('#commentform').attr('action'),
							data:data,
							headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
							type:'POST',
							datatype:'JSON',
							success: function(html) {
								
								$('#commentform').attr('action','/comment');
								
								if(html.error) {
									$('.wrap_result').css('color','red').append('<br /><strond>Ошибка: </strong>' + html.error.join('<br />'));
									$('.wrap_result').delay(2000).fadeOut(500);
								}
								else if(html.success) {
									$('.wrap_result')
													.append('<br /><strong>Сохранено!</strong>')
													.delay(2000)
													.fadeOut(500,function() {
														
														if(html.edit) {
															//alert(comParent.html);
															//console.log(html.da);
															comParent.parents('div#respond').prev().replaceWith(html.comment);
															return $('#cancel-comment-reply-link').click();
															//return false;
														}
														
														else if(html.data.parent_id > 0) {
															comParent.parents('div#respond').prev().after('<ul class="children">' + html.comment + '</ul>');
														}
														else{
															if($.contains('#comments','ol.commentlist')) {
																$('ol.commentlist').append(html.comment);
															}
															else {
																
																$('#respond').before('<ol class="commentlist group">' + html.comment + '</ol>');
																
															}
														}
														
														
														//alert('ff');
														
														$('#cancel-comment-reply-link').click();
													})
													
								}
								
								
							},
							error:function() {
								$('#commentform').attr('action','/comment');
								$('.wrap_result').css('color','red').append('<br /><strond>Ошибка: </strong>');
								$('.wrap_result').delay(2000).fadeOut(500, function() {
									$('#cancel-comment-reply-link').click();
								});
								
							}
							
						});
					});
		
	});

	

});
