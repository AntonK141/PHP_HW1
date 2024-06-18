<?php
$conn = new mysqli('localhost', 'root', '', 'hw1_user_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$message = isset($_GET['message']) ? $_GET['message'] : '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User List</title>
    <link rel="stylesheet" href="/HW1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/HW1/css/styles.css">
</head>
<body>
<div class="container mt-5">
    <h2>User List</h2>
    <div class="button-container mb-3 text-left">
        <a href="create.php" class="btn btn-primary">Create New User</a>
    </div>
    <?php if ($message): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <table class="table table-hover table-striped table-bordered">
        <thead class="table-dark">
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th class="photo-cell">Photo</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                                <td class='photo-cell'><img src='{$row['photo']}' alt='User Photo'></td>
                                <td>
                                    <button class='btn btn-warning btn-edit' data-id='{$row['id']}'>Edit</button>
                                    <button class='btn btn-danger btn-delete' data-id='{$row['id']}'>Delete</button>
                                </td>
                              </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No users found</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="id">
                    <div class="mb-3">
                        <label for="editUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editUsername" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhoto" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="editPhoto" name="photo">
                        <img id="editPhotoPreview" src="" alt="Photo Preview" style="margin-top: 10px; width: 100%;">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="/HW1/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        let userIdToDelete;

        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'get_user.php',
                type: 'GET',
                data: { id: id },
                success: function(data) {
                    var user = JSON.parse(data);
                    $('#editUserId').val(user.id);
                    $('#editUsername').val(user.username);
                    $('#editEmail').val(user.email);
                    $('#editPhotoPreview').attr('src', user.photo);
                    $('#editUserModal').modal('show');
                }
            });
        });

        $('#editPhoto').on('change', function() {
            const [file] = this.files;
            if (file) {
                $('#editPhotoPreview').attr('src', URL.createObjectURL(file));
            }
        });

        $('#editUserForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: 'edit_user.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editUserModal').modal('hide');
                    window.location.href = 'index.php?message=User updated successfully';
                }
            });
        });

        $('.btn-delete').on('click', function() {
            userIdToDelete = $(this).data('id');
            $('#deleteUserModal').modal('show');
        });

        $('#confirmDeleteButton').on('click', function() {
            $.ajax({
                url: 'delete_user.php',
                type: 'POST',
                data: { id: userIdToDelete },
                success: function(response) {
                    $('#deleteUserModal').modal('hide');
                    window.location.href = 'index.php?message=User deleted successfully';
                }
            });
        });
    });
</script>
</body>
</html>
<?php
$conn->close();
?>








