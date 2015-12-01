
    
    <?php include("header.php"); ?>
    		
    		<style>
    			#run-stats {
	    			text-align: center;
    			}
	    		#run-stats fieldset {
		    		display:inline-block;
		    		vertical-align: top;
	    		}
	    		#run-stats table {
		    		background-color: #EAEAEA;
	    		}
	    		#run-stats table td,
	    		#run-stats table th {
		    		padding: 4px;
		    		border-bottom: 1px solid #525252;
	    		}
	    		#run-stats table td:first-child,
	    		#run-stats table th:first-child {
		    		border-right: 1px solid #fff;
	    		}
    		</style>
    	
	   
	        <h1 class="page-title">Run Stats</h1>
	        <p style="text-align:center;">Count column shows how many tests of each type have been run.</p>
			<div id="run-stats">
			
			<fieldset>
			<legend>Protocols</legend>
				<table>
					<thead><tr><th>Protocol</th><th>Count</th></tr></thead>
					<tbody>
					<?php
		            foreach($protocols as $row) {
		              ?>
		              <tr>
		              	<td><?php echo $row->protocol?></td>
		                <td><?php echo $row->count?></td>
		              </tr>
		              <?php }?>
					</tbody>
				</table>
			</fieldset>
			
			<fieldset>
			<legend>File Types</legend>
				<table>
					<thead><tr><th>File Type</th><th>Count</th></tr></thead>
					<tbody>
					<?php
		            foreach($fileTypes as $row) {
		              ?>
		              <tr>
		              	<td><?php echo $row->file_type?></td>
		                <td><?php echo $row->count?></td>
		              </tr>
		              <?php }?>
					</tbody>
				</table>
			</fieldset>
			
			<fieldset>
			<legend>Packet Sizes</legend>
				<table>
					<thead><tr><th>Packet Size(kB)</th><th>Count</th></tr></thead>
					<tbody>
					<?php
		            foreach($pktSizes as $row) {
		              ?>
		              <tr>
		              	<td><?php echo $row->pkt_size?></td>
		                <td><?php echo $row->count?></td>
		              </tr>
		              <?php }?>
					</tbody>
				</table>
			</fieldset>
			
			<fieldset>
			<legend>Encryptions Used</legend>
				<table>
					<thead><tr><th>Encryption</th><th>Count</th></tr></thead>
					<tbody>
					<?php
		            foreach($encryptions as $row) {
		              ?>
		              <tr>
		              	<td><?php echo $row->encryption_used?></td>
		                <td><?php echo $row->count?></td>
		              </tr>
		              <?php }?>
					</tbody>
				</table>
			</fieldset>
			
			<fieldset>
			<legend>File Sizes</legend>
				<table>
					<thead><tr><th>File Sizes(kB)</th><th>Count</th></tr></thead>
					<tbody>
					<?php
		            foreach($fileSizes as $row) {
		              ?>
		              <tr>
		              	<td><?php echo $row->file_size?></td>
		                <td><?php echo $row->count?></td>
		              </tr>
		              <?php }?>
					</tbody>
				</table>
			</fieldset>
			
			
	    
		    
	    
			</div>
	<?php include("footer.php"); ?>
	    
    	