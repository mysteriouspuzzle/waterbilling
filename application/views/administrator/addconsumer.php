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
          <div class="qrcode">
            <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=/waterbilling/reader/readmeter/<?php echo $this->session->flashdata('in') ?>&choe=UTF-8" alt="">
          </div>
          <button onclick="jQuery('.qrcode').print()" id="printqr" class="btn btn-primary"><span class="fa fa-print"></span> Print</button>
          <?php 
          
          } 
          ?>
          
        </div>
        <div class="col-lg-8">
          <form action="administrator/storeconsumer" method="post" class="form-horizontal">
            <div class="card">
              <div class="card-header">
                <strong>Add Consumer</strong> Form
              </div>
              <div class="card-body card-block">
                <div class="row form-group">
                  <div class="col col-md-4"><label for="acct_number" class=" form-control-label">Account Number</label></div>
                  <div class="col-12 col-md-8"><input type="number" value="<?php echo $account_number ?>" id="acct_number" name="acct_number" placeholder="Account Number" class="form-control" required></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="firstname" class=" form-control-label">First Name</label></div>
                  <div class="col-12 col-md-8"><input type="text" id="firstname" name="firstname" placeholder="First Name" class="form-control text-capitalize" required></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="middlename" class=" form-control-label">Middle Name</label></div>
                  <div class="col-12 col-md-8"><input type="text" id="middlename" name="middlename" placeholder="Middle Name" class="form-control text-capitalize"></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="lastname" class=" form-control-label">Last Name</label></div>
                  <div class="col-12 col-md-8"><input type="text" id="lastname" name="lastname" placeholder="Last Name" class="form-control text-capitalize" required></div>
                </div>
                <!-- <div class="row form-group">
                  <div class="col col-md-4"><label for="birthdate" class=" form-control-label">Birthdate</label></div>
                  <div class="col-12 col-md-8"><input type="date" id="birthdate" format="dd/mm/yyyy" name="birthdate" placeholder="Birthdate" class="form-control datepicker" required></div>
                </div> -->
                <!-- <div class="row form-group">
                  <div class="col col-md-4"><label for="address" class=" form-control-label">House #, Street</label></div>
                  <div class="col-12 col-md-8"><input type="text" id="address" name="address" placeholder="House #, Street" class="form-control text-capitalize" required></div>
                </div> -->
                <div class="row form-group">
                  <div class="col col-md-4"><label for="hf-classification" class=" form-control-label">Street</label></div>
                  <div class="col-12 col-md-8">
                    <select class="form-control" name="address" required>
                      <option value="">Select Street</option>
                      <option value="Acasia">Acasia</option>
                      <option value="Alupang St.">Alupang St.</option>
                      <option value="Aquino">Aquino</option>
                      <option value="Aranga St.">Aranga St.</option>
                      <option value="Aunubing St.">Aunubing St.</option>
                      <option value="Aviles Village">Aviles Village</option>
                      <option value="Bilwang St.">Bilwang St.</option>
                      <option value="Bansalaguin St.">Bansalaguin St.</option>
                      <option value="Banuyo St.">Banuyo St.</option>
                      <option value="Batitingan">Batitingan</option>
                      <option value="Bayong St.">Bayong St.</option>
                      <option value="BFP">BFP</option>
                      <option value="Bolongeta">Bolongeta</option>
                      <option value="Bungawong">Bungawong</option>
                      <option value="Calamansanoy">Calamansanoy</option>
                      <option value="Capahis Residence">Capahis Residence</option>
                      <option value="City Engineering Office">City Engineering Office</option>
                      <option value="DC. Marsons Residence">DC. Marsons Residence</option>
                      <option value="Fautino Ablen">Fautino Ablen</option>
                      <option value="Gillamacs Marketing">Gillamacs Marketing</option>
                      <option value="Lilia Avenue">Lilia Avenue</option>
                      <option value="Matio Tans Residence">Matio Tans Residence</option>
                      <option value="Ormoc Distric Hospital">Ormoc Distric Hospital</option>
                      <option value="Purok Chrysanthemum">Purok Chrysanthemum</option>
                      <option value="Purok Dama de Noche">Purok Dama de Noche</option>
                      <option value="Purok Ilang-ilang 1">Purok Ilang-ilang 1</option>
                      <option value="Purok Ilang-ilang 2">Purok Ilang-ilang 2</option>
                      <option value="Purok Jasmin">Purok Jasmin</option>
                      <option value="Purok Rosal">Purok Rosal</option>
                      <option value="Purok Sampaguita">Purok Sampaguita</option>
                      <option value="Purok Dalhia">Purok Dalhia</option>
                      <option value="Tennis Court">Tennis Court</option>
                      <option value="Toni Con-uis Residence">Toni Con-uis Residence</option>
                      <option value="Tony Codillas Residence">Tony Codillas Residence</option>
                      <option value="Tugonons Residence">Tugonons Residence</option>
                      <option value="Wennie Codilla Residence">Wennie Codilla Residence</option>
                    </select>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="address" class=" form-control-label">Barangay, City</label></div>
                  <div class="col-12 col-md-8"><input type="text" id="address2" name="address2" placeholder="Barangay, City" value=" Cogon, Ormoc City" class="form-control text-capitalize" required></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="contact" class=" form-control-label">Contact Number</label></div>
                  <div class="col-12 col-md-8"><input type="text" id="contact" name="contact" placeholder="Contact Number" class="form-control" required></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="email" class=" form-control-label">Email Address</label></div>
                  <div class="col-12 col-md-8"><input type="email" id="email" name="email" placeholder="Email Address" class="form-control" required></div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-4"><label for="hf-classification" class=" form-control-label">Classification</label></div>
                  <div class="col-12 col-md-8">
                    <select class="form-control" name="classification" required>
                      <option value="">Select Account Type</option>
                      <option value="Residential">Residential</option>
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
<script type="text/javascript" src="assets/js/print.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#modal1').click(function(){
      $('#submit').click();
    });
    $( ".datepicker" ).datepicker({
      maxDate: 0,
      dateFormat: 'yy-mm-dd'
    });
    $("#printqr").find('button').on('click', function() {
      $(".qrcode").print();
    });
  })
</script>
