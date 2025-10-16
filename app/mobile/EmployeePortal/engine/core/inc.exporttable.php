
<div align="center" id="pr">

    <button id="btnExport" type="button" onclick="fnExcelReport();" style=" width: 55px; cursor: pointer;">
		<img src="../../../../public/assets/images/xls_hover.png" width="40" height="40">
	</button>
    <button name="button" type="button" onclick="hide(); window.print();" value="Print" style=" width: 55px; cursor: pointer;">
		<img src="../../../../public/assets/images/print.png" width="40" height="40">
	</button>




    <iframe id="txtArea1" style="display:none"></iframe>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js" ></script>

	
	
	
<script>

    function html_table_to_excel(type)
    {
        var data = document.getElementById('ExportTable');

        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

        XLSX.writeFile(file, 'file.' + type);
    }

    const export_button = document.getElementById('btnExport');

    export_button.addEventListener('click', () =>  {
        html_table_to_excel('xlsx');
    });

</script>

</div>