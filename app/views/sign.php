<?php $this->layout('master', ['title' => $title])?>
<?php 
if($user){
    echo '<div class="alert alert-danger" role="alert">
        User Already Exist!
      </div>';
}
if($new_user){
    echo '<div class="alert alert-success" role="alert">
        User Created Successfully!
      </div>
      ';
}
?>
<h1 class="text-center">Sign Up page</h1>
<div class="container mt-5">
    <form action="/sign" method="post">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Name</label>
          <input type="email" class="form-control" placeholder="Enter your username" name="username">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" placeholder="Enter your password" name="password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Sign Up</button>
      </form>
</div>