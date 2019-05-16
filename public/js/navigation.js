
var xs = 0;
var sm = 576;
var md = 768;
var lg = 992;
var xl = 1200;
var page; var status = 'center';

var w,h,admin_w,view_w;
function swipeLeft(){
	page = document.getElementById('page');

	if(status=='left') return;

	if(status=='center'){
		if(w > md) return;
		page.style.left= -1*(view_w + 2*space) + 'px';
		status = 'left';
		return;
	}
	resetView();
}

function resetView(){
	page = document.getElementById('page');
	page.style.left= '0px';
	status = 'center';
}

function swipeRight(){
	page = document.getElementById('page');

	if(status=='center'){
		if(w > lg) return;
		page.style.left= 1*(admin_w + 2*space) + 'px';
		status = 'right';
	}
	if(status=='right') return;

	resetView();
}


function calibrateTabNav(){
	resetView();
	var admin = document.getElementById('admin_panel');
	var content = document.getElementById('content');
	var view = document.getElementById('view_panel');
	page = document.getElementById('page');

	space = 15;
  w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
	h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
	admin_w = parseInt(getComputedStyle(admin,null).width);
	view_w = parseInt(getComputedStyle(view,null).width);

	page.style.maxWidth = w + "px !important";
	document.body.style.maxWidth = w + "px !important";

	// for extra-small devices and up
	// admin panel goes absolute and far left,
	// view panel goes absolute and far right,
	if(w >= xs){
		admin.style.position = 'absolute';
		admin.style.marginRight = '0';
		admin.style.marginLeft = '0';
		admin.style.top = '0px';
		admin.style.left = -1*(admin_w + 2*space) + 'px';

		view.style.position = 'absolute';
		view.style.marginRight = '0';
		view.style.marginLeft = '0';
		view.style.top = '0px';
		view.style.right = -1*(view_w + 2*space) + 'px';

	}

	// for small devices and up
	//
	if(w >= sm){

	}

	// for median devices and up
	if(w >= md){
		 view.style.position = 'relative';
		 view.style.right = '0px';
		 view.style.marginRight = space+'px';
	}

	// for large devices and up
	// admin panel goes with normal flow
	if(w >= lg){
		 admin.style.position = 'relative';
		 admin.style.left = '0px';
		 admin.style.marginLeft = space+'px';

	}

	// for extra large devices and up
	if(w >= xl){

	}

}
