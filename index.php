<!DOCTYPE html>
<html>
<head>
    <title>The Metra</title>
</head>
<body>

<form action="index.php" method="post">
    <input type="text" name="url" required>
    <button type="submit">Send</button>
</form>

</body>
</html>
<!---->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['url']) {
    $url = $_POST['url'];
    function Analysis($url)
    {

        if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {

            $html = file_get_contents($url);
            //###########Create a new DOM document##############//
            preg_match('/<title>(.*)<\/title>/i', $html, $title);
            $title_out = $title[1];
            echo 'Title Of Site ::---' . $title_out . '<br>';
            $dom = new DOMDocument;
            @$dom->loadHTML($html);
            //Get all links. You could also use any other tag name here,
            $links = $dom->getElementsByTagName('a');
            $numLinks = 0;
            $numerInternalHeaders = 0;
            $numperofExternalHeaders = 0;
            $loginCheck = '';
            //#########3make for in $links that we extarct it###############//
            foreach ($links as $link) {
                $numLinks++;
                //get number of sublink from our url
                if (strpos($link->getAttribute('href'), $url) !== false) {
                    $numerInternalHeaders++;
                }
                //###########Check if we have login or not##########//
                if (strpos($link->getAttribute('href'), 'login') !== false) {
                    $loginCheck = "This site contain login Form <br>";
                } else {
                    $loginCheck = "This site  not contain login Form <br>";
                }
            }
            //########for get External links #############//
            $numperofExternalHeaders = $numLinks - $numerInternalHeaders;
            if ($numperofExternalHeaders > 0) {
                $messForExternalHref = 'Yes we have an External heading and its Number is::--' . $numperofExternalHeaders . '<br>';
            } else {
                $messForExternalHref = 'Number of external heading inside page::-- ' . $numperofExternalHeaders . '<br>';
            }

            echo 'Number Of headings ::---' . $numLinks . '<br>';
            echo 'Number of internal heading inside page::-- ' . $numerInternalHeaders . '<br>';
            echo $messForExternalHref;
            echo $loginCheck;

        } else {
            echo 'this field required......<br> notice that this field must be valid url';
        }
    }
    Analysis($url);


}
