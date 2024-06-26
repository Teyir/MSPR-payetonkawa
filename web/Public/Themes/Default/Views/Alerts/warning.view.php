<?php
/** @var Alert $alert */

use WEB\Manager\Env\EnvManager;
use WEB\Manager\Flash\Alert;

?>
<link rel="stylesheet" href="<?= EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . 'Admin/Resources/Vendors/Izitoast/iziToast.min.css' ?>">
<script src="<?= EnvManager::getInstance()->getValue('PATH_SUBFOLDER') . 'Admin/Resources/Vendors/Izitoast/iziToast.min.js' ?>"></script>
<script>
    iziToast.show(
        {
            titleSize: '16',
            messageSize: '14',
            icon: 'fa-solid fa-warning',
            title  : "<?= $alert->getTitle() ?>",
            message: "<?= $alert->getMessage() ?>",
            color: "#faaa38",
            iconColor: '#ffffff',
            titleColor: '#ffffff',
            messageColor: '#fff',
            balloon: false,
            close: true,
            pauseOnHover: true,
            position: 'bottomRight',
            timeout: 4000,
            animateInside: false,
            progressBar: true,
            transitionIn: 'fadeInDown',
            transitionOut: 'fadeOut',
        });

</script>