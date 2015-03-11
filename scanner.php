<?php 
/*
Plugin Name: QR Code Scanner
Plugin URI: http://emanager.nyc
Description: QR code scanner for Wordpress
Author: Matthew M. Emma
Version: 0.4
Author URI: http://www.emanager.nyc
*/
/*-------------------------------------------------------*/
/* Enqueue scripts
/*-------------------------------------------------------*/

$WPQRScanner = new QRScanner();

class QRScanner {
  protected $mwidth;
  protected $mheight;
  public function __construct() {
    add_action( 'wp_enqueue_scripts', array($this, 'qrscan_scripts'), 10, 0  );
    add_action( 'wp_footer', array($this, 'qrscan_fscript'));
    add_shortcode('qrscan', array($this, 'qrscan_shortcode'));
  }
  public function qrscan_scripts() {
    wp_register_script('html5_qrcode', plugins_url('html5-qrcode.min.js', __FILE__), array( 'jquery'),null);

    wp_enqueue_script('html5_qrcode');
  }
public function strLength($str,$len){ 
      $length = strlen($str); 
      if($length > $len){ 
          return substr($str,0,$len).'...'; 
      }else{ 
          return $str; 
      } 
  } 
public function qrscan_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'width' => '400px',
    'height' => '400px'
  ), $atts, 'qrscan' ) );

  $this->mwidth = $width;
  $this->mheight = $height;

  $v = '<center><div id="reader" style="width:'.$width.';height:'.$height.'"></div>
        <h6 class="center">Result</h6>
        <span id="read" class="center"></span>
        <br>

        <h6 class="center">Read Error (Debug only)</h6>
        <span class="center">Will constantly show a message, can be ignored</span>
        <span id="read_error" class="center"></span>

        <br>
        <h6 class="center">Video Error</h6>
        <span id="vid_error" class="center"></span>
        </center>';
  return $v;
}
public function qrscan_fscript() {
    ?>
    <script id="qrscanner">
    jQuery(document).ready(function($){
      $('#reader').html5_qrcode(function(data){
          $('#read').html(data);
        },
        function(error){
          $('#read_error').html(error);
        }, function(videoError){
          $('#vid_error').html(videoError);
        }
      );
    });
  </script>
  <?php
  }
}