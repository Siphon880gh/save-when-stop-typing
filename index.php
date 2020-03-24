<?php
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
?><!DOCTYPE html>
<html lang="en">
  <head>
   <title>Demo: Trigger/Save When Stop Trying</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    
    <!-- jQuery, Bootstrap, Font-Awesome  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    
    <style>
    body {
      text-align: left;
    }
    textarea {
      display: block;
      height: 40vh;
      width: 100%;
      margin: auto;
      margin-top: 5px;
    }
    </style>

    <script src="js/trigger-when-stop-typing.js"></script>
    <script>
    $(()=>{
      var detector = TriggerWhenStopTyping($("#log"), callback);
    });

    function callback() {
      console.log("Would have saved text.");
      $("#page-corner-anim").fadeIn(200); setTimeout(()=>{ $("#page-corner-anim").fadeOut(300); }, 500);
    }
    </script>
    
    </script>
    
</head>
    <body>
      <div class="container">
        <label for="log">Demo - Trigger/Save When Stop Typing</label><br>
        <div style="font-size:12px;">By Weng Fei Fung</div>

        <div id="textarea-wrapper" style="position:relative;">
              <div id="page-corner-anim" style="z-index:99999; display: none; position: absolute; top:3px; right:3px; font-weight:400; background-color:yellow; border: 1.5px solid orange; border-radius:2.5px; padding-left: 5px; padding-right:5px; padding-top:2.5px; padding-bottom:2.5px;
                ">Saved!</div>
              <textarea id="log" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">This is a demo of the Trigger When Stopping. You can implement a save() or animation() whenever someone stops typing after a reasonable amount of time. Try it in this textarea. Note: Not really saving because I don't want a hacker to overwhelm my server.</textarea>
        </div>

        <div style="margin-top:10px;">
          ReadMe is <a href="README.md" target="_blank">here</a>.
        </div>
            
      </div> <!-- /.container -->
        
      <!-- Bootstrap JS -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    </body>
</html>