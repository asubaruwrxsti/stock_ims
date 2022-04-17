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

                <?php foreach ($user_data as $k => $v) : ?>

                    <div class="box">
                        <div class="box-body">
                            <form method="POST" action="/userinventory/insert/<?php echo $v['id'] ?>">

                                <table id="data">
                                    <thead>
                                        <th>No.</th>
                                        <th>Produkti</th>
                                        <th>Sasia</th>
                                        <th>Distributori</th>
                                        <th>Veprime</th>
                                    </thead>
                                    <tbody id="tbody">
                                        <td>1</td>
                                        <td><input type='text' name='product_id[]'></td>
                                        <td><input type='text' name='product_qty[]'></td>
                                        <td><?php echo $v['username']; ?></td>
                                    </tbody>
                                </table>

                                <button type="button" onclick="addItem();" class="btn btn-primary">Shto</button>
                                <button type="submit" class="btn btn-primary">Ruaj</button>
                            </form>
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
    var items = 1;
    var username = "<?php echo $v['username'];
                    break;
                endforeach; ?>";

    function addItem() {
        items++;

        var html = "<tr>";
        html += "<td>" + items + "</td>";
        html += "<td><input type='text' name='product_id[]'></td>";
        html += "<td><input type='text' name='product_qty[]'></td>";
        html += "<td><p>" + username + "</p></td>";
        html += "<td><button type='button' onclick='deleteRow(this);' class='btn btn-primary'>Delete</button></td>";
        html += "</tr>";

        var row = document.getElementById("tbody").insertRow();
        row.innerHTML = html;
    }

    function deleteRow(button) {
        button.parentElement.parentElement.remove();
        // first parentElement will be td and second will be tr.
    }
</script>