<?php
$CartAction = trim(strip_tags($URL[1]));
$CartBaseUI = BASE . '/conta';
?>

<div class="page_title_ctn">
    <div class="container-fluid">
        <h2>Fechar Pedido</h2>

        <ol class="breadcrumb">
            <li><a href="<?= BASE ?>">Inicio</a></li>
            <li class="active"><span>Carrinho</span></li>
        </ol>

    </div>
</div>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <?php
                echo '<article class="workcontrol_cart" id="cart">';

                //CHECK CART - SE O CARRINHO ESTIVER VAZIO EXIBE A MENSAGEM ABAIXO
                if (
                    empty($_SESSION['wc_order']) &&
                    $CartAction != 'pagamento' &&
                    $CartAction != 'obrigado'
                ):
                    echo '<h2>' . ECOMMERCE_TAG . '</h2>';

                    echo "<div class='workcontrol_cart_clean'>";
                    echo "<p class='title'><span>";
                    echo '<img title="Carrinho vazio" style="height:90px;" src="' .
                        BASE .
                        '/themes/' .
                        THEME .
                        '/images/sapinho.png"/>';
                    echo '</span>Nenhum produto foi selecionado.</p>';
                    echo '<p>Para continuar comprando, navegue pelas categorias do site ou faça uma busca pelo seu produto.</p>';
                    echo "<a class='btn btn_green' title='Escolher Produtos' href='" .
                        BASE .
                        "'>ESCOLHER PRODUTOS</a>";
                    echo '</div>';
                    //CART CLEAR

                    //CART FRONT-CONTROLER

                    //CART HOME
                    // DELETAR DEPOIS: // echo "<div class='workcontrol_cart_list_header'><p class='item cart-product-thumbnail'>-</p><p class='item cart-product-name'>Produto</p><p class='cart-product-price'>Preço</p><p class='cart-product-quantity'>Quantidade</p><p class='cart-product-subtotal'>Total</p><p class='cart-product-remove'>-</p></div>";
                    // echo "<div class='workcontrol_cart_list_item workcontrol_cart_list_item_{$pdt_id}'>";
                    //     echo "<p><img title='{$pdt_title}' alt='{$pdt_title}' src='" . BASE . "/tim.php?src=uploads/{$pdt_cover}&w=" . THUMB_W / 5 . "&h=" . THUMB_H / 5 . "'/></p>";
                    //     echo "<p class='item'><a href='" . BASE . "/produto/{$pdt_name}' title='Ver detalhes de {$pdt_title}'>{$pdt_title}</a></p>";
                    //     echo "<p>" . ($pdt_price != $ItemPrice ? "<span class='discount'>De R$ <strike>" . number_format($pdt_price, '2', ',', '.') . "</strike></span>Por " : '') . "R$ " . number_format($ItemPrice, '2', ',', '.') . "</p>";
                    //     echo "<p><button id='{$pdt_id}' class='change wc_cart_change_less'>-</button><input id='{$pdt_id}' class='wc_cart_change' type='text' value='{$ItemAmount}' max='{$pdt_inventory}'><button id='{$pdt_id}' class='change wc_cart_change_plus'>+</button><span class='stock'>" . ($pdt_inventory ? str_pad($pdt_inventory, 3, 0, STR_PAD_LEFT) : "+100") . " em estoque!</span></p>";
                    //     echo "<p class='wc_item_price_{$pdt_id}'>R$ " . number_format($ItemAmount * $ItemPrice, '2', ',', '.') . "</p>";
                    //     echo "<p><span class='wc_cart_remove' id='{$pdt_id}'>X</span></p>";
                    // echo "</div>";

                    // <tr class="cart_item">

                    // <td class="cart-product-thumbnail">
                    //     <a href="#"><img width="64" height="64" src="images\product\product-1.jpg" alt="Pink Printed Dress"></a>
                    // </td>

                    // <td class="cart-product-name">
                    //     <a href="#">Pink Printed Dress</a>
                    // </td>

                    // <td class="cart-product-price">
                    //     <span class="amount">R$19.99</span>
                    // </td>

                    // <td class="quantity">
                    //     <div class="quantity buttons-add-minus">
                    //         <input type="text" name="cart" value="1" title="Qty" class="input-text qty text">
                    //         <input type="button" value="-" class="minus">
                    //         <input type="button" value="+" class="plus">
                    //     </div>
                    // </td>

                    // <td class="cart-product-subtotal">
                    //     <span class="amount">R$ 39.98</span>
                    // </td>

                    // <td class="cart-product-remove">
                    //     <a href="#" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                    // </td>

                    // </tr>
                    //CART LOGIN
                    //CART ADDR
                    //CART CLEAR

                    //CART PAY
                    //CART PAY
                    // echo "<div class='wc_cart_total_shipment'>";
                    // echo "<p>Frete:</p><input type='text' value='" .
                    //     (!empty($_SESSION['wc_shipment_zip'])
                    //         ? $_SESSION['wc_shipment_zip']
                    //         : '') .
                    //     "' class='formCep wc_cart_ship_val'/><button class='wc_cart_ship'>Calcular</button><img alt='Calculando Frete!' title='Calculando Frete!' src='" .
                    //     BASE .
                    //     "/_cdn/widgets/ecommerce/load_g.gif'/>";
                    // echo "<div class='wc_cart_total_shipment_result'></div>";
                    // echo '</div>';
                else:
                    if ($CartAction == 'clear'):
                        unset($_SESSION['wc_order']);
                        header('Location: ' . BASE . '/pedido/home');
                    endif;

                    if ($CartAction == 'home'):

                        echo '<h2>' . ECOMMERCE_TAG . '</h2>';

                        echo "<div class='workcontrol_cart_list table-responsive'>";
                        echo '<table class="table cart">';

                        echo '<thead>';
                        echo '<tr>';
                        echo '<th class="cart-product-remove">&nbsp;</th>';
                        echo '<th class="cart-product-thumbnail">PRODUTO</th>';
                        echo '<th class="cart-product-name">DESCRIÇÃO</th>';
                        echo '<th class="cart-product-price">PREÇO UNITÁRIO</th>';
                        echo '<th class="cart-product-quantity">QUANTIDADE</th>';
                        echo '<th class="cart-product-subtotal">TOTAL</th>';
                        echo '</tr>';
                        echo '</thead>';

                        echo '<tbody>';

                        $thumb_width = THUMB_W / 8;
                        $thumb_height = THUMB_H / 15;
                        $CartTotal = 0;
                        foreach (
                            $_SESSION['wc_order']
                            as $ItemId => $ItemAmount
                        ):
                            $Read->ExeRead(
                                DB_PDT,
                                'WHERE pdt_status = 1 AND (pdt_inventory IS NULL OR pdt_inventory >= 1) AND pdt_id = :id',
                                "id={$ItemId}"
                            );
                            if ($Read->getResult()):
                                extract($Read->getResult()[0]);
                                $ItemPrice =
                                    $pdt_offer_price &&
                                    $pdt_offer_start <= date('Y-m-d H:i:s') &&
                                    $pdt_offer_end >= date('Y-m-d H:i:s')
                                        ? $pdt_offer_price
                                        : $pdt_price;
                                $CartTotal += $ItemPrice * $ItemAmount;
                                echo "<tr class='cart_item workcontrol_cart_list_item workcontrol_cart_list_item_{$pdt_id}'>";
                                echo "<td><span class='cart-product-remove wc_cart_remove' id='{$pdt_id}'>X</span></td>";
                                echo "<td class='cart-product-thumbnail'><img title='{$pdt_title}' alt='{$pdt_title}' width='{$thumb_width}' height='{$thumb_height}' src='https://donnaglam.com.br/saf/uploads/{$pdt_cover}'/></td>";
                                echo "<td class='cart-product-name item'><a href='" .
                                    BASE .
                                    "/produto/{$pdt_name}' title='Ver detalhes de {$pdt_title}'>{$pdt_title}</a></td>";
                                echo "<td class='cart-product-price'>" .
                                    ($pdt_price != $ItemPrice
                                        ? "<span class='discount'>De R$ <strike>" .
                                            number_format(
                                                $pdt_price,
                                                '2',
                                                ',',
                                                '.'
                                            ) .
                                            '</strike></span>Por '
                                        : '') .
                                    'R$ ' .
                                    number_format($ItemPrice, '2', ',', '.') .
                                    '</td>';
                                echo "<td class='quantity'><button id='{$pdt_id}' class='change wc_cart_change_less'>-</button><input id='{$pdt_id}' class='wc_cart_change' type='text' value='{$ItemAmount}' max='{$pdt_inventory}'><button id='{$pdt_id}' class='change wc_cart_change_plus'>+</button><span class='stock'>" .
                                    ($pdt_inventory
                                        ? str_pad(
                                            $pdt_inventory,
                                            3,
                                            0,
                                            STR_PAD_LEFT
                                        )
                                        : '+100') .
                                    ' em estoque!</span></td>';
                                echo "<td class='cart-product-subtotal wc_item_price_{$pdt_id}'>R$ " .
                                    number_format(
                                        $ItemAmount * $ItemPrice,
                                        '2',
                                        ',',
                                        '.'
                                    ) .
                                    '</td>';
                                echo '</tr>';
                            else:
                                unset($_SESSION['wc_order'][$ItemId]);
                            endif;
                        endforeach;

                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';

                        $CartCupom = !empty($_SESSION['wc_cupom'])
                            ? intval($_SESSION['wc_cupom'])
                            : 0;
                        $CartPrice = empty($_SESSION['wc_cupom'])
                            ? $CartTotal
                            : $CartTotal *
                                ((100 - $_SESSION['wc_cupom']) / 100);

                        echo "<div class='wc_cart_total_forms'>";
                        echo "<div class='wc_cart_total_cupom'>";
                        echo "<p class='ex1'>Cupom:</p><input  type='text' value='" .
                            (!empty($_SESSION['wc_cupom_code'])
                                ? $_SESSION['wc_cupom_code']
                                : '') .
                            "' class='wc_cart_cupom_val'/><button class='wc_cart_cupom'>Aplicar</button><img alt='Calculando Desconto!' title='Calculando Desconto!' src='" .
                            BASE .
                            "/_cdn/widgets/ecommerce/load_g.gif'/>";
                        echo '</div>';
                        echo '</div>';
                        echo "<div class='wc_cart_total_price'>";
                        echo "<p class='wc_cart_total'><b>Sub-total:</b> R$ <span>" .
                            number_format($CartTotal, '2', ',', '.') .
                            '</span></p>';
                        echo "<p class='wc_cart_discount'><b>Cupom:</b> <span>{$CartCupom}</span>%</p>";
                        echo "<p class='wc_cart_price'><b>Total:</b> R$ <span>" .
                            number_format($CartPrice, '2', ',', '.') .
                            '</span></p>';
                        echo '</div>';
                        echo "<div class='wc_cart_actions'>";
                        echo "<a class='btn btn_blue' href='" .
                            BASE .
                            "' title='Escolher Mais Produtos'>Escolher Mais Produtos</a>";
                        echo "<a class='btn btn_green' href='" .
                            BASE .
                            "/pedido/login#cart' title='Fechar Pedido'>Fechar Pedido</a>";
                        echo '</div>';
                        ?>

                <!--
                        <h2>Meu Carrinho</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">

                                    <table class="table cart">
                                        <thead>
                                            <tr>
                                                <th class="cart-product-thumbnail">PRODUTO</th>
                                                <th class="cart-product-name">DESCRIÇÃO</th>
                                                <th class="cart-product-price">PREÇO UNITÁRIO</th>
                                                <th class="cart-product-quantity">QUANTIDADE</th>
                                                <th class="cart-product-subtotal">TOTAL</th>
                                                <th class="cart-product-remove">REMOVER</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $CartTotal = 0;
                                            foreach (
                                                $_SESSION['wc_order']
                                                as $ItemId => $ItemAmount
                                            ):

                                                $Read->ExeRead(
                                                    DB_PDT,
                                                    'WHERE pdt_status = 1 AND (pdt_inventory IS NULL OR pdt_inventory >= 1) AND pdt_id = :id',
                                                    "id={$ItemId}"
                                                );
                                                if ($Read->getResult()):

                                                    extract(
                                                        $Read->getResult()[0]
                                                    );
                                                    $ItemPrice =
                                                        $pdt_offer_price &&
                                                        $pdt_offer_start <=
                                                            date(
                                                                'Y-m-d H:i:s'
                                                            ) &&
                                                        $pdt_offer_end >=
                                                            date('Y-m-d H:i:s')
                                                            ? $pdt_offer_price
                                                            : $pdt_price;
                                                    $CartTotal +=
                                                        $ItemPrice *
                                                        $ItemAmount;
                                                    ?>
                                                    <tr class="cart_item">

                                                        <td class="cart-product-thumbnail">
                                                            <a href="#"><img width="64" height="64" src="images\product\product-1.jpg" alt="Pink Printed Dress"></a>
                                                        </td>

                                                        <td class="cart-product-name">
                                                            <a href="#">Pink Printed Dress</a>
                                                        </td>

                                                        <td class="cart-product-price">
                                                            <span class="amount">R$19.99</span>
                                                        </td>

                                                        <td class="quantity">
                                                            <div class="quantity buttons-add-minus">
                                                                <input type="text" name="cart" value="1" title="Qty" class="input-text qty text">
                                                                <input type="button" value="-" class="minus">
                                                                <input type="button" value="+" class="plus">
                                                            </div>
                                                        </td>

                                                        <td class="cart-product-subtotal">
                                                            <span class="amount">R$ 39.98</span>
                                                        </td>

                                                        <td class="cart-product-remove">
                                                            <a href="#" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                        </td>

                                                    </tr>
                                                <?php
                                                endif;
                                                ?>
                                            <?php
                                            endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="cart_item coupon-check">
                                    <div class="row clearfix">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <input type="text" value="" class="dart-form-control" placeholder="Enter Coupon Code..">
                                            </div>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <a href="#" class="btn normal-btn dart-btn-xs">CUPOM PROMOCIONAL</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12 text-right">

                                            <div class="col-md-8 col-sm-6 col-xs-6">
                                                <a href="#" class="btn rd-stroke-btn border_1px dart-btn-xs">ATUALIZAR CARRINHO</a>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-6">
                                                <a href="checkout.html" class="btn rd-stroke-btn border_1px dart-btn-xs">FAZER PAGAMENTO</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-6 clearfix">
                                <h4>Calcular Frete</h4>
                                <form>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select class="dart-form-control">
                                                <option value="AX">&#197;land Islands</option>
                                                <option value="AF">Afghanistan</option>
                                                <option value="AL">Albania</option>
                                                <option value="DZ">Algeria</option>
                                                <option value="AD">Andorra</option>
                                                <option value="AO">Angola</option>
                                                <option value="AI">Anguilla</option>
                                                <option value="AQ">Antarctica</option>
                                                <option value="AG">Antigua and Barbuda</option>
                                                <option value="AR">Argentina</option>
                                                <option value="AM">Armenia</option>
                                                <option value="AW">Aruba</option>
                                                <option value="AU">Australia</option>
                                                <option value="AT">Austria</option>
                                                <option value="AZ">Azerbaijan</option>
                                                <option value="BS">Bahamas</option>
                                                <option value="BH">Bahrain</option>
                                                <option value="BD">Bangladesh</option>
                                                <option value="BB">Barbados</option>
                                                <option value="BY">Belarus</option>
                                                <option value="PW">Belau</option>
                                                <option value="BE">Belgium</option>
                                                <option value="BZ">Belize</option>
                                                <option value="BJ">Benin</option>
                                                <option value="BM">Bermuda</option>
                                                <option value="BT">Bhutan</option>
                                                <option value="BO">Bolivia</option>
                                                <option value="BQ">Bonaire, Saint Eustatius and Saba</option>
                                                <option value="BA">Bosnia and Herzegovina</option>
                                                <option value="BW">Botswana</option>
                                                <option value="BV">Bouvet Island</option>
                                                <option value="BR">Brazil</option>
                                                <option value="IO">British Indian Ocean Territory</option>
                                                <option value="VG">British Virgin Islands</option>
                                                <option value="BN">Brunei</option>
                                                <option value="BG">Bulgaria</option>
                                                <option value="BF">Burkina Faso</option>
                                                <option value="BI">Burundi</option>
                                                <option value="KH">Cambodia</option>
                                                <option value="CM">Cameroon</option>
                                                <option value="CA">Canada</option>
                                                <option value="CV">Cape Verde</option>
                                                <option value="KY">Cayman Islands</option>
                                                <option value="CF">Central African Republic</option>
                                                <option value="TD">Chad</option>
                                                <option value="CL">Chile</option>
                                                <option value="CN">China</option>
                                                <option value="CX">Christmas Island</option>
                                                <option value="CC">Cocos (Keeling) Islands</option>
                                                <option value="CO">Colombia</option>
                                                <option value="KM">Comoros</option>
                                                <option value="CG">Congo (Brazzaville)</option>
                                                <option value="CD">Congo (Kinshasa)</option>
                                                <option value="CK">Cook Islands</option>
                                                <option value="CR">Costa Rica</option>
                                                <option value="HR">Croatia</option>
                                                <option value="CU">Cuba</option>
                                                <option value="CW">Cura&Ccedil;ao</option>
                                                <option value="CY">Cyprus</option>
                                                <option value="CZ">Czech Republic</option>
                                                <option value="DK">Denmark</option>
                                                <option value="DJ">Djibouti</option>
                                                <option value="DM">Dominica</option>
                                                <option value="DO">Dominican Republic</option>
                                                <option value="EC">Ecuador</option>
                                                <option value="EG">Egypt</option>
                                                <option value="SV">El Salvador</option>
                                                <option value="GQ">Equatorial Guinea</option>
                                                <option value="ER">Eritrea</option>
                                                <option value="EE">Estonia</option>
                                                <option value="ET">Ethiopia</option>
                                                <option value="FK">Falkland Islands</option>
                                                <option value="FO">Faroe Islands</option>
                                                <option value="FJ">Fiji</option>
                                                <option value="FI">Finland</option>
                                                <option value="FR">France</option>
                                                <option value="GF">French Guiana</option>
                                                <option value="PF">French Polynesia</option>
                                                <option value="TF">French Southern Territories</option>
                                                <option value="GA">Gabon</option>
                                                <option value="GM">Gambia</option>
                                                <option value="GE">Georgia</option>
                                                <option value="DE">Germany</option>
                                                <option value="GH">Ghana</option>
                                                <option value="GI">Gibraltar</option>
                                                <option value="GR">Greece</option>
                                                <option value="GL">Greenland</option>
                                                <option value="GD">Grenada</option>
                                                <option value="GP">Guadeloupe</option>
                                                <option value="GT">Guatemala</option>
                                                <option value="GG">Guernsey</option>
                                                <option value="GN">Guinea</option>
                                                <option value="GW">Guinea-Bissau</option>
                                                <option value="GY">Guyana</option>
                                                <option value="HT">Haiti</option>
                                                <option value="HM">Heard Island and McDonald Islands</option>
                                                <option value="HN">Honduras</option>
                                                <option value="HK">Hong Kong</option>
                                                <option value="HU">Hungary</option>
                                                <option value="IS">Iceland</option>
                                                <option value="IN">India</option>
                                                <option value="ID">Indonesia</option>
                                                <option value="IR">Iran</option>
                                                <option value="IQ">Iraq</option>
                                                <option value="IM">Isle of Man</option>
                                                <option value="IL">Israel</option>
                                                <option value="IT">Italy</option>
                                                <option value="CI">Ivory Coast</option>
                                                <option value="JM">Jamaica</option>
                                                <option value="JP">Japan</option>
                                                <option value="JE">Jersey</option>
                                                <option value="JO">Jordan</option>
                                                <option value="KZ">Kazakhstan</option>
                                                <option value="KE">Kenya</option>
                                                <option value="KI">Kiribati</option>
                                                <option value="KW">Kuwait</option>
                                                <option value="KG">Kyrgyzstan</option>
                                                <option value="LA">Laos</option>
                                                <option value="LV">Latvia</option>
                                                <option value="LB">Lebanon</option>
                                                <option value="LS">Lesotho</option>
                                                <option value="LR">Liberia</option>
                                                <option value="LY">Libya</option>
                                                <option value="LI">Liechtenstein</option>
                                                <option value="LT">Lithuania</option>
                                                <option value="LU">Luxembourg</option>
                                                <option value="MO">Macao S.A.R., China</option>
                                                <option value="MK">Macedonia</option>
                                                <option value="MG">Madagascar</option>
                                                <option value="MW">Malawi</option>
                                                <option value="MY">Malaysia</option>
                                                <option value="MV">Maldives</option>
                                                <option value="ML">Mali</option>
                                                <option value="MT">Malta</option>
                                                <option value="MH">Marshall Islands</option>
                                                <option value="MQ">Martinique</option>
                                                <option value="MR">Mauritania</option>
                                                <option value="MU">Mauritius</option>
                                                <option value="YT">Mayotte</option>
                                                <option value="MX">Mexico</option>
                                                <option value="FM">Micronesia</option>
                                                <option value="MD">Moldova</option>
                                                <option value="MC">Monaco</option>
                                                <option value="MN">Mongolia</option>
                                                <option value="ME">Montenegro</option>
                                                <option value="MS">Montserrat</option>
                                                <option value="MA">Morocco</option>
                                                <option value="MZ">Mozambique</option>
                                                <option value="MM">Myanmar</option>
                                                <option value="NA">Namibia</option>
                                                <option value="NR">Nauru</option>
                                                <option value="NP">Nepal</option>
                                                <option value="NL">Netherlands</option>
                                                <option value="AN">Netherlands Antilles</option>
                                                <option value="NC">New Caledonia</option>
                                                <option value="NZ">New Zealand</option>
                                                <option value="NI">Nicaragua</option>
                                                <option value="NE">Niger</option>
                                                <option value="NG">Nigeria</option>
                                                <option value="NU">Niue</option>
                                                <option value="NF">Norfolk Island</option>
                                                <option value="KP">North Korea</option>
                                                <option value="NO">Norway</option>
                                                <option value="OM">Oman</option>
                                                <option value="PK">Pakistan</option>
                                                <option value="PS">Palestinian Territory</option>
                                                <option value="PA">Panama</option>
                                                <option value="PG">Papua New Guinea</option>
                                                <option value="PY">Paraguay</option>
                                                <option value="PE">Peru</option>
                                                <option value="PH">Philippines</option>
                                                <option value="PN">Pitcairn</option>
                                                <option value="PL">Poland</option>
                                                <option value="PT">Portugal</option>
                                                <option value="QA">Qatar</option>
                                                <option value="IE">Republic of Ireland</option>
                                                <option value="RE">Reunion</option>
                                                <option value="RO">Romania</option>
                                                <option value="RU">Russia</option>
                                                <option value="RW">Rwanda</option>
                                                <option value="ST">S&atilde;o Tom&eacute; and Pr&iacute;ncipe</option>
                                                <option value="BL">Saint Barth&eacute;lemy</option>
                                                <option value="SH">Saint Helena</option>
                                                <option value="KN">Saint Kitts and Nevis</option>
                                                <option value="LC">Saint Lucia</option>
                                                <option value="SX">Saint Martin (Dutch part)</option>
                                                <option value="MF">Saint Martin (French part)</option>
                                                <option value="PM">Saint Pierre and Miquelon</option>
                                                <option value="VC">Saint Vincent and the Grenadines</option>
                                                <option value="SM">San Marino</option>
                                                <option value="SA">Saudi Arabia</option>
                                                <option value="SN">Senegal</option>
                                                <option value="RS">Serbia</option>
                                                <option value="SC">Seychelles</option>
                                                <option value="SL">Sierra Leone</option>
                                                <option value="SG">Singapore</option>
                                                <option value="SK">Slovakia</option>
                                                <option value="SI">Slovenia</option>
                                                <option value="SB">Solomon Islands</option>
                                                <option value="SO">Somalia</option>
                                                <option value="ZA">South Africa</option>
                                                <option value="GS">South Georgia/Sandwich Islands</option>
                                                <option value="KR">South Korea</option>
                                                <option value="SS">South Sudan</option>
                                                <option value="ES">Spain</option>
                                                <option value="LK">Sri Lanka</option>
                                                <option value="SD">Sudan</option>
                                                <option value="SR">Suriname</option>
                                                <option value="SJ">Svalbard and Jan Mayen</option>
                                                <option value="SZ">Swaziland</option>
                                                <option value="SE">Sweden</option>
                                                <option value="CH">Switzerland</option>
                                                <option value="SY">Syria</option>
                                                <option value="TW">Taiwan</option>
                                                <option value="TJ">Tajikistan</option>
                                                <option value="TZ">Tanzania</option>
                                                <option value="TH">Thailand</option>
                                                <option value="TL">Timor-Leste</option>
                                                <option value="TG">Togo</option>
                                                <option value="TK">Tokelau</option>
                                                <option value="TO">Tonga</option>
                                                <option value="TT">Trinidad and Tobago</option>
                                                <option value="TN">Tunisia</option>
                                                <option value="TR">Turkey</option>
                                                <option value="TM">Turkmenistan</option>
                                                <option value="TC">Turks and Caicos Islands</option>
                                                <option value="TV">Tuvalu</option>
                                                <option value="UG">Uganda</option>
                                                <option value="UA">Ukraine</option>
                                                <option value="AE">United Arab Emirates</option>
                                                <option value="GB" selected='selected'>United Kingdom (UK)</option>
                                                <option value="US">United States (US)</option>
                                                <option value="UY">Uruguay</option>
                                                <option value="UZ">Uzbekistan</option>
                                                <option value="VU">Vanuatu</option>
                                                <option value="VA">Vatican</option>
                                                <option value="VE">Venezuela</option>
                                                <option value="VN">Vietnam</option>
                                                <option value="WF">Wallis and Futuna</option>
                                                <option value="EH">Western Sahara</option>
                                                <option value="WS">Western Samoa</option>
                                                <option value="YE">Yemen</option>
                                                <option value="ZM">Zambia</option>
                                                <option value="ZW">Zimbabwe</option>

                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="dart-form-control" placeholder="State / Country">
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="text" class="dart-form-control" placeholder="PostCode / Zip">
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="#" class="btn normal-btn dart-btn-xs">Atualizar Total</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-6 clearfix">
                                <div class="table-responsive totle-cart">
                                    <h4>Cart Totals</h4>

                                    <table class="table cart">
                                        <tbody>
                                            <tr class="cart_item cart_totle">
                                                <td class="cart-product-name">
                                                    <strong>Subtotal</strong>
                                                </td>

                                                <td class="cart-product-name">
                                                    <span class="amount">R$ 106.94</span>
                                                </td>
                                            </tr>
                                            <tr class="cart_item cart_totle">
                                                <td class="cart-product-name">
                                                    <strong>Frete</strong>
                                                </td>

                                                <td class="cart-product-name">
                                                    <span class="amount">Entrega Grátis</span>
                                                </td>
                                            </tr>
                                            <tr class="cart_item cart_totle">
                                                <td class="cart-product-name">
                                                    <strong>Total</strong>
                                                </td>

                                                <td class="cart-product-name">
                                                    <span class="blue"><strong>R$106.94</strong></span>
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>

                                </div>
                            </div>
                        </div>
                        -->


                <?php
                    elseif ($CartAction == 'login'):
                        if (
                            !empty($_SESSION['userLogin']) &&
                            !empty($_SESSION['userLogin']['user_cell']) &&
                            !empty($_SESSION['userLogin']['user_document'])
                        ):
                            header('Location: ' . BASE . '/pedido/endereco');
                        endif;
                        echo '<header>';
                        echo '<h1>Informe seus dados</h1>';
                        echo '</header>';
                        echo "<div class='workcontrol_order'>";
                        echo "<div class='workcontrol_order_forms'>";
                        echo "<form autocomplete='off' class='wc_order_login' method='post' action=''>";
                        echo "<label><span>E-mail:</span><input class='wc_order_email' type='email' name='user_email' id='user_email' placeholder='Seu E-mail:' required/></label>";
                        echo "<div class='label50'><label><span>Nome:</span><input type='text' name='user_name' id='user_name' placeholder='Seu Primeiro Nome:' required/></label></div>";
                        echo "<div class='label50'><label><span>Sobrenome:</span><input type='text' name='user_lastname' id='user_lastname' placeholder='Seu Último Nome:' required/></label></div>";
                        echo "<div class='label50'><label><span>Celular:</span><input class='formPhone' type='text' name='user_cell' id='user_cell' placeholder='Seu Telefone:' required/></label></div>";
                        echo "<div class='label50 labeldocument'><label><span>CPF:</span><input class='formCpf' type='text' name='user_document' id='user_document' placeholder='Seu CPF:' required/></label></div>";
                        echo "<label><span>Senha (de 5 a 11 caracteres):</span><input type='password' name='user_password' id='user_password' placeholder='Sua Senha:' required/></label>";
                        echo "<div class='workcontrol_order_forms_actions'>";
                        echo "<button class='btn btn_green wc_button_cart'>CONTINUAR</button>";
                        echo "<img alt='Processando Dados!' title='Processando Dados!' src='" .
                            BASE .
                            "/_cdn/widgets/ecommerce/load_g.gif'/>";
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        require 'cart.sidebar.php';
                        echo "<div class='workcontrol_order_back'>";
                        echo "<a href='" .
                            BASE .
                            "/pedido/home#cart' title='Voltar a minha lista de compras'>Voltar</a>";
                        echo '</div>';
                        echo '</div>';
                    elseif ($CartAction == 'endereco'):
                        if (empty($_SESSION['userLogin'])):
                            header('Location: ' . BASE . '/pedido/login');
                        endif;
                        echo '<header>';
                        echo '<h1>Endereço de entrega:</h1>';
                        echo '</header>';
                        echo "<div class='workcontrol_order'>";
                        echo "<div class='workcontrol_order_forms'>";
                        echo "<form autocomplete='off' class='wc_order_create' method='post' action=''>";

                        $Read->ExeRead(
                            DB_USERS_ADDR,
                            'WHERE user_id = :id ORDER BY addr_key DESC, addr_name ASC',
                            "id={$_SESSION['userLogin']['user_id']}"
                        );
                        if ($Read->getResult()):
                            echo "<div class='workcontrol_order_addrs'>";
                            echo "<p class='workcontrol_order_newaddr'><span class='btn btn_blue wc_addr_form_open'>Cadastrar Novo Endereço</span></p>";
                            foreach ($Read->getResult() as $Addr):
                                echo "<label class='worcontrol_useraddr'><input class='wc_order_user_addr' required type='radio' value='{$Addr['addr_id']}' name='wc_order_addr' id='{$Addr['addr_zipcode']}'/><div><p class='title'>{$Addr['addr_name']}: </p><p>{$Addr['addr_street']}, {$Addr['addr_number']}</p><p>B. {$Addr['addr_district']}, {$Addr['addr_city']}/{$Addr['addr_state']}</p><p>{$Addr['addr_zipcode']}</p></div></label>";
                            endforeach;
                            echo '</div>';

                            echo "<div class='workcontrol_order_newaddr_form'>";
                            echo "<p class='workcontrol_order_newaddr'><span class='btn btn_yellow wc_addr_form_close'>Selecionar Um Endereço!</span></p>";
                        endif;

                        echo "<div class='label50'><label><span>Nome:</span><input type='text' name='addr_name' placeholder='Ex: Minha Casa' required/></label></div>";
                        echo "<div class='label50'><label><span>CEP:</span><input class='wc_getCep formCep wc_order_zipcode wc_cart_ship_val' type='text' name='addr_zipcode' placeholder='CEP:' required/></label></div>";
                        echo "<div class='label50'><label><span>Logradouro:</span><input class='wc_logradouro' type='text' name='addr_street' placeholder='Nome da Rua:' required/></label></div>";
                        echo "<div class='label50'><label><span>Número:</span><input type='text' name='addr_number' placeholder='Informe o número:' required/></label></div>";
                        echo "<div class='label50'><label><span>Complemento:</span><input class='wc_complemento' type='text' name='addr_complement' placeholder='Ex: Casa B, Ap101'/></label></div>";
                        echo "<div class='label50'><label><span>Bairro:</span><input class='wc_bairro' type='text' name='addr_district' placeholder='Bairro:' required/></label></div>";
                        echo "<div class='label50'><label><span>Cidade:</span><input class='wc_localidade' type='text' name='addr_city' placeholder='Cidade:' required/></label></div>";
                        echo "<div class='label50'><label><span>Estado:</span><input class='wc_uf' type='text' name='addr_state' placeholder='UF do estado:' required/></label></div>";

                        if ($Read->getResult()):
                            echo '</div>';
                        endif;

                        echo "<p class='wc_cart_total_shipment_tag'>Selecione o frete:</p>";
                        echo "<div class='workcontrol_shipment wc_cart_total_shipment_result'></div>";
                        echo "<div class='workcontrol_order_forms_actions'>";
                        echo "<button class='btn btn_green wc_button_cart'>CONTINUAR</button>";
                        echo "<img alt='Processando Dados!' title='Processando Dados!' src='" .
                            BASE .
                            "/_cdn/widgets/ecommerce/load_g.gif'/>";
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        require 'cart.sidebar.php';
                        echo "<div class='workcontrol_order_back'>";
                        echo "<a href='" .
                            BASE .
                            "/pedido/home#cart' title='Voltar a minha lista de compras'>Voltar</a>";
                        echo '</div>';
                        echo '</div>';
                    elseif ($CartAction == 'pagamento'):
                        unset(
                            $_SESSION['wc_order'],
                            $_SESSION['wc_cupom'],
                            $_SESSION['wc_cupom_code'],
                            $_SESSION['wc_shipment_zip'],
                            $_SESSION['wc_shipment_item'],
                            $_SESSION['wc_order_addr']
                        );

                        echo '<header>';
                        echo '<h1>Pagamento:</h1>';
                        echo '</header>';

                        $OrderId = filter_var(
                            base64_decode($URL[2]),
                            FILTER_VALIDATE_INT
                        );
                        $Read->ExeRead(
                            DB_ORDERS,
                            'WHERE order_id = :od',
                            "od={$OrderId}"
                        );

                        if (!$OrderId):
                            echo "<div class='workcontrol_cart_clean'>";
                            echo "<p class='title'><span>&#10008;</span>Oppsss, não foi possível acessar o pedido! :(</p>";
                            echo '<p>Desculpe mas o pedido que você está tentando pagar não existe. Por favor, confira o link de pagamento!</p>';
                            echo "<a class='btn btn_green' title='Escolher Produtos' href='" .
                                BASE .
                                "'>ESCOLHER PRODUTOS</a>";
                            echo '</div>';
                        elseif (!$Read->getResult()):
                            echo "<div class='workcontrol_cart_clean'>";
                            echo "<p class='title'><span>&#10008;</span>Oppsss, pedido indisponível para pagamento! :(</p>";
                            echo '<p>Você tentou acessar o pedido <b>#' .
                                str_pad($OrderId, 7, 0, 0) .
                                '</b>. O mesmo não existe ou está indisponível para pagamento!</p>';
                            echo "<a class='btn btn_green' title='Escolher Produtos' href='" .
                                BASE .
                                "'>ESCOLHER PRODUTOS</a>";
                            echo '</div>';
                        else:
                            $CartOrder = $Read->getResult()[0];
                            extract($CartOrder);
                            if (
                                $order_status == 1 ||
                                $order_status == 6 ||
                                date(
                                    'Y-m-d H:i:s',
                                    strtotime(
                                        $order_date .
                                            '+' .
                                            E_ORDER_DAYS .
                                            'days'
                                    )
                                ) < date('Y-m-d H:i:s')
                            ):
                                echo "<div class='workcontrol_cart_clean'>";
                                echo "<p class='title'><span>&#10008;</span>O pedido #" .
                                    str_pad($order_id, 7, 0, 0) .
                                    ' não pode ser pago!</p>';
                                echo '<p>O status deste pedido é <b>' .
                                    getOrderStatus($order_status) .
                                    '</b>, pedidos cancelados ou concluídos não podem ser pagos!</p>';
                                echo "<a class='btn btn_green' title='Escolher Produtos!' href='" .
                                    BASE .
                                    "'>Escolha produtos para um novo pedido!</a>";
                                echo '</div>';
                            else:
                                $_SESSION['wc_payorder'] = $CartOrder;
                                echo "<div class='workcontrol_order'>";
                                echo "<div class='workcontrol_order_forms'>";
                                require 'PagSeguro/Payment.workcontrol.php';
                                echo '</div>';
                                require 'cart.order.php';
                                echo '</div>';
                            endif;
                        endif;
                    elseif ($CartAction == 'obrigado'):
                        if (empty($_SESSION['wc_payorder'])):
                            echo '<header>';
                            echo '<h1>Detalhes do pedido:</h1>';
                            echo '</header>';
                            echo "<div class='workcontrol_cart_clean'>";
                            echo "<p class='title'><span>&#10008;</span>Oppsss, não foi possível acessar o pedido! :(</p>";
                            echo '<p>Desculpe mas o pedido que você está tentando acessar não existe. Por favor, confira o link ou crie um novo pedido!</p>';
                            echo "<a class='btn btn_green' title='Escolher Produtos!' href='" .
                                BASE .
                                "'>ESCOLHER PRODUTOS!</a>";
                            echo '</div>';
                        else:
                            $Read = new Read();
                            $Read->ExeRead(
                                DB_ORDERS,
                                'WHERE order_id = :orid',
                                "orid={$_SESSION['wc_payorder']['order_id']}"
                            );
                            if (!$Read->getResult()):
                                echo '<header>';
                                echo '<h1>Detalhes do pedido:</h1>';
                                echo '</header>';
                                echo "<div class='workcontrol_cart_clean'>";
                                echo "<p class='title'><span>&#10008;</span>Oppsss, não foi possível acessar o pedido! :(</p>";
                                echo '<p>Desculpe mas o pedido que você está tentando acessar não existe. Por favor, confira o link ou crie um novo pedido!</p>';
                                echo "<a class='btn btn_green' title='Escolher Produtos!' href='" .
                                    BASE .
                                    "'>ESCOLHER PRODUTOS!</a>";
                                echo '</div>';
                            else:
                                extract($Read->getResult()[0]);
                                $Read->FullRead(
                                    'SELECT user_name, user_email FROM ' .
                                        DB_USERS .
                                        ' WHERE user_id = :oruser',
                                    "oruser={$user_id}"
                                );
                                $UserOrder = $Read->getResult()[0];

                                echo '<header>';
                                echo '<h1>&#10003 Pedido Confirmado <span>#' .
                                    str_pad($order_id, 7, 0, 0) .
                                    '</span></h1>';
                                echo '</header>';
                                echo "<div class='workcontrol_order'>";

                                echo "<div class='trigger trigger_success workcontrol_trigger_order'>";
                                echo "<b>Caro(a) {$UserOrder['user_name']},</b>";
                                echo "<p>Você receberá em sua caixa de entrada (<b>{$UserOrder['user_email']}</b>) um e-mail com todos os detalhes de seu pedido. " .
                                    'Seu pagamento foi realizado via ' .
                                    getOrderPayment($order_payment) .
                                    " e encontra-se aguardando a confirmação de pagamento. <span style='color:#709E70;'>(Caso não receba nenhum e-mail, verifique sua caixa de Span)</span></p>";
                                echo '<p>Assim que o pagamento for compensado enviaremos seu pedido!</p>';
                                echo '</div>';

                                echo "<article class='workcontrol_order_completed'>";
                                echo '<header>';
                                echo '<h1><span>Compra realizada em ' .
                                    date('d/m/Y H\hi', strtotime($order_date)) .
                                    ' via ' .
                                    getOrderPayment($order_payment) .
                                    '</span>';
                                if ($order_billet):
                                    echo "<a class='btn btn_green fl_right' title='Imprimir Boleto' target='_blanck' href='{$order_billet}'>&#x274F; Imprimir Boleto</a>";
                                endif;
                                echo "</h1><div class='clear'></div></header>";

                                echo "<div class='workcontrol_order_completed_card'><p class='product'>Produto</p><p>Preço</p><p>Quantidade</p><p>Total</p></div>";
                                $SideTotalCart = 0;
                                $SideTotalExtra = 0;
                                $SideTotalPrice = 0;
                                $Read->ExeRead(
                                    DB_ORDERS_ITEMS,
                                    'WHERE order_id = :orid',
                                    "orid={$order_id}"
                                );
                                if ($Read->getResult()):
                                    foreach (
                                        $Read->getResult()
                                        as $SideProduct
                                    ):
                                        if ($SideProduct['pdt_id']):
                                            echo "<div class='workcontrol_order_completed_card items'>";
                                            $Read->FullRead(
                                                'SELECT pdt_cover FROM ' .
                                                    DB_PDT .
                                                    ' WHERE pdt_id = :pid',
                                                "pid={$SideProduct['pdt_id']}"
                                            );
                                            echo "<p class='product'><img title='{$SideProduct['item_name']}' alt='{$SideProduct['item_name']}' src='" .
                                                BASE .
                                                "/tim.php?src=uploads/{$Read->getResult()[0]['pdt_cover']}&w=" .
                                                THUMB_W / 5 .
                                                '&h=' .
                                                THUMB_H / 5 .
                                                "'/><span>" .
                                                Check::Chars(
                                                    $SideProduct['item_name'],
                                                    42
                                                ) .
                                                '</span></p>';
                                            echo '<p>R$ ' .
                                                number_format(
                                                    $SideProduct['item_price'],
                                                    '2',
                                                    ',',
                                                    '.'
                                                ) .
                                                '</p>';
                                            echo "<p>{$SideProduct['item_amount']}</p>";
                                            echo '<p>R$ ' .
                                                number_format(
                                                    $SideProduct['item_price'] *
                                                        $SideProduct[
                                                            'item_amount'
                                                        ],
                                                    '2',
                                                    ',',
                                                    '.'
                                                ) .
                                                '</p>';
                                            $SideTotalCart +=
                                                $SideProduct['item_price'] *
                                                $SideProduct['item_amount'];
                                            echo '</div>';
                                        else:
                                            $SideTotalExtra +=
                                                $SideProduct['item_price'] *
                                                $SideProduct['item_amount'];
                                        endif;
                                    endforeach;
                                endif;

                                $TotalCart = $SideTotalCart;
                                $TotalExtra = $SideTotalExtra;
                                echo "<div class='workcontrol_order_completed_card total'>";
                                echo "<div class='wc_cart_total'>Sub-total: <b>R$ <span>" .
                                    number_format($TotalCart, '2', ',', '.') .
                                    '</span></b></div>';
                                if ($order_coupon):
                                    echo "<div class='wc_cart_discount'>Desconto: <b><strike>R$ <span>" .
                                        number_format(
                                            $SideTotalCart *
                                                ($order_coupon / 100),
                                            '2',
                                            ',',
                                            '.'
                                        ) .
                                        '</span></strike></b></div>';
                                endif;
                                echo '<div>Frete: <b>R$ <span>' .
                                    number_format(
                                        $order_shipprice,
                                        '2',
                                        ',',
                                        '.'
                                    ) .
                                    '</span></b></div>';
                                if ($order_installments > 1):
                                    echo '<div>Total : <b>R$ <span>' .
                                        number_format(
                                            $order_price,
                                            '2',
                                            ',',
                                            '.'
                                        ) .
                                        '</span></b></div>';
                                    echo "<div class='wc_cart_price'><small><sup>{$order_installments}x</sup> R$ {$order_installment} : </small><b>R$ <span>" .
                                        number_format(
                                            $order_installments *
                                                $order_installment,
                                            '2',
                                            ',',
                                            '.'
                                        ) .
                                        '</span></b></div>';
                                else:
                                    echo "<div class='wc_cart_price'>Total : <b>R$ <span>" .
                                        number_format(
                                            $order_price,
                                            '2',
                                            ',',
                                            '.'
                                        ) .
                                        '</span></b></div>';
                                endif;
                                echo '</div>';
                                echo '</article>';

                                echo '</div>';
                            endif;
                        endif;
                    else:
                        header('Location: ' . BASE . '/pedido/home');
                    endif;
                endif;
                echo '</article>';
                ?>

            </div>
        </div>
    </div>
</section>

<div id="result"></div>

<!-- SECCAO CARRINHO - FIM -->

<script>
// Check browser support
if (typeof(Storage) !== "undefined") {
    // Store
    localStorage.setItem("donna-glam", "EjAex0ie2aoi+fnsad");
    // Retrieve
    // document.getElementById("result").innerHTML = localStorage.getItem("lastname");
} else {
    document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
}
</script>