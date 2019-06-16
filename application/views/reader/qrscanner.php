<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('layout/header'); ?>
<body>

    <?php $this->load->view('layout/reader-qrscanner'); ?>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <?php $this->load->view('layout/user'); ?>
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Read Meter</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                          <li><a href="administrator/">Dashboard</a></li>
                          <li><a href="reader/viewconsumers">View Consumers</a></li>
                          <li class="active">Read Meter</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
          <video id="preview" autoplay="autoplay" class="active" style="transform: scaleX(-1);"></video>
          <script type="text/javascript">
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            scanner.addListener('scan', function (content) {
              window.open(content, "_self");
            });
            Instascan.Camera.getCameras().then(function (cameras) {
              if (cameras.length > 0) {
                scanner.start(cameras[0]);
              } else {
                console.error('No cameras found.');
              }
            }).catch(function (e) {
              console.error(e);
            });
          </script>
        </div>

      </div> <!-- .content -->
    </div><!-- /#right-panel -->
    <?php $this->load->view('layout/footer'); ?>
