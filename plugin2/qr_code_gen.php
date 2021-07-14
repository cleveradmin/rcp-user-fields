<?php
/*
Plugin Name: QR code generator
Description: Custom user fields for community assocations.
Version: 1.0
Author: Clever IT
Author URI: https://cleverit.ca
*/
require_once(__DIR__."/qrcode.php");

function shortcode1($params=array()) {
    $message = "You must be a household member to view this page.";
    $paid = "true";
    $shortcode1 = sprintf('[restrict paid=%s message="%s"]', $paid, $message);
    echo do_shortcode($shortcode1);
}

function shortcode2($params=array()) {
    $shortcode1 = sprintf('[subscription_name]');
    echo do_shortcode($shortcode1);
}

function shortcode3($params=array()) {
    $id = get_current_user_id()
    echo $id;
}

function shortcode4($params=array()) {
    $value = rcp_get_expiration_date(get_current_user_id());
    echo $value;
}


function shortcode5($params=array()) {
    $id = get_current_user_id()
    $data = sprintf("ECCA-%s", $id);
    $options = array('w' => 150);
    $generator = new QRCode($data, $options);

    /* Output directly to standard output. */
    $generator->output_image();

    /* Create bitmap image. */
    $image = $generator->render_image();
    ob_start (); 
    imagejpeg ($image);
    $image_data = ob_get_contents(); 
    ob_end_clean (); 
    $image_data_base64 = base64_encode ($image_data);
    $img = sprintf('<img src="data:image/png;base64, %s" alt="QR code" />', $image_data_base64);
    echo $img;
}


function gen_qr_code($atts)
{
    /*
[restrict paid=true message="You must be a household member to view this page."]
<div class="membercard" style="text-align: center;">

<img style="width: 200px;" src="https://symonsvalley.ca/wp-content/uploads/2018/09/symonsvalley_logov2-200x77.png" alt="Avatar">
<p></p>
<h5 style="text-align: center;"><span style="text-decoration: underline; color: #89a02c;"><strong>Active [subscription_name] Member</strong></span></h5>
<div class="membercontainer">
<h6 style="text-align: center;"><b>ECCA-[su_user field="ID"]
Expires [user_expiration]</b></h6>
<br>
[kaya_qrcode_dynamic size="150"]ECCA-[su_user field="ID"][/kaya_qrcode_dynamic]
<br>
<img class="aligncenter" style="width: 75px;" src="https://eccacalgary.com/wp-content/uploads/2019/06/ecca_logo_sm.png" alt="Avatar">
    */
?>
<?php shortcode1(); ?>
<div class="membercard" style="text-align: center;">

<img style="width: 200px;" src="https://symonsvalley.ca/wp-content/uploads/2018/09/symonsvalley_logov2-200x77.png" alt="Avatar">
<p></p>
<h5 style="text-align: center;"><span style="text-decoration: underline; color: #89a02c;"><strong>Active <?php shortcode2(); ?> Member</strong></span></h5>
<div class="membercontainer">
<h6 style="text-align: center;"><b>ECCA-<?php shortcode3(array("field" => "ID")); ?>
Expires <?php shortcode4(); ?></b></h6>
<br>
<?php shortcode5(array("size" => "150")); ?>
<br>
<img class="aligncenter" style="width: 75px;" src="https://eccacalgary.com/wp-content/uploads/2019/06/ecca_logo_sm.png" alt="Avatar"
<?php
}

add_shortcode('qr-code-gen', 'gen_qr_code');