<?php

echo '<div class="workcontroltime" id="' . (!empty($SlideSeconts) ? $SlideSeconts : 5) . '"></div>';
echo '<link rel="stylesheet" href="' . BASE . '/_cdn/widgets/slide/slide.wc.css"/>';
echo '<script src="' . BASE . '/_cdn/widgets/slide/slide.wc.js"></script>';

$Read = new Read;
$Read->ExeRead(DB_SLIDES, "WHERE slide_start <= NOW() AND (slide_end >= NOW() OR slide_end IS NULL) ORDER BY slide_date DESC");
if ($Read->getResult()) :
    $i_slide = 1;
    echo "<section class='content wc_slides'>";
    echo "<h1 class='wc_slide_title'>Conteúdo em destaque:</h1>";
    foreach ($Read->getResult() as $Slide) :
        extract($Slide);
        $SlideLink = (strstr($slide_link, 'http') ? $slide_link : BASE . "/{$slide_link}");
        $SlideTarget = (strstr($slide_link, 'http') ? ("target='_blank'") : null);
        echo "<article class='wc_slide_item" . ($i_slide == 1 ? ' first' : null) . "'>
            <a {$SlideTarget} title='{$slide_title}' href='{$SlideLink}'><img title='{$slide_title}' alt='{$slide_title}' src='" . BASE . "/tim.php?src=uploads/{$slide_image}&w=" . SLIDE_W . "&h=" . SLIDE_H . "'/></a>
            <div class='wc_slide_item_desc'>
                <h1><a {$SlideTarget} title='{$slide_title}' href='{$SlideLink}'>{$slide_title}</a></h1>
                <p><a {$SlideTarget} title='{$slide_title}' href='{$SlideLink}'>{$slide_desc}</a></p>
            </div>
        </article>";
        $i_slide++;
    endforeach;

    echo "<div class='wc_slide_pager'>";
    echo "<span class='active'></span>";
    echo str_repeat("<span></span>", $Read->getRowCount() - 1);
    echo "</div>";
    echo "<div class='clear'></div>";
    echo "</section>";
endif;
