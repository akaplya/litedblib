<?php

require_once "bootstrap.php";

use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\MethodGenerator;

echo "<pre>";

$identifierMap = [
    'catalog_product_entity' => 'sku'
];

$dml = new Sql\Dml();

$tables = $dml->select()
    ->from(['t' => 'information_schema.tables'])
    ->columns(['table_name'])
    ->where($dml->exprComparison('t.table_schema')->equal('magetwo_firedrakes'));

$tableResult = $connection->query($tables);
foreach ($tableResult as $table) {
    $properties = [];
    $methods = [];
    $parts = explode('_', $table['table_name']);
    $className = ucfirst(end($parts));
    unset($parts[count($parts) - 1]);
    $namespace = str_replace(' ', '\\', ucwords(implode(' ', $parts)));

    $docblock = new DocBlockGenerator(
        'Sample generated class',
        'This is a class generated with Zend\Code\Generator.',
        [
            [
                'name'        => 'version',
                'description' => '$Rev:$',
            ],
            [
                'name'        => 'license',
                'description' => 'New BSD',
            ],
        ]
    );

    $columns = $dml->select()
        ->from(['c' => 'information_schema.columns'])
        ->columns(
            [
                'column_name',
                'data_type',
                'is_nullable',
                'column_key',
                'extra',
                'column_default'
            ]
        )
        ->where($dml->clauseAnd([
                $dml->exprComparison('c.table_schema')->equal('magetwo_firedrakes'),
                $dml->exprComparison('c.table_name')->equal($table['table_name']),
            ])
        );
    $columnResult = $connection->query($columns);
    foreach ($columnResult as $column) {
        $autoIncrement = null;
        $propertyName = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $column['column_name']))));

            switch ($column['data_type']) {
                case 'int':
                case 'smallint':
                case 'bigint':
                    $propertyDataType = 'int';
                    break;
                case 'varchar':
                case 'char':
                case 'text':
                case 'mediumtext':
                    $propertyDataType = 'string';
                    break;
                case 'datetime':
                case 'timestamp':
                    $propertyDataType = 'date';
                    break;
                default:
                    $propertyDataType = '';
                    break;
            }

        $properties[] = new PropertyGenerator(
            $propertyName,
            $column['column_default'],
            PropertyGenerator::FLAG_PROTECTED
        );

        $setMethodName = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $column['column_name'])));
        $getMethodName = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $column['column_name'])));
        $methods[] = new MethodGenerator(
            $setMethodName,
            [$propertyName],
            MethodGenerator::FLAG_PUBLIC,
            "    \$this->{$propertyName} = \${$propertyName};     \n"
                . "return \$this;                                ",
            new DocBlockGenerator(
                'Set property ' . $propertyName,
                null,
                [
                    [
                        'name'        => 'param',
                        'description' => "{$propertyDataType} \${$propertyName}",
                    ],
                    [
                        'name'        => 'return',
                        'description' => "\$this"
                    ],
                ]
            )
        );
        $methods[] = new MethodGenerator(
            $getMethodName,
            [],
            MethodGenerator::FLAG_PUBLIC,
            "    return \$this->{$propertyName};\n",
            new DocBlockGenerator(
                'Returns property ' . $propertyName,
                null,
                [
                    [
                        'name'        => 'return',
                        'description' => $propertyDataType
                    ]
                ]
            )
        );
        if (strtoupper($column['extra']) == 'AUTO_INCREMENT') {
            $methods[] = new MethodGenerator(
                'setIdentity',
                ['identity'],
                MethodGenerator::FLAG_PUBLIC,
                "    \$this->{$setMethodName}(\$identity);     \n"
                . "return \$this;                                ",
                new DocBlockGenerator(
                    'Set identity',
                    null,
                    [
                        [
                            'name'        => 'param',
                            'description' => "{$propertyDataType} \$identity",
                        ],
                        [
                            'name'        => 'return',
                            'description' => "\$this"
                        ],
                    ]
                )
            );
            $methods[] = new MethodGenerator(
                'getIdentity',
                [],
                MethodGenerator::FLAG_PUBLIC,
                "    \$this->{$getMethodName}();",
                new DocBlockGenerator(
                    'Returns identity',
                    null,
                    [
                        [
                            'name'        => 'return',
                            'description' => $propertyDataType
                        ],
                    ]
                )
            );

            if (empty($identifierMap[$table['table_name']])) {
                $methods[] = new MethodGenerator(
                    'setIdentifier',
                    ['identifier'],
                    MethodGenerator::FLAG_PUBLIC,
                    "    \$this->{$setMethodName}(\$identifier);\n"
                    . "return \$this;",
                    new DocBlockGenerator(
                        'Set identity',
                        null,
                        [
                            [
                                'name'        => 'param',
                                'description' => "{$propertyDataType} \$identifier",
                            ],
                            [
                                'name'        => 'return',
                                'description' => "\$this"
                            ],
                        ]
                    )
                );
                $methods[] = new MethodGenerator(
                    'getIdentifier',
                    [],
                    MethodGenerator::FLAG_PUBLIC,
                    "    \$this->{$getMethodName}();",
                    new DocBlockGenerator(
                        'Returns identifier',
                        null,
                        [
                            [
                                'name'        => 'return',
                                'description' => $propertyDataType
                            ],
                        ]
                    )
                );
            }
        }

        if (!empty($identifierMap[$table['table_name']])
            && $column['column_name'] == $identifierMap[$table['table_name']]
        ) {
            $methods[] = new MethodGenerator(
                'setIdentifier',
                ['identifier'],
                MethodGenerator::FLAG_PUBLIC,
                "    \$this->{$setMethodName}(\$identifier);\n"
                . "return \$this;",
                new DocBlockGenerator(
                    'Set identifier',
                    null,
                    [
                        [
                            'name'        => 'param',
                            'description' => "{$propertyDataType} \$identifier",
                        ],
                        [
                            'name'        => 'return',
                            'description' => "\$this"
                        ],
                    ]
                )
            );
            $methods[] = new MethodGenerator(
                'getIdentifier',
                [],
                MethodGenerator::FLAG_PUBLIC,
                "    \$this->{$getMethodName}();",
                new DocBlockGenerator(
                    'Returns identifier',
                    null,
                    [
                        [
                            'name'        => 'return',
                            'description' => $propertyDataType
                        ],
                    ]
                )
            );
        }
    }

    $methods[] = new MethodGenerator(
        'setIdentifier',
        ['identifier'],
        MethodGenerator::FLAG_PUBLIC,
        "    \$this->{$setMethodName}(\$identifier);\n"
        . "return \$this;",
        new DocBlockGenerator(
            'Set identifier',
            null,
            [
                [
                    'name'        => 'return',
                    'description' => "array"
                ],
            ]
        )
    );

//  str_replace(' ', '', ucwords(str_replace('_', ' ', $table['table_name']))),
    $class = new ClassGenerator(
        $className,
        'Demo\\' . $namespace,
        null,
        null,
        ['ObjectInterface'],
        $properties,
        $methods,
        $docblock
    );
    $class->addUse('Entity\ObjectInterface');
//    echo $class->generate();
    $root = realpath(__DIR__);
    $path = $root . DIRECTORY_SEPARATOR
        . 'src' . DIRECTORY_SEPARATOR
        . 'Demo' . DIRECTORY_SEPARATOR
        . str_replace('\\', DIRECTORY_SEPARATOR, $namespace)
        . DIRECTORY_SEPARATOR;

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    file_put_contents($path . $className . '.php', "<?php \n" . $class->generate());
    echo 'created ' . $path . $className . 'php';
    echo "<br />";

}
