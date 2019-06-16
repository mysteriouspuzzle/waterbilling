<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('layout/header'); ?>
<body>

    <?php $this->load->view('layout/accounting-recon'); ?>

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
            <a href="accounting/notifydiscoconsumers" class="btn btn-info text-white"><span class="ti ti-announcement"></span> Send notification to unsent consumers</a>
            <br><br>
            <div class="card">
              <div class="card-body card-block">
                <table class="table table-bordered" id="bootstrap-data-table">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Contact Number</th>
                      <th>Disconnection Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($disco as $dc) { ?>
                    <tr>
                        <td><?php echo $dc->firstname. ' ' .$dc->lastname ?></td>
                        <td><?php echo $dc->address ?></td>
                        <td><?php echo $dc->contactNumber ?></td>
                        <td><?php echo date('F d, Y',strtotime(date('Y-m-d', strtotime($dc->due_date))." +3 month")) ?></td>
                        <td>
                          <a href="accounting/reconnect/<?php echo $dc->id ?>" class="btn btn-danger"><span class="ti ti-link"></span> Reconnect</a>
                        </td>
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
