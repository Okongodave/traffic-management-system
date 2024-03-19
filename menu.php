<?php
// session_start();
$login = isset($_SESSION['profileType']);
$applicant = false; // Define $applicant outside the conditional block

if($login){
    $admin = $_SESSION['profileType'] == "ADMIN";
    $ovcca = $_SESSION['profileType'] == "OVCCA";
    $cashier = $_SESSION['profileType'] == "CASHIER";
    $operator = $_SESSION['profileType'] == "OPERATOR";
    $private = $_SESSION['profileType'] == "PRIVATE";
    $public = $_SESSION['profileType'] == "PUBLIC";
    $operations = $_SESSION['profileType'] == "OPERATIONS";
    $applicant = $_SESSION['profileType'] == "APPLICANT";
    $investigation = $_SESSION['profileType'] == "INVESTIGATION";
}
?>
<div id="header"></div>
<div id='options'>
    <ul>
        <?php if($applicant){ ?>
            <li><a class="howtoM menuitem" href="<?php echo $root; ?>RegistrationProcess.php"> Registration Process</a></li>
        <?php } ?>
        <?php if($login){ ?>
            <!-- for all users -->
            
            <li><a class="homepageM menuitem" href="<?php echo $root; ?>HomePage/"><i class='fa fa-home'></i> Home</a></li>
            
            <li><a class="profileM menuitem" href="<?php echo $root; ?>UpdateProfile/"><i class='fa fa-user'></i> Profile</a></li>
            
            <!-- admin -->
            <?php if($admin || $ovcca || $operations || $investigation){ ?>
                <li><a class="applicantM menuitem" href="<?php echo $root; ?>Applicant/"><i class='fa fa-users'></i> Users</a></li>
            <?php } ?>
            
            <?php if(!$cashier && !$operations || $investigation){ ?>
                <li><a class="vehicleM menuitem" href="<?php echo $root; ?>Vehicle/"><i class='fa fa-road'></i> Vehicle</a></li>
            <?php } ?>
            
            <?php if(!$cashier || $investigation){ ?>
                <li><a class="driverM menuitem" href="<?php echo $root; ?>Driver/"><i class='fa fa-user'></i> Driver</a></li>
            <?php } ?>
            
            <!-- cashier -->
            <?php if($cashier){ ?>
                <li><a class="vehicleM menuitem" href="<?php echo $root; ?>Vehicle/"><i class='fa fa-road'></i> Vehicle</a></li>
                <li><a class="paymentM menuitem" href="<?php echo $root; ?>Payment/"><i class='fa fa-money'></i> Payment</a></li>
            <?php } ?>
            
            <!-- admin, ovcca -->
            <?php if($admin || $ovcca || $operations || $investigation){ ?>
                <li><a class="violationM menuitem" href="<?php echo $root; ?>Violation/"><i class='fa fa-exclamation-triangle'></i> Violation</a></li>
            <?php } ?>
            
            <?php if($admin || $operations){ ?>
                <li><a class="inspectionM menuitem" href="<?php echo $root; ?>Inspection/"><i class='fa fa-eye'></i> Inspection</a></li>
            <?php } ?>
            
            <?php if($admin || $cashier){ ?>
                <li><a class="stickerM menuitem" href="<?php echo $root; ?>Sticker/"><i class='fa fa-star'></i> Sticker</a></li>
            <?php } ?>
            
            <?php if($ovcca || $admin){ ?>
                <li><a class="logM menuitem" href="<?php echo $root; ?>Log/"><i class='fa fa-list-alt'></i> Logs</a></li>
            <?php } ?>
            
            <?php if($admin){ ?>
                <li><a class="optionM menuitem" href="<?php echo $root; ?>Option/"><i class='fa fa-cog'></i> Option</a></li>
            <?php } ?>
            
            <!-- for all users -->
            <li style="float: right;"><a class="menuitem" href="<?php echo $root; ?>logout.php"><i class='fa fa-sign-out'></i> Logout</a></li>
        <?php } else { ?>
            <li style="float: right;"><a class="menuitem" href="
            <?php echo $root; ?>loginform.php/"><i class='fa fa-sign-in'></i> Login</a></li>
            <li style="float: right;"><a class="reportM menuitem" href="
            <?php echo $root; ?>Report/"><i class='fa fa-exclamation-triangle'></i> Report Violation</a></li>
        <?php } ?>
    </ul> 
</div>