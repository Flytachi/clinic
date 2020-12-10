

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
        alert('Новый пациeнт');
        Noty({text: 'Успешно!',type: 'success'}).show();
    }
  }else if (d.type == "call_nurce_to_doc"){
    if(d.id == id){
        alert('Вас вызывают');
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
