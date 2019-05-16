<?php

use Illuminate\Database\Seeder;
use App\CrateSize;
use App\DrinkType;
use App\RoomType;
use App\Title;
use App\Service;
use App\TransactionType;
use App\Department;
use App\Activity;
use App\Room;
use App\Venue;
use App\Drink;
use App\Food;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

         $obj = new CrateSize();
    		 $crate_sizes = ($obj->crateSizes());
    		 foreach($crate_sizes as $crate_size){
    			DB::table('crate_sizes')->insert([
    			        'size' => $crate_size['size'],
    			 ]);
    		 }

         $obj = new DrinkType();
    		 $drink_types = ($obj->drinkTypes());
    		 foreach($drink_types as $drink_type){
    			DB::table('drink_types')->insert([
                  'name' => $drink_type['name'],
    			        'details' => $drink_type['details'],
    			 ]);
    		 }

         $obj = new RoomType();
    		 $room_types = ($obj->roomTypes());
    		 foreach($room_types as $room_type){
    			DB::table('room_types')->insert([
                  'name' => $room_type['name'],
    			        'details' => $room_type['details'],
    			 ]);
    		 }

         $obj = new Title();
         $titles = ($obj->titles());
         foreach($titles as $title){
          DB::table('titles')->insert([
                  'name' => $title['name'],
                  'details' => $title['details'],
           ]);
         }

          $obj = new Service();
          $services = ($obj->services());
          foreach($services as $service ){
           DB::table('services')->insert([
                   'name' => $service['name'],
                   'slug' => str_replace(" ","-",trim($service['name'])),
                   'details' => $service['details'],
            ]);
          }

          $obj = new TransactionType();
          $items = ($obj->transactionTypes());
          foreach($items as $item){
           DB::table('transaction_types')->insert([
                   'name' => $item['name'],
                   'debit' => $item['debit'],
                   'prime' => $item['prime'],
                   'for_all_services' => $item['for_all_services'],
                   'for_activities' => $item['for_activities'],
                   'details' => $item['details'],
            ]);
          }

          // service - transaction type
          foreach ($items as $transaction_type) {
            $t_type = TransactionType::where('name',$transaction_type['name'])->first();
             if(!$transaction_type['for_all_services']){
               for($i=0; $i<count($transaction_type['services']); $i++){
                 $service = Service::where('name',$transaction_type['services'][$i])->first();
                 $service->transactionTypes()->attach($t_type);
               }
             }else{
               foreach(Service::all() as $service) $service->transactionTypes()->attach($t_type);
             }
          }

          $obj = new Department();
          $departments = ($obj->departments());
          foreach($departments as $department){
           DB::table('departments')->insert([
                   'name' => $department['name'],
                   'slug' => str_replace(" ","-",trim($department['name'])),
                   'details' => $department['details'],
            ]);
          }

          // department - service
          foreach ($departments as $department) {
            $dep = Department::where('name',$department['name'])->first();
            for($i=0; $i<count($department['services']); $i++){
              $service = Service::where('name',$department['services'][$i])->first();
              $dep->services()->attach($service);
            }
          }

          $obj = new Activity();
          $activities= ($obj->activities());
          foreach($activities as $activity){
           DB::table('activities')->insert([
                   'name' => $activity['name'],
                   'slug' => str_replace(" ","-",trim($activity['name'])),
                   'price' => $activity['price'],
                   'count' => $activity['count'],
                   'details' => $activity['details'],
            ]);
          }

          // Activity - TransactionType
          foreach (Activity::all() as $activity) {
            $transaction_types = TransactionType::where('for_activities',true)->get();
            foreach($transaction_types as $transaction_type){
              $activity->transactionTypes()->attach($transaction_type);
            }
          }

          $obj = new Venue();
          $venues = ($obj->venues());
          foreach($venues as $venue){
           DB::table('venues')->insert([
                   'name' => $venue['name'],
                   'slug' => str_replace(" ","-",trim($venue['name'])),
                   'weekday_price' => $venue['weekday_price'],
                   'weekend_price' => $venue['weekend_price'],
                   'ac' => $venue['ac'],
                   'fan' => $venue['fan'],
                   'count' => $venue['count'],
                   'details' => 'a good venue',
            ]);
          }

          $obj = new Room();
          $rooms = ($obj->rooms());
          foreach($rooms as $room){
           DB::table('rooms')->insert([
                   'name' => $room['name'],
                   'slug' => str_replace(" ","-",trim($room['name'])),
                   'price' => $room['price'],
                   'ac' => $room['ac'],
                   'fan' => $room['fan'],
                   'count' => $room['count'],
                   'details' => 'a good room',
            ]);
          }

          $obj = new Drink();
          $drinks = ($obj->drinks());
          foreach($drinks as $drink){
           DB::table('drinks')->insert([
                   'name' => $drink['name'],
                   'slug' => str_replace(" ","-",trim($drink['name'])),
                   'price' => $drink['price'],
                   'stock' => $drink['stock'],
                   'count' => $drink['count'],
                   'details' => 'a good drink',
            ]);
          }

          $obj = new Food();
          $foods = ($obj->foods());
          foreach($foods as $food){
           DB::table('foods')->insert([
                   'name' => $food['name'],
                   'slug' => str_replace(" ","-",trim($food['name'])),
                   'price' => $food['price'],
                   'stock' => $food['stock'],
                   'count' => $food['count'],
                   'details' => 'a good food',
            ]);
          }

    }
}
