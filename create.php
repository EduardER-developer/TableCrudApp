<?php

require_once "config.php";

$name = $address = $salary = '';
$name_err = $address_err = $salary_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //validate $name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter name";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a name";
    } else {
        $name = $input_name;
    }

    //validate $address
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

    // validate or empty
    if (empty($name_err) && empty($address_err) && empty($salary_err)) {
        $sql = "INSERT INTO employees (name, address, salary) VALUES (?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sss", $param_name, $param_address, $param_salary);

            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;


            if ($stmt->execute()) {
                header("location: index.php");
                exit();
            } else {
                echo "Error";
            }
        }

        $stmt->close();
    }

    $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="./index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>