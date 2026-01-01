<?php

declare(strict_types=1);

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) 2026 Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\UtilBundle\Tests\Service;

use Svc\UtilBundle\Service\MailerHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Mime\Email;

/**
 * testing the MailHelper class.
 */
final class MailerHelperTest extends KernelTestCase
{
    public static function setUpBeforeClass(): void
    {
        self::bootKernel(); // <== if this line is removed, the deprecation is displayed
    }

    /**
     * check if a call to send possible and all options are resolved.
     *
     * use a dry run, not sending real mail
     *
     * @return void
     */
    public function testMailOptions()
    {
        $kernel = self::bootKernel();
        $container = $kernel->getContainer();
        $mail = $container->get('Svc\UtilBundle\Service\MailerHelper');

        $this->assertInstanceOf(MailerHelper::class, $mail);

        $result = $mail->send('dev@example.com', 'Hallo', '<h2>Test</h2>', null, [
            'priority' => Email::PRIORITY_LOW,
            'cc' => 'technik@example.com',
            'bcc' => 'test1@example.com',
            'replyTo' => 'test2@example.com',
            'dryRun' => true,
        ]);
        $this->assertEquals(true, $result);
    }

    /**
     * check call with wrong option (should raise an exception).
     *
     * @return void
     */
    public function testMailWrongOptions()
    {
        $kernel = self::bootKernel();
        $container = $kernel->getContainer();
        $mail = $container->get('Svc\UtilBundle\Service\MailerHelper');

        $this->expectException("Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException");
        $mail->send('dev@example.com', 'Hallo', '<h2>Test</h2>', null, [
            'WRONGpriority' => Email::PRIORITY_LOW,
            'dryRun' => true,
        ]);
    }

    public function testSendMail()
    {
        $kernel = self::bootKernel();
        $container = $kernel->getContainer();
        $mail = $container->get('Svc\UtilBundle\Service\MailerHelper');

        $result = $mail->send('test@example.com', 'Hello', '<h2>Test</h2>', null, [
            'cc' => 'cc@example.com',
            'bcc' => 'bcc@example.com',
            'replyTo' => 'replyTo@example.com',
            'toName' => 'To Username',
            'ccName' => 'Cc Username',
        ]);
        $this->assertEquals(true, $result);
        $this->assertEmailCount(1);

        /** @var Email $email */
        $email = $this->getMailerMessage(0);
        $this->assertEmailHeaderSame($email, 'To', 'To Username <test@example.com>');
        $this->assertEmailHeaderSame($email, 'Cc', 'Cc Username <cc@example.com>');
        $this->assertEmailHeaderSame($email, 'bcc', 'bcc@example.com');
        $this->assertEmailHeaderSame($email, 'from', 'Test User <test@test.com>');
        $this->assertEmailHeaderSame($email, 'reply-to', 'replyTo@example.com');
        $this->assertEmailHeaderSame($email, 'Subject', 'Hello', 'Email subject is incorrect');
        $this->assertStringContainsString('<h2>Test</h2>', $email->getHtmlBody(), 'Email content is incorrect');
    }
}
