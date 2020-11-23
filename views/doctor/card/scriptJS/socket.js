
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
    console.log("Connection established!");
};

conn.onmessage = function(e) {
	let d = JSON.parse(e.data)

	let time = new Date();

	let hour = addZero(time.getHours());

	let mitune = addZero(time.getMinutes());

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
		}else{

			let active = $('a.show').attr('data-idChat');


			if(active == d.id){
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
												</li>`)
			}else{
				let p = Number($(`p[data-idChat=${d.id}]`).text()) + 1;

				let b = Number($(`b#noticeus`).text()) + 1;

				console.log(`vvvvvvvvvvvvvvvvvvvv ${ $(`b#noticeus`).html() }`)

				$(`b#noticeus`).html('');

				$(`b#noticeus`).html(`<span class="badge bg-danger badge-pill ml-auto">${b}</span>`);

				$(`p[data-idChat=${d.id}]`).text(p)						

				console.log(p);
			}
		}
	}

};

function sendMessage(body) {
	let id_cli = body.dataset.buttonid;
	let word = $(`textarea[data-inputid=${id_cli}]`).val();
	console.log(word);
	$(`textarea[data-inputid=${id_cli}]`).val('');
	let obj = JSON.stringify({ id : id, id_cli : id_cli, message : word });
	conn.send(obj);
}

function deletNotice(body) {
	let id1 = $(body).attr('data-idChat');
	let count;

	try{
		console.log('--------------------------------')
		count = (Number($(`b#noticeus`).text()) - Number($(`p[data-idChat=${id1}]`).html())) != 0 ? $(`b#noticeus`).html(`<span class="badge bg-danger badge-pill ml-auto">${count}</span>`) : $(`b#noticeus`).html(``);
		$(`p[data-idChat=${id1}]`).html('');
	}catch{
		console.log('error')
	}
}