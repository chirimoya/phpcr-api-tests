<?php
require_once(dirname(__FILE__) . '/../../inc/baseCase.php');

class Connecting_4_RepositoryTest extends phpcr_suite_baseCase
{
    //don't care about fixtures

    // 4.1 Repository
    public function testRepository()
    {
        $rep = getRepository($this->sharedFixture['config']);
        $this->assertInstanceOf('PHPCR\RepositoryInterface', $rep);
    }

    public function testLoginSession()
    {
        $ses = $this->assertSession($this->sharedFixture['config']);
        $this->assertEquals($this->sharedFixture['config']['workspace'], $ses->getWorkspace()->getName());
    }

    public function testDefaultWorkspace()
    {
        $cfg = $this->sharedFixture['config'];
        unset($cfg['workspace']);
        $ses = $this->assertSession($cfg);
        //This will produce a false-positive if your configured workspace is the default one
        $this->assertNotEquals($this->sharedFixture['config']['workspace'], $ses->getWorkspace()->getName());
    }

    /** external authentication */
    public function testNoLogin()
    {
        $cfg = $this->sharedFixture['config'];
        unset($cfg['user']);
        unset($cfg['pass']);
        $ses = $this->assertSession($cfg);
        $this->assertEquals($this->sharedFixture['config']['workspace'], $ses->getWorkspace()->getName());
    }

    public function testNoLoginAndWorkspace()
    {
        $cfg = $this->sharedFixture['config'];
        unset($cfg['user']);
        unset($cfg['pass']);
        unset($cfg['workspace']);
        $ses = $this->assertSession($cfg);
        $this->assertNotEquals($this->sharedFixture['config']['workspace'], $ses->getWorkspace()->getName());
    }

    /**
     * @expectedException \PHPCR\LoginException
     */
    public function testLoginException()
    {
        $this->markTestSkipped('TODO: Figure how to make a login fail');
        $cfg = $this->sharedFixture['config'];
        $cfg['user'] = 'foo';
        $cfg['pass'] = 'bar';
        $ses = $this->assertSession($cfg);
    }

    /**
     * @expectedException PHPCR\NoSuchWorkspaceException
     */
    public function testLoginNoSuchWorkspace()
    {
        $cfg = $this->sharedFixture['config'];
        $cfg['workspace'] = 'foobar';
        $ses = $this->assertSession($cfg);
    }

    /**
     * @expectedException \PHPCR\RepositoryException
     */
    public function testLoginRepositoryException()
    {
        $cfg = $this->sharedFixture['config'];
        $cfg['workspace'] = '//';
        $ses = $this->assertSession($cfg);
    }
}
