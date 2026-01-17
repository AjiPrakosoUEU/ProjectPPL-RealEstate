<?php 
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");

// Get property and agent IDs from URL
$pid = isset($_GET['pid']) ? $_GET['pid'] : '';
$aid = isset($_GET['aid']) ? $_GET['aid'] : '';

$msg = "";
$error = "";

// Handle form submission
if(isset($_POST['schedule'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $message = $_POST['message'];
    $user_id = isset($_SESSION['uid']) ? $_SESSION['uid'] : NULL;
    
    if(!empty($name) && !empty($email) && !empty($phone) && !empty($appointment_date) && !empty($appointment_time)){
        
        // Get property and agent details for WhatsApp message
        $property_query_temp = mysqli_query($con, "SELECT property.*, user.* FROM `property`, `user` WHERE property.uid=user.uid AND pid='$pid'");
        $property_detail = mysqli_fetch_array($property_query_temp);
        
        if($property_detail){
            $property_title = $property_detail['1'];
            $property_location = $property_detail['14'];
            $agent_name = $property_detail['uname'];
            $agent_phone = $property_detail['uphone'];
            
            // Format date
            $formatted_date = date('d F Y', strtotime($appointment_date));
            $formatted_time = date('H:i', strtotime($appointment_time));
            
            // Message to user
            $user_message = "*Appointment Confirmation*\n\n";
            $user_message .= "Hello *$name*,\n\n";
            $user_message .= "Thank you for scheduling an appointment for the property:\n";
            $user_message .= "📍 *$property_title*\n";
            $user_message .= "📌 Location: $property_location\n\n";
            $user_message .= "📅 Date: *$formatted_date*\n";
            $user_message .= "⏰ Time: *$formatted_time*\n\n";
            $user_message .= "Our agent (*$agent_name*) will contact you via WhatsApp soon for further confirmation.\n\n";
            $user_message .= "Thank you! 🏠";
            
            // Message to agent
            $agent_message = "*New Appointment!*\n\n";
            $agent_message .= "Hello *$agent_name*,\n\n";
            $agent_message .= "There is a new appointment for your property:\n";
            $agent_message .= "📍 *$property_title*\n\n";
            $agent_message .= "👤 Name: *$name*\n";
            $agent_message .= "📧 Email: $email\n";
            $agent_message .= "📱 Phone: $phone\n\n";
            $agent_message .= "📅 Date: *$formatted_date*\n";
            $agent_message .= "⏰ Time: *$formatted_time*\n\n";
            if(!empty($message)){
                $agent_message .= "💬 Message: $message\n\n";
            }
            $agent_message .= "Please contact the customer for confirmation. 📞";
            
            // Send WhatsApp to user
            $urlApi = 'https://juraganbeku.tokopandai.id/api/wa/remote/logger/send/msg';
            $user_payload = array(
                'text' => $user_message,
                'targetNumber' => $phone
            );
            
            $ch = curl_init($urlApi);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($user_payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $user_response = curl_exec($ch);
            curl_close($ch);
            
            // Send WhatsApp to agent
            $agent_payload = array(
                'text' => $agent_message,
                'targetNumber' => $agent_phone
            );
            
            $ch = curl_init($urlApi);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($agent_payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $agent_response = curl_exec($ch);
            curl_close($ch);
            
            $msg = "<p class='alert alert-success' style='margin-left: 1rem; width: 97.5%'><i class='fab fa-whatsapp'></i> Appointment scheduled successfully! Confirmation has been sent to your WhatsApp and the agent will contact you soon.</p>";
        } else {
            $error = "<p class='alert alert-danger'>Property not found.</p>";
        }
    } else {
        $error = "<p class='alert alert-warning'>Please fill all required fields!</p>";
    }
}

// Get property details
$property_query = mysqli_query($con, "SELECT property.*, user.* FROM `property`, `user` WHERE property.uid=user.uid AND pid='$pid'");
$property = mysqli_fetch_array($property_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Meta Tags -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Real Estate PHP">
<meta name="keywords" content="">
<meta name="author" content="Unicoder">
<link rel="shortcut icon" href="images/favicon.ico">

<!--	Fonts
	========================================================-->
<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

<!--	Css Link
	========================================================-->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/layerslider.css">
<link rel="stylesheet" type="text/css" href="css/color.css" id="color-change">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
<link rel="stylesheet" type="text/css" href="css/style.css">

<!--	Title
	=========================================================-->
<title>Schedule Appointment - Real Estate PHP</title>
</head>
<body>

<div id="page-wrapper">
    <div class="row"> 
        <!--	Header start  -->
		<?php include("include/header.php");?>
        <!--	Header end  -->
        
        <!--	Banner   --->
        <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Schedule Appointment</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item text-white"><a href="propertydetail.php?pid=<?php echo $pid;?>">Property Detail</a></li>
                                <li class="breadcrumb-item active">Schedule Appointment</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
         <!--	Banner   --->

        <div class="full-row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <?php echo $msg; ?><?php echo $error; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Property Info -->
                    <div class="col-lg-5">
                        <div class="property-details bg-light p-4 rounded mb-4">
                            <h4 class="text-secondary mb-4">Property Information</h4>
                            <?php if($property){ ?>
                            <div class="property-image mb-3">
                                <img src="admin/property/<?php echo $property['18'];?>" alt="Property" class="img-fluid rounded">
                            </div>
                            <h5 class="text-capitalize"><?php echo $property['1'];?></h5>
                            <p class="mb-2"><i class="fas fa-map-marker-alt text-success"></i> <?php echo $property['14'];?></p>
                            <h6 class="text-success">$<?php echo $property['13'];?></h6>
                            <div class="mt-3">
                                <span class="badge badge-success"><?php echo $property['5'];?></span>
                                <span class="badge badge-info"><?php echo $property['3'];?></span>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- Agent Info -->
                        <div class="agent-details bg-light p-4 rounded">
                            <h4 class="text-secondary mb-4">Agent Information</h4>
                            <?php if($property){ ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="admin/user/<?php echo $property['uimage'];?>" alt="Agent" class="img-fluid rounded mb-3">
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-success text-capitalize"><?php echo $property['uname'];?></h6>
                                    <p class="mb-1"><i class="fas fa-phone text-success"></i> <?php echo $property['uphone'];?></p>
                                    <p class="mb-1"><i class="fas fa-envelope text-success"></i> <?php echo $property['uemail'];?></p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Appointment Form -->
                    <div class="col-lg-7">
                        <div class="appointment-form bg-white p-4 rounded shadow-sm">
                            <h4 class="text-secondary mb-4">Schedule Your Appointment</h4>
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required 
                                                value="<?php echo isset($_SESSION['uname']) ? $_SESSION['uname'] : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required
                                                value="<?php echo isset($_SESSION['uemail']) ? $_SESSION['uemail'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required
                                                value="<?php echo isset($_SESSION['uphone']) ? $_SESSION['uphone'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="appointment_date">Preferred Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="appointment_date" name="appointment_date" required min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="appointment_time">Preferred Time <span class="text-danger">*</span></label>
                                            <input type="time" class="form-control" id="appointment_time" name="appointment_time" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message">Additional Message (Optional)</label>
                                            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Any specific requirements or questions?"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" name="schedule" class="btn btn-success btn-lg btn-block">
                                            <i class="fas fa-calendar-check"></i> Schedule Appointment
                                        </button>
                                        <a href="propertydetail.php?pid=<?php echo $pid;?>" class="btn btn-secondary btn-lg btn-block mt-2">
                                            <i class="fas fa-arrow-left"></i> Back to Property
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="text-secondary"><i class="fas fa-info-circle"></i> What happens next?</h6>
                            <ul class="mb-0">
                                <li><i class="fab fa-whatsapp text-success"></i> The agent will review your appointment request</li>
                                <li><i class="fab fa-whatsapp text-success"></i> You will receive a confirmation via <strong>WhatsApp</strong></li>
                                <li><i class="fab fa-whatsapp text-success"></i> The agent may suggest an alternative time if your preferred slot is unavailable</li>
                                <li><i class="fas fa-clock text-success"></i> Please arrive 5 minutes before your scheduled time</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!--	Footer   start-->
		<?php include("include/footer.php");?>
		<!--	Footer   start-->
        
        <!-- Scroll to top --> 
        <a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a> 
        <!-- End Scroll To top --> 
    </div>
</div>
<!-- Wrapper End --> 

<!--	Js Link
============================================================--> 
<script src="js/jquery.min.js"></script> 
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/owl.carousel.min.js"></script> 
<script src="js/wow.js"></script> 
<script src="js/custom.js"></script> 

</body>
</html>
