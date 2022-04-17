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
                        <div class="box-header">
                            <h3>Your file was successfully uploaded!</h3>
                        </div>

                        <ul>
                            <?php foreach ($upload_data as $item => $value) : ?>
                                <li><?php echo $item; ?>: <?php echo $value; ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $conn = new mysqli($servername, $username, $password, "stock");
                        ?>

                        </br>
                        <table id="data">
                            <thead>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Status</th>
                            </thead>
                            <tbody> <?php

                                    $handle = fopen("./uploads/data.txt", "r");

                                    while ($userinfo = fscanf($handle, "%s\t%s\t%s\n")) {
                                        echo "<tr>";
                                        list($id, $parent_id, $name) = $userinfo;
                                        $sql = "INSERT INTO customers (id, parent_id, name) VALUES ('" . $userinfo[0] . "', " . $userinfo[2] . ", '" . $userinfo[1] . "')";
                                        if ($conn->query($sql) === True) {
                                            echo "<td>" . $userinfo[0] . "</td> <td>" . $userinfo[1] . "<td> SUCCESS </td>";
                                        } else {
                                            echo "<td>" . $userinfo[0] . "</td> <td>" . $userinfo[1] . "<td>" . $conn->error . "</td>";
                                        }
                                    }

                                    fclose($handle);
                                    unlink("./uploads/data.txt");
                                    ?> </tbody>
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
<script>
    $(document).ready(function() {
        $('#data').DataTable();
    });
</script>