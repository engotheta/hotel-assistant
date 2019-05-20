
function getAttr(element,atr){
	if((value = element.getAttribute(atr)) == null) return false;
	return value;
}

function getParentWithClass(element,classname){
		if(!element.className.includes(classname)) {
			if(element.id=='app') return null;
			return getParentWithClass(element.parentNode,classname);
		}else return element;
}

function allEqualTo(quantity_fields,number){
	all = true;
	for(var i=0; i<quantity_fields.length; i++) if(quantity_fields[i].value != number) all = false;
	return all;
}

function managePriceFieldHide(field){
		var quantity_field = field.querySelector('.quantity-field');
		if(!(transaction_group = getParentWithClass(field,'transaction-group'))) return null;
		price_fields = transaction_group.querySelectorAll(".price-field");
		quantity_fields = transaction_group.querySelectorAll(".quantity-field");

		if(quantity_field.value > 1){
			for(var i=0; i<price_fields.length; i++){
				price_fields[i].style.display = price_fields[i].getAttribute('data-display');
				price_fields[i].className.replace('show-price-if','');
			}
		}

		if(allEqualTo(quantity_fields,1) && getContentWidth() >= sm ) {
			for(var i=0; i<price_fields.length; i++){
				price_fields[i].style.display = "none";
				price_fields[i].setAttribute('data-display','flex');
				price_fields[i].setAttribute('data-transaction-group',"#"+transaction_group.id);
				if(!price_fields[i].className.includes('show-price-if')) price_fields[i].className += ' show-price-if';
			}
		}
}

function setAllReadOnly(fields,value=true){
	for(var i=0; i<fields.length; i++){
		fields[i].readOnly = value;
	}
}

function sumAllInputs(amount_fields){
  	var sum = 0;
	  for(var i=0; i<amount_fields.length; i++) sum += parseInt(amount_fields[i].value);
		return sum;
}

function sumAllHTMLs(amount_fields){
  	var sum = 0;
	  for(var i=0; i<amount_fields.length; i++) sum += parseInt(amount_fields[i].innerHTML);
		return sum;
}

function setAllHTMLs(elements,html){
	 for(var i=0; i<elements.length; i++) elements[i].innerHTML = html;
}

function updateTotalAmount(transaction_group){
		var amount_fields = transaction_group.querySelectorAll('.amount-field');
		setAllHTMLs(transaction_group.querySelectorAll('.group-total'),sumAllInputs(amount_fields));
		var service_group = getParentWithClass(transaction_group,'service-group');
		var group_totals = service_group.querySelectorAll('.group-total');
		setAllHTMLs(transaction_group.querySelectorAll('.service-total'),sumAllHTMLs(group_totals));
}

function manageFieldValue(field,group){
	 var quantity_field = group.querySelector("input.quantity-field");
	 var price_field = group.querySelector("input.price-field");
	 var amount_field = group.querySelector("input.amount-field");
	 var transaction_group = getParentWithClass(quantity_field,'transaction-group');
	 var amount_fields = transaction_group.querySelectorAll('.amount-field');
	 var quantity_fields = transaction_group.querySelectorAll('.quantity-field');
	 var value = field.value;

	 // if a quantity group is changed
	 if(field.className.includes("amount-field")){
		 	if(quantity_field.value == 1) price_field.value = amount_field.value;
	 }

	  // if a quantity group is changed then hiding of the price field is evaluated
		if(field.className.includes("quantity-field")){
			// quantity is always greater than 1 or equal
			// if quantity is set more than 1 then amount is readonly, calculated as default
			if(!(value >= 1)) field.value = 1;
			if(value > 1)	setAllReadOnly(amount_fields);
			if(price_field.value==0 && value ==1 ) price_field.value = amount_field.value;

			if(value == 1 && group.getAttribute('data-transaction-type')!='sale') {
				// if quantity is unit then amount can be edited directly, except for sale
				if(allEqualTo(quantity_fields,1)) setAllReadOnly(amount_fields,false);
				if(getContentWidth() <= sm)	amount_field.readOnly = false;
			}
			managePriceFieldHide(group);
		}

		// always amount is price * quantity
		amount_field.value =  price_field.value * quantity_field.value;
		updateTotalAmount(transaction_group);

}

