let id = '<?= $_SESSION['session_id'] ?>';


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

var conn = new WebSocket("ws://<?= $ini['SOCKET']['HOST'] ?>:<?= $ini['SOCKET']['PORT'] ?>");
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
		}
	}

};

$('textarea').keypress(function(e){
	console.log(e.keyCode);

	if(e.keyCode == 13){
		let id_cli = $(this).attr('data-inputid');
		let word = $(this).val();
		$(this).val('');
		let obj = JSON.stringify({ id : id, id_cli : id_cli, message : word });
		conn.send(obj);
	}
})

function sendMessage(body) {
	let id_cli = body.dataset.buttonid;
	let word = $(`textarea[data-inputid=${id_cli}]`).val();
	console.log(word);
	$(`textarea[data-inputid=${id_cli}]`).val('');
	let obj = JSON.stringify({ id : id, id_cli : id_cli, message : word });
	conn.send(obj);
}