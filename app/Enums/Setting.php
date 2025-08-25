<?php 

namespace App\Enums;

enum Setting: string {
       // Define keys for different settings
       
       case MaxRangeEventStartDate = 'max_range_event_start_date';

       case MaxRangeEventEndDate = 'max_range_event_end_date';
       
       case MaxItemPetitions = 'max_item_petitions';

       case MaxReagentPetitions = 'max_reagent_petitions';

       case MinPerDelivery = 'min_per_delivery';
       
       case MaxPerDelivery = 'max_per_delivery';
       
       case MinPerEventDonation = 'min_per_event_donation';

       case MaxPerEventDonation = 'max_per_event_donation';

       case MinPerReagentDonation = 'min_per_reagent_donation';

       case MaxPerReagentDonation = 'max_per_reagent_donation';
          
       // Define the possible types for values (integer, float, etc.)
       case TypeInteger = 'integer';
       case TypeDecimal = 'decimal';
       case TypeFloat = 'float';
       case TypeString = 'string';
       case TypeBoolean = 'boolean';
       case TypeJson = 'json';
   
       // Add any categories for organization, if needed
       case CategoryGeneral = 'general';
       case CategoryDonations = 'donations';
       case CategoryLimits = 'limits';
}