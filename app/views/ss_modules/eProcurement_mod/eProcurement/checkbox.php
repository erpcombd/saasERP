
<hr>
<table class="w-100" >
 <thead>
  <tr>
    <th scope="col"><?=$unique_no?></th>
    <th scope="col"><button type="button" name="more_option" class="btn1 btn1-bg-cancel" onClick="select_html('Checkbox','remove');">Remove</button></th>
  </tr>
 </thead>
 
 <tbody>
   <tr>
     <td>Label or Question</td>
     <td><input type="text" name="lebel_<?=$unique_no?>" id="dropdown_name"/></td>
   </tr>
   
   <tr>
     <td>Required</td>
     <td><input type="checkbox" name="is_required_<?=$unique_no?>" id="is_required"/></td>
   </tr>
   
   <tr>
     <td>Hint or Additional Text</td>
     <td><textarea name="hint_<?=$unique_no?>" id="hint_<?=$unique_no?>"></textarea></td>
   </tr>
   
   
   <tr>
     <td>Option-1</td>
     <td><input type="text" name="option_1_<?=$unique_no?>" id="option_1"/></td>
   </tr>
   
   <tr>
     <td>Option-2</td>
     <td><input type="text" name="option_2_<?=$unique_no?>" id="option_2"/></td>
   </tr>
   
   
   
 </tbody>
</table>

<table class="w-100"   id="optionsTable_<?=$unique_no?>">
  <tr>
     <td><input type="hidden" name="option_count_<?=$unique_no?>" id="option_count_<?=$unique_no?>" value="2"></td>
     <td><button type="button" name="more_option" class="btn1 btn1-bg-warning" onclick="addOption('checkbox',<?=$i?>)">Add Option +</button></td>
   </tr>
</table>
<hr>