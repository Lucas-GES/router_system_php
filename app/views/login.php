<?php 

$this->layout('master', ['title' => $title]);
if($not_found){
    echo '<div class="alert alert-danger" role="alert">
        User Not Founded!
      </div>';
}
if($logged){
    echo '<div class="alert alert-success" role="alert">
        Logged Successfully!
      </div>
      ';
}

?>
<h1 class="text-center">Login to our website</h1>
<div class="container mt-5">
    <form action="/login" method="post">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Name</label>
          <input type="email" class="form-control" placeholder="Enter your username" name="username">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" placeholder="Enter your password" name="password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
      <div class="text-center mt-2">
        <a href="/sign">New User ? SignUp</a>
      </div>
</div>