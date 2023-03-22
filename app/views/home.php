<?php $this->layout('master', ['title' => $title]);
if(!isset($username)){
    header('location:/');
}
?>

<h1 class="text-center">Welcome to Web Test</h1>
<div class="container">
    <h2 class="text-center">Welcome <?php echo $username; ?></h2>
    <a href="/logout" class="btn btn-primary mt-5">Logout</a>
</div>