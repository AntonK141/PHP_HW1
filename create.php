<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create User</title>
    <link rel="stylesheet" href="/HW1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Create User</h2>
    <form action="submit.php" method="post" enctype="multipart/form-data" class="mt-3">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" required>
            <img id="photoPreview" src="#" alt="Photo Preview" style="margin-top: 10px; display: none; width: 100%;">
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>
</div>
<script src="/HW1/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('photo').onchange = function () {
        const [file] = this.files;
        if (file) {
            document.getElementById('photoPreview').src = URL.createObjectURL(file);
            document.getElementById('photoPreview').style.display = 'block';
        }
    };
</script>
</body>
</html>


