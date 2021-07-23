<?php declare(strict_types=1);
namespace Jtrw\SslCertificate\Transport;

use Jtrw\SslCertificate\Exceptions\TransportNotFound;

/**
 * Class TransportFactory
 * @package Jtrw\SslCertificate
 */
class TransportFactory
{
    protected const POSTFIX           = "Transport";
    protected const DEFAULT_TRANSPORT = "Curl";
    
    /**
     * @param string|null $transportName
     * @return TransportInterface
     * @throws TransportNotFound
     */
    public static function getInstance(string $transportName = null): TransportInterface
    {
        if (!$transportName) {
            $transportName = static::DEFAULT_TRANSPORT;
        }
        $transportName = __NAMESPACE__.'\\'.ucfirst(strtolower($transportName)).static::POSTFIX;
        
        if (!class_exists($transportName)) {
            throw new TransportNotFound("Not Found Transport Class: ".$transportName);
        }
        
        return new $transportName();
    } // end getInstance
}
