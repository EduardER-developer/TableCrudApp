<?php

if (isset($_POST['id']) && !empty($_POST['id'])) {
    require_once 'config.php';

    $sql = 'DELETE FROM employees WHERE id=?';

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('i', $param_id);
        $param_id = trim($_POST['id']);

        if ($stmt->execute()) {
            header('location: index.php');
            exit();
        } else {
            echo 'Error';
        }
    }

    $stmt->close();
    $mysqli->close();
} else {
    if (empty(trim($_GET['id']))) {
        header('location: error.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Record</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete record</h2>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                        <div class="alert alert-danger">
                            <input class="input" type="hidden" name="id" value="<?= trim($_GET['id']) ?>" />
                            <p>Are you sure you want to delete this employee record?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>

</html>