<?php

if (!$CastelTecDefineConf) :
    /*
     * SITE CONFIG
     */
    define('SITE_NAME', 'Donna Glam'); //Nome do site do cliente
    define('SITE_SUBNAME', 'Loja'); //Nome do site do cliente
    define('SITE_DESC', 'Agora você não precisa sair de casa para fazer seu rancho!'); //Descrição do site do cliente

    define('SITE_FONT_NAME', 'Open Sans'); //Tipografia do site (https://www.google.com/fonts)
    define('SITE_FONT_WHIGHT', '300,400,600,700,800'); //Tipografia do site (https://www.google.com/fonts)

    /*
     * SHIP CONFIG
     * DADOS DO SEU CLIENTE/DONO DO SITE
     */
    define('SITE_ADDR_NAME', 'DONNA GLAM'); //Nome de remetente
    define('SITE_ADDR_RS', 'DONNA GLAM'); //Razão Social
    define('SITE_ADDR_EMAIL', 'mduarth@hotmail.com'); //E-mail de contato
    define('SITE_ADDR_SITE', 'http://donnaglam.com.br'); //URL descrita
    define('SITE_ADDR_CNPJ', '17.731.923/0001-16'); //CNPJ da empresa
    define('SITE_ADDR_IE', '054235545'); //Inscrição estadual da empresa
    define('SITE_ADDR_PHONE_A', '(92) 99321-3757'); //Telefone 1
    define('SITE_ADDR_PHONE_B', ''); //Telefone 2
    define('SITE_ADDR_ADDR', 'Av. Dom Pedro'); //ENDEREÇO: rua, número (complemento)
    define('SITE_ADDR_CITY', 'Manaus'); //ENDEREÇO: cidade
    define('SITE_ADDR_DISTRICT', 'Dom Pedro'); //ENDEREÇO: bairro
    define('SITE_ADDR_UF', 'AM'); //ENDEREÇO: UF do estado
    define('SITE_ADDR_ZIP', '69040-170'); //ENDEREÇO: CEP
    define('SITE_ADDR_COUNTRY', 'Brasil'); //ENDEREÇO: País

    /*
     * SOCIAL CONFIG
     * Google
     */
    define('SITE_SOCIAL_GOOGLE', true);
    define('SITE_SOCIAL_GOOGLE_AUTHOR', ''); //https://plus.google.com/????? (**ID DO USUÁRIO)
    define('SITE_SOCIAL_GOOGLE_PAGE', 'donnaglamm'); //https://plus.google.com/???? (**ID DA PÁGINA)

    /*
     * Facebook
     */
    define('SITE_SOCIAL_FB', true);
    define('SITE_SOCIAL_FB_APP', ''); //Opcional APP do facebook
    define('SITE_SOCIAL_FB_AUTHOR', ''); //https://www.facebook.com/?????
    define('SITE_SOCIAL_FB_PAGE', 'https://www.facebook.com/donnaglamm'); //https://www.facebook.com/?????

    /*
     * Twitter
     */
    define('SITE_SOCIAL_TWITTER', ''); //https://www.twitter.com/?????

    /*
     * YouTube Channel
     */
    define('SITE_SOCIAL_YOUTUBE', ''); //https://www.youtube.com/user/?????
endif;
