
<hr>
<table class="w-100" >
 <thead>
  <tr>
    <th scope="col"><span style="text-decoration:underline;">Checkbox-<?=++$n?></span></th>
    <th scope="col"></th>
  </tr>
 </thead>
 
 <tbody>
  <tr>
     <td><span style="font-size:15px; font-weight:bold;"><?=$lebel?></span></td>
   </tr>
   <tr>
    
     <td><input type="checkbox" name="checkbox_show" id="checkbox_show" />&nbsp;<?=$option_1?></td>
   </tr>
   <tr>
     
     <td><input type="checkbox" name="checkbox_show" id="checkbox_show" />&nbsp;<?=$option_2?></td>
   </tr>
    
   <? 
   
   $option_sql = 'select * from rfq_form_element_options where rfq_no="'.$_SESSION['rfq_no'].'" and form_no="'.$form_no.'" and form_detail_id="'.$form_details_id.'"';
   $option_qry = db_query($option_sql);
   while($option_data=mysqli_fetch_object($option_qry)){
   extract((array) $option_data);
   ?>
   <tr>
     
     <td><input type="checkbox" name="checkbox_show" id="checkbox_show"/>&nbsp;<?=$options?></td>
   </tr>
   <? } ?>
   
   
 </tbody>
</table>
<hr>