function manageSaleFields(service,name_field,quantity_field,price_field,amount_field){
		name_field.readOnly = true;
		name_field.value = lastSelectedService.name;
		price_field.readOnly = true;
		price_field.value = lastSelectedService.price;
		// quantity-field -> readOnly = 1
		// price-field -> data-price = lastSelectedService.price
		// <option> toggle holiday_price -> price = data-holiday-price || data-price
		if(service == 'rooms' ) {
			quantity_field.readOnly = true;
			var parent = field.querySelector(".dropdown-menu");
			var option = document.createElement('a');
			option.setAttribute('class','dropdown-item toggle-value');
			option.innerHTML = "toggle Holiday Price";
			parent.insertBefore(option,parent.querySelector('.remove-field'));
			option.setAttribute("data-price-0",lastSelectedService.price);
			option.setAttribute("data-price-1",lastSelectedService.holiday_price);
			option.onclick = function (){ togglePrices(this)};
		}

		else if(service == 'venues' ) var venue = 0; // no sales here d
		else quantity_field.readOnly = false;	 	//  drinks & food
}

function setFieldsEvents(field){
	field.querySelector("input.quantity-field").onchange = function(){ manageFieldValue(this,field); }
	field.querySelector("input.amount-field").onchange = function(){ manageFieldValue(this,field); }
	field.querySelector("input.name-field").onchange = function(){ manageFieldValue(this,field); }
	field.querySelector("input.price-field").onchange = function(){ manageFieldValue(this,field); }
}

function setFieldsDefaults(field){
	field.querySelector("input.quantity-field").readOnly = false;
	field.querySelector("input.name-field").readOnly = false;
	field.querySelector("input.price-field").readOnly = false;
	field.querySelector("input.quantity-field").value = 1;
}

function manageTransactionField(field){
		if(!(name_field = field.querySelector("input.name-field"))) return null;
		if(!(transaction_type = field.getAttribute("data-transaction-type"))) return null;
		if(!(service = field.getAttribute("data-service"))) return null;
		var quantity_field = field.querySelector("input.quantity-field");
		var price_field = field.querySelector("input.price-field");
		var amount_field = field.querySelector("input.amount-field");

		setFieldsEvents(field);
		setFieldsDefaults(field);

	  if(transaction_type =="sale")	manageSaleFields(service,name_field,quantity_field,price_field,amount_field);

		triggerEvent(price_field,'change');
		triggerEvent(quantity_field,'change');
}

function hideAll(shown,condition = true){
	for(var i=0; i<shown.length; i++){
		var display = shown[i].getAttribute('data-display');
	  var form = display ? display:'flex';
		shown[i].style.display = condition? 'none':form;
	}
}

function hideOne(shown,condition = true){
		var display = shown.getAttribute('data-display');
	  var form = display ? display:'flex';
		shown.style.display = condition? 'none':form;
}

// shift element on smaller devices and return if resized
function manageShiftOnSmall(shifted){
		if(getContentWidth() <= sm) {
			//implement the shift to another parent on small devices
			hideAll(document.querySelectorAll('.show-on-small'),false);
			hideAll(document.querySelectorAll('.show-price-if'),false);
			if(parent = getViaAttr(shifted,'data-small-parent')) parent.appendChild(shifted);
			return null;
		}
		//return the shifted on a big view
		if(node = getViaAttr(shifted,'data-return-before')) node.parentNode.insertBefore(shifted,node);
		hideAll(document.querySelectorAll('.show-on-small'));

		// hided the price input on big screen if all group quantities are 1
		var price_fields = document.querySelectorAll('.show-price-if');
		for(var i=0; i<price_fields.length; i++){
			var quantity_fields = getViaAttr(price_fields[i],'data-transaction-group').querySelectorAll('.quantity-field');
			if(allEqualTo(quantity_fields,1)) hideOne(price_fields[i]);
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
			var x = (action == null )? switchTag(dependant_links[i],'span'):setLinkTail(dependant_links[i],action);
		  if(action !=null && dependant_links[i].tagName !='A') switchTag(dependant_links[i],'a');
		}
		// if action is set, show the hidden options and viceversa
		var x = (action !=null) ? enforceSelectRepeat('block'):enforceSelectRepeat('none');
		// set onclick events to new cloners
		if(action == null) setCloners();
}

