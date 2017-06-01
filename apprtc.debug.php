<?php
$jss = [
    './js/adapter.js',
    './js/analytics.js',
    './js/appcontroller.js',
    './js/call.js',
    './js/constants.js',
    './js/infobox.js',
    './js/peerconnectionclient.js',
    './js/remotewebsocket.js',
    './js/roomselection.js',
    './js/sdputils.js',
    './js/signalingchannel.js',
    './js/stats.js',
    './js/storage.js',
    './js/util.js',
    './js/windowport.js',
];

foreach($jss as $js){
    echo "\n// Start: $js\n";
    echo file_get_contents($js);
    echo "\n// End: $js\n";
}
?>