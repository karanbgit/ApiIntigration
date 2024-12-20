
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Api View Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-3">Example Table</h2>
        <a href="<?php echo base_url('Intigration/AddData'); ?>" class="btn btn-primary mb-3">Add User</a>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Sr. No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- The array is empty then go outside the foreach loop  -->
                <?php if (!empty($users)) { ?>

                    <!-- Start the for each Loop -->
                    <?php $count = '1';
                    foreach ($users as $user) { ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $user['name'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $user['contact'] ?></td>
                            <td><img class="image-fluid" src="<?php echo 'http://localhost/ApiCreation/uploads/' . $user['image'] ?>" alt="Image"
                                style="width: 80px; height: 80px;"></td>
                            <td>
                                <a href="<?php echo base_url('Intigration/EditUser/' . $user['id']); ?>"
                                    class="btn btn-primary">Edit</a>
                                <a href="<?php echo base_url('Intigration/DeleteUser/' . $user['id']); ?>"
                                    class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <!-- End foreach -->
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php if ($this->session->flashdata('success')) { ?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php } ?>

    <!-- Bootstrap JS (Optional for advanced features like modals, dropdowns, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>