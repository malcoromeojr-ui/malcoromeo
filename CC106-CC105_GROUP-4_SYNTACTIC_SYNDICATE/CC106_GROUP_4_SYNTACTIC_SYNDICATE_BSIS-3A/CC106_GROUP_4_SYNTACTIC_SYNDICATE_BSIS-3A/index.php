<?php
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Youth Information & Service Portal (BYISP)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navigation Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">BYISP Portal</a>
            <div>
                <a href="dashboard.php" class="btn btn-light btn-sm fw-bold px-3">Open Dashboard</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-white py-5 border-bottom">
        <div class="container text-center py-4">
            <h1 class="display-5 fw-bold text-primary mb-3">Barangay Youth Information & Service Portal</h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Streamlining youth registration, sports participation, and educational assistance requests for a modern, transparent community administration.
            </p>
            <div class="mt-4">
                <a href="dashboard.php" class="btn btn-primary btn-lg px-4 me-2">Go Direct to Dashboard</a>
            </div>
        </div>
    </div>

    <!-- Feature Highlights -->
    <div class="container my-5">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 p-3">
                    <div class="card-body">
                        <div class="fs-1 text-primary mb-2">📋</div>
                        <h5 class="card-title fw-bold">Online Requests</h5>
                        <p class="card-text text-muted small">
                            Submit requests for educational assistance, certificates, and youth programs.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 p-3">
                    <div class="card-body">
                        <div class="fs-1 text-primary mb-2">⚡</div>
                        <h5 class="card-title fw-bold">Real-time Tracking</h5>
                        <p class="card-text text-muted small">
                            Track application statuses directly from your dashboard.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 p-3">
                    <div class="card-body">
                        <div class="fs-1 text-primary mb-2">📊</div>
                        <h5 class="card-title fw-bold">CSV Export</h5>
                        <p class="card-text text-muted small">
                            Generate detailed CSV reports for youth service records.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <p class="mb-0 small">&copy; <?php echo date('Y'); ?> Barangay Youth Information & Service Portal. Developed for CC106 Application Development.</p>
        </div>
    </footer>

</body>
</html>