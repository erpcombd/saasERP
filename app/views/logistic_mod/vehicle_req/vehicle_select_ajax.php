<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle category field
    if (isset($_POST['category']) && !empty($_POST['category'])) {
        $category = htmlspecialchars($_POST['category']);

        if ($category == 1) {  ?>
             <div class="mb-3">
                    <label class="form-label">Extra Guest:</label>
                    <input type="number" name="extra_guest" class="form-control">
                  </div>
    <?    } elseif ($category == 2) { ?>
             <div class="mb-3">
                    <label class="form-label">CFT / KG</label>
                    <select class="form-select" name="qty_type">
                        <option>Nothing selected</option>
                        <option value="1">CFT</option>
                        <option value="2">KG</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="qty" class="form-control">
                  </div>
<?                  
        }
    }
// Handle vehicle_to field
              
    
}
?>
