function checkTime(i) {
    if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

function displayTime(){
    var dateTime = new Date();
    var hrs = dateTime.getHours();
    var min = dateTime.getMinutes();
    var sec = dateTime.getSeconds();
    var session = document.getElementById('session');
    var chkhrs = checkTime(hrs);
    var chkmin = checkTime(min);
    var chksec = checkTime(sec);


    if(hrs >= 12){
        session.innerHTML = 'PM';
    }else{
        session.innerHTML = 'AM';
    }

    if(hrs > 12){
        hrs = hrs - 12;
    }

    document.getElementById('hours').innerHTML = chkhrs;
    document.getElementById('minutes').innerHTML = chkmin;
    document.getElementById('seconds').innerHTML = chksec;
}
setInterval(displayTime, 10);