<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - USDT Staking</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <div class="d-flex">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Platform Overview</h2>
        <div class="row my-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Total Users</h5>
                        <p class="display-6" id="totalUsers">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Total Staked</h5>
                        <p class="display-6" id="totalStaked">0.00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Total Earnings Paid</h5>
                        <p class="display-6" id="totalEarnings">0.00</p>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="mt-5">Manage Users</h3>
        <div class="mb-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Wallet</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    <!-- Dynamic rows -->
                </tbody>
            </table>
        </div>
        <h3 class="mt-5">Withdrawal Requests</h3>
        <div class="mb-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Wallet</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="withdrawalTable">
                    <!-- Dynamic rows -->
                </tbody>
            </table>
        </div>
        <h3 class="mt-5">Staking Plans</h3>
        <div class="mb-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Duration</th>
                        <th>Interest Rate</th>
                        <th>Min Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="planTable">
                    <!-- Dynamic rows -->
                </tbody>
            </table>
            <button class="btn btn-success">Add New Plan</button>
        </div>
    </div>
    <script src="../public/assets/js/app.js"></script>
</body>
</html>
