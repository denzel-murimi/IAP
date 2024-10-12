<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>2FA Verification</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Enter 2FA Code</h2>
                    </div>
                    <div class="card-body">
                        <form action="verify_2fa.php" method="POST">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
                            <div class="mb-3">
                                <label for="auth_code" class="form-label">2FA Code</label>
                                <input type="text" name="auth_code" class="form-control" maxlength="6" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Verify</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
