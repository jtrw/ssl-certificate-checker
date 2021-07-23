<?php


namespace Jtrw\SslCertificate\Tests;

use Jtrw\SslCertificate\Transport\TransportInterface;
use Jtrw\SslCertificate\ValuesObject\CertInfo;
use Jtrw\SslCertificate\ValuesObject\Url;

class TestTransport implements TransportInterface
{
    private array $options;
    
    public function __construct(array $options = [])
    {
        $this->options = $options;
    } // end __construct
    
    public function getInfo(Url $url): CertInfo
    {
        $options = [
            'url' => $url->toNative(),
        ];
        $options = array_merge($this->options, $options);
        
        return new CertInfo($options);
    } // end getInfo
}
