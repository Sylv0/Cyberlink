<?php

/*
 * This file is part of Yrgo.
 *
 * (c) Yrgo, högre yrkesutbildning.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect($path)
    {
        header("Location: ${path}");
        exit;
    }
}

/**
 * Give an SQL-statement with paramaters and get the result.
 *
 * @param string $sql
 * @param array  $params
 * @param bool   $fetchAll
 *
 * @return void
 */
function SelectFromBD(PDO $pdo, string $sql, array $params, bool $fetchAll)
{
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    if ($fetchAll) {
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
