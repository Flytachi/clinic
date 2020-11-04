/* Beta 1.0.0 */
let intevalId;

let time = document.getElementById('timeSession');

let second1, hour1, minute1 ;

if(getCookie('second1') == undefined){
    second1 = 0;
    setCookie('second1', 0);
}else{
    second1 = Number(getCookie('second1'));
}

if(getCookie('minute1') == undefined){
    minute1 = 0;
    setCookie('minute1', 0);
}else{
    minute1 = Number(getCookie('minute1'));
}

if(getCookie('hour1') == undefined){
    hour1 = 0;
    setCookie('hour1', 0);
}else{
    hour1 = Number(getCookie('hour1'));
}

let sessionButton = document.getElementById('sessionButton');

function inTime(time){

    if(time < 10){
        return (`0`+time)
    }else{
        return time
    }

}

function setTime() {

    setCookie('sessionTime', true);

    sessionButton.innerHTML = `<button class="btn bg-danger legitRipple" onclick="stopTime()" type="button">Остановить сессию</button>`

    let now, hour, minute, second;

    $('.card-sidebar-mobile').css({'pointer-events':'all', 'background-color':'rgb(255,255,255)'});
    $('.content-wrapper').css({'pointer-events':'all', 'background-color':'rgb(255,255,255)'});
    $('.card').css({'pointer-events':'all', 'background-color':'rgb(255,255,255)'});

    intevalId = setInterval(function () {

        if (second1 == 60) {
            minute1+=1;
            second1 = 0;
            setCookie('minute1', minute1);
            setCookie('second1', 0);
        }

        if(minute1 == 60){
            hour1 +=1
            minute1 = 0
            setCookie('hour1', hour1);
            setCookie('minute1', 0);
        }

        if(hour1 == 24){
            hour1 = 0
            setCookie('hour1', hour1);
        }

        time.innerHTML = `${inTime(hour1)}:${inTime(minute1)}:${inTime(second1)}`
        second1++;
        setCookie('second1', second1);
    }, 1000)
}

function stopTime() {

    sessionButton.innerHTML = `<button class="btn bg-teal legitRipple" onclick="setTime()" type="button">Продолжить сессию</button>`

    clearInterval(intevalId)

    setCookie('sessionTime', false);

    $('.card-sidebar-mobile').css({'pointer-events':'none', 'background-color':'rgba(0,0,0,0.5)'});
    $('.content-wrapper').css({'pointer-events':'none', 'background-color':'rgba(0,0,0,0.5)'});
    $('.card').css({'pointer-events':'none', 'background-color':'rgba(0,0,0,0.5)'});
}

if(getCookie('sessionTime') == 'true'){

    $('.card-sidebar-mobile').css({'pointer-events':'all', 'background-color':'rgb(255,255,255)'});
    $('.content-wrapper').css({'pointer-events':'all', 'background-color':'rgb(255,255,255)'});
    $('.card').css({'pointer-events':'all', 'background-color':'rgb(255,255,255)'});

    intevalId = setInterval(function () {

        if (second1 == 60) {
            minute1+=1;
            second1 = 0;
            setCookie('minute1', minute1);
            setCookie('second1', 0);
        }

        if(minute1 == 60){
            hour1 +=1
            minute1 = 0
            setCookie('hour1', hour1);
            setCookie('minute1', 0);
        }

        if(hour1 == 24){
            hour1 = 0
            setCookie('hour1', hour1);
        }

        time.innerHTML = `${inTime(hour1)}:${inTime(minute1)}:${inTime(second1)}`
        second1++;
        setCookie('second1', second1);
    }, 1000)

    sessionButton.innerHTML = `<button class="btn bg-danger legitRipple" onclick="stopTime()" type="button">Остановить сессию</button>`
}else if(getCookie('sessionTime') == 'false'){
    $('.card-sidebar-mobile').css({'pointer-events':'none', 'background-color':'rgba(0,0,0,0.5)'});
    $('.content-wrapper').css({'pointer-events':'none', 'background-color':'rgba(0,0,0,0.5)'});
    $('.card').css({'pointer-events':'none', 'background-color':'rgba(0,0,0,0.5)'});

    time.innerHTML = `${inTime(hour1)}:${inTime(minute1)}:${inTime(second1)}`

    sessionButton.innerHTML = `<button class="btn bg-teal legitRipple" onclick="setTime()" type="button">Продолжить сессию</button>`
}