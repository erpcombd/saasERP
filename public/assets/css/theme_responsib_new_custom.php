<?php
$allCss=find_all_field('config_template','','status=1');

header('Content-Type: text/html; charset=UTF-8');

$base_color = "$allCss->base_color";
$table_top_bg_color = "$allCss->table_top_bg_color";
$table_top_text_color = "$allCss->table_top_text_color";
$table_child_odd_color = "$allCss->table_row_odd_color";
$table_child_even_color = "$allCss->table_row_even_color";
$table_hover_bg = "$allCss->table_row_hover_color";
$font_size = "$allCss->font_size";
$font_family = "$allCss->font_family";

?>


<style>
:root {
    /*Define Theme text Color and backgroun color code*/
    /*--theme-color-bgc: green;*/
    --theme-color-bgc: <?=$base_color?>;

    --table-top-color: <?=$table_top_bg_color?>;

    --table-top-text-color: <?=$table_top_text_color?>;

    --table-child-odd-color: <?=$table_child_odd_color?>;

    --table-child-even-color: <?=$table_child_even_color?>;

    --table-hover-bg: <?=$table_hover_bg?>;

    /*--theme-color-bgc: #6239EB;*/

    --theme-color-text:;



	--add-top-bg-color:#e8f1f3;

	--add-top-color:#010611;

	--add-shadow1-bg-color:#FFFFFF;

/*---- Main menu and menu dropdown color code -----*/

    /*menu background color*/

    --menu-bg-color: #FFFFFF;

    --item-main-bg-color:var(--menu-bg-color);



    /*menu item background color*/

    /*color*/

    --white-1:#333;

    /*bg color*/

    --nav-item-bg:var(--menu-bg-color);



    /*hover color*/

    --nav-item-hover-bg:var(--theme-color-bgc);

    /*--nav-item-hover-bg:#6239EB;*/



    /*menu item dropdown background color*/

    /*color*/

    --sub-text:#11101d;



    /*bg-color*/

    --dropdown-item:#e0d2eb;

    /*--dropdown-item:#EFEBFD;*/



    /*border color*/

    --nav-border:#0401012e;



    /*hover background color*/

    --nav-item-dropdown:#fff;

    /*--nav-item-dropdown:#c9c9c9;*/



    /*hover color*/

    --white-normal: var(--white-1);



    --color-item-hover:#fff;



    /*active color*/

    --active-bg:var(--menu-bg-orange);

    /*--active-bg:#EFEBFD;*/

    /*--active-bg:#5c5a5af5;*/



    /*module main bg color*/

    --module-titel:#fff;

    --module-color:var(--theme-color-bgc);



    /*img back ground color*/

    --bg-color:var(--menu-bg-color);

    --menu-bg-red: #db3333;

    --logout-bg-red:#ff0000;

    --menu-bg-green:#33ab33;

    --menu-bg-deepskyblu:#00bfff;

    --menu-bg-purple:#bd16a4;

    --menu-bg-orange:#ffa500;





    /* Define all Button color */

/*---- background color and text color code -----*/

    --bgc-text-color: #ffffff;

    --bgc-text-color1: #000000;



    /*background css color code*/

    --bgc-color-primary: #007BFF;

    --bgc-color-info : #17a2b8;

    --bgc-color-success: #28a745;

    --bgc-color-yellow: #ffc107;

    --bgc-color-danger: #dc3545;

    --bgc-color-violet:#AF7AC5;

    --bgc-color-light-green:#1ABC9C;

    --bgc-color-yellow1:#E9FF85;



/*---- Button color code -----*/

    --btn-text-color: #ffffff;

    --btn-text-color1:#000000;



    /*Button hover color*/

	--btn-hover-hrm-color:#8b0580;

    --btn-hover-cancel-color:#ad2f13;

	--btn-hover-submit-color:#066a61;

	--btn-hover-update-color:#054c7e;

	--btn-hover-help-color:#bedf08f5; 

	--btn-hover-input-color:#066a61;





    /*Button background color*/

    --btn-hrm-bg-color:#AC0693;

    --btn-bg-color-cancel:#dc3545;

    --btn-bg-color-submit:#198754;
/*    --btn-bg-color-submit:#009688;*/
    --btn-bg-color-update:#197fe9;

    --btn-bg-color-help:#ffc107;
	
    --btn-submit-input:#198754;
/*    --btn-submit-input:#009688;*/





    /*---- Table color code -----*/

    --table-bg-color:var(--table-top-color);

    /*--table-bg-color:#233f69;*/

    --table-color:var(--table-top-text-color);

    --child-odd-color:var(--table-child-odd-color);

    --child-even-color:var(--table-child-even-color);

    --table-hover-bg-color:var(--table-hover-bg);

    --child-text-color:#000;





    /*---- Form color code -----*/

    --form-white: #ffffff;

    /*all color css code*/

    --form-info: #17a2b8;

    --bgc-sallmon:#F9E79F;

    --bgc-sallmon1:#F9E79F;

    --white-smoke: #fff;
   /* --white-smoke: #efefef;*/
    /*--form-titel-bg-color:#cdebe5;*/
	--form-titel-bg-color:var(--add-shadow1-bg-color);

    --form-tabel-bg-color-info:#2471A3;

    --req-input-after:#FF0000;





}

/*-----------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------*/
/*-----------new inputrt fieldset design start--------------*/
  fieldset.scheduler-border {
/*    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;*/
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
    padding: 7px !important;
    border: 1px solid #817777 !important;
    border-radius: 5px !important;
}

legend.scheduler-border {
	border:none;
/*	width:100px;*/
/*	width:20%;
    font-size: 1.2em !important;*/
    font-weight: bold !important;
    text-align: left !important;
	
	font-size: 12px !important;
    margin: 0px;
    border-radius: 5px;
    padding-left: 4px;
    width: max-content;
}
/*-----------new inputrt fieldset design End--------------*/
/*-----------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------*/




/*-----------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------*/
/*--------------------------------- new css for new update design css Start ---------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------*/

.bg-light{

    background-color: #ffffff !important;

}



.req{

	border-left:3.5px solid #df5b5b!important;

}


.add{

    color: var(--add-top-color);

	background-color: var(--add-top-bg-color);

    border-color: #b7b9bf;

	position:relative;

	padding:0px;

}



.shadow1 {

	background-color:var(--add-shadow1-bg-color) !important;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23) !important;

}



.new-bg{

	background-color:#FFFFFF;

	padding-top:20px;

	padding-bottom:20px;

}



.new_left{

position:absolute;

float:left;

}



.new_right{

position:relative;

float:right;

}



.sr-main-content-padding, .wrapper {

   /* background: #f3f3f3 !important;*/

	}

	

.sr-main-content-heading {

	font-size: 15px !important;

}



