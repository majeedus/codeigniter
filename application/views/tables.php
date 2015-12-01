<?php include("header.php"); ?>

<?php //create a csv file
$fp = fopen('table.csv', 'w');
foreach ($rows as $fields) {
  fputcsv($fp, (array)$fields);
}
fclose($fp);
?>
<h1 class="page-title">Results Table</h1>
<!-- /.panel-heading -->
<div class="panel-body">
  <div class="dataTable_wrapper" style="margin:20px;">
    <table class="table table-striped table-bordered table-hover" id="ford-table">
      <thead>
        <tr>
          <th>Protocol</th>
          <th>File Type</th>
          <th>Encryption Used</th>
          <th>Channel Effect</th>
          <th>File size (kB)</th>
          <th>Packet size (kB)</th>
          <th>Packets sent</th>
          <th>Total Time (sec)</th>
          <th>Sending Time (sec)</th>
          <th>TimeStamp</th>
        </tr>
      </thead>
      <tbody>

        <?php
        foreach($rows as $row) {
          ?>
          <tr class="gradeX">
            <td><?php echo $row->protocol?></td>
            <td><?php echo $row->file_type?></td>
            <td><?php echo $row->encryption_used?></td>
            <td><?php echo $row->channel_effect?></td>
            <td><?php echo $row->file_size?></td>
            <td><?php echo $row->pkt_size?></td>
            <td><?php echo $row->pkts_sent?></td>
            <td><?php echo $row->total_time?></td>
            <td><?php echo $row->send_time?></td>
            <td><?php echo $row->ModifiedTime?></td>
          </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
    <a href="<?php echo base_url('table.csv');?>" download="table.csv"><button class="btn btn-primary">Download Table</button></a>
  </div>
</div>



<!-- jQuery -->
<script src="<?php echo base_url('application/third_party/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('application/third_party/bootstrap/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('application/third_party/data-tables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('application/third_party/data-tables/dataTables.bootstrap.min.js'); ?>"></script>
<script>
$(document).ready(function() {
  $('#ford-table').DataTable({
    responsive: true
  });
});
</script>

<?php include("footer.php"); ?>
