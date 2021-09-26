<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ошибка соединения</title>
    <!-- Global stylesheets -->
    <link rel="shortcut icon" href="/static/assets/images/logo.ico" type="image/x-icon">
	<link href="/static/assets/fonts/font.css" rel="stylesheet" type="text/css">
    <link href="/static/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="/static/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/static/assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="/static/assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="/static/assets/css/components.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
</head>

<body>
    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content d-flex justify-content-center align-items-center">

                <!-- Container -->
                <div class="flex-fill">

                    <!-- Error title -->
                    <div class="text-center mb-3">
                        <h3 class="error-title text-danger">Ошибка</h3>
                        <h3><?= $_error; ?></h5>
                    </div>
                    <!-- /error title -->

                </div>
                <!-- /container -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->
</body>
</html>
