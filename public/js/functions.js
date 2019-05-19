
function getAttr(element,atr){
	if((value = element.getAttribute(atr)) == null) return false;
	return value;
}

// shift element on smaller devices and return if resized
function manageShiftOnSmall(shifted){
		if(getContentWidth() <= sm) {
			//implement the shift to another parent on small devices
			if((show = document.querySelectorAll('.show-on-small')).length >=1){
				for (var i=0; i<show.length; i++){
					show[i].style.display= (form = show[i].getAttribute('data-display'))? form:'flex';
				}
			}
			if(parent = getViaAttr(shifted,'data-small-parent') ) {
					parent.appendChild(shifted);
			}
			return null;
		}

		if(node = getViaAttr(shifted,'data-return-before')) {
			node.parentNode.insertBefore(shifted,node);
		}

		if((show = document.querySelectorAll('.show-on-small')).length >=1){
			for (var i=0; i<show.length; i++){
					show[i].style.display='none';
			}
		}

}

// manage the trigger which alters other elements attributes,
// the trigger has main two attributes 1: data-action & data-target
// action - just a value which affects the target's elements if their properties dont match with value
// has additional attributes: data-transaction, data-service, data-parent, data-click (to help with cloning)
function manageAction(trigger){
		var target = getViaAttr(trigger,'data-target');
		var action = trigger.getAttribute('data-action');
		//early return if no specified affected target
		if(target == null) return false;

		//deal with: .action-dependant-elements (they have: data-action which is compared to trigger's)
		 dependant_element = target.querySelector('.action-dependant-element');
		 if(dependant_element) showIf(dependant_element,dependant_element.getAttribute('data-action'),action);

		 // if no action dependant_links end here
		 dependant_links = target.querySelectorAll('.action-dependant-link');
		 if(dependant_links.length <=0 ) return false;

		 // deal with: .action-depandant-link (they alter href depending on the action)
		 // if action is not set, the links become cloners
		 for(var i=0; i<dependant_links.length; i++){
			 	makeIfCloner(dependant_links[i],action,trigger);
		  	if(action == null ) switchTag(dependant_links[i],'span');
			  if(action !=null && dependant_links[i].tagName !='A') switchTag(dependant_links[i],'a');
			  if(action !=null) setLinkTail(dependant_links[i],action);
		 }

		 // set onclick events to new cloners
		 if(action == null) setCloners();
}

// make an element a cloner if null is given else remove cloning features
function makeIfCloner(cloner,action=null,trigger=null){
	if(trigger==null) trigger = cloner;

	//pass parent & click element to cloner element
	if(parent = trigger.getAttribute('data-parent')) cloner.setAttribute('data-parent',parent);
	cloner.setAttribute("data-click",trigger.getAttribute('data-target'));

	// set clone
	if(action == null ){
		// requires :data-field & data-parent, data-field is assumed to be in the element attr
		// if cloner is a action_trigger remove the class
		if(!cloner.className.includes('clone-field')) cloner.className +=" clone-field";
		if(cloner.className.includes('action-trigger')) cloner.className = cloner.className.replace("action-trigger","");

		return 1;
	}

	// remove clone
	cloner.setAttribute("data-click","");
	if(cloner.className.includes('clone-field')) cloner.className = cloner.className.replace("clone-field","");
	cloner.onclick = function (){};
}


function switchTag(old_element,new_tag){
		var new_element = document.createElement(new_tag);
		new_element.innerHTML = old_element.innerHTML;
		new_element.href = old_element.href;
		var attr = old_element.attributes;
		for(var i=0; i<attr.length; i++){
			 new_element.setAttribute(attr[i].name,attr[i].value);
		}
		old_element.parentNode.replaceChild(new_element,old_element);
}

function showIf(element,value1,value2){
		if(value1 == value2) element.style.display = 'block';
		if(value1 != value2 || value2 == null || value1 == null) element.style.display = 'none';
}

function setLinkTail(link,value){
    if(value == null ) return false;
		var tail = link.href.split('/')[link.href.split('/').length-1];
		link.href = link.href.replace(tail,value);
}

