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
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Dealer</th>
                            <th>Bill No.</th>
                            <th>Products</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($warranties)): ?>
                            <?php foreach ($warranties as $warranty): ?>
                                <tr>
                                    <td><?php echo html_escape($warranty['id']); ?></td>
                                    <td><?php echo html_escape($warranty['customer_name']); ?></td>
                                    <td><?php echo html_escape($warranty['customer_contact']); ?></td>
                                    <td><?php echo html_escape($warranty['customer_email']); ?></td>
                                    <td><?php echo html_escape($warranty['dealer_name']); ?></td>
                                    <td><?php echo html_escape($warranty['bill_number']); ?></td>
                                    <td>
                                        <?php if (!empty($warranty['products'])): ?>
                                            <ul>
                                                <?php foreach ($warranty['products'] as $product): ?>
                                                    <li><?php echo html_escape($product['product_name']); ?> (<?php echo html_escape($product['product_size']); ?>)</li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            No products listed.
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d-m-Y H:i', strtotime($warranty['registration_date'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No warranties found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
