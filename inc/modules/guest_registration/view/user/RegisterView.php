<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_URL . "main.css" ?>">
    <link rel="stylesheet" href="<?= CSS_URL . "user-registration.css" ?>">
    <title>Employee Registration Form</title>
</head>
<body>
    <form id="registration-form" class="registration-form" action="<?= BASE_URL . "/User/register" ?>" method="post">
        <p class="form-name-text">
            USER REGISTRATION
        </p>

        <h5 class="form-info-text">
            Hover over input bar to see specific instructions (if any)
        </h5>
        <label for="email">Email 
        <input type="email" name="email" required>

        <label for="password">Password 
        <input type="password" name="password" required>

        <label for="confirm-password">Confirm Password 
        <input type="password" name="confirm-password" required>

        <label for="role">Role 
        <select name="role" required>
            <option value="cashier">Cashier</option>
            <option value="manager">Manager</option>
        </select>

        <label for="employee_id">Employee ID 
        <input type="text" name="employee_id" required>

        <button type="submit" form="registration-form">Submit</button>
    </form>
    <form id="registration-back-form" class="registration-back-form" action="<?= BASE_URL . "/User" ?>" method="post">
        <button type="submit">Back To Login</button>
    </form>
</body>
</html>