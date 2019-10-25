<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="-1" />

<style>
tr.for-getting-width td{
	height:0px !important;
}
tr.thead-getting-width td{
	height:0px !important;
}
tr.thead-getting-width td{
	height:0px !important;
}

</style>
<?php 
$company_name 		= $this->session->userdata('company-name');
$loggedincompanyid 	= $this->session->userdata('companyid');
$logged_detail 		= $this->session->userdata('logged_detail');
$loggedInUser 		= unserialize($logged_detail);

// print_r($loggedInUser);
date_default_timezone_set("Europe/London");
include('end_of_week.php');
// echo '<pre>';
// print_r($restriction);
// echo '</pre>';
// echo '<pre>';
// print_r($all_data);
// echo '</pre>';
// staff_dept_id
// echo '<pre>';
// print_r($pay_value_dept);
// echo '</pre>';
// echo '<pre>';
// print_r($forecast_rota_pay_comp);
// echo '</pre>';
// error_reporting(0);

// echo '<pre>';
// print_r($get_payroll_approved);
// echo '</pre>';

// echo '<pre>';
// print_r($staff_holiday_date_range);
// echo '</pre>';

// echo '<pre>';
// print_r($staff_sick_date_range);
// echo '</pre>';

// echo '<pre>';
// print_r($forecast_rota_data);
// echo '</pre>';

// echo '<pre>';
// print_r($net_of_week);
// echo '</pre>';

// echo '<pre>';
// print_r($approved_departments);
// echo '</pre>';

// echo '<pre>';
// print_r($restriction);
// echo '</pre>';

// echo '<pre>';
// print_r($pay_value_dept);
// echo '</pre>';
$show_finalisation = 1;
if(isset($restriction))
{
	$restriction_available_for_user = 1;
	foreach($restriction['read'] as $key => $row)
	{
		if($row == 0 || $restriction['write'][$key] == 0)
		{
			$show_finalisation = 0;
			break;
		}
	}
}		

$table_extra_css= '';
if($current_end_date == $end_date)
{
	$table_extra_css= 'rota-darkest';
}
?><br>
<br>


