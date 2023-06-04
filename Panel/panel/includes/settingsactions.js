/////////////////Add rule in db from form and out on page

$(document).ready(function() 
{
/////////////////Delete rule
	
	$("body").on("click", "#clearDB", function () {
		$rule = $(this);
		var id = $rule.parent().parent().attr('id');
		
		$.ajax({
			url: "includes/settingsactions.php",
			type: "POST",
			data:{func:'clearDB'},
			dataType: "json",
			success: function(result) {
				if(result = "deleted"){
					
				}				
			}					
		});	
		return false;
	});
	
/////////////////	
	
	$("body").on("click", "#dublCheckbox", function () {
		var rule = this		
		var check = rule.checked;
		$.ajax({
			url: "includes/settingsactions.php",
			type: "POST",
			data:{func:'dublicate', check:check},
			dataType: "json",
			success: function(){
				if (check){
					rule.checked = true
				}else{
					rule.checked = false
				}
			}
		});
    return false;
	});


});

										