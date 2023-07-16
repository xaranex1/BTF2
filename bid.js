// bid.js

document.addEventListener('DOMContentLoaded', function() {
    var countdown = 10;
    var countdownInterval = setInterval(function() {
        document.getElementById('countdown').innerHTML = countdown;
        countdown--;
        if (countdown < 0) {
            clearInterval(countdownInterval);
            location.reload(); // Reload the page after 10 seconds
        }
    }, 1000);
});