<div class="block" id="tabs-main">
	
	<p id="rota-publish-message-sent-to" style="display:none;"></p>
	<p id="rota-publish-message"></p>
    <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs" id="rota-ul-top-list">
        <li class="active">
			<a class = "tabs_a" id = "default" href="#default-tab">View All<input type="hidden" value="blank" class="hidden_section_id"></a>
		</li>
		<?php
		$section_availabe_coloumn = 1;
			if(isset($fetch_section_data)){
				foreach($fetch_section_data as $cnt => $row)
					{
						$section_id[] = $row->id;	
						$section_availabe_coloumn = 2;
					?>	
					<input type="hidden" value="<?php echo $row->id;?>" class="hidden_section_id">
					<!--					
					<li>
						<a  class = "tabs_a" id = "<?php echo $row->id;?>" href="#tabs-<?php echo $row->id;?>"><?php echo ucfirst($row->section_title);?><input type="hidden" value="<?php echo $row->id;?>" class="hidden_section_id"></a>
					</li>
					-->
					<?php	 
						$ss = $cnt++; 
					} 
				} 
				
		$total_coloumn_of_table = $section_availabe_coloumn+31;
				?>
				
		<!--
		<li id="li-add-button" style="display:none;">
			<form method="POST" action="" id="form-rota-add-button">
				<button class="btn btn-minw btn-primary" id="rota-add-button" type="submit">Add Staff</button>
			</form>
		</li>
		
		<li class="pull-right">
			<a href="#btabs-alt-static-settings" data-toggle="tooltip" title="Settings"><i class="si si-settings"></i></a>
		</li>
		-->
		<li class="pull-right">
			<ul class="block-options">
			<li>
				<form action="<?php echo base_url().'rota_auto_add_staff';?>" method="POST" id="form_rota_auto_add_staff">
					<input type="hidden" name="end_date" value="<?php echo $end_date; ?>">
					<button class="btn btn-primary" type="submit" id="form-for-missing-staff" style="display:none;"> &nbsp;Auto Add Staff&nbsp; </button>
				</form>
			</li>
			<li><button class="btn btn-info" data-toggle="modal" data-target="#modal-copy-for-next-week" type="button">Copy</button></li>
			<?php
			if(isset($rota_page_publish_button))
			{
			?>
				<li><button class="btn btn-success" onclick="location.href = '<?php echo base_url();?>forecast_rota/<?php echo $end_date;?>';" data-toggle="tooltip" data-placement="bottom" title="" type="button" data-original-title="View forcast rota">Unpublished</button></li>
			<?php
			}
			
			?>
			
			<li><button class="btn btn-success" onclick="location.href = '<?php echo base_url();?>recalculate_rota/<?php echo $end_date;?>';" data-toggle="tooltip" data-placement="bottom" title="" type="button" data-original-title="Recalculate current rota"><i class="si si-calculator"></i> Recalculate</button></li>
		
			<li><button class="btn btn-success" type="button" onclick="printDiv('rota-print-area')"><i class="si si-printer"></i> Print Rota</button></li>
			<?php if ($loggedInUser->checkPermission(array(16))){ ?>
			<li><button class="btn btn-warning" onclick="location.href = '<?php echo base_url();?>pay_breakdown/<?php echo $end_date;?>';" data-toggle="tooltip" data-placement="bottom" title="" type="button" data-original-title="View rota pay breakdowns and summaries"><i class="si si-bulb"></i> Pay breakdown</button></li>
			<?php }?>
			<?php if(isset($reset_rota_setting_active)){
					if($reset_rota_setting_active == 1){
			?>
		
			<li>
				<button class="btn btn-danger" onclick="location.href = '<?php echo base_url();?>staff/rota_reset/<?php echo $end_date;?>';" data-toggle="tooltip" data-placement="bottom" title="" type="button" data-original-title="If you've made a big mistake, or you've heavily changed your staff details section, then we recommend you reset the rota here. All data will be reset">Reset whole rota</button>
			</li>
			<?php }} ?>
		
			<li><button class="btn btn-info" onclick="location.href = '<?php echo base_url(); ?>update_rota_department/3/<?php echo $end_date; ?>';" data-toggle="tooltip" data-placement="bottom" title="" type="button" data-original-title="This does not delete the data you have inputted, this only updates staff departments if you have made major changes in your staff details area">Update departments</button></li>
			
			<?php
			$newuseractivation 		= $this->session->userdata('newuseractivation');
			if($loggedInUser->switch_user == 1 && $newuseractivation != '1')
			{
				?>
				<li>
					<form action="<?php echo base_url();?>form_switch_company" method="POST" id="switch-company">
						<input name="uri_2" type="hidden" value="<?php echo $end_date; ?>">
						<input name="redirect_page" type="hidden" value="rota_view_ex">
					<select name="new_company_id" onchange="if(this.value){ $(this).parent('form').submit(); }">
					<option value=""></option>
					<?php 
						$sql = "SELECT sc.id, c.company_name,sc.company_id FROM switch_company  as sc JOIN company as c on sc.company_id = c.id WHERE sc.user_id = '".$loggedInUser->user_id."' AND sc.activate = '1' ORDER BY c.company_name ASC";
						
						$fetch_switch_companies_data = $this->Common_model->query($sql);
						if($fetch_switch_companies_data->num_rows() > 0)
						{
							$fetch_switch_companies_data = $fetch_switch_companies_data->result();
							foreach($fetch_switch_companies_data as $key => $row_data){
								$selected = '';
								if($this->session->userdata('companyid') == $row_data->company_id)
								{
									$selected = 'selected';
								}
								echo '<option value="'.$row_data->company_id.'" '.$selected.'>'.$row_data->company_name.'</option>';
							}
						}							
					?>
					</select>
					</form>
				</li>
				<?php
			}
			?>
		
			<li>
				<form method="POST" action="<?php echo base_url();?>rota_view_ex/<?php echo $end_date; ?>" id="select_dept_form">
					<select onchange="select_department()" id = "select_dept" name="select_dept">
						<option value=''>All departments</option>
						<?php
						foreach($fetch_department_data as $row)
						{
							
								if($dept_idd == $row->id){
									$selected = 'selected = selected';
								}
								else
								{
									$selected = '';
								}
						?>
						<option <?php echo $selected; ?> value="<?php echo $row->id;?>"><?php echo $row->dept_name;?></option>
							<?php 

						}							?>
				
					</select>
				</form>
			</li>
			
			<li>
				<form method="POST" action="<?php echo base_url();?>rota_view_ex/<?php echo $end_date; ?>" id="select_section_form">
					<input type="hidden" name="end_date_section" value="<?php echo $end_date; ?>">
					<select onchange="$('form#select_section_form').submit()" id = "select_section" name="select_section">
						<option value=''>All Section</option>
						<?php
						foreach($fetch_section_data as $row)
						{
						
							$selected = '';
							if(isset($select_section) && $select_section == $row->id)
							{
								$selected = 'selected';
							}
						?>
						<option  value="<?php echo $row->id;?>" <?php echo $selected; ?> ><?php echo $row->section_title;?></option>
					<?php } ?>
				
					</select>
				</form>
			</li>
		
			<li id="rota-last-download-excel">
				<?php if ($loggedInUser->checkPermission(array(2))){ ?><button class="btn btn-info" type="button" onclick="location.href = '<?php echo base_url(); ?>staff/rota_download/<?php echo $end_date; ?>'" data-toggle="tooltip" data-placement="bottom"  data-original-title="For download a excel file"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i> Download<?php } ?></button>
			</li>
				
			
			<?php 
				if($get_logged_in_company_id == 28 || $get_logged_in_company_id == 38)
				{ 
					?>
					<li id="rota-last-download-excel">
						<button class="btn btn-info" type="button" onclick="location.href = '<?php echo base_url(); ?>download_manaualjournal/<?php echo $end_date; ?>'" data-toggle="tooltip" data-placement="bottom"  data-original-title="For download a excel file"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i> Manual Journal</button>
					</li>
					<?php
				}
			?>
			</ul>
		</li>	
    </ul>
	<br>
		<?php
		if(isset($restriction_available_company) && $restriction_available_company == 1)
		{
			if(isset($fetch_staff_dept))
			{
				foreach($fetch_staff_dept as $row)
				{
					$a_class = 'red';
					if(isset($approved_departments[$row->id]) && $approved_departments[$row->id] == 1)
					{
						$a_class = 'green';
					}
					
					if($a_class == 'red')
					{
						$unapproved_departments[] = $row->id;
					}
					if($show_finalisation == 1 || $loggedInUser->checkPermission(array(26)) == 1)
					{
						echo '<span class="payroll-approve '.$a_class.'" data-toggle="tooltip" data-placement="top" data-original-title="Published by '.$uc_users_name_list[$approved_departments_rota_by[$row->id]].'">&nbsp;&nbsp;<i class="fa fa-circle"></i>&nbsp;'.$row->dept_name.'&nbsp;</span>';
					}
				}
			}
		}
		?>	
        <div class="block-content tab-content">
            <?php
			if(is_array($section_id)){
				foreach($section_id as $secid){ 
					?>
					<div id="tabs-<?php echo $secid;?>" class="tab-pane">
										
					</div>	
					<?php  
				} 
			} 
			?>
			<div id="default-tab" class="payroll_dependent_inputs tab-pane active">
				<div class="table-responsive" id="rota-print-area">
					<table  id="table-1" class="rota_ex_table <?php echo $table_extra_css; ?>">
						<thead class="thead">
							<tr class="thead-getting-width">
								<?php
								for($aaaa=1;$aaaa<=$total_coloumn_of_table;$aaaa++)
								{
									echo '<td></td>';
								}
								?>
							</tr>
							<tr class="top_header_rota">
								<td colspan="<?php echo $section_availabe_coloumn; ?>" class="bg-color-red">Total Hours</td>
								<td colspan="4" class="total_mon_hours bg-color-red dept-hours-mon-<?php echo $all_data[$previous]->staff_dept_id; ?>">0</td>
								<td colspan="4" class="total_tue_hours bg-color-red dept-hours-tue-<?php echo $all_data[$previous]->staff_dept_id; ?>">0</td>
								<td colspan="4" class="total_wed_hours bg-color-red dept-hours-wed-<?php echo $all_data[$previous]->staff_dept_id; ?>">0</td>
								<td colspan="4" class="total_thu_hours bg-color-red dept-hours-thu-<?php echo $all_data[$previous]->staff_dept_id; ?>">0</td>
								<td colspan="4" class="total_fri_hours bg-color-red dept-hours-fri-<?php echo $all_data[$previous]->staff_dept_id; ?>">0</td>
								<td colspan="4" class="total_sat_hours bg-color-red dept-hours-sat-<?php echo $all_data[$previous]->staff_dept_id; ?>">0</td>
								<td colspan="4" class="total_sun_hours bg-color-red dept-hours-sun-<?php echo $all_data[$previous]->staff_dept_id; ?>">0</td>
								<td colspan="3" class="bg-color-red td-top-total-hours"></td>
							</tr>
                            <?php if($loggedInUser->checkPermission(array(15))){ ?>
							<tr class="top_header_rota">
								<td colspan="<?php echo $section_availabe_coloumn; ?>" class="bg-color-red">Forecasted sales</td>
                                <?php
								$sql = "select * from forecast where company_id = '".$loggedincompanyid."' AND we = '".$end_date."'";
								$result_1 = $this->Common_model->query($sql);
								$result_11 = $result_1->result();
								if($result_1->num_rows() > 0)
								{
									foreach($result_11 as $row)
									{
										
										$mforecast	 = $row->mforecast;
										$tforecast	 = $row->tforecast;
										$wforecast	 = $row->wforecast;
										$thforecast	 = $row->thforecast;
										$fforecast	 = $row->fforecast;
										$sforecast	 = $row->sforecast;
										$suforecast	 = $row->suforecast;
										$totforecast = $row->totforecast; 
										// $labour		 = $row->labour;
									}
								}
											
											
								 ?>
								
								 <td colspan="4" class="total_mon_fs bg-color-red"><?php echo '£ '.number_format(($mforecast/100),2); ?> </td>
								
								 <td colspan="4" class="total_tue_fs bg-color-red"><?php echo '£ '.number_format(($tforecast/100),2); ?> </td>
								
								 <td colspan="4" class="total_wed_fs bg-color-red"><?php echo '£ '.number_format(($wforecast/100),2); ?> </td>
								
								 <td colspan="4" class="total_thu_fs bg-color-red"><?php echo '£ '.number_format(($thforecast/100),2); ?> </td>
								
								<td colspan="4" class="total_fri_fs bg-color-red"><?php echo '£ '.number_format(($fforecast/100),2); ?> </td>
								
								<td colspan="4" class="total_sat_fs bg-color-red"><?php echo '£ '.number_format(($sforecast/100),2); ?> </td>
								
								<td colspan="4" class="total_sun_fs bg-color-red"><?php echo '£ '.number_format(($suforecast/100),2); ?> </td>
								
								<td colspan="3" class="bg-color-red total_all_fs"><?php echo '£ '.number_format(($totforecast/100),2); ?> </td>
							</tr><?php } ?>
							
							<?php
							//echo '<pre>';
							//print_r($forecast_target_data);
							//echo '</pre>';
								if(isset($forecast_target_data))
								{
									foreach($forecast_target_data as $target_data)
									{
										$target_department_pays_mon = $target_department_pays_tue = $target_department_pays_wed = $target_department_pays_thu = $target_department_pays_fri = $target_department_pays_sat = $target_department_pays_sun =  $target_total_of_department_pays = 0;
										$total_of_target = $target_data->mon + $target_data->tue + $target_data->wed + $target_data->thu + $target_data->fri + $target_data->sat + $target_data->sun;
										if($target_data->JSON_departments)
										{
											$target_data_combine_of_dept = json_decode($target_data->JSON_departments);
											foreach($target_data_combine_of_dept as $row_target_dept_id)
											{
												$target_department_pays_mon += $pay_value_dept[$row_target_dept_id]['sum_monpay'];
												$target_department_pays_tue += $pay_value_dept[$row_target_dept_id]['sum_tuepay'];
												$target_department_pays_wed += $pay_value_dept[$row_target_dept_id]['sum_wedpay'];
												$target_department_pays_thu += $pay_value_dept[$row_target_dept_id]['sum_thupay'];
												$target_department_pays_fri += $pay_value_dept[$row_target_dept_id]['sum_fripay'];
												$target_department_pays_sat += $pay_value_dept[$row_target_dept_id]['sum_satpay'];
												$target_department_pays_sun += $pay_value_dept[$row_target_dept_id]['sum_sunpay'];
												$target_total_of_department_pays   = $target_department_pays_mon + $target_department_pays_tue + $target_department_pays_wed + $target_department_pays_thu + $target_department_pays_fri + $target_department_pays_sat + $target_department_pays_sun;
											}
										}
										?>
										<tr>
											<td colspan="<?php echo $section_availabe_coloumn; ?>" class="bg-color-red">
												<?php echo $target_data->target_name; ?>
											</td>
											<td class="bg-color-red" colspan="4"><?php echo '£ '.number_format(($target_data->mon/100),2).' ('.number_format($target_department_pays_mon/($target_data->mon/100),2).'%)'; ?></td>
											<td class="bg-color-red" colspan="4"><?php echo '£ '.number_format(($target_data->tue/100),2).' ('.number_format($target_department_pays_tue/($target_data->tue/100),2).'%)'; ?></td>
											<td class="bg-color-red" colspan="4"><?php echo '£ '.number_format(($target_data->wed/100),2).' ('.number_format($target_department_pays_wed/($target_data->wed/100),2).'%)'; ?></td>
											<td class="bg-color-red" colspan="4"><?php echo '£ '.number_format(($target_data->thu/100),2).' ('.number_format($target_department_pays_thu/($target_data->thu/100),2).'%)'; ?></td>
											<td class="bg-color-red" colspan="4"><?php echo '£ '.number_format(($target_data->fri/100),2).' ('.number_format($target_department_pays_fri/($target_data->fri/100),2).'%)'; ?></td>
											<td class="bg-color-red" colspan="4"><?php echo '£ '.number_format(($target_data->sat/100),2).' ('.number_format($target_department_pays_sat/($target_data->sat/100),2).'%)'; ?></td>
											<td class="bg-color-red" colspan="4"><?php echo '£ '.number_format(($target_data->sun/100),2).' ('.number_format($target_department_pays_sun/($target_data->sun/100),2).'%)'; ?></td>
											<td class="bg-color-red" colspan="3"><?php echo '£ '.number_format(($total_of_target/100),2).' ('.number_format($target_total_of_department_pays/($total_of_target/100),2).'%)'; ?></td>
										</tr>
										<?php
									}
								}
							?>
							
							<tr class="top_header_rota">
								<td colspan="<?php echo $section_availabe_coloumn; ?>" class="bg-color-red">Actual Sales</td>
								<td colspan="4" class="bg-color-red mon_actual_vs_net" id="<?php echo $net_of_week['Monday'] ? $net_of_week['Monday'] : 0; ?>"></td>
								<td colspan="4" class="bg-color-red tue_actual_vs_net" id="<?php echo $net_of_week['Tuesday'] ? $net_of_week['Tuesday'] : 0; ?>"></td>
								<td colspan="4" class="bg-color-red wed_actual_vs_net" id="<?php echo $net_of_week['Wednesday'] ? $net_of_week['Wednesday'] : 0; ?>"></td>
								<td colspan="4" class="bg-color-red thu_actual_vs_net" id="<?php echo $net_of_week['Thursday'] ? $net_of_week['Thursday'] : 0; ?>"></td>
								<td colspan="4" class="bg-color-red fri_actual_vs_net" id="<?php echo $net_of_week['Friday'] ? $net_of_week['Friday'] : 0; ?>"></td>
								<td colspan="4" class="bg-color-red sat_actual_vs_net" id="<?php echo $net_of_week['Saturday'] ? $net_of_week['Saturday'] : 0; ?>"><input type="hidden"  id="sat_net"></td>
								<td colspan="4" class="bg-color-red sun_actual_vs_net" id="<?php echo $net_of_week['Sunday'] ? $net_of_week['Sunday'] : 0; ?>"></td>
								<td colspan="3" class="bg-color-red total_actual_vs_net" id="<?php echo $net_of_week['total_net'] ? $net_of_week['total_net'] : 0; ?>"></td>
							</tr>
							
							<?php if ($loggedInUser->checkPermission(array(15))){ ?>
							<tr class="top_header_rota">
								 <?php $ni_pension = 1+($ni+$pension)/100; ?>
								<td colspan="<?php echo $section_availabe_coloumn; ?>" class="bg-color-red">Total Pay
									<?php $ni_pension = 1+($ni+$pension)/100; ?></td>
								
								<td colspan="4" class="total_mon_pay  bg-color-red dept-pay-mon-<?php echo $all_data[$previous]->staff_dept_id; ?>"><?php echo '£ '.number_format(0,2); ?></td>
								
								<td colspan="4" class="total_tue_pay  bg-color-red dept-pay-tue-<?php echo $all_data[$previous]->staff_dept_id; ?>"><?php echo '£ '.number_format(0,2);  ?></td>
								
								<td colspan="4" class="total_wed_pay  bg-color-red dept-pay-wed-<?php echo $all_data[$previous]->staff_dept_id; ?>"><?php echo '£ '.number_format(0,2);  ?></td>
								
								<td colspan="4" class="total_thu_pay bg-color-red dept-pay-thu-<?php echo $all_data[$previous]->staff_dept_id; ?>"><?php echo '£ '.number_format(0,2);  ?></td>
								
								<td colspan="4" class="total_fri_pay  bg-color-red dept-pay-fri-<?php echo $all_data[$previous]->staff_dept_id; ?>"><?php echo '£ '.number_format(0,2);  ?></td>
								
								<td colspan="4" class="total_sat_pay  bg-color-red dept-pay-sat-<?php echo $all_data[$previous]->staff_dept_id; ?>"><?php echo '£ '.number_format(0,2);  ?></td>
								
								<td colspan="4" class="total_sun_pay  bg-color-red dept-pay-sun-<?php echo $all_data[$previous]->staff_dept_id; ?>"><?php echo '£ '.number_format(0,2);  ?></td>
								
								<td colspan="3" class="bg-color-red td-top-total-pay"></td>
							</tr><?php } ?>
							<?php if ($loggedInUser->checkPermission(array(15))){ ?>
							<tr class="top_header_rota">
								<td colspan="<?php echo $section_availabe_coloumn; ?>" class="bg-color-red">Holiday pay</td>
								<td colspan="4" class="bg-color-red">
									<?php
									if(isset($schedule_holiday['Monday']))
									{
									echo "£".number_format($schedule_holiday['Monday'],2);
									} else { echo "£0";}
									?></td>
								
								<td colspan="4" class="bg-color-red">
									<?php
									if(isset($schedule_holiday['Tuesday']))
									{
									echo "£".number_format($schedule_holiday['Tuesday'],2);
									} else { echo "£0";}
									?></td>
								
								<td colspan="4" class="bg-color-red">
									<?php
									if(isset($schedule_holiday['Wednesday']))
									{
									echo "£".number_format($schedule_holiday['Wednesday'],2);
									} else { echo "£0";}
									?></td>
								
								<td colspan="4" class="bg-color-red">
									<?php
									if(isset($schedule_holiday['Thursday']))
									{
									echo "£".number_format($schedule_holiday['Thursday'],2);
									} else { echo "£0";}
									?></td>
								
								<td colspan="4" class="bg-color-red">
									<?php
									if(isset($schedule_holiday['Friday']))
									{
									echo "£".number_format($schedule_holiday['Friday'],2);
									} else { echo "£0";}
									?></td>
								
								<td colspan="4" class="bg-color-red">
									<?php
									if(isset($schedule_holiday['Saturday']))
									{
									echo "£".number_format($schedule_holiday['Saturday'],2);
									} else { echo "£0";}
									?></td>
								
								<td colspan="4" class="bg-color-red">
									<?php
									if(isset($schedule_holiday['Sunday']))
									{
									echo "£".number_format($schedule_holiday['Sunday'],2);
									} else { echo "£0";}
									?></td>
								
								<td colspan="3" class="bg-color-red"><?php
									if(isset($schedule_holiday['Total']))
									{
									echo "£".number_format($schedule_holiday['Total'],2);
									} else { echo "£0";}
									?></td>
							</tr><?php } ?>
							
							<tr class="rota-notes top_header_rota">
								<td colspan="<?php echo $section_availabe_coloumn; ?>" class="bg-color-red">Notes</td>
								
								<td colspan="4" class="bg-color-red">
									<a id="<?php echo $monday = date('Y-m-d', strtotime($end_date. ' - 6 days')); ?>" onclick="open_rota_notes(this)"data-target="#modal-rota-notes" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i>
									<?php
									if(isset($schedule_notes['Monday']))
									{
									?>
										&nbsp;&nbsp;<i class="fa fa-file-text-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $schedule_notes['Monday']; ?>"></i>
									<?php
									}
									?>
									</a>
								</td>
								
								<td colspan="4" class="bg-color-red">
									<a id="<?php echo $tuesday = date('Y-m-d', strtotime($end_date. ' - 5 days')); ?>" onclick="open_rota_notes(this)"data-target="#modal-rota-notes" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i>
									<?php
									if(isset($schedule_notes['Tuesday']))
									{
									?>
										&nbsp;&nbsp;<i class="fa fa-file-text-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $schedule_notes['Tuesday']; ?>"></i>
									<?php
									}
									?>
									</a>
								</td>
								
								<td colspan="4" class="bg-color-red">
									<a id="<?php echo $wednesday = date('Y-m-d', strtotime($end_date. ' - 4 days')); ?>" onclick="open_rota_notes(this)"data-target="#modal-rota-notes" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i>
									<?php
									if(isset($schedule_notes['Wednesday']))
									{
									?>
										&nbsp;&nbsp;<i class="fa fa-file-text-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $schedule_notes['Wednesday']; ?>"></i>
									<?php
									}
									?>
									</a>
								</td>
								
								<td colspan="4" class="bg-color-red">
									<a id="<?php echo $thusday = date('Y-m-d', strtotime($end_date. ' - 3 days')); ?>" onclick="open_rota_notes(this)"data-target="#modal-rota-notes" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i>
									<?php
									if(isset($schedule_notes['Thursday']))
									{
									?>
										&nbsp;&nbsp;<i class="fa fa-file-text-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $schedule_notes['Thursday']; ?>"></i>
									<?php
									}
									?>
									</a>
								</td>
								
								<td colspan="4" class="bg-color-red">
									<a id="<?php echo $friday = date('Y-m-d', strtotime($end_date. ' - 2 days')); ?>"onclick="open_rota_notes(this)"data-target="#modal-rota-notes" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i>
									<?php
									if(isset($schedule_notes['Friday']))
									{
									?>
										&nbsp;&nbsp;<i class="fa fa-file-text-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $schedule_notes['Friday']; ?>"></i>
									<?php
									}
									?>
									</a>
								</td>
								
								<td colspan="4" class="bg-color-red">
									<a onclick="open_rota_notes(this)"data-target="#modal-rota-notes" data-toggle="modal" id="<?php echo $saturday = date('Y-m-d', strtotime($end_date. ' - 1 days')); ?>"><i class="fa fa-plus" aria-hidden="true"></i>
									<?php
									if(isset($schedule_notes['Saturday']))
									{
									?>
										&nbsp;&nbsp;<i class="fa fa-file-text-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $schedule_notes['Saturday']; ?>"></i>
									<?php
									}
									?>
									</a>
								</td>
								
								<td colspan="4" class="bg-color-red">
									<a onclick="open_rota_notes(this)"data-target="#modal-rota-notes" data-toggle="modal" id="<?php echo $end_date; ?>"><i class="fa fa-plus" aria-hidden="true" ></i>
									<?php
									if(isset($schedule_notes['Sunday']))
									{
									?>
										&nbsp;&nbsp;<i class="fa fa-file-text-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $schedule_notes['Sunday']; ?>"></i>
									<?php
									}
									?>
									</a>
								</td>
								
								
								
								<td colspan="3" class="bg-color-red"></td>
							</tr>
							<?php
							if($loggedInUser->checkPermission(array(90)))
							{
								$date_monday 	= date('Y-m-d',strtotime($end_date.' -6 days'));
								$date_tuesday 	= date('Y-m-d',strtotime($end_date.' -5 days'));
								$date_wednesday = date('Y-m-d',strtotime($end_date.' -4 days'));
								$date_thursday 	= date('Y-m-d',strtotime($end_date.' -3 days'));
								$date_friday 	= date('Y-m-d',strtotime($end_date.' -2 days'));
								$date_saturday 	= date('Y-m-d',strtotime($end_date.' -1 days'));
								$date_sunday 	= $end_date;
								?>
								<tr class="approve_clockinrota top_header_rota">
									<td colspan="<?php echo $section_availabe_coloumn; ?>" class="bg-color-red">Approved</td>
									
									<td colspan="4" class="bg-color-red">
										<?php echo isset($approve_clockinrota_all_dept['Monday']) ?  '<i class="si si-check"></i>' : '<a href="'.base_url().'rota_approval/'.$date_monday.'"><button class="label label-success">Approve</button></a>'; ?>
									</td>
									
									<td colspan="4" class="bg-color-red">
										<?php echo isset($approve_clockinrota_all_dept['Tuesday']) ?  '<i class="si si-check"></i>' : '<a href="'.base_url().'rota_approval/'.$date_tuesday.'"><button class="label label-success">Approve</button></a>'; ?>
									</td>
									
									<td colspan="4" class="bg-color-red">
										<?php echo isset($approve_clockinrota_all_dept['Wednesday']) ?  '<i class="si si-check"></i>' : '<a href="'.base_url().'rota_approval/'.$date_wednesday.'"><button class="label label-success">Approve</button></a>'; ?>
									</td>
									
									<td colspan="4" class="bg-color-red">
										<?php echo isset($approve_clockinrota_all_dept['Thursday']) ?  '<i class="si si-check"></i>' : '<a href="'.base_url().'rota_approval/'.$date_thursday.'"><button class="label label-success">Approve</button></a>'; ?>
									</td>
									
									<td colspan="4" class="bg-color-red">
										<?php echo isset($approve_clockinrota_all_dept['Friday']) ?  '<i class="si si-check"></i>' : '<a href="'.base_url().'rota_approval/'.$date_friday.'"><button class="label label-success">Approve</button></a>'; ?>
									</td>
									
									<td colspan="4" class="bg-color-red">
										<?php echo isset($approve_clockinrota_all_dept['Saturday']) ?  '<i class="si si-check"></i>' : '<a href="'.base_url().'rota_approval/'.$date_saturday.'"><button class="label label-success">Approve</button></a>'; ?>
									</td>
									
									<td colspan="4" class="bg-color-red">
										<?php echo isset($approve_clockinrota_all_dept['Sunday']) ?  '<i class="si si-check"></i>' : '<a href="'.base_url().'rota_approval/'.$date_sunday.'"><button class="label label-success">Approve</button></a>'; ?>
									</td>
									
									<td colspan="3" class="bg-color-red"></td>
								</tr>
							<?php
							}
							
							
							if($color_code_rota == 1)
							{
								?>
								<tr class="background-white">
									<th class="backgrond_light_y" >
										 <span><a data-target="#modal-shift-color-codes" data-toggle="modal">Add Shift Code</a></span>									
									</th>
									<th class="backgrond_light_y" colspan="100%">
										<?php 
										if(isset($get_shift_codes))
										{
											foreach($get_shift_codes as $shift_codes)
											{
												?>
												<div class="outer-shift-codes-buttons" style="background:<?php echo $shift_codes->color; ?>">
												<span class="shift-codes-buttons" onclick="select_shift_short_color(<?php echo $shift_codes->id.",'".$shift_codes->color."',this";?>)" style="background:<?php echo $shift_codes->color; ?>"><?php echo $shift_codes->name; ?></span>
												<span><a onclick="delete_shift_codes(<?php echo $shift_codes->id.",this";?>)"><i class="fa fa-times"></i></a></span>
												</div>
												<?php
											}
										}
										?>
									</th>
								</tr>
								<?php
							}

							if($active_rota_weather == 1)
							{
								?>
								<tr class="background-white weather_row">
									<th  class="backgrond_light_y" colspan="<?php echo $section_availabe_coloumn; ?>"></th>
									
									<th colspan="4" class="border_l backgrond_dark text-center" id="weather_monday"></th>
									<th colspan="4" class="border_l backgrond_light text-center" id="weather_tuesday"></th>
									<th colspan="4" class="border_l backgrond_dark text-center" id="weather_wednesday"></th>
									<th colspan="4" class="border_l backgrond_light text-center" id="weather_thursday"></th>
									<th colspan="4" class="border_l backgrond_dark text-center" id="weather_friday"></th>
									<th colspan="4" class="border_l backgrond_light text-center" id="weather_saturday"></th>
									<th colspan="4" class="border_l backgrond_dark text-center" id="weather_sunday"></th>
									<th class="border_l backgrond_dark text-center"></th>
									<th class="backgrond_light" colspan="2">
									</th>
								</tr>
								
								<?php
							}
							?>
							<tr class="background-white">
								<th  class="backgrond_light_y" colspan="<?php echo $section_availabe_coloumn; ?>"><strong><?php  echo $db_company_name;?></strong></th>
								
								<th colspan="4" class="border_l backgrond_dark text-center"><strong>Monday</strong><br><?php echo $monday = date('d-m-Y', strtotime($end_date. ' - 6 days')); ?><a href="<?php echo base_url();?>rota_daily_demo/<?php echo date('Y-m-d', strtotime($end_date. ' - 6 days'));?>"> (shift) </a><?php echo ($hourly_analysis == 1) ? '<br>( <a  data-toggle="modal" data-target="#modal-load_hourly_labour_analised" onclick="show_graph_of_day('."'".'mon'."'".')">Hourly</a> )' : ''; ?></th>
								<th colspan="4" class="border_l backgrond_light text-center"><strong>Tuesday</strong><br><?php echo $tuesday = date('d-m-Y', strtotime($end_date. ' - 5 days')); ?><a href="<?php echo base_url();?>rota_daily_demo/<?php echo date('Y-m-d', strtotime($end_date. ' - 5 days'));?>">(shift)</a><?php echo ($hourly_analysis == 1) ? '<br>( <a  data-toggle="modal" data-target="#modal-load_hourly_labour_analised"onclick="show_graph_of_day('."'".'tue'."'".')" >Hourly</a> )' : ''; ?></th>
								<th colspan="4" class="border_l backgrond_dark text-center"><strong>Wednesday</strong><br><?php echo $wednesday = date('d-m-Y', strtotime($end_date. ' - 4 days')); ?><a href="<?php echo base_url();?>rota_daily_demo/<?php echo date('Y-m-d', strtotime($end_date. ' - 4 days'));?>">(shift)</a><?php echo ($hourly_analysis == 1) ? '<br>( <a  data-toggle="modal" data-target="#modal-load_hourly_labour_analised" onclick="show_graph_of_day('."'".'wed'."'".')">Hourly</a> )' : ''; ?></th>
								<th colspan="4" class="border_l backgrond_light text-center"><strong>Thursday</strong><br><?php echo $thursday = date('d-m-Y', strtotime($end_date. ' - 3 days')); ?><a href="<?php echo base_url();?>rota_daily_demo/<?php echo date('Y-m-d', strtotime($end_date. ' - 3 days'));?>">(shift)</a><?php echo ($hourly_analysis == 1) ? '<br>( <a  data-toggle="modal" data-target="#modal-load_hourly_labour_analised" onclick="show_graph_of_day('."'".'thu'."'".')">Hourly</a> )' : ''; ?></th>
								<th colspan="4" class="border_l backgrond_dark text-center"><strong>Friday</strong><br><?php echo $friday = date('d-m-Y', strtotime($end_date. ' - 2 days')); ?><a href="<?php echo base_url();?>rota_daily_demo/<?php echo date('Y-m-d', strtotime($end_date. ' - 2 days'));?>">(shift)</a><?php echo ($hourly_analysis == 1) ? '<br>( <a  data-toggle="modal" data-target="#modal-load_hourly_labour_analised" onclick="show_graph_of_day('."'".'fri'."'".')">Hourly</a> )' : ''; ?></th>
								<th colspan="4" class="border_l backgrond_light text-center"><strong>Saturday</strong><br><?php echo $saturday = date('d-m-Y', strtotime($end_date. ' - 1 days')); ?><a href="<?php echo base_url();?>rota_daily_demo/<?php echo date('Y-m-d', strtotime($end_date. ' - 1 days'));?>">(shift)</a><?php echo ($hourly_analysis == 1) ? '<br>( <a  data-toggle="modal" data-target="#modal-load_hourly_labour_analised" onclick="show_graph_of_day('."'".'sat'."'".')">Hourly</a> )' : ''; ?></th>
								<th colspan="4" class="border_l backgrond_dark text-center"><strong>Sunday</strong><br><?php echo $sunday = date('d-m-Y', strtotime($end_date)); ?><a href="<?php echo base_url();?>rota_daily_demo/<?php echo $end_date;?>"> (shift)</a><?php echo ($hourly_analysis == 1) ? '<br>( <a  data-toggle="modal" data-target="#modal-load_hourly_labour_analised" onclick="show_graph_of_day('."'".'sun'."'".')">Hourly</a> )' : ''; ?></th>
								<th class="backgrond_light">
								<!--
									<a class="pull-right"><i class="si si-size-fullscreen"></i></a>
								-->	 
									<a class="icon-header-rota hiddder-top" onclick="display_top_header_data(this)" ><i class="si si-frame"></i></a>
								</th>
								<th class="backgrond_light" colspan="2">
									<a class="icon-header-rota freeze-header" onclick="fixed_rota_header(this.id,this)" id="1"><img src="<?php echo base_url().'assets/img/favicons/freeze.png'; ?>"></a>
								</th>
							</tr>
										
							<tr class="background-white">
								<th class="backgrond_light_y">Full Name</th>
								<?php
								if($section_availabe_coloumn == 2)
								{
									// if section have the add section coloumn
									?>
									<th class="backgrond_light_y">Section</th>
									<?php
								}
								?>
								
								<!--  Day Mon-->
								<th class="backgrond_dark">Start</th>
								<th class="backgrond_dark">End</th>
								<th class="backgrond_dark">Start</th>
								<th class="backgrond_dark">End</th>
								
								<!--  Day Tue-->
								<th class="backgrond_light">Start</th>
								<th class="backgrond_light">End</th>
								<th class="backgrond_light">Start</th>
								<th class="backgrond_light">End</th>
										
								<!--  Day wed-->
								<th class="backgrond_dark">Start</th>
								<th class="backgrond_dark">End</th>
								<th class="backgrond_dark">Start</th>
								<th class="backgrond_dark">End</th>
										
								<!--  Day thrus-->
								<th class="backgrond_light">Start</th>
								<th class="backgrond_light">End</th>
								<th class="backgrond_light">Start</th>
								<th class="backgrond_light">End</th>
											
								<!--  Day Fri-->
								<th class="backgrond_dark">Start</th>
								<th class="backgrond_dark">End</th>
								<th class="backgrond_dark">Start</th>
								<th class="backgrond_dark">End</th>
											
								<!--  Day Sat-->
								<th class="backgrond_light">Start</th>
								<th class="backgrond_light">End</th>
								<th class="backgrond_light">Start</th>
								<th class="backgrond_light">End</th>
											
								<!--  Day Sun-->
								<th class="backgrond_dark">Start</th>
								<th class="backgrond_dark">End</th>
								<th class="backgrond_dark">Start</th>
								<th class="backgrond_dark">End</th>
										
								<!-- Hours -->
								<th class="backgrond_light">Hours</th>
								
								<!-- Total Hours -->
								<th class="backgrond_light">Total</th>
								<?php
								if ($loggedInUser->checkPermission(array(15)))
								{
								?>
								<th class="backgrond_light">Pays</th>
								<?php
								}
								?>
							</tr>
							<!--<tr>
									<th colspan="30" class="department">Department</th>
								</tr>-->
						</thead>
						</tbody>
						<?php
							// if (empty($all_data)) {
								// echo '<a class = "add_staff_by_section" href = "'.base_url() .'staff/add/'.$section_id.'">ADD STAFF</a>';
								// echo "<br>";
								// echo "<br>";
							// }
								
							$row_span = 0;
							foreach($all_data as $key => $row_data)
								{
									// Controller part 
									
								$readonly_class = '';
								if(isset($restriction))
								{
									if($restriction['read'][$row_data->staff_dept_id] == 0 && $restriction['write'][$row_data->staff_dept_id] == 0)
									{
										$readonly_class = 'readonly_class_active';
									}
								}
						?>
						<!-- Show Deptartment sum pay value  #990000-->
						<?php
							$previous = $key - 1;
							$next_dept = $key + 1;
							$mon_hour  = 0;
							$last_row_dept_id = $all_data[$key]->staff_dept_id;
							if(($all_data[$key]->staff_dept_id != $all_data[$previous]->staff_dept_id) && $previous >= 0 )
							{
								$mon_hour +=$pay_value_dept[$all_data[$previous]->staff_dept_id]['mon_hours'];
								
								$readonly_class_pay_hr = '';
								if(isset($restriction))
								{
									if($restriction['read'][$all_data[$previous]->staff_dept_id] == 0 && $restriction['write'][$all_data[$previous]->staff_dept_id] == 0)
									{
										$readonly_class_pay_hr = 'readonly_class_active';
									}
								}
						if($readonly_class_pay_hr != 'readonly_class_active')
						{
						?>
						
						<tr class="tr-dept-hours-<?php echo $key;?> cal_hours" >
							<td colspan="<?php echo $section_availabe_coloumn; ?>" class="bg-color-red">Hour</td>
							<?php
							// compare rota hours to forecast rota hours monday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['mon_hours'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['mon_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="mon_hours bg-color-red dept-hours-mon-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$all_data[$previous]->staff_dept_id]['mon_hours'] ? $pay_value_dept[$all_data[$previous]->staff_dept_id]['mon_hours'] : 0; ?></td>
							
							
							<?php
							// compare rota hours to forecast rota Tuesday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['tue_hours'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['tue_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="tue_hours bg-color-red dept-hours-tue-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$all_data[$previous]->staff_dept_id]['tue_hours'] ? $pay_value_dept[$all_data[$previous]->staff_dept_id]['tue_hours'] : 0; ?></td>
							
							<?php
							// compare rota hours to forecast rota Wednesday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['wed_hours'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['wed_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="wed_hours bg-color-red dept-hours-wed-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$all_data[$previous]->staff_dept_id]['wed_hours'] ? $pay_value_dept[$all_data[$previous]->staff_dept_id]['wed_hours'] : 0; ?></td>
							
							<?php
							// compare rota hours to forecast rota Thusday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['thu_hours'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['thu_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="thu_hours bg-color-red dept-hours-thu-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$all_data[$previous]->staff_dept_id]['thu_hours'] ? $pay_value_dept[$all_data[$previous]->staff_dept_id]['thu_hours'] : 0; ?></td>
							
							<?php
							// compare rota hours to forecast rota Friday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['fri_hours'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['fri_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="fri_hours bg-color-red dept-hours-fri-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$all_data[$previous]->staff_dept_id]['fri_hours'] ? $pay_value_dept[$all_data[$previous]->staff_dept_id]['fri_hours'] : 0; ?></td>
							
							<?php
							// compare rota hours to forecast rota Saturday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['sat_hours'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['sat_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="sat_hours bg-color-red dept-hours-sat-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$all_data[$previous]->staff_dept_id]['sat_hours'] ? $pay_value_dept[$all_data[$previous]->staff_dept_id]['sat_hours'] : 0; ?></td>
							
							<?php
							// compare rota hours to forecast rota Sunday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['sun_hours'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['sun_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="sun_hours bg-color-red dept-hours-sun-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$all_data[$previous]->staff_dept_id]['sun_hours'] ? $pay_value_dept[$all_data[$previous]->staff_dept_id]['sun_hours'] : 0; ?></td>
							
							<td colspan="3" class="bg-color-red td-total-dept-hours"></td>
						</tr>
						<?php
						}
						if ($loggedInUser->checkPermission(array(15))){
						if($readonly_class_pay_hr != 'readonly_class_active')
						{
						?>
						<tr class="tr-dept-pay-<?php echo $key;?> cal_pay">
							<td colspan="<?php echo $section_availabe_coloumn; ?>" class="bg-color-red">Pay</td>
							
							<?php
							// compare rota pay to forecast rota Monday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['sum_monpay'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_monpay'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="mon_pay bg-color-red dept-pay-mon-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format($pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_monpay']/100,2); ?></td>
							
							<?php
							// compare rota pay to forecast rota Tuesday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['sum_tuepay'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_tuepay'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="tue_pay bg-color-red dept-pay-tue-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format($pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_tuepay']/100,2); ?></td>
							
							<?php
							// compare rota pay to forecast rota Wednesday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['sum_wedpay'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_wedpay'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="wed_pay bg-color-red dept-pay-wed-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format($pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_wedpay']/100,2); ?></td>
							
							<?php
							// compare rota pay to forecast rota Thusday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['sum_thupay'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_thupay'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="thu_pay bg-color-red dept-pay-thu-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format($pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_thupay']/100,2); ?></td>
							
							<?php
							// compare rota pay to forecast rota Friday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['sum_fripay'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_fripay'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="fri_pay bg-color-red dept-pay-fri-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format($pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_fripay']/100,2); ?></td>
							
							<?php
							// compare rota pay to forecast rota Saturday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['sum_satpay'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_satpay'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="sat_pay bg-color-red dept-pay-sat-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format($pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_satpay']/100,2); ?></td>
							
							<?php
							// compare rota pay to forecast rota Saturday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$all_data[$previous]->staff_dept_id]['sum_sunpay'] != $pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_sunpay'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="sun_pay bg-color-red dept-pay-sun-<?php echo $all_data[$previous]->staff_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format($pay_value_dept[$all_data[$previous]->staff_dept_id]['sum_sunpay']/100,2); ?></td>
							<td colspan="3" class="bg-color-red td-total-dept-pay"></td>
						</tr>
						<?php } } }
						//Show Deptartment name #990000-->
						if($all_data[$key]->dept_name == $all_data[$previous]->dept_name)
							{   } else {
							if($readonly_class != 'readonly_class_active')
							{
						?>
						<tr>
							<td colspan="100%" class="bg-color-orange"><?php echo $row_data->dept_name; ?><span class="pull-right"><?php echo (isset($approved_departments[$row_data->staff_dept_id]) && $approved_departments[$row_data->staff_dept_id] == 1) ? '<i class="fa fa-check-circle-o"></i> Published &nbsp;' : ''; echo (isset($get_payroll_approved) && in_array($row_data->staff_dept_id,$get_payroll_approved)) ? '<i class="fa fa-check-circle-o"></i> Approved &nbsp;' : ''?></span></td>
						</tr>
							<?php } }
						
						// Add class on tr
						$readonly_class = '';
						$readonly_restrictions = '';
							if(isset($restriction))
							{
								if($restriction['read'][$row_data->staff_dept_id] == 0 && $restriction['write'][$row_data->staff_dept_id] == 0)
									{
										$readonly_class = 'readonly_class_active';
									}
									if($restriction['write'][$row_data->staff_dept_id] == 0)
									{
										$readonly_restrictions = 'readonly_restrictions';
									}
							}
							
							if(isset($get_payroll_approved) && in_array($row_data->staff_dept_id,$get_payroll_approved))
							{
								$readonly_restrictions = 'readonly_restrictions';
							}
						?>
                        <!-- Show Deptartment Staff data -->
                        <?php							
								$next_minus_one = $key - 1;
								$rowspan_data 	= $staff_count_per_dept[$all_data[$key]->staff_id];
						?>
						<?php
						if($readonly_class != 'readonly_class_active')
						{
								if($all_data[$key]->staff_id == $all_data[$next_minus_one]->staff_id)
									{ 
								
						?>
                        <tr class="num <?php echo $readonly_restrictions; ?>">
                        <?php 	}	else   {  ?>
                         <tr class="num <?php echo $readonly_restrictions; ?>" style="border-style: solid;border-bottom: thin double #ff0000;"> 
                         <?php } 
						 if($all_data[$key]->staff_id == $all_data[$next_minus_one]->staff_id)
							{   }  else  {
						?>
							<td class="backgrond_light_y first-child" rowspan="<?php echo $rowspan_data; ?>" onmousedown="staff_mousedown_context(this)">
								<a href="<?php echo base_url().'staff/edit/'.$row_data->staff_id;?>"><?php $full_name = $row_data->firstname.' '.$row_data->surname; echo substr($full_name ,0,16);  ?></a>
								<?php if($row_data->staff_on_rota == '0'){ ?><a href = "<?php echo base_url().'staff/remove_rota/'.$end_date.'/3/'.$row_data->staff_id;?>" title = "Remove From Rota"><i class="fa fa-times"></i></a><?php } ?>
							</td>
						<?php   }  ?>
									
						<?php
						if($section_availabe_coloumn == 2)
						{
							// if section available then show section coloumn
						?>
						<td class="backgrond_light_y"><span data-toggle="tooltip" data-placement="bottom" title="" type="button" data-original-title="<?php echo $row_data->section_title; ?>">
															
															
															<?php echo substr($row_data->section_title,0,6);?></span>
						</td>
						<?php 
						}
						?>						
						<!--  Monday Data -->
									
						<?php
							$monday = date('Y-m-d', strtotime($end_date. ' - 6 days'));
							$holiday_class = '';
							$sick_day_class = '';
							$show_popover_1 = '';
							$show_popover_2 = '';
							if(isset($staff_holiday_date_range[$row_data->staff_id][0]))
							{
								if(in_array($monday,$staff_holiday_date_range[$row_data->staff_id][0]))
									{
										$holiday_class= 'active_holiday_approved';
										$show_popover_1 = '';
										$show_popover_2 = '';
										
									}
							}
							if(isset($staff_holiday_date_range[$row_data->staff_id][1]))
							{
								if(in_array($monday,$staff_holiday_date_range[$row_data->staff_id][1]))
									{
										$holiday_class= 'active_holiday_unapproved';
										$show_popover_1 = '<span rel="replace">';
										$show_popover_2 = '</span>';
									}
							}
							
							// for Sick day monday
							$sick_day_class = '';
							if(isset($staff_sick_date_range[$row_data->staff_id]))
							{
								if(in_array($monday,$staff_sick_date_range[$row_data->staff_id]))
								{
									$sick_day_class= ' approved_sick_holiday';
								}
							}
							
							//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['mon_shift1'])
							{
								$different_from_forecast = ' different_from_forecast';
							}	
							
							
							$clockinstatus = '';
							if(isset($clock_in_working) && $clock_in_working[$row_data->staff_id]['Monday'] == 'working')
							{
								$clockinstatus = ' clockinout_working';
							}
							
							$class_day_off = '';
							if(isset($staff_day_off_data[$row_data->staff_id]['Monday']))
							{
								$class_day_off = ' day_off_requested';
							}

							$tooltip_content = isset($approve_clockinrota['Monday'][$row_data->staff_dept_id]) ? 'data-toggle="tooltip" data-original-title="Approved"  data-placement="top" readonly' : '';
						?>
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="mon_start_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->monstart >= '00:00:00' && $row_data->monstart!= $row_data->monend) ? date('H:i', strtotime($row_data->monstart)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="mon_end_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->monend >= '00:00:00' && $row_data->monstart!= $row_data->monend) ? date('H:i', strtotime($row_data->monend)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)"  <?php echo $tooltip_content; ?>/></td>
						
						<?php
							//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['mon_shift2'])
							{
								$different_from_forecast = ' different_from_forecast';
							}							
						?>
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="mon_start2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->monstart2 >= '00:00:00' && $row_data->monstart2!= $row_data->monend2) ? date('H:i', strtotime($row_data->monstart2)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)"  <?php echo $tooltip_content; ?> /></td>
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="mon_end2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->monend2 >= '00:00:00' && $row_data->monstart2!= $row_data->monend2) ? date('H:i', strtotime($row_data->monend2)) : ''; ?>"  maxlength="5" onmousedown="set_holiday_event(event,this)"  <?php echo $tooltip_content; ?> /></td>
												
						<!--  Tuesday Data -->
						<?php
							$tuesday = date('Y-m-d', strtotime($end_date. ' - 5 days'));
							$holiday_class = '';
							$show_popover_1 = '';
							$show_popover_2 = '';
							if(isset($staff_holiday_date_range[$row_data->staff_id][0]))
							{
									if(in_array($tuesday,$staff_holiday_date_range[$row_data->staff_id][0]))
									{
										$holiday_class= 'active_holiday_approved';
									}
							}
									
							if(isset($staff_holiday_date_range[$row_data->staff_id][1]))
							{
									if(in_array($tuesday,$staff_holiday_date_range[$row_data->staff_id][1]))
									{
										$holiday_class= 'active_holiday_unapproved';
										$show_popover_1 = '<span rel="replace">';
										$show_popover_2 = '</span>';
									}
							}
								
							// for Sick day tuesday
							$sick_day_class = '';
							if(isset($staff_sick_date_range[$row_data->staff_id]))
							{
								if(in_array($tuesday,$staff_sick_date_range[$row_data->staff_id]))
								{
									$sick_day_class= ' approved_sick_holiday';
								}
							}
							
							$class_day_off = '';
							if(isset($staff_day_off_data[$row_data->staff_id]['Tuesday']))
							{
								$class_day_off = ' day_off_requested';
							}	
							//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['tue_shift1'])
							{
								$different_from_forecast = ' different_from_forecast';
							}
							
							$clockinstatus = '';
							if(isset($clock_in_working) && $clock_in_working[$row_data->staff_id]['Tuesday'] == 'working')
							{
								$clockinstatus = ' clockinout_working';
							}

							$tooltip_content = isset($approve_clockinrota['Tuesday'][$row_data->staff_dept_id]) ? 'data-toggle="tooltip" data-original-title="Approved"  data-placement="top" readonly' : '';
						?>		
						
						
						<td contenteditable class="backgrond_light <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="tue_start_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->tuestart >= '00:00:00' && $row_data->tuestart!= $row_data->tueend) ? date('H:i', strtotime($row_data->tuestart)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?>  /></td>
						
						<td contenteditable class="backgrond_light <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="tue_end_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->tueend >= '00:00:00' && $row_data->tuestart!= $row_data->tueend) ? date('H:i', strtotime($row_data->tueend)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<?php
						//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['tue_shift2'])
							{
								$different_from_forecast = ' different_from_forecast';
							}							
						?>	
						<td contenteditable class="backgrond_light <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="tue_start2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->tuestart2 >= '00:00:00' && $row_data->tuestart2!= $row_data->tueend2) ? date('H:i', strtotime($row_data->tuestart2)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?>  /></td>
						
						<td contenteditable class="backgrond_light <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="tue_end2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->tueend2 >= '00:00:00' && $row_data->tuestart2!= $row_data->tueend2) ? date('H:i', strtotime($row_data->tueend2)) : ''; ?>"  maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?>  /></td>
												
						<!--  Wednesday Data -->
						<?php
							$wednesday = date('Y-m-d', strtotime($end_date. ' - 4 days'));
							$holiday_class = '';
							$show_popover_1 = '';
							$show_popover_2 = '';
							if(isset($staff_holiday_date_range[$row_data->staff_id][0]))
								{
									if(in_array($wednesday,$staff_holiday_date_range[$row_data->staff_id][0]))
										{
											$holiday_class= 'active_holiday_approved';
										}
								}
									
							if(isset($staff_holiday_date_range[$row_data->staff_id][1]))
								{
									if(in_array($wednesday,$staff_holiday_date_range[$row_data->staff_id][1]))
									{
										$holiday_class= 'active_holiday_unapproved';
										$show_popover_1 = '<span rel="replace">';
										$show_popover_2 = '</span>';
									}
								}
							
						// for Sick day wednesday
							$sick_day_class = '';
							if(isset($staff_sick_date_range[$row_data->staff_id]))
							{
								if(in_array($wednesday,$staff_sick_date_range[$row_data->staff_id]))
								{
									$sick_day_class= ' approved_sick_holiday';
								}
							}		
							
							$class_day_off = '';
							if(isset($staff_day_off_data[$row_data->staff_id]['Wednesday']))
							{
								$class_day_off = ' day_off_requested';
							}						
						//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['wed_shift1'])
							{
								$different_from_forecast = ' different_from_forecast';
							}	
							
							$clockinstatus = '';
							if(isset($clock_in_working) && $clock_in_working[$row_data->staff_id]['Wednesday'] == 'working')
							{
								$clockinstatus = ' clockinout_working';
							}

							$tooltip_content = isset($approve_clockinrota['Wednesday'][$row_data->staff_dept_id]) ? 'data-toggle="tooltip" data-original-title="Approved"  data-placement="top" readonly' : '';
						?>			
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="wed_start_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->wedstart >= '00:00:00' && $row_data->wedstart!= $row_data->wedend) ? date('H:i', strtotime($row_data->wedstart)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="wed_end_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->wedend >= '00:00:00' && $row_data->wedstart!= $row_data->wedend) ? date('H:i', strtotime($row_data->wedend)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<?php
						//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['wed_shift2'])
							{
								$different_from_forecast = ' different_from_forecast';
							}							
						?>
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="wed_start2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->wedstart2 >= '00:00:00' && $row_data->wedstart2!= $row_data->wedend2) ? date('H:i', strtotime($row_data->wedstart2)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="wed_end2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->wedend2 >= '00:00:00' && $row_data->wedstart2!= $row_data->wedend2) ? date('H:i', strtotime($row_data->wedend2)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
												
						<!--  Thrusday Data -->
						<?php
							$thrusday = date('Y-m-d', strtotime($end_date. ' - 3 days'));
							$holiday_class = '';
							$show_popover_1 = '';
							$show_popover_2 = '';
							if(isset($staff_holiday_date_range[$row_data->staff_id][0]))
								{
									if(in_array($thrusday,$staff_holiday_date_range[$row_data->staff_id][0]))
										{
											$holiday_class= 'active_holiday_approved';
										}
								}
							
							if(isset($staff_holiday_date_range[$row_data->staff_id][1]))
								{
									if(in_array($thrusday,$staff_holiday_date_range[$row_data->staff_id][1]))
										{
											$holiday_class= 'active_holiday_unapproved';
											$show_popover_1 = '<span rel="replace">';
											$show_popover_2 = '</span>';
										}
								}
								
							// for Sick day thursday
							$sick_day_class = '';
							if(isset($staff_sick_date_range[$row_data->staff_id]))
							{
								if(in_array($thrusday,$staff_sick_date_range[$row_data->staff_id]))
								{
									$sick_day_class= ' approved_sick_holiday';
								}
							}
						//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['thu_shift1'])
							{
								$different_from_forecast = ' different_from_forecast';
							}	

							$clockinstatus = '';
							if(isset($clock_in_working) && $clock_in_working[$row_data->staff_id]['Thursday'] == 'working')
							{
								$clockinstatus = ' clockinout_working';
							}
							
							$class_day_off = '';
							if(isset($staff_day_off_data[$row_data->staff_id]['Thursday']))
							{
								$class_day_off = ' day_off_requested';
							}	

							$tooltip_content = isset($approve_clockinrota['Thursday'][$row_data->staff_dept_id]) ? 'data-toggle="tooltip" data-original-title="Approved"  data-placement="top" readonly' : '';
						?>
									
									
						<td contenteditable class="backgrond_light <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="thu_start_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->thustart >= '00:00:00' && $row_data->thustart!= $row_data->thuend) ? date('H:i', strtotime($row_data->thustart)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<td contenteditable class="backgrond_light <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="thu_end_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->thuend >= '00:00:00' && $row_data->thustart!= $row_data->thuend) ? date('H:i', strtotime($row_data->thuend)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<?php
						//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['thu_shift2'])
							{
								$different_from_forecast = ' different_from_forecast';
							}							
						?>
						
						<td contenteditable class="backgrond_light <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="thu_start2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->thustart2 >= '00:00:00' && $row_data->thustart2!= $row_data->thuend2) ? date('H:i', strtotime($row_data->thustart2)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<td contenteditable class="backgrond_light <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="thu_end2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->thuend2 >= '00:00:00' && $row_data->thustart2!= $row_data->thuend2) ? date('H:i', strtotime($row_data->thuend2)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
												
						<!--  Friday Data -->
						<?php
							$friday = date('Y-m-d', strtotime($end_date. ' - 2 days'));
							$holiday_class = '';
							$show_popover_1 = '';
							$show_popover_2 = '';
							if(isset($staff_holiday_date_range[$row_data->staff_id][0]))
							{
								if(in_array($friday,$staff_holiday_date_range[$row_data->staff_id][0]))
								{
									$holiday_class= 'active_holiday_approved';
								}
							}
									
							if(isset($staff_holiday_date_range[$row_data->staff_id][1]))
							{
								if(in_array($friday,$staff_holiday_date_range[$row_data->staff_id][1]))
								{
									$holiday_class= 'active_holiday_unapproved';
									$show_popover_1 = '<span rel="replace">';
									$show_popover_2 = '</span>';
								}
							}
							
							// for Sick day friday
							$sick_day_class = '';
							if(isset($staff_sick_date_range[$row_data->staff_id]))
							{
								if(in_array($friday,$staff_sick_date_range[$row_data->staff_id]))
								{
									$sick_day_class= ' approved_sick_holiday';
								}
							}
							
							//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['fri_shift1'])
							{
								$different_from_forecast = ' different_from_forecast';
							}
							
							$clockinstatus = '';
							if(isset($clock_in_working) && $clock_in_working[$row_data->staff_id]['Friday'] == 'working')
							{
								$clockinstatus = ' clockinout_working';
							}
							
							$class_day_off = '';
							if(isset($staff_day_off_data[$row_data->staff_id]['Friday']))
							{
								$class_day_off = ' day_off_requested';
							}

							$tooltip_content = isset($approve_clockinrota['Friday'][$row_data->staff_dept_id]) ? 'data-toggle="tooltip" data-original-title="Approved"  data-placement="top" readonly' : '';
									
						?>
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="fri_start_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->fristart >= '00:00:00' && $row_data->fristart!= $row_data->friend) ? date('H:i', strtotime($row_data->fristart)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?>  /></td>
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="fri_end_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->friend >= '00:00:00' && $row_data->fristart!= $row_data->friend) ? date('H:i', strtotime($row_data->friend)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?>  /></td>
						
						<?php
							//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['fri_shift2'])
							{
								$different_from_forecast = ' different_from_forecast';
							}
						?>
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="fri_start2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->fristart2 >= '00:00:00' && $row_data->fristart2!= $row_data->friend2) ? date('H:i', strtotime($row_data->fristart2)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?>  /></td>
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="fri_end2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->friend2 >= '00:00:00' && $row_data->fristart2!= $row_data->friend2) ? date('H:i', strtotime($row_data->friend2)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?>  /></td>

						<!--  Saturday Data -->
						<?php
							$saturday = date('Y-m-d', strtotime($end_date. ' - 1 days'));
							$holiday_class = '';
							$show_popover_1 = '';
							$show_popover_2 = '';
							if(isset($staff_holiday_date_range[$row_data->staff_id][0]))
							{
								if(in_array($saturday,$staff_holiday_date_range[$row_data->staff_id][0]))
								{
									$holiday_class= 'active_holiday_approved';
								}
							}
									
							if(isset($staff_holiday_date_range[$row_data->staff_id][1]))
							{
								if(in_array($saturday,$staff_holiday_date_range[$row_data->staff_id][1]))
								{
									$holiday_class= 'active_holiday_unapproved';
									$show_popover_1 = '<span rel="replace">';
									$show_popover_2 = '</span>';
								}
							}
							
							$sick_day_class = '';
							// for Sick day Saturday
							if(isset($staff_sick_date_range[$row_data->staff_id]))
							{
								if(in_array($saturday,$staff_sick_date_range[$row_data->staff_id]))
								{
									$sick_day_class= ' approved_sick_holiday';
								}
							}
								
							//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['sat_shift1'])
							{
								$different_from_forecast = ' different_from_forecast';
							}
							
							$clockinstatus = '';
							if(isset($clock_in_working) && $clock_in_working[$row_data->staff_id]['Saturday'] == 'working')
							{
								$clockinstatus = ' clockinout_working';
							}
							
							$class_day_off = '';
							if(isset($staff_day_off_data[$row_data->staff_id]['Saturday']))
							{
								$class_day_off = ' day_off_requested';
							}

							$tooltip_content = isset($approve_clockinrota['Saturday'][$row_data->staff_dept_id]) ? 'data-toggle="tooltip" data-original-title="Approved"  data-placement="top" readonly' : '';
						?>
									
						<td contenteditable class="backgrond_light <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="sat_start_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->satstart >= '00:00:00' && $row_data->satstart!= $row_data->satend) ? date('H:i', strtotime($row_data->satstart)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<td contenteditable class="backgrond_light <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="sat_end_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->satend >= '00:00:00' && $row_data->satstart!= $row_data->satend) ? date('H:i', strtotime($row_data->satend)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<?php
							//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['sat_shift2'])
							{
								$different_from_forecast = ' different_from_forecast';
							}
						?>
						<td contenteditable class="backgrond_light <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="sat_start2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->satstart2 >= '00:00:00' && $row_data->satstart2!= $row_data->satend2) ? date('H:i', strtotime($row_data->satstart2)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<td contenteditable class="backgrond_light <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="sat_end2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->satend2 >= '00:00:00' && $row_data->satstart2!= $row_data->satend2) ? date('H:i', strtotime($row_data->satend2)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
												
						<!--  Sunday Data -->
						<?php
							$sunday = $end_date;
							$holiday_class = '';
							$show_popover_1 = '';
							$show_popover_2 = '';
							if(isset($staff_holiday_date_range[$row_data->staff_id][0]))
							{
								if(in_array($sunday,$staff_holiday_date_range[$row_data->staff_id][0]))
									{
										$holiday_class= 'active_holiday_approved';
									}
							}
									
							if(isset($staff_holiday_date_range[$row_data->staff_id][1]))
							{
								if(in_array($sunday,$staff_holiday_date_range[$row_data->staff_id][1]))
									{
										$holiday_class= 'active_holiday_unapproved';
										$show_popover_1 = '<span rel="replace">';
										$show_popover_2 = '</span>';
									}
							}
							
						// for Sick day sunday
							$sick_day_class = '';
							if(isset($staff_sick_date_range[$row_data->staff_id]))
							{
								if(in_array($sunday,$staff_sick_date_range[$row_data->staff_id]))
								{
									$sick_day_class= ' approved_sick_holiday';
								}
							}							
							//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['sun_shift1'])
							{
								$different_from_forecast = ' different_from_forecast';
							}
							
							$clockinstatus = '';
							if(isset($clock_in_working) && $clock_in_working[$row_data->staff_id]['Sunday'] == 'working')
							{
								$clockinstatus = ' clockinout_working';
							}
							
							$class_day_off = '';
							if(isset($staff_day_off_data[$row_data->staff_id]['Sunday']))
							{
								$class_day_off = ' day_off_requested';
							}

							$tooltip_content = isset($approve_clockinrota['Sunday'][$row_data->staff_dept_id]) ? 'data-toggle="tooltip" data-original-title="Approved"  data-placement="top" readonly' : '';
									
						?>
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="sun_start_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->sunstart >= '00:00:00' && $row_data->sunstart!= $row_data->sunend) ? date('H:i', strtotime($row_data->sunstart)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="sun_end_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->sunend >= '00:00:00' && $row_data->sunstart!= $row_data->sunend) ? date('H:i', strtotime($row_data->sunend)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<?php
							//	For comparing with forecate Rota
							$different_from_forecast = '';
							if($forecast_rota_data[$row_data->staff_id][$row_data->section_idd]['sun_shift2'])
							{
								$different_from_forecast = ' different_from_forecast';
							}
									
						?>
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="sun_start2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->sunstart2 >= '00:00:00' && $row_data->sunstart2!= $row_data->sunend2) ? date('H:i', strtotime($row_data->sunstart2)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
						
						<td contenteditable class="backgrond_dark <?php echo $holiday_class.$different_from_forecast.$sick_day_class.$clockinstatus.$class_day_off; ?>"><input id="sun_end2_<?php echo $row_data->staff_id; ?>_<?php echo $row_data->section_idd;?>" value="<?php echo ($row_data->sunend2 >= '00:00:00' && $row_data->sunstart2!= $row_data->sunend2) ? date('H:i', strtotime($row_data->sunend2)) : ''; ?>" maxlength="5" onmousedown="set_holiday_event(event,this)" <?php echo $tooltip_content; ?> /></td>
												
						<!-- Hours -->
						<td id="hours_<?php echo $row_data->staff_id; ?>_<?php  echo $row_data->section_idd;?>" class="backgrond_light"> <?php echo $row_data->hours > 0 ? number_format($row_data->hours,1) : '--'; ?></td>
						
						<!-- Total Hours -->
						<?php
							if($all_data[$key]->staff_id == $all_data[$next_minus_one]->staff_id)
							{   }   else  {
						?>
						<td id="total_hours_<?php echo $row_data->staff_id; ?>_<?php  echo $row_data->section_idd;?>" rowspan="<?php echo $rowspan_data; ?>" class="backgrond_light total_hours_cal-<?php echo $row_data->staff_id;?>" data-original-title="" data-toggle="tooltip" data-placement="top" > <?php echo isset($staff_sum_hours[$row_data->staff_id]) ? number_format($staff_sum_hours[$row_data->staff_id],1) : '--' ; ?></td>
						<?php
						if ($loggedInUser->checkPermission(array(15)))
						{
							?>
							<td id="total_pay_individual_staff-<?php echo $row_data->staff_id; ?>" rowspan="<?php echo $rowspan_data; ?>" class="backgrond_light pay-individual-staff" data-original-title="" data-toggle="tooltip" data-placement="top"></td>
							<?php
						}
						
						  }  ?>
					</tr>
						<?php }     }  ?>
								
								
						<!--------Last row dept pay calculation-------->
						<?php
						
						$readonly_class = '';
						if(isset($restriction))
						{
							if($restriction['read'][$last_row_dept_id] == 0 && $restriction['write'][$last_row_dept_id] == 0)
								{
									$readonly_class = 'readonly_class_active';
								}
						}
						
						if($readonly_class != 'readonly_class_active')
						{
						
						?>
						<tr class="tr-dept-hours-<?php echo $key+1;?> cal_hours">
							<td colspan="<?php echo $section_availabe_coloumn; ?>" class="bg-color-red">Hours</td>
							<?php
							// compare rota hours to forecast rota hours monday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$last_row_dept_id]['mon_hours'] != $pay_value_dept[$last_row_dept_id]['mon_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="mon_hours bg-color-red dept-hours-mon-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$last_row_dept_id]['mon_hours']; ?></td>
							
							<?php
							// compare rota hours to forecast rota hours Tuesday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$last_row_dept_id]['tue_hours'] != $pay_value_dept[$last_row_dept_id]['tue_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="tue_hours bg-color-red dept-hours-tue-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$last_row_dept_id]['tue_hours']; ?></td>
							
							<?php
							// compare rota hours to forecast rota hours Wednesday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$last_row_dept_id]['wed_hours'] != $pay_value_dept[$last_row_dept_id]['wed_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="wed_hours bg-color-red dept-hours-wed-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$last_row_dept_id]['wed_hours']; ?></td>
							
							<?php
							// compare rota hours to forecast rota hours thusday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$last_row_dept_id]['thu_hours'] != $pay_value_dept[$last_row_dept_id]['thu_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="thu_hours bg-color-red dept-hours-thu-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$last_row_dept_id]['thu_hours']; ?></td>
							
							<?php
							// compare rota hours to forecast rota hours Friday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$last_row_dept_id]['fri_hours'] != $pay_value_dept[$last_row_dept_id]['fri_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="fri_hours bg-color-red dept-hours-fri-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$last_row_dept_id]['fri_hours']; ?></td>
							
							<?php
							// compare rota hours to forecast rota hours Saturday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$last_row_dept_id]['sat_hours'] != $pay_value_dept[$last_row_dept_id]['sat_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="sat_hours bg-color-red dept-hours-sat-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$last_row_dept_id]['sat_hours']; ?></td>
							
							<?php
							// compare rota hours to forecast rota hours Sunday
							$compare_class_red = '';
							if($forecast_rota_pay_comp[$last_row_dept_id]['sun_hours'] != $pay_value_dept[$last_row_dept_id]['sun_hours'] && $actual_rota_page == 1)
							{
								$compare_class_red = 'compare_class_red';
							}
							?>
							<td colspan="4" class="sun_hours bg-color-red dept-hours-sun-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo $pay_value_dept[$last_row_dept_id]['sun_hours']; ?></td>
							
							<td colspan="3" class="bg-color-red td-total-dept-hours"></td>
						</tr>
						<?php
						if($loggedInUser->checkPermission(array(15))){
						?>
							<tr class="tr-dept-pay-<?php echo $key+1;?> cal_pay">
								
								<td colspan="<?php echo $section_availabe_coloumn; ?>" class="bg-color-red">Pay</td>
								<?php
								// compare rota pay to forecast rota hours Monday
								$compare_class_red = '';
								if($forecast_rota_pay_comp[$last_row_dept_id]['sum_monpay'] != $pay_value_dept[$last_row_dept_id]['sum_monpay'] && $actual_rota_page == 1)
								{
									$compare_class_red = 'compare_class_red';
								}
								?>
								<td colspan="4" class="mon_pay bg-color-red dept-pay-mon-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format(($pay_value_dept[$last_row_dept_id]['sum_monpay']+$Monday_crosscharge)/100,2); ?></td>
								
								<?php
								// compare rota pay to forecast rota hours Tuesday
								$compare_class_red = '';
								if($forecast_rota_pay_comp[$last_row_dept_id]['sum_tuepay'] != $pay_value_dept[$last_row_dept_id]['sum_tuepay'] && $actual_rota_page == 1)
								{
									$compare_class_red = 'compare_class_red';
								}
								?>
								<td colspan="4" class="tue_pay bg-color-red dept-pay-tue-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format(($pay_value_dept[$last_row_dept_id]['sum_tuepay']+$Tuesday_crosscharge)/100,2); ?></td>
								
								<?php
								// compare rota pay to forecast rota hours Wednesday
								$compare_class_red = '';
								if($forecast_rota_pay_comp[$last_row_dept_id]['sum_wedpay'] != $pay_value_dept[$last_row_dept_id]['sum_wedpay'] && $actual_rota_page == 1)
								{
									$compare_class_red = 'compare_class_red';
								}
								?>
								<td colspan="4" class="wed_pay bg-color-red dept-pay-wed-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format(($pay_value_dept[$last_row_dept_id]['sum_wedpay']+$Wednesday_crosscharge)/100,2); ?></td>
								
								<?php
								// compare rota pay to forecast rota hours Thusday
								$compare_class_red = '';
								if($forecast_rota_pay_comp[$last_row_dept_id]['sum_thupay'] != $pay_value_dept[$last_row_dept_id]['sum_thupay'] && $actual_rota_page == 1)
								{
									$compare_class_red = 'compare_class_red';
								}
								?>
								<td colspan="4" class="thu_pay bg-color-red dept-pay-thu-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format(($pay_value_dept[$last_row_dept_id]['sum_thupay']+$Thursday_crosscharge)/100,2); ?></td>
								
								<?php
								// compare rota pay to forecast rota hours Friday
								$compare_class_red = '';
								if($forecast_rota_pay_comp[$last_row_dept_id]['sum_fripay'] != $pay_value_dept[$last_row_dept_id]['sum_fripay'] && $actual_rota_page == 1)
								{
									$compare_class_red = 'compare_class_red';
								}
								?>
								<td colspan="4" class="fri_pay bg-color-red dept-pay-fri-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format(($pay_value_dept[$last_row_dept_id]['sum_fripay']+$Friday_crosscharge)/100,2); ?></td>
								
								<?php
								// compare rota pay to forecast rota hours Saturday
								$compare_class_red = '';
								if($forecast_rota_pay_comp[$last_row_dept_id]['sum_satpay'] != $pay_value_dept[$last_row_dept_id]['sum_satpay'] && $actual_rota_page == 1)
								{
									$compare_class_red = 'compare_class_red';
								}
								?>
								<td colspan="4" class="sat_pay bg-color-red dept-pay-sat-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format(($pay_value_dept[$last_row_dept_id]['sum_satpay']+$Saturday_crosscharge)/100,2); ?></td>
								
								<?php
								// compare rota pay to forecast rota hours Sunday
								$compare_class_red = '';
								if($forecast_rota_pay_comp[$last_row_dept_id]['sum_sunpay'] != $pay_value_dept[$last_row_dept_id]['sum_sunpay'] && $actual_rota_page == 1)
								{
									$compare_class_red = 'compare_class_red';
								}
								?>
								<td colspan="4" class="sun_pay bg-color-red dept-pay-sun-<?php echo $last_row_dept_id.' '.$compare_class_red; ?>"><?php echo '£ '.number_format(($pay_value_dept[$last_row_dept_id]['sum_sunpay']+$Sunday_crosscharge)/100,2); ?></td>
								
								<td colspan="3" class="bg-color-red td-total-dept-pay" ></td>
							</tr>
						<?php
						}
						}
						?>
						<tr class="for-getting-width">
							<?php
							for($aaaa=1;$aaaa<=$total_coloumn_of_table;$aaaa++)
							{
								echo '<td></td>';
							}
							?>
							
						</tr>
						</tbody>
					</table>
					<table id="header-fixed"></table>



	</div>
			</div>
            
        </div>
	</div>

	<!-- Normal Modal -->
	<button data-target="#modal-popup-mouse-right-click" data-toggle="modal" id="button-mouse-right-click" style="display:none;"></button>
	<div class="modal" id="modal-popup-mouse-right-click" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="block block-themed block-transparent remove-margin-b">
					<div class="block-header bg-primary-dark">
						<ul class="block-options">
							<li>
								<button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
							</li>
						</ul>
						<h3 class="block-title">Staff Edit</h3>
					</div>
					<div class="block-content" id="mouse-right-click-content">
						
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-sm btn-default" type="button" data-dismiss="modal" id="close_right_click_modals">Close</button >
				</div>
			</div>
		</div>
	</div>
	<!-- END Normal Modal -->
	
	<div class="modal" id="modal-popin-rota-publish-error" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="block block-themed block-transparent remove-margin-b">
					<div class="block-header bg-primary-dark">
						<ul class="block-options">
							<li>
								<button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
							</li>
						</ul>
						<h3 class="block-title">Error</h3>
					</div>
					<div class="block-content">
						<p>This rota has already been published.</p>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
    <!-- END Small Modal -->
	
	<!-- Normal Modal -->
	<div class="modal" id="modal-copy-for-next-week" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="POST" action="<?php echo base_url().'copy_rota_data_week'; ?>">
					<div class="block block-themed block-transparent remove-margin-b">
						<div class="block-header bg-primary-dark">
							<ul class="block-options">
								<li>
									<button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
								</li>
							</ul>
							<h3 class="block-title">Copy</h3>
						</div>
						<div class="block-content">
							<?php
							$this_week_a = $end_date;
							$next_week_a = date('Y-m-d',strtotime($end_date.' +7 days'));
							?>
							<p>Are you sure you want to copy this rota for next week (<?php echo date('dS F',strtotime($next_week_a)); ?>) ?</p>
							<p>Note : if you confirm, you will lose all previous rota data for WE <?php echo date('dS F',strtotime($next_week_a)); ?> </p>
							<input type="hidden" name="copy_enddate" value="<?php echo $end_date; ?>">
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
						<button class="btn btn-sm btn-primary" type="submit" ><i class="fa fa-check"></i> Confirm</button>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<!-- END Normal Modal -->
	
	
	<!-- Pop In Modal for rota notes-->
	<div class="modal fade" id="modal-rota-notes" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-popin">
			<div class="modal-content">
			<form method="POST" action="<?php echo base_url().'form_rota_notes';?>" id="form_rota_notes_schedule">
				<div class="block block-themed block-transparent remove-margin-b">
					<div class="block-header bg-primary-dark">
						<ul class="block-options">
							<li>
								<button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
							</li>
						</ul>
						<h3 class="block-title">Notes</h3>
					</div>
					<div class="block-content" id="rota-notes-content">
					
						<div class="row">
							<div class="col-sm-12">
								<input type="hidden" name="date" value="">
								<textarea class="form-control" id="rota-notes-text" name="notes"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-sm btn-default" type="button" data-dismiss="modal" id="close-rota-notes">Close</button>
					<button class="btn btn-sm btn-primary" type="button" onclick="form_rota_notes_schedule()" >Save</button>
				</div>
				</form>
			</div>
		</div>
	</div>
        <!-- END Pop In Modal -->
		
		<!-- Small Modal -->
	<div class="modal" id="mising-staff-modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="block block-themed block-transparent remove-margin-b">
					<div class="block-header bg-primary-dark">
						<ul class="block-options">
							<li>
								<button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
							</li>
						</ul>
						<h3 class="block-title">Adding Staff......</h3>
					</div>
					<div class="block-content">
					<p class="text-center"><i class="fa fa-4x fa-sun-o fa-spin text-danger"></i></p>
					<p class="text-center message-missing">Please wait while we add staff to the rota...</p>
					</div>
				</div>
				<div class="modal-footer">
					<!--
					<button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
					<button class="btn btn-sm btn-primary" type="button" data-dismiss="modal"><i class="fa fa-check"></i> Ok</button>
					-->
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal" id="modal-load_hourly_labour_analised" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="block block-themed block-transparent remove-margin-b">
					<div class="block-header bg-primary-dark">
						<ul class="block-options">
							<li>
								<button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
							</li>
						</ul>
						<h3 class="block-title">Hourly Labour Analysis</h3>
					</div>
					<div class="block-content">
						<div class="mon-graph_div">
							<canvas id="mon-chart_hourly_labour_analised"></canvas>
						</div>
						<div class="tue-graph_div">
							<canvas id="tue-chart_hourly_labour_analised"></canvas>
						</div>
						<div class="wed-graph_div">
							<canvas id="wed-chart_hourly_labour_analised"></canvas>
						</div>
						<div class="thu-graph_div">
							<canvas id="thu-chart_hourly_labour_analised"></canvas>
						</div>
						<div class="fri-graph_div">
							<canvas id="fri-chart_hourly_labour_analised"></canvas>
						</div>
						<div class="sat-graph_div">
							<canvas id="sat-chart_hourly_labour_analised"></canvas>
						</div>
						<div class="sun-graph_div">
							<canvas id="sun-chart_hourly_labour_analised"></canvas>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
		
