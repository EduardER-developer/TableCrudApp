<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'config.php';

$name = $address = $salary = '';
$name_err = $address_err = $salary_err = '';

if (isset($_POST['id']) && !empty(trim($_POST['id']))) {
    $id = $_POST['id'];

    $input_name = trim($_POST['name']);

    // validate name
    if (empty($input_name)) {
        $name_err = 'Please enter a valid name';
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = 'Please enter a valid name';
    } else {
        $name = $input_name;
    }
    // validate address
    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Please enter a valid address";
    } else {
        $address = $input_address;
    }

    //validate salary
    $input_salary = trim($_POST["salary"]);
    if (empty($input_salary)) {
        $salary_err = "Please enter a valid salary";
    } else {
        $salary = $input_salary;
    }

    if (empty($name_err) && empty($salary_err) && empty($address_err)) {
        $sql = 'UPDATE employees SET name=?, address=?, salary=? WHERE id=?';

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sssi", $param_name, $param_address, $param_salary, $param_id);

            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_id = $id;

            if ($stmt->execute()) {
                header('location: index.php');
                exit();
            } else {
                echo 'Error';
            }
        }
        $stmt->close();
    }
    $mysqli->close();
} else {
    if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
        $id = trim($_GET['id']);
        $sql = 'SELECT * FROM employees WHERE id = ?';

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $param_id);

            $param_id = $id;

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    $name = $row['name'];
                    $address = $row['address'];
                    $salary = $row['salary'];
                } else {
                    header('location: error.php');
                    exit();
                }
            } else {
                echo 'Error';
            }
        }

        $stmt->close();
        $mysqli->close();
    } else {
        header('location: error.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?= htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?= (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?= $name; ?>">
                            <span class="invalid-feedback"><?= $name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?= (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?= $address; ?></textarea>
                            <span class="invalid-feedback"><?= $address_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?= (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?= $salary; ?>">
                            <span class="invalid-feedback"><?= $salary_err; ?></span>
                        </div>
                        <input type="hidden" name="id" value="<?= $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>