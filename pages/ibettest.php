
<?php
$allowedDomains = [
    'sport.ibet288.com'
];

if (isset($_GET['target_url'])) {
    $url = $_GET['target_url'];

    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        echo "<p>Invalid URL provided.</p>";
        exit;
    }

    $parsedUrl = parse_url($url);
    $host = $parsedUrl['host'] ?? '';

    if (in_array($host, $allowedDomains)) {
        $safeUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

        echo '
        <style>
        body, html {margin:0; padding:0; height:100%;}
        .container {display:flex; flex-direction:column; height:100vh;}
        header, footer {background:#004080; color:#fff; padding:10px; text-align:center; flex-shrink:0;}
        .iframe-wrapper {flex:1 1 auto; overflow:hidden; position:relative;}
        .iframe-wrapper iframe {position:absolute; top:0; left:0; width:100%; height:100%; border:0;}
        </style>

        <div class="container">
            <header>My Custom Header</header>
            <div class="iframe-wrapper" id="iframeWrapper">
                <iframe id="myIframe" src="'.$safeUrl.'" scrolling="yes" referrerpolicy="no-referrer" allowfullscreen></iframe>
            </div>
            <footer>My Custom Footer</footer>
        </div>

        <script>
        // iOS Safari detect
        var isiOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

        if(isiOS){
            // iPhone/iOS ဖြစ်ရင် iframe hide, new tab ဖြင့်ဖွင့်
            document.getElementById("iframeWrapper").style.display = "none";
            window.open("'.$safeUrl.'", "_blank");
        }
        </script>
        ';
    } else {
        echo "<p>This URL is not allowed to be shown in an iframe.</p>";
    }
} else {
    echo "<p>No target URL provided.</p>";
}
?>




<?php 
    include(root.'master/footer.php');