<input type="hidden" id="colorCode_status">
<input type="hidden" id="colorCode_id">
<input type="hidden" id="colorCode_color">
<input type="hidden" id="mon-get_load_hourly_labour_analised_data">
<input type="hidden" id="tue-get_load_hourly_labour_analised_data">
<input type="hidden" id="wed-get_load_hourly_labour_analised_data">
<input type="hidden" id="thu-get_load_hourly_labour_analised_data">
<input type="hidden" id="fri-get_load_hourly_labour_analised_data">
<input type="hidden" id="sat-get_load_hourly_labour_analised_data">
<input type="hidden" id="sun-get_load_hourly_labour_analised_data">
<script>
ajax_load_color_code_shifts();
get_data_of_schedule_multiple_sites();

function get_data_of_schedule_multiple_sites()
{
	//return true;
	var date = '<?php echo $this->uri->segment(2); ?>';
	$.ajax({
		type	: 'POST',
		url		: '<?php echo base_url(); ?>get_data_of_schedule_multiple_sites',
		data	: { 'date':date },
		success : function(response)
		{
			if(response && response!= 'no_data')
			{
				var day_array = ['mon','tue','wed','thu','fri','sat','sun'];
				var data_multisite = JSON.parse(response);
				$.each(data_multisite,function(staff_id,data_row){
					$.each(data_row,function(field_name,values){
						
						var array_key_field = field_name.split('-');
						var array_values 	= values.split('#');
						var company_name 	= array_values[0];
						company_name_short_name	= company_name.slice(0,3);
						company_name_short_name2	= company_name.slice(3,6);
						var day = array_key_field[0];
						var shift_number = array_key_field[2];
						if(shift_number == '1')
						{
							shift_number = '';
						}
						
						$('input.hidden_section_id').each(function(){
							var section_id = $(this).val();
							//mon_start_1317_15
							
							if(section_id == 'blank')
							{
								section_id = '';
							}
							
							var inputfield_start 	=  day+'_start'+shift_number+'_'+staff_id+'_'+section_id;
							var inputfield_end 		=  day+'_end'+shift_number+'_'+staff_id+'_'+section_id;
							//$('input#'+inputfield_end).parent('td').remove();
							//$('input#'+inputfield_start).parent('td').attr('colspan','2');
							
							// FRO START INPUT
							var td = $('input#'+inputfield_start).parent('td');
							$('input#'+inputfield_start).val(company_name_short_name);
							$('input#'+inputfield_start).parent('td').addClass('multisites_available_staff');
							$('input#'+inputfield_start).attr('readonly','true');
							var content = '<strong>'+company_name+'</strong><br>'+array_values[1].slice(0,5)+' - '+array_values[2].slice(0,5);
							$('input#'+inputfield_start).attr('data-toggle','tooltip');
							$('input#'+inputfield_start).attr('data-original-title',content);
							$('input#'+inputfield_start).attr('data-placement','top');
							$('input#'+inputfield_start).attr('data-html','true');
							$('input#'+inputfield_start).css('text-align','right');
							$('input#'+inputfield_start).parent('td').css('border-right','1px solid #464141');
							$('input#'+inputfield_start).tooltip();
							
							$('input#'+inputfield_start).attr('onclick','return false;');
							$('input#'+inputfield_start).attr('onchange','return false;');
							$('input#'+inputfield_start).attr('onkeyup','return false;');
							$('input#'+inputfield_start).attr('onkeydown','return false;');
							$('input#'+inputfield_start).attr('onkeypress','return false;');
							
							// FOR END INPUT
							var td = $('input#'+inputfield_end).parent('td');
							$('input#'+inputfield_end).val(company_name_short_name2);
							$('input#'+inputfield_end).parent('td').addClass('multisites_available_staff');
							$('input#'+inputfield_end).attr('readonly','true');
							var content = '<strong>'+company_name+'</strong><br>'+array_values[1].slice(0,5)+' - '+array_values[2].slice(0,5);
							$('input#'+inputfield_end).attr('data-toggle','tooltip');
							$('input#'+inputfield_end).attr('data-original-title',content);
							$('input#'+inputfield_end).attr('data-placement','top');
							$('input#'+inputfield_end).attr('data-html','true');
							$('input#'+inputfield_end).css('text-align','left');
							$('input#'+inputfield_end).parent('td').css('border-left','1px solid #464141');
							$('input#'+inputfield_end).tooltip();
							
							$('input#'+inputfield_end).attr('onclick','return false;');
							$('input#'+inputfield_end).attr('onchange','return false;');
							$('input#'+inputfield_end).attr('onkeyup','return false;');
							$('input#'+inputfield_end).attr('onkeydown','return false;');
							$('input#'+inputfield_end).attr('onkeypress','return false;');
							
							
							
							
						})
					})
				})
			}
		}
	})
}

