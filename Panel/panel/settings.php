<?php
include("./header.php");



?>


<!-- Page Content-->
<div class="page-content">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col">
                            <h4 class="page-title">Settings</h4>
                            <ol class="breadcrumb">


                            </ol>
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
            <div class="col-12">
                <div class="card">
                    <!--end card-header-->
                    <div class="card-body">
					<table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 260px;">Name</th>

                                    <th style="width: 80px;">Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                <tr>
									<td>Enable dublicates</td>
									<td>
										<div class="custom-control custom-switch switch-primary">
											<input type="checkbox" class="custom-control-input" id="dublCheckbox" <?php 
												$settings = R::load('settings', 1);
												if($settings["dublicates"] == "1")
												{
													echo 'checked="checked"';
												}

											?> data-parsley-multiple="groups" data-parsley-mincheck="2">
											<label class="custom-control-label" for="dublCheckbox">Dublicates</label>
										</div>
									</td>
								</tr>
								<tr>
									<td>Clear database</td>
									<td><button type="submit" id="clearDB" class="btn btn-sm btn-block btn-outline-info">Clear</button></td>
								</tr>
								
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
<script src="includes/settingsactions.js"></script>

</body>

</html>