#avatar-upload {
    width: 40px !important;
    height: 40px !important;

}





.card-stats .card-header.card-header-icon i {

    font-size: 25px !important;

    line-height: 42px !important;

    width: 45px !important;

    height: 45px !important;

    text-align: center !important;

}


/*-----------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------*/
/*----------------------------------------- Button design is css Start --------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------------------*/

/*--- Define all color using code ---*/

/*color: var(--title-color);*/

/*font-family: var(--title-font);*/



div.form-container_large form fieldset {

    margin: 0px !important;

    padding: 0px !important;

    border: none !important;

    margin-bottom: 0px !important;

    padding-bottom: 0px !important;

}



/*----------------------------------------------*/

/*-------- button all css or color -----------*/

/*----------------------------------------------*/

.btn1-bg-hrm{

    background-color: var(--btn-hrm-bg-color);

    color: var(--btn-text-color);

    border-color: var(--btn-hrm-bg-color);

}

.btn1-bg-hrm:hover{

    background-color: var(--btn-hover-hrm-color);

    color: var(--btn-text-color);

    border-color: var(--btn-hrm-bg-color);

}





.btn1-bg-update{

    background-color: var(--btn-bg-color-update);

    color: var(--btn-text-color);

    border-color: var(--btn-bg-color-update);

}



.btn1-bg-update:hover{

    background-color: var(--btn-hover-update-color);

    color: var(--btn-text-color);

    border-color: var(--btn-bg-color-update);

}



/*btn1 btn1-bg-submit btn1-bg-cancel btn1-bg-update*/

/*btn1 btn1-submit-input*/



.btn1-bg-submit{

    background-color: var(--btn-bg-color-submit);

    color:var(--btn-text-color);

    border-color: var(--btn-bg-color-submit);

}

.btn1-bg-submit:hover{

    background-color: var(--btn-hover-submit-color);

    color: var(--btn-text-color);

    border-color: var(--btn-bg-color-submit);

}



.btn1-bg-submit::before {

    /*font-family: "Font Awesome 5 Free";*/

    /*content: '\f06e';*/

    /*display: inline-block;*/

    /*padding-right: 3px;*/

    /*vertical-align: middle;*/

    /*font-weight: 900;*/

}



.btn1-bg-cancel{

    background-color: var(--btn-bg-color-cancel);

    color:var(--btn-text-color);

    border-color: var(--btn-bg-color-cancel);

}



.btn1-bg-cancel:hover{

    background-color: var(--btn-hover-cancel-color);

    color:var(--btn-text-color);

    border-color: var(--btn-bg-color-cancel);

}



.btn1-bg-cancel::before {

    /*font-family: "Font Awesome 5 Free";*/

    /*content: '\f0e2';*/

    /*display: inline-block;*/

    /*padding-right: 3px;*/

    /*vertical-align: middle;*/

    /*font-weight: 900;*/

}





.btn1-bg-help{

    background-color: var(--btn-bg-color-help);

    color:var(--btn-text-color);

    border-color: var(--btn-bg-color-help);

}



.btn1-bg-help:hover{

    background-color: var(--btn-hover-help-color);

    color:var(--btn-text-color);

    border-color: var(--btn-bg-color-help);

}



.btn1-submit-input{

    background-color: var(--btn-submit-input);

    font-size: 14px;

    color:var(--btn-text-color);

    border-color: var(--btn-submit-input);

    border-radius: 5px;

}



.btn1-submit-input:hover{

    background-color: var(--btn-hover-input-color);

    color:var(--btn-text-color);

    border-color: var(--btn-submit-input);

}





.btn1-bg-primary{

    background-color: var(--btn-bg-color-update);

    color: var(--btn-text-color);

    border-color: var(--btn-bg-color-update);

}

.btn1-bg-primary:hover{

    background-color: var(--btn-hover-color);

    color: var(--btn-text-color);

    border-color: var(--btn-bg-color-update);

}



.btn1-bg-yellow{

    background-color: var(--btn-bg-color-help);

    color: var(---btn-text-color1);

    border-color: var(--btn-bg-color-help);

}



.btn1-bg-yellow:hover{

    background-color: var(--btn-hover-color);

    color: var(--btn-text-color1);

    border-color: var(--btn-bg-color-help);

}





/*-------- Btn customis css start -----*/

.btn1{

    display: inline-block;

    font-weight: 400;

    text-align: center;

    vertical-align: middle;

    cursor: pointer;

    -webkit-user-select: none;

    -moz-user-select: none;

    -ms-user-select: none;

    user-select: none;

    border: 1px solid transparent;

    line-height: 1.5;

    padding: 0.25rem 0.5rem;

    font-size: .875rem;

    border-radius: 0.2rem;

    margin: 1px;

    min-width: 100px!important;

    /*padding: 0.375rem 0.75rem;*/

    /*font-size: 1rem;*/

    /*border-radius: 0.25rem;*/

    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;

}



.btn2{

    display: inline-block;

    font-weight: 400;

    text-align: center;

    vertical-align: middle;

    cursor: pointer;

    -webkit-user-select: none;

    -moz-user-select: none;

    -ms-user-select: none;

    user-select: none;

    border: 1px solid transparent;

    line-height: 1.5;

    padding: 0.25rem 0.5rem;

    font-size: .875rem;

    border-radius: 0.2rem;

    margin: 1px;

    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;

}







.input-btn-submit{

    width: 50%;

    margin-left: 25%;

    margin-right: 25%;

    border-radius: 5px;

}







/*---------------------------------------------------*/

/*------ background color css or text color ---------*/

/*---------------------------------------------------*/

.bgc-primary{

    background-color: var(--bgc-color-primary);

    color: var(--bgc-text-color);

}



.bgc-info{

    background-color: var(--bgc-color-info);

    color: var(--bgc-text-color);

}



.bgc-success{

    background-color: var(--bgc-color-success);

    color:var(--bgc-text-color);

}



.bgc-yellow{

    background-color: var(--bgc-color-yellow);

    color: var(--bgc-text-color1);



}



.bgc-danger{

    background-color: var(--bgc-color-danger);

    color:var(--bgc-text-color);

}



.bgc-violate{

    background-color: var(--bgc-color-violet);

    color:var(--bgc-text-color);

}

.bgc-light-green{

    background-color: var(--bgc-color-light-green)!important;

    color:var(--bgc-text-color)!important;

}



.bgc-yello1{

    background-color: var(--bgc-color-yellow1);

    color: var(--bgc-text-color1);

}



/*btn btn-bg-success btn-bg-danger btn-bg-info*/

























/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*------------------------------------------- Menu design is css Start --------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/



<!--body with font Siz-->

body, h1, h2, h3, h4, h5, h6, p, a, samp, span,table,.table1,.bg-form-titel-text,.forum-item-title,.forum-sub-title {
/*	font-size:16px !important;*/
	font-size:<?=$font_size?> !important;

}

