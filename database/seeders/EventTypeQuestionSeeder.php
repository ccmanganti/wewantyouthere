<?php
namespace Database\Seeders;
use App\Models\EventType;
use App\Models\EventQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class EventTypeQuestionSeeder extends Seeder {
 public function run(): void {
  $shared=['event_title'=>'Event Title','event_date'=>'Event Date','event_time'=>'Event Time','venue_name'=>'Venue Name','venue_address'=>'Venue Address','venue_map_url'=>'Map URL','host_message'=>'Invitation Message','guest_limit'=>'Number of Guests','rsvp_deadline'=>'RSVP Deadline'];
  $types=[
   'Wedding'=>['bride_name'=>'Bride Name','groom_name'=>'Groom Name','ceremony_venue'=>'Ceremony Venue','reception_venue'=>'Reception Venue','principal_sponsors'=>'Principal Sponsors / Ninong and Ninang','maid_of_honor'=>'Maid of Honor','best_man'=>'Best Man','bridesmaids'=>'Bridesmaids','groomsmen'=>'Groomsmen','flower_girls'=>'Flower Girls','ring_bearer'=>'Ring Bearer','coin_bearer'=>'Coin Bearer','veil_sponsors'=>'Veil Sponsors','cord_sponsors'=>'Cord Sponsors','candle_sponsors'=>'Candle Sponsors','dress_code'=>'Dress Code'],
   'Christening'=>['child_name'=>'Child Name','mother_name'=>'Mother Name','father_name'=>'Father Name','godfathers'=>'Ninong / Godfathers','godmothers'=>'Ninang / Godmothers','church_name'=>'Church Name','reception_venue'=>'Reception Venue','dress_code'=>'Dress Code'],
   'Birthday'=>['celebrant_name'=>'Celebrant Name','age'=>'Age','theme'=>'Party Theme','dress_code'=>'Dress Code'],
   'Debut'=>['debutante_name'=>'Debutante Name','eighteen_roses'=>'18 Roses','eighteen_candles'=>'18 Candles','eighteen_treasures'=>'18 Treasures','dress_code'=>'Dress Code'],
   'Anniversary'=>['couple_names'=>'Celebrants','years_together'=>'Years Together','dress_code'=>'Dress Code'],
   'Graduation'=>['graduate_name'=>'Graduate Name','school_name'=>'School Name','degree'=>'Degree / Program','dress_code'=>'Dress Code'],
   'Corporate Event'=>['company_name'=>'Company Name','event_organizer'=>'Organizer','agenda'=>'Agenda','dress_code'=>'Dress Code'],
  ];
  foreach($types as $name=>$specific){
   $event=EventType::updateOrCreate(['slug'=>Str::slug($name)],['name'=>$name,'is_active'=>true]);
   $questions=array_merge($shared,$specific);
   $order=0;
   foreach($questions as $key=>$label){
    $type=match($key){'event_date','rsvp_deadline'=>'date','event_time'=>'time','guest_limit','age','years_together'=>'number','venue_map_url'=>'url','host_message','agenda'=>'textarea','principal_sponsors','bridesmaids','groomsmen','flower_girls','veil_sponsors','cord_sponsors','candle_sponsors','godfathers','godmothers','eighteen_roses','eighteen_candles','eighteen_treasures'=>'textarea',default=>'text'};
    EventQuestion::firstOrCreate(['event_type_id'=>$event->id,'key'=>$key],['label'=>$label,'type'=>$type,'is_required'=>in_array($key,['event_title','event_date','venue_name'],true),'is_enabled'=>true,'sort_order'=>$order]);
    $order+=10;
   }
  }
 }
}