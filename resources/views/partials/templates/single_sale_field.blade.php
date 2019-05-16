<div id="saleField_1">
      <div class="input-group field-group sale-field-group field mb-3" >
          <div class="name-field input-group-prepend ">
             <button class="  btn btn-secondary dropdown-toggle" type="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
              >
                <small class="index"> 1 </small>
             </button>
             <div class="dropdown-menu">
               <a class="dropdown-item toggle-editable" data-inputs="sale-field-1">
                 Edit Price
               </a>
               <a class="dropdown-item collapse-detail" data-toggle="collapse"
                  data-target="#collapseDetail_0" aria-expanded="false" aria-controls="collapseExample"
                  >
                  Toggle Details
               </a>
               <a class="dropdown-item remove-field" data-field="#saleField_1" >
                 Remove this Item
               </a>
             </div>
             <input required type="text" name="sale_name[]" class="form-control no-radius name-field input" placeholder="name" >
             <input hidden type="text" name="sale_type[]" class="form-control input no-radius" >
             <input hidden type="text" name="sale_id[]" class="form-control input no-radius " >
           </div>
           <input required readonly type="number" name="sale_price[]" class="form-control input price-field auto-amount  sale-field-1 input"  placeholder="price" >
           <input required readonly type="number" name="sale_quantity[]" class="form-control input quantity-field input"  placeholder="price" >
           <input required readonly type="number" name="sale_amount[]" class="form-control input amount-field auto-amount input"  placeholder="price" >
      </div>
      <div id="collapseDetail_1" class="collapse">
        <div class="input-group field">
            <div class="input-group-prepend">
              <span class="input-group-text"> Sale Details </span>
            </div>
            <textarea name="sale_details[]" class="form-control" aria-label="With textarea"></textarea>
        </div>
      </div>
  </div>
