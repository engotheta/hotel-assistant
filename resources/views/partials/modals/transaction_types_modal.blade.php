@isset($transaction_types)
<div class="modal fade" id="{{$sname.'TransactionTypesModal'}}" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >

            <div class="modal-header">
              <h5 class="modal-title system-text ">Select the Transaction Type! </h5>
              <button  type="button" class="close"
                data-dismiss="modal" aria-label="Close"
                >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="list-group transaction-type-selector">
                <?php
                    $n=1;
                    $transaction_field = " ";
                ?>
                @forelse ($transaction_types as $transaction_type)
                    <div class="transaction-type-option list-group-item list-group-item-action clone-field"
                        data-field="#transactionGroup_1" data-parent="#{{$sname.'Transactions'}}"
                        data-child-field="#{{$transaction_field}}" data-child-parent="#childFields_1"
                        data-model="{{$transaction_type->name}}"
                        data-click="#{{$sname.'TransactionTypesModal'}}"
                        data-check="#{{$sname.'TransactionType_'.$transaction_type->id}}"
                        data-service="{{$service->name}}"
                        id="{{$sname.'TransactionTypeOption_'.$transaction_type->id}}"
                     >
                      <span class=" dark round index"> {{ $n++ }} </span>
                      <span class="stystem-text padded">{{ $transaction_type->name }}</span>
                    </div>
                @empty
                    <a href="#" class="list-group-item list-group-item-action system-text">
                      you must have a transaction type! go and add a transaction type
                    </a>
                @endforelse
              </div>
            </div>

            <div class="templates simulators">
                @foreach ($transaction_types->where('prime',1) as $transaction_type)
                   <span class="simulate-cloner"
                   data-cloner="#{{$sname.'TransactionTypeOption_'.$transaction_type->id}}">
                   </span>
                @endforeach
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
@endisset