// what is popped from selected is checked in the check boxes
function checkBox(checkbox){
		checkbox.checked=true;
		triggerEvent(checkbox);
}

function uncheckBox(checkbox){
		checkbox.checked=false;
		triggerEvent(checkbox);
}

// a cloner has two main data attributes: data-parent & data-field
// additional attributes: data-service,
function manageCloning(cloner){
		// get the main elements from the data attribute
		clone_parent = getViaAttr(cloner,'data-parent');
		field = cloneField(getViaAttr(cloner,'data-field'),clone_parent);

		updateModelField(field,cloner.getAttribute('data-model'),cloner);

		if((close_modal = getViaAttr(cloner,'data-click')) && field ) triggerEvent(close_modal,'click');

		if((checkbox = getViaAttr(cloner,'data-check')) && field ) {
				field.querySelector('.remove-field').setAttribute('data-check',getAttr(cloner,'data-check'));
				checkBox(checkbox);
		}
}

var x_options = {};
function manageOption(checkbox){
		if(!checkbox.checked){
			var parent = x_options[checkbox.id+'parent'];
			var option = x_options[checkbox.id+'option'];
			parent.insertBefore(option,parent.childNodes[0]);
			updateIndex(parent);
		}

		if(!(option = getViaAttr(checkbox,'data-option'))) return false;
		var parent = option.parentNode;

		if(checkbox.checked) {
				x_options[checkbox.id+'option'] = option;
			 	x_options[checkbox.id+'parent'] = parent;
				parent.removeChild(option);
				updateIndex(parent);
		}
}

//remove the field from the dom
function removeField(field, parent = null){
		if(parent == null) parent = field.parentNode;
		parent.removeChild(field);
		if((box = getViaAttr(field.querySelector('.remove-field'),'data-check'))) uncheckBox(box);
		updateIndex(parent);
}

// updates the indexes of the field_group items according to their current count
// SOL traverse siblings and update their indexes
function updateIndex(parent){
		if((indexes = parent.querySelectorAll('.index')).length == 0) return false;
		for(var i=0; i<indexes.length; i++){
				indexes[i].innerHTML = i+1;
		}
}

// clones a field and appends the clone to the fields parent
var nf=2; // number fo fields in the entire page
function cloneField(field, parent=null){
		if(parent==null) parent = field.parentNode;
		//clone the field
		var new_field = field.cloneNode(true);
		// try to get the a new indexed_id string from the field, return if it fails
		if(!(new_id = indexfy(field.id,nf++))) return false;
		//append and change the clone id to the indexed_id
		parent.appendChild(new_field);
		new_field.setAttribute('id',new_id);
		clearInputs(new_field);
		// sets the clone index and all the previous simblings
		updateIndex(parent);
		return new_field;
}

function getViaAttr(element,attr){
	if (element.getAttribute(attr)=="#") return null;
	return document.querySelector(element.getAttribute(attr));
}

// clears the values of element children with the class input
function clearInputs(field){
		inputs = field.querySelectorAll('.input');
		for(var i=0; i<inputs.length; i++){
			inputs[i].value="";
		}
}

// returns a field index if it follows the underscore convention
function getFieldIndex(field){
	try {
		return field.id.split('_')[1];
	}
	catch (e) {
		return false;
	}
}

//get the documents width
function getDocWidth(){
	return Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
}

function getContentWidth(){
	return parseInt(getComputedStyle(document.querySelector('#content'),null).width);
}



