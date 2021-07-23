<?php declare(strict_types=1);

namespace Jtrw\SslCertificate\ValuesObject;

use DateTime;

/**
 * Class CertInfo
 * @package Jtrw\SslCertificate\ValuesObject
 */
class CertInfo implements CertInfoInterface, ValueObjectInterface
{
    /**
     * @var string|mixed
     */
    protected string $url;
    /**
     * @var int|mixed
     */
    protected int $sslVerifyResult;
    /**
     * @var array
     */
    protected array $subject;
    /**
     * @var array
     */
    protected array $issuer;
    /**
     * @var string
     */
    protected string $version;
    /**
     * @var string
     */
    protected string $serialNumber;
    /**
     * @var DateTime
     */
    protected DateTime $startDate;
    /**
     * @var DateTime
     */
    protected DateTime $expireDate;
    /**
     * @var array|mixed
     */
    protected array $allCerts;
    
    /**
     * CertInfo constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (!empty($data['url'])) {
            $this->url = $data['url'];
        }
        
        if (isset($data['ssl_verify_result'])) {
            $this->sslVerifyResult = $data['ssl_verify_result'];
        }
        
        if (!empty($data['certinfo'])) {
            $this->allCerts = $data['certinfo'];
            $mainCert = array_shift($data['certinfo']);
            $this->setCertInfo($mainCert);
        }
        $this->info = $data;
    } // end __construct
    
    /**
     * @param array $mainCert
     * @throws \Exception
     */
    protected function setCertInfo(array $mainCert)
    {
        if (!empty($mainCert['Subject'])) {
            $this->subject = $this->getPreparedStringData($mainCert['Subject']);
        }
        if (!empty($mainCert['Issuer'])) {
            $this->issuer = $this->getPreparedStringData($mainCert['Issuer']);
        }
        
        if (!empty($mainCert['Version'])) {
            $this->version = $mainCert['Version'];
        }
        
        if (!empty($mainCert['Serial Number'])) {
            $this->version = $mainCert['Serial Number'];
        }
        
        if (!empty($mainCert['Start date'])) {
            $this->startDate = new DateTime($mainCert['Start date']);
        }
        
        if (!empty($mainCert['Expire date'])) {
            $this->expireDate = new DateTime($mainCert['Expire date']);
        }
    } // end setCertInfo
    
    /**
     * @param string $title
     * @return array
     */
    protected function getPreparedStringData(string $title): array
    {
        $titleData = [];
        $strData = explode(',', trim($title));
        foreach ($strData as $str) {
            $chunks = explode('=', trim($str));
            $titleData[trim($chunks[0])] = trim($chunks[1]);
        }
        return $titleData;
    } // end getPreparedStringData
    
    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    } // end getUrl
    
    /**
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    } // end getSerialNumber
    
    /**
     * @return int
     */
    public function getSslVerifyResult(): int
    {
        return $this->sslVerifyResult;
    } // end getSslVerifyResult
    
    /**
     * @return bool
     */
    public function isSslVerified(): bool
    {
        return $this->sslVerifyResult === 0;
    } // end isSslVerified
    
    /**
     * @return array
     */
    public function getSubject(): array
    {
        return $this->subject;
    } // end getSubject
    
    /**
     * @return array
     */
    public function getIssuer(): array
    {
        return $this->issuer;
    } // end getIssuer
    
    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    } // end getVersion
    
    /**
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    } // end getStartDate
    
    /**
     * @return DateTime
     */
    public function getExpireDate(): DateTime
    {
        return $this->expireDate;
    } // end getExpireDate
    
    /**
     * @return array
     */
    public function getAllCerts(): array
    {
        return $this->allCerts;
    } // end getAllCerts
    
    /**
     * @return array
     */
    public function toNative(): array
    {
        return [
            'url'               => $this->url,
            'ssl_verify_result' => $this->sslVerifyResult,
            'subject'           => $this->subject,
            'issuer'            => $this->issuer,
            'version'           => $this->version,
            'serial_number'     => $this->serialNumber,
            'start_date'        => $this->startDate,
            'expire_date'       => $this->expireDate,
            'all_certs'         => $this->allCerts
        ];
    } // end toNative
}