input[type=text], select, input,.btn1, button,.ui-menu-item, label, .label{
font-size:<?=$font_size?> !important;
font-weight:500 !important;
}


  /*new font siz*/
  .fs-8{font-size:8px !important;}.fs-9{font-size:9px !important;}.fs-10{font-size:10px !important;}.fs-11{font-size:11px !important;}.fs-12{font-size:12px !important;}.fs-13{font-size:13px !important;} .fs-14{font-size:14px !important;}  .fs-15{font-size:15px !important;}  .fs-16{font-size:16px !important;}  .fs-17{font-size:17px !important;}  .fs-18{font-size:18px !important;}  .fs-19{font-size:19px !important;}  .fs-20{font-size:20px !important;} .fs-21{font-size:21px !important;}.fs-22{font-size:22px !important;}
  /*end font siz*/






<!--body with fontfamilly-->
body, h1, h2, h3, h4, h5, h6, p, a, b, samp, span, .module-title, .sr-main-content-heading, .col-md-12, .col-sm-12, .col-lg-12, .col-12, .col-md-11, .col-sm-11, .col-lg-11, .col-11, .col-md-10, .col-sm-10, .col-lg-10, .col-10, .col-md-9, .col-sm-9, .col-lg-9, .col-9, .col-md-8, .col-sm-8, .col-lg-8, .col-8, .col-md-7, .col-sm-7, .col-lg-7, .col-7, .col-md-6, .col-sm-6, .col-lg-6, .col-6, .col-md-5, .col-sm-5, .col-lg-5, .col-5, .col-md-4, .col-sm-4, .col-lg-4, .col-4, .col-md-3, .col-sm-3, .col-lg-3, .col-3, .col-md-2, .col-sm-2, .col-lg-2, .col-2, .col-md-1, .col-sm-1, .col-lg-1, .col-1, table, tr, td, th, tbody, thead, tfoot, col, colgroup, caption, table1, ul, li, ol, dl, dd, .bg-warning, .bg-titel, .container, .row, .container-fluid, .n-form, .form-group, .n-form-btn-class, .n-form-titel1, .card-footer,.card-title,.stats h5, canvas,.ui-widget, center, legend.scheduler-border, .Emp_n, .Emp_n1{
	<?=$font_family?>
/*	font-family: 'Montserrat', sans-serif !important;*/
/*    font-family: 'Poppins', sans-serif !important;*/
}




/*body, h1, h2, h3, h4, h5, h6, p, a, samp{
    overflow: auto!important;
}
span{
	overflow:hidden!important;
}*/



body{
    overflow-x: hidden;
	background-color: #f5f5f5 !important;
    color: #3C4858 !important;
    font-weight: 300 !important;
	line-height: 1.5em !important;
	margin: 0 !important;
}

.form-container_large {
	padding:0px !important;
}

.round{
    border-radius: 5px !important;
}
.shadowdiv {
    /*border: 1px solid rgba(0, 0, 0, 0.125) !important;*/
    background-color: var(--add-shadow1-bg-color)!important;
    box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.16), 0px 0px 0px rgba(0, 0, 0, 0.23)!important;
}
.sidebar {
    background: #F5F5F2 !important;
    position: fixed;
	box-shadow: 0 0px 11px 0px rgba(0, 0, 0, 0.12), 0 0px 5px 1px rgba(0, 0, 0, 0.15) !important;
}
.sr-main-content, .wrapper {
    background-color: #f5f5f5 !important;
}

.sr-main-content-padding {
    background: #f5f5f5 !important;
    padding: 10px 15px !important;
    border: 1px solid #f5f5f5 !important;
    border-bottom: none !important;
}

.row{
margin:0px !important;
}

/*.sr-main-content-padding .navbar-transparent{
	box-shadow: none !important;
}
*/
.main_content .navbar-fixed-top {
    box-shadow: 0 0px 11px 0px rgba(0, 0, 0, 0.12), 0 0px 5px 1px rgba(0, 0, 0, 0.15) !important;
}







#clock .date{

	font-size:16px;

}







*, *::before, *::after {

    -webkit-box-sizing: border-box;

    box-sizing: border-box;

}



.theme_color_bg{

    background-color: var(--nav-item-hover-bg);

}





.theme_color{

	font-size:15px !important;

    color: var(--nav-item-hover-bg);

}



.company_name{

font-size:12px !important;

font-weight:500 !important;

}



.menu_bg{



    display:block;

    height: auto;

    min-height: 100%;

    padding: 0;

    vertical-align: top;

    transition: width 0.3s ease;

    border-top: 1px solid var(--nav-border);





}



.menu_bg {

    /*background-color: var(--nav-item-bg);*/

    background-color: var(--menu-bg-color);
	/*padding-bottom: 32px !important;*/
    padding-bottom: 100px !important;

    margin-top: 5px !important;

    /*padding-top: 5px !important;*/

}



.mhafuz11 a{

    border-left:5px solid var(--menu-bg-red);

    border-right: 5px solid var(--menu-bg-red);

}



.mhafuz22 a{

    border-left:5px solid var(--menu-bg-green);

    border-right: 5px solid var(--menu-bg-green);

}



.mhafuz33 a{

    border-left:5px solid var(--menu-bg-deepskyblu);

    border-right: 5px solid var(--menu-bg-deepskyblu);

}



.mhafuz44 a{

    border-left:5px solid var(--menu-bg-purple);

    border-right: 5px solid var(--menu-bg-purple);

}



.mhafuz55 a{

    border-left:5px solid var(--menu-bg-orange);

    border-right: 5px solid var(--menu-bg-orange);

}





.module-title{

    background-color:var(--module-titel);

    color:var(--module-color);

    width: 100%;

    /*text-align:center;*/

    text-align:left;

    font-size:14px !important;

    margin:0px;

    /*padding: 10px 0px;*/

    padding: 5px 0px 10px 7px;

    font-weight: 700;

}



.sidebar ,.title-image{

    background-color: var(--bg-color)!important;

}





.title-image{

    text-align: center;

    margin: 0px !important;

    padding: 0px !important;

}

.h_titel{
	font-weight:bold;
	font-size:16px;
	background-color: var(--theme-color-bgc);
	z-index: 0!important;
	text-transform:uppercase;
	color:#fff;
	padding: 10px 0px 10px 0px;
}


.menu-module-titel{

    background-color:var(--module-titel);

    color:var(--module-color);

    padding:10px;

    text-align:center;

    margin-bottom: 1px;

    margin-top: 1px;

}



.menu-module-titel a{

    color:var(--white-normal0)!important;

}





