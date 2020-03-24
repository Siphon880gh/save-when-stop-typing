/**
 * @@class TriggerWhenStopTyping
 * Once initialized, the text input or textarea will detect when you stop typing for a reasonable amount of time, then calls your functions.
 * For example, the user stops typing in the text input or textarea for 2 seconds, then it saves and plays an animation "Saved".
 * 
 *
 * @param {jQuery Queried DOM} $textarea
 * 
 * @return {void}
 *
 * @examples
 *
 *     let detector = TriggerWhenStopTyping($("#log));
 * 
 *     let detector = TriggerWhenStopTyping($("#log), ()=>{ alert("You stopped typing"); });
 * 
 *     let detector = TriggerWhenStopTyping($("#log), save);
 * 
 */
function TriggerWhenStopTyping($textarea, callback) { 
    /* Customizable */
    this.poll = 1200; // ms
    
    /* Engine */
    this.$textarea = $textarea; 
    this.callback = callback;
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
        console.log(`Hadn't reset timer because no typing detected for ${tthis.poll}ms. This timer eventually triggers functions such as save.`);
        tthis.callback(); 
        }, tthis.poll);
    } // resetRecounter
    
    // On input
    this.$textarea
        .on("input", () => {
            tthis.resetRecounter();
            console.log("Resetted timer because user typed. This timer eventually triggers functions such as save.");
        }) // keydown
        .on("blur", () => {
            clearTimeout(tthis.recounter);
            console.log("Triggered because user stopped typing");
            tthis.callback();
        });
    
    } // TriggerWhenStopTyping