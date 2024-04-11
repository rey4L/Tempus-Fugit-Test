<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?=CSS_URL."main.css"?>>
    <link rel="stylesheet" href=<?=CSS_URL."menu-item-add.css"?>>
    <title>Menu Item Form</title>
</head>

<body>
    <form action="<?=BASE_URL."/MenuItem"?>"method="POST" id="menu-back-form"></form>
    <form class="menu-item-add-form" action="<?=BASE_URL."/MenuItem/create"?>" method="post">
        <p class="form-name-text">
            ADD GUEST
        </p>
    
    <label for="first_name">First Name</label>
    <input type="text" id="first_name" name="first_name" required>

    <label for="last_name">Last Name</label>
    <input type="text" id="last_name" name="last_name" required>

    <label for="age">Age</label>
    <input type="text" id="age" name="age" required>

    <label for="gender">Gender</label>
    <select id="gender" name="gender" required>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select>

    <label for="phone">Phone Number</label>
    <input type="text" id="phone" name="phone" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <label for="passport">Passport Number</label>
    <input type="text" id="passport" name="passport" required>

    <label for="drivers_license">Driver's License</label>
    <input type="text" id="drivers_license" name="drivers_license" required>

        <button type="submit">Submit</button>
        <button type="submit" class="menu-back-button" form="menu-back-form">Back To List</button>
    </form>
</body>
</html>