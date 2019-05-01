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
                        <h1>Receipt</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                          <li><a href="administrator/">Dashboard</a></li>
                          <li class="active">Receipt</li>
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
        <div class="col-lg-12 receipt">
            <div class="card">
              <div class="card-body card-block">
                <p align="center" style="font-size:19px">Official Receipt</p>
              <table style="width:100%">
                <tr>
                    <td>
                        <h6>Account No.:</h6> <span class="p-1"><?php echo $consumer->account_number ?></span>
                    </td>
                    <td>
                        <h6>Name:</h6> <span class="p-1"><?php echo $consumer->lastname. ', ' . $consumer->firstname ?></span>
                    </td>
                </tr>
              </table>
                    
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <th>Period From</th>
                        <th>Period To</th>
                        <th>Previous Reading</th>
                        <th>Present Reading</th>
                        <th>Consumption</th>
                        <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $totalbill = 0;
                        foreach($records as $record){ ?>
                        <tr>
                            <td><?php echo $record->previous_date ?></td>
                            <td><?php echo $record->present_date ?></td>
                            <td><?php echo $record->previous_meter ?></td>
                            <td><?php echo $record->present_meter ?></td>
                            <td><?php echo $record->consumption ?></td>
                            <td><?php echo '₱'.$record->bill ?></td>
                            <?php $totalbill += $record->bill; ?>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                    <div class="row">
                        <div class="col-md-3 offset-md-5">
                            <input type="hidden" name="totalbill" id="totalbill" value="<?php echo $totalbill ?>">
                            Total Amount: <?php echo '₱'.$totalbill; ?>
                        </div>
                        <div class="col-md-2">
                            <input type="hidden" name="totalbill" id="totalbill" value="<?php echo $totalbill ?>">
                            Cash: <?php echo '₱'.$hcash; ?>
                        </div>
                        <div class="col-md-2">
                            <input type="hidden" name="totalbill" id="totalbill" value="<?php echo $totalbill ?>">
                            Change: <?php echo '₱'.$hchange; ?>
                        </div>
                    </div><hr>
                    <div class="col-md-6">
                        <input type="hidden" name="totalbill" id="totalbill" value="<?php echo $totalbill ?>">
                        Teller: <?php echo $teller->fullname; ?>
                    </div>
                    <div class="col-md-2 offset-md-4">
                        <button type="button" class="btn btn-primary no-print" id="printb" onclick="jQuery('.receipt').print()"><span class="ti ti-printer"></span> PRINT</button>
                    </div>
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
<script type="text/javascript" src="assets/js/print.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#modal1').click(function(){
      $('#submit').click();
    });
    $( ".datepicker" ).datepicker({
      dateFormat: 'yy-mm-dd'
    });
    $('#cash').keyup(function() {
        var change = $('#cash').val() - $('#totalbill').val()
        $('#change').html(Math.round(change * 100) / 100)
        if(change >=0){
            $('#pay').removeAttr('disabled')
        }else{
            $('#change').html('0.00')
        }
        if($('#cash').val()==''){
            $('#change').html('0.00')
        }
    });
    $("#printb").find('button').on('click', function() {
      $(".receipt").print();
    });
  })
</script>