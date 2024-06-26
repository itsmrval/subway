<table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <th scope="row"><?php echo htmlspecialchars($user['id']); ?></th>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['firstName']); ?></td>
                    <td><?php echo htmlspecialchars($user['lastName']); ?></td>
                    <td>
                        <div class="d-flex">
                            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editUserModal"
                                    data-id="<?php echo htmlspecialchars($user['id']); ?>"
                                    data-email="<?php echo htmlspecialchars($user['email']); ?>"
                                    data-firstname="<?php echo htmlspecialchars($user['firstName']); ?>"
                                    data-lastname="<?php echo htmlspecialchars($user['lastName']); ?>"
                                    data-isadmin="<?php echo htmlspecialchars($user['is_admin']); ?>"
                                    >
                                Edit
                            </button>
                            <form method="POST" action="">
                                <input type="hidden" name="userId" value="<?php echo htmlspecialchars($user['id']); ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>