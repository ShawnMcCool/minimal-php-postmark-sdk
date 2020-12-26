<?php namespace MinimalPhpPostmarkSdk;

use DateTimeZone;
use DateTimeImmutable;

class Timestamp
{
    private function __construct(
        private DateTimeImmutable $dateTime
    ) {
    }

    /**
     * return a string in mysql date time format
     */
    public function toMysqlDateTime(): string
    {
        return $this->dateTime->format('Y-m-d H:i:s');
    }

    /**
     * return a string in ISO8601 date time format (preferred date
     * time serialization format due to zone offset being included)
     */
    public function toIso8601(): string
    {
        return $this->dateTime->format('c');
    }

    public function toDateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function format(string $format): string
    {
        return $this->dateTime->format($format);
    }

    public function equals(Timestamp $that): bool
    {
        return $this->toIso8601() === $that->toIso8601();
    }

    public function __toString(): string
    {
        return $this->toMysqlDateTime();
    }

    /**
     * now() creates a new timestamp for the current moment based
     * on the server's php datetime configuration
     */
    public static function now(): Timestamp
    {
        return new static(new DateTimeImmutable());
    }

    /**
     * construct a timestamp from string using the system timezone
     */
    public static function fromString(string $timeString): Timestamp
    {
        return new static(new DateTimeImmutable($timeString));
    }

    /**
     * construct a timestamp from string including timezone
     *
     * The time string can be any php format
     */
    public static function fromStringWithTimezone(string $timeString, string $timeZone): Timestamp
    {
        return new static(new DateTimeImmutable($timeString, new DateTimeZone($timeZone)));
    }
}
