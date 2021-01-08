function Print(events) {
    var WinPrint = window.open(``,'ABC','left=50,top=50,width=800,height=640,toolbar=0,scrollbars=1,status=0');
    $.ajax({
        type: "GET",
        url: events,
        success: function (data) {
            WinPrint.document.write(data);
            WinPrint.document.close();
            WinPrint.focus();
            window.stop();
            $(WinPrint).on('load', function () {
                WinPrint.print();
                WinPrint.close();
            });
        },
    });
};

function PrintCheck(events) {
    var WinPrint = window.open(``,'','left=50,top=50,width=300,height=400,toolbar=0,scrollbars=1,status=0');
    $.ajax({
        type: "GET",
        url: events,
        success: function (data) {
            WinPrint.document.write(data);
            WinPrint.document.close();
            WinPrint.focus();
            window.stop();
            $(WinPrint).on('load', function () {
                WinPrint.print();
                WinPrint.close();
                $('#btn_submit').click();
            });
        },
    });
};

function addZero(number){

    let strNumber = String(number);
    let newNumber = "";

    if(strNumber.length < 2){

        let countZero = 2 - strNumber.length;

        for ($i=0; $i < countZero; $i++) {

            newNumber += "0";
        }
        newNumber += strNumber;
        return newNumber;
    }

    return strNumber;
}

conn.onopen = function(e) {
    console.log("Connection success!");
};

