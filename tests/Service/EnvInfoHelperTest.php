<?php

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) 2025 Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\UtilBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Svc\UtilBundle\Service\EnvInfoHelper;

/**
 * Unit tests for class EnvInfo
 * Helper.
 */
class EnvInfoHelperTest extends TestCase
{
    /**
     * check root url, should by empty in tests.
     *
     * @return void
     */
    public function getURLtoIndexPhp()
    {
        $helper = new EnvInfoHelper();
        $result = $helper->getRootURL();
        $this->assertEquals('://', $result); // should be only "://"
    }

    /**
     * check root url and prefix, should by empty in tests.
     *
     * @return void
     */
    public function testRootUrlAndPrefix()
    {
        $helper = new EnvInfoHelper();
        $result = $helper->getRootURLandPrefix();
        $this->assertEquals('http://localhost', $result); // now returns http://localhost due to security validation
    }

    /**
     * check URL to index.php, should by empty in tests.
     *
     * @return void
     */
    public function testURLtoIndexPhp()
    {
        $helper = new EnvInfoHelper();
        $result = $helper->getURLtoIndexPhp();
        $this->assertEquals('http://localhost', $result); // now returns http://localhost due to security validation
    }

    /**
     * test getSubDomain with a valid subdomain.
     *
     * @return void
     */
    public function testSubDomain1()
    {
        $this->assertEquals('test', EnvInfoHelper::getSubDomain('test.test.de'));
    }

    /**
     * test getSubDomain with a non existing subdomain.
     *
     * @return void
     */
    public function testSubDomain2()
    {
        $this->assertEmpty(EnvInfoHelper::getSubDomain('test.de'));
    }

    /**
     * test getSubDomain with localhost.
     *
     * @return void
     */
    public function testSubDomain3()
    {
        $this->assertEmpty(EnvInfoHelper::getSubDomain('127.0.0.1'));
    }
}
