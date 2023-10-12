


function initArray() {
    this.length = initArray.arguments.length;
    for (var i = 0; i < this.length; i++) {
        this[i] = initArray.arguments[i];
    }
}

var ctext = "LeGrandBazar";
var x = 0;
var color = new initArray(
    "red",
    "blue",
    "green",
    "black"
);

{
    document.write('<span class="navbar-brand fs-1">' + ctext + '</span>');
}
function chcolor() {
    {
        document.c.style.color = color[x];
    }
    (x < color.length - 1) ? x++ : x = 0;
}
setInterval("chcolor()", 1000);

