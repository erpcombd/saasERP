<?php
require_once "../../../controllers/routing/layout.top.php";


?>

<script type="text/javascript" src="../../../../public/assets/js/select2.min.js"></script>
<style>
  .select2-container .select2-selection--multiple .select2-selection__rendered {
    display: flex;
    list-style: none;
    padding: 0;
}
.select2-selection__choice{
  display: flex;
  margin: 4px;
  flex-direction: row-reverse;
}
[type=button]:not(:disabled), [type=reset]:not(:disabled), [type=submit]:not(:disabled), button:not(:disabled) {
    cursor: pointer;
    border:none;
}
</style>

<select class="form-select" id="multiple-select-field" data-placeholder="Choose anything" multiple>
    <option>Christmas Island</option>
    <option>South Sudan</option>
    <option>Jamaica</option>
    <option>Kenya</option>
    <option>French Guiana</option>
    <option>Mayotta</option>
    <option>Liechtenstein</option>
    <option>Denmark</option>
    <option>Eritrea</option>
    <option>Gibraltar</option>
    <option>Saint Helena, Ascension and Tristan da Cunha</option>
    <option>Haiti</option>
    <option>Namibia</option>
    <option>South Georgia and the South Sandwich Islands</option>
    <option>Vietnam</option>
    <option>Yemen</option>
    <option>Philippines</option>
    <option>Benin</option>
    <option>Czech Republic</option>
    <option>Russia</option>
</select>
<script>
  $( '#multiple-select-field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    closeOnSelect: false,
} );
</script>

<?
require_once "../../../controllers/routing/layout.bottom.php";
?>