// sets the fields attributes to match the field instance using its index
function updateModelField(field, model, cloner = null){
	 if(!field) return false
	 // quit if field id does not following the underscore convention
	 if(!(n = getFieldIndex(field))) return false;

	 // update the essential elements of a typical field
	 indexfyAttr(field.querySelector('.remove-field'),'data-field',n);
	 field.querySelector('.remove-field').setAttribute('onclick','removeField(document.getElementById("'+field.id+'"))');
	 indexfyAttr(field.querySelector('.collapse-detail'),'data-target',n);
	 replaceClasses(field.querySelectorAll('.'+model+'-field_1'),model+'-field_1',model+'-field_'+ n);
	 changeId(field.querySelector('#collapseDetail_1'),'collapseDetail_'+ n);
	 changeId(field.querySelector('#childFields_1'),'childFields_'+ n);
	 changeId(field.querySelector('#amountField_1'),'amountField_'+ n);

	 // sync the shift & replaced elements on smaller devices
	 if((els = field.querySelectorAll('.shift-on-small')).length >=1) {
		 for(var i=0; i<els.length; i++) {
			 indexfyAttr(els[i],'data-small-parent',n);
			 indexfyAttr(els[i],'data-return-before',n);
		 }
	 }

	 if((els = field.querySelectorAll('.append-field-on-small')).length >=1) {
		 for(var i=0; i<els.length; i++) indexfyAttr(els[i],'id',n);
	 }

	 // fill the correct name of the field type, on the classes model-name
	 var model_names = field.querySelectorAll('.model-name');
	 for(var i=0; i<model_names.length; i++)	model_names[i].innerHTML = model;

	 // sync the edit toggle element with the actuall fields which are not editable by default
	 if(el = field.querySelector('.toggle-editable')) el.setAttribute('data-inputs',field.id);
	 replaceClasses(field.querySelectorAll('.not-editable'),'not-editable',field.id);
	 if(el = field.querySelector('.toggle-editable')) setToggleEditableTriggers(el);

	 // for cloned elements which are associated with a modal
	 // to sync with where to place the items after selecting an option from modal,
	 // this parent will be passed to the cloner in the modal by the manageAction -> makeIfCloner function,
	 if(el = field.querySelector('.fields-parent')) indexfyAttr(el,'id',n);
	 if(el = field.querySelector('.action-trigger')) indexfyAttr(el,'data-parent',n);

	 // pass the service type to the modal triggerer, so as to trigger the right modal
	 if(service = cloner.getAttribute("data-service")) {
			 if(el = field.querySelector('.action-trigger')) el.setAttribute("data-service",service);
			 if(el && model =="sale") configToShowModal(el);
			 if(el && model !="sale") {
					makeIfCloner(el);
			 }
	 }

	 // reset the cloners and triggers with in the cloned field
	 setCloners();
	 setTriggers();
}

function configToShowModal(button){
	if(service = button.getAttribute('data-service')){
		button.setAttribute("data-target","#"+service+"Modal");
	}
}

function hasChildClass(field,className){
		if(field.querySelectorAll('.'+className).length > 0) return true;
		return false;
}

function indexfyAttr(element,attr,index){
	if(element == null) return false;
	var value = element.getAttribute(attr);
	return changeAttr(element,attr,indexfy(value,index));
}

function changeAttr(element,attr,value){
  element.setAttribute(attr,value);
 	return element;
}

function indexfy(string,index){
		try {
			return string.split('_')[0] + "_" + index;
		}
		catch (e) {
			return false;
		}
}

function incrementStr(string){
		try {
			return string.split('_')[0] + "_" + (parseInt(string.split('_')[1])+1);
		}
		catch (e) {
			return false;
		}
}

function replaceClass(element,old_class,new_class){
		if(element == null ) return false;
		element.className = element.className.replace(old_class,new_class);
		return element;
}

function replaceClasses(elements,old_class,new_class){
		if(elements.length ==0 ) return false;
		for(var i=0; i<elements.length; i++){
				elements[i].className = elements[i].className.replace(old_class,new_class);
		}
		return elements;
}

function changeId(element,new_id){
		if(element == null ) return false;
		element.setAttribute('id',new_id);
	 	return element;
}


var toggle = 2;
function toggleEditableAll(inputs){
	if(toggle % 2 == 0){
		for(var i=0; i<inputs.length; i++){
			inputs[i].readOnly=false;
		}
	}else{
		for(var i=0; i<inputs.length; i++){
			inputs[i].readOnly=true;
		}
	}
	toggle++;
}


function triggerEvent(element, eventName = 'change'){
	var eventt = document.createEvent('HTMLEvents');
	eventt.initEvent(eventName,false,true);
	element.dispatchEvent(eventt);
}

