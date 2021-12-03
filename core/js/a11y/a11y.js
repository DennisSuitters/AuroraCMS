document.addEventListener('mousemove',({pageY:h})=>document.documentElement.style.setProperty('--a11y-adhd-border-pos',`${h}px`));
var aFS=localStorage.getItem("a11y-font-size");
var aG=localStorage.getItem("a11y-grayscale");
var aSS=localStorage.getItem("a11y-seizure-safe");
var aAF=localStorage.getItem("a11y-adhd-friendly");
var aDF=localStorage.getItem("a11y-dyslexic-friendly");
var aHC=localStorage.getItem("a11y-high-contrast");
var aNC=localStorage.getItem("a11y-negative-contrast");
var aLB=localStorage.getItem("a11y-light-background");
var aLU=localStorage.getItem("a11y-links-underline");
var aRF=localStorage.getItem("a11y-readable-font");
if(aFS!==null){
  if(aFS > 100 || aFS < 201){document.querySelector("body").classList.add("a11y-resize-font-"+aFS);}
}
if(aSS==="true"){
  document.querySelector("body").classList.add("a11y-seizure-safe");
  document.querySelector(".a11y-btn-seizure-safe").classList.add('active');
}
if(aAF==="true"){
  document.querySelector("body").classList.add("a11y-adhd-friendly");
  document.querySelector(".a11y-btn-adhd-friendly").classList.add('active');
}
if(aDF==="true"){
  document.querySelector("body").classList.add("a11y-dyslexic-friendly");
  document.querySelector(".a11y-btn-dyslexic-friendly").classList.add('active');
}
if(aG==="true"){
  document.querySelector("body").classList.add("a11y-grayscale");
  document.querySelector(".a11y-btn-grayscale").classList.add('active');
}
if(aHC==="true"){
  document.querySelector("body").classList.add("a11y-high-contrast");
  document.querySelector(".a11y-btn-high-contrast").classList.add('active');
}
if(aNC==="true"){
  document.querySelector("body").classList.add("a11y-negative-contrast");
  document.querySelector(".a11y-btn-negative-contrast").classList.add('active');
}
if(aLB==="true"){
  document.querySelector("body").classList.add("a11y-light-background");
  document.querySelector(".a11y-btn-light-background").classList.add('active');
}
if(aLU==="true"){
  document.querySelector("body").classList.add("a11y-links-underline");
  document.querySelector(".a11y-btn-links-underline").classList.add('active');
}
if(aRF==="true"){
  document.querySelector("body").classList.add("a11y-readable-font");
  document.querySelector(".a11y-btn-readable-font").classList.add('active');
}
document.addEventListener('click',function(event){
  if(event.target.closest(".a11y-toolbar-toggle-link")){
    event.preventDefault();
    document.querySelector("#a11y-toolbar").classList.toggle("a11y-toolbar-open");
    var tI=document.querySelectorAll(".a11y-toolbar-link");
    tI.forEach(function(tIItem){
      var tIS=tIItem.getAttribute("tabindex");
      tIItem.setAttribute("tabindex",(tIS=='0'?'-1':'0'));
    });
    return false;
	}
  if(event.target.closest(".a11y-toolbar-link")){
    event.preventDefault();
    var action=event.target.closest(".a11y-toolbar-link").getAttribute("data-action");
    if(action==='resize-plus'){
      var aFS=localStorage.getItem("a11y-font-size");
      console.log(aFS);
      if(aFS===null)aFS=110;
      if(aFS){
        aFS = parseFloat(aFS) + parseFloat(10);
        if(aFS<120)aFS=120;
        if(aFS>200)aFS=200;
        document.querySelector("body").classList.remove("a11y-resize-font-0");
        document.querySelector("body").classList.remove("a11y-resize-font-120");
        document.querySelector("body").classList.remove("a11y-resize-font-130");
        document.querySelector("body").classList.remove("a11y-resize-font-140");
        document.querySelector("body").classList.remove("a11y-resize-font-150");
        document.querySelector("body").classList.remove("a11y-resize-font-160");
        document.querySelector("body").classList.remove("a11y-resize-font-170");
        document.querySelector("body").classList.remove("a11y-resize-font-180");
        document.querySelector("body").classList.remove("a11y-resize-font-190");
        document.querySelector("body").classList.remove("a11y-resize-font-200");        document.querySelector("body").classList.add("a11y-resize-font-"+aFS);
        localStorage.setItem("a11y-font-size",aFS);
      }
      return false;
    }
    if(action==='resize-minus'){
      var aFS=localStorage.getItem("a11y-font-size");
      console.log(aFS);
      if(aFS){
        aFS -= 10;
        if(aFS<120){
          aFS = 0;
        }
        if(aFS>200){
          aFS = 200;
        }
        document.querySelector("body").classList.remove("a11y-resize-font-0");
        document.querySelector("body").classList.remove("a11y-resize-font-120");
        document.querySelector("body").classList.remove("a11y-resize-font-130");
        document.querySelector("body").classList.remove("a11y-resize-font-140");
        document.querySelector("body").classList.remove("a11y-resize-font-150");
        document.querySelector("body").classList.remove("a11y-resize-font-160");
        document.querySelector("body").classList.remove("a11y-resize-font-170");
        document.querySelector("body").classList.remove("a11y-resize-font-180");
        document.querySelector("body").classList.remove("a11y-resize-font-190");
        document.querySelector("body").classList.remove("a11y-resize-font-200");
        document.querySelector("body").classList.add("a11y-resize-font-"+aFS);
        localStorage.setItem("a11y-font-size",aFS);
      }
      return false;
    }
    if(action==='reset'){
      var aB=document.querySelectorAll(".a11y-toolbar-link");
      aB.forEach(function(aBA){
        aBA.classList.remove('active');
      });
      event.target.closest(".a11y-toolbar-link").classList.remove("active");
      document.querySelector("body").classList.remove("a11y-resize-font-0");
      document.querySelector("body").classList.remove("a11y-resize-font-120");
      document.querySelector("body").classList.remove("a11y-resize-font-130");
      document.querySelector("body").classList.remove("a11y-resize-font-140");
      document.querySelector("body").classList.remove("a11y-resize-font-150");
      document.querySelector("body").classList.remove("a11y-resize-font-160");
      document.querySelector("body").classList.remove("a11y-resize-font-170");
      document.querySelector("body").classList.remove("a11y-resize-font-180");
      document.querySelector("body").classList.remove("a11y-resize-font-190");
      document.querySelector("body").classList.remove("a11y-resize-font-200");
      localStorage.removeItem("a11y-seizure-safe");
      document.querySelector("body").classList.remove("a11y-seizure-safe");
      localStorage.removeItem("a11y-adhd-friendly");
      document.querySelector("body").classList.remove("a11y-adhd-friendly");
      localStorage.removeItem("a11y-dyslexic-friendly");
      document.querySelector("body").classList.remove("a11y-dyslexic-friendly");
      localStorage.removeItem("a11y-font-size");
      document.querySelector("body").classList.remove("a11y-grayscale");
      localStorage.removeItem("a11y-grayscale");
      document.querySelector("body").classList.remove("a11y-high-contrast");
      localStorage.removeItem("a11y-high-contrast");
      document.querySelector("body").classList.remove("a11y-negative-contrast");
      localStorage.removeItem("a11y-negative-contrast");
      document.querySelector("body").classList.remove("a11y-light-background");
      localStorage.removeItem("a11y-light-background");
      document.querySelector("body").classList.remove("a11y-links-underline");
      localStorage.removeItem("a11y-links-underline");
      document.querySelector("body").classList.remove("a11y-readable-font");
      localStorage.removeItem("a11y-readable-font");
    }else{
      event.target.closest(".a11y-toolbar-link").classList.toggle("active");
      document.querySelector("body").classList.toggle("a11y-"+action);
      var lSC=localStorage.getItem("a11y-"+action);
      if(lSC==="true"){
        localStorage.removeItem("a11y-"+action);
      }else{
        localStorage.setItem("a11y-"+action,true);
      }
    }
  }
});