function select_shift_short_color(id,color,that){
	var colorCode_id= $('input#colorCode_id').val();
	if(colorCode_id == id)
	{
		$('input#colorCode_status').val(0);
		$('.outer-shift-codes-buttons').removeClass('active_class');
		$('input#colorCode_id').val('');
		$('input#colorCode_status').val('');
		$('input#colorCode_color').val('');
		$('table.rota_ex_table tbody input').attr('onclick',false);
		$('table.rota_ex_table tbody input').css('cursor','auto');
	}
	else
	{
		$('input#colorCode_status').val(1);
		$('.outer-shift-codes-buttons').removeClass('active_class');
		$(that).parent('.outer-shift-codes-buttons').addClass('active_class');
		
		$('input#colorCode_id').val(id);
		$('input#colorCode_status').val(1);
		$('input#colorCode_color').val(color);
		
		$('table.rota_ex_table tbody input').attr('onclick',"staff_color_code_setup(this)");
		$('table.rota_ex_table tbody input').css('cursor','pointer');
		
		
	}
	
}

function staff_color_code_setup(that){
	var staff_content           = that.id;
	var split_staff             = staff_content.split("_");
	var colorCode_id 			= $('input#colorCode_id').val();
	var colorCode_status 		= $('input#colorCode_status').val();
	var colorCode_color 		= $('input#colorCode_color').val();
	var we 						= '<?php echo $end_date; ?>';
	
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url()."staff_color_code_setup"; ?>',
		data 	: {'colorCode_id':colorCode_id, 'colorCode_status':colorCode_status, 'colorCode_color':colorCode_color,'staff_full_id':staff_content,'we':we },
		success : function(response){
			if(response){
				var data = JSON.parse(response);
				if(data.status == 'insert'){
					$('input#'+data.input_1).css('background',colorCode_color);
					$('input#'+data.input_2).css('background',colorCode_color);
				}
				else if(data.status == 'delete'){
					$('input#'+data.input_1).css('background','');
					$('input#'+data.input_2).css('background','');
				}
			}
		}
	})
}

