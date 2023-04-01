<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - SEOLinks
 * @package    core/layout/widget-seolinks.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.23
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<div class="item resize m-0 p-0 col-12 col-sm-<?=$rw['width_sm'];?> col-md-<?=$rw['width_md'];?> col-lg-<?=$rw['width_lg'];?> col-xl-<?=$rw['width_xl'];?> col-xxl-<?=$rw['width_xxl'];?>" data-dbid="<?=$rw['id'];?>" data-smmin="6" data-smmax="12" data-mdmin="6" data-mdmax="12" data-lgmin="1" data-lgmax="12" data-xlmin="5" data-xlmax="12" data-xxlmin="4" data-xxlmax="6" id="l_<?=$rw['id'];?>">
  <div class="alert widget m-3 p-0">
    <div class="toolbar px-2 py-1 handle">
      <?=$rw['title'].($config['development']==1?'<span id="width_'.$rw['id'].'"></span>':'');?>
      <div class="btn-group">
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
      </div>
    </div>
    <p class="mx-3 my-1 mt-2 small"><strong>Want to learn to do your own Search Engine Optimisation (SEO)?</strong></p>
    <p class="mx-3 my-1 small">
      There's no reason you can't do your own SEO, however, do keep in mind that if you hire a reputable professional consultant that you will get a lot better results.<br>
      Here's a list of Free SEO Courses, which I do recommend that you at least have a look at the simple ones so you have an understanding of what SEO is, and what you can do to help your business along, even if using a consultant. Plus, it will give you more understanding of what they're talking about.<br>
      <br>
      <a target="_blank" rel="nofollow noreferrer" href="https://learningseo.io/">Learning SEO – A Roadmap with Free Guides & Tools</a> &larr; <small>Best Free Resource.</small><br>
      <a target="_blank" rel="nofollow noreferrer" href="https://members.clickminded.com/courses/seo-mini-course/lessons/getting-started-5/">Free SEO Course by ClickMinded</a><br>
      <a target="_blank" rel="nofollow noreferrer" href="https://moz.com/learn/seo/one-hour-guide-to-seo">Moz's One Hour Guide to SEO (6 Part Video Series)</a><br>
      <a target="_blank" rel="nofollow noreferrer" href="https://www.semrush.com/academy/courses/seo-toolkit-course">Semrush SEO Toolkit Course</a>
    </p>
  </div>
</div>
