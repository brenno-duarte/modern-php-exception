<?php

namespace ModernPHPException\Trait;

trait HandlerAssetsTrait
{
    /**
     * @var string
     */
    private string $theme_code = "code-2";

    /**
     * @var string
     */
    private string $theme = "light";

    /**
     * @var string
     */
    private string $color_alert = "ffbbbb";

    /**
     * @return self
     */
    public function useDarkTheme(): self
    {
        $this->theme = "dark";

        return $this;
    }

    /**
     * @param array $line
     * 
     * @return self
     */
    private function loadAssets(array $info)
    {
        $asset = $this->loadCss($info);
        $asset .= $this->loadJs();

        return $asset;
    }

    /**
     * @return self
     */
    private function loadJs()
    {
        $asset = '<script>' . file_get_contents('assets/js/highlight.pack.js', FILE_USE_INCLUDE_PATH);
        $asset .= file_get_contents('assets/js/highlightjs-line-numbers.js', FILE_USE_INCLUDE_PATH) . '</script>';
        $asset .= '<script>hljs.highlightAll(); hljs.initLineNumbersOnLoad();</script>';
        $asset .= '<script>' . file_get_contents('assets/js/bootstrap.bundle.min.js', FILE_USE_INCLUDE_PATH) . '</script>';

        return $asset;
    }

    /**
     * @param array $info
     * 
     * @return self
     */
    private function loadCss(array $info)
    {
        if ($this->theme == "dark") {
            $this->color_alert = "C60000";
        }

        $asset = "<style> \n\n";
        $asset .= file_get_contents('assets/styles/bootstrap.min.css', FILE_USE_INCLUDE_PATH);
        $asset .= "</style> \n\n";

        $asset .= "<style type='text/less'> \n\n";
        $asset .= file_get_contents('assets/styles/style.less', FILE_USE_INCLUDE_PATH);
        $asset .= file_get_contents('assets/styles/code.less', FILE_USE_INCLUDE_PATH);

        if ($this->theme == "dark") {
            $asset .= file_get_contents('assets/styles/colors-dark.less', FILE_USE_INCLUDE_PATH);
        } elseif ($this->theme == "light") {
            $asset .= file_get_contents('assets/styles/colors-light.less', FILE_USE_INCLUDE_PATH);
        }

        $asset .= "\n\n #" . strtolower(pathinfo($info['file'])['filename'] . ' .hljs-ln-line[data-line-number="' . $info['line'] . '"] { background-color: #' . $this->color_alert . ' !important; font-weight: bold !important; }' . "\n\n");

        if (!empty($this->trace)) {
            foreach ($this->trace as $trace) {
                $asset .= "\n\n #" . strtolower(pathinfo($trace['file'])['filename'] . ' .hljs-ln-line[data-line-number="' . $trace['line'] . '"] { background-color: #' . $this->color_alert . ' !important; font-weight: bold !important; }' . "\n\n");
            }
        }

        $asset .= '</style>';

        return $asset;
    }
}
