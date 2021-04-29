<?php

require __DIR__ . "../../../autoloader.php";
require __DIR__ . "../../../util/db.php";

$ok = true;
$messages = array();

// check data was submitted
if (!isset($_POST['id'])) {
    die('Error');
}

$id = $_POST['id'];

if ($stmt = $con->prepare('SELECT id, title, completed FROM tasks WHERE user_id = (?)')) {
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->bind_result($id, $title, $completed);
    $stmt->execute();
    $stmt->store_result();
} else {
    $ok = false;
    $messages[] = 'An unexpected error occoured please try again later';
}

if ($stmt->num_rows() > 0) {
    while ($row = $stmt->fetch()) {
?>

<li>
    <i id="id" data-id="<?php echo $id; ?>"></i>

    <input id="complete-btn" type="checkbox" <?php if ($completed) {echo 'checked';} ?>>
    <i class="text"><?php echo $title; ?></i>
    <i id="remove-btn">x</i>
</li>
 
<?php }
} else { echo 'no tasks to show'; } ?>
