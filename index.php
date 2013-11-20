<?php
/**
 * User: Benftwc
 * Date: 18/11/13 21:00
 */

$vid = (isset($_GET['v'])) ? $_GET['v'] : NULL;

$video = FALSE;
if(isset($vid)){
		require_once("youtube-parser.php");
        $feedURL = 'http://gdata.youtube.com/feeds/api/videos/' . $vid;
        $entry = simplexml_load_file($feedURL);
        $video = parseVideoEntry($entry);
}

if($video) {
	$title = $video->title . ' - Listen and Rain';
} else {
	$title = "Listen And Rain - Youtube Enhancer";
}

$imageID = rand(1,3);
$background = 'backgrounds/' . $imageID . '.gif';
?>

<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">

    <title><?php echo $title; ?></title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

    <style type="text/css">
        * { margin: 0; padding: 0; }
        html { background: black; }
        h1 { font: bold 50px/1 Sans-Serif; letter-spacing: -2px; margin: 0 0 20px 0; text-align: center;}
        h3 {margin: 0 0 20px 0; text-align: center;}
        body {height:100%; width: 100%; background: white; background-image: url('<?php echo $background; ?>'); background-size: cover; background-position: 50% 50%;}
        .form {margin: 50px auto; width: 50%}
	.container {width: 50%; padding:20px; margin: 0 auto; background: rgba(255, 255, 255, 0.75);}
        form > * {width: 100%; text-align: center;}
        iframe { width: 100%; margin: 0 0 20px 0; }

        @media (max-width: 480px) {
            body { width: 90%; }
        }
    </style>

</head>
    <body>
	<div class="container">
    <a href="https://github.com/benftwc/listenandrain"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_white_ffffff.png" alt="Fork me on GitHub"></a>
    <h1>Listen and Rain<br>
        <small>Youtube Enhancer</small></h1>

        <?php if(isset($vid) && !is_null($vid)): ?>

            <iframe id="iframe" src="http://www.youtube.com/embed/<?php echo $vid; ?>?rel=0&amp;hd=1&amp;autoplay=1&amp;controls=0&amp;iv_load_policy=3" frameborder="0" allowfullscreen="" style="width: 100%; height: 511px;"></iframe>
            <h3><?php echo $video->title; ?></h3>
            <div class="controllers">
                Repeater : <input type="checkbox" checked="checked" class="repeater" /> <span class="repeater-counter">1</span> listens<br />
                Mood : <span class="pause">Pause</span><span class="play" style="display: none;">Play</span> ( Set volume to :
                            <span class="quarter">1/3</span>
                            <span class="half" style="display: none">2/3</span>
                            <span class="full" style="display: none">3/3</span>
                )
            </div>


        <script>

            $("#iframe").ready(function () {
                var plays = 1;
                setInterval(function(){
                    if ($(".repeater").is(':checked')) {
                        $('#iframe').attr("src", $('#iframe').attr("src"));
                        plays++;
                        $('.repeater-counter').text(plays);
                    }
                }, <?php echo (int)$video->length*1000; ?>);
            });

            $(document).ready(function() {
                var audioElement = document.createElement('audio');
                audioElement.setAttribute('src', 'audio.mp3');
                audioElement.setAttribute('autoplay', 'autoplay');
                audioElement.setAttribute('loop', 'true');
                //audioElement.load()

                $.get();

                audioElement.addEventListener("load", function() {
                    audioElement.play();
                    audioElement.volume=1;
                }, true);


                $('.quarter').click(function() {
                    audioElement.volume=0.33;
                    $('.quarter').hide();
                    $('.half').show();
                });

                $('.half').click(function() {
                    audioElement.volume=0.66;
                    $('.half').hide();
                    $('.full').show();
                });

                $('.full').click(function() {
                    audioElement.volume=1;
                    $('.full').hide();
                    $('.quarter').show();
                });

                $('.play').click(function() {
                    $('.pause').show();
                    $('.play').hide();
                    audioElement.play();
                });
                $('.pause').click(function() {
                    $('.play').show();
                    $('.pause').hide();
                    audioElement.pause();
                });
                console.log(audioElement);
            });
        </script>


        <?php else: ?>
            <div class="form">
                <form method="GET">
                    <input type="text" name="v" placeholder="Enter video ID (eg. MmpAXq7sq8s)" />
                    <br />
                    <input type="submit" value="Enjoy ;)" />
                </form>
                <p>Or try this <a href="index.php?v=jofNR_WkoCE">demo</a>. Enjoy</p>
            </div>

    <?php endif; ?>
    <div class="form">
        <a href="https://twitter.com/share" class="twitter-share-button" data-via="Benftwc" data-size="large" data-hashtags="ListenAndRain">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<a href="https://twitter.com/Benftwc" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @Benftwc</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</div>
</div>
<?php require_once('ga-tracking.php'); ?>
    </body>
</html>
