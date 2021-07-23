<?php declare(strict_types=1);

namespace Jtrw\SslCertificate;

use Jtrw\SslCertificate\ValuesObject\CertInfo;

/**
 * Interface SslCertificateCheckerInterface
 * @package Jtrw\SslCertificate
 */
interface SslCertificateInfoInterface
{
    /**
     * @param string $url
     * @return CertInfo
     */
    public function getInfo(string $url): CertInfo;
    
    /**
     * @param array $urls
     * @return array
     */
    public function getBatchInfo(array $urls): array;
    
    /**
     * @param array $data
     * @return array
     */
    public function check(array $data): array;
}
