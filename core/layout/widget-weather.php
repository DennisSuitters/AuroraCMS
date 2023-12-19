<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Administration - Dashboard - Widget - SEOLinks
 * @package    core/layout/widget-seolinks.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.2.26-1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */?>
<div class="item m-0 p-0 col-12 col-sm-12 col-md-12 col-lg-7 col-xl-6 col-xxl-4" id="l_<?=$rw['id'];?>">
  <div id="weather-background" class="alert widget-weather background m-3 p-0">
    <div class="toolbar px-2 py-1 bg-transparent handle">
      <div class="btn-group">
        <button id="refreshButton" class="btn btn-sm btn-ghost" data-tooltip="left" aria-label="Refresh"><i class="i i-color-white i-spin">refresh</i></button>
        <button class="btn btn-sm btn-ghost close-widget" data-dbid="<?=$rw['id'];?>" data-dbref="dashboard" data-tooltip="left" aria-label="Close"><i class="i i-color-white">close</i></button>
      </div>
    </div>
    <div class="container m-0 p-0 position-relative">
      <div id="current-weather">
        <div class="row">
          <div class="col-12">
            <h5><span id="cityName"></span>, <span id="cityCode"></span></h5>
          </div>
        </div>
        <div class="row">
          <div class="col-6 col-sm-4 text-center justify-content-center">
            <p style="font-size: 1rem">
              <span id="mainTemperature"></span>°C
            </p>
            <span id="tempDescription" class="mt-0"></span>
          </div>
          <div class="col-6 col-sm-4 text-center justify-content-center">
            <i class="i" id="main-icon"></i>
          </div>
          <div class="col-12 col-sm-4 mt-3 mt-sm-0 text-right">
            <div class="row">
              <div class="col-6 col-sm-12 side-weather-info">
                <h6>Humidity: <span id="humidity">N/A</span>%</h6>
              </div>
              <div class="col-6 col-sm-12 side-weather-info">
                <h6>Wind: <span id="wind">N/A</span> m/s</h6>
              </div>
              <div class="col-6 col-sm-12 side-weather-info">
                <h6>Feels Like: <span id="mainFeelsLike">N/A</span>°</h6>
              </div>
              <div class="col-6 col-sm-12 side-weather-info">
                <h6>Sunrise: <span id="mainSunrise"></span></h6>
              </div>
              <div class="col-6 col-sm-12 side-weather-info">
                <h6>Sunset: <span id="mainSunset"></span></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid m-0 p-0">
        <div class="row m-0 p-0">
          <div id="forecast-tooltip-1" class="col-6 col-sm-3 day-weather-box" data-tooltip="tooltip" aria-label="N/A">
            <div class="col-12 day-weather-inner-box">
              <div class="row">
                <div class="col-12 d-block small pl-2" id="forecast-day-1-name"></div>
                <div class="col-5 forecast-main text-left">
                  <span id="forecast-day-1-main"></span>°
                </div>
                <div class="col-4">
                  <i class="i i-4x forecast-icon" id="forecast-day-1-icon"><i class="i i-color-white i-spin">refresh</i></i>
                </div>
                <div class="col-3 forecast-min-low text-right">
                  <span class="high-temperature" id="forecast-day-1-ht"></span><br>
                  <span class="low-temperature" id="forecast-day-1-lt"></span>
                </div>
              </div>
            </div>
          </div>
          <div id="forecast-tooltip-2" class="col-6 col-sm-3 day-weather-box" data-tooltip="tooltip" aria-label="N/A">
            <div class="col-12 day-weather-inner-box">
              <div class="row">
                <div class="col-12 d-block small pl-2" id="forecast-day-2-name"></div>
                <div class="col-5 forecast-main text-left">
                  <span id="forecast-day-2-main"></span>°
                </div>
                <div class="col-4">
                  <i class="i i-4x forecast-icon" id="forecast-day-2-icon"><i class="i i-color-white i-spin">refresh</i></i>
                </div>
                <div class="col-3 forecast-min-low text-right">
                  <span class="high-temperature" id="forecast-day-2-ht"></span><br>
                  <span class="low-temperature" id="forecast-day-2-lt"></span>
                </div>
              </div>
            </div>
          </div>
          <div id="forecast-tooltip-3" class="col-6 col-sm-3 day-weather-box" data-tooltip="tooltip" aria-label="N/A">
            <div class="col-12 day-weather-inner-box">
              <div class="row">
                <div class="col-12 d-block small pl-2" id="forecast-day-3-name"></div>
                <div class="col-5 forecast-main text-left">
                  <span id="forecast-day-3-main"></span>°
                </div>
                <div class="col-4">
                  <i class="i i-4x forecast-icon" id="forecast-day-3-icon"><i class="i i-color-white i-spin">refresh</i></i>
                </div>
                <div class="col-3 forecast-min-low text-right">
                  <span class="high-temperature" id="forecast-day-3-ht"></span><br>
                  <span class="low-temperature" id="forecast-day-3-lt"></span>
                </div>
              </div>
            </div>
          </div>
          <div id="forecast-tooltip-4" class="col-6 col-sm-3 day-weather-box" data-tooltip="tooltip" aria-label="N/A">
            <div class="col-12 day-weather-inner-box">
              <div class="row">
                <div class="col-12 d-block small pl-2" id="forecast-day-4-name"></div>
                <div class="col-5 forecast-main text-left">
                  <span id="forecast-day-4-main"></span>°
                </div>
                <div class="col-4">
                  <i class="i i-4x forecast-icon" id="forecast-day-4-icon"><i class="i i-color-white i-spin">refresh</i></i>
                </div>
                <div class="col-3 forecast-min-low text-right">
                  <span class="high-temperature" id="forecast-day-4-ht"></span>
                  <span class="low-temperature" id="forecast-day-4-lt"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div style="position:absolute;top:0;right:0;bottom:0;left:0;background-color:rgba(0,0,0,.75);" class="justify-content-center p-5 d-none" id="protocol-modal">
      <p class="text-white">Due to weather api restrictions, data can only be shown via HTTP request.</p>
      <p class="text-white">Sorry for the inconvenience.</p>
      <?=($config['geo_weatherAPI']==''?'<p class="text-danger small">There is no API Key added for <a class="text-danger" target="_blank" href="https://openweathermap.org/">Open Weather Map</a></p><p class="small">Once obtained, enter key at <a class="text-white" href="'.URL.$settings['system']['admin'].'/interface/settings#tab1-3">Settings > Interface > API Key</a></p>':'');?>
    </div>
  </div>
