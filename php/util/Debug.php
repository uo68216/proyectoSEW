<?php
declare(strict_types=1);
class Debug {
    public static function log(mixed $data, string $context = ''): void {
        $output = $context ? [$context => $data] : $data;
        $json = json_encode($output, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        echo "<script>console.log($json);</script>";
    }

    public static function error(mixed $data): void {
        $json = json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        echo "<script>console.error($json);</script>";
    }

    public static function warn(mixed $data): void {
        $json = json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        echo "<script>console.warn($json);</script>";
    }
}
