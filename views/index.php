<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th,
  td {
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even) {
    background-color: #f2f2f2
  }

  th {
    background-color: #04AA6D;
    color: white;
  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Raporte
      <small> Hedhje </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Faqa kryesore</a></li>
      <li class="active">Raporte</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

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

        <div class="box">
          <div class="box-body">

            <table id="users" class="table table-bordered table-striped">
              <thead>
                <th>Perdoruesi</th>
                <th>Veprime</th>
              </thead>
              <tbody>
                <?php foreach ($users as $k => $v) : ?>
                  <tr>
                    <td> <?php echo $v['firstname'] . " " . $v['lastname'] ?> </td>
                    <td> <a href="<?php echo "/reports/userreports/" . $v['id'] ?>" onclick="window.open('/raporte/Viti_Raport_<?php echo $v['id'] ?>.xlsx');" class="btn btn-primary"> Gjenero Raport </a> </td>
                  <tr>
                  <?php endforeach; ?>
              </tbody>
            </table>

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

<script type="text/javascript">
  $(document).ready(function() {
    $('#users').DataTable();
  });
</script>