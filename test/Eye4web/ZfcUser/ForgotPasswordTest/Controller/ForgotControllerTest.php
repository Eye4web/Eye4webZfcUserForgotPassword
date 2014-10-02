<?php

namespace Eye4web\ZfcUser\ForgotPasswordTest\Controller;

use Eye4web\ZfcUser\ForgotPassword\Controller\ForgotController;
use PHPUnit_Framework_TestCase;

class BoardControllerTest extends PHPUnit_Framework_TestCase
{
    /** @var ForgotController */
    protected $controller;

    /** @var \Zend\Mvc\Controller\PluginManager */
    protected $pluginManager;

    public $pluginManagerPlugins = [];

    public function setUp()
    {
        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm $requestForm */
        $requestForm = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\RequestForm');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm $changePasswordForm */
        $changePasswordForm = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Form\Forgot\ChangePasswordForm');

        /** @var \Eye4web\ZfcUser\ForgotPassword\Service\ForgotService $forgotService */
        $forgotService = $this->getMock('Eye4web\ZfcUser\ForgotPassword\Service\ForgotService');

        /** @var \Zend\Mvc\Controller\PluginManager $pluginManager */
        $pluginManager = $this->getMock('Zend\Mvc\Controller\PluginManager', array('get'));

        $pluginManager->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(array($this, 'helperMockCallbackPluginManagerGet')));

        $this->pluginManager = $pluginManager;

        $controller = new ForgotController($requestForm, $changePasswordForm, $forgotService);

        $this->controller = $controller;
    }

    public function testIndexNoRequest()
    {
        $redirectUrl = 'test-url';

        $url = $this->getMock('Zend\Mvc\Controller\Plugin\Url', ['fromRoute']);

        $url->expects($this->once())
            ->method('fromRoute')
            ->with('e4w/zfc-user-forgot-password')
            ->willReturn($redirectUrl);

        $this->pluginManagerPlugins['url'] = $url;

        $prg = $this->getMock('Zend\Mvc\Controller\Plugin\PostRedirectGet', ['__invoke']);

        $prg->expects($this->once())
            ->method('__invoke')
            ->with($redirectUrl, true)
            ->willReturn(null);

        $this->pluginManagerPlugins['prg'] = $prg;

        $result = $this->controller->indexAction();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }
}
