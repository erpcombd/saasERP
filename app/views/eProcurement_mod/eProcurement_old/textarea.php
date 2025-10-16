
<hr>
<table class="w-100"  >
 <thead>
  <tr>
    <th scope="col"><?=$unique_no?></th>
    <th scope="col"><button type="button" name="more_option" class="btn1 btn1-bg-cancel" onClick="select_html('Text Area','remove');">Remove</button></th>
  </tr>
 </thead>
 
 <tbody>
   <tr>
     <td>Label or Question</td>
     <td><input type="text" name="lebel_<?=$unique_no?>" id="input_field_name"/></td>
   </tr>
   
   <tr>
     <td>Required</td>
     <td><input type="checkbox" name="is_required_<?=$unique_no?>" id="input_field_is_required"/></td>
   </tr>
   
   <tr>
     <td>Hint or Additional Text</td>
     <td><textarea name="hint_<?=$unique_no?>" id="input_field_hint"></textarea></td>
   </tr>
  
   
 </tbody>
</table>
<hr>