// make an element a cloner if null is given else remove cloning features
function makeIfCloner(cloner,action=null,trigger=null){
	if(trigger==null) trigger = cloner;
	//pass parent & click element to cloner element
	if(parent = trigger.getAttribute('data-parent')) cloner.setAttribute('data-parent',parent);
	if(parent = trigger.getAttribute('data-service')) cloner.setAttribute('data-service',parent);
	if(transaction = trigger.getAttribute('data-transaction-type')) cloner.setAttribute('data-transaction-type',transaction);
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
		for(var i=0; i<attr.length; i++) new_element.setAttribute(attr[i].name,attr[i].value);
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

function enforceSelectRepeat(display){
		if((selected = document.querySelectorAll('[data-selected="1"]')).length >=1){
			for(var i=0; i<selected.length; i++) selected[i].style.display=display;
		}
}

var lastSelectedService = {};
function updateLastSelectedService(clicked_option){
	  //stop if the data-name attribute is not set
		if(!(name = clicked_option.getAttribute('data-name')))  return null;
		if(!(id = clicked_option.getAttribute('data-id')))  return null;
	  if(!(model = clicked_option.getAttribute('data-model')))  return null;
		lastSelectedService['name'] = name;
		lastSelectedService['id'] = id;

		if(price = clicked_option.getAttribute('data-price')) lastSelectedService['price'] = price;
		if(holiday_price = clicked_option.getAttribute('data-holiday-price')) lastSelectedService['holiday_price'] = holiday_price;
		if(weekend_price = clicked_option.getAttribute('data-weekend-price')) lastSelectedService['weekend_price'] = weekend_price;
		if(weekday_price = clicked_option.getAttribute('data-weekday-price')) lastSelectedService['weekday_price'] = weekday_price;

		if((repeat = clicked_option.getAttribute('data-repeat')) && !parseInt(repeat)){
			 	clicked_option.setAttribute('data-selected',"1");
				enforceSelectRepeat('none');
		}
}

// a cloner has two main data attributes: data-parent & data-field
// additional attributes: data-service,
function manageCloning(cloner){
		// get the main elements from the data attribute
		clone_parent = getViaAttr(cloner,'data-parent');
		field = cloneField(getViaAttr(cloner,'data-field'),clone_parent);

		//update the inner elements of the clone element
		updateModelField(field,cloner.getAttribute('data-model'),cloner);

		// close modal if a modal was triggered and mark the selected option
		updateLastSelectedService(cloner);
		manageTransactionField(field);
		if((close_modal = getViaAttr(cloner,'data-click')) && field ) triggerEvent(close_modal,'click');

		//check the associated checkbox
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
		for(var i=0; i<indexes.length; i++)	indexes[i].innerHTML = i+1;
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
		for(var i=0; i<inputs.length; i++) inputs[i].value="";
}

// returns a field index if it follows the underscore convention
function getFieldIndex(field){
	try{ return field.id.split('_')[1]; }
	catch(e){ return false; }
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

	 //pass the services and transactiontype to child elements
	 if(service = cloner.getAttribute("data-service")) field.setAttribute("data-service",service);
	 if(model = cloner.getAttribute("data-model")) field.setAttribute("data-model",model);
	 if(transaction_type = cloner.getAttribute("data-transaction-type")) field.setAttribute("data-transaction-type",transaction_type);

	 // pass the service and transaction type to the modal triggerer, so as to trigger the right modal
	 if(el = field.querySelector('.action-trigger')){
		 if(service) el.setAttribute("data-service",service);
		 if(transaction_type) el.setAttribute("data-transaction-type",transaction_type);
	 }

	 // prepare showing the modal if the transaction for the service is sale
	 if(service) {
			 if(el && model =="sale") configToShowModal(el);
			 if(el && model !="sale") makeIfCloner(el);
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
		try{ return string.split('_')[0] + "_" + index; }
		catch(e){ return false; }
}

function incrementStr(string){
		try{ return string.split('_')[0] + "_" + (parseInt(string.split('_')[1])+1);}
		catch (e){ return false;}
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
	if(toggle % 2 == 0)	for(var i=0; i<inputs.length; i++) inputs[i].readOnly=false;
	else for(var i=0; i<inputs.length; i++) inputs[i].readOnly=true;
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

		var x = file.files.length-1;
		if(1)	create(x,file,display);

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
	  	    if(x >= 0) create(--x,file,display);
	  	 };
	  	 if (UploadFile) ReaderObj.readAsDataURL(UploadFile);
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
	if(source.toString().search("images") > 0) image.src  = source;
}

function deleteThumb(thumb){
	thumb.parentNode.innerHTML="";
}

function createIconThumbnail(file,display){
  var prev_thumbnail = document.getElementsByClassName(display+"icon_thumbnail");
	for(var i=0; i<prev_thumbnail.length; i++) prev_thumbnail[i].innerHTML = "";
	var image = document.createElement("img"),
	thumbnail = document.createElement("div"),
	holder = document.createElement("span");
	holder.setAttribute("class",display+"icon_thumbnail");
	thumbnail.setAttribute("class","icon_thumbnail thumbnail");
	thumbnail.appendChild(image);

	holder.appendChild(thumbnail);
	document.getElementById(display).appendChild(holder);
	var source = file;

	if(source.toString().search("images") > 0){
		image.src = source;
		return;
	}else{
	  var UploadFile = file.files[0], ReaderObj = new FileReader();
    ReaderObj.onloadend = function () { image.src  = ReaderObj.result;};
    if (UploadFile) ReaderObj.readAsDataURL(UploadFile);
	}
}

function centerItem(item, parent = document.body){
	var view_width = parseInt(getComputedStyle(parent,null).width);
	var view_height = parseInt(getComputedStyle(document.body,null).height);
	var item_width = parseInt(getComputedStyle(item,null).width);
	if(view_width < item_width) item.style.left=(view_width-item_width)/2+"px";
	else item.style.left="0px";
}

function centerItems(items, parent = document.body){
	var view_width = parseInt(getComputedStyle(parent,null).width);
  var view_height = parseInt(getComputedStyle(document.body,null).height);
	var item_width,item_current_left;

	for(var i=0; i<items.length; i++){
		item_width = parseInt(getComputedStyle(these[i],null).width);
		if(view_width < item_width) {
			item_current_left  = parseInt(these[i].getBoundingClientRect().left);
			these[i].style.left = ((view_width-item_width)/2 - item_current_left)+"px";
		}else these[i].style.left=item_current_left+"px";
	}
}

function setSquare(item){
	var item_width ;
  item_width = getComputedStyle(item,null).width;
	item.style.height = item_width;
}

function setAllSquare(items){
	var item_width ;
	for(var i=0; i<items.length; i++){
    item_width = getComputedStyle(items[i],null).width;
		items[i].style.height = item_width;
	}
}

function fitToDuoWidth(item,sibling){
	var view_width = parseInt(getComputedStyle(item.parentNode,null).width);
	var sibling_width = parseInt(getComputedStyle(sibling,null).width);
	var item_width = view_width - sibling_width;
	item.style.width = item_width + "px";
}

function fitToDuoHeight(item,sibling){
	var view_height = parseInt(getComputedStyle(item.parentNode,null).height),
	    sibling_height = parseInt(getComputedStyle(sibling,null).height),
	    item_height = view_height - sibling_height;
			item.style.height = item_height + "px";
}

function getAverageRGB(imgEl)  {
 	var blockSize = 5, // only visit every 5 pixels
 		defaultRGB =  { r:0,g:0,b:0}, // for non-supporting envs
		canvas = document.createElement('canvas'),
		context = canvas.getContext && canvas.getContext('2d'),
		data, width, height, length,
		i = -4,
		rgb =  { r:0,g:0,b:0},
		count = 0 ;

	 if (!context) return defaultRGB;
	 height = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height ;
	 width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width ;

	 context.drawImage(imgEl, 0, 0) ;
	 try{ data = context.getImageData(0, 0, width, height);}
	 catch(e){ return defaultRGB ;} /* security error, img on diff domain */

	 length = data.data.length ;
	 while((i += blockSize * 4) < length ){
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
		if(!(subject.length>=1)) subject.style.background = "rgba("+ rgb.r +"," + rgb.g +"," + rgb.b + ","+1+")";
	 	else for(var i=0; i<subject.length; i++) subject[i].style.background = "rgba("+ rgb.r +"," + rgb.g +"," + rgb.b + ","+1+")";
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
