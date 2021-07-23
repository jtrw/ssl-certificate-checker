<?php declare(strict_types=1);
namespace Jtrw\SslCertificate\Transport;

use Jtrw\SslCertificate\Exceptions\CurlNotFoundException;
use Jtrw\SslCertificate\ValuesObject\CertInfo;
use Jtrw\SslCertificate\ValuesObject\Url;

/**
 * Class CurlTransport
 * @package Jtrw\SslCertificate\Transport
 */
class CurlTransport implements TransportInterface
{
    /**
     * @var array
     */
    protected array $options;
    
    /**
     * CurlTransport constructor.
     * @param array $options
     * @throws CurlNotFoundException
     */
    public function __construct(array $options = [])
    {
        if (!extension_loaded('curl')) {
            throw new CurlNotFoundException('cURL extension is not available on your server');
        }
        
        $default = $this->getDefaultOptions();
        foreach ($default as $index => $value) {
            if (isset($options[$index])) {
                continue;
            }
            $options[$index] = $value;
        }
        
        $this->options = $options;
    } // end __construct
    
    /**
     * @return array
     */
    protected function getDefaultOptions(): array
    {
        return [
            CURLOPT_VERBOSE        => false,
            CURLOPT_CERTINFO       => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => false
        ];
    } // end getDefaultOptions
    
    /**
     * @param Url $url
     * @return CertInfo
     */
    public function getInfo(Url $url): CertInfo
    {
        $curl = curl_init();
        $this->options[CURLOPT_URL] = $url->toNative();
        
        curl_setopt_array($curl, $this->options);
        
        curl_exec($curl);
        
        $info = curl_getinfo($curl);
    
        $info['errno']   = curl_errno($curl);
        $info['errmsg']  = curl_error($curl);
        curl_close($curl);
        
        return new CertInfo($info);
    } // end getInfo
}
