<link href="<?= stack("assets/my_css/load.css") ?>" rel="stylesheet" type="text/css">
<div class="preloader">
    <div class="preloader__image"></div>
</div>
<script type="text/javascript">
    window.onload = function () {
        const $body = document.body;
        const $preloader = $body.querySelector('.preloader');
        function afterTransition() {
            $body.classList.add('loaded');
            $body.classList.remove('loaded_hiding');
            $preloader.removeEventListener('transitionend', afterTransition);
        }
        $body.classList.add('loaded_hiding');
        $preloader.addEventListener('transitionend', afterTransition);
    }
</script>