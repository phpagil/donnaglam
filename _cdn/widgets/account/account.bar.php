<style>
    #aumenta2 {
        position: relative
    }

    #aumenta2:hover {
        top: -2px;
        box-shadow: 0 2px 2px #fff
    }
</style>
<?php

if (!empty($URL[0]) && !empty($URL[1]) && $URL[0] == 'conta' && $URL[1] == 'sair') :
    unset($_SESSION['userLogin']);
endif;

if (!empty($_SESSION['userLogin'])) :
    $AccSaudation = (!ACC_TAG ? "Olá {$_SESSION['userLogin']['user_name']}!" : ACC_TAG);
    //echo "<a title='Minha Conta' href='" . BASE . "/conta/home'>{$AccSaudation}</a>";
    echo "<a title='Minha Conta' href='" . BASE . "/conta/home'>{$_SESSION['userLogin']['user_name']}</a>";
else :
    //    echo "<a title='Minha Conta' href='" . BASE . "/conta/login'>Entrar</a>";

    echo "<a title='Fazer Login' href='" . BASE . "/conta/login'>";
    echo '<img id="aumenta2" style="height: 33px;" src="' . BASE . '/themes/' . THEME . '/images/face.png" />';
    echo '</a>';
endif;
