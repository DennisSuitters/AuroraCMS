function filterTextInput(){
  var input,radios,radio_filter,text_filter,td0,i,divList;
  input=document.getElementById("filter-input");
  text_filter=input.value.toUpperCase();
  divList=$(".card-list");
  for(i=0;i < divList.length;i++){
    td0=divList[i].getAttribute('data-content');
    if(td0){
      if(td0.toUpperCase().indexOf(text_filter) > -1){
        divList[i].style.display="";
      }else{
        divList[i].style.display="none";
      }
    }
  }
}
function filterTextInput2(){
  var input,radios,radio_filter,text_filter,td0,i,divList;
  input=document.getElementById("filter-input");
  text_filter=input.value.toUpperCase();
  divList=$(".chatListItem");
  for(i=0;i < divList.length;i++){
    td0=divList[i].getAttribute('data-content');
    if(td0){
      if(td0.toUpperCase().indexOf(text_filter) > -1){
        divList[i].style.display="";
      }else{
        divList[i].style.display="none";
      }
    }
  }
}
