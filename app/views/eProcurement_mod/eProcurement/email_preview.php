<link type="text/css" href="sample.css" rel="stylesheet"  />
  <style>
    /* Mobile Styles */
    @media only screen and (max-width: 600px) {
      .container {
        width: 100% !important;
        padding: 0 20px;
      }
      .responsive-img {
        width: 100% !important;
        height: auto !important;
      }
    }

  .ck.ck-balloon-panel.ck-powered-by-balloon[class*=position_border]{
    display: none !important;
  }

  
  </style>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
  <?
  
  if($mail_template!=''){
   $mail_template = $mail_template;
  }else{
   $mail_template = find_a_field('mail_template_setup','mail_template','id=1');
  }
  ?>
  <form method="post" id="mailTemp" name="mailTemp">
 <textarea id="editor" name="mail_template"><?=$mail_template?></textarea>
 <? if($_SESSION['master_status']=='MANUAL' && $_SESSION['user_role']=='Owner'){?>
 <input type="submit" name="update_mail_template" id="update_mail_template" value="Update Mail Template" class="btn1 btn1-bg-cancel"/>
 <? } ?>
  </form>
 
<script src="ckeditor.js"></script>

<script>

	ClassicEditor
		.create( document.querySelector( '#editor' ), {
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>

<!--<script>
function event_mail_template() {
  var formData = $("#mailTemp").serialize();
  alert('ok');
  $.ajax({
    url: "mail_template_ajax.php",
    method: "POST",
    dataType: "JSON",
    data: formData,
    success: function (result, msg) {
      var res = result;
      
    },
  });
}
</script>-->



