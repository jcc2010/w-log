<!DOCTYPE html>
<html>
    <head>
    <title>w-Log, Logged and Loaded for Queries</title>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
	<link rel="stylesheet" href="styles/blueprint/screen.css" type="text/css" media="screen, projection">
	<link rel="stylesheet" href="styles/blueprint/print.css" type="text/css" media="print">
    <!--[if lt IE 8]>
        <link rel="stylesheet" href="styles/blueprint/ie.css" type="text/css" media="screen, projection">
    <![endif]-->
	<link rel="stylesheet" href="../../blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection">
    <link href='http://fonts.googleapis.com/css?family=Reenie+Beanie' rel='stylesheet' type='text/css'>
    <style>
        header { font-family: 'Reenie Beanie', arial, serif; }
        caption { background: #fff; font-weight: bold; }
        #render_page { display: none; margin-top: 50px; }
        #display_log { margin-top: 50px;}
        #render_log { display: none; margin-top: 25px; margin-bottom: 25px; }
        #truncate_log_result { display: none; margin-top: 25px; margin-bottom: 25px; font-weight: bold; }
        iframe { height: 500px; border: 1px #000 solid; margin-bottom: 50px; }
        ul { list-style-type: none; }
        li { display: inline; padding-left: 20px; font-weight: bold; }
    </style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/webfont/1.0.4/webfont.js"></script>
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    </head>
    <body>
        <section class="container">
            <header>
                <h1 class="logo span-2">w-log</h1>
		        <hr>
		        <h2 class="alt">logged and loaded for queries.</h2>
		        <hr>
		    </header>
		    <section>

		        <section id="load_page">
                    <form id="load_url" method="post">
                        <fieldset>
                            <legend>Load Local URL</legend>
                            <input type="url" required="required" placeholder="URL" class="text" id="url_to_load" value="<?php echo $base_url; ?>">
                        </fieldset>
                        <input type="submit" value="Submit">
                    </form>
                </section>


                <section id="render_log">

                </section>

                <p id="truncate_log_result"></p>

                <section id="render_page">

                    <ul>
                        <li>
                            <a href="#render_log" title="Display Query Log" id="display_log">Display Log</a>
                        </li>
                        <li>
                            <a href="#truncate_log" title="Truncate Query Log" id="truncate_log">Empty Log</a>
                        </li>
                        <li>
                            <a href="#truncate_log" title="Turn Off Query Log" id="turn_off">Disable Log</a>
                        </li>
                        <li>
                            <a href="#truncate_log" title="Turn Off Query Log" id="turn_on">Enable Log</a>
                        </li>
                    </ul>
                    <iframe id="loaded_url" src="" class="span-24">

                    </iframe>

                </section>

		    </section>
            <hr class="space">
            <hr>
        </section>
            <script>

                $(document).ready(function() {

                    $('#display_log').click(function() {
                        var loadUrl = 'index.php?&phase=display_log';

                        $.get(
                            loadUrl,
                            {language: "php", version: 5},
                            function(responseText){
                                $("#render_log").html(responseText);
                            },
                            "html"
                        );
                        $("#render_log").fadeIn();
                        window.location.hash = '#render_log';
                    });

                    $('#truncate_log').click(function() {
                        var loadUrl = 'index.php?&phase=truncate_log';
                        $("#truncate_log_result").fadeIn();
                        $.get(
                            loadUrl,
                            {language: "php", version: 5},
                            function(responseText){
                                $("#truncate_log_result").html(responseText);
                            },
                            "html"
                        );
                        $("#render_log").fadeOut();
                        window.location.hash = '#truncate_log';
                    });

                    $('#turn_off').click(function() {
                        var loadUrl = 'index.php?&phase=disable_log';
                        $("#truncate_log_result").fadeIn();
                        $.get(
                            loadUrl,
                            {language: "php", version: 5},
                            function(responseText){
                                $("#truncate_log_result").html(responseText);
                            },
                            "html"
                        );
                        $("#render_log").fadeOut();
                        window.location.hash = '#truncate_log';
                    });

                    $('#turn_on').click(function() {
                        var loadUrl = 'index.php?&phase=enable_log';
                        $("#truncate_log_result").fadeIn();
                        $.get(
                            loadUrl,
                            {language: "php", version: 5},
                            function(responseText){
                                $("#truncate_log_result").html(responseText);
                            },
                            "html"
                        );
                        $("#render_log").fadeOut();
                        window.location.hash = '#truncate_log';
                    });

                    $('#load_url').submit(function() {
                        var loadUrl = 'index.php?&phase=truncate_log';
                        $('#truncate_log_result').load(loadUrl);

                        var loadUrl = 'index.php?&phase=set_log';
                        $('#truncate_log_result').load(loadUrl);

                        var url = $("#url_to_load").val();
                        $("#render_page").fadeIn();
                        $('#loaded_url').attr("src", url);

                        $("#render_log").fadeOut();
                        return false;
                    });

                });
            </script>
     </body>
</html>