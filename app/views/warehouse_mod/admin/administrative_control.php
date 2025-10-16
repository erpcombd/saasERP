<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Project Info';

//echo $proj_id;
?>

<table  style="width:100%;margin:0 auto; border:0; border-spacing:0; padding:0;">
  <tr>
    <td><div class="box2">
      <table style="width:42%; margin:0 auto; border:0; border-spacing:0; padding:0; text-align:center;">
        <tr>
          <td>User ID  :</td>
          <td><input  name="code" type="text" value=""/></td>
        </tr>
        <tr>
          <td>User Name : </td>
          <td><input  name="name" type="text" value=""/></td>
        </tr>
        <tr>
          <td>Password : </td>
          <td><input  name="brief" type="text" value=""/></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div class="box4">
      <table  style="width:100%;margin:0 auto; border:0; border-spacing:0; padding:0;">
        <tr>
          <td  style="vertical-align:top;"><table  style="width:100%;margin:0 auto; border:0; border-spacing:0; padding:0;">
            <tr>
              <td class="title1"><div  style="text-align:left;">Module Name </div></td>
            </tr>
            <tr>
              <td><div class="box1">
                <div class="tabledesign2">
                  <table  style="width:100%;margin:0 auto; border:0; border-spacing:0; padding:0;">
                    <tr>
                      <th>Cbomod</th>
                    </tr>
                    <tr class="alt">
                      <td>01. Admin Controm </td>
                    </tr>
                    <tr>
                      <td>02. Setup Option 	
                    </tr>
                    <tr class="alt">
                      <td>03.</td>
                    </tr>
                    <tr>
                      <td>04.	 
                    </tr>
                    <tr class="alt">
                      <td>05.</td>
                    </tr>
                  </table>
                </div>
              </div></td>
            </tr>
            <tr>
              <td><div class="box3">
                <table style="width:100%;margin:0 auto; border:0; border-spacing:0; padding:0;">
                  <tr>
                    <td><input name="submit" type="submit" class="btn1" value="Save" style="border: 1px solid #000000;" /></td>
                    <td><input style="border: 1px solid #000000;" name="submit2" type="submit" class="btn1" value="Update" /></td>
                  </tr>
                  <tr>
                    <td><input style="border: 1px solid #000000;" name="submit22" type="submit" class="btn1" value="Delete" /></td>
                    <td><input style="border: 1px solid #000000;" name="submit23" type="submit" class="btn1" value="Browse" /></td>
                  </tr>
                  <tr>
                    <td><input style="border: 1px solid #000000;" name="submit22" type="submit" class="btn1" value="Exit" /></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div></td>
            </tr>
          </table></td>
          <td><table style="width:100%;margin:0 auto; border:0; border-spacing:0; padding:0;">
            <tr>
              <td class="title1"><div align="left">Module Option</div></td>
            </tr>
            <tr>
              <td><div class="tabledesign1">
                <table style="width:100%;margin:0 auto; border:0; border-spacing:0; padding:0;">
                  <tr>
                    <th>MID</th>
                    <th>SID</th>
                    <th>Function Name </th>
                    <th>Allow</th>
                  </tr>
                  <tr class="alt">
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr>
                    <td>Demo text
                              </th>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr class="alt">
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr>
                    <td>Demo text
                              </th>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr class="alt">
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr>
                    <td>Demo text
                              </th>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr class="alt">
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr>
                    <td>Demo text
                              </th>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr class="alt">
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr>
                    <td>Demo text
                              </th>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr class="alt">
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr>
                    <td>Demo text
                              </th>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                </table>
              </div></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>