function createThumbnail(file,display){
	var prev_thumbnails = display.querySelectorAll("thumbnail");
  var img = "";

	for(var i=0; i<prev_thumbnails.length; i++){
		prev_thumbnails[i].innerHTML = "";
    display.removeChild(prev_thumbnails[i]);
	}

	if(1){
		var x = file.files.length-1;
		create(x,file,display);
  }

	function create(i,file,display){

    	 var UploadFile =  file.files[i];
    	 var ReaderObj  =  new FileReader();

    	 ReaderObj.onloadend = function () {

      	 	var image = document.createElement("img");
      		var thumbnail = document.createElement("div");

      		thumbnail.setAttribute("class"," thumbnail ");
					image.setAttribute('class',"centered-item-js relative");
      		thumbnail.appendChild(image);


    		  display.appendChild(thumbnail);
    	    image.src  = ReaderObj.result;
    	    img = image;

    	    if(x>=0){
    	    	create(--x,file,display);
    	    }

    	  };

    	 if (UploadFile) {
    	    ReaderObj.readAsDataURL(UploadFile);
    	  } else {
    	    // img.src  = "";
    	  }
	}

}

function showThumbnail(source,display_id){

	var image = document.createElement("img");
	var thumbnail = document.createElement("div");
	var holder = document.createElement("span");
	var delete_thumb = document.createElement("div");

	holder.setAttribute("class","_thumbnail");
	image.setAttribute("class","old_image");
	thumbnail.setAttribute("class","image_thumbnail thumbnail old_thumb relative");
	delete_thumb.setAttribute("class","delete_thumb absolute");
	delete_thumb.setAttribute("onclick","deleteThumb(this.parentNode)");
	thumbnail.appendChild(image);
	thumbnail.appendChild(delete_thumb);

	holder.appendChild(thumbnail);
	document.getElementById(display_id).appendChild(holder);

	delete_thumb.innerHTML = '<i class="ti ti-trash font_icon "> </i>';

	if(source.toString().search("images")>0){
		image.src  = source;
	}

}

function deleteThumb(thumb){
	thumb.parentNode.innerHTML="";
}


function createIconThumbnail(file,display){
   var prev_thumbnail = document.getElementsByClassName(display+"icon_thumbnail");

	for(var i=0; i<prev_thumbnail.length; i++){
		prev_thumbnail[i].innerHTML = "";
	}

	var image = document.createElement("img");
	var thumbnail = document.createElement("div");
	var holder = document.createElement("span");
	holder.setAttribute("class",display+"icon_thumbnail");
	thumbnail.setAttribute("class","icon_thumbnail thumbnail");
	thumbnail.appendChild(image);

	holder.appendChild(thumbnail);
	document.getElementById(display).appendChild(holder);

	var source = file;

	if(source.toString().search("images")>0){
		image.src  = source;
		return;
	}else{
		  var UploadFile    =  file.files[0];
	 	  var ReaderObj  =  new FileReader();
	      ReaderObj.onloadend = function () {
	         image.src  = ReaderObj.result;
	      };
	      if (UploadFile) {
	          ReaderObj.readAsDataURL(UploadFile);
		  } else {

		  }
	}
}

function centerItem(item, parent = document.body){
	var view_width = parseInt(getComputedStyle(parent,null).width);
	var view_height = parseInt(getComputedStyle(document.body,null).height);
	var item_width = parseInt(getComputedStyle(item,null).width);

	if(view_width < item_width) {
		item.style.left=(view_width-item_width)/2+"px";
	}else {
		item.style.left="0px";
	}
}


function centerItems(items, parent = document.body){
	var view_width = parseInt(getComputedStyle(parent,null).width);
  var view_height = parseInt(getComputedStyle(document.body,null).height);
	var item_width;
	var item_current_left;

	for(var i=0; i<items.length; i++){
		item_width = parseInt(getComputedStyle(these[i],null).width);
		if(view_width < item_width) {
			item_current_left  = parseInt(these[i].getBoundingClientRect().left);
			these[i].style.left = ((view_width-item_width)/2 - item_current_left)+"px";
		}else {
			these[i].style.left=item_current_left+"px";
		}
	}

}


function setItemSquare(item){
	var item_width ;

  item_width = getComputedStyle(item,null).width;
	item.style.height = item_width;

}


