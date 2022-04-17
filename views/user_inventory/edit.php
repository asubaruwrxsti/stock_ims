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
            Gjendje
            <small>Magazine</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Faqa kryesore</a></li>
            <li class="active">Hyrje Magazine</li>
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

                <?php if ($update_data) : ?>
                    <?php foreach ($update_data as $k => $v) : ?>
                        <a href="<?php echo base_url('userinventory/insert_index/'.$v['id']) ?>" class="btn btn-primary"> Edito </a>
                        <br /> <br />
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"><?php echo $v['firstname'] . " " . $v['lastname'];
                                                        break;
                                                    endforeach; ?></h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <table id="data">
                                    <thead>
                                        <th> Produkti </th>
                                        <th> Sasia </th>
                                        <th> Data e hyrjes </th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($update_data as $k => $v) : ?>
                                            <tr>
                                                <td> <?php echo $v['name'] ?> </td>
                                                <td> <?php echo $v['product_qty'] ?> </td>
                                                <td> <?php echo $v['entry_date'] ?> </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>

                            </div>
                        <?php endif; ?>
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
        $('#data').DataTable();
    });
</script>