<?php

namespace Robusta\Util;

use PDO;

/**
 * Class Database
 * @package Robusta\Util
 */
class Database
{
    /**
     * @param PDO    $pdo
     * @param string $file
     * @param string $delimiter
     *
     * @return bool
     */
    public function importSqlDump(PDO $pdo, $file, $delimiter = ';')
    {
        set_time_limit(0);

        if (is_file($file) === true) {
            $file = \fopen($file, 'r');

            if (\is_resource($file) === true) {
                $query = [];

                while (feof($file) === false) {
                    $query[] = fgets($file);

                    if (preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1) {
                        $query = trim(implode('', $query));
                        $pdo->query($query);

                        while (ob_get_level() > 0) {
                            ob_end_flush();
                        }

                        flush();
                    }

                    if (is_string($query) === true) {
                        $query = [];
                    }
                }

                return fclose($file);
            }
        }

        return false;
    }
}
