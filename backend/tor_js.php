<?php
header('Content-type: text/javascript; charset=utf-8');
$ipsFile = file_get_contents('./exit_node_ips.txt', true);
$ips = preg_split ('/$\R?^/m', $ipsFile);

$v4mapped_prefix_hex = '00000000000000000000ffff';
$v4mapped_prefix_bin = pack("H*", $v4mapped_prefix_hex);
$addr = $_SERVER['REMOTE_ADDR'];
$addr_bin = inet_pton($addr);
if( $addr_bin === FALSE ) {
  die('Invalid IP address');
}
if( substr($addr_bin, 0, strlen($v4mapped_prefix_bin)) == $v4mapped_prefix_bin) {
  $addr_bin = substr($addr_bin, strlen($v4mapped_prefix_bin));
}
$clientIP = inet_ntop($addr_bin);
?>
/**
*
* tor.js
* Minimal JavaScript library to check if your visitors are TOR users
*
* Usage: https://simon-frey.eu/torjs/
* License: Public Domain (https://github.com/simonfrey/tor.js/blob/master/LICENSE)
**/

<?php
if (in_array($clientIP, $ips)) {
    echo "var isTOR = true;";
}else{   
     echo "var isTOR = false;";
}
?>

function executeForTOR(f) {
    if (isTOR){
        f();
    }
}
function executeForNotTOR(f) {
    if (!isTOR){
        f();
    }
}

function redirectTOR(url){
    var current = new URL(window.location);
    var redirect = new URL(url);
    current.hostname = redirect.hostname;
    executeForTOR(window.location.replace(current));
}