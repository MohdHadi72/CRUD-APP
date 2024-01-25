<?php
$insert = false;

$con = mysqli_connect('localhost', 'root', '', 'curddata') or die("Couldn't Connected");



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {

        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $desctiption = $_POST['descriptionEdit'];

        $sql = "UPDATE `crudtable` SET `title` = '$title', `description` = '$desctiption' WHERE `crudtable`.`sno` = $sno;";

        $result = mysqli_query($con, $sql);
    } else {
        $title = $_POST['title'];
        $desctiption = $_POST['description'];


        $sql = "INSERT INTO `crudtable` (`title`, `description`) VALUES ('$title','$desctiption');";
        $result = mysqli_query($con, $sql);


        if ($result) {
            $insert = true;
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="Crud.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <title>CRUD App Project</title>
</head>

<body style="background-color: #e4e9f7;">

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModallabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/CRUD/CrudApp.php" method="POST" class="mt-3">
                        <input type="hidden" id="snoEdit" name="snoEdit">

                        <div class="mb-3">
                            <label for="Title" class="form-label"><strong>Update Note</strong></label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                        </div>

                        <div class="form-group">
                            <label for="Description"><strong>Update Description</strong></label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success mt-4 w-25"><strong>Update Now</strong></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <nav class="navbar navbar-expand-lg navbar-black  bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="img/PHP_logo.png" alt="" style="width: 70px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#"><strong>Home</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><strong>About</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><strong>Content</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><strong>Service</strong></a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Type Search" aria-label="Search">
                    <button class="btn btn-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>





    <?php
    if ($insert) {
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Successfull:  </strong>Your Note Has been inserted Successfull.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }

    ?>



    <div class="contianer my-3">
        <h1>Add Yours Nots <span style="font-size: 28px;"> &nbsp;( ͡• ͜ʖ ͡• )</span> </h1>
        <form action="/CRUD/CrudApp.php" method="POST" class="mt-3">
            <div class="mb-3">
                <label for="Title" class="form-label"><strong>Nots Title</strong></label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="description"><strong>Nots Description</strong></label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <button type="submit" class="btn btn-success mt-4 w-25"><strong>Add Nots</strong></button>
        </form>
    </div>

    <div class="contianer table my-5">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.Number</th>
                    <th scope="col">Nots Titles</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php

                $sql = "SELECT * FROM `crudtable`";
                $result = mysqli_query($con, $sql);
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;
                    echo "<tr>
                        <th scope='row'>" . $sno . "</th>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td> <button class='edit btn btn-success' id=" . $row['sno'] . ">Edit</button>&nbsp;&nbsp;  
                          <button class='Delete btn btn-success' type='submit'>Delete</button></td>
                    </tr>";
                }

                ?>

            </tbody>
        </table>
    </div>
    <hr>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>




    <script>
        // Create Modal Function 

        Edit = document.getElementsByClassName("edit");

        Array.from(Edit).forEach((element) => {

            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerHTML;
                descriptions = tr.getElementsByTagName("td")[1].innerHTML;
                titleEdit.value = title;
                descriptionEdit.value = descriptions;
                snoEdit.value = e.target.id;
                console.log(e.target.id);

                $('#editModal').modal('toggle');

            });
        });
    </script>
</body>

</html>