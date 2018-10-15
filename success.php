<!DOCTYPE html><html lang="en" class="">
<head>
        <meta charset="UTF-8"><meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <header name = "Access-Control-Allow-Origin" value = "*" />
        <script src="https://bootstrapcreative.com/wp-bc/wp-content/themes/wp-bootstrap/codepen/bootstrapcreative.js?v=1"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css">
    </head>
    <body style="background-color:#eceeef">
        <div class="jumbotron text-xs-center">
            <h1 class="display-3">Thank You!</h1>
            <p class="lead" style="margin-top:2%">
            <?php
            $city = $_GET['city'];
            $region = $_GET['region'];
            $time = $_GET['time'];
            $email = $_GET['email'];
            $phone = $_GET['phone'];
            $confirmation = $_GET['confirmation'];
            
            $message = "";
            if ($confirmation == 'u') {
                $message = "Your registration has been confirmed for <strong>" . $city . "</strong>";
                if ($region != "") {
                    $message .= " in <strong>" . substr($region, 0, strpos($region, '(')) . "(" . $time . ")</strong>";
                }

                $message .= ". You will receive an sms on <strong>" . $phone . "</strong> and an email at <strong>" . $email . "</strong>";
            } else {
                $message = "Your registration has been queued for <strong>" . $city . "</strong>";
                if ($region != "") {
                    $message .= " in <strong>" . substr($region, 0, strpos($region, '(')) . "</strong>";
                }

                $message .= ". You will receive an sms on <strong>" . $phone . "</strong> and an email at <strong>" . $email . "</strong>";
            }

            echo $message;
            ?>
            <hr>
            <p class="lead">
                Any problems or queries? You can mail us at contactbakul@gmail.com
            </p>
            <p class="lead">
                <a class="btn btn-primary btn-sm" href="http://www.bakul.org/" role="button">Continue to Bakul Foundation Home Page</a>
            </p>
        </div>
        <div class="container">
            <div id="yin-yang"></div>
        </div>
    </body>
</html>