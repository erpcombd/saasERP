<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<!--deshboard material ui start !this is important for responsive but we hide this for other major problem-->
<link href="../../../../../public/dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
<!--deshboard material ui end--> 

<?php
$allCss=find_all_field('config_template','','status=1');
$font_family_api = "$allCss->font_family_api";
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="<?=$font_family_api?>" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Zen+Dots&display=swap" rel="stylesheet">

<link href="../../../../public/assets/css/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet"/>
<!--<link href="<?=SERVER_CDN?>bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>-->
<link href="../../../../public/assets/css/select2.min.css" type="text/css" rel="stylesheet"/>

<?php
require_once "../../../../public/assets/css/theme_responsib_new_custom.php";
?>

<link href="../../../../public/assets/css/style.css" type="text/css" rel="stylesheet"/>
<link href="../../../../public/assets/css/menu.css" type="text/css" rel="stylesheet"/>
<link href="../../../../public/assets/css/table.css" type="text/css" rel="stylesheet"/>
<link href="../../../../public/assets/css/input.css" type="text/css" rel="stylesheet"/>
<link href="../../../../public/assets/css/form.css" type="text/css" rel="stylesheet"/>

<link href="../../../../public/assets/fancy/jquery.fancybox.min.css" type="text/css" rel="stylesheet"/>
<link href="../../../../public/assets/css/pagination.css" rel="stylesheet" type="text/css" />

<link href="../../../../public/assets/css/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../public/assets/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<link href="../../../../public/assets/css/datatables.min.css" rel="stylesheet" type="text/css" />
<link href = "../../../../public/GBox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>

<style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }

  .custom-combobox-toggle {
    position: absolute;
    height: calc(1.5em + .75rem + 1.5px);
    padding: .1rem .2rem;
    font-size: 1rem;
  }
  
  .form-check, label{
  	color: black !important;
  }

  .custom-combobox-input {
    margin: 0;
    padding: .1rem .2rem;
    font-size: 1rem;
    height: calc(1.5em + .75rem + 1.5px);
    margin-left: .25rem;
    width:95%;
  }

</style>

<style>
.page_title{
    border: solid .1rem #dfdfdf;
    border-radius: 5px;
    margin-bottom: 10px;
    background: transparent;
    border: none;
    float: left;
    top: 3px;
    margin-bottom: 15px;
}

.breadcrumb {
    background-color: transparent;
    border: none;
    padding: 9px 13px;
    margin-bottom: 0px;
    padding-left: 0;
    padding-bottom: 0;
	}

.ol {
    list-style-position: outside;
    padding-left: 22px;
}

ol, ul {
    margin-top: 0;
    margin-bottom: 10px;
}

* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

ol {
    display: block;
    list-style-type: decimal;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 40px;
}
</style>

<?
if ($_SESSION['mod']=='41') {
  require_once "../../../../public/assets/datatable_esourcing/datatable3_old.php";
  require_once "../../../../public/assets/datatable_esourcing/datatable3.php";
  require_once "../../../../public/assets/datatable_esourcing/datatable2.php";
  require_once "../../../../public/assets/datatable_esourcing/datatable_report_view.php";
  require_once "../../../../public/assets/datatable_esourcing/datatable.php";
}
?>