function ajax_load_color_code_shifts(){
	var we 						= '<?php echo $end_date; ?>';
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url()."ajax_load_color_code_shifts"; ?>',
		data 	: {'we':we },
		success : function(response){
			if(response){
				var data = JSON.parse(response);
				var zz = data.y;
				$.each(data.y,function(i,k){
					// alert(i);
					// alert(j);
					$('input#'+i).css('background',k);
				})
			}
		}
	})
}


$(document).ready(function(){
	recalculate_pay();
})

function recalculate_pay()
{
	var end_date = '<?php echo $end_date; ?>';
	$.ajax({
		type	:'POST',
		url 	: '<?php echo base_url()."staff/rota_recalculate_pay"; ?>',
		data 	: {'end_date':end_date},
		success : function(response)
		{
			total_pay_per_staff();
		}
	})
}
// ---------------------Testing Purpose bbb---------------------------------
var active = 0;


// $('#rota_ex_table input').keydown(function(e){
	// alert('Hello');
    // reCalculate(e);
    // rePosition();
    // return false;
// });
    
$('table.rota_ex_table input').click(function(){
	// alert('Working That');
   active = $(this).closest('table').find('td input').index(this);
   rePosition();
});


function reCalculate(e){
    var rows = $('.rota_ex_table tr.num').length;
    var columns = $('.rota_ex_table tr.num:eq(0) td input').length;
    //alert(columns + 'x' + rows);
    // alert(e.keyCode);
    if (e.keyCode == 37) { //move left or wrap
        active = (active>0)?active-1:active;
    }
    if (e.keyCode == 38) { // move up
        active = (active-columns>=0)?active-columns:active;
    }
    if (e.keyCode == 39 || e.keyCode == 9) { // move right or wrap
       active = (active<(columns*rows)-1)?active+1:active;
    }
    if (e.keyCode == 40) { // move down
        active = (active+columns<=(rows*columns)-1)?active+columns:active;
    }
}

function rePosition(){
	// alert(active);
	$('table.active').parent().css('border','1px solid black')
    $('table.active').removeClass('active');
    $('.rota_ex_table tr.num td input').eq(active).addClass('active').trigger( "focus" ).parent().css('border','1px solid #5b8ecf');
	$(".rota_ex_table tr.num td span[rel='replace']").css('border','none');
	// $(".active").parent().css('border','1px solid black');
	// $(".active").parent().css('border','1px solid green');
    // scrollInView();
}

// function scrollInView(){
    // var target = $('.rota_ex_table tr.num td input:eq('+active+')');
    // if (target.length)
    // {
        // var top = target.offset().top;
        
        // $('html,body').stop().animate({scrollTop: top-100}, 400);
        // return false;
    // }
// }


$(document).ready(function() {
    $("table.rota_ex_table input").keypress(function(e) {
		var a = this.value;
		if(a.length > 4)
		{
			this.value = '';
		}
	});
});

// when user click input then select all for overwright the text
$(document).ready(function() {
    $("table.rota_ex_table input").click(function(e) {
		$(this).select();
	});
});
// ---------------------End of Testing Purpose --------------------------

// Allow Number Only
$(document).ready(function() {
    $("table.rota_ex_table input").keydown(function (e) {
		 reCalculate(e);
		rePosition();
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 27, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
		
    });
	
	
});

$(document).ready(function() {
    $("table.rota_ex_table input").keyup(function (e) {
		var data = this.value;
		// if press delete
		if(e.keyCode == 8)
		{
			
		}
		else
		{
			if(data > 24)
			{
				this.value = '';
			}
			else
			{
				
			
				/* if(data >= 10)
				{
					this.value = data + ':';
				}
				else if(data >=2 && data <= 9)
				{
					var data1 = data.replace(/^0+/, '');
					this.value =  '0'+data1 + ':';
				} */
				
				
				var limitField = data.trim().length;
				var limit = "5"	;
				if (e.keyCode != 8) {
				  if (limitField == 2) {
					  var fax_value = data.trim().concat(':');
					this.value = fax_value;
				  } 
				  // else if (limitField == 3) {
					  // var fax_value = data.trim().concat(':');
					// this.value = fax_value;
				  // }
				}
				if (limitField > limit) {
					var aa = data.trim().substring(0, limit);	
					this.value = aa;
				}
				
			}
			
		}
		
    });
	
	
});

$(document).ready(function() {
    $("table.rota_ex_table input").change(function (e) {
       
		var id = this.id;
		var ajax_department_select	= 'all';
		var actual_rota_page		= '<?php echo $actual_rota_page;?>';
		var company_id				= '<?php echo $loggedincompanyid;?>';
		var ajax_we					= '<?php echo $end_date;?>';
		var ajax_user				= '<?php echo $loggedInUser->user_id;?>';
		var ajax_finalise_count		= '<?php echo $this->session->userdata('finalise_countt'); ?>';
		var id_data					= id.split("_");
		var day_slice				= id_data.slice(0,1);
		var day						= day_slice.toString();
		var staff					= id_data.slice(2,3);
		var section_id				= id_data[3];
		var rotastaffid				= staff.toString();
		var start_1					= $("#"+day+"_start_"+staff+"_"+section_id).val();
		var end_1					= $("#"+day+"_end_"+staff+"_"+section_id).val();
		var start_2					= $("#"+day+"_start2_"+staff+"_"+section_id).val();
		var end_2					= $("#"+day+"_end2_"+staff+"_"+section_id).val();
		
		$.ajax({
		type : "POST",
		url : "<?php echo base_url();?>staff/ajax_change_time",
		data : {"user" : ajax_user , "ajax_department_select" :ajax_department_select ,   "ajax_we" : ajax_we , "ajax_finalise_count" : ajax_finalise_count , "day" : day ,"rotastaffid" : rotastaffid , "company_id" : company_id ,"start_1" : start_1 , "end_1" : end_1 ,"start_2" : start_2 , "end_2" : end_2, "section_id":section_id,"actual_rota_page":actual_rota_page } ,
		
		success : function(result){
			
			var contents = result;
			// alert(contents.search('Opsyte'));
			if(contents.search('Opsyte') > 0)
			{
				alert("Your session has been expired!");
				location.reload();
			}
			else
			{
			
				if(result=='session_expired'){
					alert("Your session has been expired!");
					location.reload(); 
			
				}else if(result == 'already exists')
				{
					alert('Time slot booked by other section!Please try again.');
					$('#'+id).val('');
					$('#'+id).focus();
				}
				else
				{
					
					$('#hours_'+rotastaffid+"_"+section_id).text(result);
					calculate_total_sum_hour(rotastaffid,section_id);
					calculate_dept_pay_hours(staff,day);
					total_pay_per_staff();
				}
			}
			
		}
		});
    });
	
});

function calculate_dept_pay_hours(staff_id,day)
{
	var we						= '<?php echo $end_date;?>';
	$.ajax({
		type : "POST",
		url : "<?php echo base_url();?>staff/calculate_dept_pay_hours",
		data : {"staff_id" : staff_id , "day" :day, "we" :we,  } ,
		success : function(response){
					var data 		= JSON.parse(response);
					var find 		= data.find;
					if(find == 'yes')
					{
						var dept_hours 		= data.dept_hours;
						var dept_pay 		= data.dept_pay;
						var dept_id 		= data.dept_id;
						var dept_day		= data.dept_day;
						var dept_week		= data.dept_week;
						// alert(dept_hours);
						// alert(dept_pay);
						$("td.dept-hours-"+day+"-"+dept_id).text(dept_hours);
						
						var actual_rota_page = '<?php echo $actual_rota_page; ?>';
						if(actual_rota_page == '1')
						{
							$("td.dept-hours-"+day+"-"+dept_id).css('color','#ffc107');
							$("td.dept-pay-"+day+"-"+dept_id).css('color','#ffc107');
							$("td.dept-hours-"+day+"-"+dept_id).parent('tr').find('td.td-total-dept-hours').css('color','#ffc107');
							$("td.dept-pay-"+day+"-"+dept_id).parent('tr').find('td.td-total-dept-pay').css('color','#ffc107');
						}
						
						// We now return the whole pay for the week, rather than 1 day.
						$("td.dept-pay-mon-"+dept_id).text('£ '+(dept_week.sum_monpay/100).toFixed(2));
						$("td.dept-pay-tue-"+dept_id).text('£ '+(dept_week.sum_tuepay/100).toFixed(2));
						$("td.dept-pay-wed-"+dept_id).text('£ '+(dept_week.sum_wedpay/100).toFixed(2));
						$("td.dept-pay-thu-"+dept_id).text('£ '+(dept_week.sum_thupay/100).toFixed(2));
						$("td.dept-pay-fri-"+dept_id).text('£ '+(dept_week.sum_fripay/100).toFixed(2));
						$("td.dept-pay-sat-"+dept_id).text('£ '+(dept_week.sum_satpay/100).toFixed(2));
						$("td.dept-pay-sun-"+dept_id).text('£ '+(dept_week.sum_sunpay/100).toFixed(2));

						auto_calculate_total_pay_and_hour();
						calculate_grandtotal_pay_and_hour_department();
					}
					
					
				}
	})							
}

function calculate_total_sum_hour(staffid,section_id)
{
	var company_id				= '<?php echo $loggedincompanyid;?>';
	var we						= '<?php echo $end_date;?>';
	$.ajax({
		type : "POST",
		url : "<?php echo base_url();?>staff/calculate_total_sum_hour",
		data : {"staffid" : staffid , "section_id" :section_id, "we" :we, "company_id" :company_id } ,
		
		success : function(response){
			if(response == 'not found')
			{
				
			}
			else
			{
				$('#total_hours_'+staffid+"_"+section_id).text(response);
			}
		}
	});
}

function link_switch_view(link)
{
	var week_end = '<?php echo $end_date; ?>';
	window.location.href = '<?php echo base_url();?>'+link+'/'+ week_end;
}

function select_department()
{
	$('#select_dept_form').submit();
}


// for click top small sidebar
$('li.hidden-xs.hidden-sm button').click();

//ajdust reaonly where edit_active = 0 in rota_setting
$('tr.readonly_restrictions td input').attr('readonly',true);

</script>
  
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="<?php echo base_url().'assets/js/ajax/ajax_form_data.js'?>"></script>

<?php // ---------------------Pop up hover over holiday -------------------------- ?>
<script>
$(document).ready(function(){
    $('[rel="replace"]').popover({
          trigger: 'hover',
          placement : 'bottom', 
          html: 'true',                            
          content :'They are on approved holiday!' 
    }); 
	auto_calculate_total_pay_and_hour();
	calculate_grandtotal_pay_and_hour_department();
	total_previous_week_pay_per_staff();
	rota_missing_staff_fetch();
		
});

function rota_missing_staff_fetch()
{
	var end_date = '<?php echo $end_date; ?>';
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url()."rota_missing_staff_fetch"; ?>',
		data 	: { 'end_date':end_date},
		success : function(response)
		{
			if(response == 'missing')
			{
				$('#mising-staff-modal').modal('show');
				$('form#form_rota_auto_add_staff').submit();
			}
		}
	})
}

function open_rota_notes(that)
{
	var date = that.id;
	$('#rota-notes-content input[name="date"]').val(date);
	
	$.ajax({
		type 	: 'POST',
		url		: '<?php echo base_url().'staff/ajax_schedule_notes'?>',
		data	: { 'date' : date },
		success	: function(response)
		{
			$('#rota-notes-content textarea[name="notes"]').val(response);
		}
		
	})
	// var date = $(that).parent().parent('td').find('input#date').val();
	// $(that).parent().parent('td').css('background','red');
	// alert(date);
}

function form_rota_notes_schedule()
{
	// alert('works');
	var formData = new FormData(document.getElementById("form_rota_notes_schedule"));
	$.ajax({
		type 		: 'POST',
		url			: '<?php echo base_url()."form_rota_notes"; ?>',
		async		: false,
		cache		: false,
		contentType	: false,
		processData: false,
		data		: formData,
		success		: function(response)
		{
			$('button#close-rota-notes').click();
		}
	})
}

function calculate_grandtotal_pay_and_hour_department()
{
	// alert('hj');
	$('tr.cal_hours').each(function(){
		var tr = $(this).prop('class');
		var first_tr = tr.split(' ');
		var tr = first_tr[0];
		
		// Calculate hours
		var sum_hrs = 0;
		$('tr.'+tr+' td.td-total-dept-hours').text(0);
		 $('tr.'+tr+' td:not(:first-child)').each(function(){
			 if($(this).text())
			 {
				sum_hrs +=  parseFloat($(this).text());
			 }
			// alert($(this).text());
		});
		$('tr.'+tr+' td.td-total-dept-hours').text(sum_hrs);
		if($('tr.'+tr).find('td.compare_class_red').text())
		{
			$('tr.'+tr+' td.td-total-dept-hours').css('color','#ffc107');
		}
		
	});
	
	
	$('tr.cal_pay').each(function(){
		var tr = $(this).prop('class');
		var first_tr = tr.split(' ');
		var tr = first_tr[0];
		
		// Calculate hours
		var sum_pay = 0;
		$('tr.'+tr+' td.td-total-dept-pay').text('0');
		 $('tr.'+tr+' td:not(:first-child)').each(function(){
			 if($(this).text())
			 {
				sum_pay +=  parseFloat(replace_dollar($(this).text()));
			 }
			// alert($(this).text());
		});
		$('tr.'+tr+' td.td-total-dept-pay').text('£ '+sum_pay.toFixed(2));
		if($('tr.'+tr).find('td.compare_class_red').text())
		{
			$('tr.'+tr+' td.td-total-dept-pay').css('color','#ffc107');
		}
	});
}


