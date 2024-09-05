<?php

error_reporting(E_ALL & ~E_WARNING);
$xmlDocument='yrl_searchapp.xml';


//echo "Сколько квартир сдается в Ярославле? ".$coount_room;
$xmlDoc = new DOMDocument();
$xmlDoc->load($xmlDocument);

$items=$xmlDoc->getElementsByTagName('offer');
$count_flat = 0;
$flag_flat = 'false';
$locate_flag = 'false';
$count_loc_minsk = 0;
$sum_price = 0;
$locate_flag_moskow = 'false';
$count_with_pets = 0;

 for ($i=0;$i<$items->length;$i++) {
     foreach ($items->item($i)->childNodes as $node) {
         if($node->nodeName == 'category' and $node->nodeValue == 'flat'){
             //флаг обозначающий,что эта квартира, а не другая категория
             $flag_flat = 'true';
             //echo 'This is flat number  '.$i;
         }
         if ($node->nodeName == 'location') {
                 foreach ($node->childNodes as $location) {
                     if ($location->nodeName == 'locality-name') {
                         if ($location->nodeValue == 'Ярославль') {
                             if($flag_flat == 'true') {
                                 //ко-во квартир в ярославле
                                 $count_flat++;
                                // echo 'count flat in Ярославль'.$count_flat."\n";
                             }
                         }
                         if($location->nodeValue == 'Минск') {
                              if($flag_flat == 'true') {
                                  $locate_flag = 'true';
                                  //ко-во квартир в минске
                                  $count_loc_minsk++;
                                  //echo 'count flat Минск'.$count_loc_minsk."\n";
                              }
                         }
                         if($location->nodeValue == 'Москва'){
                             if($flag_flat == 'true') {
                                 $locate_flag_moskow = 'true';
                             }
                         }

                     }
//
                 }
             }
         if($node->nodeName == 'price'){
             if($locate_flag == 'true') {
                 foreach ($node->nodeName as $price) {
                     if ($price->nodeName == 'value') {
                         //об-щая сумма стоимости квартир в минске
                         $sum_price += $node->nodeValue;
                     }
                 }
             }
         }
         if($node->nodeName == 'description'){
             if($locate_flag_moskow == 'true') {
                 if ($node->nodeValue == 'возможно размещение с животными') {
                     $count_with_pets++;
                   //  echo 'count flat Москва '.$count_with_pets;
                 }
             }
         }
         }

 }

echo "Сколько квартир сдается в Ярославле? : ".  $count_flat;
echo "Какая медианная цена аренды квартиры в Минске : ?". $median_price = $sum_price/$count_loc_minsk; //расчет медианной цены квартир в минске
echo "Сколько квартир сдается в Москве, где возможно размещение с животными? :". $count_with_pets;
