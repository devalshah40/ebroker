<hr class="noscreen" />

	<!-- Columns -->
	<div id="cols" class="box">

		<!-- Aside (Left Column) -->
		<div id="aside" class="box">

			<div class="padding box">

				<!-- Logo (Max. width = 200px) -->
				<p id="logo"><a href="#"><img src="tmp/logo.gif" alt="Our logo" title="Visit Site" /></a></p>

				<!-- Search -->
				<form action="manage_search.php" method="get" id="search">
					<fieldset>
						<legend>Search</legend>
						<style type="text/css">
						.col {float: left;padding-right: 5px;}
						</style>
						<p><input type="text" size="17" name="query_value" class="input-text" />&nbsp;<input type="submit" value="OK" class="input-submit-02" /><br />
						<a href="javascript:toggle('search-options');" class="ico-drop">Advanced search</a></p>

						<!-- Advanced search -->
						<div id="search-options" style="display:none;" >
								<div  class="col">
								        <div><label><input type="checkbox"  name="clients" />Clients</label><br /></div>
								        <div><label><input type="checkbox" name="transactions" />Transactions</label><br /></div>
								        <div><label><input type="checkbox" name="greetings" />Greetings </label<br /></div>
                                </div>
                                <div class="col">
								        <label><input type="checkbox" name="tasks"/>Tasks</label><br />
								        <label ><input type="checkbox" name="vendors"  />Vendors</label><br />
								        <label><input type="checkbox" name="payments"/>Payments</label><br />
						        </div> 
						</div><!-- /search-options -->
					</fieldset>
				</form>

				<!-- Create a new project -->
				<p id="btn-create" class="box"><a href="manage_clients.php?action=view"><span>Create a new Client</span></a></p>
				<p id="btn-create" class="box"><a href="manage_vendors.php?action=view"><span>Create a new Vendor</span></a></p>
				<p id="btn-create" class="box"><a href="manage_transactions.php?action=view"><span>Create a new Transaction</span></a></p>
				<p id="btn-create" class="box"><a href="manage_payments.php?action=view"><span>Create a new Payments</span></a></p>

			</div> <!-- /padding -->

			<ul class="box">
				<li id="submenu-active"><a href="#">Reports</a> <!-- Active -->
					<ul>
						<li><a href="manage_reports.php?action=client">Client Report</a></li>
						<li><a href="manage_reports.php?action=vendor">Vendor Report</a></li>
						<li><a href="manage_reports.php?action=month">Monthly Report</a></li>
						<li><a href="manage_reports.php?action=quarter">Quaterly Report</a></li>
						<li><a href="manage_reports.php?action=year">Annual Report</a></li>
					</ul>
				</li>
			</ul>

		</div> <!-- /aside -->
