<?php

namespace App\EventSubscriber;

use App\Repository\CreneauRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CalendarSubscriber implements EventSubscriberInterface
{

    private $creneauRepository;

    public function __construct(
        CreneauRepository $creneauRepository,
    )
    {
        $this->creneauRepository = $creneauRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        $creneaux = $this->creneauRepository->findAll();

        foreach ($creneaux as $creneau) {
            $event = new Event(
                $creneau,
                $creneau->getDateDebut(),
                $creneau->getDateFin()
            );
            $event->setOptions([
                'backgroundColor' => '#77B5FE',
                'department'=>'test',
                //'borderColor' => 'red',
                'description' => 'test'
            ]);

            $calendar->addEvent($event);
        }
    }
}