</div>
<script>
  var weatherIconsMap={"01d":"weather-day-sunny","01n":"weather-night-clear","02d":"weather-day-cloudy","02n":"weather-night-cloudy","03d":"weather-cloud","03n":"weather-cloud","04d":"weather-cloudy","04n":"weather-cloudy","09d":"weather-showers","09n":"weather-showers","10d":"weather-day-hail","10n":"weather-night-hail","11d":"weather-thunderstorm","11n":"weather-thunderstorm","13d":"weather-snow","13n":"weather-snow","50d":"weather-fog","50n":"weather-fog"};
  $(function(){
    <?php if($config['geo_weatherAPI']!=''){?>
      getClientPosition();
    <?php }else{?>
      $('#protocol-modal').removeClass('d-none');
    <?php }?>
  });
  function getClientPosition(){
    <?php if($config['geo_position']!=''){
      $geo=explode(',',$config['geo_position']);?>
      getWeatherData(<?=$geo['0'];?>,<?=$geo[1]?>);
    <?php }else{?>
      $.getJSON("https://ipapi.co/json/",function(position){
        getWeatherData(position.latitude,position.longitude);
      });
    <?php }?>
  }
  function getWeatherData(latitude,longitude){
    $.ajax({
      type:"GET",
      url:"https://api.openweathermap.org/data/2.5/weather?lat="+latitude+"&lon="+longitude+"&exclude=minutely,hourly&units=metric&appid=<?=$config['geo_weatherAPI'];?>",
      cache:true,
      success:function(forecast){
        globalForecast=forecast;
        updateCurrent(forecast);
      },
      error:function(error){
        $("#refreshButton i").removeClass('i-spin');
        $('#protocol-modal').removeClass('d-none');
        console.log("Error with ajax: "+error);
      }
    });
    $.ajax({
      type:"GET",
      url:"https://api.openweathermap.org/data/2.5/onecall?lat="+latitude+"&lon="+longitude+"&units=metric&appid=<?=$config['geo_weatherAPI'];?>",
      cache:true,
      success:function(forecast){
        globalForecast=forecast;
        updateDaily(forecast);
        $("#refreshButton i").removeClass('i-spin');
      },
      error:function(error){
        $("#refreshButton i").removeClass('i-spin');
        $('#protocol-modal').removeClass('d-none');
        console.log("Error with ajax: "+error);
      }
    });
  }
  function updateCurrent(forecast){
    $("#weather-background").addClass(forecast.weather[0].main);
    if(forecast.weather[0].icon.indexOf('n') > -1){
      $("#weather-background").addClass('night');
    }else{
      $("#weather-background").removeClass('night');
    }
    $("#cityName").text(forecast.name);
    $("#cityCode").text(forecast.sys.country);
    $("#tempDescription").text(toCamelCase(forecast.weather[0].description));
    $("#humidity").text(forecast.main.humidity);
    $("#wind").text(forecast.wind.speed);
    $("#main-icon").text(weatherIconsMap[forecast.weather[0].icon]);
    $("#mainTemperature").text(Math.round(forecast.main.temp));
    $('#mainSunrise').text(getFormattedTime(forecast.sys.sunset));
    $('#mainSunset').text(getFormattedTime(forecast.sys.sunrise));
    $("#mainTempHot").text(Math.round(forecast.main.temp_max));
    $("#mainTempLow").text(Math.round(forecast.main.temp_min));
    $("#mainFeelsLike").text(Math.round(forecast.main.feels_like));
  }
  function updateDaily(forecast){
    for(var i=1;i<(forecast.daily).length;i++){
      var day=forecast.daily[i];
      var dayName=getFormattedDate(day.dt).split(',')[0];
      var weatherIcon=weatherIconsMap[day.weather[0].icon];
      $("#forecast-tooltip-"+i).attr('aria-label',toCamelCase(day.weather[0].description));
      $("#forecast-day-"+i+"-name").text(dayName);
      $("#forecast-day-"+i+"-icon").text('');
      $("#forecast-day-"+i+"-icon").text(weatherIcon);
      $("#forecast-day-"+i+"-main").text(Math.round(day.temp.day));
      $("#forecast-day-"+i+"-ht").text(Math.round(day.temp.max));
      $("#forecast-day-"+i+"-lt").text(Math.round(day.temp.min));
    }
  }
  $("#refreshButton").on("click",function(){
    $("#refreshButton i").addClass('i-spin');
    getClientPosition();
  });
  function getFormattedDate(date){
    var options={weekday:'long',year:'numeric',month:'long',day:'numeric'};
    return new Date(date * 1000).toLocaleDateString("en-US",options);
  }
  function getFormattedTime(ti){
    var a=new Date(ti*1000);
     var hour=a.getUTCHours();
     var min=a.getUTCMinutes();
     var time=hour+':'+min;
     return time;
  }
  function toCamelCase(str){
    var splitStr=str.toLowerCase().split(' ');
    for(var i=0;i<splitStr.length;i++){
      splitStr[i]=splitStr[i].charAt(0).toUpperCase()+splitStr[i].substring(1);
    }
    return splitStr.join(' ');
  }
</script>
