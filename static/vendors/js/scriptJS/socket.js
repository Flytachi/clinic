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

var ExportExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) {
        return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; })
    }
    , downloadURI = function(uri, name) {
        var link = document.createElement("a");
        link.download = name;
        link.href = uri;
        link.click();
    }

    return function(table, name, fileName) {
        if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
        var resuri = uri + base64(format(template, ctx))
        downloadURI(resuri, fileName);
    }
})();

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

conn.onerror = function(error) {
    new Noty({
        text: 'Сокет сервер не включён!',
        type: 'error'
    }).show();
    conn.close();
};

conn.onclose = function(error) {
    new Noty({
        text: 'Сокет сервер был  выключен!',
        type: 'error'
    }).show();
    conn.close();
};

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

        switch (d.type_message) {
          case "text":
            $(`ul[data-chatid=${d.id_cli}]`).append(`
              <li class="media media-chat-item-reverse">
                <div class="media-body">
                  <div class="media-chat-item">${d.message}</div>
                  <div class="font-size-sm text-muted mt-2">
                    ${ hour } : ${ mitune }
                    <a href="#">
                      <i class="icon-pin-alt ml-2 text-muted"></i>
                    </a>
                  </div>
                </div>

                <div class="ml-3">
                  <a href="#">
                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
                  </a>
                </div>
              </li>
              `)
            break;
          case "file":
            $(`ul[data-chatid=${d.id_cli}]`).append(`
              <li class="media media-chat-item-reverse">
                <div class="media-body">
                  <div class="media-chat-item">
                    <a style="color: white;" href="${d.message}" download>Скачать файл</a>
                  </div>
                  <div class="font-size-sm text-muted mt-2">
                    ${ hour } : ${ mitune }
                    <a href="#">
                      <i class="icon-pin-alt ml-2 text-muted"></i>
                    </a>
                  </div>
                </div>

                <div class="ml-3">
                  <a href="#">
                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
                  </a>
                </div>
              </li>
              `)
            break;
          case "image":
            $(`ul[data-chatid=${d.id_cli}]`).append(`
               <li class="media media-chat-item-reverse">
                <div class="media-body">
                  <div class="media-chat-item">
                    <img src="${d.message}" width="200">
                  </div>
                  <div class="font-size-sm text-muted mt-2">
                    ${ hour } : ${ mitune }
                    <a href="#">
                      <i class="icon-pin-alt ml-2 text-muted"></i>
                    </a>
                  </div>
                </div>

                <div class="ml-3">
                  <a href="#">
                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
                  </a>
                </div>
              </li>
              `)
            break;
          default:
            console.log("Sorry, we are out of.");
            break
        }



  		     $(`ul[data-chatid=${d.id_cli}]`).scrollTop($(`ul[data-chatid=${d.id_cli}]`).prop('scrollHeight'));
  		}else{

  			let active = $('a.show').attr('data-idChat');

  			if(active == d.id){

  				$.ajax({
  			        type: "POST",

  			        url: "http://localhost/clinic/static/vendors/js/scriptJS/ajax.php",

  			        data: { id: id, id1: d.id },

  			        success: function (www) {
  			        	console.log(www);
  			        },
  			    });


  			}else{

          $('#audio').trigger('play');

  				let p = Number($(`span[data-idchat=${d.id}]`).text()) + 1;

  				let b = Number($(`span#noticeus`).text()) + 1;

  				$(`span#noticeus`).html('');

  				$(`span#noticeus`).html(b);

  				$(`span[data-idChat=${d.id}]`).text(p)

  			}

        switch (d.type_message) {
          case "text":
            $(`ul[data-chatid=${d.id}]`).append(`
              <li class="media">
                <div class="mr-3">
                  <a href="#">
                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
                  </a>
                </div>
                <div class="media-body">
                  <div class="media-chat-item">${d.message}</div>
                  <div class="font-size-sm text-muted mt-2">
                    ${ hour } : ${ mitune }
                    <a href="#">
                      <i class="icon-pin-alt ml-2 text-muted"></i>
                    </a>
                  </div>
                </div>
              </li>
              `)
            break;
          case "file":
            $(`ul[data-chatid=${d.id}]`).append(`
              <li class="media">
                <div class="mr-3">
                  <a href="#">
                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
                  </a>
                </div>

                <div class="media-body">
                  <div class="media-chat-item">
                    <a style="color: #333333;" href="${d.message}" download>Скачать файл</a>
                  </div>
                  <div class="font-size-sm text-muted mt-2">
                    ${ hour } : ${ mitune }
                      <a href="#">
                        <i class="icon-pin-alt ml-2 text-muted"></i>
                      </a>
                  </div>
                </div>
              </li>
              `)
            break;
          case "image":
            $(`ul[data-chatid=${d.id}]`).append(`
              <li class="media">
                <div class="mr-3">
                  <a href="#">
                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
                  </a>
                </div>
                <div class="media-body">
                  <div class="media-chat-item">
                    <img src="${d.message}" width="200">
                  </div>
                  <div class="font-size-sm text-muted mt-2">
                    ${ hour } : ${ mitune }
                    <a href="#">
                      <i class="icon-pin-alt ml-2 text-muted"></i>
                    </a>
                  </div>
                </div>
              </li>
              `)
            break;
          default:
            console.log("Sorry, we are out of.");
            break
        }

         $(`ul[data-chatid=${d.id}]`).scrollTop($(`ul[data-chatid=${d.id}]`).prop('scrollHeight'));
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
  }else if (d.type == "alert_pharmacy_call"){
    if(d.id == id){
        swal({
            position: 'top',
            title: 'Внимание! Вызов с аптеки!',
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
              <tr data-userid="${ d.user[0].user_id }" data-parentid="${ d.user[0].parent_id }" data-status="accept_patient" style="text-transform: uppercase; font-weight: 900; font-weight: 900; font-size: 250%; background-color: #97E32F;">
                <td style="text-align: center;">${ d.user[0].user_id }</td>
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

            $('#wew').html(`Новый пациент ${d.queue[0].last_name} - ${d.queue[0].first_name}`)

            footer.marquee('resume');

            // Проигрывается аудио уведомления
            $('#audio').trigger('play');

            console.log('---------------------------------------------------------------')

            // Удаляется и добавляется заново подсвеченным зеленым

            console.log(d);

            $(`#${ d.queue[0].parent_id }`).append(`<tr data-userid="${ d.queue[0].user_id }" style="text-transform: uppercase; font-weight: 900; font-size: 250%;" data-parentid="${ d.queue[0].parent_id }">
                          <td style="text-align: center;">${ d.queue[0].user_id }</td>
                          </tr>`);
            },
        });

      }
  }else if (d.type == "delet_patient" ) {

      // События для монитора, принятие к доктору
      if(d.id == id){

        $.ajax({
          type: "POST",

          url: "visitpd.php",

          data: { id_user: d.user_id, id_patient: d.parent_id },

          success: function (data) {

            let d = JSON.parse(data);

            // Удаляется пациент
            $(`tr[data-userid=${ d.user[0].user_id }][data-parentid=${ d.user[0].parent_id }]`).remove();
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
	let obj = JSON.stringify({ type : 'messages', type_message : 'text', id : id, id_cli : id_cli, message : word });
	conn.send(obj);
}

function deletNotice(body) {
	let id1 = $(body).attr('data-idChat');
	let count;

	 $.ajax({
        type: "POST",

        url: "http://localhost/clinic/static/vendors/js/scriptJS/ajax.php",

        data: { id: id, id1: id1 },

        success: function (www) {
        	console.log(www);
        },
    });

	try{
		console.log('--------------------------------');
		console.log($(`span[data-idChat=${id1}]`).text());
		console.log($(`b#noticeus`).text());

		count = Number($(`span#noticeus`).text()) - Number($(`span[data-idchat=${id1}]`).text());
		if (count != 0) {
			$(`span#noticeus`).html(count);
		}else{
			$(`span#noticeus`).html(``);
		}
		$(`span[data-idchat=${id1}]`).html('');
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

function deletPatient(body) {
  parentid = body.dataset.parentid;
  userid = body.dataset.userid;
  let obj = JSON.stringify({ type : 'delet_patient', id : "1983", user_id : userid, parent_id : parentid});
  conn.send(obj);
  console.log( obj);
}
