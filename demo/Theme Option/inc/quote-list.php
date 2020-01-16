<?php
function quote_list_callback(){ ?>
	<div class="admin-page-wrap">
<div id="wpms-entryform">
    </div>
	<div class="admin-page-inner" id="msentry-showtab">
		<div class="ap-heading-wrap">
			<h3 class="heading mshead">Auto Finance Lending Quote List</h3>
		</div>
		<div class="ap-content-wrap">
		    <div class="responsive-table">
				<table id="ms-dt" class="ms-dt tabl-border table table-bordered">
					<thead><tr><th>Borrow</th><th>Finance</th><th>Title</th><th>First name</th><th> Last name</th><th>Phone number</th><th>Email</th><th>DOB</th><th>Marital status</th><th>Email By</th><th>Sms By</th><th>Time month</th><th>Employee time month</th><th>Postal code</th><th>Emp Name </th><th>Emp occupation</th><th>Emp monthly income</th><th>Emp Status</th><th>Residential address</th><th>Licence type</th><th>TC</th><th>Submission Date</th>
					<thead>
					<tbody></tbody>
				</table>
			</div>
		</div>	
	</div>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		initTable();
	});
	var initTable = function () {
		var table = jQuery('#ms-dt');
		var oTable = table.dataTable({
			"processing": true,
			"serverSide": true,
			"ajax":  '<?php echo admin_url( 'admin-ajax.php' );?>?action=msdata',
			'responsive': true,
			"columns": [
					{"data":'borrow'},
					{"data":'finance'},
					{"data":'title'},
					{"data":'first_name'},
					{"data":'last_name'},
					{"data":'phone_number'},
					{"data":'email'},
					{"data":'dob_number'},
					{"data":'gender'},
					{"data":'email_by'},
					{"data":'sms_by'},
					{"data":'time_month'},
					{"data":'emp_time_month'},
					{"data":'postal_code'},
					{"data":'emp_name'},
					{"data":'emp_occupation'},
					{"data":'emp_monincome'},
					{"data":'emp_status'},
					{"data":'residen_address'},
					{"data":'driv_lice'},
					{"data":'term_con'},
					{"data":'submission_date'},
				],
			 "order": [
				[0, 'asc']
			],
			
			"lengthMenu": [
				[10, 25, 50, 100, "All"],
				[10, 25, 50, 100, "All"] // change per page values here
			],
			// set the initial value
			"pageLength": 25,
		});
	}
</script>
<?php }
?>