<?php
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
?><!DOCTYPE html>
<html lang="en">
  <head>
   <title>Demo: Save When Stop Trying</title>
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

    <script src="js/save-when-stop-typing.js"></script>
    <script>
    $(()=>{
      var saver = SaveWhenStopTyping($("#log"));
    });
    </script>
      
    <script>
    //TODO: Calculates hours missing (if lt 7 hours slept) vs hours recovered (if gt 7 hours slept)
    //JSFIDDLE: https://jsfiddle.net/Siphon880jsf/95e5cLwh/

        
    function round(value, exp) {
      if (typeof exp === 'undefined' || +exp === 0)
        return Math.round(value);

      value = +value;
      exp = +exp;

      if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
        return NaN;

      // Shift
      value = value.toString().split('e');
      value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

      // Shift back
      value = value.toString().split('e');
      return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
    }
        
    function removeIntermediateTokens() { // removes ^ and $ added to text to calculate hours
        var textS1 = $("textarea#log").val(),
            textS2 = textS1.replace(/[\^]/g, ""),
            text = textS2.replace(/[\$]/g, "");
    
        $("textarea#log").val(text); 
    } // removeIntermediateTokens

    function removeEmptyCheckboxes() {
      var text = $("textarea#log").val();
      var lines = text.split("\n"),
          newLines = [];

      for(var i=0; i<lines.length; i++) {
          if(lines[i].indexOf("[]")===-1 && lines[i].indexOf("[ ]")===-1) {
                  newLines.push(lines[i]);
          }
      }

      text = newLines.join("\n");            if(tthis.callbacks!==undefined) {
              if(Array.isArray(tthis.callbacks)) {
                for(i = 0; i<tthis.callbacks.length; i++) {
                  tthis.callbacks[i].call(tthis.$textarea);
                } // for
              } else {
                var callback = tthis.callbacks;
                callback.call(tthis.$textarea);
              } // else
            } // if not undefined
      $("textarea#log").val(text); 
    } // removeEmptyCheckboxes

    function removeBeginningTexts() {
      var text = $("textarea#log").val();
      var lines = text.split("\n"),
          newLines = [];

      for(var i=0; i<lines.length; i++) {
        var line = lines[i];

        // Remove Submit and @ at beginning of lines
        line = line.replace(/\s*Submit.*/, "Warning: EverNote Web does not keep track of checked/unchecked when pasted to apps other than Safari. Use Safari.\n");
        line = line.replace(/s*@.*/, "");
        newLines.push(line);
      }

      text = newLines.join("\n");
      $("textarea#log").val(text); 
    } // removeBeginningTexts

    // remove trailing blank lines because it'd cause old calc lines to be duplicated when recalculating
    function removeTrailingBlankLines() {
      var text = $("textarea#log").val();
      var lines = text.split("\n");

      for(var i=lines.length-1; i>=0; i--) {
        if(lines[i].length===0) {
          lines.splice(-1);
          console.log("spliced");
        } else {
          console.log("break");
          break;
        }
      }

      text = lines.join("\n");
      $("textarea#log").val(text); 
    } // removeTrailingBlankLines

    // Removes triple lines into double lines. Why not remove double lines? Because sometimes you want double lines because it is more presentable.
    function removeTripleLines() {
        var text = $("textarea#log").val();
        // text = text.replace(/(?![a-zA-Z0-9])\n\n\n/g, "");
        text = text.replace(/\n\n\n/g, "\n\n");

        $("textarea#log").val(text); 
    }

    function removeOldCalcs() {
      var text = $("textarea#log").val();
      var lines = text.split("\n"),
          newLines = [];

      for(var i=0; i<lines.length; i++) {
          if(lines[i].indexOf("Missing")!==0 && lines[i].indexOf("Recovered")!==0 && lines[i].indexOf("Satisfied")!==0) {
              newLines.push(lines[i]);
          } // for
          else {
            if(i-1!==-1 && newLines[i-1].length===0)
              newLines.splice(i-1, 1);
          }
      } // for

      text = newLines.join("\n");
      $("textarea#log").val(text); 
    } // removeOldCalcs

    window.oldText = ""; // for undoing

    function clearText() {
      if($("#log").val().length>0)
        if(!confirm("Are you sure you want to clear the text?")) 
          return;

      window.oldText = $("#log").val();
      $("#clear").hide();
      $("#undo").show();
      window.currentTimer = setTimeout( ()=> {
        $("#clear").show();
        $("#undo").hide();
      }, 3000);

      $("#log").val("");
    } // clearText

    function undoText() {
      $("#log").val(window.oldText);
      clearInterval(window.currentTimer);
      $("#undo").hide();
      $("#undo-example").hide();
      $("#clear").show();
      $("#example").show();
    }

    function pullExample() {
      if($("#log").val().length>0)
        if(!confirm("Are you sure you want to replace the text?")) 
          return;

      window.oldText = $("#log").val();
      window.currentTimer = null;

      const exampleText = $("#example-text").text();
      $("#log").val(exampleText);
      $("#example").hide();
      $("#undo-example").show();
      window.currentTimer = setTimeout( ()=> {
        $("#example").show();
        $("#undo-example").hide();
      }, 3000);
    } // pullExample

    function calculate(preformatters, postformatters) {

      if(preformatters!==undefined) {
        for(var i=0; i<preformatters.length; i++)
        preformatters[i]();
      }

      var textS1 = $("textarea#log").val(),
          textS2 = textS1.replace(/[\^]/g, ""),
          text = textS2.replace(/[\$]/g, ""),
          
          lines = text.split("\n"),
          total = 0;

      var asleepHour = 0; // aka probably asleep hour

      //console.clear();

      function validPLine(testString, toArr1) {
        // Less restrictive: /^P(.*?)\d+/i
        var match = (/^P[a-z]{0,4}[\s]{0,}\d{1,4}/i).exec(testString);
        if(match!==null) {
          if(toArr1!==undefined && toArr1===true) {
              asleepHour = parseLine(testString);
              arr1.push(testString);
              arr1.push(asleepHour);
          }
          return true;
        } else {
          return false;
        }
      }

      var arr1 = [],
          arr2 = [];


      function validWLine(testString, toArr2) {
        // Less restrictive: /^W(.*?)\d+/i
        var match = (/^W[a-z]{0,4}[\s]{0,}\d{1,4}/i).exec(testString);
        if(match!==null) {
            //console.log("++++++");
          if(toArr2!==undefined && toArr2===true) {
            awakeHour = parseLine(testString);
              console.alert("!");
            arr2.push(testString);
            arr2.push(awakeHour);
          }
          return true;
        } else {
          return false;
        }
      }

      function parseLine(humanString) {
        console.log("Parse Line");
        var match = (/[\d]+/).exec(humanString);
        if(match!==null) {
          var numString = match[0],
              zerothHour = (numString[0]==='0');

          if(numString.length===3)
            numString = '0'+numString;

          var num = 0,
              hr = 0,
              fraction = 0;

          if(!zerothHour && parseInt(numString)<100) {
            // Force to military time int
            num = parseInt(match[0]) * 100;
          } else {
            num = parseInt(match[0]);
          }

          hr = (num - num%100)/100;

          var remainder = num % 100;
          fraction = remainder/60;
            
          return hr + fraction;
        } else {
          return 0
        }
      }

      function solveMidnightNoonProblem(passByReferenceObj) {
          
        var asleepHour = passByReferenceObj.asleepHour,
            awakeHour = passByReferenceObj.awakeHour;
          
        // Considers all cases where user might use military time or not inconsistently for sleep and awake
        if(awakeHour < asleepHour) {
          if(asleepHour<=12) {
            awakeHour+=12;
          } else {
            awakeHour+=24;
          }
        } // if
          
          /*console.log("%cexp:", "font-weight: 900");
          console.dir({asleepHour: asleepHour, awakeHour: awakeHour});*/
          
        if(asleepHour>=12 && asleepHour<13 && awakeHour>=24) {
            asleepHour+=12;
        }
          
          passByReferenceObj.asleepHour = asleepHour;
          passByReferenceObj.awakeHour = awakeHour;
      } // solveMidnightNoonProblem
      
    // Sometimes you subtract minutes from 60, sometimes it's just the minutes
    window.subtrOrAsIsMM = {
      awakeRemainder: undefined,
      asleepRemainder: undefined
    }
    function solveLostOrGainMMProblem() {
      console.log(">>>")
      Math.round(0.3000000000000007*10)/10;
      console.log(window.subtrOrAsIsMM.awakeRemainder);
      console.log(window.subtrOrAsIsMM.asleepRemainder);
      console.log(total);
      console.log("<<<")
      if(window.subtrOrAsIsMM.awakeRemainder < window.subtrOrAsIsMM.asleepRemainder) 
        if(total<7)
          return "LOST";
        else
          return "GAIN";
      else if(window.subtrOrAsIsMM.awakeRemainder > window.subtrOrAsIsMM.asleepRemainder) 
        if(total>7)
          return "GAIN";
        else
          return "LOST";
      else
        return 0;
    }

    function willPairW(lines, j) {
        console.log(lines[j]);
        for(;j<=lines.length;j++) {
            if(validPLine(lines[j]))
                return false;
            else if(validWLine(lines[j])) {
                nextWLine = j;
                return true;
            }
        } // for
    } // willPairW

        var nextPLine = -1,
            nextWLine = -1; // will be assigned via reference at funtion willPairW

      for(var i=0; i<lines.length; i++) {
        if (i+1==lines.length+1) {
          return;
        } else if(validPLine(lines[i]) && willPairW(lines, i+1)) {
          lines[i] = "^" + lines[i];
          var asleepHour = parseLine( lines[i] );

          arr1.push(lines[i]);
          arr1.push(asleepHour);
        }

        if(validWLine(lines[i])) {
            lines[i] = "$" + lines[i];
            if(arr1.length>arr2.length) {
              var awakeHour = parseLine( lines[i] );
              arr2.push(lines[i]);
              arr2.push(awakeHour);
            }
            
            
              var passByReferenceObj = {};
              passByReferenceObj.awakeHour = awakeHour;
              passByReferenceObj.asleepHour = asleepHour;
              solveMidnightNoonProblem(passByReferenceObj);

              window.subtrOrAsIsMM.awakeRemainder = awakeHour%1;
              window.subtrOrAsIsMM.awakeRemainder = Math.round(window.subtrOrAsIsMM.awakeRemainder*100)/100; // force round 0.00

              if(typeof window.subtrOrAsIsMM.asleepRemainder==="undefined") {
                window.subtrOrAsIsMM.asleepRemainder = asleepHour%1;
                window.subtrOrAsIsMM.asleepRemainder = Math.round(window.subtrOrAsIsMM.asleepRemainder*100)/100; // force round 0.00
              }

              // Then round
              awakeHour = round(passByReferenceObj.awakeHour, 2);
              asleepHour = round(passByReferenceObj.asleepHour, 2);

              total += (awakeHour - asleepHour);
        } // pairing done


      } // for

      var newText = "";
      for(var i=0; i<lines.length; i++) {
        newText += lines[i] + "\r";
      }
      $("textarea#log").val(newText);

      console.log(lines);

      console.log("%cAsleep hours:", "font-weight: 900;");
      console.dir(arr1);

      console.log("%cWake hours:", "font-weight: 900;");
      console.dir(arr2);

      function mmhh(total) {
        // debugger;
        total = total.toFixed(2);
        var remainder = (total%1).toFixed(2);

        // var hh = 0;
        var mm = 0;
        
/*         if(total>7) {
          hh = Math.floor(total-7);
        } else if (total==7) {
          hh = 7;
        } else if (total<7) {
          hh = Math.floor(total-7);
          hh = Math.abs(hh);
        } */

        if(solveLostOrGainMMProblem(total)==="LOST") {
          mm = (60-(remainder*60)).toFixed(0);
          console.log("LOST");
          console.log(mm);
        } else if(solveLostOrGainMMProblem(total)==="GAIN") {
          mm = (remainder*60).toFixed(0);
          console.log("GAIN");
          console.log(mm);
        } else {
          mm = 0;
          console.log("ELSE");
          console.log(mm);
        }

        //return `${hh}h ${mm}m`;
        
        console.log("%cTotal:", "font-weight: 900;");
        console.dir(total);
          
        // minDiff math is wrong, now superceded by mm math          
        var minDiff = 0,
            hrDiff = 0;
          
        // Do not move the abs functions
        if(total<7) {
            minDiff = total%1; // gets .25mins for example
            minDiff--;
            minDiff*=60;

            // Old:
            // minDiff=Math.round(minDiff); // gets rid of dec's
            // minDiff=Math.abs(minDiff);
            // minDiff=(minDiff===60?0:minDiff);

            // New:
            // Differentiates 10pm to 4pm VS 4pm to 10pm
            minDiff=Math.round(minDiff); // gets rid of dec's
            switch(minDiff) {
              case -60:
                minDiff = 0;
                break;
              case 0:
                break;
              case 60:
                minDiff = 0;
                break;
              default:
            }
            minDiff=Math.abs(minDiff);


            hrDiff=7-total;
            hrDiff=Math.abs(hrDiff);
            hrDiff=Math.floor(hrDiff);
        } else {
            minDiff = total%1; // gets .25mins for example
            minDiff*=60;
            minDiff=Math.round(minDiff); // gets rid of dec's
            minDiff=Math.abs(minDiff);
            minDiff=(minDiff===60?0:minDiff);

            hrDiff=total-7;
            hrDiff=Math.abs(hrDiff);
            hrDiff=Math.floor(hrDiff);
        }
        
          
        console.log("%cMinutes Diff:", "font-weight: 900;");
        console.dir(minDiff);

        console.log("%cHours Diff:", "font-weight: 900;");
        console.dir(hrDiff);

        // minDiff math is wrong, now superceded by mm math
        return `${hrDiff}h ${mm}m`;
        
      } // mmhh

      total = parseFloat(total.toFixed(2));
      if(arr1.length===0 || arr2.length===0) {
        let htmlResult = `Error: Are there P and W lines?`;
        $("#result").removeClass("text-success text-danger").addClass("text-danger");
        $("#result").html(htmlResult);

      } else if(total>7) {
        let htmlResult = `Recovered ${mmhh(total)}`,
            textResult = `${$("textarea#log").val()}\nRecovered ${mmhh(total)} (total:${total.toFixed(2)}h)`;
        $("#result").removeClass("text-success text-danger").addClass("text-success");
        $("#result").html(htmlResult);
        $("textarea#log").val(textResult);
      } else if(total===7) {
        let htmlResult = `Satisfied`,
            textResult = `${$("textarea#log").val()}\nSatisfied (total:${total.toFixed(2)}h)`;
        $("#result").removeClass("text-success text-danger").addClass("text-success");
        $("#result").html(htmlResult);
        $("textarea#log").val(textResult);
      } else {
        let htmlResult = `Missing ${mmhh(total)}`,
            textResult = `${$("textarea#log").val()}\nMissing ${mmhh(total)} (total:${total.toFixed(2)}h)`;
        $("#result").removeClass("text-success text-danger").addClass("text-danger");
        $("#result").html(htmlResult);
        $("textarea#log").val(textResult);
      }
        
      // Jump down
      window.location.hash = "#calculate";

      if(postformatters!==undefined) {
        for(var i=0; i<postformatters.length; i++)
        postformatters[i]();
      }

    } // calculate
        
    // Able to select text programmatically
    function selectDiv(el, win) {
        win = win || window;
        var doc = win.document, sel, range;
        if (win.getSelection && doc.createRange) {
            sel = win.getSelection();
            range = doc.createRange();
            range.selectNodeContents(el);
            sel.removeAllRanges();
            sel.addRange(range);
        } else if (doc.body.createTextRange) {
            range = doc.body.createTextRange();
            range.moveToElementText(el);
            range.select();
        }
    } // selectDiv

    function selectAndCopyTextarea($el, $done) {
      this.selectTextarea = function($el, callback) {
        var isIOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);

        if(isIOS)
          $el.get(0).setSelectionRange(0,9999);
        else
          $el.select();

        callback();
      } // selectTextarea

      this.saveToClipboard =function() {
        try {
          var successful = document.execCommand( 'copy' );
          var msg = successful ? 'successful' : 'unsuccessful';
          console.log('Copying text command was ' + msg);
          $done.fadeIn(800).delay(1200).fadeOut(500);
        } catch (err) {
          console.log('Oops, unable to copy');
        }

      } // saveToClipboard

      this.selectTextarea($el, saveToClipboard);

    } // selectAndCopyTextarea
    </script>

    <script>
    function jumpToBottomTextarea() {
      const $ta = $("textarea").first(),
            ta = $ta[0];
            
      var lineHeight = ta.scrollHeight / ta.rows;
      var jump = (ta.rows - 1) * lineHeight;
      ta.scrollTop = jump;
    } // jumpToBottomTextarea
    </script>
    
</head>
    <body>
      <div class="container">
        <label for="log">Demo - Save When Stop Typing</label><br>
        <div style="font-size:12px;">By Weng Fei Fung</div>
          <textarea id="log"></textarea>
        <div style="margin-top:10px;">
          This is a demo of the Save When Stopping repository. <a href="README.md" target="_blank">ReadMe is here</a>.
        </div>
            
      </div> <!-- /.container -->
        
      <!-- Bootstrap JS -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    </body>
</html>