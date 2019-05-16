
window.addEventListener('DOMContentLoaded',function(){
  new SmartPhoto(".js-smartphoto");
});


document.body.onload = function (){

    calibrateTabNav();
    this.addEventListener('swipeleft',function(e){ swipeLeft(); });
    this.addEventListener('swiperight',function(e){ swipeRight();  });
    this.addEventListener('resize',function(e){ calibrateTabNav();  });

    tippy();
    if(document.querySelectorAll('.has-tip').length > 0) tippy('.has-tip',{});

    if((money = document.querySelectorAll('.money')).length > 0){
      for(var i=0; i<money.length; i++){
          money[i].innerHTML = parseInt(money[i].innerHTML).toMoney(0);
      }
    }

    if((thumbnail_creators = document.querySelectorAll('.thumbnail-creator')).length > 0){
      for(var i=0; i<thumbnail_creators.length; i++){
         if(thumbnail_creators[i].getAttribute('data-event') =='onchange'){
            thumbnail_creators[i].onchange = function () {
              createThumbnail(this,document.querySelector(this.getAttribute('data-display')));
            };
         }
      }
    }

    if((centered_items = document.querySelectorAll('.centered-item-js')).length > 0){
      for(var i=0; i<centered_items.length; i++){
          centerItem(centered_items[i],centered_items[i].parentNode);
      }
    }

    // attach a click event to elements, to toggle targeted inputs readonly / editable
    if((editable_triggers = document.querySelectorAll('.toggle-editable')).length > 0){
      for(var i=0; i<editable_triggers.length; i++){
          editable_triggers[i].onclick = function () {
            toggleEditableAll(document.querySelectorAll('.'+this.getAttribute('data-inputs')));
          };
      }
    }

    // attach a click event to elements, to toggle targeted inputs readonly / editable
    // a cloner should have: data-field & data-parent -> field to be clone and clone parent
    // clone the first field with the class defined in the .clone-field element
    if((cloners = document.querySelectorAll('.clone-field')).length > 0){
      for(var i=0; i<cloners.length; i++){
          cloners[i].onclick = function () {
              manageCloning(this);
          };
      }
    }

    if((option_checkbox = document.querySelectorAll('.option-checkbox')).length > 0){
      for(var i=0; i<option_checkbox.length; i++){
          option_checkbox[i].onchange = function () {
            manageOption(this);
          };
      }
    }

    //clone the prime transaction group fields by forging a click event on the cloners
    if((cloners = document.querySelectorAll('.simulate-cloner')).length > 0){
      for(var i=0; i<cloners.length; i++){
         triggerEvent(getViaAttr(cloners[i],'data-cloner'),'click');
      }
    }

}
