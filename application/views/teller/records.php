<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('layout/header'); ?>
<body>

    <?php $this->load->view('layout/teller-consumers'); ?>

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <?php $this->load->view('layout/user'); ?>
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>View Consumers</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                          <li><a href="administrator/">Dashboard</a></li>
                          <li class="active">View Consumers</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
          <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-success">
               <a href="#" class="close" data-dismiss="alert">&times;</a>
               <span class="ti ti-check"></span> <?php echo $this->session->flashdata('success'); ?>
           </div>
          <?php } ?>
        </div>
        <div class="col-lg-12">
            <div class="card">
              <div class="card-body card-block">
                <table class="table table-striped table-hover" id="bootstrap-data-table">
                    <thead>
                        <tr>
                        <th>Period From</th>
                        <th>Period To</th>
                        <th>Previous Reading</th>
                        <th>Present Reading</th>
                        <th>Consumption</th>
                        <th>Total Amount</th>
                        <th>Due Date</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if(count($records) == 0){
                        ?><tr>
                            <td colspan="7">No bills available.</td>
                        </tr><?php
                    }else{
                        foreach($records as $record){ ?>
                            <tr>
                            <td><?php echo $record->previous_date ?></td>
                            <td><?php echo $record->present_date ?></td>
                            <td><?php echo $record->previous_meter ?></td>
                            <td><?php echo $record->present_meter ?></td>
                            <td><?php echo $record->consumption ?></td>
                            <td><?php echo '₱'.$record->bill ?></td>
                            <td><?php echo $record->due_date ?></td>
                            <?php if($record->status == 'Unpaid'){ ?>
                                <td><a href="consumer/paymentdetails/<?php echo $record->bill_id ?>" class="btn btn-info">Pay</a></td>
                            <?php }else{ ?>
                                <td>Paid</td>
                            <?php } ?>
                            </tr>
                        <?php } 
                    } ?>
                    </tbody>
                </table>
              </div>
            </div>
        </div>

      </div> <!-- .content -->
    </div><!-- /#right-panel -->
    <?php $this->load->view('layout/footer'); ?>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="mediumModalLabel">Confirm first</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  Are you sure?
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="button" id="modal1" class="btn btn-primary">Confirm</button>
              </div>
          </div>
      </div>
  </div>
<script type="text/javascript" src="assets/js/vendor/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets/js/validator.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#modal1').click(function(){
      $('#submit').click();
    });
    $( ".datepicker" ).datepicker({
      dateFormat: 'yy-mm-dd'
    });
  })
</script>
