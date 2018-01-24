$(document).ready(function(){
    var i = 0;
    $('.'+content_class_name).each(function() {
        html2canvas(this,{
            onrendered: function (canvas) {
                //Set hidden field's value to image data (base-64 string)
                $('#'+form_id).append('<input type="hidden" rel="'+i+'" name="'+hidden_image_names+'[]" value="'+canvas.toDataURL("image/png")+'"/>');
                i++;
                console.log(i);
            }

        });

    });

    var timer = setInterval(function () {
        if(i == $('.'+content_class_name).length){
        	var postData = new FormData();
        	var other_data = $('#myForm').serializeArray();
            $.each(other_data,function(key,input){
            	postData.append( input.name,input.value );
            });
    	    var formURL = $('#myForm').attr("action");
    	    
    	    $.ajax(
    	    {
    	        url : formURL,
    	        type: "POST",
    	        data : postData,
    			processData: false,
    			contentType: false,
    	        success:function(data, textStatus, jqXHR) 
    	        {
    	        },
    	        error: function(jqXHR, textStatus, errorThrown) 
    	        {
    	        }
    	    });
            clearInterval(timer);
        }
    }, 500);
});