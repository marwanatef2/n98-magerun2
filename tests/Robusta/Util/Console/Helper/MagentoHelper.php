<?php

namespace Robusta\Util\Console\Helper;

use Robusta\Magento\Command\TestCase;
use org\bovigo\vfs\vfsStream;

class MagentoHelper extends TestCase
{
    /**
     * @return MagentoHelper
     */
    protected function getHelper()
    {
        $inputMock = $this->createMock('Symfony\Component\Console\Input\InputInterface');
        $outputMock = $this->createMock('Symfony\Component\Console\Output\OutputInterface');

        return new MagentoHelper($inputMock, $outputMock);
    }

    /**
     * @test
     */
    public function testHelperInstance()
    {
        $this->assertInstanceOf('\Robusta\Util\Console\Helper\MagentoHelper', $this->getHelper());
    }

    /**
     * @test
     */
    public function detectMagentoInStandardFolder()
    {
        vfsStream::setup('root');
        vfsStream::create(
            [
                'app' => [
                    'Mage.php' => '',
                ],
            ]
        );

        $helper = $this->getHelper();
        $helper->detect(vfsStream::url('root'), []);

        $this->assertEquals(vfsStream::url('root'), $helper->getRootFolder());
        $this->assertEquals(\Robusta\Magento\Application::MAGENTO_MAJOR_VERSION_1, $helper->getMajorVersion());
    }

    /**
     * @test
     */
    public function detectMagentoInHtdocsSubfolder()
    {
        vfsStream::setup('root');
        vfsStream::create(
            [
                'htdocs' => [
                    'app' => [
                        'Mage.php' => '',
                    ],
                ],
            ]
        );

        $helper = $this->getHelper();

        // vfs cannot resolve relative path so we do 'root/htdocs' etc.
        $helper->detect(
            vfsStream::url('root'),
            [
                vfsStream::url('root/www'),
                vfsStream::url('root/public'),
                vfsStream::url('root/htdocs'),
            ]
        );

        $this->assertEquals(vfsStream::url('root/htdocs'), $helper->getRootFolder());
        $this->assertEquals(\Robusta\Magento\Application::MAGENTO_MAJOR_VERSION_1, $helper->getMajorVersion());
    }

    /**
     * @test
     */
    public function detectMagentoFailed()
    {
        vfsStream::setup('root');
        vfsStream::create(
            [
                'htdocs' => [],
            ]
        );

        $helper = $this->getHelper();

        // vfs cannot resolve relative path so we do 'root/htdocs' etc.
        $helper->detect(
            vfsStream::url('root')
        );

        $this->assertNull($helper->getRootFolder());
    }

    /**
     * @test
     */
    public function detectMagentoInModmanInfrastructure()
    {
        vfsStream::setup('root');
        vfsStream::create(
            [
                '.basedir' => 'root/htdocs/magento_root',
                'htdocs'   => [
                    'magento_root' => [
                        'app' => [
                            'Mage.php' => '',
                        ],
                    ],
                ],
            ]
        );

        $helper = $this->getHelper();

        // vfs cannot resolve relative path so we do 'root/htdocs' etc.
        $helper->detect(
            vfsStream::url('root')
        );

        // Verify if this could be checked with more elegance
        $this->assertEquals(vfsStream::url('root/../root/htdocs/magento_root'), $helper->getRootFolder());

        $this->assertEquals(\Robusta\Magento\Application::MAGENTO_MAJOR_VERSION_1, $helper->getMajorVersion());
    }

    /**
     * @test
     */
    public function detectMagento2InHtdocsSubfolder()
    {
        vfsStream::setup('root');
        vfsStream::create(
            [
                'htdocs' => [
                    'app' => [
                        'autoload.php'  => '',
                        'bootstrap.php' => '',
                    ],
                ],
            ]
        );

        $helper = $this->getHelper();

        // vfs cannot resolve relative path so we do 'root/htdocs' etc.
        $helper->detect(
            vfsStream::url('root'),
            [
                vfsStream::url('root/www'),
                vfsStream::url('root/public'),
                vfsStream::url('root/htdocs'),
            ]
        );

        $this->assertEquals(vfsStream::url('root/htdocs'), $helper->getRootFolder());
        $this->assertEquals(\Robusta\Magento\Application::MAGENTO_MAJOR_VERSION_2, $helper->getMajorVersion());
    }
}
