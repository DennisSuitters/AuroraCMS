/*
 fullcalendar-rightclick v1.7
 Docs & License: https://github.com/mherrmann/fullcalendar-rightclick
 (c) 2015 Michael Herrmann
*/
(function(g){function e(d){d=d["class"]||d;var e="render"in d.prototype?"render":"renderDates",f=d.prototype[e];d.prototype[e]=function(){f.call(this);this.el.data("fullcalendar-rightclick")||(this.registerRightclickListener(),this.el.data("fullcalendar-rightclick",!0))};d.prototype.registerRightclickListener=function(){var b=this;this.el.on("contextmenu",function(c){var a=g(c.target).closest(".fc-event");if(a.length)return a=a.data("fc-seg"),b.trigger("eventRightclick",this,a.event,c);if(g(c.target).closest(".fc-bg, .fc-slats, .fc-content-skeleton, .fc-bgevent-skeleton").length&&
(b.coordMap?(b.coordMap.build(),a=b.coordMap.getCell(c.pageX,c.pageY)):(b.prepareHits(),a=b.queryHit(c.pageX,c.pageY),a=b.getHitSpan(a)),a))return b.trigger("dayRightclick",null,a.start,c)})}}var f=g.fullCalendar;e(f.views.agenda);e(f.views.basic)})(jQuery);
