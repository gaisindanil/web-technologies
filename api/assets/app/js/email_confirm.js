const $ = require("jquery")

// move next
function moveToNext(elem, count){
    if(elem.value.length > 0) {
        $("#form_d"+count).focus();
    }
}

window.moveToNext = moveToNext
