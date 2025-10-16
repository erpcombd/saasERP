<style>
	<?php
	$style=find_all_field('chq_print_setup','*','chq_id="'.$style_css.'"');
 ?>
root{

}
		/* Set A4 size */
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		@page {
			size: A4;
			margin: 0px !important;
		}
		/* Set content to fill the entire A4 page */
		html,
		body {
			width: 210mm;
			height: 297mm;
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			/*align-items: center;*/
		}
		/* Style content with shaded background */
		.chq-content {
			width: <?=$style->width?>mm;
			height: <?=$style->height?>mm;
			padding: 4mm;
			box-sizing: border-box;
			font-family: Arial, sans-serif;
			background-color: #f0f0f0;
		}
		
		.account-payee, .chq-date, .chq-pay-name, .bearer, .chq-inwords-n1, .chq-inwords-n2, .amount, .muri_amount{
			position:absolute !important;
			border:1px solid #333;
			padding: 3px;
		}
		
		.account-payee{
			left: <?=$style->acct_pay_left;?>mm;
			top: <?=$style->acct_pay_top;?>mm;
			width:<?=$style->acct_pay_width;?>mm;
			height:<?=$style->acct_pay_hight?>mm;
			display:flex;
			justify-content: <?=$style->acct_pay_align?>;
			align-items:center;
			font-family:Arial, Helvetica, sans-serif;
			font-size:<?=$style->acct_pay_font_size;?>px;
		}
		
		.chq-date{
			left: <?=$style->date_left;?>mm;
			top: <?=$style->date_top;?>mm;
			border:none;
			display:flex;
			justify-content: center;
		}
		.chq-date .latter1, .chq-date .latter2, .chq-date .latter3, .chq-date .latter4, .chq-date .latter5, .chq-date .latter6, .chq-date .latter7, .chq-date .latter8{
			width: <?=$style->date_width;?>mm;
			height: <?=$style->date_hight;?>mm;
			border:1px solid #333;
			margin-left: <?=$style->date_letter;?>mm;
			display:flex;
			justify-content: <?=$style->date_align;?>;
			align-items:center;
			font-family:Arial, Helvetica, sans-serif;
			font-size:<?=$style->date_font_size;?>px;
		}
		.chq-date .latter3, .chq-date .latter5{
			margin-left:<?=$style->date_section;?>mm;
		}
		
				
		.chq-pay-name{
			left: <?=$style->name_left;?>mm;
			top: <?=$style->name_top;?>mm;
			width: <?=$style->name_width;?>mm;
			height: <?=$style->name_hight;?>mm;
			display:flex;
			justify-content: <?=$style->name_align;?>;
			align-items:center;
			font-family:Arial, Helvetica, sans-serif;
			font-size: <?=$style->name_font_size;?>px;
		}
						
		.bearer{
			left: <?=$style->bearer_left; ?>mm;
			top: <?=$style->bearer_top; ?>mm;
			width:<?=$style->bearer_width; ?>mm;
			height:<?=$style->bearer_hight; ?>mm;
			display:flex;
			justify-content: <?=$style->bearer_align; ?>;
			align-items:center;
			font-family:Arial, Helvetica, sans-serif;
			font-size:<?=$style->bearer_font_size; ?>px;
		}		
		
			
				
					
		.chq-inwords-n1{
			left: <?=$style->in_words_left;?>mm;
			top: <?=$style->in_words_top;?>mm;
			width:<?=$style->in_words_width;?>mm;
			height:<?=$style->in_words_hight;?>mm;	
			line-height: <?=$style->in_words_line_height;?>mm;
			display:flex;
			justify-content: <?=$style->in_words_align;?>;
			align-items:center;
			font-family:Arial, Helvetica, sans-serif;
			font-size:<?=$style->in_words_font_size;?>px;
		}
		
								
		.chq-inwords-n2{
			left: 5mm;
			top: 46mm;
			width:120mm;
			height:8mm;
			display:flex;
			justify-content: center;
			align-items:center;
			font-family:Arial, Helvetica, sans-serif;
			font-size:15px;
		}
		
										
		.amount{
			left: <?=$style->amount_left;?>mm;
			top: <?=$style->amount_top;?>mm;
			width:<?=$style->amount_width;?>mm;
			height:<?=$style->amount_hight;?>mm;
			display:flex;
			justify-content: <?=$style->amount_align;?>;
			align-items:center;
			font-family:Arial, Helvetica, sans-serif;
			font-size:<?=$style->amount_font_size;?>px;
		}
		
		.muri_amount{
			left: <?=$style->muri_amount_left; ?>mm;
			top: <?=$style->muri_amount_top; ?>mm;
			width:<?=$style->muri_amount_width; ?>mm;
			height:<?=$style->muri_amount_height; ?>mm;
			display:flex;
			justify-content: <?=$style->muri_amount_align; ?>;
			align-items:center;
			font-family:Arial, Helvetica, sans-serif;
			font-size:<?=$style->muri_amount_front_size; ?>px;
		}	
		
		@media print{
		.chq-content {
			background:none !important;
		}
		
		@media print{
		.chq-date .latter1, .chq-date .latter2, .chq-date .latter3, .chq-date .latter4, .chq-date .latter5, .chq-date .latter6, .chq-date .latter7, .chq-date .latter8{
			
			border:none !important;
		}
		
		.account-payee, .chq-date, .chq-pay-name, .bearer, .chq-inwords-n1, .chq-inwords-n2, .amount, .muri_amount{
			border: none !important;
		}
		
		body {
        transform: rotate(270deg) !important;
        transform-origin: left top !important;
        width: 100vh !important;
        /*height: 100vw;*/
        overflow: hidden !important;
        position: absolute !important;
        left: 0 !important;
        top: 100% !important;
		margin: 0;
    	padding: 0;
		font-size:15px;
		
    }
	

/* body {
        transform: rotate(270deg) !important;
        transform-origin: left top !important;
        overflow: hidden !important;
        position: absolute !important;
        left: 0 !important;
        top: 100% !important;
    }*/
		}
</style>
	
	
	
<!--<style>
/* Add the following styles for vertical printing */
#pr input[type="button"] {
    width: 70px !important;
    height: 25px !important;
    background-color: #6cff36 !important;
    color: #333 !important;
    font-weight: bolder !important;
    border-radius: 5px !important;
    border: 1px solid #333 !important;
    cursor: pointer !important;
}
p {
    letter-spacing: 17px !important;
    font-weight: 600 !important;
    padding-left: 15px !important;
    font-size: 13px !important;
}

/*.cheque_table{
    width: 750px !important;
    margin-top: -25px !important;
    float: left !important;
}*/
    
@media print{

    .cheque_table{
    width: 750px !important;
    margin-top: -55px !important;
    float: right !important;
    margin-right:-39px !important;
}
    .header{
    margin-top: 40% !important;
    margin-bottom: 40% !important;
}
       body {
        transform: rotate(270deg) !important;
        transform-origin: left top !important;
        width: 100vh !important;
        /*height: 100vw;*/
        overflow: hidden !important;
        position: absolute !important;
        left: 0 !important;
        top: 100% !important;
    }
}
.font{
    font-size: 14px !important;
}
</style>-->