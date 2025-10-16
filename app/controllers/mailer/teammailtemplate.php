<?php   
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once(SERVER_CORE.'mailer/phpmail.php');

?>
<div style="max-width: 1000px; margin-right: auto; margin-left: auto; padding: 24px; font-family: 'Source Sans Pro', sans-serif;">
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #EEEEEE;">
        <thead style="background: #000; color: white;">
            <tr>
                <th style="padding: 12px;">Name</th>
                <th style="padding: 12px;">Wins</th>
                <th style="padding: 12px;">Draws</th>
                <th style="padding: 12px;">Losses</th>
                <th style="padding: 12px;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background: #EEEEEE;">
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">Tom</td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">2</td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">0</td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">1</td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">5</td>
            </tr>
            <tr>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">Dick</td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">1</td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">1</td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">2</td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">3</td>
            </tr>
            <tr style="background: #EEEEEE;">
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">Harry</td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">0</td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">2</td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">2</td>
                <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;">2</td>
            </tr>
        </tbody>
    </table>
</div>
