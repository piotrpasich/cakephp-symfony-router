<?php

use Symfony\Component\Yaml\Parser;

App::uses('RouterConfigurationInterface', 'CakephpSymfonyRouter.Lib');

class RouterYmlConfiguration implements RouterConfigurationInterface
{

    public function loadConfiguration($fileName)
    {
        $yaml = new Parser();

        return $yaml->parse(file_get_contents($fileName));
    }
}