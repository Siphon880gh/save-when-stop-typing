/**
 * @@class SaveWhenStopTyping
 * Once initialized, the text input or textarea DOM you initialized with will load from data/data.txt
 * and saves when you stop typing in the text input or textarea for 2 seconds.
 *
 * @param {jQuery Queried DOM} $textarea
 * 
 * @return {void}
 *
 * @examples
 *
 *     let saver = SaveWhenStopTyping($("#log));
 * 
 *     let saver = SaveWhenStopTyping($("#log), ()=>{alert("ran after saving")});
 * 
 *     let saver = SaveWhenStopTyping($("#log), [()=>{alert("ran after saving")}, ()=>{alert("ran after saving2")}]);
 * 
 */
function SaveWhenStopTyping($textarea, callbacks) { 
    /* Customizable */
    this.relativeUrl = "data";
    this.poll = 1200; // ms
    
    /* Engine */
    this.$textarea = $textarea; 
    this.callbacks = callbacks;
    if($textarea.length==0) {
        console.log("ERROR: jQuery queried DOM does not exist.");
        return;
    }
    var tthis = this;
    
    this.recounter = null;
    this.resetRecounter = () => {
        if(tthis.recounter!==null) {
        clearTimeout(tthis.recounter);
        }
        tthis.recounter = setTimeout(()=>{ 
        console.log(`Hadn't reset timer because no typing detected for ${tthis.poll}ms. This timer eventually saves text.`);
        tthis.save(); 
        }, tthis.poll);
    } // resetRecounter
    
    this.save = () => {
        $.ajax({method:"post", url:`${tthis.relativeUrl}/save.php`, data: { "log":tthis.$textarea.val() }}).done(()=>{
            // Web console: Saved
            console.log("%cSaved", "font-weight:900");
    
            // Callbacks
            if(tthis.callbacks!==undefined) {
            if(Array.isArray(tthis.callbacks)) {
                for(i = 0; i<tthis.callbacks.length; i++) {
                tthis.callbacks[i].call(tthis.$textarea);
                } // for
            } else {
                var callback = tthis.callbacks;
                callback.call(tthis.$textarea);
            } // else
            } // if not undefined
        }); // ajax
    } // save
    
    // On input
    this.$textarea
        .on("input", () => {
            tthis.resetRecounter();
            console.log("Resetted timer because user typed. This timer eventually saves text.");
        }) // keydown
        .on("blur", () => {
            clearTimeout(tthis.recounter);
            tthis.save();
        });
    
    } // SaveWhenStopTyping