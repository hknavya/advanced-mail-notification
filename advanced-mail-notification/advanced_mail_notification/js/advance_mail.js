$(function(){
	setTimeout(function(){
		if($("#ccm-check-in-comments").val()!=""){
			$("#ccm-check-in-comments").val('');
			
		};
		$("#ccm-check-in").submit(function(){
			$('#version-comment-err').remove();
			var comments = $("#ccm-check-in-comments").val();
			var messageDiv = $('<div id="version-comment-err"><div class="alert alert-error">Please enter a version comment</div></div>');
			messageDiv.css('margin','20px 20px 0');
			$("#ccm-edit-overlay").prepend(messageDiv);
			if(!/\w/.test(comments) && $("#ccm-approve-field").val()!='DISCARD'){
				/*ToDo:FadeOut */
				$('#ccm-edit-overlay').fadeOut(10000000, 'easeOutExpo');
				messageDiv.show();
				return false;
			}
			else{
				return true;
			}
		});	
	},300)
});
