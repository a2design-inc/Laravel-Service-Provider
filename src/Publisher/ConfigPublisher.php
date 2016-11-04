<?php

namespace BrianFaust\ServiceProvider\Publisher;

use InvalidArgumentException;

class ConfigPublisher extends Publisher
{
    protected function getSource($packagePath)
    {
        $sources = [
            "{$packagePath}/resources/config",
            "{$packagePath}/config",
        ];

        // iterate through all possible locations
        foreach ($sources as $source) {
            if ($this->files->isDirectory($source)) {
                $paths = [];

                // get all files of the current directory
                $files = $this->getSourceFiles($source);

                // iterate through all files
                foreach ($files as $file) {
                    $destinationPath = $this->getDestinationPath('config', [
                        $this->getFileName($file),
                    ]);

                    // if the destination doesn't exist we can add the file to the queue
                    if (!$this->files->exists($destinationPath)) {
                        $paths[$file] = $destinationPath;
                    }
                }

                return $paths;
            }
        }

        throw new InvalidArgumentException('Configuration not found.');
    }
}