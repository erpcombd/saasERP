
$('.attachment-toggle .attachment-toggle-add-file').click(function(e) {
  var $container = $(this).closest('.attachment-toggle').children('.fileuploadcontainer');

  if ($container.hasClass('fileuploadcontaineropened')) {
    
    $container.removeClass('fileuploadcontaineropened');
  } else {
   
    
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
   
    $container.addClass('fileuploadcontaineropened');
    

  }

});
$('.attachment-toggle .attachment-toggle-add-url').click(function(e) {
   
  var $container = $(this).closest('.attachment-toggle').children('.attachmenturluploadcontainer');
  
  if ($container.hasClass('fileuploadcontaineropened')) {
    
    $container.removeClass('fileuploadcontaineropened');
  } else {

    
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
    
    $container.addClass('fileuploadcontaineropened');
    

  }

});
$('.attachment-toggle .attachment-toggle-add-text').click(function(e) {
   
  var $container = $(this).closest('.attachment-toggle').children('.attachmenttextuploadcontainer');
  
  if ($container.hasClass('fileuploadcontaineropened')) {
    
    $container.removeClass('fileuploadcontaineropened');
  } else {

    
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
   
    $container.addClass('fileuploadcontaineropened');
   

  }

});
$(' .attachment-icon-close-container').click(function(e) {

  var $container = $(this).closest('.attachment-toggle').next('.fileuploadcontainer');

  if ($container.hasClass('fileuploadcontaineropened')) {
    
    $container.removeClass('fileuploadcontaineropened');
  } else {
    
    
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
   
    $container.addClass('fileuploadcontaineropened');
   

  }

});


$('.fileuploadcontainer input[type="file"]').on('input', function() {
    var $form = $(this).closest('form');
    $form.trigger('submit');
});


$('.fileuploadcontainer form').submit(function (e) {
e.preventDefault();

$('.filepercentageandloader').css('display', 'block');
$('.drop-area2').css('display', 'none');


var $container = $(this).closest('.attachment-toggle').find('.attachmentshowcontainer');
var $mothercontainer = $(this).closest('.attachment-toggle').find('.fileuploadcontainer');




var formData = new FormData(this);
    var motherContainerValue = formData.get('motherContainer');
    var datashowContainerValue = formData.get('datashowContainer');
    var progressBarContainer = $('.filepercentageandloader');


        formData.getAll('eprocfiles[]').forEach(function (file, index) {
            
            var fileProgressBar = $('<div class="rounded " style="margin-top: 10px !important; width: 100% !important; height: 70px !important; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6 !important;"><span>'+ file.name+'</span><div class="d-flex justify-content-around align-items-center "><div class="lds-spinner" style="position: relative !important; top: -5px !important;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div><div class="progress " style="width: 70% !important; height: 12px !important;"><div class="progress-bar"  role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div></div></div>');
            progressBarContainer.append(fileProgressBar)
})

var progressBar = $('.progress-bar');

$.ajax({
    url: '../../../views/eProcurement_mod/api/new_api_file_upload.php',
    type: 'POST',
    data: formData,
    xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function (evt) {
            if (evt.lengthComputable) {
                var percentComplete = (evt.loaded / evt.total) * 100;
                progressBar.width(percentComplete + '%');
                progressBar.attr('aria-valuenow', percentComplete);
                progressBar.text(percentComplete.toFixed(2) + '%');
            }
        }, false);
        return xhr;
    },
    success: function (responseData) {
      
      console.log(responseData);
		var responseObject = JSON.parse(responseData);


$.each(responseObject, function(index, item) {
	
	var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="../../../controllers/utilities/api_upload_attachment_show.php?name='+item.new_name+'&folder='+item.tr_from+'" target="_blank" rel="noopener"><em class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></em> <span>'+item.original_name+'</span></a><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,\''+item.attachment_id+'\',\''+item.rfq_no+'\',\''+item.tr_from+'\',\''+item.entry_by+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><em class="fa-solid fa-xmark"></em></button></div></div>');
	$container.append(card);

    $mothercontainer.removeClass('fileuploadcontaineropened');

	$('.filepercentageandloader').empty();
	$('.filepercentageandloader').css('display', 'none');
    $('.drop-area2').css('display', 'block');

	
});
  


    },
    error: function (xhr, status, error) {
        console.error('Error uploading image:', error);
        $('#response').text('Error uploading image. Please try again.');
    },
    cache: false,
    contentType: false,
    processData: false
});
});

