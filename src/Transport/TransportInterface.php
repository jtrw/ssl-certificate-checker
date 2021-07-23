<?php declare(strict_types=1);

namespace Jtrw\SslCertificate\Transport;

use Jtrw\SslCertificate\ValuesObject\CertInfo;
use Jtrw\SslCertificate\ValuesObject\Url;

/**
 * Interface TransportInterface
 * @package Jtrw\SslCertificate\Transport
 */
interface TransportInterface
{
    /**
     * @param Url $url
     * @return CertInfo
     */
    public function getInfo(Url $url): CertInfo;
}