.dashboard1-app {

    display: -webkit-box;

    display: -webkit-flex;

    display: -ms-flexbox;

    display: flex;

    -webkit-box-orient: vertical;

    -webkit-box-direction: normal;

    -webkit-flex-direction: column;

    -ms-flex-direction: column;

    flex-direction: column;

    -webkit-box-flex: 2;

    -webkit-flex-grow: 2;

    -ms-flex-positive: 2;

    flex-grow: 2;

    margin-top: 84px;

}



.dashboard1-content {

    -webkit-box-flex: 2;

    -webkit-flex-grow: 2;

    -ms-flex-positive: 2;

    flex-grow: 2;

    padding: 25px;

}





.dashboard1-nav-list {

    display: -webkit-box;

    display: -webkit-flex;

    display: -ms-flexbox;

    display: flex;

    -webkit-box-orient: vertical;

    -webkit-box-direction: normal;

    -webkit-flex-direction: column;

    -ms-flex-direction: column;

    flex-direction: column;



}







.dashboard1-nav-item {

    min-height: 35px;

    font-size: 14px;

    /*line-height: 14px;*/

    padding: 13px 10px 10px 50px;



    display: -webkit-box;

    display: -webkit-flex;

    display: -ms-flexbox;

    display: flex;

    -webkit-box-align: center;

    -webkit-align-items: center;

    -ms-flex-align: center;

    align-items: center;

    letter-spacing: 0.02em;

    transition: ease-out 0.5s;

    background-color: var(--nav-item-bg);

    color: var(--white-1);

    cursor: pointer;

    /*border-top: 1px solid var(--nav-border);*/

    border-bottom: 1px solid var(--nav-border);

}





.dashboard1-nav-item i {

    /*width: 25px;*/

    width: 18px;

    font-size: 14px;

    margin-left: -40px;

    /*color: #979494;*/

    /*color: var(--theme-color-bgc);*/

}



.dashboard1-nav-item:hover {

    background-color: var(--nav-item-hover-bg);

    color: var(--color-item-hover) !important;

    /*border-radius: 10px;*/

    font-weight: 500;



}



.dashboard1-nav-item .dashboard1-nav-dropdown-toggle{

    font-size: 14px;

}



.active1 {

background-color: var(--active-bg)!important;

color: var(--white-normal)!important;

font-weight: 400;

/*border-radius: 5px;*/

}



.dashboard1-nav-dropdown .dashboard1-nav-item{

    line-height: 17px;

    padding-top: 15px;

    padding-bottom: 15px;

    text-align: left;







}



.dashboard1-nav-dropdown {

    color: var(--white-1);

    background: var( --item-main-bg-color);

    display: -webkit-box;

    display: -webkit-flex;

    display: -ms-flexbox;

    display: flex;

    -webkit-box-orient: vertical;

    -webkit-box-direction: normal;

    -webkit-flex-direction: column;

    -ms-flex-direction: column;

    flex-direction: column;

}



.dashboard1-nav-dropdown .show{

    transition:all 0.3s ease-in-out;

}





.dashboard1-nav-dropdown.show .dashboard1-nav-item {

    background-color: var(--nav-item-hover-bg);

    color: var(--color-item-hover) !important;

    font-weight: 500;

    text-shadow: rgb(0 0 0 / 25%) 0 -1px 0;

    box-shadow: rgb(0 0 0 / 25%) 0 1px 0, inset rgb(255 255 255 / 16%) 0 1px 0;

    /*transition: 60s;*/

}





.dashboard1-nav-dropdown.show > .dashboard1-nav-dropdown-toggle:after {

    transform: rotate(135deg);

}



.dashboard1-nav-dropdown.show > .dashboard1-nav-dropdown-menu {

    display: -webkit-box;

    display: -webkit-flex;

    display: -ms-flexbox;

    display: flex;

    transition:all 0.3s ease-in-out;

}




.dashboard1-nav-dropdown-toggle:after {
    border-style: solid;
    border-width: 0.20em 0.20em 0 0;
	/*border-width: 0.25em 0.25em 0 0;*/
    content: '';
    display: inline-block;
	
	height: 7px;
    width: 7px;
/*    height: 9px;
    width: 9px;*/
    left: 0.15em;
    position: relative;
    vertical-align: top;
    top: 0;
    transform:rotate(222deg);
    margin-left: auto;
}







.dashboard1-nav-dropdown-menu {

    display: none;

    -webkit-box-orient: vertical;

    -webkit-box-direction: normal;

    -webkit-flex-direction: column;

    -ms-flex-direction: column;

    flex-direction: column;

}



.dashboard1-nav-dropdown-item {

    min-height: 40px;

    padding: 8px 20px 8px 15px;

    font-size: 13px;

    line-height: 14px;

    display: -webkit-box;

    display: -webkit-flex;

    display: -ms-flexbox;

    display: flex;

    -webkit-box-align: center;

    -webkit-align-items: center;

    -ms-flex-align: center;

    align-items: center;

    text-align: left;

    transition: ease-out 0.5s;

    font-weight: 600;

    color: var(--sub-text);

    background-color: var(--dropdown-item);

    border-bottom: 1px solid var(--nav-border);

}







.dashboard1-nav-dropdown-item:hover {

    /*border-radius: 5px;*/

    background-color: var(--nav-item-dropdown)!important;

    color: var(--nav-item-hover-bg) !important;

    /*color: var(--white-normal)!important;*/

}



.dashboard1-nav-dropdown-item:before{

    font-family: "Font Awesome 5 Free";

    content: "\f111";

    display: inline-block;

    padding-right: 5px;

    vertical-align: middle;

    color: var(--nav-item-hover-bg);

    font-size: 9px;

    /*font-size: 13px;*/

    /*color: var(--sub-text);*/

}





.sidebar footer{

    /*position: absolute;*/

    background-color:var(--nav-item-hover-bg);

    bottom: 0px;

    border-radius: 0px;

}

.ul1 .li1:hover .li1 .menu-moule-icon i{

    color: var(--theme-color-bgc);

}





.menu-moule-icon{

    background-color:var(--nav-item-hover-bg);

    border-radius: 0px;

}



/*.sidebar footer i,.menu-moule-icon i{*/

    /*background-color: var(--nav-item-bg);*/

    /*/!*color: var(--logout-bg-red)!important;*!/*/

    /*color: var(--theme-color-bgc)!important;*/

    /*width: 30px;*/

    /*font-size: 18px;*/

    /*padding: 6px;*/

    /*border-radius: 5px;*/

    /*/!* margin-right: 0px; *!/*/

/*}*/



.sidebar footer i,.menu-moule-icon i{

    background-color: var(--nav-item-bg);

    /* color: var(--logout-bg-red)!important; */

    color: var(--theme-color-bgc)!important;

    width: 22px;

 /*   font-size: 18px;*/

	font-size: 14px;

	padding-top: 5px;

/*    padding-top: 3px;*/

    border-radius: 5px;

    /* margin-right: 0px; */

    font-weight: 800;

    height: 25px;

    margin-bottom: 4px;

}





