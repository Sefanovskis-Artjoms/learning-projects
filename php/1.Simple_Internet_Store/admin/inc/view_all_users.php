<div class="wrapper">
  <div class="page-header-box">
    <div>
      <h2 class="page-heading">View Users</h2>
      <span class="page-heading-line"></span>
    </div>
    <a href="admin-users.php?source=add_user" class="btn--cta">
      <i class="fas fa-plus"></i>
      <span>Create User</span>
    </a>
  </div>

<?php
$query = "select*from users ";
$query.= "order by user_id desc";
$select_users = mysqli_query($conn,$query);

if(mysqli_num_rows($select_users) == 0){
  echo "<div class='empty-msg'>Looks like it is empty here...</div>";
}
else{
?>

  <table class="hor-table view-all-users-table"> 
    <thead class="hor-table-head" >
      <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Role</th>
        <th>Options</th>
        <th></th>
        <th></th> 
        <th></th>
      </tr>
    </thead>
    <tbody class="hor-table-body">
      
      <?php  
      while ($row = mysqli_fetch_assoc($select_users)) {
        
        $user_id = $row['user_id'];
        $user_first = $row['user_first'];
        $user_last = $row['user_last'];
        $user_email = $row['user_email'];
        $user_phone = $row['user_phone'];
        $user_phone_code = $row['user_phone_code'];
        $user_role = $row['user_role'];
        
        echo "<tr>";
        echo "<td>{$user_id}</td>";
        echo "<td>{$user_first}</td>";
        echo "<td>{$user_last}</td>";
        echo "<td>{$user_email}</td>";
        echo "<td>+{$user_phone_code} {$user_phone}</td>";
        echo "<td>{$user_role}</td>";
        echo "<td><a href='admin-users.php?change_to_user=$user_id'>Change to User</a></td>";
        echo "<td><a href='admin-users.php?change_to_admin=$user_id'>Change to Admin</a></td>";
        echo "<td><a href='admin-users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";
        echo "<td><a href='admin-users.php?delete=$user_id'>Delete</a></td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>
<?php } ?>


<?php 
  if (isset($_GET['delete'])) {
    $the_user_id = $_GET['delete'];
  
    global $conn;
    $query = "delete from users where user_id = $the_user_id";
    $delete_query = mysqli_query($conn,$query);
    header("Location: admin-users.php");
  }

  if (isset($_GET['change_to_admin'])) {
    $the_user_id = $_GET['change_to_admin'];

    global $conn;
    $query = "update users set user_role = 'admin' ";
    $query.= "where user_id = $the_user_id";
    $change_to_admin_query = mysqli_query($conn,$query);
    header("Location: admin-users.php");
  }
  if (isset($_GET['change_to_user'])) {
    $the_user_id = $_GET['change_to_user'];

    global $conn;
    $query = "update users set user_role = 'user' ";
    $query.= "where user_id = $the_user_id";
    $change_to_user_query = mysqli_query($conn,$query);
    header("Location: admin-users.php");
  }
  
?>