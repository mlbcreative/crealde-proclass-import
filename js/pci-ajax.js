jQuery(document).ready(function($){
	
	$('#loadingMsg').hide();
	
	$('#pci-form').submit(function() {
		
		$('#loadingMsg').show();
		
		var data = {
			action : 'pci_get_results',
			classid : $('#class_id').val()
		};
		
/*
		$.post(ajaxurl, data, function(response){
			$('#loadingMsg').hide();
			//console.log(response);
			alert(response);
			
		})
*/
		
		$.ajax({
			type : 'POST',
			url : ajaxurl,
			data : data,
			success : function(response) {
				$('#loadingMsg').hide();
				alert(response);
				$('#class_id').val('');
			},
			async: false
		})
		
		
		return false; //prevent default behavior
	});
})