$('.attachmenturluploadcontainer form').submit(function (e) {
e.preventDefault();

var $container = $(this).closest('.attachment-toggle').find('.attachmentUrlshowcontainer');
var $mothercontainer = $(this).closest('.attachment-toggle').find('.attachmenturluploadcontainer');
console.log($mothercontainer);
console.log()

var formData = new FormData(this);
var motherContainerValue = formData.get('motherContainer');
var datashowContainerValue = formData.get('datashowContainer');


 


$.ajax({
    url: '../../../views/eProcurement_mod/api/new_api_url_upload.php',
    type: 'POST',
    data: formData,

    success: function (responseData) {
   
     console.log(responseData);

		var responseObject = JSON.parse(responseData);
		
    var urlData = responseObject.url_data;
        

    if (!urlData.startsWith('https://')) {
       
        urlData = 'https://' + urlData;
    }

    var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="' + urlData + '" target="_blank" rel="noopener"><em class="fa-duotone fa-link fa-2xl" style="--fa-primary-color: #d6960a; --fa-secondary-color: #d6960a;"></em><span>' + urlData + '</span></a><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,\'' + responseObject.attachment_id + '\',\'' + responseObject.rfq_no + '\',\'' + responseObject.tr_from + '\',\'' + responseObject.entry_by + '\',\'' + motherContainerValue + '\',\'' + datashowContainerValue + '\')"><em class="fa-solid fa-xmark"></em></button></div></div>');
    $container.append(card);
    
		$mothercontainer.removeClass('fileuploadcontaineropened');
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');
		

    },
    error: function (xhr, status, error) {
        console.error('Error uploading image:', error);
        $('#response').text('Error uploading image. Please try again.');
    },
    cache: false,
    contentType: false,
    processData: false
});
});

