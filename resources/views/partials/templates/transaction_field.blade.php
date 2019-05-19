<div id="transactionField_1" class="transaction-field">
      <div class="input-group field-group transaction-field-group field mb-3" >
          <div class="name-field input-group-prepend">
             <button class="  btn btn-secondary dropdown-toggle" type="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
              >
                <small class="index"> 1 </small>
             </button>
             <div class="dropdown-menu">
               <a class="dropdown-item toggle-editable" data-inputs="not-editable">
                 Edit Price
               </a>
               <a class="dropdown-item collapse-detail" data-toggle="collapse"
                  data-target="#collapseDetail_0" aria-expanded="false" aria-controls="collapseExample"
                  >
                  Toggle Details
               </a>
               <a class="dropdown-item remove-field" data-field="#transactionField_1" >
                 Remove this Item
               </a>
             </div>
             <input hidden type="text" name="transaction_type[]" class="form-control input no-radius" >
             <input hidden type="text" name="transactionable_type[]" class="form-control input no-radius" >
             <input hidden type="text" name="transactionable_id[]" class="form-control input no-radius " >
             <input required type="text" name="transactionable_name[]" class="form-control no-radius input name-field">
           </div>
           <input required readonly type="number" name="transaction_quantity[]"
            data-small-parent="#quantityFieldSub_1" data-return-before="#amountField_1"
            class="shift-on-small form-control input quantity-field" >
           <input required readonly type="number" name="transaction_price[]"
            data-small-parent="#priceFieldSub_1" data-return-before="#amountField_1"
            class="shift-on-small form-control input price-field not-editable">
           <input required readonly type="number" id="amountField_1" name="transaction_amount[]" class="form-control input amount-field"  >
      </div>
      <div id="collapseDetail_1" class="collapse">
        <div class="sub-field-group bottom-spaced show-on-small">
            <div class="field append-field-on-small" id="quantityFieldSub_1">
              <span class="label input-group-text"> qnty </span>
            </div>
            <div class="field append-field-on-small" id="priceFieldSub_1">
              <span class="label input-group-text"> prc </span>
            </div>
        </div>
        <div class="input-group field">
            <div class="input-group-prepend">
              <span class="input-group-text"> Sale Details </span>
            </div>
            <textarea name="transaction_details[]" class="form-control" aria-label="With textarea"></textarea>
        </div>
      </div>
  </div>
