<?php
// include('start.php');
// require_once('start.php');

// start('1.1.1.1');
$pw = '';
if (isset($_POST['password'])) {
    $pw = $_POST["password"];
}
if ($pw != "test") {
    header("Location: index.php?err=yes");
}
$cookie_name = "ip";
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
    <title>Nginx Configuration</title>
    <style>
        .loading {
            color: black;
            font: 300 2em/100% Impact;
            text-align: center;
        }

        /* loading dots */

        .loading:after {
            content: ' .';
            animation: dots 1s steps(5, end) infinite;
        }

        .font-base {
            font-size: large;
        }

        button {
            font-size: large !important;
        }

        textarea,
        input {
            font-size: large !important;
        }
    </style>
</head>

<body class="p-5 font-base">
    <div class="form-outline w-75 m-auto">
        <label for="domain">Domains:</label>
        <textarea class="form-control" rows="5" id="domain" name="domain" required></textarea>

        <label for="ip" class="mt-5">Destination IP:</label>
        <input type="text" class="form-control w-25" id="ip" required
            value='<?php echo !isset($_COOKIE[$cookie_name]) ? "" : $_COOKIE[$cookie_name] ?>'>

        <div class="form-group text-right">
            <button type="button" class="btn btn-success mt-4" onclick="addDomain()">Save domains</button>
        </div>
        <div class="form-group">
            <table class="table mt-5 m-auto">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">domain name</th>
                        <th scope="col">ip</th>
                        <th scope="col">status</th>
                        <th scope="col">date added</th>
                        <th scope="col">remove</th>
                    </tr>
                </thead>
                <tbody id="domain_data">
                </tbody>
            </table>
            <p class="loading">Loading Data</p>
        </div>
        <div class="form-group text-right">
            <button type="button" class="btn btn-primary mt-4" id="btn_start" onclick="startConfig()">Start config
                generation on new
                domains</button>
        </div>
        <div class="form-group text-right">
            <button type="button" class="btn btn-warning mt-2" id="btn_restart" onclick="restartConfig()">Restart web
                server</button>
        </div>
        <div id="status" class="form-group text-right">
        </div>
        <textarea class="form-control" rows="5" id="comment" readonly></textarea>
    </div>
    <script>
        $(document).ready(function () {
            domainList();
        });
        function domainList() {
            $.ajax({
                type: 'get',
                url: "database/crud/domain-list.php",
                success: function (data) {
                    console.log(data)
                    var response = JSON.parse(data);
                    var tr = '';
                    for (var i = 0; i < response.length; i++) {
                        var id = response[i].id;
                        var name = response[i].name;
                        var ip = response[i].ip;
                        var status = response[i].status;
                        var date = response[i].date;
                        tr += '<tr>';
                        tr += '<td><a href="https://' + name + '" target="_blank">' + name + '</td>';
                        tr += '<td>' + ip + '</td>';
                        tr += '<td>' + status + '</td>';
                        tr += '<td>' + date + '</td>';
                        tr += '<td><div class="d-flex">';
                        tr +=
                            `<button type="button" class="btn btn-danger fa fa-close" onclick="deleteDomain(${id})">remove</button>`;
                        tr += '</div></td>';
                        tr += '</tr>';
                    }
                    $('.loading').hide();
                    $('#domain_data').html('');
                    $('#domain_data').html(tr);
                    startConfig();
                }
            });
        }

        function addDomain() {
            var lines = $('#domain').val().split('\n').map(line => line.trim()).filter(line => Boolean(line));
            console.log(lines)
            var ip = $('#ip').val();
            if (lines.length < 1 || ip == "") {
                alert("Domains and Destination IP can not be empty.");
                return
            }

            console.log(lines)
            console.log(ip)

            // lines.map(async line => {
            // console.log(line)
            $.ajax({
                type: 'post',
                data: {
                    names: lines,
                    status: 'new',
                },
                url: "database/crud/domain-add.php",
                success: function (data) {
                    console.log(data)
                    var response = JSON.parse(data);
                    domainList();
                    // alert(response.message);
                }
            })
            // })
        }

        function editDomain() {
            var name = $('.edit_domain #name_input').val();
            var email = $('.edit_domain #email_input').val();
            var phone = $('.edit_domain #phone_input').val();
            var address = $('.edit_domain #address_input').val();
            var domain_id = $('.edit_domain #domain_id').val();

            $.ajax({
                type: 'post',
                data: {
                    name: name,
                    email: email,
                    phone: phone,
                    address: address,
                    domain_id: domain_id,
                },
                url: "database/crud/domain-edit.php",
                success: function (data) {
                    var response = JSON.parse(data);
                    $('#editdomainModal').modal('hide');
                    domainList();
                    alert(response.message);
                }

            })
        }

        function viewDomain(id = 2) {
            $.ajax({
                type: 'get',
                data: {
                    id: id,
                },
                url: "database/crud/domain-view.php",
                success: function (data) {
                    var response = JSON.parse(data);
                    $('.edit_domain #name_input').val(response.name);
                    $('.edit_domain #email_input').val(response.email);
                    $('.edit_domain #phone_input').val(response.phone);
                    $('.edit_domain #address_input').val(response.address);
                    $('.edit_domain #domain_id').val(response.id);
                    $('.view_domain #name_input').val(response.name);
                    $('.view_domain #email_input').val(response.email);
                    $('.view_domain #phone_input').val(response.phone);
                    $('.view_domain #address_input').val(response.address);
                }
            })
        }

        function deleteDomain(id) {
            // var id = $('#delete_id').val();
            // $('#deleteDomainModal').modal('hide');
            $.ajax({
                type: 'get',
                data: {
                    id,
                },
                url: "database/crud/domain-delete.php",
                success: function (data) {
                    console.log(data)
                    var response = JSON.parse(data);
                    domainList();
                    // alert(response.message);
                }
            })
        }

        function startConfig() {
            const ip = $("#ip").val();
            $("#btn_start").attr('disabled', 'disabled');
            $.ajax({
                type: 'get',
                data: {
                    ip,
                },
                url: "database/config/start.php",
                success: function (data) {
                    console.log(data)
                    $("#comment").val(data)
                    $('#btn_start').removeAttr('disabled');
                    $('#domain_data tr').map((index, tr) => {
                        console.log(tr);
                        const domain_name = $(tr).find("td:first-child a").get(0)?.innerHTML ?? "Nope"
                        if (data.includes(`Domain ${domain_name} is successful`)) {
                            $(tr).css("background-color", "lightgreen")
                        }
                    })
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $('#btn_start').removeAttr('disabled');
                }
            })
        }

        function restartConfig() {
            $("#btn_restart").attr('disabled', 'disabled');
            $.ajax({
                type: 'get',
                url: "database/config/restart.php",
                success: function (data) {
                    console.log(data)
                    $("#comment").val(data)
                    $('#btn_restart').removeAttr('disabled');
                    // var response = JSON.parse(data);
                    // domainList();
                    // alert(response.message);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                    $('#btn_restart').removeAttr('disabled');
                }
            })
        }
    </script>
</body>

</html>