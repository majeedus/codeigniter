<?php include('header.php');?>

<div class="panel panel-info" >
  <div class="panel-heading">
    <div class="panel-title">Custom Query</div>
  </div>

  <div style="padding-top:30px" class="panel-body" >

    <form id="searchForm" class="form-horizontal" action="<?php echo base_url('index.php/searchQuery/graph'); ?>" method="post">
      <div class="form-group">
        <label class="col-md-4 control-label" for="protocol">Protocol</label>
        <div class="col-md-2">
          <select id="protocol" name="protocol[]" class="form-control" multiple="multiple">
            <?php foreach($protocols as $row) { ?>
              <option value="<?php echo $row->protocol; ?>"><?php echo $row->protocol; ?></option>
              <?php }?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-4 control-label" for="time">Time</label>
          <div class="col-md-4">
            <select id="time" name="time" class="form-control">
              <option value="total_time">Total Time</option>
              <option value="send_time">Send Time</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-4 control-label" for="encrypted">Encryption Used</label>
          <div class="col-md-4">
            <select id="encrypted" name="encrypted" class="form-control">
              <?php foreach($encryptions as $row) { ?>
                <option value="<?php echo $row->encryption_used; ?>" selected="<?php echo $row->encryption_used === "None" ?>"><?php echo $row->encryption_used; ?></option>
                <?php }?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Minimum Package Size</label>
            <div class="col-md-4">
              <select id="min_package" name="min_package" class="form-control">
                <?php foreach($pktSizes as $row) { ?>
                  <option value="<?php echo $row->pkt_size; ?>"><?php echo $row->pkt_size . " KB"; ?></option>
                  <?php }?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label" for="textinput">Maximum Package Size</label>
              <div class="col-md-4">
                <select id="max_package" name="max_package" class="form-control">
                  <?php
                  $len = count($pktSizes); $i = 0;
                  foreach($pktSizes as $row) {  $i++; ?>
                    <option value="<?php echo $row->pkt_size; ?>" selected="<?php echo ($i == $len - 1)?>"><?php echo $row->pkt_size . " KB"; ?></option>
                    <?php }?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label" for="fileSelect">File Type</label>
                <div class="col-md-4">
                  <select id="fileSelect" name="file_type[]" class="form-control" multiple="multiple">
                    <?php foreach($fileTypes as $row) { ?>
                      <option value="<?php echo $row->file_type; ?>"><?php echo $row->file_type; ?></option>
                      <?php }?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div style="margin-top:10px" class="form-group">
                  <div class="col-sm-12 controls">
                    <input class="btn btn-success" type="submit" value="Query"/>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
<script>
  $(document).ready(function(){

  })
</script>
