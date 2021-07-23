<?php
namespace Jtrw\SslCertificate\Tests;

use Jtrw\SslCertificate\SslCertificateInfo;
use Jtrw\SslCertificate\ValuesObject\CertInfo;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SslCertificateCheckerCheckTest extends TestCase
{
    private string $urlHttps = "https://test.com";
    private string $urlHttp = "http://test.com";
    
    private MockObject $mockChecker;
    
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->mockChecker = $this->getMockBuilder(SslCertificateInfo::class)
            ->onlyMethods(['getTransport'])->getMock();
        
        parent::__construct($name, $data, $dataName);
    } // end __construct
    
    public function testCheck(): void
    {
        $checkerObject = $this->getCloneMockObject();
        
        $returnDataExpire = new TestTransport(
            [
                'ssl_verify_result' => 1,
                'certinfo' => [
                    [
                        'Expire date' => date("Y-m-d", strtotime("-1 year"))
                    ]
        
                ]
            ]
        );
    
        $returnData = new TestTransport(
            [
                'ssl_verify_result' => 0,
                'certinfo' => [
                    [
                        'Expire date' => date("Y-m-d")
                    ]
            
                ]
            ]
        );
        
        $checkerObject->method('getTransport')->will(
            $this->onConsecutiveCalls(
                $returnDataExpire,
                $returnData,
                $returnData
            )
        );
        
        $sites = [
            "http://test1.com" => ['expire_date' => date("Y-m-d", strtotime("-1 month"))],
            "http://test2.com",
            "http://test3.com"
        ];
        $checkInfo = $checkerObject->check($sites);

        $this->assertIsArray($checkInfo);
        
        foreach ($checkInfo as $siteData) {
            $this->assertArrayHasKey('host', $siteData);
            $this->assertArrayHasKey('is_verified', $siteData);
            $this->assertArrayHasKey('expire_date', $siteData);
        }
        
        $firstSiteData = array_shift($checkInfo);
        $this->assertFalse($firstSiteData['is_verified']);
    } // end testGetInfoWithHttpsUrl
    
    private function getCloneMockObject(): MockObject
    {
        return clone $this->mockChecker;
    } // end getCloneMockObject
}
