<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


    <meta name="description" content="WebRTC reference app">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <meta itemprop="description" content="Video chat using the reference WebRTC application">
    <meta itemprop="image" content="/images/webrtc-icon-192x192.png">
    <meta itemprop="name" content="AppRTC">
    <meta name="mobile-web-app-capable" content="yes">
    <meta id="theme-color" name="theme-color" content="#1e1e1e">

    <!--<base target="_blank">-->
    <base href="." target="_blank">

    <title>AppRTC</title>

    <link rel="canonical" href="https://apprtc.dev/r/sazzad">

    <link rel="stylesheet" href="./main.css">

</head>

<body>
<!--
 * Keep the HTML id attributes in sync with |UI_CONSTANTS| defined in
 * appcontroller.js.
-->
<div id="videos">
    <video id="mini-video" autoplay="" muted=""></video>
    <video id="remote-video" autoplay=""></video>
    <video id="local-video" autoplay="" muted="" class="active"></video>
</div>

<div id="room-selection" class="hidden">
    <h1>AppRTC</h1>
    <p id="instructions">Please enter a room name.</p>
    <div>
        <div id="room-id-input-div">
            <input type="text" id="room-id-input" autofocus="">
            <label class="error-label hidden" for="room-id-input" id="room-id-input-label">Room name must be 5 or more
                characters and include only letters, numbers, underscore and hyphen.</label>
        </div>
        <div id="room-id-input-buttons">
            <button id="join-button">JOIN</button>
            <button id="random-button">RANDOM</button>
        </div>
    </div>
    <div id="recent-rooms">
        <p>Recently used rooms:</p>
        <ul id="recent-rooms-list"></ul>
    </div>
</div>

<div id="confirm-join-div" class="hidden">
    <div>Ready to join<span id="confirm-join-room-span"> "sazzad"</span>?</div>
    <button id="confirm-join-button">JOIN</button>
</div>

<footer>
    <div id="sharing-div" class="active">
        <div id="room-link">Waiting for someone to join this room: <a id="room-link-href"
                                                                      href="https://apprtc.dev/r/sazzad" target="_blank">https://apprtc.dev/r/sazzad</a>
        </div>
    </div>
    <div id="info-div"><pre id="info-box-stats" style="line-height: initial">Version:
gitHash:    8aa99b92a1fb8eefa9a21051a660a53e36013769
branch:     master
time:       Wed May 3 16:23:48 2017 +0200
</pre>
    </div>
    <div id="status-div"></div>
    <div id="rejoin-div" class="hidden"><span>You have left the call.</span>
        <button id="rejoin-button">REJOIN</button>
        <button id="new-room-button">NEW ROOM</button>
    </div>
</footer>

<div id="icons" class="">

    <svg id="mute-audio" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="-10 -10 68 68">
        <title>title</title>
        <circle cx="24" cy="24" r="34">
            <title>Mute audio</title>
        </circle>
        <path class="on" transform="scale(0.6), translate(17,18)"
              d="M38 22h-3.4c0 1.49-.31 2.87-.87 4.1l2.46 2.46C37.33 26.61 38 24.38 38 22zm-8.03.33c0-.11.03-.22.03-.33V10c0-3.32-2.69-6-6-6s-6 2.68-6 6v.37l11.97 11.96zM8.55 6L6 8.55l12.02 12.02v1.44c0 3.31 2.67 6 5.98 6 .45 0 .88-.06 1.3-.15l3.32 3.32c-1.43.66-3 1.03-4.62 1.03-5.52 0-10.6-4.2-10.6-10.2H10c0 6.83 5.44 12.47 12 13.44V42h4v-6.56c1.81-.27 3.53-.9 5.08-1.81L39.45 42 42 39.46 8.55 6z"
              fill="white"></path>
        <path class="off" transform="scale(0.6), translate(17,18)"
              d="M24 28c3.31 0 5.98-2.69 5.98-6L30 10c0-3.32-2.68-6-6-6-3.31 0-6 2.68-6 6v12c0 3.31 2.69 6 6 6zm10.6-6c0 6-5.07 10.2-10.6 10.2-5.52 0-10.6-4.2-10.6-10.2H10c0 6.83 5.44 12.47 12 13.44V42h4v-6.56c6.56-.97 12-6.61 12-13.44h-3.4z"
              fill="white"></path>
    </svg>

    <svg id="mute-video" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="-10 -10 68 68">
        <circle cx="24" cy="24" r="34">
            <title>Mute video</title>
        </circle>
        <path class="on" transform="scale(0.6), translate(17,16)"
              d="M40 8H15.64l8 8H28v4.36l1.13 1.13L36 16v12.36l7.97 7.97L44 36V12c0-2.21-1.79-4-4-4zM4.55 2L2 4.55l4.01 4.01C4.81 9.24 4 10.52 4 12v24c0 2.21 1.79 4 4 4h29.45l4 4L44 41.46 4.55 2zM12 16h1.45L28 30.55V32H12V16z"
              fill="white"></path>
        <path class="off" transform="scale(0.6), translate(17,16)"
              d="M40 8H8c-2.21 0-4 1.79-4 4v24c0 2.21 1.79 4 4 4h32c2.21 0 4-1.79 4-4V12c0-2.21-1.79-4-4-4zm-4 24l-8-6.4V32H12V16h16v6.4l8-6.4v16z"
              fill="white"></path>
    </svg>

    <svg id="fullscreen" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="-10 -10 68 68">
        <circle cx="24" cy="24" r="34">
            <title>Enter fullscreen</title>
        </circle>
        <path class="on" transform="scale(0.8), translate(7,6)"
              d="M10 32h6v6h4V28H10v4zm6-16h-6v4h10V10h-4v6zm12 22h4v-6h6v-4H28v10zm4-22v-6h-4v10h10v-4h-6z"
              fill="white"></path>
        <path class="off" transform="scale(0.8), translate(7,6)"
              d="M14 28h-4v10h10v-4h-6v-6zm-4-8h4v-6h6v-4H10v10zm24 14h-6v4h10V28h-4v6zm-6-24v4h6v6h4V10H28z"
              fill="white"></path>
    </svg>

    <svg id="hangup" class="hidden" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="-10 -10 68 68">
        <circle cx="24" cy="24" r="34">
            <title>Hangup</title>
        </circle>
        <path transform="scale(0.7), translate(11,10)"
              d="M24 18c-3.21 0-6.3.5-9.2 1.44v6.21c0 .79-.46 1.47-1.12 1.8-1.95.98-3.74 2.23-5.33 3.7-.36.35-.85.57-1.4.57-.55 0-1.05-.22-1.41-.59L.59 26.18c-.37-.37-.59-.87-.59-1.42 0-.55.22-1.05.59-1.42C6.68 17.55 14.93 14 24 14s17.32 3.55 23.41 9.34c.37.36.59.87.59 1.42 0 .55-.22 1.05-.59 1.41l-4.95 4.95c-.36.36-.86.59-1.41.59-.54 0-1.04-.22-1.4-.57-1.59-1.47-3.38-2.72-5.33-3.7-.66-.33-1.12-1.01-1.12-1.8v-6.21C30.3 18.5 27.21 18 24 18z"
              fill="white"></path>
    </svg>