$('.attachmenttextuploadcontainer form').submit(function (e) {
e.preventDefault();

var $container = $(this).closest('.attachment-toggle').find('.attachmentTextshowcontainer');
var $mothercontainer = $(this).closest('.attachment-toggle').find('.attachmenttextuploadcontainer');


var formData = new FormData(this);
var motherContainerValue = formData.get('motherContainer');
var datashowContainerValue = formData.get('datashowContainer');
 


$.ajax({
    url: '../../../views/eProcurement_mod/api/new_api_text_upload.php',
    type: 'POST',
    data: formData,

    success: function (responseData) {
       
        console.log("Ffffffffffffffffff");
    console.log(responseData);
		var responseObject = JSON.parse(responseData);

		var card = $('<div class="col-sm-12 col-md-12 col-lg-12 pb-1"><div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><span><em class="fa-solid fa-text-size fa-xl" style="color: #df5c16;"></em><span> '+responseObject.text_data+'</span></span><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,\''+responseObject.attachment_id+'\',\''+responseObject.rfq_no+'\',\''+responseObject.tr_from+'\',\''+responseObject.entry_by+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><em class="fa-solid fa-xmark"></em></button></div></div>');
		$container.append(card);
		$mothercontainer.removeClass('fileuploadcontaineropened');
    $('.fileuploadcontaineropened').removeClass('fileuploadcontaineropened');


    },
    error: function (xhr, status, error) {
        console.error('Error uploading image:', error);
        $('#response').text('Error uploading image. Please try again.');
    },
    cache: false,
    contentType: false,
    processData: false
});
});

function deleteAttachmentseventinfo(button,attachmentid, masterId, trFrom, entryBy,motherContainerValue,datashowContainerValue) {
  
  var $attachmentcontainershow = $(button).closest('.attachmentshowcontainer');
 
  


    $.ajax({
        url: '../../../views/eProcurement_mod/api/api_attachment_delete.php',
        type: 'POST',
        data: JSON.stringify({
        attachmentid: attachmentid,
        masterId: masterId,
        trFrom: trFrom,
        entryBy: entryBy
    }),
        success: function(responseData) {

        console.log(responseData)
            
			var responseObject = JSON.parse(responseData);
			$attachmentcontainershow.empty();



		$.each(responseObject, function(index, item) {
			
			var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style="background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="../../../views/eProcurement_mod/utilities/support/api_upload_attachment_show.php?name='+item.new_name+'&folder='+item.tr_from+'" target="_blank" rel="noopener"><em class="fa-light fa-file fa-2xl fs-22" style="color: #d6960a;"></em> <span>'+item.original_name+'</span></a><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentseventinfo(this,\''+item.attachment_id+'\',\''+item.rfq_no+'\',\''+item.tr_from+'\',\''+item.entry_by+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><em class="fa-solid fa-xmark"></em></button></div></div>');
            
			$attachmentcontainershow.append(card);
		})
            
        },
        error: function(xhr, status, error) {
            console.error('Error uploading image:', error);
            $('#response').text('Error uploading image. Please try again.');
        },
       
    });
}
function deleteAttachmentURLseventinfo(button,attachmentid, masterId, trFrom, entryBy,motherContainerValue,datashowContainerValue) {
  var $attachmentcontainershow = $(button).closest('.attachmentUrlshowcontainer');
 
    $.ajax({
        url: '../../../views/eProcurement_mod/api/api_attachment_url_delete.php',
        type: 'POST',
        data: JSON.stringify({
        attachmentid: attachmentid,
        masterId: masterId,
        trFrom: trFrom,
        entryBy: entryBy
    }),
        success: function(responseData) {
           console.log(responseData);
			var responseObject = JSON.parse(responseData);
			$attachmentcontainershow.empty();



		$.each(responseObject, function(index, item) {
			
			var card = $('<div class="col-sm-10 col-md-10 col-lg-10 pb-1"><div class="rounded p-2" style=" word-break: break-all; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><a href="'+item.url_data+'" target="_blank" rel="noopener"><em class="fa-duotone fa-link fa-2xl" style="--fa-primary-color: #d6960a; --fa-secondary-color: #d6960a;"></em><span>'+item.url_data+'</span></a><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentURLseventinfo(this,\''+item.attachment_id+'\',\''+item.rfq_no+'\',\''+item.tr_from+'\',\''+item.entry_by+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><em class="fa-solid fa-xmark"></em></button></div></div>');            
			$attachmentcontainershow.append(card);
		})
          
        },
        error: function(xhr, status, error) {
            console.error('Error uploading image:', error);
            $('#response').text('Error uploading image. Please try again.');
        },
       
    });
}

function deleteAttachmentTextseventinfo(button,attachmentid, masterId, trFrom, entryBy,motherContainerValue,datashowContainerValue) {
  var $attachmentcontainershow = $(button).closest('.attachmentTextshowcontainer');

    $.ajax({
        url: '../../../views/eProcurement_mod/api/api_attachment_text_delete.php',
        type: 'POST',
        data: JSON.stringify({
        attachmentid: attachmentid,
        masterId: masterId,
        trFrom: trFrom,
        entryBy: entryBy
    }),
        success: function(responseData) {
            
			var responseObject = JSON.parse(responseData);
			$attachmentcontainershow.empty();



		$.each(responseObject, function(index, item) {
			
			var card = $('<div class="col-sm-12 col-md-12 col-lg-12 pb-1"><div class="rounded p-2" style=" height: 40px !important; background-color: #f7f7f7 !important; border: 1px solid #e6e6e6!important; "><span><em class="fa-solid fa-text-size fa-xl" style="color: #df5c16;"></em><span> '+item.text_data+'</span></span><button type="button" style=" display: inline !important;" class="border-0" onclick="deleteAttachmentTextseventinfo(this,\''+item.attachment_id+'\',\''+item.rfq_no+'\',\''+item.tr_from+'\',\''+item.entry_by+'\',\''+motherContainerValue+'\',\''+datashowContainerValue+'\')"><em class="fa-solid fa-xmark"></em></button></div></div>');            
			$attachmentcontainershow.append(card);
		})
          
        },
        error: function(xhr, status, error) {
            console.error('Error uploading image:', error);
            $('#response').text('Error uploading image. Please try again.');
        },
       
    });
}