function auto_calculate_total_pay_and_hour()
{
		$('span.forecast_percent').remove();
		var ni_pension = '<?php echo $ni_pension; ?>'
		// total mon hours cal...
		var temp_mon = 0;
		$('td.mon_hours').each(function(){

			var tdTxt = $(this).text();
		
			temp_mon+= parseFloat(tdTxt);  
			$('.total_mon_hours').text(temp_mon.toFixed(1));
			
		});
		
		
		// total mon pay cal...
		var temp_mon_pay = 0.00;
		$('td.mon_pay').each(function(){

			var tdTxt = $(this).text();
			var tdTxt_mon = tdTxt.split(' ');   //splite dollar sign
			
			temp_mon_pay+= parseFloat(replace_dollar(tdTxt_mon[1])); 
			
			$('.total_mon_pay').text(tdTxt_mon[0]+' '+(ni_pension*temp_mon_pay).toFixed(2));
		});
		
		// Total forecast sale Monday
		var forecast_mon_txt 		= $('td.total_mon_fs').text();
		var forecast_mon_val 		= parseFloat(replace_dollar(forecast_mon_txt));
		var forecast_percent_mon	= parseFloat((temp_mon_pay*ni_pension/forecast_mon_val)*100);
		if(forecast_mon_val == '0' || temp_mon_pay == '0')
		{
			$('td.total_mon_fs').text(forecast_mon_txt+' ').append('<span class="forecast_percent"> (0%)</span>');
		}
		else
		{
			$('td.total_mon_fs').text(forecast_mon_txt+' ').append('<span class="forecast_percent"> ('+forecast_percent_mon.toFixed(1)+'%)</span>');
		}
		
		// Calculate labour vs net sale for Monday
		var mon_net_val = '<?php echo number_format($net_of_week['Monday'],2) ? number_format($net_of_week['Monday'],2) : 0; ?>';
		var mon_net = parseFloat($('td.mon_actual_vs_net').prop('id'));
		var labour_vs_net_mon = parseFloat((temp_mon_pay*ni_pension/mon_net)*100)
		if(mon_net == '0' )
		{
			$('td.mon_actual_vs_net').text('£ '+mon_net_val+' (0%)');
		}
		else
		{
			$('td.mon_actual_vs_net').text('£ '+mon_net_val+' ('+labour_vs_net_mon.toFixed(1)+'%)');
		}
		
		
		// total tue hours cal...
		var temp_tue = 0;
		$('td.tue_hours').each(function(){

			var tdTxt = $(this).text();
			
			temp_tue+= parseFloat(tdTxt);  
			$('.total_tue_hours').text(temp_tue.toFixed(1));
		});
		// total tue pay cal...
		var temp_tue_pay = 0.00;
		$('td.tue_pay').each(function(){

			var tdTxt = $(this).text();
			var tdTxt_tue = tdTxt.split(' ');
			
			temp_tue_pay+= parseFloat(replace_dollar(tdTxt_tue[1]));  
			$('.total_tue_pay').text(tdTxt_tue[0]+' '+(ni_pension*temp_tue_pay).toFixed(2));
		});
		// Total forecast sale Tuesday
		var forecast_tue_txt 		= $('td.total_tue_fs').text();
		var forecast_tue_val 		= parseFloat(replace_dollar(forecast_tue_txt));
		var forecast_percent_tue	= parseFloat((temp_tue_pay*ni_pension/forecast_tue_val)*100);
		if(forecast_tue_val == '0' || temp_tue_pay == '0')
		{
			$('td.total_tue_fs').text(forecast_tue_txt+' ').append('<span class="forecast_percent"> (0%)</span>');
		}
		else
		{
			$('td.total_tue_fs').text(forecast_tue_txt+' ').append('<span class="forecast_percent"> ('+forecast_percent_tue.toFixed(1)+'%)</span>');
		}
		
		// Calculate labour vs net sale for Tuesday
		var tue_net_val = '<?php echo number_format($net_of_week['Tuesday'],2) ? number_format($net_of_week['Tuesday'],2) : 0; ?>';
		var tue_net = parseFloat($('td.tue_actual_vs_net').prop('id'));
		var labour_vs_net_tue = parseFloat((temp_tue_pay*ni_pension/tue_net)*100)
		if(tue_net == '0' )
		{
			$('td.tue_actual_vs_net').text('£ '+tue_net_val+' (0%)');
		}
		else
		{
			$('td.tue_actual_vs_net').text('£ '+tue_net_val+' ('+labour_vs_net_tue.toFixed(1)+'%)');
		}
		
		
		
		// total wed hours cal...
		var temp_wed = 0;
		$('td.wed_hours').each(function(){

			var tdTxt = $(this).text();
			
			temp_wed+= parseFloat(tdTxt);  
			
			$('.total_wed_hours').text(temp_wed.toFixed(1));
		});
		
		// total wed pay cal...
		var temp_wed_pay = 0.00;
		$('td.wed_pay').each(function(){

			var tdTxt = $(this).text();
			var tdTxt_wed = tdTxt.split(' ');
			
			temp_wed_pay+= parseFloat(replace_dollar(tdTxt_wed[1]));  
			$('.total_wed_pay').text(tdTxt_wed[0]+' '+(ni_pension*temp_wed_pay).toFixed(2));
		});
		
		// Total forecast sale Wednesday
		var forecast_wed_txt 		= $('td.total_wed_fs').text();
		var forecast_wed_val 		= parseFloat(replace_dollar(forecast_wed_txt));
		var forecast_percent_wed	= parseFloat((temp_wed_pay*ni_pension/forecast_wed_val)*100);
		if(forecast_tue_val == '0' || temp_tue_pay == '0')
		{
			$('td.total_wed_fs').text(forecast_wed_txt+' ').append('<span class="forecast_percent"> (0%)</span>');
		}
		else
		{
			$('td.total_wed_fs').text(forecast_wed_txt+' ').append('<span class="forecast_percent"> ('+forecast_percent_wed.toFixed(1)+'%)</span>');
		}
		
		// Calculate labour vs net sale for Wednesday
		var wed_net_val = '<?php echo number_format($net_of_week['Wednesday'],2) ? number_format($net_of_week['Wednesday'],2) : 0; ?>';
		var wed_net = parseFloat($('td.wed_actual_vs_net').prop('id'));
		var labour_vs_net_wed = parseFloat((temp_wed_pay*ni_pension/wed_net)*100)
		if(wed_net == '0' )
		{
			$('td.wed_actual_vs_net').text('£ '+wed_net_val+' (0%)');
		}
		else
		{
			$('td.wed_actual_vs_net').text('£ '+wed_net_val+' ('+labour_vs_net_wed.toFixed(1)+'%)');
		}
		
		// total thur hours cal...
		var temp_thu = 0;
		$('td.thu_hours').each(function(){

			var tdTxt = $(this).text();
			
			temp_thu+= parseFloat(tdTxt);  
			
			$('.total_thu_hours').text(temp_thu.toFixed(1));
		});
		
		// total thur pay cal...
		var temp_thu_pay = 0.00;
		$('td.thu_pay').each(function(){

			var tdTxt = $(this).text();
			var tdTxt_thu = tdTxt.split(' ');
			
			temp_thu_pay+= parseFloat(replace_dollar(tdTxt_thu[1]));  
			$('.total_thu_pay').text(tdTxt_thu[0]+' '+(ni_pension*temp_thu_pay).toFixed(2));
		});
		
		// Total forecast sale Thusday
		var forecast_thu_txt 		= $('td.total_thu_fs').text();
		var forecast_thu_val 		= parseFloat(replace_dollar(forecast_thu_txt));
		var forecast_percent_thu	= parseFloat((temp_thu_pay*ni_pension/forecast_thu_val)*100);
		if(forecast_thu_val == '0' || temp_thu_pay == '0')
		{
			$('td.total_thu_fs').text(forecast_thu_txt+' ').append('<span class="forecast_percent"> (0%)</span>');
		}
		else
		{
			$('td.total_thu_fs').text(forecast_thu_txt+' ').append('<span class="forecast_percent"> ('+forecast_percent_thu.toFixed(1)+'%)</span>');
		}
		
		// Calculate labour vs net sale for Thusday
		var thu_net_val = '<?php echo number_format($net_of_week['Thursday'],2) ? number_format($net_of_week['Thursday'],2) : 0; ?>';
		var thu_net = parseFloat($('td.thu_actual_vs_net').prop('id'));
		var labour_vs_net_thu = parseFloat((temp_thu_pay*ni_pension/thu_net)*100)
		if(thu_net == '0' )
		{
			$('td.thu_actual_vs_net').text('£ '+thu_net_val+' (0%)');
		}
		else
		{
			$('td.thu_actual_vs_net').text('£ '+thu_net_val+' ('+labour_vs_net_thu.toFixed(1)+'%)');
		}
		
		// total fri hours cal...
		var temp_fri = 0;
		$('td.fri_hours').each(function(){

			var tdTxt = $(this).text();
			
			temp_fri+= parseFloat(tdTxt);  
			$('.total_fri_hours').text(temp_fri.toFixed(1));
		});
		
		// total fri pay cal...
		var temp_fri_pay = 0.00;
		$('td.fri_pay').each(function(){

			var tdTxt = $(this).text();
			var tdTxt_fri = tdTxt.split(' ');
			
			temp_fri_pay+= parseFloat(replace_dollar(tdTxt_fri[1]));  
			$('.total_fri_pay').text(tdTxt_fri[0]+' '+(ni_pension*temp_fri_pay).toFixed(2));
		});
		// Total forecast sale Friday
		var forecast_fri_txt 		= $('td.total_fri_fs').text();
		var forecast_fri_val 		= parseFloat(replace_dollar(forecast_fri_txt));
		var forecast_percent_fri	= parseFloat((temp_fri_pay*ni_pension/forecast_fri_val)*100);
		if(forecast_fri_val == '0' || temp_fri_pay == '0')
		{
			$('td.total_fri_fs').text(forecast_fri_txt+' ').append('<span class="forecast_percent"> (0%)</span>');
		}
		else
		{
			$('td.total_fri_fs').text(forecast_fri_txt+' ').append('<span class="forecast_percent"> ('+forecast_percent_fri.toFixed(1)+'%)</span>');
		}
		
		// Calculate labour vs net sale for Friday
		var fri_net_val = '<?php echo $net_of_week['Friday'] ? $net_of_week['Friday'] : 0; ?>';
		var fri_net = parseFloat($('td.fri_actual_vs_net').prop('id'));
		var labour_vs_net_fri = parseFloat((temp_fri_pay*ni_pension/fri_net)*100)
		if(fri_net == '0' )
		{
			$('td.fri_actual_vs_net').text('£ '+fri_net_val+' (0%)');
		}
		else
		{
			$('td.fri_actual_vs_net').text('£ '+fri_net_val+' ('+labour_vs_net_fri.toFixed(1)+'%)');
		}
		
		// total sat hours cal...
		var temp_sat = 0;
		$('td.sat_hours').each(function(){

			var tdTxt = $(this).text();
			
			temp_sat+= parseFloat(tdTxt);  
			$('.total_sat_hours').text(temp_sat.toFixed(1));
		});
		
		// total sat pay cal...
		var temp_sat_pay = 0.00;
		$('td.sat_pay').each(function(){

			var tdTxt = $(this).text();
			var tdTxt_sat = tdTxt.split(' ');
			
			temp_sat_pay+= parseFloat(replace_dollar(tdTxt_sat[1]));  
			$('.total_sat_pay').text(tdTxt_sat[0]+' '+(ni_pension*temp_sat_pay).toFixed(2));
		});
		// Total forecast sale Saturday
		var forecast_sat_txt 		= $('td.total_sat_fs').text();
		var forecast_sat_val 		= parseFloat(replace_dollar(forecast_sat_txt));
		var forecast_percent_sat	= parseFloat((temp_sat_pay*ni_pension/forecast_sat_val)*100);
		if(forecast_sat_val == '0' || temp_sat_pay == '0')
		{
			$('td.total_sat_fs').text(forecast_sat_txt+' ').append('<span class="forecast_percent"> (0%)</span>');
		}
		else
		{
			$('td.total_sat_fs').text(forecast_sat_txt+' ').append('<span class="forecast_percent"> ('+forecast_percent_sat.toFixed(1)+'%)</span>');
		}
		// Calculate labour vs net sale for Saturday
		var sat_net_val = '<?php echo $net_of_week['Saturday'] ? $net_of_week['Saturday'] : 0; ?>';
		var sat_net = parseFloat($('td.sat_actual_vs_net').prop('id'));
		var labour_vs_net_sat = parseFloat((temp_sat_pay*ni_pension/sat_net)*100)
		if(sat_net == '0' )
		{
			$('td.sat_actual_vs_net').text('£ '+sat_net_val+' (0%)');
		}
		else
		{
			$('td.sat_actual_vs_net').text('£ '+sat_net_val+' ('+labour_vs_net_sat.toFixed(1)+'%)');
		}
		
		
		// total sun hours cal...
		var temp_sun = 0;
		$('td.sun_hours').each(function(){

			var tdTxt = $(this).text();
			
			temp_sun+= parseFloat(tdTxt);  
			$('.total_sun_hours').text(temp_sun.toFixed(1));
		});
		
		// total sun pay cal...
		var temp_sun_pay = 0.00;
		
		$('td.sun_pay').each(function(){

			var tdTxt = $(this).text();
			var tdTxt_sun = tdTxt.split(' ');
			
			temp_sun_pay+= parseFloat(replace_dollar(tdTxt_sun[1])); 
			
			$('.total_sun_pay').text(tdTxt_sun[0]+' '+(ni_pension*temp_sun_pay).toFixed(2));
		});
		
		// Total forecast sale Sunday
		var forecast_sun_txt 		= $('td.total_sun_fs').text();
		var forecast_sun_val 		= parseFloat(replace_dollar(forecast_sun_txt));
		var forecast_percent_sun	= parseFloat((temp_sun_pay*ni_pension/forecast_sun_val)*100);
		if(forecast_sun_val == '0' || temp_sun_pay == '0')
		{
			$('td.total_sun_fs').text(forecast_sun_txt+' ').append('<span class="forecast_percent"> (0%)</span>');
		}
		else
		{
			$('td.total_sun_fs').text(forecast_sun_txt+' ').append('<span class="forecast_percent"> ('+forecast_percent_sun.toFixed(1)+'%)</span>');
		}
		// Calculate labour vs net sale for Sunday
		var sun_net_val = '<?php echo $net_of_week['Sunday'] ? $net_of_week['Sunday'] : 0; ?>';
		var sun_net = parseFloat($('td.sun_actual_vs_net').prop('id'));
		var labour_vs_net_sun = parseFloat((temp_sun_pay*ni_pension/sun_net)*100)
		if(sun_net == '0' )
		{
			$('td.sun_actual_vs_net').text('£ '+sun_net_val+' (0%)');
		}
		else
		{
			$('td.sun_actual_vs_net').text('£ '+sun_net_val+' ('+labour_vs_net_sun.toFixed(1)+'%)');
		}
		
		
		var all_total_pay = temp_mon_pay + temp_tue_pay + temp_wed_pay + temp_thu_pay + temp_fri_pay + temp_sat_pay + temp_sun_pay; 
		$('td.td-top-total-pay').empty();
		$('td.td-top-total-pay').text('£ '+(ni_pension*all_total_pay).toFixed(2));
		
		var all_total_hours = temp_mon + temp_tue + temp_wed + temp_thu + temp_fri + temp_sat +temp_sun;
		$('td.td-top-total-hours').empty();
		$('td.td-top-total-hours').text(all_total_hours.toFixed(1));
		
		var total_net_val = '<?php echo $net_of_week['total_net'] ? $net_of_week['total_net'] : 0; ?>';
		var all_total_net = parseFloat($('td.total_actual_vs_net').prop('id'));
		var labour_vs_net_total = parseFloat((all_total_pay*ni_pension/all_total_net)*100);
		if(all_total_net == '0')
		{
			$('td.total_actual_vs_net').text('£ '+parseFloat(total_net_val).toFixed(1)+' (0%)');
		}
		else
		{
			$('td.total_actual_vs_net').text('£ '+parseFloat(total_net_val).toFixed(1)+' ('+labour_vs_net_total.toFixed(1)+'%)');
		}
		
		var forecast_total_txt 		= $('td.total_all_fs').text();
		var forecast_total_val 		= parseFloat(replace_dollar(forecast_total_txt));
		var forecast_percent_total	= parseFloat((all_total_pay*ni_pension/forecast_total_val)*100);
		if(forecast_total_val == '0' || all_total_pay == '0')
		{
			$('td.total_all_fs').text(forecast_total_txt+' ').append('<span class="forecast_percent"> (0%)</span>');
		}
		else
		{
			$('td.total_all_fs').text(forecast_total_txt+' ').append('<span class="forecast_percent"> ('+forecast_percent_total.toFixed(1)+'%)</span>');
		}
		
		
		
}


function vishnu_checking(){
	var z = 0;
	$('td.pay-individual-staff').each(function(){
		var x = parseFloat(replace_dollar($(this).text()));
		z+=x;
	})
	
	$('td.td-top-total-pay').text('£ '+z.toFixed(2));
}

</script>

 			<script>
				$('.tabs_a').click(function(event){ 
				
				$('.total_mon_hours_ajax').text('');
				$('.total_tue_hours_ajax').text('');
				$('.total_wed_hours_ajax').text('');
				$('.total_thu_hours_ajax').text('');
				$('.total_fri_hours_ajax').text('');
				$('.total_sat_hours_ajax').text('');
				$('.total_sun_hours_ajax').text('');
				
				$('.total_mon_pay_ajax').text('');
				$('.total_tue_pay_ajax').text('');
				$('.total_wed_pay_ajax').text('');
				$('.total_thu_pay_ajax').text('');
				$('.total_fri_pay_ajax').text('');
				$('.total_sat_pay_ajax').text('');
				$('.total_sun_pay_ajax').text('');
				
				
				
				$(".tabs_a").removeData("cache.tabs");
					var id = this.id;
					
					if(id == 'default'){
						location.reload(); 
					}
					else
					{
						$('li#li-add-button').css('display','block');
						$("form#form-rota-add-button").attr("action", "<?php echo base_url().'view_rota/'.$end_date.'/'; ?>"+id);
					}
					event.preventDefault();
					var dept = $('#select_dept').val();
					if(dept == ''){
						dept = '0';
					}
					$("#tabs-"+id).empty();
					 $.ajaxSetup ({
							cache: false
						});
						var ajax_load = "<img src='<?php echo base_url()."assets/images/small-loading.gif"?>' alt='loading...' />";
						

						var loadUrl = "<?php echo base_url().'staff/load_rota/'.$end_date.'/'?>"+dept+'/'+id;
							// $("#tabs-"+id).load(loadUrl);
							$("div.tabs-pane").removeClass('active');
							$("#rota-ul-top-list li").removeClass('active');
							$("div#default-tab").removeClass('active');
							$('#rota-ul-top-list li a[href="#tabs-'+id+'"]').parent('li').addClass('active');
							$("div#tabs-"+id).addClass('tabs-pane active');
							$("#tabs-"+id).load(loadUrl, function() {
								auto_calculate_total_pay_and_hour1(id);
								calculate_grandtotal_pay_and_hour_department1();
								payroll_dependent_inputs_fn();
								disable_holiday_inputs();
							});
							
					// $("#tabs-"+id).load("<?php echo base_url().'staff/load_rota/'.$end_date.'/'?>"+dept+'/'+id);
				});
				
function printDiv(divName) {
	
	var check_permission_super = '<?php echo ($loggedInUser->checkPermission(array(26))) ? 1 : 0;  ?>';
	var check_permission_payroll = '<?php echo ($loggedInUser->checkPermission(array(15))) ? 1 : 0;  ?>';
	// alert(check_permission);
	if(check_permission_super == '0' && check_permission_payroll == '1')
	{
		$('table.rota_ex_table tr').each(function(){
			var check_colspan = $(this).find('td:last-child').prop('colspan');
			if(check_colspan == 3)
			{
				$(this).find('td:last-child').prop('colspan','2');
			}
			else if(check_colspan == 2)
			{
				$(this).find('td:last-child').prop('colspan','1');
			}
			else if(check_colspan == 1){
				$(this).find('td:last-child').remove();
			}
		})
		
		$('table.rota_ex_table tr').each(function(){
			var check_colspan = $(this).find('th:last-child').prop('colspan');
			if(check_colspan == 3)
			{
				$(this).find('th:last-child').prop('colspan','2');
			}
			else if(check_colspan == 2)
			{
				$(this).find('th:last-child').prop('colspan','1');
			}
			else if(check_colspan == 1){
				$(this).find('th:last-child').remove();
			}
		})
	}
	
	$("#rota-print-area a").prop("href", "");
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
	 window.location = '<?php echo base_url().'rota_view_ex/'.$end_date;?>';
}

function replace_dollar(n)
{
	var a = n.replace('$', '');
	var b = a.replace(',', '');
	var b = b.replace(',', '');
	var b = b.replace(',', '');
	var b = b.replace(',', '');
	var b = b.replace(' ', '');
	var c = b.replace('%', '');
	var c = c.replace('£', '');
	return c;
}

function payroll_dependent_inputs_fn()
{
	var payroll_confirmed = '<?php echo $payroll_confirmed;?>';
	if(payroll_confirmed == '1')
	{
		$('.payroll_dependent_inputs input').attr('disabled',true);
	}
}

function staff_mousedown_context(that)
{
	// alert('abc');
	$('table.rota_ex_table')[0].oncontextmenu = function() { return true; }
	// $(that)[0].oncontextmenu = function() { return true; }
}

function set_holiday_event(event,that)
{
	$('div#content_data_page')[0].oncontextmenu = function() { return false; }
	// $('div.dropup').remove();
	mouse =event.button;
	if(mouse == '2')
	{
		 $(that)[0].oncontextmenu = function() { return false; }
		 
		var check_td_class = $(that).parent('td').prop('class');
		// alert(check_td_class);
		if(check_td_class.indexOf('active_holiday_unapproved') > -1) {
				var dropup = 0;
				var show_pop_up = 1;
				var holiday_status = 1;
		}
		else if(check_td_class.indexOf('active_holiday_approved') > -1)
		{
				var show_pop_up = 1;
				var holiday_status = 1;
		}
		else if(check_td_class.indexOf('approved_sick_holiday') > -1)
		{
				var show_pop_up = 1;
				var holiday_status = 3;
		}
		else 
		{
			var show_pop_up = 1;
			var dropup = 1;
			var holiday_status = 4;
		}
		
		// alert(holiday_status);
		
		if(show_pop_up == '1')
		{
			$('button#button-mouse-right-click').click();
			var input_id = that.id;
			if(holiday_status == '1')
			{
				// Remove Holiday
				var holiday_button = '<li><a onclick="remove_approved_holiday(this)" id="'+input_id+'"><button class="btn btn-primary">Remove Holiday</button></a></li>';
			}
			else if(holiday_status == '3')
			{
				// Add Holiday
				var holiday_button = '<li><a onclick="remove_sick_holiday(this)" id="'+input_id+'"><button class="btn btn-primary">Remove Sick Day</button></a></li>';
			}
			else
			{
				var holiday_button = '<li><a onclick="approved_holiday(this)" id="'+input_id+'"><button class="btn btn-primary">Click for Holiday</button></a></li><li><a onclick="approved_sick_holiday(this)" id="'+input_id+'"><button class="btn btn-primary">Click for Sick Day</button></a></li>';
			}
			
			if(check_td_class.indexOf('day_off_requested') > -1){
				var day_of_text = 'Remove Day Off';
			}
			else
			{
				var day_of_text = 'Day Off';
			}
			
			var Dayoff_button = '<li><a onclick="day_off_funtionality(this)" id="'+input_id+'"><button class="btn btn-primary" >'+day_of_text+'</button></a></li>';
			
			content_ul = '<div class="block"><ul class="block-options">'+holiday_button+'<li><a onclick="remove_week_shift(this)" id="'+input_id+'"><button class="btn btn-primary">Remove Shift</button></a></li><li><a onclick="clear_week_rota(this)" id="'+input_id+'"><button class="btn btn-primary">Clear Week</button></a></li><li><a onclick="copy_week_rota(this)" id="'+input_id+'"><button class="btn btn-primary">Copy Week</button></a></li><li><a onclick="copy_day_data(this)" id="'+input_id+'"><button class="btn btn-primary">Copy Day</button></a></li><li><a onclick="paste_day_data(this)" id="'+input_id+'"><button class="btn btn-primary">Paste</button></a></li>'+Dayoff_button+'<li><a onclick="see_clock_in_out_data(this)" id="'+input_id+'" class="show_clock_in_out_content"></a></li></ul></div><div class="row"><div class="col-sm-4"><label class="label-control ">Cross Charge/Other Site</label></div><div class="col-sm-3"><input type="text" class="form-control" value="" id="'+input_id+'" onchange="cross_charge_other_site(this)" name="other_site_pay"></div></div><div id="clock-break-modal" class="block"></div>';
			
			$('div#mouse-right-click-content').empty();
			$('div#mouse-right-click-content').append(content_ul);
			$('a.show_clock_in_out_content').click();
			
			
			 return false;
		}
		
		
		
	}
}

