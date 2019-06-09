<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('layout/header'); ?>
<body>

    <?php $this->load->view('layout/admin-consumers'); ?>

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <?php $this->load->view('layout/user'); ?>
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Add Consumer</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                          <li><a href="administrator/">Dashboard</a></li>
                          <li class="active">Add Consumer</li>
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
        <div class="col-lg-8">
          <form action="administrator/updateconsumer/" method="post" class="form-horizontal">
            <div class="card">
              <div class="card-header">
                <strong>Add Consumer</strong> Form
              </div>
              <div class="card-body card-block">
                <input type="hidden" name="consumer_id" value="<?php echo $consumer->id ?>">
                <div class="row form-group">
                  <div class="col col-md-4"><label for="acct_number" class=" form-control-label">Account Number</label></div>
                  <div class="col-12 col-md-8"><input type="number" value="<?php echo $consumer->account_number ?>" id="acct_number" name="acct_number" placeholder="Account Number" class="form-control" required></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="firstname" class=" form-control-label">First Name</label></div>
                  <div class="col-12 col-md-8"><input type="text" value="<?php echo $consumer->firstname ?>" value="<?php echo $consumer->account_number ?>" id="firstname" name="firstname" placeholder="First Name" class="form-control text-capitalize" required></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="middlename" class=" form-control-label">Middle Name</label></div>
                  <div class="col-12 col-md-8"><input type="text" value="<?php echo $consumer->middlename ?>" value="<?php echo $consumer->account_number ?>" id="middlename" name="middlename" placeholder="Middle Name" class="form-control text-capitalize"></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="lastname" class=" form-control-label">Last Name</label></div>
                  <div class="col-12 col-md-8"><input type="text" value="<?php echo $consumer->lastname ?>" value="<?php echo $consumer->account_number ?>" id="lastname" name="lastname" placeholder="Last Name" class="form-control text-capitalize" required></div>
                </div>
                <!-- <div class="row form-group">
                  <div class="col col-md-4"><label for="birthdate" class=" form-control-label">Birthdate</label></div>
                  <div class="col-12 col-md-8"><input type="date" id="birthdate" format="dd/mm/yyyy" name="birthdate" placeholder="Birthdate" class="form-control datepicker" required></div>
                </div> -->
                <div class="row form-group">
                  <div class="col col-md-4"><label for="address" class=" form-control-label">House #, Street</label></div>
                  <div class="col-12 col-md-8"><input type="text" value="<?php echo substr($consumer->address, 0,strrpos($consumer->address, ' Cogon, Ormoc City')); ?>" id="address" name="address" placeholder="House #, Street" class="form-control text-capitalize" required></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="address" class=" form-control-label">Barangay, City</label></div>
                  <div class="col-12 col-md-8"><input type="text" value=" Cogon, Ormoc City" id="address2" name="address2" placeholder="Barangay, City" value=" Cogon, Ormoc City" class="form-control text-capitalize" required></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="contact" class=" form-control-label">Contact Number</label></div>
                  <div class="col-12 col-md-8"><input type="text" value="<?php echo $consumer->contactNumber ?>" id="contact" name="contact" placeholder="Contact Number" class="form-control" required></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="email" class=" form-control-label">Email Address</label></div>
                  <div class="col-12 col-md-8"><input type="email" value="<?php echo $consumer->email ?>" id="email" name="email" placeholder="Email Address" class="form-control" required></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="hf-classification" class=" form-control-label">Classification</label></div>
                  <div class="col-12 col-md-8">
                    <select class="form-control" name="classification" required>
                      <option value="">Select Account Type</option>
                      <option value="Residential" selected>Residential</option>
                      <option value="Commercial" disabled>Commercial</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                  <i class="ti ti-arrow-right"></i> Continue
                </button>
                <input type="submit" name="submit" id="submit" style="display:none">
                <button type="reset" class="btn btn-danger btn-sm">
                  <i class="fa fa-ban"></i> Reset
                </button>
              </div>
            </div>
          </form>
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
      maxDate: 0,
      dateFormat: 'yy-mm-dd'
    });
  })
</script>
