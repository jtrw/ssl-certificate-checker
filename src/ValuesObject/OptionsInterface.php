<?php declare(strict_types=1);
namespace Jtrw\SslCertificate\ValuesObject;

use DateTime;

interface OptionsInterface
{
    public function isExpireDate(): bool;
    public function getEndDate(): DateTime;
    public function toNative(): array;
}
