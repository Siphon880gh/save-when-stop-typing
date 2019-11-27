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