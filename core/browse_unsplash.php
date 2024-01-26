<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Content - Browse Unsplash
 * @package    core/layout/edit_content.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-3
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$id=isset($_GET['id'])?filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT):0;
$tbl=isset($_GET['t'])?filter_input(INPUT_GET,'t',FILTER_SANITIZE_STRING):'';
$col=isset($_GET['c'])?filter_input(INPUT_GET,'c',FILTER_SANITIZE_STRING):'';
require'db.php';
$config=$db->query("SELECT mediaOptions,mediaMaxWidth,mediaMaxWidthThumb,unsplash_appname,unsplash_publickey,unsplash_secretkey FROM `".$prefix."config` WHERE `id`=1")->fetch(PDO::FETCH_ASSOC);
if($config['unsplash_publickey']!=''&&$config['unsplash_secretkey']!=''){?>
  <div class="container p-5">
    <form class="unsplash-form">
      <div class="form-row">
        <div class="input-text unsplash-result-stats hidewhenempty"></div>
        <input type="text" class="unsplash-search-input" placeholder="Search high quality photos from Unsplash" autofocus>
        <button type="submit">Go</button>
      </div>
    </form>
    <div class="unsplash-cat-wrapper">
      <div class="unsplash-cat-btn-wrapper left">
        <button title="scroll list to the left" class="btn-ghost unsplash-left"><svg width="24" height="24" class="DG_Wq" viewBox="0 0 24 24" version="1.1" aria-hidden="false"><desc lang="en-US">Chevron left</desc><path d="M15.5 18.5 14 20l-8-8 8-8 1.5 1.5L9 12l6.5 6.5Z"></path></svg></button>
      </div>
      <div class="unsplash-cat-btn-wrapper right">
        <button title="scroll list to the right" class="btn-ghost unsplash-right"><svg width="24" height="24" class="DG_Wq" viewBox="0 0 24 24" version="1.1" aria-hidden="false"><desc lang="en-US">Chevron right</desc><path d="M8.5 5.5 10 4l8 8-8 8-1.5-1.5L15 12 8.5 5.5Z"></path></svg></button>
      </div>
      <div class="unsplash-cat-list-container">
        <div class="unsplash-cat-list-wrapper">
          <ul class="unsplash-cat-list">
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Wallpapers`);handleCategory();">Wallpapers</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`3D Renders`);handleCategory();">3D Renders</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Animals`);handleCategory();">Animals</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Architecture & Interiors`);handleCategory();">Architecture & Interiors</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Agriculture`);handleCategory();">Agriculture</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Athletics`);handleCategory();">Athletics</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Arts & Culture`);handleCategory();">Arts & Culture</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Aurora`);handleCategory();">Aurora</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Automobile`);handleCategory();">Automobile</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Beach`);handleCategory();">Beach</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Black`);handleCategory();">Black</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Blue`);handleCategory();">Blue</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Business & Work`);handleCategory();">Business & Work</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Cafe`);handleCategory();">Cafe</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Cake`);handleCategory();">Cake</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Camera`);handleCategory();">Camera</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Car`);handleCategory();">Car</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Coffee`);handleCategory();">Coffee</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Computer`);handleCategory();">Computer</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Current Events`);handleCategory();">Current Events</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Experimental`);handleCategory();">Experimental</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Fashion & Beauty`);handleCategory();">Fashion & Beauty</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Film`);handleCategory();">Film</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Flowers`);handleCategory();">Flowers</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Food & Drink`);handleCategory();">Food & Drink</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Fruit`);handleCategory();">Fruit</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Garden`);handleCategory();">Garden</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Grass`);handleCategory();">Grass</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Green`);handleCategory();">Green</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Health & Wellness`);handleCategory();">Health & Wellness</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`History`);handleCategory();">History</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Nature`);handleCategory();">Nature</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Orange`);handleCategory();">Orange</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Pastry`);handleCategory();">Pastry</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`People`);handleCategory();">People</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Red`);handleCategory();">Red</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`School`);handleCategory();">School</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Science`);handleCategory();">Science</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Space`);handleCategory();">Space</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Sprituality`);handleCategory();">Spirituality</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Sport`);handleCategory();">Sport</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Street Photography`);handleCategory();">Street Photography</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Sun`);handleCategory();">Sun</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Surreal`);handleCategory();">Surreal</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Technology`);handleCategory();">Technology</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Textures & Patterns`);handleCategory();">Textures & Patterns</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Travel`);handleCategory();">Travel</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Trees`);handleCategory();">Trees</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Tractor`);handleCategory();">Tractor</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Truck`);handleCategory();">Truck</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`White`);handleCategory();">White</a></li>
            <li><a class="badger" onclick="$(`.unsplash-search-input`).val(`Yellow`);handleCategory();">Yellow</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="row unsplash-search-results m-1"></div>
    <div class="unsplash-pag">
      <button class="d-none unsplash-prev-btn">Previous page</button>
      <button class="d-none unsplash-next-btn">Next page</button>
    </div>
  </div>
  <script>
    $('.unsplash-left').click(function(){
      $(".unsplash-cat-list-container").animate({scrollLeft: "-=300px"});
    });
    $('.unsplash-right').click(function(){
      $(".unsplash-cat-list-container").animate({scrollLeft: "+=300px"});
    });
    const form=document.querySelector('.unsplash-form');
    form.addEventListener('submit',handleSubmit);
    const nextBtn=document.querySelector('.unsplash-next-btn');
    const prevBtn=document.querySelector('.unsplash-prev-btn');
    let resultStats=document.querySelector('.unsplash-result-stats');
    let totalResults;
    let currentPage=1;
    let searchQuery;
    const apiKey="<?=$config['unsplash_publickey'];?>";
    nextBtn.addEventListener('click',()=>{
      currentPage+=1;
      fetchResults(searchQuery);
    });
    prevBtn.addEventListener('click',()=>{
      currentPage-=1;
      fetchResults(searchQuery);
    });
    function pagination(totalPages){
      nextBtn.classList.remove('d-none');
      if(currentPage>=totalPages){
        nextBtn.classList.add('d-none');
      }
      prevBtn.classList.add('d-none');
      if(currentPage!==1){
        prevBtn.classList.remove('d-none');
      }
    }
    async function fetchResults(searchQuery){
      try{
        const results=await searchUnsplash(searchQuery);
        pagination(results.total_pages);
        displayResults(results);
      }catch(err){
        alert('Failed to search Unsplash');
      }
    }
    function handleSubmit(event){
      event.preventDefault();
      currentPage=1;
      const inputValue=document.querySelector('.unsplash-search-input').value;
      searchQuery=inputValue.trim();
      fetchResults(searchQuery);
    }
    function handleCategory(event){
      currentPage=1;
      const inputValue=document.querySelector('.unsplash-search-input').value;
      searchQuery=inputValue.trim();
      fetchResults(searchQuery);
    }
    async function searchUnsplash(searchQuery){
      const endpoint=`https://api.unsplash.com/search/photos?query=${searchQuery}&per_page=28&page=${currentPage}&client_id=${apiKey}`;
      const response=await fetch(endpoint);
      if(!response.ok){
        throw Error(response.statusText);
      }
      const json=await response.json();
      return json;
    }
    function displayResults(json){
      const searchResults=document.querySelector('.unsplash-search-results');
      searchResults.textContent='';
      json.results.forEach(result=>{
        const iid=result.id;
        const regular=result.urls.regular;
        const thumb=result.urls.thumb;
        const downloadtrigger=result.links.download_location;
        const alt=result.alt_description != null ? result.alt_description : '';
        const unsplashLink=result.links.html;
        const photographer=result.user.name;
        const photographerPage=result.user.links.html;
        searchResults.insertAdjacentHTML(
          'beforeend',
          `<a id="unsplash_${iid}" class="col-12 col-sm-3" data-alt="${alt}" data-name="${photographer}" data-url="${photographerPage}?utm_source=<?=$config['unsplash_appname'];?>&utm_medium=referral" data-thumb="${thumb}" onclick="addUnsplash('${iid}','<?=$r['id'];?>','<?=$tbl;?>','<?=$col;?>','${regular}','${downloadtrigger}');">
          <img src="${regular}">
          <div>${alt}<br>by ${photographer}</div>
          </a>`
        );
      });
      totalResults=json.total;
      resultStats.textContent=`${totalResults} results for`;
    };
    function addUnsplash(iid,id,t,c,da,dt){
      da=da.substring(0,da.indexOf('?'));
      if(t=='note-image-url'){
        da=da+'?w=<?=$config['mediaMaxWidth'];?>&utm_source=<?=$config['unsplash_appname'];?>&utm_medium=referral';
        $('.note-image-url').val(da);
        var alt=$('.note-image-alt').val();
        if(alt==''){
          $('.note-image-alt').val($('#unsplash_'+iid).data('alt') + ' by ' + $('#unsplash_'+iid).data('name'));
        }
        $('.note-image-btn').removeAttr("disabled");
      }else if(t=='note-imageAttributes-src'){
        da=da+'?w=<?=$config['mediaMaxWidth'];?>&utm_source=<?=$config['unsplash_appname'];?>&utm_medium=referral';
        $('.note-imageAttributes-src').val(da);
        var alt=$('.note-imageAttributes-alt').val();
        if(alt==''){
          $('.note-imageAttributes-alt').val($('#unsplash_'+iid).data('alt') + ' by ' + $('#unsplash_'+iid).data('name'));
        }
        var caption=$('.note-imageAttributes-caption').val();
        if(caption==''){
          $('.note-imageAttributes-caption').val($('#unsplash_'+iid).data('alt') + ' by ' + $('#unsplash_'+iid).data('name'));
        }
      }else if(t=='loginimage'){
        da=da+'?w=1900&utm_source=<?=$config['unsplash_appname'];?>&utm_medium=referral';
        $('#limage').val(da);
        $('#lit').val($('#unsplash_'+iid).data('alt'));
        $('#lia').val($('#unsplash_'+iid).data('name'));
        $('#liau').val($('#unsplash_'+iid).data('url'));
        $('#lisu').val($('#unsplash_'+iid).data('url'));
        $('#lis').val('Unsplash');
      }else{
        if(c=='thumb'){
          da=da+'?w=<?=$config['mediaMaxWidthThumb'];?>&utm_source=<?=$config['unsplash_appname'];?>&utm_medium=referral';
        }else{
          var da2=da+'?w=<?=$config['mediaMaxWidthThumb'];?>&utm_source=<?=$config['unsplash_appname'];?>&utm_medium=referral';
          da=da+'?w=<?=$config['mediaMaxWidth'];?>&utm_source=<?=$config['unsplash_appname'];?>&utm_medium=referral';
        }
        $('#'+c).val(da);
        $('#'+c+'image').attr('src',da);
        $('[data-fancybox="'+c+'"]').attr('href',da);
        $('[data-imageeditor="edit'+c+'"]').data('image',da);
        $('[data-imageeditor="edit'+c+'"]').data('name',$('#unsplash_'+iid).data('name'));
        $('#save'+c).addClass('btn-danger');
        $('#'+c).addClass('unsaved');
        if(c=='file'){
          $('#'+c).val(da);
          $('#'+c+'image').attr('src',da);
          <?php if($config['mediaOptions'][1]==1){?>
            if($('#thumb').length>0){
              $('#thumb').val(da2);
              $('#thumbimage').attr('src',da2);
              $('[data-fancybox="thumb"]').attr('href',da2);
              $('[data-imageeditor="editthumb"]').data('image',da2);
              $('#savethumb').addClass('btn-danger');
              $('#thumb').addClass('unsaved');
            }
          <?php }?>
        }
        if(c!='thumb'){
          $('[data-el="fileALT"]').text($('#unsplash_'+iid).data('alt'));
          $('#fileALT').val($('#unsplash_'+iid).data('alt'));
          $('#savefileALT').addClass('btn-danger');
          $('#fileALT').addClass('unsaved');
          $('#attributionImageTitle').val($('#unsplash_'+iid).data('alt'));
          $('#saveattributionImageTitle').addClass('btn-danger');
          $('#attributionImageTitle').addClass('unsaved');
          $('#attributionImageName').val($('#unsplash_'+iid).data('name'));
          $('#saveattributionImageName').addClass('btn-danger');
          $('#attributionImageName').addClass('unsaved');
          $('#attributionImageURL').val($('#unsplash_'+iid).data('url'));
          $('#saveattributionImageURL').addClass('btn-danger');
          $('#attributionImageURL').addClass('unsaved');
        }
        $.ajax({
          type:"GET",
          url:dt,
          data:{
            client_id:'<?=$config['unsplash_publickey'];?>'
          }
        }).done(function(){});
        $('.saveall').addClass('btn-danger');
        unsaved=true;
      }
      parent.jQuery.fancybox.close();
    }
  </script>
<?php }else{
  echo'<script>'.
    ($config['unsplash_publickey']==''?'toastr["error"](`The Unsplash API Public Key is not set!`);':'').
    ($config['unsplash_secretkey']==''?'toastr["error"](`The Unsplash API Secret Key is not set!`);':'').
    'parent.jQuery.fancybox.close();'.
  '</script>';
}
