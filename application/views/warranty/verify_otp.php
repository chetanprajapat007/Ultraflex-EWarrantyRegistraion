<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header">
                        Enter OTP
                    </div>
                    <div class="card-body">
                        <p>An OTP has been sent to your contact number. Please enter it below to complete your warranty registration.</p>
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>
                        <form action="<?php echo site_url('warranty/process_otp'); ?>" method="post">
                            <div class="form-group">
                                <label for="otp">OTP</label>
                                <input type="text" name="otp" id="otp" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Verify OTP</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
