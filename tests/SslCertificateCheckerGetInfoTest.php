<?php
namespace Jtrw\SslCertificate\Tests;

use PHPUnit\Framework\TestCase;
use Jtrw\SslCertificate\SslCertificateInfo;
use Jtrw\SslCertificate\ValuesObject\CertInfo;
use PHPUnit\Framework\MockObject\MockObject;

class SslCertificateCheckerGetInfoTest extends TestCase
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
    
    public function testGetInfoWithHttpsUrl(): void
    {
        $checkerObject = $this->getCloneMockObject();
    
        $checkerObject->method('getTransport')->will(
            $this->returnValue(new TestTransport())
        );
        
        $certInfo = $checkerObject->getInfo($this->urlHttps);
        
        $this->assertInstanceOf(CertInfo::class, $certInfo);
        
        $this->assertEquals($this->urlHttps, $certInfo->getUrl());
    } // end testGetInfoWithHttpsUrl
    
    public function testGetInfoWithHttpUrl(): void
    {
        $checkerObject = $this->getCloneMockObject();
    
        $checkerObject->method('getTransport')->will(
            $this->returnValue(new TestTransport())
        );
        
        $certInfo = $checkerObject->getInfo($this->urlHttp);
        
        $this->assertInstanceOf(CertInfo::class, $certInfo);
        
        $this->assertNotEquals($this->urlHttp, $certInfo->getUrl());
        
        $resultPos = strpos($certInfo->getUrl(), "https");
        
        $this->assertEquals(0, $resultPos);
    } // end testGetInfoWithHttpUrl
    
    public function testIsNotSslVerified(): void
    {
        $checkerObject = $this->getCloneMockObject();
    
        $checkerObject->method('getTransport')->will(
            $this->returnValue(new TestTransport(['ssl_verify_result' => 1]))
        );
    
        $certInfo = $checkerObject->getInfo($this->urlHttp);
    
        $this->assertFalse($certInfo->isSslVerified());
    } // end testIsNotSslVerified
    
    public function testIsSslVerified(): void
    {
        $checkerObject = $this->getCloneMockObject();
        
        $checkerObject->method('getTransport')->will(
            $this->returnValue(new TestTransport(['ssl_verify_result' => 0]))
        );
        
        $certInfo = $checkerObject->getInfo($this->urlHttp);
        
        $this->assertTrue($certInfo->isSslVerified());
    } // end testIsSslVerified
    
    private function getCloneMockObject(): MockObject
    {
        return clone $this->mockChecker;
    } // end getCloneMockObject
}
