<?php declare(strict_types=1);
namespace Jtrw\SslCertificate;

use Jtrw\SslCertificate\Transport\TransportFactory;
use Jtrw\SslCertificate\Transport\TransportInterface;
use Jtrw\SslCertificate\ValuesObject\CertInfo;
use Jtrw\SslCertificate\ValuesObject\Options;
use Jtrw\SslCertificate\ValuesObject\Url;

/**
 * Class SslCertificateChecker
 * @package Jtrw\SslCertificate
 */
class SslCertificateInfo implements SslCertificateInfoInterface
{
    protected TransportInterface $transport;
    
    /**
     * SslCertificateChecker constructor.
     * @param array $options
     * @throws Exceptions\TransportNotFound
     */
    public function __construct(array $options = [])
    {
        $transportName = null;
        if (!empty($options['transport_name'])) {
            $transportName = $options['transport_name'];
        }
        $this->transport = TransportFactory::getInstance($transportName);
    } // end __construct
    
    /**
     * @param string $url
     * @return CertInfo
     * @throws Exceptions\WebsiteHostNotFound
     */
    public function getInfo(string $url): CertInfo
    {
        return $this->getTransport()->getInfo(new Url($url));
    } // end getInfo
    
    /**
     * @param array $urls
     * @return array
     * @throws Exceptions\WebsiteHostNotFound
     */
    public function getBatchInfo(array $urls): array
    {
        $sitesInfo = [];
        foreach ($urls as $url) {
            $sitesInfo[$url] = $this->getTransport()->getInfo(new Url($url));
        }
    
        return $sitesInfo;
    } // end checkBatch
    
    /**
     * @param array $data
     * @return array
     *
     * $key="http://site" => $options['expire_date']
     */
    public function check(array $data): array
    {
        $result = [];
        foreach ($data as $url => $options) {
            if (is_int($url) && is_scalar($options)) {
                $url = $options;
                $options = [];
            }

            $result[] = $this->doCheckRow($url, $options);
        }
        return $result;
    } // end check
    
    /**
     * @param string $url
     * @param array $options
     * @return array
     * @throws Exceptions\WebsiteHostNotFound
     */
    protected function doCheckRow(string $url, array $options = []): array
    {
        $info = $this->getInfo($url);
        
        $result = [
            'host'        => $info->getUrl(),
            'is_verified' => $info->isSslVerified(),
            'expire_date' => $info->getExpireDate()->format("Y-m-d H:i:s")
        ];
        
        if ($options) {
            $optionsVO = new Options($options);
            if ($optionsVO->isExpireDate()) {
                $isVerified = $info->getExpireDate()->getTimestamp() > $optionsVO->getEndDate()->getTimestamp();
                $result['is_verified'] = $isVerified;
            }
        }
        
        return $result;
    } // end doCheckRow
    
    /**
     * @return TransportInterface
     */
    protected function getTransport(): TransportInterface
    {
        return $this->transport;
    } //end getTransport
}
