<?php
if (isset($_GET['err'])) {
    if ($_GET["err"] == "yes") {
        echo "
        <script>
            alert('Wrong password!!!');
        </script>
    ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reverse proxy UI</title>
    <style>
        body {
            padding: 100px 0;
            background-color: #efefef
        }

        a,
        a:hover {
            color: #333
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <form action="conf.php" method="post">
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group" id="show_hide_password">
                            <input class="form-control" type="password" name="password">
                            <!-- <div class="input-group-addon">
                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // $("#show_hide_password a").on('click', function (event) {
            //     event.preventDefault();
            //     if ($('#show_hide_password input').attr("type") == "text") {
            //         $('#show_hide_password input').attr('type', 'password');
            //         // $('#show_hide_password i').addClass("fa-eye-slash");
            //         $('#show_hide_password i').removeClass("fa-eye");
            //     } else if ($('#show_hide_password input').attr("type") == "password") {
            //         $('#show_hide_password input').attr('type', 'text');
            //         // $('#show_hide_password i').removeClass("fa-eye-slash");
            //         $('#show_hide_password i').addClass("fa-eye");
            //     }
            // });
        });
    </script>
</body>

</html>
