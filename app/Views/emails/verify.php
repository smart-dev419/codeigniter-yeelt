Welcome, <?= $email ?>!

Now you can verify your email, just press the button:<br>
<a class="btn btn-primary text-white" href="<?= base_url('login/emailverified/'.$email.'/'.$token); ?>">Click Me</a><br>
After you press the button you will be redirected to the login page, and since then you will be able to log in.