function setItemsSquare(items){
	var item_width ;

	for(var i=0; i<items.length; i++){
    item_width = getComputedStyle(items[i],null).width;
		items[i].style.height = item_width;
	}
}



function fitToAvailableDuoWidth(item,sibling){
	var view_width = parseInt(getComputedStyle(item.parentNode,null).width);
	var sibling_width = parseInt(getComputedStyle(sibling,null).width);
	var item_width = view_width - sibling_width;

	item.style.width = item_width + "px";
}


function fitToAvailableDuoHeight(item,sibling){
	var view_height = parseInt(getComputedStyle(item.parentNode,null).height);
	var sibling_height = parseInt(getComputedStyle(sibling,null).height);
	var item_height = view_height - sibling_height;
//alert(sibling_height);
	item.style.height = item_height + "px";
}


function getAverageRGB(imgEl)  {
 	var blockSize = 5, // only visit every 5 pixels
 		defaultRGB =  { r:0,g:0,b:0}, // for non-supporting envs
		canvas = document.createElement('canvas'),
		context = canvas.getContext && canvas.getContext('2d'),
		data, width, height,
		i = -4,
		length,
		rgb =  { r:0,g:0,b:0},
		count = 0 ;

	 if (!context)  {
		 return defaultRGB ;
	 }

	 height = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height ;
	 width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width ;

	 context.drawImage(imgEl, 0, 0) ;

	 try  {
		 data = context.getImageData(0, 0, width, height) ;
	 } catch(e)  {
		 /* security error, img on diff domain */ return defaultRGB ;
	 }

	 length = data.data.length ;

	 while ( (i += blockSize * 4) < length )  {
		 ++count ;
		 rgb.r += data.data[i] ;
		 rgb.g += data.data[i+1] ;
		 rgb.b += data.data[i+2] ;
	 } // ~~ used to floor values rgb.r = ~~(rgb.r/count) ;

	 rgb.g = ~~(rgb.g/count) +0;
	 rgb.b = ~~(rgb.b/count) +0;
	 rgb.r = ~~(rgb.r/count) +0;

	 return rgb;
 } //For IE, check out excanvas.


 function matchImageColor(image,subject){
	var rgb = getAverageRGB(image);
 	//	var rgb = get_average_rgb(image);
 	//	alert(rgb.r);

 	if(subject.length>=1){
 		for(var i=0; i<subject.length; i++){
 			subject[i].style.background = "rgba("+ rgb.r +"," + rgb.g +"," + rgb.b + ","+1+")";
 		}
 	}else{
 		subject.style.background = "rgba("+ rgb.r +"," + rgb.g +"," + rgb.b + ","+1+")";
 	}
 }


function invertRGB(rgb,subject_id){
	var subject = document.getElementById(subject_id);
	 rgb.g = 256 -  rgb.g ;
	 rgb.b =  256 -  rgb.g ;
	 rgb.r = 256 -  rgb.g ;

}

/*
decimal_sep: character used as deciaml separtor, it defaults to '.' when omitted
thousands_sep: char used as thousands separator, it defaults to ',' when omitted
*/
Number.prototype.toMoney = function(decimals, decimal_sep, thousands_sep)
{
   var n = this,
   c = isNaN(decimals) ? 2 : Math.abs(decimals), //if decimal is zero we must take it, it means user does not want to show any decimal
   d = decimal_sep || '.', //if no decimal separator is passed we use the dot as default decimal separator (we MUST use a decimal separator)

   /*
   according to [https://stackoverflow.com/questions/411352/how-best-to-determine-if-an-argument-is-not-sent-to-the-javascript-function]
   the fastest way to check for not defined parameter is to use typeof value === 'undefined'
   rather than doing value === undefined.
   */
   t = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep, //if you don't want to use a thousands separator you can pass empty string as thousands_sep value

   sign = (n < 0) ? '-' : '',

   //extracting the absolute value of the integer part of the number and converting to string
   i = parseInt(n = Math.abs(n).toFixed(c)) + '',

   j = ((j = i.length) > 3) ? j % 3 : 0;
   return sign + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '');
}
