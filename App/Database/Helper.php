<?php

declare(strict_types=1);

namespace Idos\Database;

use Idos\Database\Exception\InvalidQueryException;

class Helper
{
    /**
     * Escapes Schema object name to safe use inside SQL query. MySQL variant.
     *
     * Use it for Schema objects (table name, column name, key name, foreign key name, constraint name, etc.)
     * Don't use it for values!
     * @link https://dev.mysql.com/doc/refman/8.0/en/identifiers.html
     */
    public static function escapeMysqlSchemaNames(string $name): string
    {
        // Doubles backticks and wrap whole string to backsticks: 'Hello' => '`Hello`', 'He`llo' => '`He``llo`'
        return sprintf('`%s`', str_replace('`', '``', $name));
    }

    /**
     * Return SQL columns list as string. If empty, placeholder is returned (useful for `SELECT *`)
     * otherwise throw Exception
     */
    public static function columnListToQuery(array $columns, ?string $emptyPlaceholder = null): string
    {
        if (count($columns)) {
            return implode(", ", array_map(self::escapeMysqlSchemaNames(...), $columns));
        }

        if ($emptyPlaceholder === null) {
            throw new InvalidQueryException('Invalid query: Column list must contains at least one value.');
        }

        return $emptyPlaceholder;
    }

    public static function keyValuesToSetString(array $keyValues): string
    {
        $sets = [];

        foreach ($keyValues as $key => $value) {
            $sets[] = sprintf('%s = ?', self::escapeMysqlSchemaNames($key));
        }

        return implode(', ', $sets);
    }

    public static function unpackMultiValues(array $multiValues): array
    {
        return array_merge(...$multiValues);
    }
}