function copy_day_data(that)
{
	var input_id				= that.id;
	var we 						= '<?php echo $end_date;?>';
	var id_data					= input_id.split("_");
	var day_slice				= id_data.slice(0,1);
	var day						= day_slice.toString();
	var staff_id				= id_data.slice(2,3);
	staff_id					= staff_id.toString();
	var section					= id_data.slice(3,4);
	section						= section.toString();
	
	var start1 	= $('input#'+day+'_start_'+staff_id+'_'+section).val();
	var end1 	= $('input#'+day+'_end_'+staff_id+'_'+section).val();
	var start2 	= $('input#'+day+'_start2_'+staff_id+'_'+section).val();
	var end2 	= $('input#'+day+'_end2_'+staff_id+'_'+section).val();
	
	$('input#copy-start1').val(start1);
	$('input#copy-end1').val(end1);
	$('input#copy-start2').val(start2);
	$('input#copy-end2').val(end2);
	$('div.dropup').remove();
	$('button#close_right_click_modals').click();
}

function paste_day_data(that)
{
	var input_id				= that.id;
	var we 						= '<?php echo $end_date;?>';
	var id_data					= input_id.split("_");
	var day_slice				= id_data.slice(0,1);
	var day						= day_slice.toString();
	var staff_id				= id_data.slice(2,3);
	staff_id					= staff_id.toString();
	var section					= id_data.slice(3,4);
	section						= section.toString();
	
	var start1 	= $('input#copy-start1').val();
	var end1 	= $('input#copy-end1').val();
	var start2 	= $('input#copy-start2').val();
	var end2 	= $('input#copy-end2').val();
	$('input#'+day+'_start_'+staff_id+'_'+section).val(start1);
	$('input#'+day+'_end_'+staff_id+'_'+section).val(end1);
	$('input#'+day+'_start2_'+staff_id+'_'+section).val(start2);
	$('input#'+day+'_end2_'+staff_id+'_'+section).val(end2);
	
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url().'staff/ajax_paste_day_data'; ?>',
		data 	: { 'we':we, 'staff_id':staff_id, 'day':day, 'section':section, 'start1':start1, 'end1':end1, 'start2':start2, 'end2':end2 },
		success : function(response)
		{
			$('td#hours_'+staff_id+'_'+section).text(response);
			$('div.dropup').remove();
			$('button#close_right_click_modals').click();
			calculate_total_sum_hour(staff_id,section);
			total_pay_per_staff();
			
		}
	})
	
}

function approved_sick_holiday(that)
{
	var spin_rolling = '<p class="modal-popup-mouse-right-click-message"><i class="fa fa-sun-o fa-spin text-danger"></i> Sick Day Approving .....</p>';
	$('div#mouse-right-click-content').before(spin_rolling);
	var input_id				= that.id;
	var we 						= '<?php echo $end_date;?>';
	var id_data					= input_id.split("_");
	var day_slice				= id_data.slice(0,1);
	var day						= day_slice.toString();
	var staff_id				= id_data.slice(2,3);
	staff_id					= staff_id.toString();
	
	var section				= id_data.slice(3,4);
	section					= section.toString();
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url().'staff/ajax_sick_day_approved'; ?>',
		data 	: { 'we':we, 'staff_id':staff_id, 'day':day},
		success : function(result)
		{
			// alert(result);
			$('div.dropup').remove();
			$('input.hidden_section_id').each(function(){
				var section = this.value;
				if(section == 'blank')
				{
					section='';
				}
				// alert(section);
				var start = day+'_start_'+staff_id+'_'+section;
				var end = day+'_end_'+staff_id+'_'+section;
				var start2 = day+'_start2_'+staff_id+'_'+section;
				var end2 = day+'_end2_'+staff_id+'_'+section;
				
				$('input#'+start).css('background','rgba(255, 82, 0, 0.55)');
				$('input#'+end).css('background','rgba(255, 82, 0, 0.55)');
				$('input#'+start2).css('background','rgba(255, 82, 0, 0.55)');
				$('input#'+end2).css('background','rgba(255, 82, 0, 0.55)');
				
				var class_start_td = $('input#'+start).parent('td').prop('class');
				$('input#'+start).parent('td').addClass(class_start_td+' approved_sick_holiday');
				
				var class_start2_td = $('input#'+start2).parent('td').prop('class');
				$('input#'+start2).parent('td').addClass(class_start2_td+' approved_sick_holiday');
				var class_end_td = $('input#'+end).parent('td').prop('class');
				$('input#'+end).parent('td').addClass(class_end_td+' approved_sick_holiday');
				var class_end2_td = $('input#'+end2).parent('td').prop('class');
				$('input#'+end2).parent('td').addClass(class_end2_td+' approved_sick_holiday');
				
				disable_holiday_inputs();
				$('p.modal-popup-mouse-right-click-message').remove();
				$('button#close_right_click_modals').click();
			})
			
			
		}
	})
}

function approved_holiday(that)
{
	var spin_rolling = '<p class="modal-popup-mouse-right-click-message"><i class="fa fa-sun-o fa-spin text-danger"></i> Holiday Approving .....</p>';
	$('div#mouse-right-click-content').before(spin_rolling);
	var input_id				= that.id;
	var we 						= '<?php echo $end_date;?>';
	var id_data					= input_id.split("_");
	var day_slice				= id_data.slice(0,1);
	var day						= day_slice.toString();
	var staff_id				= id_data.slice(2,3);
	staff_id					= staff_id.toString();
	
	var section				= id_data.slice(3,4);
	section					= section.toString();
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url().'staff/ajax_rota_holiday_approved'; ?>',
		data 	: { 'we':we, 'staff_id':staff_id, 'day':day},
		success : function(result)
		{
			// alert(result);
			$('div.dropup').remove();
			$('input.hidden_section_id').each(function(){
				var section = this.value;
				if(section == 'blank')
				{
					section='';
				}
				// alert(section);
				var start = day+'_start_'+staff_id+'_'+section;
				var end = day+'_end_'+staff_id+'_'+section;
				var start2 = day+'_start2_'+staff_id+'_'+section;
				var end2 = day+'_end2_'+staff_id+'_'+section;
				$('input#'+start).css('background','rgba(0, 254, 255, 0.61)');
				$('input#'+end).css('background','rgba(0, 254, 255, 0.61)');
				$('input#'+start2).css('background','rgba(0, 254, 255, 0.61)');
				$('input#'+end2).css('background','rgba(0, 254, 255, 0.61)');
				
				var class_start_td = $('input#'+start).parent('td').prop('class');
				$('input#'+start).parent('td').addClass(class_start_td+' active_holiday_unapproved');
				
				var class_start2_td = $('input#'+start2).parent('td').prop('class');
				$('input#'+start2).parent('td').addClass(class_start2_td+' active_holiday_unapproved');
				var class_end_td = $('input#'+end).parent('td').prop('class');
				$('input#'+end).parent('td').addClass(class_end_td+' active_holiday_unapproved');
				var class_end2_td = $('input#'+end2).parent('td').prop('class');
				$('input#'+end2).parent('td').addClass(class_end2_td+' active_holiday_unapproved');
				
				disable_holiday_inputs();
				$('p.modal-popup-mouse-right-click-message').remove();
				$('button#close_right_click_modals').click();
			})
			
			
		}
	})
}

function day_off_funtionality(that)
{
	var input_id				= that.id;
	var we 						= '<?php echo $end_date;?>';
	var id_data					= input_id.split("_");
	var day_slice				= id_data.slice(0,1);
	var day						= day_slice.toString();
	var staff_id				= id_data.slice(2,3);
	staff_id					= staff_id.toString();
	
	var section				= id_data.slice(3,4);
	section					= section.toString();
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url().'ajax_day_off_request'; ?>',
		data 	: { 'we':we, 'staff_id':staff_id, 'day':day},
		success : function(result)
		{
			// alert(result);
			if(result == 'schdule_timing')
			{
				alert('You need to first clear timing of this day');
				return false;
			}
			
			// $('div.dropup').remove();
			$('input.hidden_section_id').each(function(){
				var section = this.value;
				if(section == 'blank')
				{
					section='';
				}
				// alert(section);
				var start = day+'_start_'+staff_id+'_'+section;
				var end = day+'_end_'+staff_id+'_'+section;
				var start2 = day+'_start2_'+staff_id+'_'+section;
				var end2 = day+'_end2_'+staff_id+'_'+section;
				
				if(result == 'inserted')
				{
					//$('input#'+start).css('background','#6c94f9');
					//$('input#'+end).css('background','#6c94f9');
					//$('input#'+start2).css('background','#6c94f9');
					//$('input#'+end2).css('background','#6c94f9');
				}
				
				
				
				var class_start_td = $('input#'+start).parent('td').prop('class');
				var class_start2_td = $('input#'+start2).parent('td').prop('class');
				var class_end_td = $('input#'+end).parent('td').prop('class');
				var class_end2_td = $('input#'+end2).parent('td').prop('class');
				
				if(result == 'inserted')
				{
					$('input#'+start).parent('td').addClass(class_start_td+' day_off_requested');
					$('input#'+start2).parent('td').addClass(class_start2_td+' day_off_requested');
					$('input#'+end).parent('td').addClass(class_end_td+' day_off_requested');
					$('input#'+end2).parent('td').addClass(class_end2_td+' day_off_requested');
				}
				else if(result == 'remove_off_day')
				{
					$('input#'+start).parent('td').removeClass('day_off_requested');
					$('input#'+start2).parent('td').removeClass('day_off_requested');
					$('input#'+end).parent('td').removeClass('day_off_requested');
					$('input#'+end2).parent('td').removeClass('day_off_requested');
					
					$('input#'+start).attr('readonly',false);
					$('input#'+end).attr('readonly',false);
					$('input#'+start2).attr('readonly',false);
					$('input#'+end2).attr('readonly',false);
				}
				
				disable_holiday_inputs();
				$('button#close_right_click_modals').click();
			})
			
			
		}
	})
}

function remove_week_shift(that){
	
	var input_id				= that.id;
	var we 						= '<?php echo $end_date;?>';
	var id_data					= input_id.split("_");
	var day_slice				= id_data.slice(0,1);
	var day						= day_slice.toString();
	var staff_id				= id_data.slice(2,3);
	staff_id					= staff_id.toString();
	
	var section				= id_data.slice(3,4);
	section					= section.toString();
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url().'staff/remove_week_shift'; ?>',
		data 	: { 'we':we, 'staff_id':staff_id,'section':section, 'day':day },
		success : function(result)
		{
			// alert(result);
			$('div.dropup').remove();
			$('input#'+day+'_start_'+staff_id+'_'+section).val('');
			$('input#'+day+'_end_'+staff_id+'_'+section).val('');
			$('input#'+day+'_start2_'+staff_id+'_'+section).val('');
			$('input#'+day+'_end2_'+staff_id+'_'+section).val('');
			$('button#close_right_click_modals').click();
		}
	})
	
}

$(document).ready(function() {
	 $("table.rota_ex_table")[0].oncontextmenu = function() { return false; }
    $("table.rota_ex_table td").click(function(){
		$('div.dropup').remove();
	})
});

// disabled all approve or unapproved holiday inputs
$(document).ready(function() {
	$('table td.active_holiday_approved input').attr('readonly',true);
	$('table td.active_holiday_unapproved input').attr('readonly',true);
	$('table td.approved_sick_holiday input').attr('readonly',true);
	$('table td.day_off_requested input').attr('readonly',true);
})

function disable_holiday_inputs()
{
	$('table td.active_holiday_approved input').attr('readonly',true);
	$('table td.active_holiday_unapproved input').attr('readonly',true);
	$('table td.active_holiday_unapproved input').val('');
	$('table td.approved_sick_holiday input').attr('readonly',true);
	$('table td.approved_sick_holiday input').val('');
	$('table td.day_off_requested input').attr('readonly',true);
}

function see_clock_in_out_data(that)
{
	var input_id				= that.id;
	var we 						= '<?php echo $end_date;?>';
	var id_data					= input_id.split("_");
	var day_slice				= id_data.slice(0,1);
	var day						= day_slice.toString();
	var staff_id				= id_data.slice(2,3);
	staff_id					= staff_id.toString();
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url().'ajax_see_clock_in_out_data'; ?>',
		data 	: { 'we':we, 'staff_id':staff_id, 'day':day},
		success : function(result)
		{
			
			$('div#clock-break-modal').empty();
			$('div#clock-break-modal').append(result);
			ajax_sum_hours(staff_id,day);
			ajax_other_site_data(staff_id,day,we);
		}
	})
}

function ajax_other_site_data(staff_id,day,we)
{
	$.ajax({
		type	: 'POST',
		url		: '<?php echo base_url()."staff/ajax_ajax_other_site_data";?>',
		data	: { 'staff_id':staff_id,'day':day,'we':we  },
		success	: function(response)
		{
			var paynow = parseFloat(response);
			$('div#mouse-right-click-content input[name="other_site_pay"]').val('£ '+paynow.toFixed(2));
		}
	})
}
// for autocalculate total pay per staff
function total_pay_per_staff()
{
	// alert('swdjegdasfgj');
	var we =  '<?php echo $end_date; ?>';
	$.ajax({
		type	: 'POST',
		url		: '<?php echo base_url()."ajax_total_pay_per_staff"; ?>',
		data	: { 'we':we },
		success	: function(response){
			var result_data = JSON.parse(response);
			$.each(result_data,function(i,k){
				// alert(i);
				// alert(k.sum_pay);
				var sum_pay = parseFloat(k.sum_pay)/100;
				$('td#total_pay_individual_staff-'+i).text('£ '+sum_pay.toFixed(2));
			})
			// alert(result_data[1065].staff_name);
			// $('td.pay-individual-staff').each(function(){
				// var td_id = this.id;
				// var td_split	= td_id.split("-");
				// var staff_id	= td_split.slice(1,2);
				// alert(result_data[staff_id].sum_pay);
				// if(result_data[staff_id].sum_pay)
				// {
					// var sum_pay = parseFloat(result_data[staff_id].sum_pay)/100;
					// $('td#total_pay_individual_staff-'+staff_id).text('£ '+sum_pay.toFixed(1));
				// }
			// })
				//vishnu_checking();
			
		}
	})
}

function total_previous_week_pay_per_staff()
{
	// alert('swdjegdasfgj');
	var we =  '<?php echo date('Y-m-d',strtotime($end_date.' -7 days')); ?>';
	$.ajax({
		type	: 'POST',
		url		: '<?php echo base_url()."ajax_total_pay_per_staff"; ?>',
		data	: { 'we':we },
		success	: function(response){
			var result_data = JSON.parse(response);
			$.each(result_data,function(i,k){
				
				var sum_pay = parseFloat(k.sum_pay)/100;
				var hours = k.total_hour;
				// $('td#total_pay_individual_staff-'+staff_id).text('£ '+sum_pay.toFixed(1));
				
			
				$('td#total_pay_individual_staff-'+i).attr('data-original-title','£ '+sum_pay.toFixed(1));
				$('td.total_hours_cal-'+i).attr('data-original-title',hours+' hrs');
				
			})
			// alert(result_data[1065].staff_name);
			// $('td.pay-individual-staff').each(function(){
				// var td_id = this.id;
				// var td_split	= td_id.split("-");
				// var staff_id	= td_split.slice(1,2);
				
				// var sum_pay = parseFloat(result_data[staff_id].sum_pay)/100;
				// var hours = result_data[staff_id].total_hour;
				// $('td#total_pay_individual_staff-'+staff_id).attr('data-original-title','£ '+sum_pay.toFixed(1));
				// $('td.total_hours_cal-'+staff_id).attr('data-original-title',hours+' hrs');
			// })
				
			
		}
	})
}

function ajax_sum_hours(staff_id,day)
{
	var we = '<?php echo $end_date; ?>';
	$.ajax({
		type	: 'POST',
		url		: '<?php echo base_url()."Clock_data/ajax_sum_hours_clockinout_new";?>',
		data	: {'staff_id':staff_id,'day':day,'we':we},
		success	: function(response)
		{
			var data = JSON.parse(response);
			var clock_in_out_hour = data['clock_in_out_hour'];
			var break_total_hour = data['break_total_hour'];
			$('th#clockinout_total_hour').text(clock_in_out_hour.toFixed(2)+' hours');
			$('th#break_total_hour').text(break_total_hour.toFixed(2)+' hours');
			$('span.total-breaks').tooltip();
			
		}
	})
}

function remove_sick_holiday(that)
{
	var input_id				= that.id;
	var we 						= '<?php echo $end_date;?>';
	var id_data					= input_id.split("_");
	var day_slice				= id_data.slice(0,1);
	var day						= day_slice.toString();
	var staff_id				= id_data.slice(2,3);
	staff_id					= staff_id.toString();
	
	var section				= id_data.slice(3,4);
	section					= section.toString();
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url().'staff/ajax_remove_sick_holiday'; ?>',
		data 	: { 'we':we, 'staff_id':staff_id, 'day':day},
		success : function(result)
		{
			// alert(result);
			$('div.dropup').remove();
			$('input.hidden_section_id').each(function(){
				var section = this.value;
				if(section == 'blank')
				{
					section='';
				}
				// alert(section);
				var start = day+'_start_'+staff_id+'_'+section;
				var end = day+'_end_'+staff_id+'_'+section;
				var start2 = day+'_start2_'+staff_id+'_'+section;
				var end2 = day+'_end2_'+staff_id+'_'+section;
				
				// $('input#'+start).css('background','rgba(255, 82, 0, 0.55)');
				// $('input#'+end).css('background','rgba(255, 82, 0, 0.55)');
				// $('input#'+start2).css('background','rgba(255, 82, 0, 0.55)');
				// $('input#'+end2).css('background','rgba(255, 82, 0, 0.55)');
				
				var class_start_td = $('input#'+start).parent('td').prop('class');
				$('input#'+start).parent('td').removeClass('approved_sick_holiday');
				$('input#'+start).attr('readonly',false);
				
				var class_start2_td = $('input#'+start2).parent('td').prop('class');
				$('input#'+start2).parent('td').removeClass('approved_sick_holiday');
				$('input#'+start2).attr('readonly',false);
				
				var class_end_td = $('input#'+end).parent('td').prop('class');
				$('input#'+end).parent('td').removeClass('approved_sick_holiday');
				$('input#'+end).attr('readonly',false);
				
				var class_end2_td = $('input#'+end2).parent('td').prop('class');
				$('input#'+end2).parent('td').removeClass('approved_sick_holiday');
				$('input#'+end2).attr('readonly',false);
				
				var classss_td = $('input#'+end2).parent('td').prop('class');
				if(classss_td == 'backgrond_dark')
				{
					var bg_color = 'rgba(175, 188, 200, 0.32)';
				}
				else
				{
					var bg_color = 'rgb(213, 245, 227)';
				}
				$('input#'+start).css('background',bg_color);
				$('input#'+end).css('background',bg_color);
				$('input#'+start2).css('background',bg_color);
				$('input#'+end2).css('background',bg_color);
				disable_holiday_inputs();
				$('button#close_right_click_modals').click();
			})
			
			
		}
	})
}

function remove_approved_holiday(that)
{
	var input_id				= that.id;
	var we 						= '<?php echo $end_date;?>';
	var id_data					= input_id.split("_");
	var day_slice				= id_data.slice(0,1);
	var day						= day_slice.toString();
	var staff_id				= id_data.slice(2,3);
	staff_id					= staff_id.toString();
	
	var section				= id_data.slice(3,4);
	section					= section.toString();
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url().'staff/ajax_remove_approved_holiday'; ?>',
		data 	: { 'we':we, 'staff_id':staff_id, 'day':day},
		success : function(result)
		{
			// alert(result);
			$('div.dropup').remove();
			$('input.hidden_section_id').each(function(){
				var section = this.value;
				if(section == 'blank')
				{
					section='';
				}
				// alert(section);
				var start = day+'_start_'+staff_id+'_'+section;
				var end = day+'_end_'+staff_id+'_'+section;
				var start2 = day+'_start2_'+staff_id+'_'+section;
				var end2 = day+'_end2_'+staff_id+'_'+section;
				
				// $('input#'+start).css('background','rgba(255, 82, 0, 0.55)');
				// $('input#'+end).css('background','rgba(255, 82, 0, 0.55)');
				// $('input#'+start2).css('background','rgba(255, 82, 0, 0.55)');
				// $('input#'+end2).css('background','rgba(255, 82, 0, 0.55)');
				
				var class_start_td = $('input#'+start).parent('td').prop('class');
				$('input#'+start).parent('td').removeClass('active_holiday_unapproved');
				$('input#'+start).attr('readonly',false);
				
				var class_start2_td = $('input#'+start2).parent('td').prop('class');
				$('input#'+start2).parent('td').removeClass('active_holiday_unapproved');
				$('input#'+start2).attr('readonly',false);
				
				var class_end_td = $('input#'+end).parent('td').prop('class');
				$('input#'+end).parent('td').removeClass('active_holiday_unapproved');
				$('input#'+end).attr('readonly',false);
				
				var class_end2_td = $('input#'+end2).parent('td').prop('class');
				$('input#'+end2).parent('td').removeClass('active_holiday_unapproved');
				$('input#'+end2).attr('readonly',false);
				
				var classss_td = $('input#'+end2).parent('td').prop('class');
				if(classss_td == 'backgrond_dark')
				{
					var bg_color = 'rgba(175, 188, 200, 0.32)';
				}
				else
				{
					var bg_color = 'rgb(213, 245, 227)';
				}
				$('input#'+start).css('background',bg_color);
				$('input#'+end).css('background',bg_color);
				$('input#'+start2).css('background',bg_color);
				$('input#'+end2).css('background',bg_color);
				disable_holiday_inputs();
				$('button#close_right_click_modals').click();
			})
			
			
		}
	})
}


