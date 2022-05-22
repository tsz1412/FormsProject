<?php

$templates = array(
    'before' => '<div class="breadcrumb"><div class="container"><ul>',
    'after' => '</div></ul></div>',
    'standard' => '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">%s</li>',
    'current' => '<li class="current">%s</li>',
    'link' => '<a href="%s" itemprop="url"><span itemprop="title">%s</span></a>'
);
$options = array(
    'show_htfpt' => true
);

$breadcrumb = new Breadcrumb( $templates, $options );