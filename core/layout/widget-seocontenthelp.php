<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - SEO Content Help
 * @package    core/layout/widget-seocontenthelp.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.10
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<div class="alert widget item mt-3 ml-2 p-0" data-dbid="<?=$rw['id'];?>" id="l_<?=$rw['id'];?>">
  <div class="toolbar px-2 py-1 bg-white">
    <?=$rw['title'];?>
    <div class="btn-group">
      <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i">close</i></button>
    </div>
  </div>
  <p class="mx-2 my-1 small">
    Need help or inspiration to write content, here's some links below that may help.<br>
    <a target="_blank" href="https://ads.google.com/home/tools/keyword-planner/">Google's Keyword Planner</a>. Or you can try <a target="_blank" href="https://www.wordstream.com/keywords">Word Streams Free Keyword Tool</a> for a cut down, easier to user Planner.<br>
    <a target="_blank" href="https://alsoasked.com/">AlsoAsked</a> can help you find topics for content to write based on topics or keywords. Or you can try <a target="_blank" href="https://answerthepublic.com/">Answer The Public</a> to also find topics to use.<br>
    <script>
      var checkGrammarly=document.querySelectorAll('body[data-gr-ext-installed]');
      if(checkGrammarly){
        document.write('Great you have <a target="_blank href="https://www.grammarly.com/">Grammarly</a> installed.<br>');
      }else{
        document.write('<a target="_blank" href="https://www.grammarly.com/">Grammarly</a> is a Browser Extension that can help with spelling, synonym\'s and sentence structure.</br>');
      }
    </script>
    <br>
    After your content has been published for a while, try <a href="https://ahrefs.com/backlink-checker">AHref's Free Backink Checker</a> (No sign-in), to see how it's going, or needs improving with it's keywords.<br>
  </p>
</div>
