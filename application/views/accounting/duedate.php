<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('layout/header'); ?>
<body>

    <?php $this->load->view('layout/accounting-due'); ?>

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <?php $this->load->view('layout/user'); ?>
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Disconnection</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                          <li><a href="administrator/">Dashboard</a></li>
                          <li class="active">Disconnection</li>
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
        <div class="col-lg-12"><br>
            <a href="accounting/notifydueconsumers" class="btn btn-info text-white"><span class="ti ti-announcement"></span> Send notification to unsent consumers</a>
            <br><br>
            <div class="card">
              <div class="card-body card-block">
                <table class="table table-bordered" id="bootstrap-data-table">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Contact Number</th>
                      <th>Due Date</th>
                      <th>Notification</th>
                      <!-- <th>Action</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($due as $d) { ?>
                    <tr>
                        <td><?php echo $d->firstname. ' ' .$d->lastname ?></td>
                        <td><?php echo $d->address ?></td>
                        <td><?php echo $d->contactNumber ?></td>
                        <td><?php echo date('F d, Y', strtotime($d->due_date)) ?></td>
                        <td><?php 
                            if($d->due_notif == 'Sent'){
                                ?><span class="text-info"><?php echo $d->due_notif ?></span><?php
                            }else{
                                ?><span class="text-danger"><?php echo $d->due_notif ?></span><?php
                            }
                        ?></td>
                        <!-- <td>
                            <a href="teller/records/<?php echo $d->id ?>" class="btn btn-primary">Records</a>
                            <a href="teller/paymentdetails/<?php echo $d->id ?>" class="btn btn-info">Payment</a>
                        </td> -->
                    </tr>
                  <?php } ?>
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
