<?php

namespace App\Domain\Constant;

class TicketSubject
{
    const SUBJECT_1 = 'subject1';
    const SUBJECT_2 = 'subject2';

    public static function getTicketSubjects(): array
    {
        return [
            self::SUBJECT_1,
            self::SUBJECT_2
        ];
    }

    public static function getTicketSubjectsWithNames(): array
    {
        return [
            self::SUBJECT_1 => 'Temat 1',
            self::SUBJECT_2 => 'Temat 2'
        ];
    }
}