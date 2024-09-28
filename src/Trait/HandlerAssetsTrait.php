<?php

namespace ModernPHPException\Trait;

use AssetException;

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
     * @return string
     */
    private function loadAssets(array $info): string
    {
        if (!is_bool($this->config['enable_cdn_assets']))
            throw new AssetException("`true` or `false` must be the options in the variable `enable_cdn_assets`");

        $asset = $this->loadCss($info);
        $asset .= $this->loadJs();
        return $asset;
    }

    /**
     * @return string
     */
    private function loadJs(): string
    {
        if ($this->config['enable_cdn_assets'] == false) {
            $asset = '<script>' . file_get_contents('assets/js/highlight.min.js', FILE_USE_INCLUDE_PATH);
            $asset .= file_get_contents('assets/js/highlightjs-line-numbers.js', FILE_USE_INCLUDE_PATH) . '</script>';
            $asset .= '<script>hljs.highlightAll(); hljs.initLineNumbersOnLoad();</script>';
            $asset .= '<script>' . file_get_contents('assets/js/bootstrap.bundle.min.js', FILE_USE_INCLUDE_PATH) . '</script>';
            $asset .= '<script>' . file_get_contents('assets/js/less.js', FILE_USE_INCLUDE_PATH) . '</script>';
        } elseif ($this->config['enable_cdn_assets'] == true) {
            $asset = '<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/highlight.min.js"></script>';
            $asset .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/highlightjs-line-numbers.js/2.8.0/highlightjs-line-numbers.min.js"></script>';
            $asset .= '<script>hljs.highlightAll();hljs.initLineNumbersOnLoad();</script>';
            $asset .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>';
            $asset .= '<script src="https://cdn.jsdelivr.net/npm/less@4"></script>';
        }

        return $asset;
    }

    /**
     * @param array $info
     * 
     * @return string
     */
    private function loadCss(array $info): string
    {
        if ($this->theme == "dark") $this->color_alert = "C60000";

        if ($this->config['enable_cdn_assets'] == false) {
            $asset = "<style>\n";
            $asset .= file_get_contents('assets/styles/bootstrap.min.css', FILE_USE_INCLUDE_PATH);
            $asset .= "</style>";
        } elseif ($this->config['enable_cdn_assets'] == true) {
            $asset = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">';
        }

        $asset .= "\n<style type='text/less'>\n";
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
