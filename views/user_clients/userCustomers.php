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
            Kliente
            <small>Perdoruesi</small>
        </h1>
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


                <?php if ($user_customerdata) : ?>
                    <?php foreach ($user_customerdata as $k => $v) : ?>

                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"><?php echo $v['firstname'] . " " . $v['lastname']; ?></h3>
                                <a href="/userclients/addcustomer/<?php echo $v['id'];
                                                                    break;
                                                                endforeach;  ?>" class="btn btn-primary">Shto Klient</a>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="groupTable" class="table table-bordered table-striped">
                                    <thead>
                                        <th>Klienti</th>
                                        <th>Data e shtimit</th>
                                        <th>Veprime</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($user_customerdata as $k => $v) : ?>
                                            <tr>
                                                <td> <?php echo $v['name']; ?> </td>
                                                <td> <?php echo $v['date_added']; ?> </td>
                                                <td> <a href="/userclients/remove/<?php echo $v['c_id'] ?>/<?php echo $v['id'] ?>" class="btn btn-primary"> Fshi </a></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif; ?>
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
        $('#groupTable').DataTable();
    });
</script>