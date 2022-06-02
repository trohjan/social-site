<?php 

require_once "userConfig.php";



function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
  }
 


$firstName = $lastName = $username = $password = $confirmPassword = $email = $phone = $county = $town = $gender = "" ;
$firstNameErr =  $lastNameErr = $usernameErr = $passwordErr = $confirmPasswordErr = $emailErr = $phoneErr = $countyErr = $townErr = $genderErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	//firstname
	if (empty($_POST["firstName"])) {
	  $firstNameErr = "First name is required";
	} else {
	  $firstName = test_input($_POST["firstName"]);
	  if (!preg_match("/^[a-zA-Z-' ]*$/",$firstName)) {
		$firstNameErr = "Only letters and white space allowed";
	  }
	}

	//lastname
	if (empty($_POST["lastName"])) {
		$lastNameErr = "Last name is required";
	} else {
		$lastName = test_input($_POST["lastName"]);
		if (!preg_match("/^[a-zA-Z-' ]*$/",$lastName)) {
		  $lastNameErr = "Only letters and white space allowed";
		}
	}

	// Validate username
    if(empty(trim($_POST["username"]))){
        $usernameErr = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $usernameErr = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT member_id FROM members WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $username);
            
            // Set parameters
            $username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $usernameErr = "This username is already taken.";
					
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

	// Validate password
    if(empty(trim($_POST["password"]))){
        $passwordErr = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $passwordErr = "Password must have atleast 6 characters.";
    } else{
        $password = test_input($_POST["password"]);
    }
	
	// Validate confirm password
    if(empty(trim($_POST["confirmPassword"]))){
        $confirmPasswordErr = "Please confirm password.";     
    } else{
        $confirmPassword = trim($_POST["confirmPassword"]);
        if(empty($passwordErr) && ($password != $confirmPassword)){
            $confirmPasswordErr = "Password did not match.";
        }
    }
    
    
    
    // Close connection
    $mysqli->close();

	//email
	if (empty($_POST["email"])) {
		$emailErr = "Email is required";
	} else {
		$email = test_input($_POST["email"]);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $emailErr = "Invalid email format";
		}
	}

	//phone
	if (empty($_POST["phone"])) {
		$phoneErr = "Phone is required";
	} else {
		$phone = test_input($_POST["phone"]);
		if (!preg_match('/^[0-9]*$/',$phone)) {
		  $phoneErr = "Invalid phone";
		}
	}

	//county
	if (empty($_POST["county"])) {
		$countyErr = "County is required";
	} else {
		$county = test_input($_POST["county"]);
		if (!preg_match("/^[a-zA-Z-' ]*$/",$county)) {
		  $countyErr = "Only letters and white space allowed";
		}
	}

	//town
	if (empty($_POST["town"])) {
		$townErr = "Town name is required";
	} else {
		$town = test_input($_POST["town"]);
		if (!preg_match("/^[a-zA-Z-' ]*$/",$town)) {
		  $townErr = "Only letters and white space allowed";
		}
	}

	//gender
	if (empty($_POST["gender"])) {
		$genderErr = "Gender is required";
	} else {
		$gender = test_input($_POST["gender"]);
	}

	// Check input errors before inserting in database
    if(empty($firstNameErr) && empty($lastNameErr) && empty($emailErr) && empty($phoneErr) 
	&& empty($usernameErr) && empty($passwordErr) && empty($confirmPasswordErr) && empty($countyErr)
	&& empty($townErr)&& empty($genderErr)){
		$host = "localhost";
        $dbname = "socialsite";
        $username = "tj47";
        $password = "VLCNm1jUJ/lVmAmd";

		$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

        $conn = new mysqli($host, $username, $password, $dbname);
        if ($conn->connect_error){
            die("Connection error : " .$conn->connect_error);
        }else{
            $stmt = $conn->prepare("insert into members(username, password,firstName, lastName, phone, email,  
			gender, county, town)
                values(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $username,  $password,$firstName , $lastName,$phone,$email,$gender, 
			 $county, $town);
            $stmt->execute();
            $last_id = $stmt->insert_id;
            
            $stmt->close();
            $conn->close();
			header("Location: login.php");
        };

    }

	




	
  }





?>

