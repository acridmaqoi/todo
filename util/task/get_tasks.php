<?php

require_once "../../config/db.php";

$ok = true;
$messages = array();

// check data was submitted
if (!isset($_POST['id'])) {
    die('Error');
}

$id = $_POST['id'];

$data = mysqli_query($con, "SELECT * FROM tasks");

?>

<?php
if (mysqli_num_rows($data) > 0) {
    while ($row = mysqli_fetch_assoc($data)) {
?>

<li>
    <i id="id" data-id="<?php echo $row['id']; ?>"></i>
    <i class="text"><?php echo $row['title']; ?></i>
    <i id="remove-btn">x</i>
    <i id="complete-btn">complete task</i>
</li>
 
<?php }
} ?>