conn.onmessage = function(e) {


	let d = JSON.parse(e.data)

  console.log(d);
	let time = new Date();

	let hour = addZero(time.getHours());

	let mitune = addZero(time.getMinutes());

  if(d.type == "messages"){

    if(d.id == id || d.id_cli == id ){

  		if(d.id == id){
  			$(`ul[data-chatid=${d.id_cli}]`).append(`<li class="media media-chat-item-reverse">
  											<div class="media-body">
  												<div class="media-chat-item">${d.message}</div>
  												<div class="font-size-sm text-muted mt-2">
  													${ hour } : ${ mitune } <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
  												</div>
  											</div>

  											<div class="ml-3">
  												<a href="#">
  													<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
  												</a>
  											</div>
  										</li>`)
  		     $(`ul[data-chatid=${d.id_cli}]`).scrollTop($(`ul[data-chatid=${d.id_cli}]`).prop('scrollHeight'));
  		}else{

  			let active = $('a.show').attr('data-idChat');

  			if(active == d.id){

  				$.ajax({
  			        type: "POST",

  			        url: "scriptJS/ajax.php",

  			        data: { id: id, id1: d.id },

  			        success: function (www) {
  			        	console.log(www);
  			        },
  			    });

  			    $(`ul[data-chatid=${d.id}]`).append(`<li class="media">
  													<div class="mr-3">
  														<a href="#">
  															<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
  														</a>
  													</div>

  													<div class="media-body">
  														<div class="media-chat-item"> ${d.message} </div>
  														<div class="font-size-sm text-muted mt-2">
  															${ hour } : ${ mitune } <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
  														</div>
  													</div>
  												</li>`);

  			     $(`ul[data-chatid=${d.id}]`).scrollTop($(`ul[data-chatid=${d.id}]`).prop('scrollHeight'));
  			}else{

  				$(`ul[data-chatid=${d.id}]`).append(`<li class="media">
  													<div class="mr-3">
  														<a href="#">
  															<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
  														</a>
  													</div>

  													<div class="media-body">
  														<div class="media-chat-item"> ${d.message} </div>
  														<div class="font-size-sm text-muted mt-2">
  															${ hour } : ${ mitune } <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
  														</div>
  													</div>
  												</li>`);

  				let p = Number($(`span[data-idChat=${d.id}]`).text()) + 1;

  				let b = Number($(`b#noticeus`).text()) + 1;

  				console.log(`vvvvvvvvvvvvvvvvvvvv ${ $(`b#noticeus`).html() }`)

  				$(`b#noticeus`).html('');

  				$(`b#noticeus`).html(`<span class="badge bg-danger badge-pill ml-auto">${b}</span>`);

  				$(`span[data-idChat=${d.id}]`).text(p)

  				console.log(p);
  			}
  		}
  	}

  }else if (d.type == "alert_new_patient"){
    if(d.id == id){
        new Noty({
            text: d.message,
            type: 'info'
        }).show();
    }
  }else if (d.type == "call_nurce_to_doc"){
    if(d.id == id){
        swal({
            position: 'top',
            title: 'Внимание! Срочный вызов!',
            type: 'warning',
            html: d.message
        });
    }
  }else if (d.type == "accept_patient" ) {

      // События для монитора, принятие к доктору
      if(d.id == id){


        $.ajax({
          type: "POST",

          url: "visitpd.php",

          data: { id_user: d.user_id, id_patient: d.parent_id },

          success: function (data) {

            let d = JSON.parse(data);

            // Проигрывается аудио уведомления  
            $('#audio').trigger('play');

            // Удаляется и добавляется заново подсвеченным зеленым
            $(`tr[data-userid=${ d.user[0].user_id }][data-parentid=${ d.user[0].parent_id }]`).remove();
            $(`tr[data-parentid=${ d.user[0].parent_id }][data-status=accept_patient]`).remove();
            $(`#${ d.user[0].parent_id }`).prepend(`
              <tr data-userid="${ d.user[0].user_id }" data-parentid="${ d.user[0].parent_id }" data-status="accept_patient" style="font-weight: 900; font-size: 140%; background-color: #97E32F;">
                <td>${ d.user[0].user_id }</td>
                <td>${ d.user[0].first_name } - ${ d.user[0].last_name }</td>
              </tr>`)
            },
        });
      }
  }else if (d.type == "new_patient" ) {

      // События для монитора, добавление нового пациента
      if(d.id == id){
        $.ajax({
          type: "POST",

          url: "get_user.php",

          data: { id_user: d.user_id, id_patient: d.parent_id },

          success: function (data) {

            let d = JSON.parse(data);

            console.log('ew')

            // Проигрывается аудио уведомления  
            $('#audio').trigger('play');

            // Удаляется и добавляется заново подсвеченным зеленым
            $(`#${ d.queue[0].parent_id }`).append(`<tr data-userid="${ d.queue[0].user_id }" style="font-weight: 900; font-size: 140%;" data-parentid="${ d.queue[0].parent_id }">
                          <td>${ d.queue[0].user_id }</td>
                          <td>${ d.queue[0].last_name } - ${ d.queue[0].first_name }</td>
                          </tr>`);
            },
        });

      }
  }
};

function sendMessage(body) {
	let id_cli = body.dataset.buttonid;
	let word = $(`textarea[data-inputid=${id_cli}]`).val();
	console.log(word);
	$(`textarea[data-inputid=${id_cli}]`).val('');
	let obj = JSON.stringify({ type : 'messages', id : id, id_cli : id_cli, message : word });
	conn.send(obj);
}

function deletNotice(body) {
	let id1 = $(body).attr('data-idChat');
	let count;

	 $.ajax({
        type: "POST",

        url: "scriptJS/ajax.php",

        data: { id: id, id1: id1 },

        success: function (www) {
        	console.log(www);
        },
    });

	try{
		console.log('--------------------------------');
		console.log($(`span[data-idChat=${id1}]`).text());
		console.log($(`b#noticeus`).text());

		count = Number($(`b#noticeus`).text()) - Number($(`span[data-idChat=${id1}]`).text());
		if (count != 0) {
			$(`b#noticeus`).html(`<span class="badge bg-danger badge-pill ml-auto">${count}</span>`);
		}else{
			$(`b#noticeus`).html(``);
		}
		$(`span[data-idChat=${id1}]`).html('');
	}catch{
		console.log('error')
	}
}

function sendPatient(body) {
  parentid = body.dataset.parentid;
  userid = body.dataset.userid;
  let obj = JSON.stringify({ type : 'accept_patient', id : "1983", user_id : userid, parent_id : parentid});
  conn.send(obj);
}
