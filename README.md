Save When Stop Typing
===
By Weng Fei Fung

Calls functions when the user stops typing after a reasonable amount of time, so you can do things like:
- Save while user types but minimizing bandwidth use.
- Play an animation like "Keep typing!"

Requirements
---

Customize
---
How long the user stops typing for when we save:
```
this.poll = 1400; // ms
```

How to use
---
Pass a textarea or input text to the constructor, followed by a callback when the user stops typing.
```
let saver = TriggerWhenStopTyping($("#log"), callbackFunction);
```

Example 1
```
let saver = TriggerWhenStopTyping($("#log"), ()=>{alert("Ran after you stopped typing!")});
```

Example 2
```
let saver = TriggerWhenStopTyping($("#log"), save);

function save() {
  $.ajax({method:"post", url:`data/save.php`, data: { "log":$("#log").val() }}).done(()=>{
      // Web console: Saved
      console.log("%cSaved", "font-weight:900");
      $("#page-corner-anim").fadeIn(200); setTimeout(()=>{ $("#page-corner-anim").fadeOut(300); }, 500);
  }); // ajax
} // save


<div id="textarea-wrapper" style="position:relative;">
    <div id="page-corner-anim" style="z-index:99999; display: none; position: absolute; top:3px; right:3px; font-weight:400; background-color:yellow; border: 1.5px solid orange; border-radius:2.5px; padding-left: 5px; padding-right:5px; padding-top:2.5px; padding-bottom:2.5px;
    ">Saved!</div>
    <textarea id="textarea" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></textarea>
</div>

```