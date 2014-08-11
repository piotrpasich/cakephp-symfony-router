<?php

use Symfony\Component\Yaml\Parser;
use \Exception as WrongArgumentException;
App::uses('RouterConfigurationInterface', 'CakephpSymfonyRouter.Lib');

class RouterYmlConfiguration implements RouterConfigurationInterface
{

    /**
     * @var string
     */
    protected $fileName;

    public function __construct($fileName)
    {
        $this->setFileName($fileName);
    }

    public function loadConfiguration()
    {
        $yaml = new Parser();

        return $yaml->parse(file_get_contents($this->fileName));
    }

    protected function setFileName($filename)
    {
        if (!is_string($filename)) {
            throw new WrongArgumentException('Passed argument is not a proper filename');
        }

        $this->fileName = $filename;
    }
}