.exit{

    font-weight: 700;

}





.sidebar footer a{

    color: var(--white-normal);

    font-size: 14px;

    padding-right: 15px;

}



@media (max-width: 991px){

    .navbar-header {

        float: none;

        margin-left: 15%!important;

    }

    .sidebar footer{

        position: relative;

        bottom: 0px;

        border-radius: 0px;

        width: 100%;

    }



    .menu_bg {

        padding-bottom: 32px;

    }

}





@media (min-width: 1200px) {

    .dashboard1-nav-item{

        font-size: 13px;

        font-weight: 500;

        /*font-size: 13px;*/

        /*font-weight: 700;*/

    }



    .dashboard1-nav-dropdown-item{

        font-size: 12px;

    }

}













/*-------------------------------------------*/

/*------new menu left design start-----------*/

/*--------------------------------------------*/
					 .right1{
					 	overflow:hidden !important;
					 }
					 .sidemenu-top{
					 	position:relative !important;
					 }
					 .menu_bg{
						overflow-x: scroll;
						position: relative;
						height: 100%;
					 }
					 
					/* Custom Scrollbar (for WebKit browsers) */
					.menu_bg::-webkit-scrollbar {
						width: 0px; /* Width of the scrollbar */
					}
			
/*					.menu_bg::-webkit-scrollbar-track {
						background: #f1f1f1; 
						border-radius: 10px;
					}
			
					.menu_bg::-webkit-scrollbar-thumb{
						background: #888; 
						border-radius: 10px;
					}
			
					.menu_bg::-webkit-scrollbar-thumb:hover{
						background: #555; 
					}*/


 .left1{

     /*width: 5%;*/
     width: 50px;
     float: left;
     top: 0;
     height: 100%;
     position: fixed;
     overflow: hidden;
	 z-index: 1000!important;

 }



.left1 a{

    text-align: center;

    padding: 5px;

    line-height: 2.5em !important;

}



.left1 a i{

    color: #FFFFFF;

}



.right1{

    width: 84%;

    float: right;

    top: 0px;

    height: 100%;

    /*position: relative;*/

    z-index: 999 !important;

    background-color: white;

    /*padding-top: 10px;*/

}



.ul1{

    list-style: none;

    margin: 0;

    padding: 0;

	margin-top: 40px;



}



.active-icon{

    background-color: #fff;

    /*border-radius: 50% 0% 0% 50%;*/

    margin-left: 5px;

    border-top-left-radius: 65px;

    border-bottom-left-radius: 65px;

}



.active-icon a{

    padding: 10px;

}



.active-icon a i{

    color: var(--theme-color-bgc);

}





.ul1 .li1:hover{

    /*background-color: #fff;*/

    /*margin-left: 0px;*/

    border-top-left-radius: 100px;

    border-bottom-left-radius: 100px;

}



.ul1 .li1:hover a i, .ul1 .li1:hover .menu-moule-icon i, .ul1 .li1:hover .li2{

    color: var(--theme-color-bgc);

    background-color: #8fe5ff;

}









.li2, .ul2{

    margin: 0;

    padding: 0;

    list-style: none;

}



.ul1 .li1:hover .ul2 {

    display: inline-block;

    min-width: 200px;

}











/*animation: moveToRight 2s ease-in-out;*/

/*animation-delay: 1000ms;*/

/*}*/



/*@keyframes moveToRight {*/

    /*0% {*/

        /*transform: translateX(0px);*/

    /*}*/

    /*100% {*/

        /*transform: translateX(0px);*/

    /*}*/

/*}*/





.ul2{

    /*display: inline-block;*/

    position: fixed;

    /*margin-top: 3px;*/

    display: none;

    margin-left: -5px;

    width:0px;

    text-align: left;

}



.li2{

    position: relative;

    background-color: var(--theme-color-bgc);

    color: #FFFFFF;

    font-weight: 500;

    padding-top: 2px;

    padding-left: 10px;

    padding-bottom: 2px;

    padding-right: 2px;

    -webkit-transition: all 0.4s cubic-bezier(.5, .24, 0, 1);

    transition: all 0.4s cubic-bezier(.5, .24, 0, 1)

    border-radius: 0px 5px 5px 0px;

    height: 25px;

}















@media only screen and (min-width: 1100px){

    .left1{

        width: 32px;



    }

    .left1 a{

        font-size: 15px !important;

        font-weight: bold;

    }



    .right1{

        width: 84%;



    }

}



@media only screen and (min-width: 1200px){

    .left1{

        width: 35px;



    }

    .left1 a{

        font-size: 15px !important;

        font-weight: bold;

    }



    .right1{

        width: 84%;



    }

}



@media only screen and (min-width: 1300px){

    .left1{

        width: 40px;



    }

    .left1 a{

        font-size: 15px !important;

        font-weight: bold;

    }



    .right1{

        width: 84%;



    }

}





@media only screen and (min-width: 1500px){

    .left1{

        width: 42px;

    }

    .left1.active{

        width: 42px !important;

    }

    .left1 a{

        font-size: 15px !important;

        font-weight: bold;

    }



    .right1{

        width: 84%;



    }

}





@media only screen and (min-width: 1600px){



    .left1.active {

        width: 45px !important;

    }



    .left1{

        width: 45px;

    }

    .left1 a{

        font-size: 20px;

    }

    .right1{

        width: 84%;

    }



    .left1 .ul1 .li1 b:nth-child(1){

        top: 35px !important;

        height: 14px !important;

        width: 100% !important;

    }



    .left1 .ul1 .li1 b:nth-child(1)::before{

        content: '';

        width: 88% !important;

        height: 100% !important;

    }



    .left1 .ul1 .li1 b:nth-child(2){

        top: 85px !important;

        height: 14px !important;

        width: 100% !important;

    }



    .left1 .ul1 .li1 b:nth-child(2)::before{

        content: '';

        width: 88% !important;

        height: 100% !important;

    }





}








@media only screen and (min-width: 1700px){

    .left1.active {

        width: 47px !important;

    }



    .left1{

        width: 46px;

    }



    .left1 a{

        font-size: 20px;

    }



    .right1{

        width: 84%;



    }





    .left1 .ul1 .li1 b:nth-child(1){

        top: 35px !important;

        height: 14px !important;

        width: 100% !important;

    }



    .left1 .ul1 .li1 b:nth-child(1)::before{

        content: '';

        width: 89% !important;

        height: 100% !important;

    }



    .left1 .ul1 .li1 b:nth-child(2){

        top: 85px !important;

        height: 14px !important;

        width: 100% !important;

    }



    .left1 .ul1 .li1 b:nth-child(2)::before{

        content: '';

        width: 89% !important;

        height: 100% !important;

    }



}







