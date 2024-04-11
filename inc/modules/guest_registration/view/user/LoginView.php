<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?=CSS_URL."login-form.css"?>>
    <title>Login Page</title>
</head>
<body>
    <div class="login-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5">
                        <div class="card-body">
                            <h3 class="card-title text-center">Login</h3>
                            <form action="<?= BASE_URL . "/user/login"?>" method="post">                                
                                <div class="form-group">
                                    <label for="email">
                                        Email address
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">
                                        Password
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="text-center">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </form>
                                
                            <form action="<?= BASE_URL."/user/view/user=Register"?>"  method="post">
                               <button type="submit" class="btn btn-primary">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

