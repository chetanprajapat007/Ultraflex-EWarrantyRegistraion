<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Warranty Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">E-Warranty Registration Form</h1>
        <form action="<?php echo site_url('warranty/register'); ?>" method="post">
            <div class="form-group">
                <label for="customer_name">Customer Name*</label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="customer_contact">Customer Contact No*</label>
                <input type="text" name="customer_contact" id="customer_contact" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="customer_email">Customer Email</label>
                <input type="email" name="customer_email" id="customer_email" class="form-control">
            </div>
            <div class="form-group">
                <label for="dealer_name">Dealer Name*</label>
                <input type="text" name="dealer_name" id="dealer_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="bill_number">Bill Number*</label>
                <input type="text" name="bill_number" id="bill_number" class="form-control" required>
            </div>

            <hr>

            <h3>Product Details</h3>
            <div id="product-list">
                <!-- Product entries will be added here -->
            </div>
            <button type="button" id="add-product" class="btn btn-secondary">Add Product</button>
            <!-- QR Code functionality to be added later -->

            <hr>

            <button type="submit" class="btn btn-primary">Register Warranty</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#add-product').click(function() {
                $('#product-list').append(`
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Product Name</label>
                            <input type="text" name="product_name[]" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Size</label>
                            <input type="text" name="product_size[]" class="form-control">
                        </div>
                    </div>
                `);
            });
        });
    </script>
</body>
</html>
