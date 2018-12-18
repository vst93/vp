<?php
/*
 * This file is part of the Text_Template package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A simple template engine.
 *
 * @since Class available since Release 1.0.0
 */
class Text_Template
{
    /**
     * @var string
     */
    protected $template = '';

    /**
     * @var string
     */
    protected $openDelimiter = '{';

    /**
     * @var string
     */
    protected $closeDelimiter = '}';

    /**
     * @var array
     */
    protected $values = array();

    /**
     * Constructor.
     *
     * @param  string $file
     * @throws InvalidArgumentException
     */
    public function __construct($file = '', $openDelimiter = '{', $closeDelimiter = '}')
    {
        $this->setFile($file);
        $this->openDelimiter = $openDelimiter;
        $this->closeDelimiter = $closeDelimiter;
        $this->template = $this->importTemplate($this->template);
    }

    /**
     * Sets the template file.
     *
     * @param  string $file
     * @throws InvalidArgumentException
     */
    public function setFile($file)
    {
        $distFile = $file . '.dist';

        if (file_exists($file)) {
            $this->template = file_get_contents($file);
        } else if (file_exists($distFile)) {
            $this->template = file_get_contents($distFile);
        } else {
            throw new InvalidArgumentException(
                'Template file could not be loaded.'
            );
        }
    }

    /**
     * Sets one or more template variables.
     *
     * @param array $values
     * @param bool $merge
     */
    public function setVar(array $values, $merge = TRUE)
    {
        if (!$merge || empty($this->values)) {
            $this->values = $values;
        } else {
            $this->values = array_merge($this->values, $values);
        }
    }

    /**
     * Renders the template and returns the result.
     *
     * @return string
     */
    public function render()
    {
        $keys = array();

        foreach ($this->values as $key => $value) {
            $keys[] = $this->openDelimiter . $key . $this->closeDelimiter;
        }

        return str_replace($keys, $this->values, $this->template);
    }

    /**
     * Renders the template and writes the result to a file.
     *
     * @param string $target
     */
    public function renderTo($target)
    {
        $fp = @fopen($target, 'wt');

        if ($fp) {
            fwrite($fp, $this->render());
            fclose($fp);
        } else {
            $error = error_get_last();

            throw new RuntimeException(
                sprintf(
                    'Could not write to %s: %s',
                    $target,
                    substr(
                        $error['message'],
                        strpos($error['message'], ':') + 2
                    )
                )
            );
        }
    }

    /**
     * @param $template_html
     * @return mixed
     */
    public function importTemplate($template_html)
    {
        $preg_str = '/' . $this->openDelimiter . 'import=(.*)' . $this->closeDelimiter . '/';
        preg_match_all($preg_str, $template_html, $template_arr);
        if (!is_array($template_arr[1]) || count($template_arr[1]) <= 0) {
            return $template_html;
        }
        foreach ($template_arr[1] as $key => $value) {
            $file_path = ROOT . 'view/' . $value . '.html';
            if (!file_exists($file_path)) {
                continue;
            }
            $file_html = file_get_contents($file_path);
            if ($file_html) {
                $file_html = $this->importTemplate($file_html);
            } else {
                $file_html = '';
            }
            $template_html = str_replace($template_arr[0][$key], $file_html, $template_html);

        }
        return $template_html;
    }
}

