<?php

namespace Dainsys\LivewireGenerator\Creators;

use Dainsys\LivewireGenerator\Generators\Generator;
use Illuminate\Support\Facades\File;

abstract class BaseFileCreator implements FileCreatorContract
{
    protected $generator;

    protected $destination_file_name;

    protected string $main_destination_folder;

    protected string $content;

    protected bool $warn_file_exists = true;

    public array $warns = [];
    public array $infos = [];

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;

        $this->content = $this->parseContent(File::get($this->generator->stubsPath . $this->stub_path));

        $this->file_model_name = $this->getFileModelName();

        $this->main_destination_folder = $this->getMainDestinationFolder();

        $this->destination_file_name = $this->getDestinationFileLocation();
    }

    public function createFile()
    {
        if (File::exists($this->destination_file_name)) {
            if (!$this->generator->getForce()) {
                if ($this->warn_file_exists) {
                    $this->warns[] = "File {$this->destination_file_name} exists. Pass the --force flag to override. File Not created!";
                }
                return $this; // Do nothing
            }
        }
        if (File::isDirectory($this->main_destination_folder) == false) {
            File::makeDirectory($this->main_destination_folder, 0755, true);
        }

        File::put($this->destination_file_name, $this->content);

        if ($this->warn_file_exists) {
            $this->infos[] = "Created file {$this->destination_file_name}";
        }

        return $this;
    }

    abstract protected function getMainDestinationFolder();

    abstract protected function getFileModelName();

    protected function parseContent($content)
    {
        $content = str_replace('[model]', $this->generator->getModelName(), $content);
        $content = str_replace('[models-path]', $this->generator->getModelsDir(), $content);
        $content = str_replace('[model-plural]', $this->generator->getModelNameAsplural(), $content);
        $content = str_replace('[model-snake]', $this->generator->getModelNameAsSnake(), $content);
        $content = str_replace('[model-snake-plural]', $this->generator->getModelNameAsPluralSnake(), $content);

        return $content;
    }

    protected function getDestinationFileLocation()
    {
        return join("/", [
            $this->getMainDestinationFolder(),
            $this->file_model_name  . $this->file_name_sufix,
        ]);
    }
}
