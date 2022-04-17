<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Faqa Kryesore</a></li>
      <li class="active">Raporte</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if ($this->session->flashdata('success')) : ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif ($this->session->flashdata('error')) : ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        </br>

        <div class="box">
          <div class="box-body">

            <div class="box-header">
              <h3 class="box-title">Raporte</h3>
            </div>

            <div style="float:left;">
              Minimum: <input type="date" id="txtMin" />
              Maximum: <input type="date" id="txtMax" />
              <button id="table1_draw" type="button" class="btn">Go</button>
            </div> </br> </br>

            <table id="Table" class="table table-bordered table-striped">
              <thead></thead>
              <tbody></tbody>
            </table>

            <div class="box-header">
              <h3 class="box-title">Raporte2</h3>
            </div>

            <table id="Table2" class="table table-bordered table-striped">
              <thead></thead>
              <tbody></tbody>
            </table>

            <div class="box-header">
              <h3 class="box-title">Raporte3</h3>
            </div>
            <table id="Table3" class="table table-bordered table-striped">
              <thead></thead>
              <tbody></tbody>
            </table>
          </div>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- col-md-12 -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap3-typeahead.js"></script>
<script type="text/javascript">
  var manageTable;
  var manageTable2;
  var manageTable3;
  var dataSrc = [];
  var dataSrc2 = [];
  var dataSrc3 = [];

  var base_url = "<?php echo base_url(); ?>";
  var parent_id = "<?php echo $this->session->userdata('id'); ?>";


  $(document).ready(function() {

    $("#table1_draw").click(function() {
      $('#Table').DataTable().draw();
    });

    $("#table2_draw").click(function() {
      $('#Table2').DataTable().draw();
    });

  });

  $.fn.DataTable.ext.search.push(
    function(settings, data, dataIndex) {


      var valid = true;
      var min = moment($("#txtMin").val());
      if (!min.isValid()) {
        min = null;
      }

      var max = moment($("#txtMax").val());
      if (!max.isValid()) {
        max = null;
      }

      if (min === null && max === null) {
        // no filter applied or no date columns
        valid = true;
      } else {

        $.each(settings.aoColumns, function(i, col) {

          if (col.type == "date") {
            var cDate = moment(data[i]);

            if (cDate.isValid()) {
              if (max !== null && max.isBefore(cDate)) {
                valid = false;
              }
              if (min !== null && cDate.isBefore(min)) {
                valid = false;
              }
            } else {
              valid = false;
            }
          }
        });
      }
      return valid;
    });

  // initialize the datatable 
  manageTable = $('#Table').DataTable({
    'ajax': base_url + 'attributes/fetchAttributeData',
    columns: [{
        title: "Klienti"
      },
      {
        title: "Distributori"
      },
      {
        title: "Produkti"
      },
      {
        title: "Sasia"
      },
      {
        title: "Data",
        type: "date"
      }
    ],
    "order": [
      [1, "desc"]
    ],
    'initComplete': function() {
      var api = this.api();
      api.cells('tr', [0, 1, 2]).every(function() {
        var data = $('<div>').html(this.data()).text();
        if (dataSrc.indexOf(data) === -1) {
          dataSrc.push(data);
        }
      });
      dataSrc.sort();
      $('.dataTables_filter input[type="search"]', api.table().container())
        .typeahead({
          source: dataSrc,
          afterSelect: function(value) {
            api.search(value).draw();
          }
        });
    }
  });

  manageTable2 = $('#Table2').DataTable({
    'ajax': base_url + 'attributes/fetchAttributeData2',
    columns: [{
        title: "Klienti"
      },
      {
        title: "Produkti"
      },
      {
        title: "Sasia"
      },
    ],
    "order": [
      [1, "desc"]
    ],
    'initComplete': function() {
      var api = this.api();
      api.cells('tr', [0, 1, 2]).every(function() {
        var data = $('<div>').html(this.data()).text();
        if (dataSrc2.indexOf(data) === -1) {
          dataSrc2.push(data);
        }
      });
      dataSrc2.sort();
      $('.dataTables_filter input[type="search"]', api.table().container())
        .typeahead({
          source: dataSrc2,
          afterSelect: function(value) {
            api.search(value).draw();
          }
        });
    }
  });

  manageTable3 = $('#Table3').DataTable({
    'ajax': base_url + 'attributes/getQtyData',
    columns: [{
        title: "Produkti"
      },
      {
        title: "Sasia"
      }
    ],
    "order": [
      [1, "desc"]
    ],
    'initComplete': function() {
      var api = this.api();
      api.cells('tr', [0]).every(function() {
        var data = $('<div>').html(this.data()).text();
        if (dataSrc3.indexOf(data) === -1) {
          dataSrc3.push(data);
        }
      });
      dataSrc3.sort();
      $('.dataTables_filter input[type="search"]', api.table().container())
        .typeahead({
          source: dataSrc3,
          afterSelect: function(value) {
            api.search(value).draw();
          }
        });
    }
  });
</script>