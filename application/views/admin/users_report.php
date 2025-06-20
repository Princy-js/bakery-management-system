<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Users Report</h4>
                    </div>
                    <div class="card-body">
                        <!-- Form for filtering -->
                        <form method="get" action="<?= base_url('admin/generate_users_report'); ?>">
                            
                            <button type="submit" class="btn btn-purple mt-3">Download Report</button>
                        </form>

                        <!-- Table to display users -->
                        <div class="table-responsive mt-4">
                            <table class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)) { ?>
                                        <?php $i = 0; foreach ($users as $user) { $i++; ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $user['name']; ?></td>
                                                <td><?= $user['email']; ?></td>
                                                <td><?= $user['phone']; ?></td>
                                                <td><?= $user['address']; ?></td>
                                                <td>
                                                    <?php if ($user['status'] == 1): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr><td colspan="6">No users found.</td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
