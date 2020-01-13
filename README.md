Save When Stop Typing
===
By Weng Fei Fung<br/>
Algorithm saves text only when you stop typing, minimizing bandwidth use.

Requirements
---
data/save.php

Customize
---
How long the user stops typing for when we save:
```
this.poll = 1400; // ms
```

Change the required path from data/
```
this.relativeUrl = "data";
```

How to use
---
Pass a textarea or input text to the constructor.

Init with no callbacks:
```
let saver = SaveWhenStopTyping($("#log"));
```

Init with a callback:
```
let saver = SaveWhenStopTyping($("#log"), ()=>{alert("ran after saving")});
```

Init with callbacks:
```
let saver = SaveWhenStopTyping($("#log"), [()=>{alert("ran after saving")}, ()=>{alert("ran after saving2")}]);
```

Suggested UI
---
I recommend having a notification animation when saved so the user knows. Try this:

```
$(()=>{
    let saver = SaveWhenStopTyping($("#log"), () => { $("#page-corner-anim").fadeIn(200); setTimeout(()=>{ $("#page-corner-anim").fadeOut(300); }, 500); });
})

<div id="page-corner-anim" style="display: none; position: fixed; top:5px; right: 10px; font-weight:400; background-color:yellow; border: 1.5px solid orange; border-radius:2.5px; padding-left: 5px; padding-right:5px; padding-top:2.5px; padding-bottom:2.5px;">Saved!</div>
```

