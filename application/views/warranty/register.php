<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Warranty Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #qr-reader {
            width: 500px;
        }
        #qr-reader-results {
            display: none;
        }
    </style>
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
            <button type="button" id="add-product" class="btn btn-info">Add Product Manually</button>
            <button type="button" id="scan-qr" class="btn btn-success">Scan Product QR</button>

            <div id="qr-reader" class="mt-3" style="display: none;"></div>

            <hr>

            <button type="submit" class="btn btn-primary">Register Warranty</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to add a new product row
            function addProductRow(name = '', size = '') {
                $('#product-list').append(`
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Product Name</label>
                            <input type="text" name="product_name[]" class="form-control" value="${name}">
                        </div>
                        <div class="form-group col-md-5">
                            <label>Product Size</label>
                            <input type="text" name="product_size[]" class="form-control" value="${size}">
                        </div>
                        <div class="form-group col-md-1">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-block remove-product">X</button>
                        </div>
                    </div>
                `);
            }

            // Add product manually
            $('#add-product').click(function() {
                addProductRow();
            });

            // Remove product row
            $('#product-list').on('click', '.remove-product', function() {
                $(this).closest('.form-row').remove();
            });


            // QR Code Scanner
            const qrReader = new Html5Qrcode("qr-reader");

            $('#scan-qr').click(function() {
                $('#qr-reader').show();
                const config = { fps: 10, qrbox: { width: 250, height: 250 } };
                qrReader.start({ facingMode: "environment" }, config, onScanSuccess, onScanError);
            });

            function onScanSuccess(decodedText, decodedResult) {
                // handle the scanned code as you like, for example:
                console.log(`Code matched = ${decodedText}`, decodedResult);

                // Assuming QR code format is "ProductName,ProductSize"
                const parts = decodedText.split(',');
                const productName = parts[0] ? parts[0].trim() : '';
                const productSize = parts[1] ? parts[1].trim() : '';

                addProductRow(productName, productSize);

                // Stop scanning and hide the reader
                qrReader.stop().then(() => {
                    $('#qr-reader').hide();
                }).catch(err => console.error("Failed to stop QR scanner", err));

                alert(`Scanned: ${productName}`);
            }

            function onScanError(errorMessage) {
                // handle scan error, usually ignore it.
                // console.warn(`Code scan error = ${errorMessage}`);
            }
        });
    </script>
</body>
</html>