@media only screen and (min-width: 1800px){

    .left1.active {

        width: 50px !important;

    }



    .left1{

        width: 49px;

    }



    .left1 a{

        font-size: 20px;

    }



    .right1{

        width: 84%;



    }





    .left1 .ul1 .li1 b:nth-child(1){

        top: 35px !important;

        height: 14px !important;

        width: 100% !important;

    }



    .left1 .ul1 .li1 b:nth-child(1)::before{

        content: '';

        width: 89% !important;

        height: 100% !important;

    }



    .left1 .ul1 .li1 b:nth-child(2){

        top: 85px !important;

        height: 14px !important;

        width: 100% !important;

    }



    .left1 .ul1 .li1 b:nth-child(2)::before{

        content: '';

        width: 89% !important;

        height: 100% !important;

    }



}











.left1 .ul1 .li1 b:nth-child(1){

    position: absolute;

   /* top: 43px;*/

	top: 35px;

    height: 14px;

    width: 100%;

    background-color: #FFFFFF;

    display: none;

}



.left1 .ul1 .li1 b:nth-child(1)::before{

    content: '';

    position: absolute;

    top: 0;

    left: 0;

    width: 87%;

    height: 100%;

    border-bottom-right-radius: 10px;

    background-color: var(--theme-color-bgc);

}





.left1 .ul1 .li1 b:nth-child(2){

    position: absolute;

    /*bottom: 145px;*/

 /*   top: 93px;*/

	top: 85px;

    height: 14px;

    width: 100%;

    background-color: #FFFFFF;

    display: none;

}



.left1 .ul1 .li1 b:nth-child(2)::before{

    content: '';

    position: absolute;

    bottom: 0;

    left: 0;

    width: 87%;

    height: 100%;

    border-top-right-radius: 10px;

    background-color: var(--theme-color-bgc);

}



.left1 .ul1 .active-icon b:nth-child(1),

.left1 .ul1 .active-icon b:nth-child(2){

    display: block;

}







/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*------------------------------ Top menu bar icon design is css Start --------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/



/*Side Menu hide and open css and js start*/

    .sidemenu {
        position: fixed;
        top: 15px;
        /*height: 25px;*/
        /*width: 25px;*/
        height: 30px;
        width: 30px;
        background-color: var(--theme-color-bgc);
        color: #FFFFFF;
        border-radius: 0px 16px 16px 0px;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
		z-index: 1;
    }

.sidemenu.active{

    background-color: #cfcfcf;



}



.sidemenu i{

    position: absolute;

    color: #FFFFFF;

    /*font-size: 24px;*/

    font-size: 20px;

    display: none;

}



.sidemenu i.close1{

    margin-left: 2px;

    color: var(--theme-color-bgc);

}

.sidemenu i.open,

.sidemenu.active i.close1

{

    display: block;

}



.sidemenu i.close1,

.sidemenu.active i.open

{

    display: none;

}





.sidebar.active{

    width: 0%!important;

}

.main_content.active{

    width: 97% !important;

}

.left1.active{

    width: 40px;

    /*width: 36px;*/



}







@media (max-width: 991px){

    .sidemenu{

        height: 0px;

    }



    .notificationblock{

        right: 10px !important;

    }



    .navbar.navbar-absolute{

        width: 40% !important;

    }
	.sr-main-content-heading{
		padding:5px !important;
	}
	
	.sr-main-content-padding{
		padding:0px !important;
	}



}





.circle {

    border-radius: 50%;

    border: 2px var(--theme-color-bgc) solid;

    overflow: hidden

}



.userblock {

    height: 100%;

    width: auto;

    right: 270px !important; 

    position: absolute;

    font-size: 12px;

    font-size: 1.2rem;

}



.notificationblock {

    height: 100%;

    top: 0;

    width: auto;

    background-color: transparent;

    z-index: auto;

    right: 150px;

    position: absolute;

    display: inline-block;

}



.notificationblock a{

/*    font-size: 22px;*/

	font-size:19px  !important ;

    padding: 5px;

    display: block;

    float: left;

    position: relative;

    background-color: whitesmoke;

/*    margin-top: 15%;*/

	margin-top: 20%;

    border-radius: 5px;

    margin-left: 3px;

    margin-right: 3px;

	width: 29px;
    border: 1px solid #ddd;
	overflow: hidden !important;
	height: 34px;

}







.notificationblock i {

/*    font-size: 22px;*/

    /*color: #5e87a8*/

    color: var(--logout-bg-red);

}





.notificationblock .bell-massage i {

/*    font-size: 22px;*/

    color: var(--theme-color-bgc);

}



.notificationblock a:hover i,.notificationblock a:hover {

    color: #ffffff;

    background-color: var(--logout-bg-red);

    border-radius: 5px;

}





.notificationblock .bell-massage:hover i,.notificationblock .bell-massage:hover {

    color: #ffffff;

    background-color: var(--theme-color-bgc);

    border-radius: 5px;

}











/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*------------------------------------------- Table design is css Start --------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

.table1,.thead1,.tbody1{
	font-size:<?=$font_size?> !important;
    /*font-family: 'Poppins', sans-serif !important;*/
    /*font-family: 'Roboto', sans-serif  !important;*/
    text-align: center;
}

.table1 {
    width: 100%;
    overflow:auto;
	zoom: 95% !important;
}


.table1{
    /*display:table;*/
}



.thead1, .tbody tr {

    /*display:table;*/

    width:100%;

    table-layout:fixed;

}



.thead1{

    position: sticky;

    top: 0px;

}

.table1 .btn1{

    line-height: 1 !important;

}





#table_head thead .bgc-info,.thead1 .bgc-info, .tabledesign2 th,

.thead1 .bgc-success, #grp thead tr, table thead tr{

    background-color: var(--table-bg-color) !important;

    color: var(--table-color)!important;
white-space: nowrap;
}



#activities .table1{

    width: 100%;

}



.thead1 tr:hover,#table_head tr:hover,.tbody1 tr:hover,#grp tr:hover,.dataTable tr:hover {

    background-color: var(--table-hover-bg-color) !important;

}

/*datatable even and odd change start*/
table.dataTable.display tbody tr.odd>.sorting_1, table.dataTable.order-column.stripe tbody tr.odd>.sorting_1 {
    background-color: var(--child-odd-color) !important;
    color: var(--child-text-color) !important;
}

table.dataTable.display tbody tr.even>.sorting_1, table.dataTable.order-column.stripe tbody tr.even>.sorting_1{
    background-color: var(--child-even-color)!important;
}

/*datatable even and odd change end*/

tr:nth-child(odd){
    background-color: var(--child-odd-color) !important;
    color: var(--child-text-color) !important;
}

