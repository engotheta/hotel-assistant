
<div class="transaction-group" id="transactionGroup_1" >
  <div class="transaction-group-header flex-container">
      <span class="group-name wide dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="model-name plural"> Sale </span>
      </span>
      <div class="dropdown-menu">
        <a class="dropdown-item remove-field" data-field="#singleSaleField_1" >
          Remove these transactions
        </a>
      </div>
      <span class="group-total money wide"> 2000 </span>
  </div>
  <div class="transactions-header">
      <!-- js filled according to the transactionType_ -->
  </div>
  <div class="transactions-list fields-parent" id="childFields_1">
      <!-- transaction type fields are populated here -->
  </div>
  <hr>
  <div class="input-group field transactions-footer center-text flex-container flex-between">
    <button type="button" class="round secondary-outline wide action-trigger"
      data-service="" data-toggle='modal' data-field="#transactionField_1" data-transaction-type="" data-target="#" data-parent="#childFields_1">
      <span> add </span>
      <span class="model-name"> Sale </span>
    </button>
    <span  class="group-total round dark money wide" > 1000</span>
  </div>
</div>
