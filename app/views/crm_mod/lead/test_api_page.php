<?

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
?>

<h2>Upload Image Form</h2>
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="hidden" name="master_id" value="1"> <!-- Adjust value as needed -->
        <input type="hidden" name="tr_from" value="sample_value"> <!-- Adjust value as needed -->
        <input type="hidden" name="entry_by" value="sample_user"> <!-- Adjust value as needed -->
        <input type="file" name="image[]" id="imageInput" accept="image/*" multiple>
        <button type="submit">Upload Images</button>
    </form>

    <div id="response"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#uploadForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                
                $.ajax({
                    url: 'https://dev.clouderp.com.bd/eProcurement_mod/api/new_api_auto_file_upload.php',
                    type: 'POST',
                    data: formData,
                    success: function(responseData) {
                        $('#response').text(JSON.stringify(responseData, null, 2));
                    },
                    error: function(xhr, status, error) {
                        console.error('Error uploading image:', error);
                        $('#response').text('Error uploading image. Please try again.');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });
    </script>