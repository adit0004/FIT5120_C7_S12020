<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/css/bootstrap.css'>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: -webkit-box;
            display: flex;
            -ms-flex-align: center;
            -ms-flex-pack: center;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 500px;
            padding: 15px;
            margin: 0 auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="password"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
    </style>
    <title>Login</title>

</head>

<body class="text-center">
    <?php echo form_open('general/checkPassword', 'class=form-signin');?>
    <!-- <form class="form-signin"> -->
      <img class="mb-4" src="<?php echo base_url();?>assets/img/logo.png" alt="" width="200" height="200">
      <h3 class="mb-3 font-weight-normal">Password?</h3>
      <div class="row">
          <?php if($error == 1)
          { 
            echo "<p class='text-danger w-100 text-center'>That doesn't seem correct.</p>";
          }
          ?>
          <div class="col-8 pr-1">
              <input type="password" id="password" name='password' class="form-control" placeholder="(Tip: It's not 'password'!)" required>
          </div>
          <div class="col-4 pl-1">
              <button class="btn btn-outline-primary btn-lg btn-block" style='padding-top:6px; padding-bottom:6px;' type="submit">Enter &rarr;</button>
          </div>
      </div>
    <?php echo form_close();?>
    <!-- </form> -->
  </body>

</html>