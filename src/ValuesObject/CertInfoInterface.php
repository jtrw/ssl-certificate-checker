<?php declare(strict_types=1);

namespace Jtrw\SslCertificate\ValuesObject;

use DateTime;

/**
 * Interface CertInfoInterface
 * @package Jtrw\SslCertificate\ValuesObject
 */
interface CertInfoInterface
{
    /**
     * @return string
     */
    public function getUrl(): string;
    
    /**
     * @return string
     */
    public function getSerialNumber(): string;
    
    /**
     * @return int
     */
    public function getSslVerifyResult(): int;
    
    /**
     * @return bool
     */
    public function isSslVerified(): bool;
    
    /**
     * @return array
     */
    public function getSubject(): array;
    
    /**
     * @return array
     */
    public function getIssuer(): array;
    
    /**
     * @return string
     */
    public function getVersion(): string;
    
    /**
     * @return DateTime
     */
    public function getStartDate(): DateTime;
    
    /**
     * @return DateTime
     */
    public function getExpireDate(): DateTime;
    
    /**
     * @return array
     */
    public function getAllCerts(): array;
}
