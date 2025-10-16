
<hr>
<table class="w-100" >
 <thead>
  <tr>
    <th scope="col"><span style="text-decoration:underline;">Dropdown-<?=++$s?></span></th>
  </tr>
 </thead>
 
 <tbody>
   <tr>
     <td><span style="font-size:15px; font-weight:bold;"><?=$lebel?></span>
	 <select name="drowdown_show" id="drowdown_show">
	   <option><?=$option_1?></option>
	   <option><?=$option_2?></option>
	   <? 
   
   $option_sql = 'select * from rfq_form_element_options where rfq_no="'.$_SESSION['rfq_no'].'" and form_no="'.$form_no.'" and form_detail_id="'.$form_details_id.'"';
   $option_qry = db_query($option_sql);
   $k=2;
   while($option_data=mysqli_fetch_object($option_qry)){
   extract((array) $option_data);
   ?>
   <option><?=$options?></option>
   <?
   }
   ?>
	 </select>
	 </td>
   </tr>
   
   
   
 </tbody>
</table>
<hr>