


$(document).ready( function() {
	$(".ajaxform").submit(function(e)
	{
		if ( $(this).data('submit') != undefined && !eval( $(this).data('submit') ) ) {
			return false;
		}
		
	    var postData = new FormData();
	    $(this).find('input[type="file"]').each(function($i){
	    	postData.append( $(this).attr("name"), $(this)[0].files[0] );
        });
        $(this).find('input[type="checkbox"]').each(function($i){
            postData.append( $(this).attr("name"), ( $(this).is(':checked') ) ? $(this).val() : 0 );
        });
	    var other_data = $(this).serializeArray();
        $.each(other_data,function(key,input){
            if ( !postData.has( input.name ) ) {
                if (input.value == "" & $('[name="' + input.name + '"]').data('is_ck') == 1)
                    postData.append(input.name, CKEDITOR.instances[input.name].getData());
                else
                    postData.append(input.name, input.value);
            }
        });
	    var formURL = $(this).attr("action");
	    
	    $('body').addClass('loading-overlay-showing');
	    $.ajax(
	    {
	        url : formURL,
	        type: "POST",
	        data : postData,
			processData: false,
			contentType: false,
	        success:function(data, textStatus, jqXHR) 
	        {
	        	var result = JSON.parse( data );
	        	if ( result.error_code == 200 ) {
	        		if ( result.error_msg != '' )
	        			alert( result.error_msg );
	        		if ( result.data.moveUrl != undefined )
	        			window.location = result.data.moveUrl;
	        		else
	        			location.reload();
                } else
	            	alert( result.error_msg );
	        	$('body').removeClass('loading-overlay-showing');
	        },
	        error: function(jqXHR, textStatus, errorThrown) 
	        {
	            alert( '입력하신 정보를 다시 확인해주세요.' );
	            $('body').removeClass('loading-overlay-showing');
	        }
	    });
	    e.preventDefault(); //STOP default action
	    //e.unbind(); //unbind. to stop multiple form submit.
	});
	
	$('select').change( function() {
		var v = $(this).children('option:selected').val();
		$(this).children('option').attr( 'selected', false );
		$(this).children('option[value="' + v + '"]').attr( 'selected', true );
		$(this).val( v );
	});
});