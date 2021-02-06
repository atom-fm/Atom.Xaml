<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">

    <title>UI Demo</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">
    <link href="style/offcanvas.css" rel="stylesheet">

    <?php include __DIR__ . "/highlighter.php" ?>
    <?php include __DIR__ . "/config.php" ?>

</head>

<body class="bg-light">
    <?php include __DIR__ . "/hot-reload.php" ?>

    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
        <div class="container-fluid">
            <a class="navbar-brand" href="?view=index">Offcanvas navbar</a>
            <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="?view=dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?view=notifications">Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?view=profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?view=switch-account">Switch account</a>
                    </li>
                </ul>

                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Settings</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown01">
                            <li><a class="dropdown-item" href="?view=profile">Profile</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav nav-underline" aria-label="Secondary navigation">
            <a class="nav-link active" aria-current="page" href="?view=dashboard">Dashboard</a>
            <a class="nav-link" href="?view=friends">
                Friends
                <span class="badge bg-light text-dark rounded-pill align-text-bottom">27</span>
            </a>
            <a class="nav-link" href="?view=explore">Explore</a>
            <a class="nav-link" href="?view=suggestions">Suggestions</a>
        </nav>
    </div>

    <main class="container">
        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <?php echo $content ?>
        </div>
        <!--
        <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
            <div class="lh-1">
                <h1 class="h6 mb-0 text-white lh-1">Bootstrap</h1>
                <small>Since 2011</small>
            </div>
        </div>

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom pb-2 mb-0">Recent updates</h6>
            <div class="d-flex text-muted pt-3">
                <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
                </svg>

                <p class="pb-3 mb-0 small lh-sm border-bottom">
                    <strong class="d-block text-gray-dark">@username</strong>
                    Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                </p>
            </div>
            <div class="d-flex text-muted pt-3">
                <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#e83e8c" /><text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text>
                </svg>

                <p class="pb-3 mb-0 small lh-sm border-bottom">
                    <strong class="d-block text-gray-dark">@username</strong>
                    Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                </p>
            </div>
            <div class="d-flex text-muted pt-3">
                <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#6f42c1" /><text x="50%" y="50%" fill="#6f42c1" dy=".3em">32x32</text>
                </svg>

                <p class="pb-3 mb-0 small lh-sm border-bottom">
                    <strong class="d-block text-gray-dark">@username</strong>
                    Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                </p>
            </div>
            <small class="d-block text-end mt-3">
                <a href="#">All updates</a>
            </small>
        </div>

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom pb-2 mb-0">Suggestions</h6>
            <div class="d-flex text-muted pt-3">
                <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
                </svg>

                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                    <div class="d-flex justify-content-between">
                        <strong class="text-gray-dark">Full Name</strong>
                        <a href="#">Follow</a>
                    </div>
                    <span class="d-block">@username</span>
                </div>
            </div>
            <div class="d-flex text-muted pt-3">
                <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
                </svg>

                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                    <div class="d-flex justify-content-between">
                        <strong class="text-gray-dark">Full Name</strong>
                        <a href="#">Follow</a>
                    </div>
                    <span class="d-block">@username</span>
                </div>
            </div>
            <div class="d-flex text-muted pt-3">
                <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
                </svg>

                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                    <div class="d-flex justify-content-between">
                        <strong class="text-gray-dark">Full Name</strong>
                        <a href="#">Follow</a>
                    </div>
                    <span class="d-block">@username</span>
                </div>
            </div>
            <small class="d-block text-end mt-3">
                <a href="#">All suggestions</a>
            </small>
        </div>
        -->
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <script src="js/offcanvas.js"></script>
</body>

</html>