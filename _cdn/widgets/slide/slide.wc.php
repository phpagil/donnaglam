<section class="dart-no-padding-tb">

    <div class="ms-layers-template">
        <!-- masterslider -->
        <div class="master-slider ms-skin-black-2 round-skin" id="masterslider">

            <div class="ms-slide slide-2" style="z-index: 10" data-delay="10">
                <img src="<?= BASE; ?>/_cdn/vendor/masterslider\style\blank.gif" data-src="<?= BASE; ?>/_cdn/images/demo-4/bg4.jpg" alt="lorem ipsum dolor sit">
                <img src="<?= BASE; ?>/_cdn/vendor/masterslider\style\blank.gif" width="600" data-src="<?= BASE; ?>/_cdn/images/demo-4/original.gif" alt="layer" class="ms-layer" style="bottom:220px; left:180px;" data-effect="fade(30)" data-duration="2000" data-ease="easeOutExpo" data-type="image">
                <h3 class="ms-layer normal-title" style="left:230px; top:360px; color:#ee2b63; font-size: 40px; font-weight: 600;" data-effect="right(40)" data-duration="2300" data-delay="1300" data-ease="easeOutExpo">VEM FAZER TEU RANCHO!</h3>
                <h3 class="ms-layer normal-title" style="left:200px; top:405px; color:#ee2b63; font-size: 30px;" data-effect="left(40)" data-duration="2300" data-delay="1400" data-ease="easeOutBack">PASSE NA DONNA GLAM</h3>
            </div>

            <div class="ms-slide slide-2" style="z-index: 13" data-delay="10">
                <img src="<?= BASE; ?>/_cdn/vendor/masterslider\style\blank.gif" data-src="<?= BASE; ?>/_cdn/images/demo-4/bg.jpg" alt="lorem ipsum dolor sit">
                <img src="<?= BASE; ?>/_cdn/vendor/masterslider\style\blank.gif" data-src="<?= BASE; ?>/_cdn/images/demo-4/bm.png" alt="layer" class="ms-layer" style="bottom:0; left:0px" data-effect="left(40)" data-type="image">
                <img src="<?= BASE; ?>/_cdn/vendor/masterslider\style\blank.gif" data-src="<?= BASE; ?>/_cdn/images/demo-4/bm-2.png" alt="layer" class="ms-layer" style="left:640px; top:184px " data-effect="rotatebottom(40,250,c)" data-duration="3500" data-delay="900" data-ease="easeOutExpo" data-type="image">
                <h3 class="ms-layer light-title" style="left:660px; top:60px; color:#464646; font-size:40px; font-weight: 600;letter-spacing: 1px;" data-effect="left(short)" data-duration="3300" data-delay="1900" data-ease="easeOutExpo">Nova Cidade</h3>
                <h1 class="ms-layer light-title" style="left:630px; top:100px; color:#ee2b63; font-size:30px; font-weight: 900;letter-spacing: 0.5px;" data-effect="left(short)" data-duration="3500" data-delay="2100" data-ease="easeOutExpo">Estamos Chegando...</h1>
            </div>

            <?php
            $Read = new Read;
            $Read->ExeRead(DB_SLIDES, "WHERE slide_start <= NOW() AND (slide_end >= NOW() OR slide_end IS NULL) ORDER BY slide_date DESC");
            if ($Read->getResult()) :
                $i_slide = 1;
                foreach ($Read->getResult() as $Slide) :
                    extract($Slide);
                    $SlideLink = (strstr($slide_link, 'http') ? $slide_link : BASE . "/{$slide_link}");
                    $SlideTarget = (strstr($slide_link, 'http') ? ("target='_blank'") : null);

                    echo "<div class='ms-slide slide-2' style='z-index: 13' data-delay='10'>";
                    echo '<img onclick="window.location.href=' . $SlideLink . '" src="' . BASE . '/_cdn/vendor/masterslider\style\blank.gif" data-src="' . BASE . '//tim.php?src=uploads/' . $slide_image . '&w=' . SLIDE_W . '&h=' . SLIDE_H . '" alt="lorem ipsum dolor sit">';
                    echo "</div>";

                    $i_slide++;
                endforeach;
            endif;
            ?>

        </div>
        <!-- end of masterslider -->
    </div>

</section>