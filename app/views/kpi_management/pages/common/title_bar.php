
<table class="oe_view_manager_header">
          <colgroup>
		  <col width="20%">
          <col width="35%">
          <col width="15%">
          <col width="30%">
          </colgroup><tbody>
		  
		 
		 
		 <td colspan="2">
			
			

			<table width="70%" border="0" align="left" cellpadding="0" cellspacing="0" style="height:25px; float:left" class="modal-content">

            
<? if($_SESSION['employee_selected']>0){?>
              <tr>
			  
			  
			  
		  
			  

                <td width="80" align="center" valign="middle"><strong style="color:#FFF; font-size:16px;"><em><img src="../../pic/staff/<?=$_SESSION['employee_selected']?>.jpg" style="border-radius: 100%; width: 70px; margin:0px; margin-top: 22px; margin-left:2px;" class="img-circle profile_img modal-content" width="120" height="70" hspace="5" vspace="0" />
				
				
			
				
				
				</em></strong></td>

                <td width="400" align="left" style="color:#000; font-family:Tahoma; background: #17a2b8; color: white;" >

				

                 <?php

				$sql =  @mysql_query("select PBI_NAME, PBI_DEPARTMENT, PBI_DESIGNATION,EMP_ID from personnel_basic_info where PBI_ID = ".$_SESSION['employee_selected']."");

				  $row = @mysql_fetch_object($sql);

				  if($row->PBI_NAME!='') echo "<span style='font-size:24px;'>".' '.$row->PBI_NAME."(".$row->EMP_ID.")<br/></span>";

				   echo "<span style='font-size:16px; margin-top:10px;'>".find_a_field('designation','DESG_DESC','DESG_ID='.$row->PBI_DESIGNATION)."<br/></span><span style='height:10px;'></span>";

				  echo "<span style='font-size:18px; margin-top:10px;'>".find_a_field('department','DEPT_DESC','DEPT_ID='.$row->PBI_DEPARTMENT)."</span>";

				 

				?>

                </td>

              </tr>  
			  <? }?>
			  



            </table>

			                

</td>
		 
		 
		 
            <td colspan="2">
               <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group top_search" style="margin-left: 55%;">
                  <div class="input-group">
            <input type="text" name="employee_selected2" style="border-radius: 0px; border: 1px solid #17a2b8; " id="employee_selected2" class="form-control" placeholder="Search ID..." value="<?=(isset($_SESSION['employee_selected2']))?sprintf("%'04d", $_SESSION['employee_selected2']):'';?>"/>
                    <span class="input-group-btn">
					   <button class="btn btn-danger" id="button" style="height:34px; border-radius: 0px; background: #17a2b8; color: white; " value="Find"  type="submit">Go!</button>
					
                     
                    </span>
                  </div>
                </div>
              </div>
                
            </td>
			
			
			
			
			

            

            </tr>

  </tbody>
			
			</table>









