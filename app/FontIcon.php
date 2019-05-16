<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FontIcon extends Model
{
    //

    public function themifyIcons(){
      $categories = [
          'add' =>   [ 'tag' => '<i class="icon ti ti-plus"> </i>' ],
          'edit' =>  [ 'tag' => '<i class="icon ti ti-pencil"> </i>' ],
          'view' =>  [ 'tag' => '<i class="icon ti ti-eye"> </i>' ],
          'delete' => [ 'tag' => '<i class="icon icon-trash"> </i>' ],
          'add-many' => [ 'tag' => '<i class="icon icon-doc-new"> </i>' ],
          'edit-many' => [ 'tag' => '<i class="icon  icon-edit"> </i>' ],

          'fan' => [ 'tag' => '<i class="icon icon-spin5"> </i>' ],
          'ac' => [ 'tag' => '<i class="icon icon-snowflake-o"> </i>' ],
          'room-type' => [ 'tag' => '<i class="icon icon-bed"> </i>' ],
          'drink-type' => [ 'tag' => '<i class="icon icon-beer"> </i>' ],
          'price' => [ 'tag' => '<i class="icon icon-money "> </i>' ],
          'money' => [ 'tag' => '<i class="icon icon-money "> </i>' ],
          'count' => [ 'tag' => '<i class="icon icon-hashtag"> </i>' ],
          'crate' => [ 'tag' => '<i class="icon icon-hashtag"> </i>' ],
          'index' => [ 'tag' => '<i class="icon icon-hashtag"> </i>' ],
          'floor' => [ 'tag' => '<i class="icon icon-home-1"> </i>' ],
          'active' => [ 'tag' => '<i class="icon icon-ok"> </i>' ],
          'inactive' => [ 'tag' => '<i class="icon icon-wrench"> </i>' ],
          'details' => [ 'tag' => '<i class="icon icon-doc-text"> </i>' ],
          'capacity' => [ 'tag' => '<i class="icon ti-bar-chart"> </i>' ],

          'email' => [ 'tag' => '<i class="icon icon-at"> </i>' ],
          'phone' => [ 'tag' => '<i class="icon icon-mobile-alt"> </i>' ],
          'gender' => [ 'tag' => '<i class="icon ti ti-face-smile "> </i>' ],
          'birth' => [ 'tag' => '<i class="icon icon-birthday "> </i>' ],
          'title' => [ 'tag' => '<i class="icon ti ti-medall-alt  "> </i>' ],
          'address' => [ 'tag' => '<i class="icon ti ti-direction   "> </i>' ],
          'role' => [ 'tag' => '<i class="icon ti ti-id-badge  "> </i>' ],

          'admin' => [ 'tag' => '<i class="icon icon-key"> </i>' ],
          'user' => [ 'tag' => '<i class="icon icon-user-o "> </i>' ],

          'admin panel' => [ 'tag' => '<i class="icon ti ti-infinite  "> </i>' ],
          'view panel' => [ 'tag' => '<i class="icon ti ti-eye "> </i>' ],
          'content panel' => [ 'tag' => '<i class="icon ti ti-clipboard "> </i>' ],

          'settings' => [ 'tag' => '<i class="icon ti ti-settings "> </i>' ],
          'branches' => [ 'tag' => '<i class="icon ti ti-location-pin "> </i>' ],
          'departments' => [ 'tag' => '<i class="icon ti ti-tag  "> </i>' ],
          'variables' => [ 'tag' => '<i class="icon ti ti-direction-alt"> </i>' ],
          'titles' => [ 'tag' => '<i class="icon ti ti-direction-alt"> </i>' ],
          'roles' => [ 'tag' => '<i class="icon ti ti-direction-alt"> </i>' ],

          'business days' => [ 'tag' => '<i class="icon ti ti-receipt "> </i>' ],
          'business-days' => [ 'tag' => '<i class="icon ti ti-receipt "> </i>' ],
          'unpaid loans' => [ 'tag' => '<i class="icon ti ti-calendar "> </i>' ],
          'unpaid-loans' => [ 'tag' => '<i class="icon ti ti-calendar "> </i>' ],
          'venue-bookings' => [ 'tag' => '<i class="icon ti ti-gift"> </i>' ],
          'venue bookings' => [ 'tag' => '<i class="icon ti ti-gift"> </i>' ],

          'new-businessday' => [ 'tag' => '<i class="icon icon-doc-new"> </i>' ],
          'edit-businessday' => [ 'tag' => '<i class="icon  icon-edit"> </i>' ],

          'members' => [ 'tag' => '<i class="icon ti ti-user "> </i>' ],
          'rooms' => [ 'tag' => '<i class="icon ti ti-layout-width-full "> </i>' ],
          'drinks' => [ 'tag' => '<i class="icon ti ti-paint-bucket "> </i>' ],
          'foods' => [ 'tag' => '<i class="icon  icon-food-1 "> </i>' ],
          'venues' => [ 'tag' => '<i class="icon ti ti-layout-sidebar-none "> </i>' ],
          'activities' => [ 'tag' => '<i class="icon ti ti-crown "> </i>' ],

          'stocking' => [ 'tag' => '<i class="icon ti ti-exchange-vertical"> </i>' ],
          'stock' => [ 'tag' => '<i class="icon ti ti-exchange-vertical"> </i>' ],




      ];

      return $categories;
    }
}
