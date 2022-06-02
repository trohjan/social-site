<!doctype html>
<html lang="en">
  <head>
  	<title>TJ net</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">

	</head>
	<body style="background-image: url(images/backg.jpg);">
	<section class="ftco-section">
		<div class="container">
			
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap py-5">
                    <div class="img d-flex align-items-center justify-content-center" style="background-image: url(images/bg.png);"></div>
                    <h3 class="text-center mb-0">Enter the Reset code you've received</h3>
                    
                            
                    <form action="confirmReset.php" class="login-form">
                        <br/>
                        <div class="form-group">
                            
                            <input type="text" class="form-control" placeholder="TJ-" name="resetcode" required>
                            
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-center" >
								
					        <a href="#" style="color:green" >Try resend code</a>
								
	                    </div>
                        <div class="form-group d-flex align-items-center justify-content-center" >
								
					        <a href="resetCode.php" style="color:green" >Change the resend method</a>
								
	                    </div>


                    
                        <div class="form-group">
                            <button type="submit" style="background-color:green" class="btn form-control  rounded submit px-3">Reset</button>
                        </div>
                        <a href="login.php" style="text-decoration: none;">CANCEL</a>

                    </form>
                
                   
                </div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>