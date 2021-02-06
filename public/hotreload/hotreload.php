<?php

class HotReload
{
    public function get($dir)
    {
        $it =  new RecursiveDirectoryIterator($dir);
        $ri = new RecursiveIteratorIterator($it);
        $list =  iterator_to_array($ri);

        $list = array_filter($list, function ($e) {
            return $e->isFile() &&
                (
                    (strpos($e->getPathName(), "vendor") === false) &&
                    (strpos($e->getPathName(), ".git") === false) &&
                    (strpos($e->getPathName(), ".exe") === false));
        });

        $list = array_map(function ($e) {
            return $e->getMTime();
        }, $list);

        return md5(implode(",", $list));
    }

    public function sendMessage($data)
    {
        $data = json_encode($data);
        echo "data: $data \n\n";
        @ob_flush();
        flush();
    }

    public function sendHeaders()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
    }

    public function run($dir = __DIR__)
    {
        $this->sendHeaders();
        $lastHash = null;
        while (true) {
            sleep(1);
            clearstatcache();
            $result = $this->get($dir);
            if ($result !== $lastHash) {
                $lastHash = $result;
                $this->sendMessage(["hash" => $result]);
            }
            if (connection_aborted()) {
                break;
            }
        }
    }
}

$path = dirname(dirname(__DIR__));

(new HotReload())->run($path);
