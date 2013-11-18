<?php
/**
 * User: Benftwc
 * Date: 18/11/13 21:00
 */

$vid = (isset($_GET['v'])) ? $_GET['v'] : NULL;
?>

<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">

    <title>Listen and Rain - Youtube Enhancer</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

    <style type="text/css">
        * { margin: 0; padding: 0; }
        html { background: black; }
        h1 { font: bold 50px/1 Sans-Serif; letter-spacing: -2px; margin: 0 0 20px 0; text-align: center;}
        h3 {margin: 0 0 20px 0; text-align: center;}
        body { width: 50%; margin: 50px auto; padding: 20px; background: white; }
        .form {margin: 0 auto; width: 500px;}
        form > * {width: 100%; text-align: center;}
        iframe { width: 100%; margin: 0 0 20px 0; }

        @media (max-width: 480px) {
            body { width: 90%; }
        }
    </style>

</head>
    <body>

    <h1>Listen and Rain<br>
        <small>Youtube Enhancer</small></h1>

        <?php if(isset($vid) && !is_null($vid)):

        require_once("youtube-parser.php");
        $feedURL = 'http://gdata.youtube.com/feeds/api/videos/' . $vid;
        $entry = simplexml_load_file($feedURL);
        $video = parseVideoEntry($entry);

        ?>

            <iframe id="iframe" src="http://www.youtube.com/embed/<?php echo $vid; ?>?rel=0&amp;hd=1&amp;autoplay=1&amp;controls=2" frameborder="0" allowfullscreen="" style="width: 855px; height: 511px;"></iframe>
            <h3>Video informations <br />

                <small>
                    <?php echo $video->title; ?> <br />
                </small>

            </h3>
            <div class="controllers">
                Repeater : <input type="checkbox" class="repeater" />
            </div>


        <script src="fit-yt.js"></script>
        <script>

            $("#iframe").ready(function () {
                setTimeout(function(){
                    if ($(".repeater").is(':checked')) {
                        $('#iframe').attr("src", $('#iframe').attr("src"));
                    } else {
                        console.log('tour +1');
                    }
                }, 10000);
                console.log('pouet');
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
    </body>
</html>