</div>
<div id="privacy" class="hidden">
    <a href="https://www.google.com/accounts/TOS">Terms</a>
    |
    <a href="https://www.google.com/policies/privacy/">Privacy</a>
    |
    <a href="https://github.com/webrtc/apprtc">Code repo</a>
</div>


<script src="./js/util.js"></script>
<script src="./js/appcontroller.js"></script>
<script src="./js/adapter.js"></script>
<script src="./js/call.js"></script>
<script src="./js/constants.js"></script>
<script src="./js/infobox.js"></script>
<script src="./js/peerconnectionclient.js"></script>
<script src="./js/remotewebsocket.js"></script>
<script src="./js/roomselection.js"></script>
<script src="./js/sdputils.js"></script>
<script src="./js/signalingchannel.js"></script>
<script src="./js/stats.js"></script>
<script src="./js/storage.js"></script>
<script src="./js/windowport.js"></script>


<script type="text/javascript">
    var loadingParams = {
        errorMessages: [],
        isLoopback: false,
        warningMessages: [],
        roomServer: 'https://apprtc.dev',
        roomId: 'sazzad',
        roomLink: 'https://apprtc.dev/r/sazzad',


        mediaConstraints: {
            "audio": true,
            "video": { "optional": [{ "minWidth": "1280" }, { "minHeight": "720" }], "mandatory": {} }
        },
        offerOptions: {},
        peerConnectionConfig: { "rtcpMuxPolicy": "require", "bundlePolicy": "max-bundle", "iceServers": [] },
        peerConnectionConstraints: { "optional": [] },
        turnRequestUrl: 'https://computeengineondemand.appspot.com/turn?username=831555083&key=4080218913',
        iceServerRequestUrl: 'https://networktraversal.googleapis.com/v1alpha/iceconfig?key=AIzaSyAJdh2HkajseEIltlZ3SIXO02Tze9sO3NY',
        iceServerTransports: '',
        wssUrl: 'wss://apprtc-ws.webrtc.org:443/ws',
        wssPostUrl: 'https://apprtc-ws.webrtc.org:443',
        bypassJoinConfirmation: false,
        turnServerOverride: [],
        versionInfo: {
            "gitHash": "8aa99b92a1fb8eefa9a21051a660a53e36013769",
            "branch": "master",
            "time": "Wed May 3 16:23:48 2017 +0200"
        },
        callstatsParams: {
            "appSecret": "Ew03QUKBLp5D:hdEwlXtR0IwwOi8nhfAK8zLfKZjPBBYWCvz72h/P908=",
            "appId": "110765241"
        }
    };

    var appController;

    function initialize() {
        // We don't want to continue if this is triggered from Chrome prerendering,
        // since it will register the user to GAE without cleaning it up, causing
        // the real navigation to get a "full room" error. Instead we'll initialize
        // once the visibility state changes to non-prerender.
        if (document.visibilityState === 'prerender') {
            document.addEventListener('visibilitychange', onVisibilityChange);
            return;
        }
        appController = new AppController(loadingParams);
    }

    function onVisibilityChange() {
        if (document.visibilityState === 'prerender') {
            return;
        }
        document.removeEventListener('visibilitychange', onVisibilityChange);
        initialize();
    }

    initialize();
</script>

</body>
</html>