tr:nth-child(even){
    background-color: var(--child-even-color)!important;
    /*color:#3D80DF !important;*/
    /*font-weight: bold !important;*/
}





/*---------- Date type design ----------*/

.ui-datepicker-calendar tr{

    background-color: #f8ffc0 !important;

}



.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight{

    border: 1px solid #5c1074 !important;

    background: #be13c9 !important;

    color: #ffffff !important;

    font-weight: bold !important;

}



/*---------------------- end -----------------*/









@media only screen and (max-width: 991px){



    .table1 {

        display:block;

        max-height:500px;

        max-width: fit-content;

        width: 100%;

        /*overflow-x:auto;*/

        overflow:auto;

    }



    .table1,.thead1,.tbody1{

        font-size: 12px !important;

    }





}







.dataTables_wrapper .dataTables_paginate .paginate_button{
    padding: 0px !important;
}

.dataTables_info{
    font-size: 12px !important;
}

.dataTables_length label, .dataTables_filter label{
	font-size: 12px !important;
    width: 100% !important;
    margin: 0px !important;
    margin-bottom: 5px !important;
}

.dataTables_filter label input::placeholder {
    color: var(--table-bg-color) !important;
	font-size:12px !important;
    opacity: 1; /* Ensures full visibility in some browsers */
}

.dataTables_length label select, .dataTables_filter label input{
	height:30px !important;
}
.paginate_button a{
	height:30px !important;
	font-size: 10px !important;
}

.dataTables_wrapper div{
	padding:0px !important;
}

table ,table tr th, table tr td{
	border-collapse: collapse !important;
}

.dataTables_wrapper table{
	border: 1px solid var(--table-bg-color) !important;
}

.dataTables_wrapper table thead tr{
	background-color: var(--table-bg-color) !important;
    color: var(--table-color) !important;
    white-space: nowrap;
}

/*.dataTables_wrapper table thead tr th,  .dataTables_wrapper table tbody tr td{
	border:0px solid var(--table-bg-color) !important;
	border-top:1px solid var(--table-bg-color) !important;
	border-bottom:1px solid var(--table-bg-color) !important;
}*/

.pagination, .dataTables_info{
    margin: 0px !important;
    margin-top: 5px !important;
}

/*.dataTables_length label select{
    width: 90%!important;
}*/

.page-link{
    background-color: #fcfcfc !important;
    border: 1px solid #dee2e6 !important;
}

.page-item.active .page-link{

    z-index: 1;

    color: #ffffff !important;

    background-color: #2196f3 !important;

    border: 1px solid #2196f3 !important;

}





.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active

{



    color: #000 !important;

    cursor: pointer !important;

    /*color: #666 !important;*/

    /*border: 1px solid #0be3ff !important;*/

    background-color: #0be3ff !important

box-shadow: none;

}



.paginate_button a:hover{

    color: #000!important;

    font-weight: bold!important;

}



.paginate_button a:active{

    color: #000!important;

    font-weight: bold!important;

}













/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*------------------------------------------- Form design is css Start --------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

.re-titel{

    font-weight: bolder;

}





.n-form-titel1{

    background-color: var(--form-info);

    color: var(--form-white);

    padding-top: 5px;

    padding-bottom: 5px;

    border-radius: 5px 5px 0px 0px;

}



.setup-fixed{
	position: sticky !important;
	top: 0 !important;
	z-index: 100 !important;
}


.n-form{
    background-color: var(--white-smoke);
    padding-bottom: 10px;
    border-radius: 5px;
    border: 1px solid rgba(0, 0, 0, 0.125) !important;
}


.n-form1{
    background-color: var(--white-smoke);
    padding-top: 10px;
    padding-bottom: 10px;
    border-radius: 5px;
    border: 1px solid rgba(0, 0, 0, 0.125) !important;
	width: 90% !important;
}



/*dubul form*/

.n-form2{
    background-color: var(--white-smoke);
    padding-top: 10px;
    padding-bottom: 10px;
    border: 0px solid rgba(0, 0, 0, 0.125) !important;
	padding: 0px !important;
}





.n-form-btn-class{

    text-align: center;

    padding-top: 10px;

    padding-bottom: 10px;

}

.req-input::after{

    content: '\*';

    color: var(--req-input-after);

}





.fo-width{

    min-width: 850px !important;

}



.fo-width1{

    min-width: 650px !important;

}



.fo-short{

    min-width: 500px !important;

}





/*.mobile-form1{*/

/*display: none;*/

/*}*/



/*.destop-form1{*/

/*display: block;*/

/*}*/





/*@media screen and (max-width: 600px) {*/

/*.mobile-form1 {*/

/*display: block;*/

/*}*/

/*.destop-form1{*/

/*display: none;*/

/*}*/

/*}*/





.bg-form-titel{

    background-color: var(--form-titel-bg-color);

    padding-top: 20px;

    padding-bottom: 20px;

    box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.16), 0px 0px 0px rgba(0, 0, 0, 0.23) !important;
	border-radius: 5px !important;

}



.bg-form-titel-text{

    font-size: 15px;

    font-weight: bold;

}



.bold{

    font-weight: bold;

}



.form-tabel-bg-color-info{

    background-color: var(--form-tabel-bg-color-info);

    color: var(--white);

}



.bg-titel{

    background-color: var(--bgc-sallmon);

    color: var(--black);

}



.bg-table1{

    background-color: var(--bgc-sallmon1);

    color: var(--black);

}



.menusearch{
 border: 1px solid  var(--theme-color-bgc) !important; 
 border-left: 1px solid var(--theme-color-bgc) !important;
 padding-left: 5px !important;
}
.menusearch::placeholder {
  color: #b5b5b5 !important;  
}
.menusearch-span i{
color: var(--theme-color-bgc) !important; 
}

input[type=search]{
	/*height: 35px !important;*/
    margin: 0px !important;
    width: 100% !important;
    background-color: var(--form-white) !important;
    border: 1px solid #9fb2c5 !important;
    outline: none !important;
    border-radius: 5px !important;
}


input[type=text],input[type=password],select,input[type=date]{
    /*height: 35px !important;*/
    margin: 0px !important;
    width: 100% !important;
    background-color: var(--form-white) !important;
 /*   border: 1px solid #9fb2c5 !important;*/
    border: 1px solid #e5e3e3 !important;
	border-radius: 4px !important;
    outline: none!important;
}



.req{
	border-left:3.5px solid #df5b5b!important;
}

.req1{
	border-left:3.5px solid #3fa31f!important;
}



input[type=submit],input[type=button]{

    min-width: 100px!important;
	/* height: 35px !important;*/
    outline: none!important;

}







input[type=date]{
    margin: 0px !important;
    width: 100% !important;
   /* height: 35px !important;*/
    background-color: var(--form-white) !important;
 /*   border: 1px solid #9fb2c5 !important;*/
    outline: none!important;
}