function clear_week_rota(that)
{
	var input_id				= that.id;
	var we 						= '<?php echo $end_date;?>';
	var id_data					= input_id.split("_");
	var day_slice				= id_data.slice(0,1);
	var day						= day_slice.toString();
	var staff_id				= id_data.slice(2,3);
	staff_id					= staff_id.toString();
	
	var section				= id_data.slice(3,4);
	section					= section.toString();
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url().'staff/ajax_clear_week_rota'; ?>',
		data 	: { 'we':we, 'staff_id':staff_id, 'day':day},
		success : function(result)
		{
			// alert(result);
			$('div.dropup').remove();
			$('input.hidden_section_id').each(function(){
				var section = this.value;
				if(section == 'blank')
				{
					section='';
				}
				// alert(section);
				var start = day+'_start_'+staff_id+'_'+section;
				var end = day+'_end_'+staff_id+'_'+section;
				var start2 = day+'_start2_'+staff_id+'_'+section;
				var end2 = day+'_end2_'+staff_id+'_'+section;
				
				// $('input#'+start).css('background','rgba(255, 82, 0, 0.55)');
				// $('input#'+end).css('background','rgba(255, 82, 0, 0.55)');
				// $('input#'+start2).css('background','rgba(255, 82, 0, 0.55)');
				// $('input#'+end2).css('background','rgba(255, 82, 0, 0.55)');
				$('input#'+start).parent().parent('tr').find('input').val('');
				$('input#'+start).parent().parent('tr').find('input').attr('readonly',false);
				$('input#'+start).parent().parent('tr').find('td').removeClass('active_holiday_unapproved');
				$('input#'+start).parent().parent('tr').find('td').removeClass('approved_sick_holiday');
				$('input#'+start).parent().parent('tr').find('td').removeClass('active_holiday_approved');
				
				
			$('input#'+start).parent().parent('tr').find('td').each(function(){
				
				var classss_td = $(this).prop('class');
				if(classss_td == 'backgrond_dark')
				{
					var bg_color = 'rgba(175, 188, 200, 0.32)';
					$(this).css('background',bg_color);
					$(this).find('input').css('background',bg_color);
				}
				else if(classss_td == 'backgrond_light')
				{
					var bg_color = 'rgb(213, 245, 227)';
					$(this).css('background',bg_color);
					$(this).find('input').css('background',bg_color);
				}
				
				
				
			});
				
				disable_holiday_inputs();
				$('button#close_right_click_modals').click();
			})
			
			
		}
	})
}

function copy_week_rota(that)
{
	var input_id				= that.id;
	var we 						= '<?php echo $end_date;?>';
	var id_data					= input_id.split("_");
	var day_slice				= id_data.slice(0,1);
	var day						= day_slice.toString();
	var staff_id				= id_data.slice(2,3);
	staff_id					= staff_id.toString();
	
	var section				= id_data.slice(3,4);
	section					= section.toString();
	var start = day+'_start_'+staff_id+'_'+section;
	var i = 0;
	var sick_days = '';
	$('input#'+start).parent().parent('tr').find('td.approved_sick_holiday').each(function(){
		var input_sick_id = $(this).find('input').prop('id');
		
		sick_days = sick_days+input_sick_id+'_';
	})
	
	var approved_days = '';
	$('input#'+start).parent().parent('tr').find('td.active_holiday_unapproved').each(function(){
		var input_sick_id = $(this).find('input').prop('id');
		
		approved_days = approved_days+input_sick_id+'_';
	})
	
	
	var unapproved_days = '';
	$('input#'+start).parent().parent('tr').find('td.active_holiday_approved').each(function(){
		var input_sick_id = $(this).find('input').prop('id');
		
		unapproved_days = unapproved_days+input_sick_id+'_';
	})
	
	
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url().'staff/ajax_copy_week_rota'; ?>',
		data 	: { 'we':we, 'staff_id':staff_id, 'day':day,'sick_days':sick_days,'approved_days':approved_days,'unapproved_days':unapproved_days},
		success : function(result)
		{
			// alert(result);
			$('button#close_right_click_modals').click();
		}
	})
}

function cross_charge_other_site(that)
{
	var input_id				= that.id;
	var we 						= '<?php echo $end_date;?>';
	var id_data					= input_id.split("_");
	var day_slice				= id_data.slice(0,1);
	var day						= day_slice.toString();
	var staff_id				= id_data.slice(2,3);
	staff_id					= staff_id.toString();
	pay                         = that.value;
	var section				= id_data.slice(3,4);
	section					= section.toString();
	var start = day+'_start_'+staff_id+'_'+section;
	
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url().'staff/ajax_cross_charge_other_site'; ?>',
		data 	: { 'we':we, 'staff_id':staff_id, 'day':day,'pay':pay},
		success : function(response)
		{
			var paynow = parseFloat(response)/100;
			// alert(result);
			that.value = '£ '+paynow.toFixed(2);
		}
	})
}
</script>

<?php
if($payroll_confirmed == 1)
{
	?>
	<script>
	$(document).ready(function(){
		$('.payroll_dependent_inputs input').attr('disabled',true);
	})
	</script>
	<?php
}
?>	
<div class="copy-day-data">
	<input type="hidden" id="copy-start1">
	<input type="hidden" id="copy-end1">
	<input type="hidden" id="copy-start2">
	<input type="hidden" id="copy-end2">
</div>

<script>
function send_rota_publish_email()
{	
	// $.ajaxQ.abortAll();
	$('p#rota-publish-message').html('<i class="fa fa-2x fa-sun-o fa-spin text-danger"></i> Publishing....');
	$("button#rota-publish-close-button").click();
	$.ajax({
			type:'POST',
			url : '<?php echo base_url()."sending_publish_rota"; ?>',
			data: $('form#sending-rota-form').serialize(),
			success : function(response)
			{
				// if(response.search('Opsyte') > 0)
				// {
					// alert("Your session has been expired!");
					// location.reload();
				// }
				var company_name 	= $('form#sending-rota-form input[name="company_name"]').val();
				var user 			= $('form#sending-rota-form input[name="user"]').val();
				var message 		= $('form#sending-rota-form textarea[name="message"]').val();
				var staff_ids 		= $('input#email_only_send_to_staff').val();
				var arr = staff_ids.split(',');
				
				
				for(i=0; i < arr.length; i++){
					j = arr.length - 1;
					var published = '';
					if(j == i)
					{
						var published = 'published';
					}
					var b = i+1;
					$.ajax({
						type:'POST',
						url : '<?php echo base_url()."sending_rota_message_to_staff"; ?>',
						data: {'staff_id':arr[i],'we':'<?php echo $end_date; ?>','user':user,'company_name':company_name,'message':message,'published':published},
						success : function(response){
							
							// alert(i);
							// alert(arr.length);
							if(response){
								// if(response.search('Opsyte') > 0)
								// {
									// $('p#rota-publish-message-sent-to').text('Your session has been expired!');
									// location.reload();
									// return false;
								// }
								// $('form#sending-rota-form').remove();
								if(response != 'published')
								{
									$('p#rota-publish-message-sent-to').css('display','block');
									$('button#publish-rota-button').remove();
									$('p#rota-publish-message-sent-to').text(response);
								}
								else
								{
									$('button#publish-rota-button').remove();
									$('p#rota-publish-message').text('Rota successfully published');
									$('p#rota-publish-message-sent-to').remove();
								}
							}
							
						}
					})
				}
				
				
				
				
			}
	})
} 

function delete_shift_codes(id,that){
	var end_date = '<?php echo $end_date; ?>';
	if(confirm("Are you sure to delete") == true){
		$.ajax({
			type 	: 'POST',
			url 	: '<?php echo base_url().'delete_shift_codes'; ?>',
			data 	: { 'id':id, 'end_date':end_date },
			success : function(response){
				location.reload();
			}
		})
	}
}

function display_top_header_data(that){
	var i_class = $(that).find('i').prop('class');
	var i_link = $('a.hiddder-top').find('i');
	// alert(i_class);
	if(i_class == 'si si-frame'){
		i_link.prop('class','');
		i_link.prop('class','have_no_class');
		i_link.append('<img src="<?php echo base_url().'assets/img/favicons/expanded.png';?>">');
		$('tr.top_header_rota').css('display','none');
		$('tr.weather_row').css('display','none');
	}
	else if(i_class == 'have_no_class'){
		i_link.prop('class','');
		i_link.empty();
		i_link.prop('class','si si-frame');
		$('tr.top_header_rota').css('display','');
		$('tr.weather_row').css('display','');
	}
}

</script>

<script>
// var tableOffset = $("#table-1").offset().top;
// var $header = $("#table-1 > thead").clone();
// var $fixedHeader = $("#header-fixed").append($header);

// $(window).bind("scroll", function() {
    // var offset = $(this).scrollTop();
    
    // if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
        // $fixedHeader.show();
    // }
    // else if (offset < tableOffset) {
        // $fixedHeader.hide();
    // }
// });

function fixed_rota_header(z,that){
	// alert(z);
	if(z== '1')
	{
		// $('#header-fixed').css('position','fixed');
		// $('#header-fixed').css('top','70px');
		// $('#header-fixed').css('display','none');
		
		var tableOffset = $("#table-1").offset().top;
		var $header = $("#table-1 > thead").clone();
		$("#header-fixed").empty();
		var $fixedHeader = $("#header-fixed").append($header);

		$(window).bind("scroll", function() {
			var offset = $(this).scrollTop();
			
			if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
				$fixedHeader.slideDown(1500);
			}
			else if (offset < tableOffset) {
				$fixedHeader.hide();
			}
		});
		
		$("#header-fixed tr.top_header_rota").remove();
		$('#header-fixed tr.weather_row').remove();
		$('a.freeze-header').addClass('active');
		$(that).addClass('active');
		$(that).attr('id','0');
		$('a.freeze-header').attr('id','0');
	}
	else
	{
		$("#header-fixed").empty();
		$('#header-fixed').css('position','');
		$('#header-fixed').css('top','');
		$('#header-fixed').css('display','');
		$(that).attr('id','1');
		$('a.freeze-header').attr('id','1');
		$(that).removeClass('active');
		$('a.freeze-header').removeClass('active');
	}
	
	var table_width = $('table#table-1').width();
	$('table#header-fixed').css('width',table_width+'px');
	var get_class = $('table#table-1').prop('class');
	$('table#header-fixed').addClass(get_class);
	$('tr.for-getting-width td').each(function(){
		var index_td = $(this).index();
		var width_td = $(this).width();
		$('table#header-fixed tr.thead-getting-width td').eq(index_td).css('width',width_td+'px');
		// $('table#header-fixed tr.thead-getting-width td').eq(index_td).text(index_td);
		
	})
	
	
	// alert(.text());
	$('tr.for-getting-width td').css('height','0px');
	$('tr.thead-getting-width td').css('height','0px');
}
</script>

<style>
<!--
#header-fixed { 
    position: fixed;
    top: 70px; 
	display:none;
}
-->

</style>
<script>

$(document).ready(function(){
	var table_width = $('table#table-1').width();
	$('table#header-fixed').css('width',table_width+'px');
	var get_class = $('table#table-1').prop('class');
	$('table#header-fixed').addClass(get_class);
	$('tr.for-getting-width td').each(function(){
		var index_td = $(this).index();
		var width_td = $(this).width();
		$('table#header-fixed tr.thead-getting-width td').eq(index_td).css('width',width_td+'px');
		// $('table#header-fixed tr.thead-getting-width td').eq(index_td).text(index_td);
		
	})
	
	
	// alert(.text());
	$('tr.for-getting-width td').css('height','0px');
	$('tr.thead-getting-width td').css('height','0px');
})

function active_rota_weather(){
	var end_date = '<?php echo $end_date; ?>';
	var location = '<?php echo $weather_location ? $weather_location : 'London'; ?>';
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url().'staff_next/weather_forcast_rota'; ?>',
		data 	: {'end_date':end_date,'location':location},
		success : function(response){
			// alert(response);
			var data = JSON.parse(response);
			$.each(data,function(key,row){
				// alert(row.icon);
				// alert(row);
				if(row.icon)
				{
					$('th#weather_'+key).append('<img data-toggle="tooltip" data-placement="bottom" data-original-title="'+row.max_min_in_celcias+'" src="'+row.icon+'">');
					$('th#weather_'+key+' img').tooltip();
				}
			})
			
		}
	})
}

function calculate_total_pay_of_all(){
	var end_date = '<?php echo $this->uri->segment(2); ?>'
	$.ajax({
		type	: 'POST',
		url     : '<?php echo base_url()."ajax_total_of_pay_value_each_day";?>',
		data	: { 'end_date':end_date},
		success : function(response)
		{
			var ni_pension = '<?php echo $ni_pension; ?>'
			var data = JSON.parse(response);
			var mon_pay = data.mon_pay/100*ni_pension;
			var tue_pay = data.tue_pay/100*ni_pension;
			var wed_pay = data.wed_pay/100*ni_pension;
			var thu_pay = data.thu_pay/100*ni_pension;
			var fri_pay = data.fri_pay/100*ni_pension;
			var sat_pay = data.sat_pay/100*ni_pension;
			var sun_pay = data.sun_pay/100*ni_pension;
			
			var total_pay = (mon_pay + tue_pay + wed_pay + thu_pay + fri_pay + sat_pay + sun_pay)*ni_pension;
			
			$('td.total_mon_pay').text('£ '+mon_pay.toFixed(2));
			$('td.total_tue_pay').text('£ '+tue_pay.toFixed(2));
			$('td.total_wed_pay').text('£ '+wed_pay.toFixed(2));
			$('td.total_thu_pay').text('£ '+thu_pay.toFixed(2));
			$('td.total_fri_pay').text('£ '+fri_pay.toFixed(2));
			$('td.total_sat_pay').text('£ '+sat_pay.toFixed(2));
			$('td.total_sun_pay').text('£ '+sun_pay.toFixed(2));
			
			
			$('td.td-top-total-pay').text('£ '+(total_pay/ni_pension).toFixed(2));
						
		}
	})
}

active_rota_weather();
calculate_total_pay_of_all();
</script>
<script src="<?php echo base_url();?>assets/js/chart-both-line-bar/charts2.0.js"></script>
<script>
<?php
if($hourly_analysis == 1)
{
	echo 'load_hourly_labour_analised("'.$monday.'","mon");';
	echo 'load_hourly_labour_analised("'.$tuesday.'","tue");';
	echo 'load_hourly_labour_analised("'.$wednesday.'","wed");';
	echo 'load_hourly_labour_analised("'.date('Y-m-d',strtotime($end_date.' -3 days')).'","thu");';
	echo 'load_hourly_labour_analised("'.$friday.'","fri");';
	echo 'load_hourly_labour_analised("'.$saturday.'","sat");';
	echo 'load_hourly_labour_analised("'.$sunday.'","sun");';
}
?>

function get_load_hourly_labour_analised_data(date,day)
{
	$.ajax({
		type 	: 'POST',
		url 	: '<?php echo base_url()."Report/weekly_report_hourly_json/"; ?>'+date,
		data 	: {  },
		success : function(response)
		{
			$('input#'+day+'-get_load_hourly_labour_analised_data').val(response);
		}
	});
}

function load_hourly_labour_analised(date,day)
{
	
	//$('#chart_hourly_labour_analised').empty();
	get_load_hourly_labour_analised_data(date,day);
	
	$('canvas#'+day+'-chart_hourly_labour_analised').parent('div.'+day+'-graph_div').prepend('<p id="messageing_on_chart"><i class="fa fa-2x fa-cog fa-spin"></i> <strong>Chart is loading....</strong></p>');
	var myVar = [];
	
		myVar.day = setInterval(function(){
			var chart_data = $('input#'+day+'-get_load_hourly_labour_analised_data').val();
			if(chart_data)
			{
				$('div.'+day+'-graph_div p#messageing_on_chart').remove();
				get_load_chart(day);
				clearInterval(myVar.day);
			}
		}, 1000);
}

function get_load_chart(day){ 
	 var DataElements = JSON.parse($('input#'+day+'-get_load_hourly_labour_analised_data').val());
	 
	 var array_number_of_staff 		= [];
	 var average_labour_budget 		= [];
	 var average_labour_per_net 	= [];
	 var rota_day_setting_hourly 	= [];
	 var last_six_week_labour 		= [];
	 var count 						= 0;
	 $.each(DataElements.array_return_number_of_staff,function(key,row){
		array_number_of_staff[count] = row;
		average_labour_budget[count] = '<?php echo $labour_budget/100; ?>';
		count++;
		
	})
	
	
	count = 0;
	 $.each(DataElements.array_return_pay_of_every_hours,function(key,row){
		average_labour_per_net[count] = row;
		count++;
	})
	
	count = 0;
	 $.each(DataElements.get_rota_day_setting_hourly,function(key,row){
		rota_day_setting_hourly[count] = row;
		count++;
	})
	
	/*
	count = 0;
	 $.each(DataElements.array_labour_last_six_week,function(key,row){
		last_six_week_labour[count] = row;
		count++;
	})
	*/
	 
	 var barChartData = {
            labels: rota_day_setting_hourly,
            datasets: [{
                type: 'bar',
                  label: "Number of Staff",
                    data: array_number_of_staff,
                    fill: false,
                    backgroundColor: '#4471c4',
                    borderColor: '#4471c4',
                    hoverBackgroundColor: '#4471c4',
                    hoverBorderColor: '#4471c4',
                    yAxisID: 'y-axis-1'
            }, 
            {
                label: "Labour Budget",
                    type:'line',
                    data: average_labour_budget,
                    fill: false,
                    borderColor: '#ed7c30',
                    backgroundColor: '#ed7c30',
                    pointBorderColor: '#ed7c30',
                    pointBackgroundColor: '#ed7c30',
                    pointHoverBackgroundColor: '#ed7c30',
                    pointHoverBorderColor: '#ed7c30',
                    yAxisID: 'y-axis-1'
            } ,
            {
                label: "Labour %",
                    type:'line',
                    data: average_labour_per_net,
                    fill: false,
                    borderColor: '#f9bc05',
                    backgroundColor: '#f9bc05',
                    pointBorderColor: '#f9bc05',
                    pointBackgroundColor: '#f9bc05',
                    pointHoverBackgroundColor: '#f9bc05',
                    pointHoverBorderColor: '#f9bc05',
                    yAxisID: 'y-axis-1'
            } 
            /*,
            {
                label: "Historical Labour",
                    type:'line',
                    data: last_six_week_labour,
                    fill: false,
                    borderColor: '#a9a9a9',
                    backgroundColor: '#a9a9a9',
                    pointBorderColor: '#a9a9a9',
                    pointBackgroundColor: '#a9a9a9',
                    pointHoverBackgroundColor: '#a9a9a9',
                    pointHoverBorderColor: '#a9a9a9',
                    yAxisID: 'y-axis-1'
            } 
            */
            
            ]
        };
        
        //if (window.myBar) {
       // window.myBar.destroy();
    //  }
			
		var ctx = document.getElementById(day+"-chart_hourly_labour_analised").getContext("2d");
		window.myBar = new Chart(ctx, {
			type: 'bar',
			data: barChartData,
			options: {
			responsive: true,
			tooltips: {
			  mode: 'label'
		  },
		  elements: {
			line: {
				fill: false
			}
		},
		  scales: {
			xAxes: [{
				display: true,
				gridLines: {
					display: false
				},
				labels: {
					show: true,
				}
			}],
			yAxes: [{
				type: "linear",
				display: true,
				position: "left",
				id: "y-axis-1",
				gridLines:{
					display: false
				},
				labels: {
					show:true,
					
				}
			}] 
			
		}
		}
		});
		
		//$('input#get_load_hourly_labour_analised_data').val('');
}

function show_graph_of_day(day)
{
	$('canvas.display_graph_active').removeClass('display_graph_active');
	$('canvas#'+day+'-chart_hourly_labour_analised').addClass('display_graph_active');
	$('div#modal-load_hourly_labour_analised canvas').css('display','none');
	$('canvas#'+day+'-chart_hourly_labour_analised').css('display','block');
	
	var all_days = ['mon','tue','wed','thu','fri','sat','sun'];
	$.each(all_days , function(i,row){
		if(row == day)
		{
			$('div.'+row+'-graph_div p#messageing_on_chart').css('display','block');
		}
		else
		{
			$('div.'+row+'-graph_div p#messageing_on_chart').css('display','none');
		}
	})
	
	
}

</script>
<?php
require_once('colopicker_modals.php');
?>	

