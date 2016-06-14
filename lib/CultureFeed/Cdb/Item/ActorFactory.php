<?php

class CultureFeed_Cdb_Item_ActorFactory
{
    public static function fromEvent(\CultureFeed_Cdb_Item_Event $event)
    {
        $actor = new \CultureFeed_Cdb_Item_Actor();
        $actor->setAsset(true);

        $eventReflection = new \ReflectionClass($event);
        $actorReflection = new \ReflectionClass($actor);

        foreach ($eventReflection->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($event);

            if (is_null($value)) {
                continue;
            }

            switch ($property->getName()) {
                case 'details':
                    $eventDetailList = $value;
                    $actorDetailList = new \CultureFeed_Cdb_Data_ActorDetailList();

                    /* @var CultureFeed_Cdb_Data_EventDetail $eventDetail */
                    foreach ($eventDetailList as $eventDetail) {
                        $actorDetail = new \CultureFeed_Cdb_Data_ActorDetail();

                        $actorDetail->setLanguage($eventDetail->getLanguage());
                        $actorDetail->setTitle($eventDetail->getTitle());
                        $actorDetail->setShortDescription($eventDetail->getShortDescription());
                        $actorDetail->setLongDescription($eventDetail->getLongDescription());
                        $actorDetail->setCalendarSummary($eventDetail->getCalendarSummary());
                        $actorDetail->setMedia($eventDetail->getMedia());
                        $actorDetail->setPrice($eventDetail->getPrice());

                        $actorDetailList->add($actorDetail);
                    }

                    $actor->setDetails($actorDetailList);
                    break;

                case 'location':
                    /* @var CultureFeed_Cdb_Data_Location $value */
                    $location = $value;
                    if (empty($actor->getContactInfo()->getAddresses())) {
                        $address = $location->getAddress();
                        $contactInfo = new \CultureFeed_Cdb_Data_ContactInfo();
                        $contactInfo->addAddress($address);
                        $actor->setContactInfo($contactInfo);
                    }
                    break;

                case 'weekScheme':
                    /* @var CultureFeed_Cdb_Data_Calendar_WeekScheme $value */
                    $calendar = new \CultureFeed_Cdb_Data_Calendar_Permanent();
                    $calendar->setWeekScheme($value);
                    $event->setCalendar($calendar);
                    break;

                case 'calendar':
                    $calendar = $value;
                    if ($calendar instanceof CultureFeed_Cdb_Data_Calendar_Permanent) {
                        $weekScheme = $calendar->getWeekScheme();
                        if (!empty($weekScheme)) {
                            $actor->setWeekScheme($weekScheme);
                        }
                    }
                    break;

                case 'categories':
                    /* @var CultureFeed_Cdb_Data_CategoryList $value */
                    $categories = $value;
                    if (!$categories->hasCategory('8.15.0.0.0')) {
                        $locationCategory = new \CultureFeed_Cdb_Data_Category(
                            'actortype',
                            '8.15.0.0.0',
                            'Locatie'
                        );
                        $categories->add($locationCategory);
                    }

                    $actor->setCategories($categories);
                    break;

                default:
                    $actorProperty = $actorReflection->getProperty($property->getName());
                    $actorProperty->setAccessible(true);
                    $actorProperty->setValue($actor, $value);
                    break;
            }
        }

        return $actor;
    }
}
