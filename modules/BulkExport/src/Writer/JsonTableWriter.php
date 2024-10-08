<?php declare(strict_types=1);

namespace BulkExport\Writer;

use BulkExport\Form\Writer\JsonTableWriterConfigForm;
use Log\Stdlib\PsrMessage;

class JsonTableWriter extends AbstractFieldsWriter
{
    protected $label = 'Json Table'; // @translate
    protected $extension = 'json';
    protected $mediaType = 'application/json';
    protected $configFormClass = JsonTableWriterConfigForm::class;
    protected $paramsFormClass = JsonTableWriterConfigForm::class;

    protected $defaultOptions = [
        'flags' => JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_LINE_TERMINATORS | JSON_PARTIAL_OUTPUT_ON_ERROR,
    ];

    protected $handle;
    protected $isSingle = false;

    public function process(): WriterInterface
    {
        $this->options += $this->defaultOptions;
        return parent::process();
    }

    protected function initializeOutput(): WriterInterface
    {
        parent::initializeOutput();

        $this->handle = fopen($this->filepath, 'w+');
        if (!$this->handle) {
            $this->hasError = true;
            $this->logger->err(new PsrMessage(
                'Unable to open output: {error}.', // @translate
                ['error' => error_get_last()['message']]
                ));
        }

        if (!$this->hasError && !$this->isSingle) {
            fwrite($this->handle, "[\n");
        }
        return $this;
    }

    protected function finalizeOutput(): WriterInterface
    {
        if ($this->hasError || $this->isSingle) {
            return parent::finalizeOutput();
        }

        // Get the two last characters, that may be "," and "\n", that should be
        // removed in json. This is simpler than checking last element, because
        // it may be skipped on an error. There is no another pointer.

        $pos = ftell($this->handle);
        if ($pos === false) {
            $this->hasError = true;
            $this->logger->err(new PsrMessage(
                'Unable to check output: {error}.', // @translate
                ['error' => error_get_last()['message']]
            ));
            return parent::finalizeOutput();
        }

        if ($pos === 0) {
            return parent::finalizeOutput();
        }

        // When file length = 1, nothing was written, except "[".
        if ($pos === 1) {
            fwrite($this->handle, ']');
            return parent::finalizeOutput();
        }

        // fseek returns -1 in case of error.
        if (fseek($this->handle, -2, SEEK_END)) {
            return parent::finalizeOutput();
        }

        $lastTwo = fgets($this->handle);
        // Normally not possible.
        if ($lastTwo === false) {
            return parent::finalizeOutput();
        }

        if ($lastTwo === ",\n") {
            fseek($this->handle, -2, SEEK_END);
        } elseif (mb_substr($lastTwo, 1) === ',') {
            fseek($this->handle, -1, SEEK_END);
        }
        fwrite($this->handle, "\n]");

        return parent::finalizeOutput();
    }

    protected function writeFields(array $fields)
    {
        // Just return a single value for single valued key, else an array,
        // mainly for property.
        foreach ($fields as $key=> &$value) {
            if ($this->isSingleField($key)) {
                $value = reset($value);
            }
        }
        unset($value);

        fwrite($this->handle, json_encode($fields, $this->options['flags']) . ",\n");

        return $this;
    }
}
