<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<form action="">
    <input type="text" name="user" id="user" placeholder="Emri i distributorit"></input>
    <button name="edit" type="submit">Shfaq klientet</button>
</form>

<?php
    
    $conn = new mysqli("localhost","root","","stock");  

    echo "<style> th {
        background-color: #04AA6D;
        color: white;
      } tr:nth-child(even) {background-color: #f2f2f2;}
    tr:hover {background-color: yellow;}
    th, td {
        border-bottom: 1px solid #ddd;
      } </style>";
    
    echo '<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>';

    echo '<table id="example" class="display" style="width:100%">';
    echo "<th>ID</th><th>Name</th> <th>Action</th>";

    $user = $_GET["user"];

    $sql = "SELECT id from users where users.username = '".$user."' limit 1";
    $user_id = $conn -> query($sql)->fetch_object()->id;

    $sql = "SELECT customers.id, customers.name from customers where customers.parent_id = '".$user_id."'";
    $result = $conn -> query($sql);

    while($a = $result->fetch_array(MYSQLI_ASSOC)){
            echo '<tr> <td>'.$a["id"].'</td> <td class="name"><span>'.$a["name"].'</span></td> <td><button class="delete"> Delete </button></td> </tr>';
    }
    echo "</table>";

    echo '<script type="text/javascript">

    $(".delete").click(function() {
      var $item = $(this).closest("tr").find(".name").text();
      console.log($item);
      var $r = confirm("Delete ?");
      if ($r==true){
        $.ajax({
          type: "POST",
          url: "delete.php",
          data: {name : $item},
          success : function(result) {
            location.reload(true);
          }
        });
      }
    });

      function alterRow(button) {
        alert("ALTER EVENT!");
      }
      
      </script>';

?>