<!doctype html>
<html lang="en">
  <head>
  	<title>TJ net</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/styles2.css">

	</head>
	<body style="background-image: url(images/backg.jpg); background-repeat: no-repeat; background-attachment: fixed;" >
	<section class="ftco-section" >
		<div class="container" >
			
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-8">
				<div class="login-wrap py-5">
					<div class="img d-flex align-items-center justify-content-center" style="background-image: url(images/bg.png);"></div>
					<h3 class="text-center mb-0">Welcome</h3>
					<p class="text-center">Sign in by entering your credentials below</p>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="login-form">
						<div class="form_wrap">
							<div class="input_grp">

							<!-- Frist name input Place -->
							<div class="input_wrap " >
								<label for="firstName">First Name</label>
								<input type="text" class="form-control" name="firstName" id="firstName" style="width: 330px;" value="<?php echo $firstName;?>">
								<span class="error">* <?php echo $firstNameErr;?></span>
							</div>

							<!-- Last Name input place -->
							<div class="input_wrap" >
								<label for="lastName">Last Name</label>
								<input type="text" class="form-control" name="lastName" id="lastName"style="width: 330px;" value="<?php echo $lastName;?>">
								<span class="error">* <?php echo $lastNameErr;?></span>
							</div>
						</div>

						<!-- username Id input Place -->
						<div class="input_wrap">
							<label for="username">Username</label>
							<input type="text" class="form-control" name="username" id="username" value="<?php echo $username;?>">
							<span class="error">* <?php echo $usernameErr;?></span>
						</div>
  						
						<!-- password Id input Place -->
						<div class="input_wrap">
							<label for="password">password</label>
							<input type="password" class="form-control" name="password" id="password" value="<?php echo $password;?>">
							<span class="error">* <?php echo $passwordErr;?></span>
						</div>

						<div class="input_wrap">
							<label for="confirmPassword">Confirm Password</label>
							<input type="password" class="form-control" name="confirmPassword" id="confirmPassword" value="<?php echo $confirmPassword;?>">
							<span class="error">* <?php echo $confirmPasswordErr;?></span>
						</div>

						<!-- Email Id input Place -->
						<div class="input_wrap">
							<label for="email">Email Address</label>
							<input type="text" class="form-control" name="email" id="email" value="<?php echo $email;?>">
							<span class="error">* <?php echo $emailErr;?></span>
						</div>

						<div class="input_wrap">
							<label for="phone">Phone Number</label>
							<input type="number" class="form-control" name="phone" id="phone" value="<?php echo $phone;?>">
							<span class="error">* <?php echo $phoneErr;?></span>
						</div>

						<!-- City Name input place -->
						<div class="input_wrap">
							<label for="county">County</label>
							<input type="text" class="form-control" name="county" id="county" value="<?php echo $county;?>">
							<span class="error">* <?php echo $countyErr;?></span>
						</div>

						<!-- Country Name input place -->
						<div class="input_wrap">
							<label for="town">Town</label>
							<input type="text" class="form-control" name="town" id="town" value="<?php echo $town;?>">
							<span class="error">* <?php echo $townErr;?></span>
						</div>

						<!-- Gender Select box -->
						<div class="input_wrap ">
							<label>Gender</label>
							<ul>
								<li>
									<label class="radio_wrap">
									<input type="radio" name="gender"  
									<?php if (isset($gender) && $gender=="male") echo "checked";?>
									value="male" class="input_radio" checked>
									<span>Male</span>
									</label>
								</li>

								<li>
									<label class="radio_wrap">
									<input type="radio" name="gender" 
									<?php if (isset($gender) && $gender=="female") echo "checked";?>
									value="female" class="input_radio">
									<span>Female</span>
								</label>
								</li>

							</ul>
							<span class="error">* <?php echo $genderErr;?></span>
						</div>

						

						
					</form>
					<div class="w-100 text-center mt-4 text">
						<p class="mb-0">By clicking Sign UP , you agree to the <a href="terms.html" style="color:green" >Terms and conditions</a>, You will receive a message from us</p>
						<div class="form-group">
							<button type="submit" style="background-color:green" class="btn form-control  rounded submit px-3">REGISTER</button>
						</div>
						
					<a href="login.php" style="text-decoration: none;">CANCEL</a>
						
					</div>
	        	
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