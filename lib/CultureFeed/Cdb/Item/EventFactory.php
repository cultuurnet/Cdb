<?php

class CultureFeed_Cdb_Item_EventFactory
{
    /**
     * @param CultureFeed_Cdb_Item_Actor $actor
     * @return CultureFeed_Cdb_Item_Event
     */
    public static function fromActor(\CultureFeed_Cdb_Item_Actor $actor)
    {
        $event = new \CultureFeed_Cdb_Item_Event();

        // Set as permanent.
        $event->setCalendar(
            new \CultureFeed_Cdb_Data_Calendar_Permanent()
        );

        $actorReflection = new \ReflectionClass($actor);
        $eventReflection = new \ReflectionClass($event);

        $locationLabel = null;

        foreach ($actorReflection->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($actor);

            if (is_null($value)) {
                continue;
            }

            switch ($property->getName()) {
                case 'details':
                    $actorDetailList = $value;
                    $eventDetailList = new \CultureFeed_Cdb_Data_EventDetailList();

                    foreach ($actorDetailList as $actorDetail) {
                        /* @var \CultureFeed_Cdb_Data_EventDetail $eventDetail */
                        // http://stackoverflow.com/questions/3243900/convert-cast-an-stdclass-object-to-another-class
                        $eventDetail = unserialize(sprintf(
                            'O:%d:"%s"%s',
                            strlen(CultureFeed_Cdb_Data_EventDetail::class),
                            CultureFeed_Cdb_Data_EventDetail::class,
                            strstr(strstr(serialize($actorDetail), '"'), ':')
                        ));

                        if ($locationLabel == null) {
                            $locationLabel = $eventDetail->getTitle();
                        }

                        $eventDetailList->add($eventDetail);
                    }

                    $event->setDetails($eventDetailList);
                    break;

                case 'asset':
                    // Do nothing.
                    break;

                case 'weekScheme':
                    /* @var CultureFeed_Cdb_Data_Calendar_WeekScheme $value */
                    $calendar = new \CultureFeed_Cdb_Data_Calendar_Permanent();
                    $calendar->setWeekScheme($value);
                    $event->setCalendar($calendar);
                    break;

                default:
                    $eventProperty = $eventReflection->getProperty($property->getName());
                    $eventProperty->setAccessible(true);
                    $eventProperty->setValue($event, $value);
                    break;
            }
        }

        // Set event location from contact info.
        if (!is_null($actor->getContactInfo())) {
            $addresses = $actor->getContactInfo()->getAddresses();

            if (!empty($addresses)) {
                $locationAddress = $addresses[0];
                $location = new \CultureFeed_Cdb_Data_Location($locationAddress);

                if (!is_null($locationLabel)) {
                    $location->setLabel($locationLabel);
                    $location->setCdbid($actor->getCdbId());
                }

                $event->setLocation($location);
            }
        }

        return $event;
    }
}
