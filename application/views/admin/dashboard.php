<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('admin/logout'); ?>">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-5">Welcome to the Admin Dashboard</h1>
                <p>Here you will see the list of registered warranties.</p>

                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Customer Contact</th>
                            <th>Dealer Name</th>
                            <th>Bill Number</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($warranties)): ?>
                            <?php foreach ($warranties as $warranty): ?>
                                <tr>
                                    <td><?php echo $warranty['id']; ?></td>
                                    <td><?php echo $warranty['customer_name']; ?></td>
                                    <td><?php echo $warranty['customer_contact']; ?></td>
                                    <td><?php echo $warranty['dealer_name']; ?></td>
                                    <td><?php echo $warranty['bill_number']; ?></td>
                                    <td><?php echo $warranty['registration_date']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No warranties found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
