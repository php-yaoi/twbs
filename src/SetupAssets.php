<?php

namespace Yaoi\Twbs;

class SetupAssets
{
    public static function execute()
    {
        echo "Copying bootstrap/dist to public/twbs\n";

        $source = getcwd() . "/vendor/twbs/bootstrap/dist";
        $dest = getcwd() . "/public/twbs";

        if (file_exists($dest)) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dest, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($files as $fileinfo) {
                $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                $todo($fileinfo->getRealPath());
            }

        } else {
            mkdir($dest, 0755, true);
        }

        foreach (
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST) as $item
        ) {
            if ($item->isDir()) {
                $name = $dest . '/' . $iterator->getSubPathName();
                if (!file_exists($name)) {
                    mkdir($name);
                }
            } else {
                copy($item, $dest . '/' . $iterator->getSubPathName());
            }
        }

        $source = __DIR__ . '/../assets';

        foreach (
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST) as $item
        ) {
            /** @var \RecursiveDirectoryIterator $iterator */
            if ($item->isDir() ) {
                $name = $dest . '/' . $iterator->getSubPathName();
                if (!file_exists($name)) {
                    mkdir($name);
                }
            } else {
                copy($item, $dest . '/' . $iterator->getSubPathName());
            }
        }

        echo "OK\n";

    }

}