<?php declare(strict_types=1);

namespace ADR\Filesystem;

use RuntimeException;
use Symfony\Component\Yaml\Yaml;

/**
 * Represents the configuration of this project.
 *
 * @author Alexander Bachmann <a.t.bachmann@gmail.com>
 */
class Config
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param string $file
     *
     * @throws RuntimeException
     */
    public function __construct(string $file)
    {
        $this->parseFile($file);
    }

    /**
     * Returns the ADR workspace directory
     *
     * @return string
     */
    public function directory(): string
    {
        return $this->data['directory'];
    }

    /**
     * Returns the path to the decision record template
     *
     * @return string
     */
    public function decisionRecordTemplateFile(): string
    {
        return $this->data['template']['decision-record'];
    }

    /**
     * @param string $file
     *
     * @throws RuntimeException If the file can not be processed
     */
    private function parseFile(string $file): void
    {
        if (! file_exists($file)) {
            throw new RuntimeException("The config file does not exist: $file");
        }

        if (! is_readable($file)) {
            throw new RuntimeException("The config file isn't readable: $file");
        }

        $this->data = Yaml::parseFile($file);
    }
}
