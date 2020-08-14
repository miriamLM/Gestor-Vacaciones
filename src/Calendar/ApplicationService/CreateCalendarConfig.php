<?php

declare(strict_types = 1);

namespace App\Calendar\ApplicationService;

use App\Calendar\ApplicationService\DTO\CalendarRequest;
use App\Calendar\ApplicationService\Exception\CalendarAlreadyExistsException;
use App\Calendar\Domain\CalendarRepository;
use App\Calendar\Domain\ValueObject\WorkDays;
use App\Calendar\Domain\ValueObject\WorkingYear;
use App\Entity\Calendar;
use DateTimeImmutable;

final class CreateCalendarConfig
{
    private CalendarRepository $calendarRepository;

    public function __construct(CalendarRepository $calendarRepository)
    {
        $this->calendarRepository = $calendarRepository;
    }

    public function __invoke(CalendarRequest $calendarRequest)
    {
        $calendarEntity = $this->calendarRepository->findCalendarByWorkingYear($calendarRequest);

        if (null !== $calendarEntity) {
            throw new CalendarAlreadyExistsException($calendarRequest->workingYear());
        }

        $this->calendarRepository->saveCalendarConfig($calendarRequest);
    }

    public function mappingCalendarFromCalendarRequest(CalendarRequest $calendarRequest): Calendar
    {
        $workingYear = new WorkingYear(intval($calendarRequest->workingYear()));
        $workDays = new WorkDays($calendarRequest->workDays());

        $calendarEntity = new Calendar(
            new DateTimeImmutable($calendarRequest->initDateRequest()),
            new DateTimeImmutable($calendarRequest->endDateRequest()),
            $workDays,
            $calendarRequest->workDays(),
            $calendarRequest->company(),
            $workingYear
        );

        return $calendarEntity;
    }
}