input[type=file]{

    margin: 0px !important;

    width: 100% !important;

    cursor: pointer  !important;

    outline: none!important;
	padding: 3px !important;
    position: unset !important;
    opacity: unset !important;
	border: 1px solid #ced4da !important;
    border-radius: 4px !important;

}





input[type=number]{

    margin: 0px !important;

    width: 100% !important;

   /* height: 35px !important;*/

    background-color: var(--form-white) !important;

 /*   border: 1px solid #9fb2c5 !important;*/

    outline: none!important;



}



textarea{

    width: 100% !important;

    border: 1px solid #E0E0E0 !important;

    background-color: var(--form-white)!important;

    height: auto !important;

    resize: both!important;

    line-height: 1.428571 !important;

    outline: none!important;
	border: 1px solid #ced4da !important;
    border-radius: 4px !important;

}



input[type=file]:focus,

input[type=text]:focus,

input[type=submit]:focus,

input[type=date]:focus,

input[type=password]:focus,

select:focus, textarea:focus{

    border: 1px solid #dee2e6!important;

}


input[type=date],input[type=password],input[type=text],input[type=file],input[type=number],input[type=search],textarea,select{
	background-image: none !important;
	height: 30px !important;
}


input[type=date],input[type=text],input[type=file],input[type=number],textarea,select{
	border-left: 3.5px solid #3fa31f !important;
}
input[type=date]:required ,input[type=text]:required ,input[type=file]:required ,input[type=number]:required,textarea:required ,select:required{
    border-left: 3.5px solid #df5b5b !important;
}


.vendor_info_img img{

    width: 100%;

    /*width: 120px;152*/

    height:155px;

}



.vendor_label_text{

    font-size: 12px !important;

    font-weight: bold;

}



.custom-combobox-input{

    margin: 0px !important;

    padding: 0px !important;

    width:92%!important;

    background: var(--form-white) !important;

}



.custom-combobox-toggle{

    /*background-color: var(--theme-color-bgc) !important;*/

    background-color: #efefef !important;

}





.font-size12{

    font-size: 12px !important;



}



.font-size13{

    font-size: 13px !important;

}



.font-size14{

    font-size: 14px !important;

}



.font-size15{

    font-size: 15px !important;

}





@media only screen and (max-width: 991px){



    .form-group .justify-content-end{

        justify-content: flex-start!important;

    }



    .fo-width{

        min-width: 100% !important;

    }



    .fo-width1{

        min-width: 100% !important;

    }



    .fo-short{

        min-width: 100% !important;

    }



}



















/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*---------------------------------------- Dashboard design is css Start ------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

.card {

    border: 0 !important;

    margin-bottom: 15px !important;

    margin-top: 15px !important;

    border-radius: 6px !important;

    color: #333333 !important;

    background: #fff !important;

    width: 100% !important;

    box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 20%), 0 1px 5px 0 rgb(0 0 0 / 12%) !important;

}





#localsales7day,#possales7day,#sales7day,#salesReturn,

#inventoryValue,#presentStock,#grnValue,#invoiceValue{

    font-size: 17px;

    font-weight: bold;

}



/*.card-title #salesReturn{*/

/*font-size: 18px !important;*/

/*font-weight: normal !important;*/

/*}*/





#onemounth{

    height: 268px;



}

@media(max-width: 1200px) {

    #onemounth{

        height: 212px;

    }

}



@media(max-width: 1400px) {

    #onemounth{

        height: 212px;

    }

}



@media(max-width: 1500px) {

    #onemounth{

        height: 357px;

    }

}










/*-----------------------------------------------------------------------------------------------------------------------*/

/*------------------------------------------- New Clock design is css Start ---------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/
                        .today-clock div{
							margin: 0px !important;
							padding:0px !important;
						}
						
						.today-clock {
							display: block;
							font-family: 'Share Tech Mono', monospace;
							color: #000000 !important;
							text-align: center;
							right: 10px !important;
							line-height: 1;
							position: absolute;
						}

                        .today-clock #now_time {
                            font-size: 28px;
                            padding: 1px 0;
                            font-weight:800;

                        }

                        .today-clock #today_date{
                            font-size: 9px !important;

                        }

                        .today-clock .text {
                            font-size: 12px;
                            padding: 1px 0;

                        }


                        .today-clock span{
                            display: block;
                        }








/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*------------------------------------------- Clock design is css Start --------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*------------------------------------------- Clock design is css Start --------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------*/

#clock span{

    display: block;

}



#clock{

    display:block;

    /*text-align: center;*/

  /*  padding-right:10px;*/

    line-height: 1;

    justify-content: center;

    right:12px!important;

    width: 150px !important;

    /*width: 121px !important;*/

    position: absolute !important;

    color: var(--theme-color-bgc) !important;

    /*text-shadow: 0 0 10px rgba(10, 175, 230, 1),  0 0 10px rgba(10, 175, 230, 0);*/

}



.time,.date,.text{

    font-family: 'Zen Dots', cursive !important;

}

/*.text{*/

/*font-family: ;*/

/*font-weight: 700;*/

/*}*/

.text,.date{

    font-size: 8px !important;

    color: #3e4a5a;

}



.date{

    overflow: hidden!important;

    margin-top: 2px !important;

    margin-bottom: 2px !important;

    margin-left: 1px;

}



.time{

	overflow: hidden!important;

    position: absolute !important;

    font-size: 13px !important;

    font-weight: 800;

    /* margin-left: 2px; */

    margin-left: 28px;

    margin-top: 2px;

}



.text{

    overflow: hidden!important;

    margin-top: 22px !important;

}





@media only screen and (max-width: 700px) {

    #clock, .today-clock /*.navbar-toggler*/{

        display: none!important;

    }


}





@media only screen and (max-width: 820px) {

    #clock{

        display: none!important;

    }

}











@media only screen and (max-width: 991px) {

    #clock{

        display: none!important;

    }

}































/* Styles for custom combobox toggle */
.custom-combobox-toggle {
    position: relative;
    display: inline-block;
    cursor: pointer;
    background-color: #d0dcec !important;
    width: 25px;
    border: 1px solid #7b7979;
}

/* Styles for the before element */
.custom-combobox-toggle::before {
      content: "\f0d7";
  font-family: 'Font Awesome\ 5 Free';
    position: absolute;
    left: 5px; /* Adjust as needed */
    color: blue; /* Adjust color as needed */
}

.ui-datepicker .ui-datepicker-title{
    display: flex !important;
}
.ui-datepicker-month{
    margin-right: 5px !important;
}
.ui-datepicker-year{
    margin-left: 5px !important;
}

.nav-pills .nav-link.active, .nav-pills .show>.nav-link{
color: #fff ! IMPORTANT;
    background-color: var(--theme-color-bgc);
}

</style>