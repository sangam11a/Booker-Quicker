var timeout ;
function refreshing(i) {
document.getElementById('sec').innerHTML=i;
timeout = setTimeout(refreshing, 1000,i-1);
if(i==0) {
    clearTimeout(timeout);
    location.href=location.href;
 }
}